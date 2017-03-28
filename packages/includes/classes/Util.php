<?php

/**
 * Util class containing various util functions used through our various packages
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     Util
 * @subpackage  Util/Classes
 */

namespace Livetime\Includes;

class Util
{
    protected static $file_sizes = array(
        'bytes',
        'KB',
        'MB',
        'GB',
        'TB'
    );

    /**
     * Database Capsule
     *
     * @since       1.0.0
     * @var         Illuminate\Database\Capsule\Manager     $capsule        The database capsule
     */
    protected static $capsule = null;

    /**
     * Function to render PHP files into HTML
     *
     * @since       1.0.0
     * @param       string      $file       Path to file to render
     * @param       array       $data       Array containing all the data that is needed in the rendered file.
     * @return      null/html               Returns null if file doesn't exist. Else return rendered HTML.
     */
    public static function render_php( $file, $data )
    {
        if ( file_exists( $file ) ) {
            ob_start();

            extract( $data );
            include( $file );

            $html = ob_get_clean();

            return $html;
        }

        return null;
    }

    /**
     * Return the database capsule if existing.
     *
     * @since       1.0.0
     * @return      Database capsule
     */
    public static function get_capsule()
    {
        return self::$capsule;
    }

    /**
     * Function to initialize the database and Eloquent for the current session.
     *
     * @since       1.0.0
     * @return      bool        Returns whether or not the database setup was successful.
     */
    public static function init_database()
    {
        if ( !self::$capsule )
        {
            try {
                self::$capsule = new \Illuminate\Database\Capsule\Manager();

                self::$capsule->addConnection([
                    'driver' => 'mysql',
                    'host' => DB_HOST,
                    'database' => DB_NAME,
                    'username' => DB_USER,
                    'password' => DB_PASSWORD,
                    'charset' => DB_CHARSET,
                    'collation' => DB_COLLATE,
                    'prefix' => 'wp_'
                ]);
                self::$capsule->setAsGlobal();
                self::$capsule->bootEloquent();

                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate POST input.
     *
     * @since       1.0.0
     * @param       array       $post       The POST array.
     * @param       array       $rules      List of rules to pass.
     */
    public static function validate( $post, $rules )
    {
        if ( empty( $post ) ) return false;

        foreach ( $rules as $field => $rule ) {
            if ( empty( $post[$field] ) ) return false;

            $post_fields = (is_array( $post[$field] ) ? $post[$field] : array( $post[$field] ));

            foreach ( $post_fields as $post_field ) {
                $post_field = strtolower( trim( $post_field ) );

                echo $rule;

                switch ( $rule )
                {
                    case 'allow':
                        break;
                    case 'name':
                        if ( !preg_match( '/^[a-zåäö]+$/', $post_field ) ) return false;
                        break;
                    case 'email':
                        if ( !preg_match( '/^([a-zåäö0-9_\.-]+)@([\da-zåäö\.-]+)\.([a-z\.]{2,6})$/', $post_field ) ) return false;
                        break;
                    case 'number':
                        if ( !preg_match( '/^[0-9]+$/', $post_field ) ) return false;
                        break;
                    case 'orgnr':
                        if ( !preg_match( '/^[0-9]{6}-?[0-9]{4}$/', $post_field ) ) return false;
                        break;
                    case 'postal':
                        if ( !preg_match( '/^[0-9]{3}[ -]?[0-9]{2}$/', $post_field ) ) return false;
                        break;
                    case 'url':
                        if ( !preg_match( '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iu', $post_field ) ) return false;
                        break;
                    default:
                        break;
                }
            }
        }

        return true;
    }

    /**
     * Sanitize text input.
     *
     * @since       1.0.0
     * @param       string      $input      The input to sanitize.
     * @return      string                  Sanitizied version of $input
     */
    public static function stf( $input )
    {
        return sanitize_text_field( $input );
    }

    /**
     * Get current WordPress user.
     *
     * @since       1.0.0
     * @return      object      The current WordPress user object.
     */
    public static function get_current_user()
    {
        $user = wp_get_current_user();
        $user->phone = get_user_meta($user->ID, 'phone', true);

        return $user;
    }

    /**
     * Get specific WordPress user.
     *
     * @since       1.0.0
     * @return      object      The specified WordPress user.
     */
    public static function get_user( $id )
    {
        $user = get_userdata( $id );
        $user->phone = get_user_meta( $id, 'phone', true );

        return $user;
    }

    /**
     * Get recent WordPress posts.
     *
     * @since       1.0.0
     * @param       int     $num            Optional. The number of posts to get. Default 1.
     * @return      array                   Returns an array of posts.
     */
    public static function get_recent_posts( $num = 1, $filter = false )
    {
        $recent_posts = wp_get_recent_posts( [
            'numberposts' => $num,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish'
        ], OBJECT );

        if ( $filter ) {
            foreach ( $recent_posts as $recent_post ) {
                $recent_post->post_excerpt = substr( wp_strip_all_tags( $recent_post->post_content ), 0, 340) . '...';
                $recent_post->post_url     = get_permalink( $recent_post->ID );
            }
        }

        return $recent_posts;
    }

    /**
     * Get recent testimonials.
     *
     * @since       1.0.0
     * @param       int     $num            Optional. The number of testimonials to get. Default 1.
     * @return      array                   Returns either an array of testimonials or one testiomial object.
     */
    public static function get_recent_testimonials( $num = 1 )
    {
        $testimonials = wp_get_recent_posts( [
            'numberposts' => $num,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish'
        ], OBJECT );

        foreach ( $testimonials as $testimonial ) {
            $testimonial->thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id( $testimonial->ID ) );
            $testimonial->company_name = get_post_meta( $testimonial->ID, 'lt_company_name', true );
        }

        if ( count( $testimonials ) === 1 )
            return $testimonials[0];

        return $testimonials;
    }

    /**
     * Get thumbnail for post.
     *
     * @since       1.0.0
     * @param       object      $post       The post the get the thumbnail from.
     * @return      string                  URL to post thumbnail.
     */
    public static function get_post_thumbnail( $post )
    {
        return wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
    }

    /**
     * Check if theme contains shop or not.
     *
     * @since       1.0.0
     * @param       Models\Theme    $theme      The theme to check.
     * @return      bool                        Returns true if the theme contains a shop.
     */
    public static function is_theme_shop( $theme )
    {
        $is_shop = false;

        if ( $theme->classification != NULL ) {
            $classifications = array_map( 'strtolower', explode('/', $theme->classification ) );

            if ( in_array( 'ecommerce', $classifications ) )
                $is_shop = true;
        }

        return $is_shop;
    }

    /**
     * Get a theme or create a new one.
     *
     * @since       1.0.0
     * @param       string      $theme_url      URL to the theme demo.
     * @param       string      $envato_url     URL to the envato page for the theme.
     * @return      Theme                       Return a theme model.
     */
    
    public static function get_theme( $theme_url, $envato_url )
    {
        $theme = \Livetime\Models\Theme::where( 'url', '=', $theme_url )->orWhere( 'envato_url', '=', $envato_url )->first();

        if ( !$theme )
        {
            $theme = new \Livetime\Models\Theme();

            $theme->url = $theme_url;
            $theme->screenshot = self::screenshot( $theme_url );

            $theme_info = self::get_theme_info( $envato_url );

            $theme->classification = $theme_info['classification'];
            $theme->envato_url = $envato_url;
            $theme->envato_image_url = $theme_info['image'];
            $theme->save();
        }
        else if ( $theme->screenshot == 'light' )
        {
            $theme->screenshot = self::screenshot( $theme_url );
            $theme->save();
        }

        return $theme;
    }

    /**
     * Get a theme without screenshoting or create one.
     *
     * @since       1.0.0
     * @param       string      $theme_url      URL to the theme demo.
     * @param       string      $envato_url     URL to the envato page for the theme.
     * @return      Theme                       Return a theme model.
     */
    public static function get_theme_light( $theme_url, $envato_url )
    {
        $theme = \Livetime\Models\Theme::where( 'url', '=', $theme_url )->orWhere( 'envato_url', '=', $envato_url )->first();

        if ( !$theme )
        {
            $theme = new \Livetime\Models\Theme();

            $theme->url = $theme_url;
            $theme->screenshot = 'light';

            $theme_info = self::get_theme_info( $envato_url );

            $theme->classification = $theme_info['classification'];
            $theme->envato_url = $envato_url;
            $theme->envato_image_url = $theme_info['image'];
            $theme->save();
        }

        return $theme;
    }

    /**
     * Create screeenshot of website.
     *
     * @since       1.0.0
     * @param       string      $url        The page to screenshot.
     * @return      string                  URL to the screenshot.
     */
    private static function screenshot( $url )
    {
        //if ( !self::validate( array( 'url' => $url ), array( 'url' => 'url' ) ) ) return 'http://livetime.nu';
        
        $exec_path = LTS_BASE . 'bin/phantomjs';
        $javascript_path = LTS_BASE . 'assets/rasterize.js';

        $file_path = LTS_BASE . 'screenshots/' . md5( $url ) . '.jpg';
        $file_url = LTS_BASE_URL . 'screenshots/' . md5( $url ) . '.jpg';

        $exec = $exec_path . ' ' . $javascript_path . ' ' . $url . ' ' . $file_path . ' 1920px*1080px';

        exec( $exec );
        exec( "/usr/bin/convert {$file_path} -fill black -colorize 85% {$file_path}" );

        return $file_url;
        /*if ( !self::validate( array( 'url' => $url ), array( 'url' => 'url' ) ) ) return 'http://livetime.nu';

        $file_path = LTS_BASE . 'screenshots/' . md5( $url ) . '.jpg';
        $file_url = LTS_BASE_URL . 'screenshots/' . md5( $url ) . '.jpg';

        $screenshot_api_endpoint = "http://api.screenshotlayer.com/api/capture?access_key=705da17449ecbe9db9e383ca09c724fa&url={$url}&viewport=1440x900&width=825";

        copy( $screenshot_api_endpoint, $file_path );
        //exec( "/usr/bin/convert {$file_path} -fill black -colorize 85% {$file_path}");

        return $file_url;*/
    }

    /**
     * Get theme info.
     *
     * @since       1.0.0
     * @param       string      $url        The envato theme URL to check.
     * @return      array                  The full classification of item.
     */
    private static function get_theme_info( $url )
    {
        $envato_info = array(
            'classification' => null,
            'image' => null
        );

        $envato_id = self::get_envato_id( $url );

        if ( $envato_id !== null ) {
            $envato_endpoint = "https://api.envato.com/v3/market/catalog/item?id={$envato_id}";

            $client = new \GuzzleHttp\Client();
            $response = $client->request( 'GET', $envato_endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer nVPZ7U6ov6E4VwWY494EAt4J2lQSNTYl'
                ],
                'verify' => false
            ] );

            if ( $response->getStatusCode() == 200 ) {
                $envato_object = json_decode( $response->getBody() );

                $envato_info['classification'] = $envato_object->classification;
                $envato_info['image'] = self::get_envato_image( $envato_object->previews );
            }
        }

        return $envato_info;
    }

