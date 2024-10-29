<?php
/**
 * Auto_Mail_SendGrid_Mailer Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

use SendGrid\Mail\To;
use SendGrid\Mail\Cc;
use SendGrid\Mail\Bcc;
use SendGrid\Mail\From;
use SendGrid\Mail\Content;
use SendGrid\Mail\Mail;
use SendGrid\Mail\Personalization;
use SendGrid\Mail\Subject;
use SendGrid\Mail\Header;
use SendGrid\Mail\CustomArg;
use SendGrid\Mail\SendAt;
use SendGrid\Mail\Attachment;
use SendGrid\Mail\Asm;
use SendGrid\Mail\MailSettings;
use SendGrid\Mail\BccSettings;
use SendGrid\Mail\SandBoxMode;
use SendGrid\Mail\BypassBounceManagement;
use SendGrid\Mail\BypassListManagement;
use SendGrid\Mail\BypassSpamManagement;
use SendGrid\Mail\BypassUnsubscribeManagement;
use SendGrid\Mail\Footer;
use SendGrid\Mail\SpamCheck;
use SendGrid\Mail\TrackingSettings;
use SendGrid\Mail\ClickTracking;
use SendGrid\Mail\OpenTracking;
use SendGrid\Mail\SubscriptionTracking;
use SendGrid\Mail\Ganalytics;
use SendGrid\Mail\ReplyTo;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_SendGrid_Mailer' ) ) :

    class Auto_Mail_SendGrid_Mailer extends Auto_Mailer_Abstract{

        /**
         * send email.
         *
         * @since 1.0.0
         */
        public function send($is_test = false) {
			$settings = get_option('auto_mail_global_settings');

            $api_key = $settings['sendgrid_api_key'];   //api key from sendgrid

		    $email = new \SendGrid\Mail\Mail();

			if($is_test){
				$email->setSubject('Auto Mail Test');
		    	$email->addTo($this->options['recipient_address'], $this->options['recipient_name']);
		    	$email->addContent(
    		    	"text/html", $this->get_test_email_html()
		    	);
			}else{
				$email->setSubject($this->options['subject']);
		    	$email->addTo($this->options['to_address'], $this->options['to_name']);
		    	$email->addContent(
    		    	"text/html", $this->options['html']
		    	);
			}

		    $email->setFrom($settings['from_address'], $settings['from_name']);

		    $sendgrid = new \SendGrid($api_key);

		    try {
    		    $response = $sendgrid->send($email);

				if($response->statusCode() == 202){
					$result = array(
						'success' => true,
						'message' => 'Email has been sent successfully'
					);
				}else{
					$response_body = $response->body();
					$response_message = json_decode($response_body);
					$result = array(
						'success' => false,
						'message' => $response_message->errors[0]->message
					);
				}

				return $result;
		    } catch (Exception $e) {
    		    echo esc_html($e->getMessage());
		    }
        }

    }

endif;
