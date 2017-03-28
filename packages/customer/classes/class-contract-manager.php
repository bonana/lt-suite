<?php

/**
 * Class to handle Contracts.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Packages/Customer/Classes
 */

namespace Livetime\Customer;

class Contract_Manager extends Base_Manager
{
    /**
     * Initialize the class.
     *
     * @since       1.0.0
     */
    public function __construct()
    {
        $this->plugin_dir = LTS_BASE;
        $this->template = 'packages/customer/templates/contract.php';
        $this->contract_dir = 'contracts/';
        $this->exec_dir = 'bin' . DIRECTORY_SEPARATOR;
    }

    public function build_contract( $customer, $staff, $project, $customer_contact )
    {
        $contract_html = \Livetime\Includes\Util::render_php( $this->plugin_dir . $this->template, array(
            'customer' => $customer,
            'staff' => $staff,
            'project' => $project,
            'customer_contact' => $customer_contact,
        ) );

        $contract_html = mb_convert_encoding( $contract_html, 'UTF-8', 'auto' );

        return \Livetime\Includes\Util::create_pdf( LTS_BASE . 'contracts/', $contract_html, $customer->id, $project->id, 'contract', "8", "12" );
    }

    protected function generate_pdf_name( $customer_id, $project_id )
    {
        return $customer_id . '_contract_' . $project_id . '.pdf';
    }

    protected function get_path_contract_base()
    {
        return $this->plugin_dir . $this->contract_dir;
    }

    protected function get_path_contract_html( $name )
    {
        return $this->get_path_contract_base() . $name . '/' . $name . '.html';
    }

    protected function get_path_contract_pdf( $dir_name, $pdf_name )
    {
        return $this->get_path_contract_base() . $dir_name . '/' . $pdf_name;
    }

    protected function get_url_contract_base()
    {
        return get_site_url() . '/wp-content/plugins/livetime-suite/' . $this->contract_dir;
    }

    protected function get_url_contract_pdf( $dir_name, $pdf_name )
    {
        return $this->get_url_contract_base() . $dir_name . '/' . $pdf_name;
    }    
}