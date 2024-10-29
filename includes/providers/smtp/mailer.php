<?php
/**
 * Auto_Mail_SMTP_Mailer Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_SMTP_Mailer' ) ) :

    class Auto_Mail_SMTP_Mailer extends Auto_Mailer_Abstract{

        /**
         * send email.
         *
         * @since 1.0.0
         */
        public function send($is_test = false) {

			$settings = get_option('auto_mail_global_settings');

            global $mailer;
		    if ( ! is_object( $mailer ) || ! $mailer instanceof PHPMailer ) {
			    require_once ABSPATH . WPINC . '/class-phpmailer.php';
			    $mailer = new PHPMailer( true );
		    }

            try {
                		//Server settings
                		$mailer->IsSMTP();
                   		$mailer->Port = $settings['smtp_port'];
                   		$mailer->SMTPAuth = true;
                   		//sendgrid
                   		$mailer->Username = $settings['smtp_login'];
                   		$mailer->Password = $settings['smtp_password'];
                   		$mailer->Host = $settings['smtp_host_name'];
                   		$mailer->SMTPSecure = 'tls';

                		// From
                		$mailer->setFrom($settings['from_address'], $settings['from_address']);
                		$mailer->addReplyTo($settings['from_address'], $settings['from_name']);

						if($is_test){
							$mailer->addAddress($this->options['recipient_address'], $this->options['recipient_name']);     //Add a recipient
                		    $mailer->addAddress($this->options['recipient_address']);  //Name is optional
 						    $mailer->Subject = 'Auto Mail Test';
							$mailer->Body = $this->get_test_email_html();
						}else{
							$mailer->addAddress($this->options['to_address'], $this->options['to_name']);     //Add a recipient
                		    $mailer->addAddress($this->options['to_address']);  //Name is optional
							$mailer->Subject = $this->options['subject'];
							$mailer->Body = stripslashes(str_replace("\r\n","", $this->options['html']));
						}


                		//Content
                		$mailer->isHTML(true); //Set email format to HTML

                		$mailer->send();
						$result = array(
							'success' => true,
							'message' => 'Email has been sent successfully'
						);
						return $result;

            } catch (Exception $e) {
				$result = array(
					'success' => false,
					'message' => "Message could not be sent. Mailer Error: {$mailer->ErrorInfo}"
				);
				return $result;
            }

        }
    }

endif;
