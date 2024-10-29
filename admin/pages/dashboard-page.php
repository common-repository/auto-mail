<?php
/**
 * Auto_Mail_Dashboard_Page Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Dashboard_Page' ) ) :

    class Auto_Mail_Dashboard_Page extends Auto_Mail_Admin_Page {

        /**
         * Add page screen hooks
         *
         * @since 1.0.0
         *
         * @param $hook
         */
        public function enqueue_scripts( $hook ) {
            // Load admin styles
            auto_mail_admin_enqueue_styles( AUTO_MAIL_VERSION );

            $auto_mail_data = new Auto_Mail_Admin_Data();

            // Load admin dashboard scripts
            auto_mail_admin_enqueue_scripts_dashboard(
                AUTO_MAIL_VERSION,
                $auto_mail_data->get_options_data()
            );
        }

    }

endif;
