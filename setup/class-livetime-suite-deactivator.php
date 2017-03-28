<?php

/**
 * Class to deactivate the plugin.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Classes
 */

namespace Livetime;

use \Illuminate\Database\Capsule\Manager as Capsule;

class Livetime_Suite_Deactivator
{
    /**
     * Function to run during plugin deactivation, we use it to remove our custom databases.
     *
     * @since       1.0.0
     */
    public static function deactivate()
    {
        self::load_dependencies();
        Includes\Util::init_database();

        if ( Capsule::schema()->hasTable( 'signatures' ) )
            Capsule::schema()->drop( 'signatures' );

        if ( Capsule::schema()->hasTable( 'people' ) )
            Capsule::schema()->drop( 'people' );

        if ( Capsule::schema()->hasTable( 'invoices' ) )
            Capsule::schema()->drop( 'invoices' );

        if ( Capsule::schema()->hasTable( 'quotes' ) )
            Capsule::schema()->drop( 'quotes' );

        if ( Capsule::schema()->hasTable( 'project_products' ) )
            Capsule::schema()->drop( 'project_products' );

        if ( Capsule::schema()->hasTable( 'project_files' ) )
            Capsule::schema()->drop( 'project_files' );

        if ( Capsule::schema()->hasTable( 'projects' ) )
            Capsule::schema()->drop( 'projects' );

        if ( Capsule::schema()->hasTable( 'status' ) )
            Capsule::schema()->drop( 'status' );

        if ( Capsule::schema()->hasTable( 'themes' ) )
            Capsule::schema()->drop( 'themes' );

        if ( Capsule::schema()->hasTable( 'customer_contacts' ) )
            Capsule::schema()->drop( 'customer_contacts' );

        if ( Capsule::schema()->hasTable( 'customers' ) )
            Capsule::schema()->drop( 'customers' );
    }

    private static function load_dependencies()
    {
        require_once LTS_INCLUDES . 'classes/Util.php';
    }
}