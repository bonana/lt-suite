<?php

/**
 * Class to handle public-facing functionality of the site.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 *
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Public
 */

namespace Livetime;

class Livetime_Suite_Public
{
    /**
     * Controller class to handle displaying views.
     *
     * @since       1.0.0
     * @access      private
     * @var         object      $controller         Our public controller.
     */
    private $controller;

    /**
     * Envato client for handling envato requests.
     *
     * @since       1.0.0
     * @access      private
     * @var         object      $envato             Our envato client.
     */
    private $envato;

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
        $this->envato = new Envato\Envato();
        $this->controller = new Livetime_Suite_public_Controller(
            $this->envato,
            new BankID\BankID( 'bankid.livetime.pem', true ),
            new Customer\Invoice_Manager(),
            new Customer\Email_Manager(
                \Swift_SmtpTransport::newInstance('ssl://smtp.gmail.com', 465)
                                    ->setUsername('info@livetime.nu')
                                    ->setPassword('dbltzrxczcbbqwmc')),
            new Customer\Contract_Manager()
        );
    }

    /**
     * Register all of our query vars.
     *
     * @since       1.0.0
     * @param       array       $vars       Array of current query vars.
     * @return      array                   Merged array of query vars.
     */
    public function register_query_vars( $vars )
    {
        $vars[] = 'envato-id';
        $vars[] = 'envato-term';
        $vars[] = 'envato-site';
        $vars[] = 'envato-page';

        $vars[] = 'livetime-suite-hash';

        return $vars;
    }

    /**
     * Add URL Rewrite rules.
     *
     * @since       1.0.0
     */
    public function register_rewrite_rules()
    {
        add_rewrite_tag( '%envato-id%', '([0-9]*)' );
        add_rewrite_tag( '%envato-term%', '([^/]*)' );
        add_rewrite_tag( '%envato-site%', '([^/]*)' );
        add_rewrite_tag( '%envato-page%', '([0-9]*)' );

        add_rewrite_rule(
            '^envato/([0-9]*)/?$',
            'index.php?pagename=envato&envato-id=$matches[1]',
            'top'
        );

        add_rewrite_rule(
            '^envato/([^/]*\.[^/]*)/([^/]*)/([0-9]*)/?$',
            'index.php?pagename=envato&envato-site=$matches[1]&envato-term=$matches[2]&envato-page=$matches[3]',
            'top'
        );

        add_rewrite_rule(
            '^envato/([^/]*\.[^/]*)/([^/]*)/?$',
            'index.php?pagename=envato&envato-site=$matches[1]&envato-term=$matches[2]',
            'top'
        );

        add_rewrite_rule(
            '^envato/([^/]*)/([0-9]*)/?$',
            'index.php?pagename=envato&envato-term=$matches[1]&envato-page=$matches[2]',
            'top'
        );

        add_rewrite_rule(
            '^envato/([^/]*)/?$',
            'index.php?pagename=envato&envato-term=$matches[1]',
            'top'
        );

        add_rewrite_rule(
            '^envato/([^/]*\.[^/]*)/?$',
            'index.php?pagename=envato&envato-site=$matches[1]',
            'top'
        );

        add_rewrite_tag( '%livetime-suite-hash%', '([a-zA-Z0-9]*)' );

        add_rewrite_rule(
            '^project/([a-zA-Z0-9]*)/?$',
            'index.php?pagename=project&livetime-suite-hash=$matches[1]',
            'top'
        );

        flush_rewrite_rules();
    }

    /**
     * Register public REST routes.
     *
     * @since       1.0.0
     */
    public function register_rest_routes()
    {
        register_rest_route( 'livetime/v1', '/bankid/sign', array(
            'methods' => 'POST',
            'callback' => array( $this->controller, 'bankid_sign' )
        ) );

        register_rest_route( 'livetime/v1', '/bankid/collect', array(
            'methods' => 'GET',
            'callback' => array ( $this->controller, 'bankid_collect' )
        ) );

        register_rest_route( 'livetime/v1', '/envato/suggest', array(
            'methods' => 'GET',
            'callback' => array( $this->controller, 'get_envato_suggest' )
        ) );

        register_rest_route( 'livetime/v1', '/envato/change', array(
            'methods' => 'POST',
            'callback' => array( $this->controller, 'set_project_theme' )
        ) );

        register_rest_route( 'livetime/v1', '/project/sign', array(
            'methods' => 'POST',
            'callback' => array( $this->controller, 'project_sign' )
        ) );
    }

    /**
     * Register all of our page templates.
     *
     * @since       1.0.0
     * @param       string      $page_template      The page template.
     * @return      string                          The new page tmeplate.
     */
    public function envato_page_template( $page_template )
    {
        if ( is_page( 'envato' ) ) {
            $page_template = LTS_PUBLIC . 'partials/envato/page.php';
        } else if ( is_page( 'project' ) ) {
            $page_template = LTS_PUBLIC . 'partials/project/page.php';
        }

        return $page_template;
    }

    /**
     * Register all our shortcodes with WordPress.
     *
     * @since       1.0.0
     */
    public function register_shortcodes()
    {
        add_shortcode( 'livetime_suite_envato', array( $this, 'envato_search' ) );
        add_shortcode( 'livetime_suite_project_overview', array( $this, 'project_overview' ) );
        add_shortcode( 'invoice_test', array( $this, 'invoice_test' ) );
    }

    /**
     * TESTTEST
     */
    public function invoice_test( $atts )
    {
        extract( shortcode_atts( array(
            'project_id' => 1
        ), $atts ) );

        $project = Models\Project::where( 'id', '=', $project_id )->first();

        if ( ! $project ) return 'empty';

        $customer = $project->customer;
        $staff = Includes\Util::get_user( $project->handler_id );

        $invoice_html = Includes\Util::render_php( LTS_PACKAGES . 'customer/templates/invoice.php', array(
            'project' => $project,
            'customer' => $customer,
            'staff' => $staff
        ) );

        $invoice_html = mb_convert_encoding( $invoice_html, 'UTF-8', 'auto' );

        $invoice_path = Includes\Util::create_pdf( LTS_BASE . 'invoices/', $invoice_html, $customer->id, $project->id, 'invoice' );

        print_r( $invoice_path );

        return 'hello';
    }

    /**
     * Register the required stylesheets for our public-facing site.
     *
     * @since       1.0.0
     */
    public function enqueue_styles()
    {
        if ( is_page( 'project' ) ) {
            wp_enqueue_style( 'overview', LTS_PUBLIC_URL . 'assets/project/css/overview.css', array(), '20160916', 'all' );
        }
    }

    /**
     * Register the required JavaScript for our public-facing site.
     *
     * @since       1.0.0
     */
    public function enqueue_scripts()
    {
        if ( is_page( 'project' ) ) {
            //wp_enqueue_script( 'bankid', LTS_PUBLIC_URL . 'assets/project/js/bankid.js', array( 'jquery' ), '20160912', true );
            wp_enqueue_script( 'overview', LTS_PUBLIC_URL . 'assets/project/js/overview.js', array( 'jquery' ), '20160913', true);
        }
    }

    /**
     * Register global JS variables.
     *
     * @since       1.0.0
     */
    public function register_javascript_env()
    {
        ?>
        <script>
            var REST = REST || {};
            REST.url = '<?php echo get_site_url() . '/wp-json/livetime/v1/'; ?>';
        </script>
        <?php
    }

    /**
     * Function to display envato search shortcode.
     *
     * @since       1.0.0
     * @param       array       $atts       Shortcode attributes.
     * @return      string                  The HTML to display.
     */
    public function envato_search( $atts )
    {
        extract( shortcode_atts( array(
            'id' => null,
            'site' => null,
            'term' => null,
            'page' => 1
        ), $atts ) );

        ob_start();

        $template = 'partials/envato/empty.php';

        if ( $id !== null ) {
            $match = $this->envato->get( $id );
            $related = $this->envato->search();

            if ( $match ) {
                if ( isset( $match->previews->live_site ) )
                    $live_site_url = ( isset( $match->previews->live_site->href ) ? $match->previews->live_site->href : $match->previews->live_site->url );

                $template = 'partials/envato/detail.php';
            }
        } else {
            $results = $this->envato->search( ['term' => $term, 'site' => $site, 'page' => $page] );

            if ( $results && $results->matches && count( $results->matches ) > 0 ) {
                $template = 'partials/envato/search.php';
            }
        }

        include LTS_PUBLIC . $template;

        $html = ob_get_clean();

        return $html;
    }

    /**
     * Function to display project overview shortcode.
     *
     * @since       1.0.0
     * @param       array       $atts       Shortcode attributes.
     * @return      string                  The HTML to display.
     */
    public function project_overview( $atts )
    {
        extract( shortcode_atts( array(
            'hash' => null
        ), $atts ) );

        $template = 'partials/project/empty.php';

        if ( $hash ) {
            $project = Models\Project::where( 'hash', '=', $hash )->with('invoices')->with('theme')->first();

            if ( $project ) {
                $customer = $project->customer;
                $staff = Includes\Util::get_user( $project->handler_id );

                if ( $project->confirmed ) {
                    $template = 'partials/project/panel.php';
                } else {
                    // SETUP ENVATO STUFF.
                    $envato = Includes\Util::get_project_envato( $this->envato, $project );
                    $suggested_page = ( isset( $_SESSION['livetime_suite_envato_suggested_page'] ) ? $_SESSION['livetime_suite_envato_suggested_page'] : 1 );

                    $compatible_with = null;

                    foreach ( $envato->attributes as $attribute ) {
                        if ( $attribute->name === 'compatible-software' ) {
                            if ( is_array( $attribute->value ) ) {
                                $temp_value = $attribute->value[0];
                                $temp_value = explode( ' ', $temp_value );

                                $compatible_with = $temp_value[0];
                            } else {
                                $compatible_with = $attribute->value;
                            }
                        }
                    }

                    $suggested_products = $this->envato->search( array(
                        'site' => 'themeforest.net',
                        'sort_by' => 'rating',
                        'platform' => $compatible_with,
                        'page_size' => 3,
                        'page' => $suggested_page
                    ) );

                    $template = 'partials/project/overview.php';
                }
            }
        }

        ob_start();

        include LTS_PUBLIC . $template;

        $html = ob_get_clean();

        return $html;
    }


    /**
     * Load the dependencies for this class
     *
     * @since       1.0.0
     */
    private function load_dependencies()
    {
        // VENDOR
        require_once LTS_PACKAGES . 'envato/envato.php';
        require_once LTS_PACKAGES . 'bankid/bankid.php';

        require_once LTS_PUBLIC . 'controller/class-livetime-suite-public-controller.php';
    }

    /**
     * Get the publi controller.
     *
     * @since       1.0.0
     * @return      Livetime_Suite_Public_Controller     The current controller
     */
    public function get_controller()
    {
        return $this->controller;
    }
}