    /**
     * Get theme ID from URL.
     *
     * @since       1.0.0
     * @param       string      $url        The envato theme URL to extract from.
     * @return      string                  The ID of the theme.
     */
    public static function get_envato_id( $url )
    {
        $url = explode( '?', $url );
        $url = $url[0];
        $url = explode( '/', $url );
        $url = array_pop( $url );

        return preg_replace( '/\D/', '', $url );
    }

    /**
     * Function to get the most relevant image from the $previews array.
     *
     * @since       1.0.0
     * @param       array       $previews       Array of all the previews.
     * @return      string                      URL to the most relevant image.
     */
    public static function get_envato_image( $previews )
    {
        $image_url = null;

        if ( !empty( $previews->landscape_preview ) )
            $image_url = $previews->landscape_preview->landscape_url;
        else if ( !empty( $previews->thumbnail_preview ) ) {
            if ( !empty( $previews->thumbnail_preview->large_url ) )
                $image_url = $previews->thumbnail_preview->large_url;
            else
                $image_url = $previews->thumbnail_preview->small_url;
        } else if ( !empty( $previews->icon_with_audio_preview ) )
            $image_url = $previews->icon_with_audio_preview->icon_url;
        else if ( !empty( $previews->icon_with_square_preview ) )
            $image_url = $previews->icon_with_square_preview->square_url;
        else if ( !empty( $previews->icon_with_video_preview ) ) {
            if ( !empty( $previews->icon_with_video_preview->landscape_url ) )
                $image_url = $previews->icon_with_video_preview->landscape_url;
            else
                $image_url = $previews->icon_with_video_preview->icon_url;
        }

        return $image_url;
    }

