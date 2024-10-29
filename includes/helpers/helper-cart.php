<?php
/**
 * Sanitize post array.
 *
 * @return array
*/
function am_sanitize_post_data() {

	$input_post_values = array(
			'wcf_billing_company'     => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_email'               => array(
				'default'  => '',
				'sanitize' => FILTER_SANITIZE_EMAIL,
			),
			'wcf_billing_address_1'   => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_billing_address_2'   => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_billing_state'       => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_billing_postcode'    => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_shipping_first_name' => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_shipping_last_name'  => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_shipping_company'    => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_shipping_country'    => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_shipping_address_1'  => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_shipping_address_2'  => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_shipping_city'       => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_shipping_state'      => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_shipping_postcode'   => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_order_comments'      => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_name'                => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_surname'             => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_phone'               => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_country'             => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_city'                => array(
				'default'  => '',
				'sanitize' => 'FILTER_SANITIZE_STRING',
			),
			'wcf_post_id'             => array(
				'default'  => 0,
				'sanitize' => FILTER_SANITIZE_NUMBER_INT,
			),

		    );

	$sanitized_post = array();
		foreach ( $input_post_values as $key => $input_post_value ) {

			    if ( isset( $_POST[ $key ] ) ) {
				    if ( 'FILTER_SANITIZE_STRING' === $input_post_value['sanitize'] ) {
					    $sanitized_post[ $key ] = am_sanitize_text_filter( $key, 'POST' );
				    } else {
					    $sanitized_post[ $key ] = filter_input( INPUT_POST, $key, $input_post_value['sanitize'] );
				    }
			    } else {
				    $sanitized_post[ $key ] = $input_post_value['default'];
			    }
		}
	 return $sanitized_post;

}

/**
 * Sanitize text field.
 *
 * @param string $key field key to sanitize.
 * @param string $method method type.
*/
function am_sanitize_text_filter( $key, $method = 'POST' ) {

		$sanitized_value = '';

		if ( 'POST' === $method && isset( $_POST[ $key ] ) ) {
			$sanitized_value = sanitize_text_field( wp_unslash( $_POST[ $key ] ) );
		}

		if ( 'GET' === $method && isset( $_GET[ $key ] ) ) {
			$sanitized_value = sanitize_text_field( wp_unslash( $_GET[ $key ] ) );
		}

		return $sanitized_value;
}

/**
 * Get the checkout details for the user.
 *
 * @param string $wcf_session_id checkout page session id.
 * @since 1.0.0
 */
function am_get_checkout_details( $wcf_session_id ) {
	global $wpdb;
	$cart_abandonment_table = $wpdb->prefix . 'am_cart_abandonment';
	$result                 = $wpdb->get_row(
        $wpdb->prepare('SELECT * FROM `' . $cart_abandonment_table . '` WHERE session_id = %s', $wcf_session_id )
	);
	return $result;
}

/**
 * Get the checkout details for the user.
 *
 * @param string $email user email.
 * @since 1.0.0
 */
function am_get_checkout_details_by_email( $email ) {
	global $wpdb;
	$cart_abandonment_table = $wpdb->prefix . 'am_cart_abandonment';
	$result                 = $wpdb->get_row(
        $wpdb->prepare('SELECT * FROM `' . $cart_abandonment_table . '` WHERE email = %s AND `order_status` IN ( %s, %s )', $email, AM_CART_ABANDONED_ORDER, AM_CART_NORMAL_ORDER )
    );
	return $result;
}

/**
 * Prepare cart data to save for abandonment.
 *
 * @param array $post_data post data.
 * @return array
 */
function am_prepare_abandonment_data( $post_data = array() ) {

		if ( function_exists( 'WC' ) ) {

			// Retrieving cart total value and currency.
			$cart_total = WC()->cart->total;

			$payment_gateway = WC()->session->chosen_payment_method;

			// Retrieving cart products and their quantities.
			$products     = WC()->cart->get_cart();
			$current_time = current_time( AM_CA_DATETIME_FORMAT );
			$other_fields = array(
				'wcf_billing_company'     => $post_data['wcf_billing_company'],
				'wcf_billing_address_1'   => $post_data['wcf_billing_address_1'],
				'wcf_billing_address_2'   => $post_data['wcf_billing_address_2'],
				'wcf_billing_state'       => $post_data['wcf_billing_state'],
				'wcf_billing_postcode'    => $post_data['wcf_billing_postcode'],
				'wcf_shipping_first_name' => $post_data['wcf_shipping_first_name'],
				'wcf_shipping_last_name'  => $post_data['wcf_shipping_last_name'],
				'wcf_shipping_company'    => $post_data['wcf_shipping_company'],
				'wcf_shipping_country'    => $post_data['wcf_shipping_country'],
				'wcf_shipping_address_1'  => $post_data['wcf_shipping_address_1'],
				'wcf_shipping_address_2'  => $post_data['wcf_shipping_address_2'],
				'wcf_shipping_city'       => $post_data['wcf_shipping_city'],
				'wcf_shipping_state'      => $post_data['wcf_shipping_state'],
				'wcf_shipping_postcode'   => $post_data['wcf_shipping_postcode'],
				'wcf_order_comments'      => $post_data['wcf_order_comments'],
				'wcf_first_name'          => $post_data['wcf_name'],
				'wcf_last_name'           => $post_data['wcf_surname'],
				'wcf_phone_number'        => $post_data['wcf_phone'],
				'wcf_location'            => $post_data['wcf_country'] . ', ' . $post_data['wcf_city'],
			);

			$checkout_details = apply_filters(
				'woo_ca_session_abandoned_data',
				array(
					'email'         => $post_data['wcf_email'],
					'cart_contents' => serialize( $products ),
					'cart_total'    => sanitize_text_field( $cart_total ),
					'time'          => sanitize_text_field( $current_time ),
					'other_fields'  => serialize( $other_fields ),
					'checkout_id'   => $post_data['wcf_post_id'],
				)
			);
		}
		return $checkout_details;
}

/**
* Get the acceptable order statuses.
*/
function am_get_acceptable_order_statuses() {

	$acceptable_order_statuses = array( 'processing', 'completed' );
	$acceptable_order_statuses = array_map( 'strtolower', $acceptable_order_statuses );

	return $acceptable_order_statuses;
}

/**
 * Fetch all the scheduled emails with templates for the specific session.
 *
 * @param string  $session_id session id.
 * @param boolean $fetch_sent sfetch sent emails.
 * @return array|object|null
 */
function am_fetch_scheduled_emails( $session_id, $fetch_sent = false ) {
		global $wpdb;
		$email_history_table  = $wpdb->prefix . CARTFLOWS_CA_EMAIL_HISTORY_TABLE;
		$email_template_table = $wpdb->prefix . CARTFLOWS_CA_EMAIL_TEMPLATE_TABLE;

		$query =   $wpdb->prepare("SELECT * FROM  $email_history_table as eht INNER JOIN $email_template_table as ett ON eht.template_id = ett.id WHERE ca_session_id = %s", sanitize_text_field($session_id)); // phpcs:ignore

		if ( $fetch_sent ) {
			$query .= ' AND email_sent = 1';
		}

		$result = $wpdb->get_results( $query ); // phpcs:ignore
		return $result;
	}