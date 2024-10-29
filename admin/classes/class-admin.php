<?php
/**
 * Auto_Mail_Admin Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Admin' ) ) :

    class Auto_Mail_Admin {

        /**
         * @var array
         */
        public $pages = array();

        /**
         * Auto_Mail_Admin constructor.
         */
        public function __construct() {
            $this->includes();

            // Init admin pages
            add_action( 'admin_menu', array( $this, 'add_dashboard_page' ) );

            // Init Admin AJAX class
            new Auto_Mail_Admin_AJAX();

            /**
             * Triggered when Admin is loaded
             */
            do_action( 'auto-mail_admin_loaded' );
        }

        /**
         * Include required files
         *
         * @since 1.0.0
         */
        private function includes() {
            // Admin Pages
            require_once AUTO_MAIL_DIR . '/admin/pages/dashboard-page.php';
            require_once AUTO_MAIL_DIR . '/admin/pages/setup-page.php';
            require_once AUTO_MAIL_DIR . '/admin/pages/manage-page.php';
            require_once AUTO_MAIL_DIR . '/admin/pages/settings-page.php';
            require_once AUTO_MAIL_DIR . '/admin/pages/upgrade-page.php';
            require_once AUTO_MAIL_DIR . '/admin/pages/addons-page.php';
            require_once AUTO_MAIL_DIR . '/admin/pages/generator-page.php';

            // Admin Ajax
            require_once AUTO_MAIL_DIR . '/admin/classes/class-admin-ajax.php';

            // Admin Data
            require_once AUTO_MAIL_DIR . '/admin/classes/class-admin-data.php';

            // Admin Addons
            require_once AUTO_MAIL_DIR . '/admin/classes/class-admin-addons.php';
            require_once AUTO_MAIL_DIR . '/admin/classes/class-admin-triggers.php';
            require_once AUTO_MAIL_DIR . '/admin/classes/class-admin-actions.php';

        }


        /**
         * Initialize Dashboard page
         *
         * @since 1.0.0
         */
        public function add_dashboard_page() {
            $title = esc_html__( 'Auto Mail', Auto_Mail::DOMAIN );

            $this->pages['auto_mail']           = new Auto_Mail_Dashboard_Page( 'auto-mail', 'dashboard', $title, $title, false, false );
            $this->pages['auto_mail-dashboard'] = new Auto_Mail_Dashboard_Page( 'auto-mail', 'dashboard', esc_html__( 'Auto Mail Dashboard', Auto_Mail::DOMAIN ), esc_html__( 'Dashboard', Auto_Mail::DOMAIN ), 'auto-mail' );
        }

        /**
         * Add setup page
         *
         * @since 1.0.0
         */
        public function add_setup_page() {
            add_action( 'admin_menu', array( $this, 'init_setup_page' ) );
        }

        /**
         * Initialize setup page
         *
         * @since 1.0.0
         */
        public function init_setup_page() {
            $this->pages['auto-mail_setup'] = new Auto_Mail_Setup_Page(
                'auto-mail-setup',
                'setup',
                esc_html__( 'Setup', 'auto-mail' ),
                esc_html__( 'Setup', 'auto-mail' ),
                'auto-mail'
            );
        }

        /**
         * Add settings page
         *
         * @since 1.0.0
         */
        public function add_settings_page() {
            add_action( 'admin_menu', array( $this, 'init_settings_page' ) );
        }

        /**
         * Initialize settings page
         *
         * @since 1.0.0
         */
        public function init_settings_page() {
            $this->pages['auto-mail_settings'] = new Auto_Mail_Settings_Page(
                'auto-mail-settings',
                'settings',
                esc_html__( 'Settings', 'auto-mail' ),
                esc_html__( 'Settings', 'auto-mail' ),
                'auto-mail'
            );
        }

        /**
         * Add manage page
         *
         * @since 1.0.0
         */
        public function add_manage_page() {
            add_action( 'admin_menu', array( $this, 'init_manage_page' ) );
        }

        /**
         * Initialize manage page
         *
         * @since 1.0.0
         */
        public function init_manage_page() {
            $this->pages['auto-mail_manage'] = new Auto_Mail_Manage_Page(
                'auto-mail-manage',
                'manage',
                esc_html__( 'Manage Subscribers', 'auto-mail' ),
                esc_html__( 'Manage Subscribers', 'auto-mail' ),
                'auto-mail'
            );
        }

        /**
		* Add upgrade page
		*
		* @since 1.0.0
		*/
	    public function add_upgrade_page() {
            add_action( 'admin_menu', array( $this, 'init_upgrade_page' ) );
        }

       /**
       * Initialize Logs page
       *
       * @since 1.0.0
       */
       public function init_upgrade_page() {

         $menu_text = '<span>'.__( 'Pro Version ⇪', Auto_Mail::DOMAIN ) . '</span>';

         $this->pages['auto-mail-upgrade'] = new Auto_Mail_Upgrade_Page(
             'auto-mail-upgrade',
             'upgrade',
             __( 'Pro Verion', Auto_Mail::DOMAIN ),
             $menu_text,
             'auto-mail'
         );
      }

      /**
		* Add am_generator page
		*
		* @since 1.0.0
		*/
	    public function add_am_generator_page() {
            add_action( 'admin_menu', array( $this, 'init_am_generator_page' ) );
        }

       /**
       * Initialize Logs page
       *
       * @since 1.0.0
       */
       public function init_am_generator_page() {

         $menu_text = '<span>'.__( 'Welcome', Auto_Mail::DOMAIN ) . '</span>';

         $this->pages['auto-mail-generator'] = new AM_Automation_Generator_Page(
             'auto-mail-generator',
             'generator',
             __( 'Welcome', Auto_Mail::DOMAIN ),
             $menu_text,
             'auto-mail'
         );
      }

      /**
		* Add addons page
		*
		* @since 1.0.0
		*/
		public function add_addons_page() {
			add_action( 'admin_menu', array( $this, 'init_addons_page' ) );
		}

		/**
		 * Initialize addons page
		 *
		 * @since 1.0.0
		 */
		public function init_addons_page() {
            $menu_text = '<span>'.__( 'Extensions ⇪', Auto_Mail::DOMAIN ) . '</span>';

			$this->pages['auto-mail-addons'] = new Auto_Mail_Addons_Page(
				'auto-mail-addons',
				'addons',
				__( 'Extensions', Auto_Mail::DOMAIN ),
                $menu_text,
                'auto-mail'
			);
		}

    }

endif;
