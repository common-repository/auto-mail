<?php
/**
 * Admin Triggers List Class
 *
 * Plugin Admin Triggers List Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Auto_Mail_Admin_Triggers' ) ) :

	/**
	 * Admin Triggers List
	 */
	class Auto_Mail_Admin_Triggers {

        public static function get_list(){
            // list of triggers
                $triggers = apply_filters('am_triggers_details_list',array(
                    'wordpress' => array(
                        'name'=>'wordpress',
                        'desc'=>'Wordpress trigger events',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/triggers/wordpress.png'
                    ),
                    'woocommerce' => array(
                        'name'=>'woocommerce',
                        'desc'=>'Woocommerce trigger events',
                        'thumbnail' => AUTO_MAIL_URL.'/assets/images/triggers/woocommerce.png'
                    )
                ));

                return $triggers;
            }


	}



endif;