<?php
/**
 * Plugin Name: Auto Mail
 * Plugin URI: https://wpautomail.com
 * Description: Auto Mail - Abandoned Cart Recovery, Newsletter Builder & Marketing Automation for WooCommerce.
 * Version: 1.2.5
 * Author: wphobby
 * Author URI: https://wpautomail.com/pricing/
 *
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Set constants
 */
if ( ! defined( 'AUTO_MAIL_DIR' ) ) {
    define( 'AUTO_MAIL_DIR', plugin_dir_path(__FILE__) );
}

if ( ! defined( 'AUTO_MAIL_URL' ) ) {
    define( 'AUTO_MAIL_URL', plugin_dir_url(__FILE__) );
}

if ( ! defined( 'AUTO_MAIL_VERSION' ) ) {
    define( 'AUTO_MAIL_VERSION', '1.2.5' );
}

// Plugin Root File.
if ( ! defined( 'AUTO_MAIL_FILE' ) ) {
	define( 'AUTO_MAIL_FILE', __FILE__ );
}

if ( ! defined( 'AUTO_MAIL_SITE' ) ) {
    define( 'AUTO_MAIL_SITE', 'https://wpautomail.com' );
}

$upload_folder = wp_upload_dir();

if ( ! defined( 'AUTO_MAIL_UPLOAD_DIR' ) ) {
	define( 'AUTO_MAIL_UPLOAD_DIR', trailingslashit( $upload_folder['basedir'] ) );
}

define( 'AM_CART_ABANDONED_ORDER', 'abandoned' );
define( 'AM_CART_NORMAL_ORDER', 'normal' );
define( 'AM_CART_COMPLETED_ORDER', 'completed' );
define( 'AM_CART_LOST_ORDER', 'lost' );
define( 'AM_CART_FAILED_ORDER', 'failed' );

define( 'AM_CA_DATETIME_FORMAT', 'Y-m-d H:i:s' );

// Register activation hook
register_activation_hook( __FILE__, array( 'Auto_Mail', 'activation_hook' ) );

