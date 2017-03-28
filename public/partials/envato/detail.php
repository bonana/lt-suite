<?php
/**
 * View for detail page of an envato object.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Public/Partials
 */

namespace Livetime;
?>
<div class="envato-detail-container cf">
<?php print_r( $match ) ; ?>
    <h1 class="envato-search-meta"><?php echo esc_html( $match->name ); ?></h1>
    <div class="envato-preview-container" envato-x-container">
        <div class="envato-preview" style="background-image: url('<?php echo Includes\Util::get_envato_image( $match->previews ); ?>');"></div>
        <?php if ( isset( $match->previews->live_site ) ) : ?>
            <div class="envato-preview-button"><a href="<?php echo esc_url( $match->normalized_url ); ?>" target="_blank"><?php _e( 'Förhandsgranska', 'livetime-suite' ); ?></a>
            </div>
        <?php endif; ?>
        <div class="envato-detail-description"><?php echo $match->description; ?></div>
    </div><!-- .enato-preview-container -->
    <div class="envato-buy-container envato-x-container cf">
        <input type="hidden" id="envato_link" name="envato_link" value="<?php echo $match->url; ?>">
        <h3 class="price-header">Produktpris</h3><h3 class="price"><span class="text-bold"><?php echo ceil( Includes\Util::convert_currency( $match->price_cents / 100, 'USD', 'SEK' ) ); ?></span>SEK</h3>
        <div class="cf">
            <div class="envato-btn-generic envato-btn-license"><i class="dslc-icon-ext-document"></i>&nbsp;<?php _e( 'Licensvillkor', 'livetime-suite' ); ?></div>
            <a class="envato-btn-generic envato-btn-buy product_type_simple add_to_cart_button ajax_add_to_cart" rel="nofollow" hreF="?add-to-cart=2252" data-quantity="1" data-product_id="2252" data-product_sku=""><div class="loading-overlay"><div class="loading-pulse"></div></div><i class="dslc-icon-ext-ecommerce_creditcard"></i>&nbsp;<?php _e( 'Beställ', 'livetime-suite' ); ?></a>
        </div>
    </div><!-- .envato-buy-container -->

    <!-- TAG START -->
    <div class="envato-tag-container envato-x-container">
        <div class="envato-tag-item">
            <div class="envato-tag-header"><?php _e( 'Skapad', 'livetime-suite' ); ?></div>
            <div class="envato-tag-value"><?php echo Includes\Util::format_date( $match->published_at ); ?></div>
        </div>
        <div class="envato-tag-item">
            <div class="envato-tag-header"><?php _e( 'Uppdaterad', 'livetime-suite' ); ?></div>
            <div class="envato-tag-value"><?php echo Includes\Util::format_date( $match->updated_at ); ?></div>
        </div>
        <?php foreach ( $match->attributes as $attribute ) : ?>
            <?php $attribute->value = ( is_array( $attribute->value ) ? implode( ', ', $attribute->value ) : $attribute->value ); ?>
            <div class="envato-tag-item">
                <div class="envato-tag-header"><?php echo Includes\Util::translate_attribute( $attribute->label ); ?></div>
                <div class="envato-tag-value"><?php echo $attribute->value; ?></div>
            </div>
        <?php endforeach; ?>
        <div class="envato-tag-item">
            <div class="envato-tag-header"><?php _e( 'Taggar', 'livetime-suite' ); ?></div>
            <div class="envato-tag-value"><?php echo implode( ', ', $match->tags ); ?></div>
        </div>
    </div><!-- .envato-tag-container -->
    <!-- TAG END -->

    <!-- RELATED TAGS START -->
    <div class="envato-tag-container envato-x-container clear-right">
        <h3><?php _e( 'Relaterade produkter' ); ?></h3>
        <?php foreach ( $related->matches as $related_match ) : ?>
            <div class="envato-related-product">
                <div class="preview" style="background-image: url('<?php echo Includes\Util::get_envato_image( $related_match->previews ); ?>');"></div>
                <?php $name_suffix = strlen( $related_match->name ) > 40 ? '...' : ''; ?>
                <h4><?php echo substr( $related_match->name, 0, 40 ) . $name_suffix; ?></h4>
                <div class="price"><?php echo Includes\Util::get_envato_site_type( $related_match->site ); ?></div>
            </div>
        <?php endforeach; ?>
    </div><!-- .envato-tag-container -->
    <!-- RELATED TAGS END -->
    
</div><!-- .envato-detail-container -->