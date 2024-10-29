<?php
/**
 * Auto_Mail_AWS_Mailer Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_AWS_Mailer' ) ) :

    class Auto_Mail_AWS_Mailer extends Auto_Mailer_Abstract{

        /**
         * send email.
         *
         * @since 1.0.0
         */
        public function send($is_test = false) {
            $settings = get_option('auto_mail_global_settings');

            $ses = new SimpleEmailService(
                $settings['amazon_access_key'], // your AWS access key id
                $settings['amazon_secret_key'], // your AWS secret access key
                $settings['aws_region'] // AWS region, default is us-east-1
            );

            if($is_test){
				$envelope = new SimpleEmailServiceEnvelope(
                    $settings['from_address'],
                    'Auto Mail Test',
                    'Message',
                    $this->get_test_email_html()
                );
                $envelope->addTo($this->options['recipient_address']);
			}else{
				$envelope = new SimpleEmailServiceEnvelope(
                    $settings['from_address'],
                    $this->options['subject'],
                    'Message',
                    $this->options['html']
                );
                $envelope->addTo($this->options['to_address']);
			}

            $response = $ses->sendEmail($envelope);

            if($response instanceof SimpleEmailServiceError){
				$result = array(
					'success' => false,
					'message' => $response->message
				);
            }else{
                $result = array(
                    'success' => true,
                    'message' => 'Email has been sent successfully'
                );
            }

            return $result;
        }
    }

endif;
