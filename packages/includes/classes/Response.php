<?php
/**
 * Class to handle responses from our API.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Packages/Includes/Classes
 */

namespace Livetime\Includes;

class Response
{
    private function __construct()
    {

    }

    /**
     * Formats a reponse to make it ready for return.
     *
     * @since       1.0.0
     * @param       array       $response       The response to format.
     * @return      string                      JSON encoded response.
     */
    private static function format_response( $response )
    {
        return json_encode( $response );
    }

    /**
     * Return a message from BankID.
     *
     * @since       1.0.0
     * @param       string      $code       The message code from BankID
     * @return      string                  JSON encoded response.
     */
    public static function bankid( $code )
    {
        $code_map = array(
            'RFA1'      => 'Starta BankID-appen.',
            'RFA2'      => 'Du har inte BankID-appen installerad. Kontakta din internetbank.',
            'RFA3'      => 'Åtgärden avbruten. Försök igen.',
            'RFA5'      => 'Internt tekniskt fel. Försök igen.',
            'RFA6'      => 'Åtgärden avbruten.',
            'RFA8'      => 'BankID-appen svarar inte. Kontrollera att den är startad och att du har internetanslutning. Om du inte har något giltigt BankID kan du hämta ett hos din bank. Försök sedan igen.',
            'RFA9'      => 'Skriv in din säkerhetskod i BankID-appen och välj Legitimera eller Skriv under.',
            'RFA12'     => 'Internt tekniskt fel. Uppdatera BankID-appen och försök igen.',
            'RFA13'     => 'Försöker starta BankID-appen.',
            'RFA14'     => 'Söker efter BankID, det kan ta en liten stund...',
            'RFA16'     => 'Det BankID du försöker använda är för gammalt eller spärrat. Använd ett annat BankID eller hämta ett nytt hos din internetbank.',
            'RFA17'     => 'BankID-appen verkar inte finnas i din dator eller telefon. Installera den och hämta ett BankID hos din internetbank. Installera appen från install.bankid.com.',
            'RFA18'     => 'Starta BankID-appen.',
            'COMPLETE'  => 'Avtal signerat.',
            'DEFAULT'   => 'Internt tekniskt fel. Försök igen.'
        );

        if ( array_key_exists( $code, $code_map ) )
            return self::format_response( array( 'message' => $code_map[$code] ) );

        return self::format_response( array( 'message' => $code_map[$code] ) );
    }

    /**
     * Returns an error.
     *
     * @since       1.0.0
     * @param       string      $message        The message to send.
     * @return      string                      JSON encoded error message.
     */
    public static function error( $message )
    {
        return self::format_response( array( 'message' => $message, 'error' => true ) );
    }
}