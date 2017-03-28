<?php

/**
 * Class used to route admin views to pages.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Admin/Controller
 */

namespace Livetime;

class Livetime_Suite_Admin_Controller
{
    /**
     * Display the main admin page.
     *
     * @since       1.0.0
     */
    public function display_admin_main()
    {
        include( LTS_ADMIN . 'partials/admin_main.php' );
    }

    /**
     * Display the quote admin page.
     *
     * @since       1.0.0
     */
    public function display_admin_quote()
    {
        include( LTS_ADMIN . 'partials/admin_quote.php' );
    }

    /**
     * Display page to create invoices
     *
     * @since       1.0.0
     */
    public function display_admin_invoice()
    {
        include( LTS_ADMIN . 'partials/admin_invoice.php' );
    }

    /**
     * Display page to overview projects.
     *
     * @since       1.0.0
     */
    public function display_admin_project()
    {
        if ( $_GET['projectid'] ) {
            $project = Models\Project::with('customer')->with('products')->with('customer.contacts')->where('id', '=', esc_sql( $_GET['projectid'] ) )->first();
            $statuses = Models\Status::all();

            if ( $project ) {
                include( LTS_ADMIN . 'partials/admin_project_detail.php' );
            }
        } else {
            $projects = Models\Project::with('customer')->with('status')->where('handler_id', '=', get_current_user_id())->where('confirmed', '=', true)->get();

            $unconfirmed_projects = Models\Project::with('customer')->with('status')->where('handler_id', '=', get_current_user_id())->where('confirmed', '=', false)->get();

            include( LTS_ADMIN . 'partials/admin_project.php' );
        }
    }

    /**
     * Create a standalone invoice.
     *
     * @since       1.0.0
     */
    public function create_invoice()
    {
        $project_id = $_POST['project_id'];

        if ( ! $project_id ) return null;

        $project = Models\Project::where( 'id', '=', $project_id )->first();

        if ( ! $project ) return null;

        $customer = $project->customer;
        $staff = Includes\Util::get_user( $project->handler_id );

        $invoice_html = Includes\Util::render_php( LTS_PACKAGES . 'customer/templates/invoice.php', array(
            'customer' => $customer,
            'project' => $project,
            'staff' => $staff
        ) );

        $pdf_path = Includes\Util::create_pdf( LTS_BASE . 'invoices/', $invoice_html, $customer->id, $project->id, 'invoice' );

        echo $pdf_path;
    }