    /**
     * Extract products and return them in a normalized format.
     *
     * @since       1.0.0
     * @param       array       $names          The array of product names.
     * @param       array       $descriptions   The array of products descriptions.
     * @param       array       $prices         The array of product prices.
     * @param       array       $qty            The array of product quantities.
     * @return      array                       Array containing objects of all the products.
     */
    public static function extract_products( $names, $descriptions, $prices, $qty )
    {
        $product_count = count( $names );

        if ( $product_count <= 0 ) return null;

        $products = array();

        for ( $i = 0; $i < $product_count; $i++ ) {
            $product = new \stdClass;

            $product->name          = $names[$i];
            $product->description   = $descriptions[$i];
            $product->price         = $prices[$i];
            $product->qty           = $qty[$i];

            array_push( $products, $product );
        }

        return $products;
    }

    /**
     * Function to convert between currencies.
     *
     * $from/$to takes language code format such as SEK, USD etc.
     *
     * @since       1.0.0
     * @param       string      $amount     The amount of convert.
     * @param       string      $from       The currency to convert from.
     * @param       string      $to         The currency to convert to.
     * @return      string                  The converted amount.
     */
    public static function convert_currency( $amount, $from, $to )
    {
        $api_endpoint = "https://www.google.com/finance/converter?a={$amount}&from={$from}&to={$to}";

        $response = file_get_contents( $api_endpoint );

        preg_match( "/<span class=bld>(.*)<\/span>/", $response, $converted );
        $converted = preg_replace( "/[^0-9.]/", "", $converted[1] );

        return $converted;
    }

