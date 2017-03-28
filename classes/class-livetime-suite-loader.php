<?php

/**
 * Class that handles loading and registering of all our hooks to WordPress.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Classes
 */

namespace Livetime;

class Livetime_Suite_Loader
{
    /**
     * The array of actions registered with WordPress.
     *
     * @since       1.0.0
     * @access      protected
     * @var         array       $actions        The actions registered with WordPress to fire when the plugin loads.
     */
    protected $actions;

    /**
     * The array of filters registered with WordPress
     *
     * @since       1.0.0
     * @access      protected
     * @var         array       $filters        The filters registered with WordPress to fire when the plugin loads.
     */
    protected $filters;

    /**
     * Initialize our collections
     *
     * @since       1.0.0
     */
    public function __construct()
    {
        $this->actions = array();
        $this->filters = array();
    }

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @since       1.0.0
     * @param       string      $hook           The name of the WordPress action that is being registered.
     * @param       object      $component      A reference to the instance of the object on which the action is defined.
     * @param       string      $callback       The name of the function definition on the $component.
     * @param       int         $priority       Optional. The priority at which the function should be fired. Default is 10.
     * @param       int         $accepted_args  Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 )
    {
        $this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @since       1.0.0
     * @param       string      $hook           The name of the WordPress filter that is being registered.
     * @param       object      $component      A reference to the instance of the object on which the filter is defined.
     * @param       string      $callback       The name of the function definition on the $copmonent.
     * @param       int         $priority       Optional. The priority at which the function should be fired. Default is 10.
     * @param       int         $accepted_args  Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 )
    {
        $this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
    }

    /**
     * Utility function to add either an action or filter.
     *
     * @since       1.0.0
     * @access      protected
     * @param       array       $hooks          The collection of hooks that is being registered(either actions or filter).
     * @param       string      $hook           The name of the WordPress action/filter that is being registered.
     * @param       object      $component      A reference to the instance of the object on which the filter is defined.
     * @param       string      $callback       The name of the function definition on the $component.
     * @param       int         $priority       The priority at which the function should be fired.
     * @param       int         $accepted_args  The number of arguments that should be passed to $callback.
     * @return      array                       The collection of actions or filters that is being registered with WordPress
     */
    public function add( $hooks, $hook, $component, $callback, $priority, $accepted_args )
    {
        $hooks[] = array(
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args
        );

        return $hooks;
    }

    /**
     * Execute the loading and register all the filters and actions with WordPress.
     *
     * @since       1.0.0
     */
    public function run()
    {
        foreach ( $this->filters as $hook ) {
            add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }

        foreach ( $this->actions as $hook ) {
            add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }
    }
}