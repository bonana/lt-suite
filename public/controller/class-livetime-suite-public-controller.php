<?php

/**
 * Class to handle all our routes for the public facing functionallity.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Public/Controller
 */

namespace Livetime;

class Livetime_Suite_Public_Controller
{
    /**
     * Envato Client.
     *
     * @since       1.0.0
     * @access      private
     * @var         object      $envato     Envato Client
     */
    private $envato;

    /**
     * BankID Client.
     *
     * @since       1.0.0
     * @access      private
     * @var         object      $bankid     BankID Client
     */
    private $bankid;

    /**
     * The Invoice Handler.
     *
     * @since       1.0.0
     * @access      private
     * @var         object      $invoice    Invoice Handler.
     */
    private $invoice;

    /**
     * The Email Handler.
     *
     * @since       1.0.0
     * @access      private
     * @var         object      $email      Email Handler.
     */
    
    private $contract;

    /**
     * Initialize our class.
     *
     * @since       1.0.0
     * @param       object      $envato     Envato Client
     * @param       object      $bankid     BankID Client
     * @param       object      $invoice    Invoice Handler
     * @param       object      $email      Email Handler.
     */
    public function __construct( $envato, $bankid, $invoice, $email, $contract )
    {
        $this->envato = $envato;
        $this->bankid = $bankid;
        $this->invoice = $invoice;
        $this->email = $email;
        $this->contract = $contract;
    }

    /**
     * Get suggested products for an envato product.
     *
     * @since       1.0.0
     * @param       WP_REST_Request     $request        The REST request data.
     * @return      string                              JSON encoded object containing suggested products.
     */
    public function get_envato_suggest( \WP_REST_Request $request )
    {
        $next_page = $request->get_param( 'next-page' );
        $url_regex = "#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#i";

        if ( !$next_page || !preg_match( $url_regex, $next_page ) ) return array( 'error' => 'invalid url' );

        $results = $this->envato->fetch( $next_page );

        $return_array = array(
            'next_page' => $results->links->next_page_url,
            'pictures' => array(),
            'urls' => array(),
            'site_urls' => array()
        );

        /**
         * Make sure to normalize site URLs due to different URL structures on envato.
         * Also grab the correct envato image.
         */
        foreach ( $results->matches as $result ) {
            $return_array['urls'][] = $result->url;
            $return_array['site_urls'][] = $result->normalized_url;
            $return_array['pictures'][] = Includes\Util::get_envato_image( $result->previews );
        }

        // Remember what page we are currently on for future suggestions.
        $_SESSION['livetime_suite_envato_suggested_page'] = $this->get_envato_page( $next_page );

        header('Content-type: application/json');
        echo json_encode( $return_array );
        die();
    }

    /**
     * Helper function the get the page number from an envato URL.
     * 
     * @since       1.0.0
     * @param       string      $url        The URL to the current envato page.
     * @return                              Returns the correct page number.
     */
    protected function get_envato_page( $url )
    {
        $url = explode( '?', $url );

        if ( count( $url ) < 2 ) return 1;

        $url = $url[1];
        $url = explode( '&', $url );

        foreach ( $url as $query_param )
        {
            $query_param = explode( '=', $query_param );

            if ( $query_param[0] === 'page' )
                return $query_param[1];
        }

        return 1;
    }

    /**
     * Set the theme for a project.
     *
     * @since       1.0.0
     * @param       WP_REST_Request     $request        The REST request data.
     * @return      string                              JSON encoded data of new theme.
     */
    public function set_project_theme( \WP_REST_Request $request )
    {
        $project_hash = $request->get_param( 'project-hash' );
        $envato_url = $request->get_param( 'envato-url' );
        $theme_url = $request->get_param( 'theme-url' );

        $project = Models\Project::where( 'hash', '=', $project_hash )->first();

        if ( !$project ) return null;

        // Get the theme without generating a thumbnail.
        $theme = Includes\Util::get_theme_light( $theme_url, $envato_url );

        $project->theme_id = $theme->id;
        $project->save();

        $result = $this->envato->get( Includes\Util::get_envato_id( $envato_url ) );

        $image_url = Includes\Util::get_envato_image( $result->previews );

        $return_array = array(
            'name' => $result->name,
            'attributes' => $result->attributes,
            'preview' => $result->normalized_url,
            'image' => $image_url
        );

        header('Content-type: application/json');
        echo json_encode( $return_array );
        die();
    }

