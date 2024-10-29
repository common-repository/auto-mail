<?php
/**
 * Auto_Mail_Core Class
 *
 * Plugin Core Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Core' ) ) :

    class Auto_Mail_Core {

        /**
         * Plugin instance
         *
         * @var null
         */
        private static $instance = null;

        /**
         * Return the plugin core instance
         *
         * @since 1.0.0
         * @return Auto_Mail_Core
         */
        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Auto_Mail_Core constructor.
         *
         * @since 1.0
         */
        public function __construct() {

            // Include all necessary files
            $this->includes();
            if ( is_admin() ) {
                // Initialize admin core
                $this->admin = new Auto_Mail_Admin();
            }

            // Enabled modules
            $modules = new Auto_Mail_Modules();
            $this->modules = $modules->get_modules();

            if ( is_admin() ) {
                // Add sub pages
                $this->admin->add_setup_page();
                $this->admin->add_am_generator_page();
                $this->admin->add_manage_page();
                //$this->admin->add_upgrade_page();
                $this->admin->add_addons_page();
            }

            // Create template dir and import files
            $this->import_template_files();

        }

        /**
         * @since 1.0.0
         */
        public function import_template_files() {
            global $wp_filesystem;
            $sourceTemplateFiles = $this->getDirContents(AUTO_MAIL_DIR . '/assets/template');
            $targetTemplateDir = AUTO_MAIL_UPLOAD_DIR.'/auto-mail-template';

            if ( ! is_dir( $targetTemplateDir) ) {
				wp_mkdir_p( $targetTemplateDir );
			}else{
                return;
            }

            if (empty($wp_filesystem)) {
                require_once (ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            foreach($sourceTemplateFiles as $key => $source){

                $data = file_get_contents($source);
                $filename = $targetTemplateDir.'/'.basename($source);

                if ( $file_handle = fopen( $filename, 'w' ) ) {
                    fwrite( $file_handle, $data );
                    fclose( $file_handle );
                }
            }
        }

        public function getDirContents($dir, &$results = array()) {
            $files = scandir($dir);

            foreach ($files as $key => $value) {
                $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
                if (!is_dir($path)) {
                    $results[] = $path;
                } else if ($value != "." && $value != "..") {
                    getDirContents($path, $results);
                    $results[] = $path;
                }
            }

            return $results;
        }




        /**
         * Includes
         *
         * @since 1.0.0
         */
        private function includes() {
           if ( is_admin() ) {
               require_once AUTO_MAIL_DIR . 'admin/abstracts/class-admin-page.php';
               require_once AUTO_MAIL_DIR . 'admin/abstracts/class-admin-module.php';
               require_once AUTO_MAIL_DIR . 'admin/classes/class-admin.php';
           }

           // Helpers
           require_once AUTO_MAIL_DIR . 'includes/helpers/helper-core.php';
           require_once AUTO_MAIL_DIR . 'includes/helpers/helper-forms.php';
           require_once AUTO_MAIL_DIR . 'includes/helpers/helper-import.php';
           require_once AUTO_MAIL_DIR . 'includes/helpers/helper-triggers.php';
           require_once AUTO_MAIL_DIR . 'includes/helpers/helper-actions.php';
           require_once AUTO_MAIL_DIR . 'includes/helpers/helper-events.php';
           require_once AUTO_MAIL_DIR . 'includes/helpers/helper-functions.php';
           require_once AUTO_MAIL_DIR . 'includes/helpers/helper-automation.php';
           require_once AUTO_MAIL_DIR . 'includes/helpers/helper-cart.php';

           // Modules
           require_once AUTO_MAIL_DIR . 'includes/class-modules.php';

           // Schedule
           require_once AUTO_MAIL_DIR . 'includes/class-schedule.php';

           // Queue
           require_once AUTO_MAIL_DIR . 'includes/class-queue.php';

           // Sending Job
           require_once AUTO_MAIL_DIR . 'includes/class-sending-job.php';

           // Model
           require_once AUTO_MAIL_DIR . '/includes/model/class-base-model.php';
           require_once AUTO_MAIL_DIR . '/includes/model/class-form-model.php';
           require_once AUTO_MAIL_DIR . '/includes/model/class-automation-model.php';
           require_once AUTO_MAIL_DIR . '/includes/model/class-campaign-model.php';
           require_once AUTO_MAIL_DIR . '/includes/model/class-subscriber-model.php';
           require_once AUTO_MAIL_DIR . '/includes/model/class-list-model.php';

           // Jobs
           require_once AUTO_MAIL_DIR . 'includes/jobs/abstract-class-import.php';
           require_once AUTO_MAIL_DIR . 'includes/jobs/class-paste-import.php';
           require_once AUTO_MAIL_DIR . 'includes/jobs/class-upload-import.php';
           require_once AUTO_MAIL_DIR . 'includes/jobs/class-mailchimp-import.php';
           require_once AUTO_MAIL_DIR . 'includes/jobs/class-mailchimp-api.php';
           require_once AUTO_MAIL_DIR . 'includes/jobs/class-wordpress-import.php';

           // Mail
           require_once AUTO_MAIL_DIR . 'includes/jobs/class-mail-helper.php';
           require_once AUTO_MAIL_DIR . 'includes/jobs/class-mail-sender.php';

           // Mailer Providers
           require_once AUTO_MAIL_DIR . 'includes/providers/abstract-class-mailer.php';
           require_once AUTO_MAIL_DIR . 'includes/providers/sendgrid/mailer.php';
           require_once AUTO_MAIL_DIR . 'includes/providers/mailjet/mailer.php';
           require_once AUTO_MAIL_DIR . 'includes/providers/smtp/mailer.php';
           require_once AUTO_MAIL_DIR . 'includes/providers/default/mailer.php';
           require_once AUTO_MAIL_DIR . 'includes/providers/aws/mailer.php';
           require_once AUTO_MAIL_DIR . 'includes/providers/aws/ses-error.php';
           require_once AUTO_MAIL_DIR . 'includes/providers/aws/ses-envelope.php';
           require_once AUTO_MAIL_DIR . 'includes/providers/aws/ses.php';

           // Automation Classes
           require_once AUTO_MAIL_DIR . 'includes/class-automation.php';
           require_once AUTO_MAIL_DIR . 'includes/automations/integration-trigger.php';
           require_once AUTO_MAIL_DIR . 'includes/automations/integration-action.php';
           require_once AUTO_MAIL_DIR . 'includes/integrations/wordpress/wordpress.php';
           require_once AUTO_MAIL_DIR . 'includes/integrations/woocommerce/woocommerce.php';

           // Log Class
           require_once AUTO_MAIL_DIR . 'includes/class-log.php';

           // Cart Abandonment Tracking Class
           require_once AUTO_MAIL_DIR . 'includes/class-cart-tracking.php';
        }

    }

endif;
