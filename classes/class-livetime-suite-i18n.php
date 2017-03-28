<?php

/**
 * Class to handle internationalization of the plugin.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Classes
 */

namespace Livetime;

class Livetime_Suite_i18n
{
    /**
     * Load plugin text domain so we can translate.
     *
     * @since       1.0.0
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            'livetime-suite',
            false,
            LTS_BASE . 'languages/'
        );
    }
}