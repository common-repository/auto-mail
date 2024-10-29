<?php
/**
 * Integration Trigger Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class AM_Automation_Woo_Cart_Abandonment extends AM_Automation_Integration_Trigger {

    public $integration = 'woocommerce';
    public $trigger = 'woocommerce_cart_abandonment';

    /**
     * Register the trigger
     *
     * @since 1.0.0
     */
    public function register() {

        am_automation_register_trigger( $this->trigger, array(
            'integration'       => $this->integration,
            'label'             => __( 'User abandon woocommerce cart', Auto_Mail::DOMAIN ),
            'select_option'     => __( 'User abandon woocommerce cart', Auto_Mail::DOMAIN ),
            'edit_label'        => __( 'User abandon woocommerce cart', Auto_Mail::DOMAIN ),
            'log_label'         => __( 'User abandon woocommerce cart', Auto_Mail::DOMAIN ),
            'action'            => 'am_woo_cart_abandonment',
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
    public function listener( $user_email ) {

        error_log( 'Automations log listener for woo cart abandonment' );

        // $debug = var_export($email, true);
        // error_log( $debug );

        am_automation_trigger_event( array(
            'trigger' => $this->trigger,
            'user_email' => $user_email,
            'user_id' => 1
        ) );

    }
}

new AM_Automation_Woo_Cart_Abandonment();