    /**
     * Send invoice to customer
     *
     * @since       1.0.0
     */
    public function send_admin_invoice()
    {
        $project_id = $_POST['project_id'];

        if ( !$project_id ) {
            echo 'no id';
            wp_die();
        }

        $project = Models\Project::where( 'id', '=', $project_id )->first();

        if ( !$project ) {
            echo 'missing';
            wp_die();
        }

        $staff = Includes\Util::get_user( $project->handler_id );
        $customer = $project->customer;
        $customer_contact = $customer->contacts->first();

        if ( !$staff || !$customer || !$customer_contact ) {
            echo 'missing data';
            wp_die();
        }

        // Create email and send the invoice.
        $mail_body = 'Välkommen!';

        $invoice_manager = new Customer\Invoice_Manager();
        $invoice_url = $invoice_manager->create_invoice_part( $customer, $staff, $project, $customer_contact );

        $contract_manager = new Customer\Contract_Manager();
        $contract_url = $contract_manager->build_contract( $customer, $staff, $project, $customer_contact );

        $invoice_path = str_replace('http://', '/storage/content/20/215520/', $invoice_url);
        $invoice_path = str_replace('livetime.nu/', 'livetime.nu/public_html/', $invoice_path);

        $contract_path = str_replace('http://', '/storage/content/20/215520/', $contract_url);
        $contract_path = str_replace('livetime.nu/', 'livetime.nu/public_html/', $contract_path);

        $email_html = Includes\Util::render_php( LTS_CUSTOMER . 'templates/invoice_email.php', array(
            'contact' => $customer_contact
        ));

        $email_manager = new Customer\Email_Manager(\Swift_SmtpTransport::newInstance('ssl://smtp.gmail.com', 465)
        ->setUsername('info@livetime.nu')
        ->setPassword('dbltzrxczcbbqwmc'));

        $email_manager->send_email(
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

        echo json_encode( array( 'message' => 'success' ) );
        wp_die();
    }

    /**
     * Handle posting of new quote.
     *
     * @since       1.0.0
     */
    public function send_admin_quote()
    {
        if ( !Includes\Util::validate( $_POST, array(
            'email_customer_firstname'      => 'allow',
            'email_customer_lastname'       => 'allow',
            'email_customer_email'          => 'email',
            'email_customer_phone'          => 'allow',
            'email_company_name'            => 'allow',
            'email_company_org_nr'          => 'orgnr',
            'email_company_county'          => 'allow',
            'email_company_town'            => 'allow',
            'email_company_address'         => 'allow',
            'email_company_post_code'       => 'postal',
            'email_envato_url'              => 'url',
            'email_theme_url'               => 'url',
            'email_product_name'            => 'allow',
            'email_product_description'     => 'allow',
            'email_product_price'           => 'number',
            'email_product_qty'             => 'number'
        ))) return false;

        // CUSTOMER
        $customer_manager = new Customer\Customer_Manager();

        if ( !$customer_manager->exists( $_POST['email_company_org_nr'] ) ) {
            $customer_manager->create(
                $_POST['email_company_name'],
                $_POST['email_company_org_nr'],
                $_POST['email_company_county'],
                $_POST['email_company_town'],
                $_POST['email_company_address'],
                $_POST['email_company_post_code']
            )
            ->add_contact(
                $_POST['email_customer_firstname'],
                $_POST['email_customer_lastname'],
                $_POST['email_customer_email'],
                $_POST['email_customer_phone']
            );
        }

        $theme = Includes\Util::get_theme( $_POST['email_theme_url'], $_POST['email_envato_url'] );
        $customer_manager->add_project( get_current_user_id(), $theme->id );

        $products = Includes\Util::extract_products( $_POST['email_product_name'], $_POST['email_product_description'], $_POST['email_product_price'], $_POST['email_product_qty'] );

        foreach ( $products as $product ) {
            $customer_manager->add_project_product( $product->name, $product->description, $product->price, $product->qty );
        }

        // QUOTE
        $quote_manager = new Customer\Quote_Manager();

        $quote_manager->create_quote( $customer_manager->get_customer(), Includes\Util::get_current_user(), $customer_manager->get_project() );

        echo 'mile_two<br>';

        // EMAIL
        $recent_posts = Includes\Util::get_recent_posts( 2, true );
        $testimonial = Includes\Util::get_recent_testimonials( 1 );
        $thumbnail_one = Includes\Util::get_post_thumbnail( $recent_posts[0] );
        $thumbnail_two = Includes\Util::get_post_thumbnail( $recent_posts[1] );
        $is_shop = Includes\Util::is_theme_shop( $theme );
        $staff = Includes\Util::get_current_user();
        $html_body = Includes\Util::render_php( LTS_CUSTOMER . 'templates/email.php', array(
            'ltCustomer' => $customer_manager->get_customer(),
            'ltStaff' => $staff,
            'lt_post_one' => $recent_posts[0],
            'lt_post_two' => $recent_posts[1],
            'lt_post_one_thumbnail_url' => $thumbnail_one,
            'lt_post_two_thumbnail_url' => $thumbnail_two,
            'testimonial' => $testimonial,
            'theme' => $theme,
            'quote' => $quote_manager->get_quote(),
            'is_shop' => $is_shop
        ) );

        $email_manager = new Customer\Email_Manager(
            \Swift_SmtpTransport::newInstance('ssl://smtp.gmail.com', 465)
                                ->setUsername('info@livetime.nu')
                                ->setPassword('dbltzrxczcbbqwmc')
        );
        $email_manager->send_email(
            array( 'info@livetime.nu' => 'Livetime AB' ),
            array( $_POST['email_customer_email'] => $_POST['email_customer_firstname'] . ' ' . $_POST['email_customer_lastname']),
            'Livetime Förslag',
            $html_body,
            'text/html'
        );
    }
}