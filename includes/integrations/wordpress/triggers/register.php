<?php
/**
 * Integration Trigger Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class AM_Automation_WordPress_Register extends AM_Automation_Integration_Trigger {

    public $integration = 'wordpress';
    public $trigger = 'user-created';

    /**
     * Register the trigger
     *
     * @since 1.0.0
     */
    public function register() {

        am_automation_register_trigger( $this->trigger, array(
            'integration'       => $this->integration,
            'label'             => __( 'User registers to the site', Auto_Mail::DOMAIN ),
            'select_option'     => __( 'User <strong>registers</strong> to the site', Auto_Mail::DOMAIN ),
            'edit_label'        => __( 'User registers to the site', Auto_Mail::DOMAIN ),
            'log_label'         => __( 'User registers', Auto_Mail::DOMAIN ),
            'action'            => 'user_register',
            'function'          => array( $this, 'listener' ),
            'priority'          => 10,
            'accepted_args'     => 1,
            'options'           => array(
                // No options
            ),
            'tags' => array(
                // No tags
            )
        ) );

    }

    /**
     * Trigger listener
     *
     * @since 1.0.0
     *
     * @param int $user_id New registered user ID
     */
    public function listener( $user_id ) {

        error_log( 'Automations log listener message' );

        am_automation_trigger_event( array(
            'trigger' => $this->trigger,
            'user_id' => $user_id,
        ) );

    }
}

new AM_Automation_WordPress_Register();