    /**
     * Format a date to the correct format.
     *
     * @since       1.0.0
     * @param       string      $date       The date to format.
     * @return      string                  The formatted date.
     */
    public static function format_date( $date )
    {
        $new_date = substr( $date, 0, 10 );
        $new_date = explode( '-', $new_date );
        $new_date = implode( '-', array( $new_date[2], $new_date[1], $new_date[0] ) );
        $new_date = strtotime( $new_date );

        setlocale( LC_TIME, 'sv_SE' );
        return strftime( '%e %B %Y', $new_date );
    }

    /**
     * Get the site type of an envato product.
     *
     * @since       1.0.0
     * @param       string      $site           The site.
     * @return      string                      Site type.
     */
    public static function get_envato_site_type( $site )
    {
        switch ( strtolower( $site ) )
        {
            case 'themeforest.net':
                return 'hemsida';
                break;
            case 'codecanyon.net':
                return 'kod';
                break;
            case 'videohive.net':
                return 'film';
                break;
            case 'audiojungle.net':
                return 'ljud';
                break;
            case 'graphicriver.net':
                return 'grafiskt';
                break;
            case 'photodune.net':
                return 'foto';
                break;
            case '3docean.net':
                return 'modell';
                break;
            default:
                return 'okänt';
                break;
        }
    }

    /**
     * Translate envato attributes.
     *
     * @since       1.0.0
     * @param       string      $key        The key to translate.
     * @return      string                  The translated input.
     */
    public static function translate_attribute( $key )
    {
        $attributes = array(
            'Columns' => 'Kolumner',
            'Compatible Browsers' => 'Kompatibla Webbläsare',
            'Compatible With' => 'Kompatibel Med',
            'Demo URL' => 'Demo URL',
            'Documentation' => 'Dokumentation',
            'High Resolution' => 'Hög Upplösning',
            'Layout' => 'Layout',
            'ThemeForest Files Included' => 'ThemeForest Filer Inkluderade',
            'Tags' => 'Taggar'
        );

        if ( array_key_exists( $key, $attributes ) )
            return $attributes[$key];

        return $key;
    }

