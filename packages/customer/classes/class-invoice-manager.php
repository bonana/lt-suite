<?php

/**
 * Class to handle Invoices.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Packages/Customer/Classes
 */

namespace Livetime\Customer;

use \Livetime\Models\Invoice;

class Invoice_Manager extends Base_Manager
{
    /**
     * The last created invoice.
     *
     * @since       1.0.0
     * @access      private
     * @var         Models\Invoice      $invoice        The last created invoice.
     */
    private $invoice;

    /**
     * Initialize the class.
     *
     * @since       1.0.0
     */
    public function __construct()
    {
        $this->plugin_dir = LTS_BASE;
        $this->template = 'packages/customer/templates/invoice.php';
        $this->invoice_dir = 'invoices/';
        $this->exec_dir = 'bin' . DIRECTORY_SEPARATOR;
    }

    /**
     * Base function to create invoices
     *
     * @since       1.0.0
     */
    private function build_invoice( $customer, $staff, $project, $customer_contact, $percentage )
    {
        if ( empty( $project->products ) ) return null;

        foreach ( $project->products as $product )
        {
            $product->price = $product->price * ( $percentage / 100 );
        }

        $this->invoice = new Invoice();

        $this->invoice->url = 'none';
        $project->invoices()->save( $this->invoice );
        $project->percentage = $percentage;
        $project->save();

        $this->invoice->ocr = $this->create_ocr( $this->invoice->id );
        $this->invoice->save();

        $invoice_html = \Livetime\Includes\Util::render_php( $this->plugin_dir . $this->template, array(
            'customer' => $customer,
            'staff' => $staff,
            'project' => $project,
            'customer_contact' => $customer_contact,
            'invoice' => $this->invoice
        ) );

        $invoice_html = mb_convert_encoding( $invoice_html, 'UTF-8', 'auto' );

        $this->invoice->url = \Livetime\Includes\Util::create_pdf( LTS_BASE . 'invoices/', $invoice_html, $customer->id, $project->id, 'invoice' );
        $this->invoice->save();

        return $this->invoice->url;
    }

    /**
     * Create a part payment of 50%
     *
     * @since       1.0.0
     */
    public function create_invoice_part( $customer, $staff, $project, $customer_contact )
    {
        return $this->build_invoice( $customer, $staff, $project, $customer_contact, 50 );
    }

    /**
     * Create a new Invoice.
     *
     * @since       1.0.0
     */
    public function create_invoice( $customer, $staff, $project, $customer_contact )
    {
        return $this->build_invoice( $customer, $staff, $project, $customer_contact, 100 );
        /*$invoice_html = \Livetime\Includes\Util::render_php( $this->plugin_dir . $this->template, array(
            'customer' => $customer,
            'staff' => $staff,
            'project' => $project,
            'customer_contact' => $customer_contact
        ) );

        $invoice_html = mb_convert_encoding( $invoice_html, 'UTF-8', 'auto' );

        $dir_name = md5( $customer->id . '_invoice' );
        $pdf_name = $this->generate_pdf_name( $customer->id, $project->id );

        if ( !file_exists( $this->plugin_dir . $this->invoice_dir . $dir_name ) )
            mkdir( $this->plugin_dir . $this->invoice_dir . $dir_name, 0777, true );

        file_put_contents( $this->get_path_invoice_html( $dir_name ), $invoice_html );
        exec( dirname( dirname( __FILE__ ) ) . '/bin/wkhtmltopdf --print-media-type --page-width 2480px --page-height 3508px --margin-top 0 --margin-right 0 --margin-bottom 0 --margin-left 0 --dpi 200 --zoom 1 -L 0 -R 0 -T 0 -B 0 ' . $this->get_path_invoice_html( $dir_name ) . ' ' . $this->get_path_invoice_pdf( $dir_name, $pdf_name ) );

        //if ( file_exists( $this->get_path_quote_pdf( $dir_name, $pdf_name ) ) ) {
            $this->invoice = new Invoice();

            $this->invoice->url = $this->get_url_invoice_pdf( $dir_name, $pdf_name );

            $project->invoices()->save( $this->invoice );

            $this->invoice->ocr = $this->create_ocr( $this->invoice->id );
            $this->invoice->save();
        //}*/
    }

    /**
     * Get the last created invoice.
     *
     * @since       1.0.0
     * @return      Models\Invoice      The last created invoice.
     */
    public function get_invoice()
    {
        return $this->invoice;
    }

    protected function generate_pdf_name( $customer_id, $project_id )
    {
        return $customer_id . '_invoice_' . $project_id . '.pdf';
    }

    protected function get_path_invoice_base()
    {
        return $this->plugin_dir . $this->invoice_dir;
    }

    protected function get_path_invoice_html( $name )
    {
        return $this->get_path_invoice_base() . $name . '/' . $name . '.html';
    }

    protected function get_path_invoice_pdf( $dir_name, $pdf_name )
    {
        return $this->get_path_invoice_base() . $dir_name . '/' . $pdf_name;
    }

    protected function get_url_invoice_base()
    {
        return get_site_url() . '/wp-content/plugins/livetime-suite/' . $this->invoice_dir;
    }

    protected function get_url_invoice_pdf( $dir_name, $pdf_name )
    {
        return $this->get_url_invoice_base() . $dir_name . '/' . $pdf_name;
    }

    /**
     * Create a valid OCR number for our invoice.
     *
     * Base the OCR number on our internal invoice id.
     *
     * @since       1.0.0
     * @param       int         $id         The invoice ID.
     * @param       string                  Returns the OCR for our Invoice.
     */
    protected function create_ocr( $id )
    {
        $ocr = str_pad( $id, 10, '0', STR_PAD_LEFT );
        $ocr = $ocr . '2';

        $ocr_reverse = strrev( $ocr );

        $sum = 0;

        // Multiplier starts with 2
        $multiplier = 2;

        $len = strlen( $ocr_reverse );

        for ( $i = 0; $i < $len; $i++ ) {
            $current_number = intval( $ocr_reverse[$i] ) * $multiplier;

            if ( $current_number > 9 )
                $current_number -= 9;

            $sum += $current_number;

            if ( $multiplier === 2 )
                $multiplier = 1;
            else
                $multiplier = 2;
        }

        $max_num = ceil( $sum / 10 ) * 10;

        $control = $max_num - $sum;

        return $ocr . $control;
    }
    
}