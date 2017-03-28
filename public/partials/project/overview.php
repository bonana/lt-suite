<?php
/**
 * Template to display a project overview.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Pulbic/partials/Project
 */

namespace Livetime;

if ( ! defined( 'ABSPATH' ) ) die;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
        <header class="entry-header">
            <?php echo the_title( '<h1 class="entry-title">', '</h1>', false ); ?>
            <p>Hejsan <?php echo esc_html( $customer->contacts->first()->name ); ?>. <?php echo esc_html( $staff->display_name ); ?> har bjudit in dig till vår kampanj <span class="color-brand text-bold">Once in a Livetime</span>. Vänligen läs igenom vad kampanjen innebär och på vilka villkor. Vid frågor så tveka inte på att kontakta din projektledare. Du kan när som helst enkelt signera avtal med BankID.</p>
        </header>
        <section class="row">
            <div class="column-3">
                <header class="row-header">
                    <img class="content-img" src="<?php echo get_template_directory_uri() . '/images/webmail/content.png'; ?>" alt="Livetime Content">
                </header>
            </div>
            <div class="column-9">
                <div class="row-content" style="padding-top: 20px;">
                    <p class="text-left">Once in a Livetime innefattar vårt nylanserade koncept. Vi hittar tillsammans med dig ett tema som passar eran verksamhet. Vi visualliserar oss dina kunders behov och anpassar design med kod efter faktorer så som, användarvänlighet, tillgänglighet och varumärkesprofil. Eftersom vi bara behöver programmera tillägg till det ursprungliga temat så kan vi hålla ner produktionstiden och kostnaden markant. Vi applicerar sedan en sökmotoroptimering på innehållet för att hjälpa hemsidan att bli mer relevant hos sökmotorer. Oroa dig inte för länkar! Vi tänker på allt och din hemsida vilar tryggt hos Binero med våran översyn. Vi tar hand om allt det där som du inte har tid med.</p>
                    <a class="btn web-email-btn" href="<?php echo esc_url( $envato->normalized_url ); ?>"><i class="dslc-icon-ext-basic_eye"></i> Öppna demo</a>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="column-12">
                <header class="row-header">
                    <h2 class="row-title">Vilket tema vill du ha?</h2>
                </header>
                <div class="row-content">
                    <p>Känner du dig nöjd med den design som <?php echo esc_html( explode( ' ', $staff->display_name )[0] ); ?> valt ut? Det finns 26,286 teman i Themeforest lager att välja mellan.</p>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="column-6">
                <header class="row-header">
                    <h2 class="row-title">Utvalt tema</h2>
                </header>
                <div class="row-content chosen-theme">
                    <div class="row-thumbnail-container">
                        <div class="row-thumbnail-checkmark"><span>&#10004;</span></div>
                        <img class="row-thumbnail" src="<?php echo esc_url( $project->theme->envato_image_url ); ?>" alt="Theme Preview">
                        <ul class="row-theme-navigation clear">
                            <li><a class="demo-link" href="<?php echo esc_url ( $envato->normalized_url ); ?>" target="_blank"><i class="dslc-icon-ext-basic_eye"></i> <?php _e( 'Öppna demo', 'livetime-suite' ); ?></a></li>
                            <li><a href="#"><i class="dslc-icon-ext-graduation"></i> <?php _e( 'Användarvillkor', 'livetime-suite' ); ?></a></li>
                        </ul>
                    </div>
                    <div class="row-info">
                        <h3 class="row-info-title"><?php echo esc_html( $envato->name ); ?></h3>
                        <ul class="row-info-list">
                            <?php $envato->attributes = array_filter( $envato->attributes, function( $item ) { if ( !empty( $item->value ) ) return true; else return false; } ); ?>
                            <?php foreach( $envato->attributes as $attribute ) : ?>
                                <li><strong><?php echo esc_html( $attribute->label ); ?>:</strong> <?php echo ( is_array( $attribute->value ) ? implode( ', ', $attribute->value ) : $attribute->value ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="column-6">
                <header class="row-header">
                    <h2 class="row-title"><?php _e( 'Andra förslag', 'livetime-suite' ); ?></h2>
                </header>
                <?php foreach ( $suggested_products->matches as $suggested_product ) : ?>
                    <div class="row-content suggested-product">
                        <div class="row-thumbnail-container">
                            <div class="loading-overlay"><span class="loading-pulse"></span></div>
                            <img class="row-thumbnail" src="<?php echo esc_url( Includes\Util::get_envato_image( $suggested_product->previews ) ); ?>" alt="Theme Preview">
                            <ul class="row-theme-navigation clear">
                                <li class="small"><a class="theme-select" href="<?php echo esc_url( 'http://livetime.nu/valj-tema' ); ?>" data-theme-url="<?php echo esc_url( $suggested_product->url ); ?>" data-site-url="<?php echo esc_url( $suggested_product->normalized_url ); ?>"><i class="dslc-icon-ext-square-check"></i> <?php _e( 'Välj tema', 'livetime-suite' ); ?></a></li>
                                <li class="small"><a href="<?php echo esc_url( $suggested_product->normalized_url ); ?>" target="_blank"><i class="dslc-icon-ext-basic_eye"></i> <?php _e( 'Öppna demo', 'livetime-suite' ); ?></a></li>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if ( !empty( $suggested_products->links->next_page_url ) ) : ?>
                    <div class="row-content">
                        <a id="envato-suggest-btn" class="btn web-email-btn" data-next-page="<?php echo $suggested_products->links->next_page_url; ?>"><i class="dslc-icon-ext-refresh"></i> <?php _e( 'Ge mig nya förslag', 'livetime-suite' ); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <section class="row">
            <div class="column-12">
                <header class="row-header">
                    <h2 class="row-title"><?php _e( 'Vilka funktioner behöver du &amp; din kunder?' ); ?></h2>
                </header>
                <div class="row-content" style="margin: 0 0 50px;">
                    <p>Nu när ditt tema är spikat så riktar vi oss mot dina kunder. Hur kan hemsidan förenkla konsumentresan? Hur kan hemsidan förenkla eran arbetsdag? Det finns oftast flera olika bra och smarta lösningar man kan progremmera.</p>
                </div>
            </div>
            <div class="column-6">
                <p class="text-left">Våra behovsanalyser hjälper dig att summera vilka funktioner som är behövliga. Vi delar även vår kreativitet för att tillsammans med dig nå påhittiga och nyttiga lösningar. Att optimera processer internt genom att automatisera dem kan he en mängd synergieffekter på hela organisationen. Vi uppmuntrar nytänk och utvecklar gärna dina skräddarsydda lösnignar. Vi har inga problem med att programmera anslutningar mot tredje part. Vi har lösningar för samtliga betalningsalternativ färdiga och kan snabbt installera dessa åt dig. Vi hjälper dig med hela ledet så att det varken är energi eller tidskrävande. Det du inte hunnit tänka på, har vi redan en plan för.</p>
            </div>
            <div class="column-3">
                <ul class="row-service-list text-left">
                    <li><?php _e( 'Betalningsalternativ?', 'livetime-suite' ); ?></li>
                    <li><?php _e( 'Kassasystem?', 'livetime-suite' ); ?></li>
                    <li><?php _e( 'Logistiklösning?', 'livetime-suite' ); ?></li>
                    <li><?php _e( 'Faktureringsprogram?', 'livetime-suite' ); ?></li>
                    <li><?php _e( 'Avtalshantering?', 'livetime-suite' ); ?></li>
                    <li><?php _e( 'Informationshantering?', 'livetime-suite' ); ?></li>
                    <li><?php _e( 'Kommunikation?', 'livetime-suite' ); ?></li>
                    <li><?php _e( 'Affärssystem', 'livetime-suite' ); ?></li>
                    <li><?php _e( 'Bokningssystem?', 'livetime-suite' ); ?></li>
                </ul>
            </div>
            <div class="column-3 show-for-large">
                <header class="row-header">
                    <img class="content-img" src="<?php echo get_template_directory_uri() . '/images/webmail/services.png'; ?>" alt="Tjänster">
                </header>
            </div>
        </section>
        <section class="row" style="margin-bottom: 120px;">
            <div class="column-12">
                <header class="row-header">
                    <h2 class="row-title" style="margin: 0 0 90px;">Vi tänker också på</h2>
                </header>
            </div>

            <div class="row">
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/license.png'; ?>" alt="Licens">
                    <h4 class="row-heading">Licenser</h4>
                    <p>Alla bilder och filer med licenser så att du alltid kan känna dig säker.</p>
                </div>
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/security.png'; ?>" alt="Säkerhet">
                    <h4 class="row-heading">Säkerhet</h4>
                    <p>Vi tar säkerhetskopieringar var tredje timme.</p>
                </div>
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/statistics.png'; ?>" alt="Statistik">
                    <h4 class="row-heading">Statistik</h4>
                    <p>Vi installerar Google Analytics så att du har koll på dina besökare.</p>
                </div>
            </div>

            <div class="row">
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/support.png'; ?>" alt="Support">
                    <h4 class="row-heading">Support</h4>
                    <p>Personlig projektledare för att snabbt få svar på dina frågor.</p>
                </div>
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/admin.png'; ?>" alt="Administrationspanel">
                    <h4 class="row-heading">Administrationspanel</h4>
                    <p>Panel där du kan uppdatera och hantera innehållet på hemsidan.</p>
                </div>
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/seo.png'; ?>" alt="Sökmotoroptimering">
                    <h4 class="row-heading">Sökmotoroptimering</h4>
                    <p>Vi installerar Yoast och optimerar innehållet på hemsidan åt dig.</p>
                </div>
            </div>

            <div class="row">
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/domain.png'; ?>" alt="Domänhantering">
                    <h4 class="row-heading">Domän &amp; Länkhantering</h4>
                    <p>Vi hjälper till med att rikta om aktuella domäner och bevara länkar.</p>
                </div>
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/import.png'; ?>" alt="Säkerhet">
                    <h4 class="row-heading">Importering</h4>
                    <p>Vi hjälper till med att importera produkter och information.</p>
                </div>
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/webhotel.png'; ?>" alt="Webbhotell">
                    <h4 class="row-heading">Webbhotell</h4>
                    <p>Vi övervakar och låter din hemsida parkera hos oss.</p>
                </div>
            </div>

            <div class="row">
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/ecommerce.png'; ?>" alt="E-handel">
                    <h4 class="row-heading">E-handel</h4>
                    <p>Om du önskar e-handelsprogram installerat så hjälper vi dig.</p>
                </div>
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/payment.png'; ?>" alt="Betalningsalternativ">
                    <h4 class="row-heading">Betalningsalternativ</h4>
                    <p>Vi hjälper dig med att installera de betalningsalternativ som önskas.</p>
                </div>
                <div class="column-4">
                    <img class="row-icon" width="100" height="62" src="<?php echo get_template_directory_uri() . '/images/webmail/logistics.png'; ?>" alt="Logistik">
                    <h4 class="row-heading">Logistik</h4>
                    <p>Vi erbjuder våran hjälp med att hitta bästa lösning för din logistik.</p>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="column-12">
                <ul class="row-button-list">
                    <li class="column-6 text-right"><a id="contract-btn" class="btn web-email-btn" href="#"><i class="dslc-icon-ext-graduation"></i> <?php _e( 'Avtalsvillkor', 'livetime-suite' ); ?></a></li>
                    <li class="column-6 text-left"><a class="btn web-email-btn" href="<?php echo $project->quotes->first()->url; ?>"><i class="dslc-icon-ext-download"></i> <?php _e( 'Ladda ner offert', 'livetime-suite' ); ?></a></li>
                </ul>
            </div>
        </section>
        <section class="row">
            <div class="column-12">
                <header class="row-header">
                    <h2 class="row-title"><?php _e( 'Hur vill du betala?', 'livetime-suite' ); ?></h2>
                </header>
            </div>
            <div class="column-12" style="margin: 0 0 60px;">
                <div class="row-content">
                    <ul class="row-payment-list">
                        <li>
                            <label>
                                <input type="checkbox" id="payment-option" name="payment-option" value="1">
                                Faktura
                            </label>
                        </li>
                        <li>
                            <label class="disabled">
                                <div class="coming-soon-tooltip">Kommer snart</div>
                                <input disabled type="checkbox" name="livetime-suite-payment-option" value="stripe">
                                Kortbetalning
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="column-12 sign-form">
                <div class="row-content">
                    <input type="hidden" name="project-hash" id="project-hash" value="<?php echo $project->hash; ?>">
                    <button type="submit" id="sign-btn" class="btn web-email-btn web-email-bankid-btn">Godkänn</button>
                </div>
            </div>
            <!--<div class="column-12 bankid-form">
                <div class="row-content">
                    <input type="hidden" name="livetime-suite-project-hash" id="livetime-suite-project-hash" value="<?php echo $project->hash; ?>">
                    <input type="text" name="livetime-suite-personal-number" id="livetime-suite-personal-number" placeholder="Personnummer">
                    <a class="btn web-email-btn web-email-bankid-btn" href="#"><img src="<?php echo get_template_directory_uri() . '/images/webmail/bankid.png'; ?>"> <span><?php _e( 'Signera avtal', 'livetime-suite' ); ?></span></a>
                </div>
                <div class="loading-overlay">
                    <div class="loading-pulse"></div>
                    <div id="bankid-info-tooltip" class="loading-text">&nbsp;</div>
                </div>
            </div>-->
        </section>
    </div><!-- .entry-content -->
</article><!-- #post-## -->