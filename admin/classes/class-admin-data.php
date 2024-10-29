<?php
/**
 * Auto_Mail_Admin_Data Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Admin_Data' ) ) :

    class Auto_Mail_Admin_Data {

        public $core = null;

        /**
         * Current Nonce
         *
         * @since 1.0.0
         * @var string
         */
        private $_nonce = '';

        /**
         * Auto_Mail_Admin_Data constructor.
         *
         * @since 1.0.0
         */
        public function __construct() {
            $this->generate_nonce();
        }

        /**
         * Generate nonce
         *
         * @since 1.0.0
         */
        public function generate_nonce() {
            $this->_nonce = wp_create_nonce( 'auto-mail' );
        }

        /**
         * Get current generated nonce
         *
         * @since 1.0.0
         * @return string
         */
        public function get_nonce() {
            return $this->_nonce;
        }

        /**
         * Combine Data and pass to JS
         *
         * @since 1.0.0
         * @return array
         */
        public function get_options_data() {
            $data           = $this->admin_js_defaults();
            $data           = apply_filters( 'auto_mail_data', $data );

            return $data;
        }

        /**
         * Default Admin properties
         *
         * @since 1.0.0
         * @return array
         */
        public function admin_js_defaults() {
            return array(
                'ajaxurl'                        => auto_mail_ajax_url(),
                'wizard_url'                     => admin_url( 'admin.php?page=auto-mail-form-wizard' ),
                'forms_url'                      => admin_url( 'admin.php?page=auto-mail-forms' ),
                'subscribers_url'                => admin_url( 'admin.php?page=auto-mail-subscribers' ),
                'lists_url'                      => admin_url( 'admin.php?page=auto-mail-lists' ),
                'campaigns_url'                  => admin_url( 'admin.php?page=auto-mail-campaigns' ),
                'automations_url'                => admin_url( 'admin.php?page=auto-mail-automations' ),
                'new_am_url'                     => admin_url( 'admin.php?page=auto-mail-automation-wizard' ),
                '_ajax_nonce'                    => $this->get_nonce(),
            );
        }

    }

endif;
