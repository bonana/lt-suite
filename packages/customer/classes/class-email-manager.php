<?php

/**
 * Class to handle sending out the emails.
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     Customer
 * @subpackage  Customer/Classes
 */

namespace Livetime\Customer;

class Email_Manager extends Base_Manager
{
    /**
     * The transport to use for sending emails.
     *
     * @since       1.0.0
     * @var         \Swift_SmtpTransport        $transport        The transport mode to use.
     */
    protected $transport;

    /**
     * The mailer to use to send mails.
     *
     * @since       1.0.0
     * @var         \Swift_Mailer               $mailer           The mailer to use.
     */
    protected $mailer;

    /**
     * Initialize our class.
     *
     * @since       1.0.0
     * @param       \Swift_SmtpTransport        $transport         The transport mode tu use.
     */
    public function __construct( $transport )
    {
        $this->transport = $transport;
        $this->mailer = \Swift_Mailer::newInstance( $this->transport );
    }

    /**
     * Send an email.
     *
     * @since       1.0.0
     * @param       array       $from           Array containing from email and name.
     * @param       array       $to             Send to.
     * @param       string      $subject        Email subject.
     * @param       string      $body           The mail body.
     * @param       string      $type           The mail type, default text/plain.
     * @param       array       $bcc            Send blind carbon copy to.
     * @return      ?                           SwiftMail Result.
     */
    public function send_email( $from, $to, $subject, $body, $type = 'text/plain', $attachments = null, $bcc = null )
    {
        $message = \Swift_Message::newInstance( $subject )
                                 ->setFrom( $from )
                                 ->setTo( $to )
                                 ->setBcc( $bcc )
                                 ->setBody( $body, $type );

        if ( $attachments ) {
            foreach ( $attachments as $attachment ) {
                $message->attach(\Swift_Attachment::fromPath( $attachment ));
            }
        }

        return $this->mailer->send( $message );
    }
}