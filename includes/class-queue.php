<?php
/**
 * Auto Mail Queue Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Auto_Mail_Queue' ) ) :

	/**
	 * Auto Mail Queue
	 */
	class Auto_Mail_Queue {

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
        }

        /**
         * Total subscribers for each campaign.
         *
         * @since 1.0.0
         */
        public static function total_subscribers_amonut( $campaign_id ) {
            global $wpdb;
            $query = "
            SELECT * FROM " . $wpdb->prefix . "auto_mail_queue
            WHERE camp_id = " . $campaign_id;
            $wpdb->get_results($query);

            $rowcount = $wpdb->num_rows;

            return $rowcount;
        }

        /**
         * Sent subscribers for each campaign.
         *
         * @since 1.0.0
         */
        public static function sent_subscribers_amonut( $campaign_id ) {
            global $wpdb;
            $query = "
            SELECT * FROM " . $wpdb->prefix . "auto_mail_queue
            WHERE status = 'sent' AND
            camp_id = " . $campaign_id;
            $wpdb->get_results($query);

            $rowcount = $wpdb->num_rows;

            return $rowcount;
        }

        /**
         * Add new subscriber to sending queue.
         *
         * @since 1.0.0
         */
        public function add( $campaign_id, $subscriber, $name ) {
            $this->campaign_id = $campaign_id;

            global $wpdb;
            $wpdb->insert(
				"{$wpdb->prefix}auto_mail_queue",
				array(
					'camp_id'    =>  $this->campaign_id,
                    'subscriber' =>  $subscriber,
                    'name' =>  $name,
					'created_at' =>  microtime( true ),
				)
			);
        }

        /**
         * Prepare Subscribers.
         *
         * @since 1.1.0
         * @param string $content content to be saved to the file.
         */
        public static function prepare_subscribers($id, $limit) {
            global $wpdb;
            $query = "
            SELECT * FROM " . $wpdb->prefix . "auto_mail_queue
            WHERE status = 'scheduled' AND
            camp_id = " . $id . ' LIMIT ' . $limit;
            $tasks = $wpdb->get_results($query);

            return $tasks;
        }

        /**
         * Mark email send.
         *
         * @since 1.1.0
         */
        public static function mark_email_send($id) {
            global $wpdb;
            $table_name  = $wpdb->prefix."auto_mail_queue";
            $wpdb->query( $wpdb->prepare("UPDATE $table_name
                    SET status = %s
                WHERE id = %s",'sent', $id));
        }

    }

endif;
