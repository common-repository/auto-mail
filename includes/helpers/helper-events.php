<?php
/**
 * Events
 *
 * @since  1.0.0
 * @package Auto Mail
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Handles an event trigger
 *
 * @since 1.0.0
 *
 * @param array $event Event information
 *
 * @return array|false An array of triggered triggers or false if event is not correctly triggered
 */
function am_automation_trigger_event( $event ) {
    $automations = am_automation_get_automation_by_trigger($event['trigger']);

    // $debug = var_export($automations, true);
    // error_log( $debug );

    // $debug = var_export($event, true);
    // error_log( $debug );

    foreach($automations as $key => $automation){
        am_automation_execute_all_automation_actions($automation, $event['user_id'], $event);
    }
}

/**
 * Checks if event contains the required attributes (by default, user_id and trigger)
 *
 * @since 1.0.0
 *
 * @param array $event Event information
 *
 * @return bool
 */
function am_automation_is_event_correct( $event = array() ) {

    // Check trigger
    if( ! isset( $event['trigger'] ) ) {
        return false;
    }

    if( ! isset( AM_Automation()->triggers[$event['trigger']] ) ) {
        return false;
    }

    $trigger = AM_Automation()->triggers[$event['trigger']];

    // Check the user ID if trigger is not anonymous
    if( ! $trigger['anonymous'] ) {

        // Check user
        if( ! isset( $event['user_id'] ) ) {
            return false;
        }

        $event['user_id'] = absint( $event['user_id'] );

        if( $event['user_id'] === 0 ) {
            return false;
        }

    }

    /**
     * Filter to add custom checks to event checking
     *
     * @since 1.0.0
     *
     * @param bool  $is_correct If event is correct or not
     * @param array $event      Event information
     *
     * @return bool
     */
    return apply_filters( 'am_automation_is_event_correct', true, $event );

}

/**
 * Execute all automation actions
 *
 * @since 1.0.0
 *
 * @param stdClass  $automation         The automation object
 * @param int       $user_id            The user ID
 * @param array     $event              Event information
 *
 * @return bool
 */
function am_automation_execute_all_automation_actions( $automation_id = 0, $user_id = 0, $event = array() ) {

    // Check if automation is correct
    if( $automation_id === 0 ) {
        return false;
    }

    // Check the user ID
    if( $user_id === 0 ) {
        return false;
    }

    // Get all automation action to execute them
    $actions = am_automation_get_automation_actions( $automation_id );

    // $debug = var_export($actions, true);
    // error_log( $debug );

    foreach( $actions as $action ) {
        am_automation_execute_action( $action, $user_id, $event );
    }

    return true;

}

/**
 * Execute an action
 *
 * @since 1.0.0
 *
 * @param stdClass  $action             The action object
 * @param int       $user_id            The user ID
 * @param array     $event              Event information
 *
 * @return bool
 */
function am_automation_execute_action( $action = null, $user_id = 0, $event = array() ) {

    // Check if action is correct
    if( ! is_object( $action ) ) {
        return false;
    }

    // Check the user ID
    if( $user_id === 0 ) {
        return false;
    }

    // // Setup the automation assigned to this action
    // $automation = am_automation_get_automation_object( $action->automation_id );

    // // Check if automation is correct
    // if( ! is_object( $automation ) ) {
    //     return false;
    // }

    // Get all action options to parse all replacements
    //$action_options = am_automation_get_action_stored_options( $action->id );

    // $debug = var_export($action, true);
    // error_log( $debug );

    $subject = am_get_action_meta($action->id, 'subject');
    $content = am_get_action_meta($action->id, 'content');
    $delay = am_get_action_meta($action->id, 'delay');
    $unit = am_get_action_meta($action->id, 'unit');

    $schedule_time = time();
    if(isset($delay->meta_value)){
        $schedule_time = time() + am_calculate_schedule_time($delay->meta_value, $unit->meta_value);
    }

    $to = get_option('admin_email');

    if( isset( $event['user_id'] ) ) {
        $user = get_userdata( $event['user_id'] );
        $to = $user->user_email;
    }

    $action_options = array(
        'from' => get_option('admin_email'),
        'to' =>  $to,
        'cc' => '',
        'bcc' => '',
        'subject' => isset( $subject->meta_value ) ? $subject->meta_value : 'AM Automation Marketing',
        'message' => isset( $content->meta_value ) ? $content->meta_value : 'AM Automation Message Content',
        'schedule_time' => $schedule_time
    );

    $debug = var_export($action_options, true);
    error_log( $debug );

    /**
     * Available action to hook for execute an action function
     *
     * @since 1.0.0
     *
     * @param stdClass  $action             The action object
     * @param int       $user_id            The user ID
     * @param array     $event              Event information
     * @param array     $action_options     The action's stored options (with tags already passed)
     * @param stdClass  $automation         The action's automation object
     */
    do_action( 'am_automation_execute_action', $action, $user_id, $event, $action_options );

    return true;

}