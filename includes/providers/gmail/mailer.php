<?php
/**
 * Auto_Mail_Gmail_Mailer Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Gmail_Mailer' ) ) :

    class Auto_Mail_Gmail_Mailer extends Auto_Mailer_Abstract{

        /**
         * send email.
         *
         * @since 1.0.0
         */
        public function send($is_test = false) {

        }

    }

endif;
