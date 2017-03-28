<?php

/**
 * Class to activate the plugin.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Setup
 */

namespace Livetime;

use \Illuminate\Database\Capsule\Manager as Capsule;

class Livetime_Suite_Activator
{
    /**
     * Function to run during activation of the plugin, setup our necessary database structures
     * and such.
     *
     * @since       1.0.0
     */
    public static function activate()
    {
        self::load_dependencies();
        Includes\Util::init_database();

        if ( ! Capsule::schema()->hasTable( 'customers' ) ) {
            Capsule::schema()->create( 'customers', function( $table ) {
                $table->bigIncrements( 'id' );
                $table->string( 'name' );
                $table->string( 'org_nr' );
                $table->string( 'county' );
                $table->string( 'town' );
                $table->string( 'address' );
                $table->string( 'postal' );
                $table->timestamps();
            });
        }

        if ( ! Capsule::schema()->hasTable( 'customer_contacts' ) ) {
            Capsule::schema()->create( 'customer_contacts', function( $table ) {
                $table->bigIncrements( 'id' );
                $table->bigInteger( 'customer_id' )->unsigned();
                $table->string( 'name' );
                $table->string( 'surname' );
                $table->string( 'email' );
                $table->string( 'phone' );
                $table->timestamps();

                //$table->foreign( 'customer_id' )->references( 'id' )->on( 'customers' )->onDelete( 'cascade' );
            });

            Capsule::schema()->table( 'customer_contacts', function( $table ) {
                $table->foreign( 'customer_id' )->references( 'id' )->on( 'customers' )->onDelete( 'cascade' );
            } );
        }

        /*if ( ! Capsule::schema()->hasTable( 'customer_meta' ) ) {
            Capsule::schema()->create( 'customer_meta', function( $table ) {
                $table->increments('id');
                $table->integer( 'customer_id' )->unsigned();
                $table->string( 'key' );
                $table->text( 'value' );
                $table->timestamps();

                $table->foreign( 'customer_id' )->references( 'id' )->on( 'customers' )->onDelete( 'cascade' );
            });
        }*/

        if ( ! Capsule::schema()->hasTable( 'themes' ) ) {
            Capsule::schema()->create( 'themes', function( $table ) {
                $table->bigIncrements( 'id' );
                $table->text( 'url' );
                $table->text( 'screenshot' );
                $table->string( 'classification' );
                $table->text( 'envato_url' );
                $table->text( 'envato_image_url' );
                $table->timestamps();
            });
        }

        if ( ! Capsule::schema()->hasTable( 'status' ) ) {
            Capsule::schema()->create( 'status', function( $table ) {
                $table->bigIncrements( 'id' );
                $table->string( 'name' );
                $table->text( 'description' );
                $table->timestamps();
            });

            \DB::table('status')->insert( array(
                array(
                    'name' => 'Obetald',
                    'description' => 'Kunden har ej betalat än.'
                ),
                array(
                    'name' => 'Påbörjad',
                    'description' => 'Kunden har betalat och arbete påbörjas.'
                ),
                array(
                    'name' => 'Färdig',
                    'description' => 'Projektet är färdigt.'
                )
            ) );
        }

        if ( ! Capsule::schema()->hasTable( 'projects' ) ) {
            Capsule::schema()->create( 'projects', function( $table ) {
                $table->bigIncrements( 'id' );
                $table->bigInteger( 'customer_id' )->unsigned();
                $table->bigInteger( 'handler_id' )->unsigned();
                $table->bigInteger( 'theme_id' )->unsigned();
                $table->string( 'hash' );
                $table->tinyInteger( 'percentage' );
                $table->boolean( 'confirmed' )->default( FALSE );
                $table->bigInteger( 'status_id' )->unsigned();
                $table->timestamps();

                //$table->foreign( 'customer_id' )->references( 'id' )->on( 'customers' );
                //$table->foreign( 'handler_id' )->references( 'ID' )->on( 'users' );
                //$table->foreign( 'theme_id' )->references( 'id' )->on( 'themes' );
            });

            Capsule::schema()->table( 'projects', function( $table ) {
                $table->foreign( 'customer_id' )->references( 'id' )->on( 'customers' );
                $table->foreign( 'handler_id' )->references( 'ID' )->on( 'users' );
                $table->foreign( 'theme_id' )->references( 'id' )->on( 'themes' );
                $table->foreign( 'status_id' )->references( 'id' )->on( 'status' );
            });
        }

        if ( ! Capsule::schema()->hasTable( 'project_products' ) ) {
            Capsule::schema()->create( 'project_products', function( $table ) {
                $table->bigIncrements( 'id' );
                $table->bigInteger( 'project_id' )->unsigned();
                $table->string( 'name' );
                $table->text( 'description' );
                $table->decimal( 'price', 10, 2 );
                $table->integer( 'qty' )->unsigned();
                $table->timestamps();

                //$table->foreign( 'project_id' )->references( 'id' )->on( 'projects' )->onDelete( 'cascade' );
            });

            Capsule::schema()->table( 'project_products', function( $table ) {
                $table->foreign( 'project_id' )->references( 'id' )->on( 'projects' )->onDelete( 'cascade' );
            });
        }

        if ( ! Capsule::schema()->hasTable( 'project_files' ) ) {
            Capsule::schema()->create( 'project_files', function( $table ) {
                $table->bigIncrements( 'id' );
                $table->bigInteger( 'project_id' )->unsigned();
                $table->text( 'path' );
                $table->text( 'url' );
                $table->timestamps();
            });
        }

        if ( ! Capsule::schema()->hasTable( 'quotes' ) ) {
            Capsule::schema()->create( 'quotes', function( $table ) {
                $table->bigIncrements( 'id' );
                $table->bigInteger( 'project_id' )->unsigned();
                $table->text( 'url' );
                $table->timestamps();

                //$table->foreign( 'project_id' )->references( 'id' )->on( 'projects' )->onDelete( 'cascade' );
            });

            Capsule::schema()->table( 'quotes', function( $table ) {
                $table->foreign( 'project_id' )->references( 'id' )->on( 'projects' )->onDelete( 'cascade' );
            });
        }

        if ( ! Capsule::schema()->hasTable( 'invoices' ) ) {
            Capsule::schema()->create( 'invoices', function( $table ) {
                $table->bigIncrements( 'id' );
                $table->bigInteger( 'project_id' )->unsigned();
                $table->text( 'url' );
                $table->string( 'ocr', 12 )->unique();
                $table->boolean( 'paid' )->default( false );
                $table->timestamps();

                //$table->foreign( 'project_id' )->references( 'id' )->on( 'projects' );
            });

            Capsule::schema()->table( 'invoices', function( $table ) {
                $table->foreign( 'project_id' )->references( 'id' )->on( 'projects' );
            });
        }

        if ( ! Capsule::schema()->hasTable( 'people' ) ) {
            Capsule::schema()->create( 'people', function( $table ) {
                $table->bigIncrements( 'id' );
                $table->string( 'ssn', 12 )->unique();
                $table->string( 'name' );
                $table->string( 'surname' );
                $table->string( 'full_name' );
                $table->dateTime( 'not_before' );
                $table->dateTime( 'not_after' );
                $table->string( 'ip' );
                $table->timestamps();
            } );
        }

        if ( ! Capsule::schema()->hasTable( 'signatures' ) ) {
            Capsule::schema()->create( 'signatures', function( $table ) {
                $table->bigIncrements( 'id' );
                $table->text( 'signature' );
                $table->text( 'ocsp' );
                $table->bigInteger( 'project_id' )->unsigned();
                $table->bigInteger( 'person_id' )->unsigned();
                $table->timestamps();
            } );

            Capsule::schema()->table( 'signatures', function( $table ) {
                $table->foreign( 'project_id' )->references( 'id' )->on( 'projects' );
                $table->foreign( 'person_id' )->references( 'id' )->on( 'people' );
            } );
        }

        return true;
    }

    /**
     * Load the needed dependencies to run the class.
     *
     * @since       1.0.0
     */
    private static function load_dependencies()
    {
        require_once LTS_INCLUDES . 'classes/Util.php';
    }
}