<?php
/**
 * Auto_Mail_Schedule Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Schedule' ) ) :

   class Auto_Mail_Schedule {

       /**
        * Plugin instance
        *
        * @var null
        */
       private static $instance = null;

       /**
        * Return the plugin instance
        *
        * @since 1.0.0
        * @return Auto_Mail_Schedule
        */
       public static function get_instance() {
           if ( is_null( self::$instance ) ) {
               self::$instance = new self();
           }

           return self::$instance;
       }

       /**
       * Auto_Mail_Schedule constructor.
       *
       * @since 1.0.0
       */
       public function __construct() {
           // Add a custom interval
           add_filter( 'cron_schedules', array( $this, 'am_add_cron_interval' ) );

           // Setup Cron Job
           $this->mail_cron_setup();

           // Setup Cron Job
           $this->automation_cron_setup();
       }

       /**
        * Add a custom interval
        *
        * @since 1.0.0
        */
       public function am_add_cron_interval( $schedules ) {
           $schedules = array(
                'once_am_a_minute' => array(
                    'interval' => 60,
                    'display'  => esc_html__( 'Once Auto Mail Job a Minute' )
                ),
                'once_am_two_minute' => array(
                    'interval' => 60*2,
                    'display'  => esc_html__( 'Once Auto Mail Job Two Minute' )
                ),
                'once_am_five_minute' => array(
                    'interval' => 60*5,
                    'display'  => esc_html__( 'Once Auto Mail Job Five Minute' )
                ),
                'once_am_ten_minute' => array(
                    'interval' => 60*10,
                    'display'  => esc_html__( 'Once Auto Mail Job Ten Minute' )
                ),
                'once_am_fifteen_minute' => array(
                    'interval' => 60*15,
                    'display'  => esc_html__( 'Once Auto Mail Job Fifteen Minute' )
                ),
                'once_am_thirty_minute' => array(
                    'interval' => 60*30,
                    'display'  => esc_html__( 'Once Auto Mail Job Thirty Minute' )
                ),
           );
           return $schedules;
       }

       /**
        * Setup Mail Cron Job
        *
        * @since 1.0.0
        */
       public function mail_cron_setup(){
         if ( ! wp_next_scheduled( 'am_cron_hook' ) ) {
            $settings = get_option('auto_mail_global_settings');
            $sending_frequency = isset($settings['sending_frequency']) ? $settings['sending_frequency'] : 30;

            switch ( $sending_frequency ) {
				case '1':
                    wp_schedule_event( time(), 'once_am_a_minute', 'am_cron_hook' );
					break;
				case '2':
                    wp_schedule_event( time(), 'once_am_two_minute', 'am_cron_hook' );
					break;
				case '5':
                    wp_schedule_event( time(), 'once_am_five_minute', 'am_cron_hook' );
					break;
				case '10':
                    wp_schedule_event( time(), 'once_am_ten_minute', 'am_cron_hook' );
					break;
				case '15':
                    wp_schedule_event( time(), 'once_am_fifteen_minute', 'am_cron_hook' );
					break;
				case '30':
                    wp_schedule_event( time(), 'once_am_thirty_minute', 'am_cron_hook' );
					break;
				default:
					break;
			}

         }

         // Add Cron Job Hook Function
         add_action( 'am_cron_hook', array( $this, 'am_cron_exec' )  );

       }

       /**
        * Cron Job Execute
        *
        * @since 1.0.0
        */
       public function am_cron_exec(){
           // Start auto mail sending job
           $job = new Auto_Mail_Sending_Job();
           $job->do_sending();
       }

       /**
        * Print Current Cron Jobs
        *
        * @since 1.0.0
        */
       public function am_print_tasks() {
           echo '<pre>'; print_r( _get_cron_array() ); echo '</pre>';
       }

       /**
        * Setup Automation Cron Job
        *
        * @since 1.0.0
        */
        public function automation_cron_setup(){
            if ( ! wp_next_scheduled( 'am_automation_cron_hook' ) ) {
                wp_schedule_event( time(), 'once_am_a_minute', 'am_automation_cron_hook' );
            }

            // Add Automation Cron Job Hook Function
            add_action( 'am_automation_cron_hook', array( $this, 'am_automation_cron_exec' )  );
        }

        /**
        * Automation Cron Job Execute
        *
        * @since 1.0.0
        */
        function am_automation_cron_exec() {
            // Run automations queue job here
            // $scheduledAutomations = array();
            // $automations = Auto_Mail_Automation_Model::model()->get_all_models();
            // foreach($automations['models'] as $key => $item){
            //     if($item->status == 'publish'){
            //         $scheduledAutomations[] = $item;
            //     }
            // }

            // foreach($scheduledAutomations as $key => $automation){
            //     $automation->settings['trigger'] = 'wordpress_register';
            //     $automation->settings['action'] = 'wordpress_send_email';
            //     $automation->settings['total_times'] = 100;
            //     $automation->settings['current_times'] = 5;
            //     // Run automations
            //     am_automation_run_automation( $automation->settings );
            // }

            // Run cart abandonment automations queue job here
            global $wpdb;
            $cart_abandonment_table = $wpdb->prefix . 'am_cart_abandonment';
		    $minutes = 1;

            $wp_current_datetime = current_time( AM_CA_DATETIME_FORMAT );
            $abandoneds       = $wpdb->get_results(
                 $wpdb->prepare( 'SELECT * FROM `' . $cart_abandonment_table . '` WHERE `order_status` = %s AND ADDDATE( `time`, INTERVAL %d MINUTE) <= %s', AM_CART_NORMAL_ORDER, $minutes, $wp_current_datetime )
            );

            foreach ( $abandoneds as $item ) {
                if ( isset( $item->session_id ) ) {
                    $current_session_id = $item->session_id;
                    $wpdb->update(
                        $cart_abandonment_table,
                        array(
                            'order_status' => AM_CART_ABANDONED_ORDER,
                        ),
                        array( 'session_id' => $current_session_id )
                    );
                    do_action('am_woo_cart_abandonment', $item->email);
                }
            }

            // Run schedule emails queue job here
            $schedule_emails_table = $wpdb->prefix . 'am_automation_emails';
            $schedule_emails       = $wpdb->get_results(
                $wpdb->prepare( 'SELECT * FROM `' . $schedule_emails_table . '` WHERE `status` = %s AND `schedule_time` <= %s', 'schedule', time() )
            );

            foreach ( $schedule_emails as $item ) {
                $email_args = array(
                    'from'          => $item->from,
                    'to'            => $item->to,
                    'subject'       => $item->subject,
                    'message'       => $item->message,
                );
                $result = am_automation_send_email($email_args);
                if($result){
                    $email_details = array(
                        'status' => 'sent'
                    );
                    $wpdb->update(
                        $schedule_emails_table,
                        $email_details,
                        array( 'id' => $item->id )
                    );
                }
            }
        }

   }

endif;