    /**
     * Get an envato objectr from a project.
     *
     * @since       1.0.0
     * @param       object              $client         Envato Client.
     * @param       Models\Project      $project        The projec to get envato object from.
     * @return      object                              Envato object.
     */
    public static function get_project_envato( $client, $project )
    {
        return $client->get( self::get_envato_id( $project->theme->envato_url ) );
    }

    /**
     * Get a person from the database or create a new one if none exists.
     *
     * @since       1.0.0
     * @param       object              $person_info    Info about a person.
     * @return      int                                 Returns the persons id.
     */
    public static function get_person( $person_info )
    {
        if ( empty( $person_info ) ) return null;

        $person = \Livetime\Models\Person::where( 'ssn', '=', $person_info->personalNumber )->first();

        if ( !$person ) {
            $person = new \Livetime\Models\Person();

            $person->ssn = $person_info->personalNumber;
            $person->name = $person_info->givenName;
            $person->surname = $person_info->surname;
            $person->full_name = $person_info->name;
            $person->not_before = $person_info->notBefore;
            $person->not_after = $person_info->notAfter;
            $person->ip = $person_info->ipAddress;
            $person->save();
        }

        return $person->id;
    }

    /**
     * Normalize text to UTF-8.
     *
     * @since       1.0.0
     * @param       string      $input      The input to normalize.
     * @return      string                  The input converted to UTF-8
     */
    public static function normalize_text( $input )
    {
        return iconv( mb_detect_encoding( $input, mb_detect_order(), true ), "UTF-8", $input );
    }

