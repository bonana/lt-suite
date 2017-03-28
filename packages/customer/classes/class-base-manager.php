<?php

/**
 * Class to define a skeleton for Manager classes
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     Customer
 * @subpackage  Customer/Classes
 */

namespace Livetime\Customer;

abstract class Base_Manager
{
    /**
     * The plugin BaseDIR
     *
     * @since       1.0.0
     * @var         string                              $plugin_dir     The plugin directory
     */
    protected $plugin_dir = null;

    /**
     * Database class.
     *
     * @since       1.0.0
     * @var         Utils\Classes\DatabaseHandler       $database       The database handler
     */
    //protected static $database = null;

    /**
     * Initialize our class.
     *
     * @since       1.0.0
     */
    public function __construct()
    {
    }

    /**
     * Init the class
     * @param       string                              $plugin_dir     The plugin directory
     * @param       Utils\Classes\DatabaseHandler       $database       The database handler
     */
    public function init( $plugin_dir/*, $database*/ )
    {
        if ( !self::$plugin_dir )
            $this->plugin_dir = $plugin_dir;
    }
}