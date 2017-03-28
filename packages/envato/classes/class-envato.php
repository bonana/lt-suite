<?php

/**
 * Class to handle integration with the Envato Market API to perform searches
 * and lookups of specific items.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     Envato
 * @subpackage  Envato/Classes
 */

namespace Livetime\Envato;

use Illuminate\Filesystem\Filesystem as Filesystem;
use Illuminate\Cache\FileStore as FileStore;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Envato
{
    /**
     * API Auth KEY
     *
     * @since       1.0.0
     * @var         string      $api_key        Our API key for the Envato Market API
     */
    protected $api_key;

    /**
     * Envato item search URL.
     *
     * @since       1.0.0
     * @var         string      $search_url     URL for the search function of the Envato API
     */
    protected $search_url;

    /**
     * Envato item detail URL.
     *
     * @since       1.0.0
     * @var         string      $detail_url     URL for getting details on a specific item fron the Envato API
     */
    protected $detail_url;

    /**
     * Envato item price URL.
     *
     * @since       1.0.0
     * @var         string      $price_url      URL for getting prices on items from the Envato API
     */
    protected $price_url;

    /**
     * Array containing all the headers for the request to the API.
     *
     * @since       1.0.0
     * @var         array       $headers        Array containing all the headers to be sent to the server.
     */
    protected $headers;

    /**
     * GuzzleHTTP Client.
     *
     * @since       1.0.0
     * @var         GuzzleHttp\Client       $client     GuzzleHttp client to contact API
     */
    protected $client;
    
    /**
     * Initialize our class to be ready for use against the API.
     *
     * @since       1.0.0
     */
    public function __construct()
    {
        $this->api_key = 'nVPZ7U6ov6E4VwWY494EAt4J2lQSNTYl';

        $this->search_url = 'https://api.envato.com/v1/discovery/search/search/item';
        $this->detail_url = 'https://api.envato.com/v3/market/catalog/item';
        $this->price_url = 'https://api.envato.com/v1/market/item-prices';

        $this->headers = array(
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$this->api_key}"
        );

        $this->client = new Client( array(
            'curl' => array(
                CURLOPT_SSL_VERIFYPEER => false
            )
        ) );
    }

    /**
     * Convert an envato URL to an array of querys to be used with the search function.
     *
     * @since       1.0.0
     * @param       string      $url        The URL to convert
     * @return                              Return the Envato API object or null if failed.
     */
    public function fetch( $url )
    {
        $url_parameters = explode('?', $url)[1];
        $url_parameters = explode('&', $url_parameters);

        $query = array();

        foreach ( $url_parameters as $parameter ) {
            $parameter = explode('=', $parameter);

            $query[$parameter[0]] = $parameter[1];
        }

        return $this->search( $query );
    }

    /**
     * Search the Envato Market APi for items matching criteria.
     *
     * @since       1.0.0
     * @param       array       $query      Array containing all the query parameters to send
     * @return                              The Envato API Object or null if failed.
     */
    public function search( $query = array() )
    {
        $cache_name = 'es_' . md5( serialize( $query ) );
        $cache = new FileStore( new Filesystem( $cache_name . '.txt' ), __DIR__ . '/../cache' );

        if ( $cache->get( $cache_name ) ) {
            return json_decode( $cache->get( $cache_name ) );
        } else {
            try {
                $request = new Request( 'GET', $this->build_url( $query ) );

                $response = $this->client->send( $request, [
                    'headers' => $this->headers
                ] );

                return $this->handle_response( $response, $cache, $cache_name );
            } catch ( \Exception $e ) {
                return null;
            }
        }
    }

    /**
     * Get an individual item from the Envato Market API.
     *
     * @since       1.0.0
     * @param       string      $id     The ID to attempt to get from the API
     * @return                          Either returns the Envato Object from ID or null if failed.
     */
    public function get( $id )
    {
        $cache_name = 'eg_' . str_replace( ' ', '', $id );
        $cache = new FileStore( new Filesystem( $cache_name . '.txt' ), __DIR__ . '/../cache' );

        if ( $cache->get( $cache_name ) ) {
            return json_decode( $cache->get( $cache_name ) );
        } else {
            try {
                $response = $this->client->request( 'GET', $this->detail_url, [
                    'headers' => $this->headers,
                    'query' => ['id' => $id]
                ] );
                return $this->handle_response( $response, $cache, $cache_name );
            } catch ( \Exception $e ) {
                return null;
            }
        }
    }

    /**
     * Function to get detailed price information from specific item.
     *
     * @since       1.0.0
     * @param       string      $id     The ID to attempt ot get from the API
     * @return                          Returns either the Envato Object or null if failed.
     */
    public function get_price( $id )
    {
        $cache_name = 'es_gp_' . md5( $id );
        $cache = new FileStore( new Filesystem( $cache_name . '.txt'), __DIR__ . '/../cache' );

        if ( $cache->get( $cache_name ) ) {
            return json_decode( $cache->get( $cache_name ) );
        } else {
            try {
                $response = $this->client->request( 'GET', $this->build_price_url( $id ), [
                    'headers' => $this->headers
                ] );

                return $this->handle_response( $response, $cache, $cache_name );
            } catch ( \Exception $e ) {
                return null;
            }
        }
    }

    /**
     * Handle and cache responses.
     *
     * @since       1.0.0
     * @param       object      $response       The response object.
     * @param       object      $cache          The cache to use.
     * @return                                  Returns the JSON decoded body.
     */
    protected function handle_response( $response, $cache, $cache_name )
    {
        if ( $response && $response->getStatusCode() === 200 ) {
            $body = (string) $response->getBody();
            $body = json_decode( $body );

            if ( !empty( $body->matches ) ) {
                foreach ( $body->matches as &$match ) {
                    if ( isset( $match->previews->live_site ) ) {
                        $match->normalized_url = ( isset( $match->previews->live_site->href ) ? 'http://' . $match->site . $match->previews->live_site->href : $match->previews->live_site->url );
                    }
                }
            } else {
                if ( isset( $body->previews->live_site ) ) {
                    $body->normalized_url = ( isset( $body->previews->live_site->href ) ? 'http://' . $body->site . $body->previews->live_site->href : $body->previews->live_site->url );
                }
            }

            $body = json_encode( $body );


            $cache->put( $cache_name, $body, 600 );

            return json_decode( $body );
        }

        return null;
    }

    /**
     * Build a search URL from base url and query parameters.
     *
     * @since       1.0.0
     * @param       array       $query      Array of query parameters
     * @return                              Complete URL for API call
     */
    protected function build_url( $query )
    {
        return $this->search_url . '?' . http_build_query( $query );
    }

    /**
     * Build price URL.
     *
     * @since       1.0.0
     * @param       string      $id     The ID to search for.
     * @return      string              Returns URL to price API call
     */
    public function build_price_url( $id )
    {
        return $this->price_url . ':' . $id . '.json';
    }
}