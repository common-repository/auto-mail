<?php
/**
 * Admin Addons List Class
 *
 * Plugin Admin Addons List Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Auto_Mail_Admin_Addons' ) ) :

	/**
	 * Admin Addons List
	 */
	class Auto_Mail_Admin_Addons {

        public static function get_list(){
            // list of addons
                $addons = apply_filters('robot_addons_details_list',array(
                    'mailchimp' => array(
                        'name'=>'Mailchimp Addon',
                        'desc'=>'Connect Auto Mail to MailChimp',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/addons/mailchimp.png'
                    ),
                    'activecampaign' => array(
                        'name'=>'ActiveCampaign Addon',
                        'desc'=>'Connect Auto Mail to ActiveCampaign',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/addons/activecampaign.png'
                    ),
                    'mailpoet' => array(
                        'name'=>'MailPoet Addon',
                        'desc'=>'Connect Auto Mail to MailPoet',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/addons/mailpoet.png'
                    ),
                    'mailerlite' => array(
                        'name'=>'MailerLite Addon',
                        'desc'=>'Connect Auto Mail to MailerLite',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/addons/mailerlite.png'
                    ),
                    'sendgrid' => array(
                        'name'=>'SendGrid Addon',
                        'desc'=>'Connect Auto Mail to SendGrid',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/addons/sendgrid.png'
                    ),
                    'sendinblue' => array(
                        'name'=>'Sendinblue Addon',
                        'desc'=>'Connect Auto Mail to Sendinblue',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/addons/sendinblue.png'
                    ),
                ));

                return $addons;
            }


	}



endif;