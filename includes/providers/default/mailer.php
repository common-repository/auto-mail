<?php
/**
 * Auto_Mail_Default_Mailer Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Default_Mailer' ) ) :

    class Auto_Mail_Default_Mailer extends Auto_Mailer_Abstract{

        /**
         * send email.
         *
         * @since 1.0.0
         */
        public function send($is_test = false) {
            $settings = get_option('auto_mail_global_settings');

            if($is_test){
				$to = $this->options['recipient_address'];
                $subject = 'Auto Mail Test';
                $body = $this->get_test_email_html();
                $headers = array(
                    'Content-Type: text/html; charset=UTF-8',
                    'From: '.$settings['from_address']. ' '.$settings['from_address']
                );
			}else{
				$to = $this->options['to_address'];
                $subject = $this->options['subject'];
                $body = $this->options['html'];
                $headers = array(
                    'Content-Type: text/html; charset=UTF-8',
                    'From: '.$settings['from_address']. ' '.$settings['from_address']
                );
			}

            $response = wp_mail( $to, $subject, $body, $headers );
            if($response){
                $result = array(
                    'success' => true,
                    'message' => 'Email has been sent successfully'
                );
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Email sent failed'
                );
            }

            return $result;
        }

    }

endif;
