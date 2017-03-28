<?php

/**
 * Class to handle admin functionality of the site.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 *
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Admin
 */

namespace Livetime;

class Livetime_Suite_Admin
{
    /**
     * Controller class to handle displaying views.
     *
     * @since       1.0.0
     * @access      private
     * @var         object      $controller         Our admin controller.
     */
    private $controller;

    /**
     * The name of our plugin.
     *
     * @since       1.0.0
     * @access      private
     * @var         string      $plugin_name        Our plugins name
     */
    private $plugin_name;

    /**
     * The version of our plugin.
     *
     * @since       1.0.0
     * @access      private
     * @var         string      $version            Our plugin version
     */
    private $version;

    /**
     * Initialize the class and set our properties.
     *
     * @since       1.0.0
     * @param       string      $plugin_name        The name of our plugin.
     * @param       string      $version            The version of our plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->load_dependencies();
        $this->controller = new Livetime_Suite_Admin_Controller();
    }

    /**
     * Register the required stylesheets for our admin area.
     *
     * @since       1.0.0
     */
    public function enqueue_styles()
    {

    }

    /**
     * Register the required JavaScript for our admin area.
     *
     * @since       1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script( 'livetime-suite-list', LTS_ADMIN_URL . 'assets/js/list.min.js', array( 'jquery' ), '20161013', true);
        wp_enqueue_script( 'livetime-suite-admin', LTS_ADMIN_URL . 'assets/js/livetime-suite-admin.js', array( 'jquery', 'livetime-suite-list' ), '20160908', true);
    }

    /**
     * Register our plugin in the admin menu.
     *
     * @since       1.0.0
     */
    public function setup_admin_menu()
    {
        add_menu_page( 'Livetime', 'Livetime', 'delete_pages', 'livetime-suite-admin', array( $this->controller, 'display_admin_main' ) );
        add_submenu_page( 'livetime-suite-admin', 'Förslag utskick', 'Förslag utskick', 'delete_pages', 'livetime-suite-admin-email', array( $this->controller, 'display_admin_quote' ) );
        //add_submenu_page( 'livetime-suite-admin', 'Skapa faktura', 'Skapa faktura', 'delete_pages', 'livetime-suite-admin-invoice', array( $this->controller, 'display_admin_invoice' ) );
        add_submenu_page( 'livetime-suite-admin', 'Projekt', 'Projekt', 'delete_pages', 'livetime-suite-admin-project', array( $this->controller, 'display_admin_project' ) );
    }

    /**
     * Load the dependencies for this class
     *
     * @since       1.0.0
     */
    private function load_dependencies()
    {
        require_once LTS_ADMIN . 'controller/class-livetime-suite-admin-controller.php';
    }

    /**
     * Get the admin controller.
     *
     * @since       1.0.0
     * @return      Livetime_Suite_Admin_Controller     The current controller
     */
    public function get_controller()
    {
        return $this->controller;
    }
}