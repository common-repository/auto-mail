<?php
/**
 * AM_Cart_Tracking Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'AM_Cart_Tracking' ) ) :

   class AM_Cart_Tracking {

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
        * @return AM_Cart_Tracking
        */
       public static function get_instance() {
           if ( is_null( self::$instance ) ) {
               self::$instance = new self();
           }

           return self::$instance;
       }

       /**
       * AM_Cart_Tracking constructor.
       *
       * @since 1.0.0
       */
       public function __construct() {
            // Delete the stored cart abandonment data once order gets created.
            // add_action( 'woocommerce_new_order', array( $this, 'delete_cart_abandonment_data' ) );
            // add_action( 'woocommerce_thankyou', array( $this, 'delete_cart_abandonment_data' ) );
			add_action( 'woocommerce_order_status_changed', array( $this, 'am_update_order_status' ), 999, 3 );
       }

       /**
	 	* Deletes cart abandonment tracking and scheduled event.
	 	*
	 	* @param int $order_id Order ID.
	 	* @since 1.0.0
	 	*/
		public function delete_cart_abandonment_data( $order_id ) {

			$acceptable_order_statuses = array( 'processing', 'completed' );

			$order        = wc_get_order( $order_id );
			$order_status = $order->get_status();
			if ( ! in_array( $order_status, $acceptable_order_statuses, true ) ) {
				// Proceed if order status in completed or processing.
				return;
			}

			global $wpdb;
			$cart_abandonment_table = $wpdb->prefix . 'am_cart_abandonment';

			if ( isset( WC()->session ) ) {
				$session_id = WC()->session->get( 'wcf_session_id' );

				if ( isset( $session_id ) ) {
					$checkout_details = am_get_checkout_details( $session_id );

						if ( $checkout_details && ( AM_CART_ABANDONED_ORDER === $checkout_details->order_status || AM_CART_LOST_ORDER === $checkout_details->order_status ) ) {

							$order = wc_get_order( $order_id );
							$note  = __( 'This order was abandoned & subsequently recovered.', Auto_Mail::DOMAIN );
							$order->add_order_note( $note );
							$order->save();

						} elseif ( AM_CART_COMPLETED_ORDER !== $checkout_details->order_status ) {
							$wpdb->delete( $cart_abandonment_table, array( 'session_id' => sanitize_key( $session_id ) ) );
						}

				}
				if ( WC()->session ) {
					WC()->session->__unset( 'wcf_session_id' );
				}
			}
		}


		/**
	 	* Update the Order status.
	 	*
	 	* @param integer $order_id order id.
	 	* @param string  $old_order_status old order status.
	 	* @param string  $new_order_status new order status.
	 	*/
		public function am_update_order_status( $order_id, $old_order_status, $new_order_status ) {

			$acceptable_order_statuses = array( 'processing', 'completed' );

			if ( ( AM_CART_FAILED_ORDER === $new_order_status ) ) {
				return;
			}

			if ( $order_id && in_array( $new_order_status, $acceptable_order_statuses, true ) ) {

				$order = wc_get_order( $order_id );

				$order_email   = $order->get_billing_email();
				$captured_data = $this->get_captured_data_by_email( $order_email );

				if ( $captured_data && is_object( $captured_data ) ) {
					$capture_status = $captured_data->order_status;
					global $wpdb;
					$cart_abandonment_table = $wpdb->prefix . 'am_cart_abandonment';

					if ( ( AM_CART_NORMAL_ORDER === $capture_status ) ) {
						$wpdb->delete( $cart_abandonment_table, array( 'session_id' => sanitize_key( $captured_data->session_id ) ) );
					}
				}

			}

		}

		/**
	 	* Get the checkout details for the user.
	 	*
	 	* @param string $value value.
	 	* @since 1.0.0
	 	*/
		public function get_captured_data_by_email( $value ) {
			global $wpdb;
			$cart_abandonment_table = $wpdb->prefix . 'am_cart_abandonment';
			$result                 = $wpdb->get_row(
				$wpdb->prepare(
					'SELECT * FROM `' . $cart_abandonment_table . '` WHERE email = %s ORDER BY `time` DESC LIMIT 1', $value )
			);
			return $result;
		}

}

endif;
