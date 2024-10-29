<?php
/**
 * Integration Actions Functions
 *
 * @since  1.0.0
 * @package Auto Mail
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Registers a new action
 *
 * @since 1.0.0
 *
 * @param string    $action The action key
 * @param array     $args   The action arguments
 */
function am_automation_register_action( $action, $args ) {

    $args = wp_parse_args( $args, array(
        'integration'       => '',
        'label'             => '',
        'select_option'     => '',
        'edit_label'        => '',
        'options'           => array(),
    ) );

    /**
     * Filter to extend registered action arguments
     *
     * @since 1.0.0
     *
     * @param array     $args   The action arguments
     * @param string    $action The action key
     *
     * @return array
     */
    $args = apply_filters( 'am_automation_register_action_args', $args, $action );

    // Sanitize options setup
    foreach( $args['options'] as $option => $option_args ) {

        if( in_array( $option, array( 'action', 'nonce', 'id', 'item_type', 'option_name' ) ) ) {
            _doing_it_wrong( __FUNCTION__, sprintf( __( 'Action "%s" has the option key "%s" that is not allowed', Auto_Mail::DOMAIN ), $action, $option ), null );
            return;
        }

    }

    if( isset( AM_Automation()->actions[$action] ) ) {
        error_log( sprintf( __( 'Possible action duplication with the key "%s"', Auto_Mail::DOMAIN ), $action ) );
    }

    AM_Automation()->actions[$action] = $args;

}

/**
 * Get automation actions
 *
 * @since 1.0.0
 *
 * @param int   $automation_id The automation id
 */
function am_automation_get_automation_actions( $automation_id ) {
    global $wpdb;
    $query = "
    SELECT * FROM " . $wpdb->prefix . "am_automation_actions
    WHERE automation_id = " . $automation_id;

    // $debug = var_export($query, true);
    // error_log( $debug );

    $actions = $wpdb->get_results($query);
    return $actions;
}

/**
 * Get the checkout details for the user.
 *
 * @param int $action_id.
 * @param string $meta_key.
 * @since 1.0.0
 */
function am_get_action_meta( $action_id, $meta_key ) {
	global $wpdb;
	$actions_meta_table = $wpdb->prefix . 'am_automation_actions_meta';
	$result                 = $wpdb->get_row(
        $wpdb->prepare('SELECT * FROM `' . $actions_meta_table . '` WHERE `action_id` = %s AND `meta_key` = %s', $action_id, $meta_key )
	);
	return $result;
}

/**
 * Get a action by template
 *
 * @since 1.0.0
 *
 * @param string $template
 *
 * @return string
 */
function am_get_actions_by_template( $template ) {

    $actions = array();

    switch ( $template ) {
        case 'abandoned-cart':
            $actions = array(
                '1' => array(
                    'name'=>'woo_schedule_email',
                    'subject' => 'Purchase issue?',
                    'content' => '<p>Hi {{customer.firstname}}!</p><p>We&#039;re having trouble processing your recent purchase. Would you mind completing it?</p><p>Here&#039;s a link to continue where you left off:</p><p><a href=&#039;{{cart.checkout_url}}&#039; target=&#039;_blank&#039; rel=&#039;noopener&#039;> Continue Your Purchase Now </a></p><p>Kindly,<br />{{admin.firstname}}<br />{{admin.company}}</p><p>{{cart.unsubscribe}}</p>',
                    'delay' => 3
                ),
                '2' => array(
                    'name'=>'woo_schedule_email',
                    'subject' => 'Need help?',
                    'content' => '<p>Hi {{customer.firstname}}!</p><p>I&#039;m {{admin.firstname}}, and I help handle customer issues at {{admin.company}}.</p><p>I just noticed that you tried to make a purchase, but unfortunately, there was some trouble. Is there anything I can do to help?</p><p>You should be able to complete your checkout in less than a minute:<br /><a href=&#039;{{cart.checkout_url}}&#039; target=&#039;_blank&#039; rel=&#039;noopener&#039;> Click here to continue your purchase </a><p><p>Thanks!<br />{{admin.firstname}}<br />{{admin.company}}</p><p>{{cart.unsubscribe}}</p>',
                    'delay' => 5
                ),
                '3' => array(
                    'name'=>'woo_schedule_email',
                    'subject' => 'Exclusive discount for you.',
                    'content' => '<p>Few days back you left {{cart.product.names}} in your cart.</p><p>To help make up your mind, we have added an exclusive 10% discount coupon {{cart.coupon_code}} to your cart.</p><p><a href=&#039;{{cart.checkout_url}}&#039; target=&#039;_blank&#039; rel=&#039;noopener&#039;>Complete Your Purchase Now >></a></p><p>Hurry! This is a onetime offer and will expire in 24 Hours.</p><p>In case you couldn&#039;t finish your order due to technical difficulties or because you need some help, just reply to this email we will be happy to help.</p><p>Kind Regards,<br />{{admin.firstname}}<br />{{admin.company}}</p><p>{{cart.unsubscribe}}</p>',
                    'delay' => 10
                )
            );
            break;
        default:
            break;
    }

    return $actions;
}

/**
 * Get a type by template
 *
 * @since 1.0.0
 *
 * @param string $template
 *
 * @return string
 */
function am_action_type_by_template( $template ) {

    $type = '';

    switch ( $template ) {
        case 'abandoned-cart':
            $type = 'woocommerce';
            break;
        default:
            break;
    }

    return $type;
}

/**
 * Add action data
 *
 * @since 1.0.0
 *
 */
function am_add_action( $automation_id, $action ) {
    global $wpdb;
    $automation_actions_table = $wpdb->prefix . 'am_automation_actions';
    $action_details = array(
        'automation_id' => $automation_id,
        'type' => $action['type'],
        'name' => $action['name'],
        'position' => $action['position'],
        'status' => 'active'
    );

    // Inserting row into database.
    $result = $wpdb->insert(
        $automation_actions_table,
        $action_details
    );

    return $wpdb->insert_id;
}

/**
 * Add action meta data
 *
 * @since 1.0.0
 *
 */
function am_add_action_meta( $action_id, $key, $value ) {

    global $wpdb;
    $automation_actions_meta_table = $wpdb->prefix . 'am_automation_actions_meta';

    $meta_details = array(
        'action_id' => $action_id,
        'meta_key' => $key,
        'meta_value' => $value
    );

    // Inserting row into database.
    $result = $wpdb->insert(
        $automation_actions_meta_table,
        $meta_details
    );

}

/**
 * Update action meta data
 *
 * @since 1.0.0
 *
 */
function am_update_action_meta( $action_id, $key, $value ) {

    global $wpdb;
    $automation_actions_meta_table = $wpdb->prefix . 'am_automation_actions_meta';

    $meta_details = array(
        'meta_value' => $value
    );

    $result = $wpdb->update(
        $automation_actions_meta_table,
        $meta_details,
        array( 'action_id' => $action_id ,'meta_key' => $key )
    );

    return $result;

}