/**
 * Class Auto_Mail
 *
 * Main class. Initialize plugin
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'Auto_Mail' ) ) {
    /**
     * Auto_Mail
     */
    class Auto_Mail {

        const DOMAIN = 'auto-mail';

        /**
         * Instance of Auto_Mail
         *
         * @since  1.0.0
         * @var (Object) Auto_Mail
         */
        private static $_instance = null;

        /**
         * Get instance of Auto_Mail
         *
         * @since  1.0.0
         *
         * @return object Class object
         */
        public static function get_instance() {
            if ( ! isset( self::$_instance ) ) {
                self::$_instance = new self;
            }
            return self::$_instance;
        }

        /**
         * Constructor
         *
         * @since  1.0.0
         */
        private function __construct() {
            add_action( 'admin_init', array( $this, 'initialize_admin' ) );

            $this->includes();
            $this->init();
        }

        /**
		 * Called on plugin activation
		 *
		 * @since 1.0.0
		 */
		public static function activation_hook() {
			add_option( 'auto_mail_activation_hook', 'activated' );
		}

        /**
		 * Called on admin_init
		 *
		 * Flush rewrite rules are not called directly on activation hook, because CPT are not initialized yet
		 *
		 * @since 1.0.0
		 */
		public function initialize_admin() {
			if ( is_admin() && 'activated' === get_option( 'auto_mail_activation_hook' ) ) {
				delete_option( 'auto_mail_activation_hook' );
			}
		}

        /**
         * Load plugin files
         *
         * @since 1.0
         */
        private function includes() {
            // Autoload files.
            require_once AUTO_MAIL_DIR . '/vendor/autoload.php';

            // Core files.
            require_once AUTO_MAIL_DIR . '/includes/class-core.php';
        }


        /**
         * Init the plugin
         *
         * @since 1.0.0
         */
        private function init() {
            // Initialize plugin core
            $this->auto_mail_core = Auto_Mail_Core::get_instance();

            // Create tables
            $this->create_tables();

            // Initial Schedule Class for WP Cron Jobs
            Auto_Mail_Schedule::get_instance();

            // Initial Automation Class
            AM_Automation::get_instance();

            // Initial Cart Tracking Class
            AM_Cart_Tracking::get_instance();

            add_action( 'admin_init', array( $this, 'welcome' ) );

            /**
             * Triggered when plugin is loaded
             */
            do_action( 'auto_mail_loaded' );

            // Enqueue scripts
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

            // Add the settings link to a plugin on plugins page.
		    add_filter( 'plugin_action_links_' . plugin_basename( AUTO_MAIL_FILE ), array( $this, 'add_plugin_action_link'), 10, 3 );
        }

        /** Redirect to welcome page when activation */
        public function welcome()
        {
            $page_url = 'admin.php?page=auto-mail-automations';
            if ( !get_transient( '_auto_mail_activation_redirect' ) ) {
                return;
            }
            delete_transient( '_auto_mail_activation_redirect' );
            wp_safe_redirect( admin_url( $page_url ) );
            exit;
        }

        /**
	    * Add plugin action links on Plugins page (lite version only).
	    *
	    * @since 1.0.0
	    * @since 1.5.0 Added a link to Email Log.
	    * @since 2.0.0 Adjusted links. Process only the Lite plugin.
	    *
	    * @param array $links Existing plugin action links.
	    *
	    * @return array
	    */
	    public function add_plugin_action_link( $links ) {

		    $custom['pro'] = sprintf(
			    '<a href="%1$s" aria-label="%2$s" target="_blank" rel="noopener noreferrer"
				    style="color: #00a32a; font-weight: 700;"
				    onmouseover="this.style.color=\'#008a20\';"
				    onmouseout="this.style.color=\'#00a32a\';"
				    >%3$s</a>',
			    esc_url( 'https://wpautomail.com/pricing/' ),
			    esc_attr__( 'Upgrade to Auto Mail Pro', 'auto-mail' ),
			    esc_html__( 'Get Auto Mail Pro', 'auto-mail' )
		    );

		    $custom['settings'] = sprintf(
			    '<a href="%s" aria-label="%s">%s</a>',
			    esc_url( admin_url( 'admin.php?page=auto-mail-campaigns' ) ),
			    esc_attr__( 'Go to Auto Mail Newsletters page', 'auto-mail' ),
			    esc_html__( 'Newsletters', 'auto-mail' )
		    );

		    $custom['docs'] = sprintf(
			    '<a href="%1$s" target="_blank" aria-label="%2$s" rel="noopener noreferrer">%3$s</a>',
			    esc_url( 'https://wpautomail.com/document/' ),
			    esc_attr__( 'Go to Auto Mail Documentation page', 'auto-mail' ),
			    esc_html__( 'Docs', 'auto-mail' )
		    );

		    return array_merge( $custom, (array) $links );
	    }


        /**
        * Add enqueue scripts hooks
        *
        * @since 1.0.0
        *
        * @param $hook
        */
        public function enqueue_scripts( $hook ) {

            // Enqueue front styles
            $this->auto_mail_front_enqueue_styles();

            // Enqueue front scripts
            $this->auto_mail_front_enqueue_scripts();
        }

        /**
        * Enqueue front styles
        *
        * @since 1.0.0
        *
        * @param $version
        */
        function auto_mail_front_enqueue_styles() {
            wp_enqueue_style( 'auto-mail-front-style', AUTO_MAIL_URL . 'assets/css/front.css', array(), AUTO_MAIL_VERSION, false );
        }

        public function auto_mail_front_enqueue_scripts(){

            wp_register_script(
                'auto-mail-form-front',
                AUTO_MAIL_URL . '/assets/js/front/render-form.js',
                array(
                    'jquery'
                ),
                AUTO_MAIL_VERSION,
                true
            );

            wp_enqueue_script( 'auto-mail-form-front' );

            wp_register_script(
                'am-cart-tracking',
                AUTO_MAIL_URL . '/assets/js/front/cart-abandonment-tracking.js',
                array(
                    'jquery'
                ),
                AUTO_MAIL_VERSION,
                true
            );

            wp_enqueue_script( 'am-cart-tracking' );

            $data = array(
                'ajaxurl' => auto_mail_ajax_url(),
                '_ajax_nonce' => wp_create_nonce('auto-mail')
            );

            // Set js localize data
            wp_localize_script( 'auto-mail-form-front', 'Auto_Mail_Ajax_Front_Data', $data );
            wp_localize_script( 'am-cart-tracking', 'AM_Cart_Tracking_Data', $data );
        }

        /**
         * @since 1.0.0
         */
        public function render_form() {
            echo '<div style="background: green; color: white; text-align: right;">WPShout was here.</div>';
        }

        /**
         * @since 1.0.0
         */
        public static function create_tables() {
            global $wpdb;
            $wpdb->hide_errors();

            $table_schema = [
                "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}auto_mail_queue` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `camp_id` int(11) DEFAULT NULL,
                `status` ENUM('sending','sent','scheduled') NOT NULL DEFAULT 'scheduled',
                `subscriber` text DEFAULT NULL,
                `name` text DEFAULT NULL,
                `created_at` DECIMAL(16, 6) NOT NULL,
                `updated_at` DECIMAL(16, 6) NOT NULL,
                `deleted_at` DECIMAL(16, 6) NOT NULL,
                PRIMARY KEY (`id`)
                )  CHARACTER SET utf8 COLLATE utf8_general_ci;",

                "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}am_automation_actions` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                `automation_id` bigint DEFAULT NULL,
                `title` text DEFAULT NULL,
                `name` text DEFAULT NULL,
                `type` text DEFAULT NULL,
                `status` ENUM('active','draft') NOT NULL DEFAULT 'active',
                `position` int NOT NULL,
                `date` datetime NOT NULL,
                PRIMARY KEY (`id`)
                )  CHARACTER SET utf8 COLLATE utf8_general_ci;",

                "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}am_automation_actions_meta` (
                `meta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                `action_id` bigint DEFAULT NULL,
                `meta_key` VARCHAR(255),
                `meta_value` LONGTEXT,
                PRIMARY KEY (`meta_id`)
                )  CHARACTER SET utf8 COLLATE utf8_general_ci;",

                "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}am_automation_triggers` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                `automation_id` bigint DEFAULT NULL,
                `title` text DEFAULT NULL,
                `type` text DEFAULT NULL,
                `status` ENUM('active','draft') NOT NULL DEFAULT 'active',
                `position` int NOT NULL,
                `date` datetime NOT NULL,
                PRIMARY KEY (`id`)
                )  CHARACTER SET utf8 COLLATE utf8_general_ci;",

                "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}am_cart_abandonment` (
                id BIGINT(20) NOT NULL AUTO_INCREMENT,
                checkout_id int(11) NOT NULL,
                email VARCHAR(100),
                cart_contents LONGTEXT,
                cart_total DECIMAL(10,2),
                session_id VARCHAR(60) NOT NULL,
                other_fields LONGTEXT,
                order_status ENUM( 'normal','abandoned','completed','lost') NOT NULL DEFAULT 'normal',
                unsubscribed  boolean DEFAULT 0,
                coupon_code VARCHAR(50),
                time DATETIME DEFAULT NULL,
                PRIMARY KEY  (`id`, `session_id`),
                UNIQUE KEY `session_id_UNIQUE` (`session_id`)
                ) CHARACTER SET utf8 COLLATE utf8_general_ci;",

                "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}am_automation_emails` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                `status` ENUM('schedule','sent') NOT NULL DEFAULT 'schedule',
                `schedule_time` bigint NOT NULL,
                `subject` text DEFAULT NULL,
                `message` LONGTEXT DEFAULT NULL,
                `from` text DEFAULT NULL,
                `to` VARCHAR(100) DEFAULT NULL,
                PRIMARY KEY (`id`)
                )  CHARACTER SET utf8 COLLATE utf8_general_ci;",
            ];
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            foreach ( $table_schema as $table ) {
                dbDelta( $table );
            }
        }

    }
}

