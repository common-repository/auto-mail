<?php
/**
 * Send Email
 *
 * @since  1.0.0
 * @package Auto Mail
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class AM_Automation_WordPress_Send_Email extends AM_Automation_Integration_Action {

    public $integration = 'wordpress';
    public $action = 'wordpress_send_email';

    /**
     * Store the action result
     *
     * @since 1.0.0
     *
     * @var bool $result
     */
    public $result = false;

    /**
     * Register required hooks
     *
     * @since 1.0.0
     */
    public function hooks() {
        parent::hooks();
    }

    /**
     * Register the trigger
     *
     * @since 1.0.0
     */
    public function register() {

        am_automation_register_action( $this->action, array(
            'integration'       => $this->integration,
            'label'             => __( 'Send an email', Auto_Mail::DOMAIN ),
            'select_option'     => __( 'Send <strong>an email</strong>', Auto_Mail::DOMAIN ),
            /* translators: %1$s: Email. */
            'edit_label'        => sprintf( __( 'Send an email to %1$s', Auto_Mail::DOMAIN ), '{email}' ),
            /* translators: %1$s: Email. */
            'log_label'         => sprintf( __( 'Send an email to %1$s', Auto_Mail::DOMAIN ), '{email}' ),
            'options'           => array(
                'email' => array(
                    'from' => 'to',
                    'default' => __( 'user', Auto_Mail::DOMAIN ),
                    'fields' => array(
                        'from' => array(
                            'name' => __( 'From:', Auto_Mail::DOMAIN ),
                            'desc' => __( 'Leave empty to use default WordPress email.', Auto_Mail::DOMAIN ),
                            'type' => 'text',
                            'default' => ''
                        ),
                        'to' => array(
                            'name' => __( 'To:', Auto_Mail::DOMAIN ),
                            'desc' => __( 'Email address(es) to send the email. Accepts single or comma-separated list of emails.', Auto_Mail::DOMAIN )
                                . '<br>' . __( 'Leave empty to use the email of the user that completes the automation.', Auto_Mail::DOMAIN ),
                            'type' => 'text',
                            'default' => ''
                        ),
                        'cc' => array(
                            'name' => __( 'CC:', Auto_Mail::DOMAIN ),
                            'desc' => __( 'Email address(es) that will receive a copy of this email. Accepts single or comma-separated list of emails.', Auto_Mail::DOMAIN ),
                            'type' => 'text',
                            'default' => ''
                        ),
                        'bcc' => array(
                            'name' => __( 'BCC:', Auto_Mail::DOMAIN ),
                            'desc' => __( 'Email address(es) that will receive a copy of this email. Accepts single or comma-separated list of emails.', Auto_Mail::DOMAIN ),
                            'type' => 'text',
                            'default' => ''
                        ),
                        'subject' => array(
                            'name' => __( 'Subject:', Auto_Mail::DOMAIN ),
                            'desc' => __( 'Email\'s subject.', Auto_Mail::DOMAIN ),
                            'type' => 'text',
                            'required'  => true,
                            'default' => ''
                        ),
                        'content' => array(
                            'name' => __( 'Content:', Auto_Mail::DOMAIN ),
                            'desc' => __( 'Email\'s content.', Auto_Mail::DOMAIN ),
                            'type' => 'wysiwyg',
                            'required'  => true,
                            'default' => ''
                        ),
                    )
                )
            ),
        ) );

    }

    /**
     * Action execution function
     *
     * @since 1.0.0
     *
     * @param stdClass  $action             The action object
     * @param int       $user_id            The user ID
     * @param array     $action_options     The action's stored options (with tags already passed)
     */
    public function execute( $action, $user_id, $action_options) {
        // Shorthand
        $to = $action_options['to'];

        // $debug = var_export($to, true);
        // error_log( $debug );

        // Setup to
        if( empty( $to ) ) {
            $user = get_userdata( $user_id );
            $to = $user->user_email;
        }

        // Send the email
        $this->result = am_automation_send_email( array(
            // Email parameters
            'from'              => $action_options['from'],
            'to'                => $to,
            'cc'                => $action_options['cc'],
            'bcc'               => $action_options['bcc'],
            'subject'           => $action_options['subject'],
            'message'           => $action_options['message'],
            // Custom parameters
            'action'            => $action,
            'user_id'           => $user_id,
            'action_options'    => $action_options,
        ) );

    }

}

new AM_Automation_WordPress_Send_Email();