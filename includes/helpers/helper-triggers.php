<?php
/**
 * Integration Trigger Functions
 *
 * @since  1.0.0
 * @package Auto Mail
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Registers a new trigger
 *
 * @since 1.0.0
 *
 * @param string    $trigger    The trigger key
 * @param array     $args       The trigger arguments
 */
function am_automation_register_trigger( $trigger, $args ) {

    $args = wp_parse_args( $args, array(
        'integration'       => '',
        'anonymous'         => false,
        'label'             => '',
        'select_option'     => '',
        'edit_label'        => '',
        'log_label'         => '',
        'action'            => '',
        'filter'            => '',
        'function'          => '',
        'priority'          => 10,
        'accepted_args'     => 1,
        'options'           => array(),
        'tags'              => array(),
    ) );

    /**
     * Filter to extend registered trigger arguments
     *
     * @since 1.0.0
     *
     * @param array     $args       The trigger arguments
     * @param string    $trigger    The trigger key
     *
     * @return array
     */
    $args = apply_filters( 'am_automation_register_trigger_args', $args, $trigger );

    // Sanitize options setup
    foreach( $args['options'] as $option => $option_args ) {

        if( in_array( $option, array( 'action', 'nonce', 'id', 'item_type', 'option_name' ) ) ) {
            _doing_it_wrong( __FUNCTION__, sprintf( __( 'Trigger "%s" has the option key "%s" that is not allowed', Auto_Mail::DOMAIN ), $trigger, $option ), null );
            return;
        }

    }

    if( isset( AM_Automation()->triggers[$trigger] ) ) {
        error_log( sprintf( __( 'Possible trigger duplication with the key "%s"', Auto_Mail::DOMAIN ), $trigger ) );
    }

    AM_Automation()->triggers[$trigger] = $args;
}

/**
 * Get automations by trigger
 *
 * @since 1.0.0
 *
 * @param string   $trigger The trigger name
 */
function am_automation_get_automation_by_trigger( $trigger ) {
    $automations = array();

    global $wpdb;
    $args = array(
        'post_type'      => 'am_automations',
        'post_status'    => 'publish',
    );
    $query  = new WP_Query( $args );

    foreach($query->posts as $key => $post){
        $meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE post_id = ".$post->ID);
        $meta_value = unserialize($meta[0]->meta_value);
        //$meta_value['settings']['trigger'] = 'woocommerce_cart_abandonment';
        if(isset($meta_value['settings']['trigger-name']) && $trigger == $meta_value['settings']['trigger-name']){
            $automations[] = $post->ID;
        }
    }

    return $automations;
}


/**
 * Get a trigger
 *
 * @since 1.0.0
 *
 * @param string $trigger
 *
 * @return array|false
 */
function am_automation_get_trigger( $trigger ) {

    $trigger_args = ( isset( AM_Automation()->triggers[$trigger] ) ? AM_Automation()->triggers[$trigger] : false );

    /**
     * Available filter to override the trigger args
     *
     * @since 1.0.0
     *
     * @param array|false $trigger_args
     * @param string $trigger
     *
     * @return array|false
     */
    return apply_filters( 'am_automation_get_trigger', $trigger_args, $trigger );

}

/**
 * Get a trigger by template
 *
 * @since 1.0.0
 *
 * @param string $template
 *
 * @return array|false
 */
function am_get_trigger_by_template( $template ) {

    $trigger = '';

    switch ( $template ) {
        case 'abandoned-cart':
            $trigger = 'woocommerce_cart_abandonment';
            break;
        default:
            break;
    }

    return $trigger;
}

/**
 * Get a type by template
 *
 * @since 1.0.0
 *
 * @param string $template
 *
 * @return array|false
 */
function am_trigger_type_by_template( $template ) {

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