if ( ! function_exists( 'auto_mail' ) ) {
    function auto_mail() {
        return Auto_Mail::get_instance();
    }

    /**
     * Init the plugin and load the plugin instance
     *
     * @since 1.0.0
     */
    add_action( 'plugins_loaded', 'auto_mail' );
}

// Hook in all our important actions
add_action( 'plugins_loaded', 'pre_init', 50 );
add_action( 'plugins_loaded', 'post_init', 999 );

/**
* Init function
*
* @access      private
* @since       1.0.0
* @return      void
*/
function pre_init() {
    // Trigger our action to let other plugins know that Auto Mail is ready
    do_action( 'auto_mail_pre_init' );
}

/**
 * Post init function
 *
 * @access      private
 * @since       1.0.0
 * @return      void
*/
function post_init() {
    // Trigger our action to let other plugins know that Auto Mail has been initialized
    do_action( 'auto_mail_post_init' );
}

/**
 * Make custom post type meta data accessible on rest api
*/
add_action( 'rest_api_init', 'create_template_api' );

function create_template_api() {
    register_rest_route(
        'automail/v1',
        '/template',
        array(
            'methods'  => WP_REST_Server::READABLE,
            'callback' => 'auto_mail_get_api_template',
        )
    );
}

function auto_mail_get_api_template(WP_REST_Request $request) {
    $id = $request->get_param( 'id' );
    return get_post_meta( $id, 'auto_mail_form' );
}

