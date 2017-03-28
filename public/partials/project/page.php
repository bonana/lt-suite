<?php
/**
 * View for viewing a project overview.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Public/Partials/Project
 */

namespace Livetime;

if ( ! defined( 'ABSPATH' ) ) die;

// BUILD SHORTCODE
$shortcode_builder = "[livetime_suite_project_overview";

if ( !empty( get_query_var( 'livetime-suite-hash' ) ) )
    $shortcode_builder .= " hash='" . get_query_var( 'livetime-suite-hash' ) . "'";

$shortcode_builder .= "]";

get_header();
?>
<div id="content" class="site-content" role="main">
    <?php echo do_shortcode( $shortcode_builder ); ?>
</div>
<?php

get_footer();