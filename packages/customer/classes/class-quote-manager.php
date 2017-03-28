<?php

/**
 * Class to handle Quotes.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     Customer
 * @subpackage  Customer/Classes
 */

namespace Livetime\Customer;

use \Livetime\Models\Quote;

class Quote_Manager extends Base_Manager
{
    /**
     * The last created quote.
     *
     * @since       1.0.0
     * @access      private
     * @var         Models\Quote    $quote      The last created quote
     */
    private $quote;

    /**
     * Initialize the class.
     *
     * @since       1.0.0
     */
    public function __construct()
    {
        $this->plugin_dir = LTS_BASE;
        $this->template = 'packages/customer/templates/quote.php';
        $this->quote_dir = 'quotes/';
        $this->exec_dir = 'bin' . DIRECTORY_SEPARATOR;
    }

    /**
     * Create a Quote.
     *
     * @since       1.0.0
     */
    public function create_quote( $customer, $staff, $project )
    {
        $quote_html = \Livetime\Includes\Util::render_php( $this->plugin_dir . $this->template, [
            'ltCustomer' => $customer,
            'ltStaff' => $staff,
            'ltProject' => $project
        ] );
        $quote_html = mb_convert_encoding( $quote_html, 'UTF-8', 'auto' );

        $pdf_path = \Livetime\Includes\Util::create_pdf( LTS_BASE . 'quotes/', $quote_html, $customer->id, $project->id, 'quote' );

        if ( $pdf_path ) {
            $this->quote = new Quote();

            $this->quote->url = $pdf_path;

            $project->quotes()->save( $this->quote );
        }
    }

    /**
     * Get the last created quote.
     *
     * @since       1.0.0
     * @return      Models\Quote        The last created quote
     */
    public function get_quote()
    {
        return $this->quote;
    }

    protected function generate_pdf_name( $customer_id, $project_id )
    {
        return $customer_id . '_quote_' . $project_id . '.pdf';
    }

    protected function get_path_quote_base()
    {
        return $this->plugin_dir . $this->quote_dir;
    }

    protected function get_path_quote_html( $name ) 
    {

        return $this->get_path_quote_base() . $name . '/' . $name . '.html';
    }

    protected function get_path_quote_pdf( $dir_name, $pdf_name )
    {
        return $this->get_path_quote_base() . $dir_name . '/' . $pdf_name;
    }

    protected function get_url_quote_base()
    {
        return get_site_url() . '/wp-content/plugins/livetime-suite/' . $this->quote_dir;
    }

    protected function get_url_quote_pdf( $dir_name, $pdf_name )
    {
        return $this->get_url_quote_base() . $dir_name . '/' . $pdf_name;
    }
}