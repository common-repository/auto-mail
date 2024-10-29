<?php
/**
 * Integration Trigger Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class AM_Automation_WordPress_Login extends AM_Automation_Integration_Trigger {

    public $integration = 'wordpress';
    public $trigger = 'user-login';

    /**
     * Register the trigger
     *
     * @since 1.0.0
     */
    public function register() {

        am_automation_register_trigger( $this->trigger, array(
            'integration'       => $this->integration,
            'label'             => __( 'User login to the site', Auto_Mail::DOMAIN ),
            'select_option'     => __( 'User <strong>login </strong> to the site', Auto_Mail::DOMAIN ),
            'edit_label'        => __( 'User login to the site', Auto_Mail::DOMAIN ),
            'log_label'         => __( 'User login', Auto_Mail::DOMAIN ),
            'action'            => 'wp_login',
            'function'          => array( $this, 'listener' ),
            'priority'          => 10,
            'accepted_args'     => 2,
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
    public function listener( $user_login, $user ) {

        error_log( 'Automations log listener message for user login' );

        $user_id = $user->ID;

        am_automation_trigger_event( array(
            'trigger' => $this->trigger,
            'user_id' => $user_id,
        ) );

    }
}

new AM_Automation_WordPress_Login();