    /**
     * Envato pagination.
     *
     * @since       1.0.0
     * @param       int         $page       The current page number.
     * @param       string      $term       The current search term.
     * @param       string      $site       The current site to search on.
     * @param       int         $total      The total number of items.
     * @return      string                  HTML pagination.
     */
    public static function get_envato_pagination( $page = 1, $term = null, $site = null, $total = null )
    {
        if ( !$total ) $total = 1;

        $adjacents = 2;
        $limit = 30;

        $prev = $page - 1;
        $next = $page + 1;
        $last = ceil( $total / $limit );

        if ( $last > 60 )
            $last = 60;

        $lpm1 = $last - 1;
        $pagination = "";

        if ( $last > 1 ) {
            $pagination .= '<div class="envato-pagination-container">';
            $pagination .= '<div class="envato-pagination">';

            $base_url = get_site_url() . '/envato/';

            if ( $site && $site !== '' )
                $base_url .= $site . '/';

            if ( $term && $term !== '' )
                $base_url .= $term . '/';

            $base_url .= '%d';

            if ( $page > 1 ) {
                $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, $prev ) . '"><i class="dslc-icon-ext-arrow-left5"></i></a>';
            } else {
                $pagination .= '<span class="envato-btn-link envato-disabled"><i class="dslc-icon-ext-arrow-left5"></i></span>';
            }

            if ( $last < 7 + ( $adjacents * 2 ) ) {
                for ( $counter = 1; $counter <= $last; $counter++ ) {
                    if ( $counter == $page )
                        $pagination .= '<span class="envato-btn-link envato-current">' . $counter . '</span>';
                    else
                        $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, $counter ) . '">' . $counter . '</a>';
                }
            } else if ( $last >= 7 + ( $adjacents * 2 ) ) {
                if ( $page < 1 + ( $adjacents * 3 ) ) {
                    for ( $counter = 1; $counter < 4 + ( $adjacents * 2 ); $counter++ ) {
                        if ( $counter == $page )
                            $pagination .= '<span class="envato-btn-link envato-current">' . $counter . '</span>';
                        else
                            $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, $counter ) . '">' . $counter . '</a>';
                    }

                    $pagination .= '<span class="elipses">...</span>';
                    $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, $lpm1 ) . '">' . $lpm1 . '</a>';
                    $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, $last ) . '">' . $last . '</a>';
                } else if ( $last - ( $adjacents * 2 ) > $page && $page > ( $adjacents * 2) ) {
                    $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, 1 ) . '">1</a>';
                    $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, 2 ) . '">2</a>';
                    $pagination .= '<span class="elipses">...</span>';

                    for ( $counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++ ) {
                        if ( $counter == $page )
                            $pagination .= '<span class="envato-btn-link envato-current">' . $counter . '</span>';
                        else
                            $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, $counter ) . '">' . $counter . '</a>';
                    }

                    $pagination .= '<span class="elipses">...</span>';
                    $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, $lpm1 ) . '">' . $lpm1 . '</a>';
                    $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, $last ) . '">' . $last . '</a>';
                } else {
                    $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, 1 ) . '">1</a>';
                    $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, 2 ) . '">2</a>';
                    $pagination .= '<span class="elipses">...</span>';

                    for ( $counter = $last - ( 1 + ( $adjacents * 3 ) ); $counter <= $last; $counter++ ) {
                        if ( $counter == $page )
                            $pagination .= '<span class="envato-btn-link envato-current">' . $counter . '</span>';
                        else
                            $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, $counter ) . '">' . $counter . '</a>';
                    }
                }
            }

            if ( $page < $counter - 1 )
                $pagination .= '<a class="envato-btn-link" href="' . sprintf( $base_url, $next ) . '"><i class="dslc-icon-ext-arrow-right5"></i></a>';
            else
                $pagination .= '<span class="envato-btn-link envato-disabled"><i class="dslc-icon-ext-arrow-right5"></i></span>';

            $pagination .= '</div>';
            $pagination .= '</div>';
        }

        return $pagination;
    }

    /**
     * Convert HTML to a PDF document.
     *
     * @since       1.0.0
     * @param       string      $path           Path to save document.
     * @param       string      $html           The HTML to convert.
     * @param       int         $customer_id    The customer we are creating the document for.
     * @param       int         $project_id     The project we are creating the document for.
     * @param       string      $type           Optional. The type of the document. Defaults to none.
     * @return      string                      Returns the path to the document.
     */
    public static function create_pdf( $path, $html, $customer_id, $project_id, $type = 'none', $margin_hori = 0, $margin_verti = 0, $return_path = false )
    {
        $directory_name = md5( $customer_id . '_' . $type );
        $document_name = $customer_id . '_' . $type . '_' . $project_id;

        $html_path = $path . $directory_name . '/html/';
        $pdf_path = $path . $directory_name . '/';

        $pdf_url = str_replace('/public_html', '', $pdf_path);
        $pdf_url = str_replace('/storage/content/20/215520/', 'http://', $pdf_url);

        if ( ! file_exists( $html_path ) )
            mkdir( $html_path, 0777, true );

        $wkhtmltopdf_path = LTS_BASE . 'bin/wkhtmltopdf';

        $exec_string = "{$wkhtmltopdf_path} --print-media-type --page-width 2480px --page-height 3508px --margin-top {$margin_verti} --margin-right {$margin_hori} --margin-bottom {$margin_verti} --margin-left {$margin_hori} --dpi 200 --zoom 1 " . $html_path . $document_name . ".html " . $pdf_path . $document_name . ".pdf 2>&1";

        file_put_contents( $html_path . $document_name . '.html', $html );
        //exec( 'wkhtmltopdf --print-media-type --page-width 2480px --page-height 3508px --margin-top 0 --margin-right 0 --margin-bottom 0 --margin-left 0 --dpi 200 --zoom 1 ' . $html_path . $document_name . '.html ' . $pdf_path . $document_name . '.pdf 2>&1', $output );
        exec( $exec_string, $output );

        if ( file_exists( $pdf_path . $document_name . '.pdf' ) ) {
            if ( $return_path )
                return $pdf_path . $document_name . '.pdf';
            
            return $pdf_url . $document_name . '.pdf';
        }

        return false;
    }

    /**
     * Get file name from a path/url
     */
    public static function get_filename( $path )
    {
        $path = str_replace( '\\', '/', $path );

        $path_parts = explode('/', $path);

        return array_pop( $path_parts );
    }

    public static function get_filesize( $path )
    {
        $size = filesize( $path );

        $suffix_index = 0;

        while ( $size >= 1024 ) {
            $size = $size / 1024;
            $suffix_index++;
        }

        $size = round( $size, 1 );

        return $size . ' ' . self::$file_sizes[$suffix_index];
    }
}