<?php
/**
 * View for displaying Envato searches.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Templates
 */

if ( ! defined( 'ABSPATH' ) ) die;

get_header();

$shortcode_builder = "[livetime_suite_envato";

if ( !empty( get_query_var( 'envato-id' ) ) )
    $shortcode_builder .= " id='" . get_query_var( 'envato-id' ) . "'";

if ( !empty( get_query_var( 'envato-term' ) ) )
    $shortcode_builder .= " term=" . get_query_var( 'envato-term' );

if ( !empty( get_query_var( 'envato-site' ) ) )
    $shortcode_builder .= " site=" . get_query_var( 'envato-site' );

if ( !empty( get_query_var( 'envato-page' ) ) )
    $shortcode_builder .= " page=" . get_query_var( 'envato-page' );

$shortcode_builder .= "]";
?>
<!--<div id="content" class="site-content" role="main">-->
    <?php echo do_shortcode( $shortcode_builder ); ?>
<!--</div>-->

<?php get_footer(); ?>