<?php
/**
 * Admin Actions List Class
 *
 * Plugin Admin Actions List Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Auto_Mail_Admin_Actions' ) ) :

	/**
	 * Admin Actions List
	 */
	class Auto_Mail_Admin_Actions {

        public static function get_list(){
            // list of actions
                $actions = apply_filters('am_actions_details_list',array(
                    'wordpress' => array(
                        'name'=>'wordpress',
                        'desc'=>'Wordpress trigger events',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/actions/wordpress.png'
                    ),
                    'woocommerce' => array(
                        'name'=>'woocommerce',
                        'desc'=>'Woocommerce trigger events',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/actions/woocommerce.png'
                    ),
                    'mailpoet' => array(
                        'name'=>'mailpoet',
                        'desc'=>'Connect Auto Mail to MailPoet',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/actions/mailpoet.png'
                    ),
                    'mailerlite' => array(
                        'name'=>'mailerlite',
                        'desc'=>'Connect Auto Mail to MailerLite',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/actions/mailerlite.png'
                    ),
                    'sendgrid' => array(
                        'name'=>'sendgrid',
                        'desc'=>'Connect Auto Mail to SendGrid',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/actions/sendgrid.png'
                    ),
                    'sendinblue' => array(
                        'name'=>'sendinblue',
                        'desc'=>'Connect Auto Mail to Sendinblue',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/actions/sendinblue.png'
                    ),
                ));

                return $actions;
            }


	}



endif;