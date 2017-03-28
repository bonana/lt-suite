<?php

/**
 * File for setting up the Includes package.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Packages/Includes
 */

/**
 * Load UTILS
 */
if ( !function_exists('untrailingslashit' ) ) {
    function untrailingslashit( $string ) {
        return rtrim( $string, '/\\' );
    }
}

if ( !function_exists('trailingslashit' ) ) {
    function trailingslashit( $string ) {
        return untrailingslashit( $string ) . '/';
    }
}

if ( !function_exists('plugin_dir_path' ) ) {
    function plugin_dir_path( $file ) {
        return trailingslashit( dirname( $file ) );
    }
}

require_once plugin_dir_path( __FILE__ ) . 'classes/Util.php';
require_once plugin_dir_path( __FILE__ ) . 'classes/Response.php';