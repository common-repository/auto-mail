<?php
/**
 * Integration Trigger Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class AM_Automation_Integration_Trigger {

    /**
     * Integration
     *
     * @since 1.0.0
     *
     * @var string $integration
     */
    public $integration = '';

    /**
     * Trigger
     *
     * @since 1.0.0
     *
     * @var string $trigger
     */
    public $trigger = '';

    public function __construct() {
        $this->hooks();
        $this->register();
    }

    /**
     * Register the required hooks
     *
     * @since 1.0.0
     */
    public function hooks() {

        if ( ! did_action( 'auto_mail_post_init' ) ) {
            // Default hook to register listener hook
            add_action('auto_mail_post_init', array( $this, 'register_listener_hook' ) );
        } else {
            // Hook for triggers registered from the theme's functions
            add_action( 'after_setup_theme', array( $this, 'register_listener_hook' ) );
        }

    }

    /**
     * Register the trigger
     *
     * @since 1.0.0
     */
    public function register() {
        // Override
    }

    /**
     * Register the trigger listener hook
     *
     * @since 1.0.0
     */
    public function register_listener_hook() {

        // Get the trigger args
        $trigger = am_automation_get_trigger( $this->trigger );

        //error_log( 'AM register hook' );

        //error_log( var_dump($trigger) );

        // Bail if trigger not registered
        if( ! $trigger ) {
            return;
        }

        // Bail if not action or filter is provided
        if( empty( $trigger['action'] ) ) {
            return;
        }

        // Bail if not callback function is provided
        if( empty( $trigger['function'] ) ) {
            return;
        }

        // Register the trigger hook (action or filter)
        if( ! empty( $trigger['action'] ) ) {

            // Ensure that is an array
            if( ! is_array( $trigger['action'] ) ) {
                $trigger['action'] = array( $trigger['action'] );
            }

            // Add all the actions
            foreach( $trigger['action'] as $action ) {
                add_action( $action, $trigger['function'], $trigger['priority'], $trigger['accepted_args'] );
            }

        }
    }
}