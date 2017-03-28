<?php

/**
 * Class to handle BankID integration.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     BankID
 * @subpackage  BankID/Classes
 */

namespace Livetime\BankID;

use Livetime\Includes\Util as Util;

class BankID
{
    /**
     * Our SOAPClient to make API requests to BankID central server.
     *
     * @since       1.0.0
     * @var         SOAPClient      $soap       Our SOAP client.
     */
    protected $soap;

    /**
     * Certificates to verify against BankID.
     *
     * @since       1.0.0
     * @var         string          $certs      File path to certificate files.
     */
    protected $certs;

    /**
     * API related URLS.
     *
     * @since       1.0.0
     * @var         string          $api_url        URL to the API.
     * @var         string          $wsdl_url       URL to the API structure
     * @var         string          $verify_cert    Path to the local CA file for BankID.
     */
    protected $api_url;
    protected $wsdl_url;
    protected $verify_cert;

    /**
     * Intialize our class and set certifications.
     *
     * @since       1.0.0
     * @param       string          $certifications Name of the ceritifications to load.
     * @param       bool            $test           Whether or not to run in test mode.
     */
    public function __construct( $certifications, $test = false )
    {
        $this->certs = $this->get_cert( $certifications );

        if ( $test ) {
            $this->api_url = 'https://appapi.test.bankid.com/rp/v4';
            $this->wsdl_url = 'https://appapi.test.bankid.com/rp/v4?wsdl';
            $this->verify_cert = $this->get_cert( 'appapi.test.bankid.com.pem' );
        } else {
            $this->api_url = 'https://appapi.bankid.com/rp/v4';
            $this->wsdl_url = 'https://appapi.bankid.com/rp/v4?wsdl';
            $this->verify_cert = $this->get_cert( 'appapi.bankid.com.pem' );
        }

        $stream_context = stream_context_create( array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        ) );

        $this->soap = new \SOAPClient( $this->wsdl_url, array(
            'local_cert' => $this->certs,
            'stream_context' => $stream_context
        ) );
    }

    /**
     * Attempt to authenticate a user against BankID.
     *
     * @since       1.0.0
     * @param       string      $personal_number        The persons personnumber that you want to authenticate.
     * @param       array       $kwargs                 Keyword argument array.
     * @return      string                              API response or null
     */
    public function authenticate( $personal_number, $kwargs = null )
    {
        try {
            $out = $this->soap->Authenticate( array( 'personalNumber' => $personal_number ) );
        } catch ( \SoapFault $e ) {
            $out = null;
        }

        return $out;
    }

    /**
     * Attempt to start a sign for the given user.
     *
     * @since       1.0.0
     * @param       string      $personal_number        The persons personalnumber that you want to sign.
     * @param       string      $user_visible_data      The data that will show to the user in the sign form.
     * @param       string      $user_non_visible_data  The data that will be held at BankIDs servers.
     * @param       array       $kwargs                 Keyword argument array
     * @return                                          Return the response if successful, else null
     */
    public function sign( $personal_number, $user_visible_data, $user_non_visible_data = '', $kwargs = null )
    {
        try {
            $out = $this->soap->Sign( array( 'personalNumber' => $personal_number, 'userVisibleData' => Util::normalize_text( base64_encode( $user_visible_data ) ), 'userNonVisibleData' => Util::normalize_text( base64_encode( $user_non_visible_data ) ) ) );
        } catch ( \SoapFault $e ) {
            $out = null;
        }

        return $out;
    }

    /**
     * Collect response from BankID.
     *
     * @since       1.0.0
     * @param       string      $order_ref              The order reference to collect.
     */
    public function collect( $order_ref )
    {
        try {
            $out = $this->soap->Collect( $order_ref );
        } catch ( \SoapFault $e ) {
            $out = null;
        }

        return $out;
    }

    /**
     * Get the correct certificate.
     *
     * @since       1.0.0
     * @param       string      $name       The certificate name.
     * @return      string                  Full certificate path.
     */
    private function get_cert( $name )
    {
        $cert_path = plugin_dir_path( dirname( __FILE__ ) ) . 'certs/' . $name;

        if ( file_exists( $cert_path ) )
            return $cert_path;

        return null;
    }
}