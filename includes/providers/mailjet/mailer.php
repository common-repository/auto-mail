<?php
/**
 * Auto_Mail_MailJet_Mailer Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_MailJet_Mailer' ) ) :

    class Auto_Mail_MailJet_Mailer extends Auto_Mailer_Abstract{

        /**
         * send email.
         *
         * @since 1.0.0
         */
        public function send($is_test = false) {
			$settings = get_option('auto_mail_global_settings');

            $body             = null;
            $apikey           = $settings['mailjet_api_key'];
            $secret           = $settings['mailjet_secret_key'];
            $mailjet_endpoint = 'https://api.mailjet.com/';
            $url              = $mailjet_endpoint . 'v3.1/send';

            $auth = base64_encode( $apikey.':'.$secret );

            // mailchimp api need http basic authentication
            $headers = array(
                'Authorization' => 'Basic ' . $auth,
                'content-type'  => 'application/json'
            );

            $body = [
                'FromEmail' => $settings['from_address'],
                'FromName' => $settings['from_name'],
                'Subject' => "Auto Mail Test",
                'Text-part' => "Dear passenger, welcome to Mailjet! May the delivery force be with you!",
                'Html-part' => $this->get_test_email_html(),
                'Recipients' => [
                    [
                        'Email' => $this->options['recipient_address']
                    ]
                ]
            ];

            $response = wp_remote_request(
                $url,
                array(
                    'method'  => 'POST',
                    'headers' => $headers,
                    'timeout' => 15,
                    'body'    => $body,
                )
            );

            if ( is_wp_error( $response ) ) {
                return $response;
            }

            $code = wp_remote_retrieve_response_code( $response );
            $body = wp_remote_retrieve_body( $response );

            if ( 200 != $code && 201 != $code ) {
                $body = json_decode( $body );
                if ( isset( $body->message ) ) {
                    $message = $body->message;
                } else {
                    $message = wp_remote_retrieve_response_message( $response );
                }
                return new WP_Error( $code, $message );
            } else {
                $body = json_decode( $body );
            }

            return $body;


        }

    }

endif;
