<?php
/**
 * View for displaying envato searches.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Public/Partials/Envato
 */

namespace Livetime;
?>
<div class="envato-search-container">
    <div class="envato-search-meta cf">
        <h1><?php _e( 'Visar resultat för: ', 'livetime-suite' ); ?><?php echo $term; ?></h1>
        <form method="GET" action="" style="position: relative;">
            <input type="text" name="envato-search-term" id="envato-search-term">
            <button type="submit" class="envato-btn-search"><i class="dslc-icon-ext-basic_magnifier"></i></button>
        </form>
    </div>
    <div class="envato-search-items">
    <?php foreach ( $results->matches as $match ) : ?>
        <div class="envato-item"><a href="<?php echo get_site_url() . '/envato/' . $match->id; ?>">
            <div class="preview" style="background-image: url('<?php echo Includes\Util::get_envato_image( $match->previews ); ?>');"></div>
            <div class="envato-item-meta">
                <div class="envato-info">
                    <?php $title_suffix = strlen( $match->name ) > 50 ? '...' : ''; ?>
                    <h3 class="envato-item-title"><?php echo substr( $match->name, 0, 50 ) . $title_suffix; ?></h3>
                    <?php $stripped_description = wp_strip_all_tags( $match->description ); ?>
                    <?php $description_suffix = strlen( $stripped_description ) > 440 ? '...' : ''; ?>
                    <p class="envato-item-description"><?php echo substr( $stripped_description, 0, 440 ) . $description_suffix; ?></p>
                </div>
                <div class="envato-dates">
                    <div class="created">
                        <h4 class="title"><?php _e( 'Skapad', 'livetime-suite' ); ?></h4>
                        <div class="date"><?php echo Includes\Util::format_date( $match->published_at ); ?></div>
                    </div>
                    <div class="updated">
                        <h4 class="title"><?php _e( 'Uppdaterad', 'livetime-suite' ); ?></h4>
                        <div class="date"><?php echo Includes\Util::format_date( $match->updated_at ); ?></div>
                    </div>
                </div>
            </div>
            <div class="envato-tooltip">
                <img src="<?php echo Includes\Util::get_envato_image( $match->previews ); ?>" alt="<?php echo $match->name; ?>">
                <div class="envato-tooltip-meta">
                    <h3><?php echo $match->name; ?></h3>
                    <p class="classification"><?php echo $match->classification; ?></p>
                </div>
            </div>
        </a>
        </div><!-- .envato-item -->
    <?php endforeach; ?>
    </div>
    <?php
        if ( $results->total_hits > 30 && $results->links ) {
            echo Includes\Util::get_envato_pagination( $page, $term, $site, $results->total_hits );
        }
    ?>
</div>