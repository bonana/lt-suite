<?php

/**
 * Plugin to handle all the specific needs of Livetime.nu
 * This includes being able to generate quotes dynamicly and
 * then send a custom HTML email containing all the project information.
 * Also includes functionality for a dynamic Webshop using the Envato API.
 * BankID integration.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @package     livetimesuite
 */

/**
 * Plugin Name: Livetime WordPress Suite
 * Plugin URI: http://livetime.nu
 * Author: Alexander Karlsson <alexander@livetime.nu>
 * Description: A WordPress plugin adding Livetime Suite Features to WordPress
 * Version: 1.0.0
 */

if ( !defined('ABSPATH') ) die;

define( 'LTS_BASE', plugin_dir_path( __FILE__ ) );
define( 'LTS_BASE_URL', plugin_dir_url( __FILE__ ) );

define( 'LTS_PACKAGES', LTS_BASE . 'packages/' );
define( 'LTS_PACKAGES_URL', LTS_BASE_URL . 'packages/' );

define( 'LTS_CUSTOMER', LTS_PACKAGES . 'customer/' );
define( 'LTS_CUSTOMER_URL', LTS_PACKAGES_URL . 'customer/' );

define( 'LTS_BANKID', LTS_PACKAGES . 'bankid/' );
define( 'LTS_BANKID_URL', LTS_PACKAGES_URL . 'bankid/' );

define( 'LTS_ENVATO', LTS_PACKAGES . 'envato/' );
define( 'LTS_ENVATO_URL', LTS_PACKAGES_URL . 'envato/' );

define( 'LTS_INCLUDES', LTS_PACKAGES . 'includes/' );
define( 'LTS_INCLUDES_URL', LTS_PACKAGES_URL . 'includes/' );

define( 'LTS_ADMIN', LTS_BASE . 'admin/' );
define( 'LTS_ADMIN_URL', LTS_BASE_URL . 'admin/' );

define( 'LTS_PUBLIC', LTS_BASE . 'public/' );
define( 'LTS_PUBLIC_URL', LTS_BASE_URL . 'public/' );

session_start();

require_once LTS_BASE . 'vendor/autoload.php';

/**
 * Code that will run during plugin activation.
 * Documented in setup/class-livetime-suite-activator.php
 */
function activate_livetime_suite()
{
    require_once LTS_BASE . 'setup/class-livetime-suite-activator.php';
    Livetime\Livetime_Suite_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_livetime_suite' );

/**
 * Code that will run during plugin deactivation.
 * Documented in setup/class-livetime-suite-deactivator.php
 */
function deactivate_livetime_suite()
{
    require_once LTS_BASE . 'setup/class-livetime-suite-deactivator.php';
    Livetime\Livetime_Suite_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_livetime_suite' );

/**
 * Run the core plugin.
 */
require_once LTS_BASE . 'classes/class-livetime-suite.php';

function run_livetime_suite()
{
    $plugin = new Livetime\Livetime_Suite();
    $plugin->run();
}

run_livetime_suite();