function the_custom_post_status(){
    register_post_status( 'scheduled', array(
         'label'                     => _x( 'Scheduled', 'auto-mail' ),
         'public'                    => true,
         'show_in_admin_all_list'    => false,
         'show_in_admin_status_list' => true,
         'label_count'               => _n_noop( 'Scheduled <span class="count">(%s)</span>', 'Scheduled <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'the_custom_post_status' );

add_action('wp_footer', 'wpshout_action_example');
function wpshout_action_example() {
    echo '<div class="auto-mail-form-container"></div>';
}

/**
* Plugin install hook
*
* @since 1.8.0
* @return void
*/
if ( !function_exists( 'auto_mail_install' ) ) {
    function auto_mail_install()
    {
        // Hook for plugin install.
        do_action( 'auto_mail_install' );
        /*
         * Set activation redirect.
         */
        set_transient( '_auto_mail_activation_redirect', 1 );
    }

}
// When activated, trigger install method.
register_activation_hook( AUTO_MAIL_FILE, 'auto_mail_install' );

if ( ! function_exists( 'am_fs' ) ) {
    // Create a helper function for easy SDK access.
    function am_fs() {
        global $am_fs;

        if ( ! isset( $am_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $am_fs = fs_dynamic_init( array(
                'id'                  => '10397',
                'slug'                => 'auto-mail',
                'type'                => 'plugin',
                'public_key'          => 'pk_0eb01df6d8892fe84dc48e14aa8e6',
                'is_premium'          => false,
                'is_premium_only'     => false,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'menu'                => array(
                    'slug'           => 'auto-mail',
                    'first-path'     => 'admin.php?page=auto-mail',
                    'support'        => false,
                ),
            ) );
        }

        return $am_fs;
    }

    // Init Freemius.
    am_fs();
    // Signal that SDK was initiated.
    do_action( 'am_fs_loaded' );
}