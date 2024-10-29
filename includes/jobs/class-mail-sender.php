<?php
/**
 * Auto Mail Sender Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Auto_Mail_Sender' ) ) :

	class Auto_Mail_Sender {

		public $mailer;

		public function __construct($provider, $options) {
			switch ( $provider ) {
				case 'php':
					$this->mailer = new Auto_Mail_Default_Mailer($options);
					break;
				case 'sendgrid':
					$this->mailer = new Auto_Mail_SendGrid_Mailer($options);
					break;
				case 'gmail':
					$this->mailer = new Auto_Mail_Gmail_Mailer($options);
					break;
				case 'amazon':
					$this->mailer = new Auto_Mail_AWS_Mailer($options);
					break;
				case 'mailjet':
					$this->mailer = new Auto_Mail_MailJet_Mailer($options);
					break;
				case 'smtp':
					$this->mailer = new Auto_Mail_SMTP_Mailer($options);
					break;
				default:
					break;
			}
		}

		/**
		* Do send email actions
		*
		* @since 1.0.0
		*/
		public function do_send($is_test = false){
			if($is_test){
				$response = $this->mailer->send(true);
			}else{
				$response = $this->mailer->send(false);
			}
			return $response;
		}

	}

endif;
