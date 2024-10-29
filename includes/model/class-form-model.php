<?php
/**
 * Auto_Mail_Form_Model Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Form_Model' ) ) :

    class Auto_Mail_Form_Model extends Auto_Mail_Form_Base_Model {

        protected $post_type = 'am_forms';

        /**
         * @param int|string $class_name
         *
         * @since 1.0
         * @return Auto_Mail_Form_Model
         */
        public static function model( $class_name = __CLASS__ ) { // phpcs:ignore
            return parent::model( $class_name );
        }
    }

endif;
