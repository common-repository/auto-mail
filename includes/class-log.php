<?php
/**
 * Auto Robot Log Class
 *
 * @since  1.0.0
 * @package Auto Robot
 */

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Auto_Mail_Log' ) ) :

	/**
	 * Auto Robot Log
	 */
	class Auto_Mail_Log {

        /**
         * Campaign ID
         *
         * @int
         */
        public $campaign_id;

		/**
		 * Constructor.
		 *
		 * @since 1.1.0
		 */
		public function __construct() {
            //$this->campaign_id = $campaign_id;
            //$this->start();
        }

        /**
         * Automation Job Start
         *
         * @since 1.0.0
         * @return void
         */
        public function start() {
            $this->add( 'Started Automation Job Process' );
            $this->add( "Timezone \t\t: " );
            $this->add( 'Automation Started! - ');
        }

        /**
         * @since 1.0.0
         */
        public function add($content) {
            global $wp_filesystem;
            $targetTemplateDir = AUTO_MAIL_UPLOAD_DIR.'/auto-mail-log';

            if ( ! is_dir( $targetTemplateDir) ) {
				wp_mkdir_p( $targetTemplateDir );
			}else{
                return;
            }

            if (empty($wp_filesystem)) {
                require_once (ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            $source = 'automation.log';
            $filename = $targetTemplateDir.'/'.basename($source);

            if ( $file_handle = fopen( $filename, 'a+' ) ) {
                fwrite( $file_handle, $content );
                fclose( $file_handle );
            }
        }

        /**
         * Timezone
         *
         * @since 1.1.0
         * @see https://codex.wordpress.org/Option_Reference/
         *
         * @return string Current timezone.
         */
        public function get_timezone() {
            $timezone = get_option( 'timezone_string' );

            if ( ! $timezone ) {
                return get_option( 'gmt_offset' );
            }

            return $timezone;
        }

        /**
         * Current Time for log.
         *
         * @since 1.1.0
         * @return string Current time with time zone.
         */
        public function current_time() {
            return gmdate( 'H:i:s' ) . ' ' . date_default_timezone_get();
        }
    }

endif;
