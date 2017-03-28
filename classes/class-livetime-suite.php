<?php

/**
 * Class to handle core functionality of Livetime Suite.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Classes
 */

namespace Livetime;

class Livetime_Suite
{
    /**
     * Loader class that handles all our hooks with WordPress.
     *
     * @since       1.0.0
     * @access      protected
     * @var         Livetime_Suite_Loader       $loader     Registers all hooks for the plugin
     */
    protected $loader;

    /**
     * Our plugin name.
     *
     * @since       1.0.0
     * @access      protected
     * @var         string      $plugin_name        The string used to identify this plugin.
     */
    protected $plugin_name;

    /**
     * Current version of our plugin.
     *
     * @since       1.0.0
     * @access      protected
     * @var         string      $version            The current version.
     */
    protected $version;

    /**
     * Boot up the core functionality of our plugin.
     *
     * Intializes plugin name and version that is usable throughout the plugin.
     * Load all dependencies, handle localization, and register hooks.
     *
     * @since       1.0.0
     */
    public function __construct()
    {
        $this->plugin_name = 'livetime-suite';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->init_database();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies.
     *
     * The following files make up the plugin:
     *
     * - Livetime_Suite_Loader. Takes care of all hooks.
     * - Livetime_Suite_i18n. Takes care of internationalization.
     * - Livetime_Suite_Admin. Handles all admin related things.
     * - Livetime_Suite_Public. Handles all public related things.
     *
     * Create an instance of the loader which will be used to register our hooks.
     *
     * @since       1.0.0
     * @access      private
     */
    private function load_dependencies()
    {
        /**
         * Load vendor / libraries
         */
        require_once LTS_PACKAGES . 'bankid/bankid.php';
        require_once LTS_PACKAGES . 'customer/customer.php';
        require_once LTS_PACKAGES . 'envato/envato.php';
        require_once LTS_PACKAGES . 'includes/includes.php';

        /**
         * Loader class responsible for hooks.
         */
        require_once LTS_BASE . 'classes/class-livetime-suite-loader.php';

        /**
         * Class responsible for internationlization.
         */
        require_once LTS_BASE . 'classes/class-livetime-suite-i18n.php';

        /**
         * Class responsible for all admin facing functionality.
         */
        require_once LTS_BASE . 'admin/class-livetime-suite-admin.php';

        /**
         * Class responsible for all the public facing functionality.
         */
        require_once LTS_BASE . 'public/class-livetime-suite-public.php';

        $this->loader = new Livetime_Suite_loader();
    }

    /**
     * Start the database.
     *
     * @since       1.0.0
     * @access      private
     */
    private function init_database()
    {
        Includes\Util::init_database();
    }

    /**
     * Set up internationalization for the plugin.
     *
     * Uses our i18n class to set text domain and register that hook with WordPress.
     *
     * @since       1.0.0
     * @access      private
     */
    private function set_locale()
    {
        $plugin_i18n = new Livetime_Suite_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all our admin related hooks.
     *
     * @since       1.0.0
     * @access      private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Livetime_Suite_Admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'admin_menu', $plugin_admin, 'setup_admin_menu' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_post_livetime_suite_quote_send', $plugin_admin->get_controller(), 'send_admin_quote' );
        $this->loader->add_action( 'admin_post_livetime_suite_invoice_create', $plugin_admin->get_controller(), 'create_invoice' );
        $this->loader->add_action( 'wp_ajax_livetime_suite_send_invoice', $plugin_admin->get_controller(), 'send_admin_invoice' );
    }

    /**
     * Register all our public related hooks.
     *
     * @since       1.0.0
     * @access      private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Livetime_Suite_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'init', $plugin_public, 'register_shortcodes' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_head', $plugin_public, 'register_javascript_env' );

        // SETUP ENVATO
        $this->loader->add_filter( 'query_vars', $plugin_public, 'register_query_vars' );
        $this->loader->add_action( 'init', $plugin_public, 'register_rewrite_rules' );
        $this->loader->add_filter( 'page_template', $plugin_public, 'envato_page_template' );

        // SETUP BANKID
        $this->loader->add_action( 'rest_api_init', $plugin_public, 'register_rest_routes' );
    }

    /**
     * Execute the loader to register all of our hooks.
     *
     * @since       1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * Get the name that is used to identify our plugin.
     *
     * @since       1.0.0
     * @return      string      The plugin name.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * Get our plugin version.
     *
     * @since       1.0.0
     * @return      string      Version number of our plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Get the loader class currently in use.
     *
     * @since       1.0.0
     * @return      Livetime_Suite_Loader       Handles registration of hooks.
     */
    public function get_loader()
    {
        return $this->loader;
    }
}