    /**
     * Sign a project and send out agreements and invoices.
     *
     * @since       1.0.0
     * @param       WP_REST_Request     $request        The REST request data.
     * @return                                          
     */
    public function project_sign( \WP_REST_Request $request )
    {
        $project_hash = $request->get_param( 'project_hash' );
        $payment_option = intval($request->get_param( 'payment_option' ));

        if ( !$project_hash || !$payment_option ) return Includes\Response::error( 'Need to specify a project.' );

        $project = Models\Project::where( 'hash', '=', $project_hash )->first();

        if ( !$project ) return Includes\Response::error( 'The project doesn\'nt exist.' );

        $staff = Includes\Util::get_user( $project->handler_id );
        $customer = $project->customer;
        $customer_contact = $customer->contacts->first();

        if ( !$staff || !$customer || !$customer_contact ) return Includes\Response::error( 'Data missing.' );

        if ( $payment_option === 1 ) {
            $invoice_url = $this->invoice->create_invoice_part( $customer, $staff, $project, $customer_contact );
        }

        $contract_url = $this->contract->build_contract( $customer, $staff, $project, $customer_contact );

        $invoice_path = str_replace('http://', '/storage/content/20/215520/', $invoice_url);
        $invoice_path = str_replace('livetime.nu/', 'livetime.nu/public_html/', $invoice_path);

        $contract_path = str_replace('http://', '/storage/content/20/215520/', $contract_url);
        $contract_path = str_replace('livetime.nu/', 'livetime.nu/public_html/', $contract_path);

        $email_html = Includes\Util::render_php( LTS_CUSTOMER . 'templates/invoice_email.php', array(
            'contact' => $customer_contact
        ));

        $this->email->send_email(
            array( 'info@livetime.nu' => 'Livetime AB' ),
            array( $customer_contact->email => $customer_contact->name . ' ' . $customer_contact->surname ),
            'Livetime Faktura & Avtal',
            $email_html,
            'text/html',
            array(
                $invoice_path,
                $contract_path
            )
        );

        $project->confirmed = true;
        $project->save();

        return json_encode( array( 'success' => true ) );
    }

    /**
     * Start a signing process with BankID.
     *
     * @since       1.0.0
     * @param       WP_REST_Request     $request        The REST request data.
     * @return      string                              Returns JSON encoded response from BankID.
     */
    public function bankid_sign( \WP_REST_Request $request )
    {
        $personal_number = $request->get_param( 'personal_number' );
        $data            = $request->get_param( 'data' );

        if ( !$data || !$personal_number ) return json_encode( array( 'error' => 'You need to specify a personal number.' ) );

        $personal_number = str_replace( '-', '', $personal_number );

        // Hidden data should probaly be implemented for security reasons in the future.
        $hidden_data = '';

        $response = $this->bankid->sign( $personal_number, $data, $hidden_data );

        if ( $response ) {
            return json_encode( array( 'order_ref' => $response->orderRef ) );
        }

        return json_encode( array( 'error' => 'Something went wrong.' ) );
    }

    /**
     * Collect data from an ongoing BankID transaction.
     *
     * @since       1.0.0
     * @param       WP_REST_Request     $request        The REST request data.
     * @return      string                              Returns JSON encoded repsonse from BankID.
     */
    public function bankid_collect( \WP_REST_Request $request )
    {
        $order_ref = $request->get_param( 'order_ref' );
        $project_hash = $request->get_param( 'project_hash' );

        if ( !$order_ref || !$project_hash ) return Includes\Response::error( 'No ongoing attempts could be found. Please retry.' );

        /*$project = Cache::remember( $project_hash, 10, function() {
            return DB::table( 'projects' )->where( 'hash', '=', $project_hash)->first();
        } );*/

        $project = Models\Project::where( 'hash', '=', $project_hash )->first();

        if ( !$project ) return Includes\Response::error( 'You are trying to sign a non-existant project.' );

        $response = $this->bankid->collect( $order_ref );

        if ( $response ) {
            switch ( $response->progressStatus )
            {
                case 'OUTSTANDING_TRANSACTION':
                    return Includes\Response::bankid( 'RFA1' );
                case 'NO_CLIENT':
                    return Includes\Response::bankid( 'RFA1' );
                case 'STARTED':
                    return Includes\Response::bankid( 'RFA14' );
                case 'USER_SIGN':
                    return Includes\Response::bankid( 'RFA9' );
                case 'COMPLETE':
                    $person_id = Includes\Util::get_person( $response->userInfo );

                    if ( !$person_id ) return Includes\Response::error( 'Your BankID is invalid.' );

                    $signature = new Models\Signature();

                    $signature->signature = $response->signature;
                    $signature->ocsp = $response->ocspResponse;
                    $signature->person_id = $person_id;
                    $signature->project_id = $project->id;
                    $signature->save();

                    // Create the invoice.
                    $staff = Includes\Util::get_user( $project->handler_id );
                    $customer = $project->customer;
                    $customer_contact = $customer->contacts->first();

                    if ( !$customer_contact ) return Includes\Response::error( 'Something went wrong.' );

                    if ( !$staff || !$customer ) return Includes\Response::error( 'Something went wrong.' );

                    //$this->invoice->create_invoice( $customer, $staff, $project, $customer_contact );
                    
                    $this->invoice->create_invoice_part( $customer, $staff, $project, $customer_contact );

                    $invoice = $this->invoice->get_invoice();

                    $this->email->send_email(
                        array( 'info@livetime.nu' => 'Livetime AB' ),
                        array( $customer_contact->email => $customer_contact->name . ' ' . $customer_contact->surname ),
                        'Livetime Faktura',
                        'Hejsan du kan se din faktura här: ' . $invoice->url
                    );

                    return json_encode( array( 'message' => 'Avtal signerat.', 'complete' => true ) );
                default:
                    return Includes\Response::error( 'Invalid response type.' );

            }
        }

        return json_encode( array( 'error' => 'Something went wrong.' ) );
    }
}