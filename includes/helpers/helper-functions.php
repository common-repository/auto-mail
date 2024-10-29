<?php
/**
 * Helper Functions
 *
 * @since  1.0.0
 * @package Auto Mail
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Helper function to send an email
 *
 * @since 1.4.0
 *
 * @param array $args   Arguments passed to this function.
 *                      Note: Pass additional args to be used in the function's filters
 *
 * @return bool         Whether the email contents were sent successfully.
 */
function am_automation_send_email( $args = array() ) {

    // Parse the email required args
    $email = wp_parse_args( $args, array(
        'from'          => '',
        'to'            => '',
        'cc'            => '',
        'bcc'           => '',
        'subject'       => '',
        'message'       => '',
        'headers'       => array(),
        'attachments'   => array(),
    ) );

    /**
     * Filter available to override the email arguments before process them
     *
     * @since 1.4.0
     *
     * @param array     $email  The email arguments
     * @param array     $args   The original arguments received
     *
     * @return array
     */
    $email = apply_filters( 'am_automation_pre_email_args', $email, $args );

    // Setup subject
    $email['subject'] = do_shortcode( $email['subject'] );

    // Setup message
    $email['message'] = wpautop( $email['message'] );
    $email['message'] = do_shortcode( $email['message'] );

    // Setup headers
    if( ! is_array( $email['headers'] ) ) {
        $email['headers'] = array();
    }

    if( ! empty( $email['from'] ) ) {
        $email['headers'][] = 'From: <' . $email['from'] . '>';
    }

    if ( ! empty( $email['cc'] ) ) {
        $email['headers'][] = 'Cc: ' . $email['cc'];
    }

    if ( ! empty( $email['bcc'] ) ) {
        $email['headers'][] = 'Bcc: ' . $email['bcc'];
    }

    $email['headers'][] = 'Content-Type: text/html; charset='  . get_option( 'blog_charset' );

    // Setup attachments
    if( ! is_array( $email['attachments'] ) ) {
        $email['attachments'] = array();
    }

    /**
     * Filter available to override the email arguments after process them
     *
     * @since 1.4.0
     *
     * @param array     $email  The email arguments
     * @param array     $args   The original arguments received
     *
     * @return array
     */
    $email = apply_filters( 'am_automation_email_args', $email, $args );

    add_filter( 'wp_mail_content_type', 'am_automation_set_html_content_type' );

    // Send the email
    $result = wp_mail( $email['to'], $email['subject'], $email['message'], $email['headers'], $email['attachments'] );

    remove_filter( 'wp_mail_content_type', 'am_automation_set_html_content_type' );

    /**
     * Filter available to decide to log email errors or not
     *
     * @since 1.4.0
     *
     * @param bool      $log_errors Whatever to log email errors or not, by default true
     * @param array     $email      The email arguments
     * @param array     $args       The original arguments received
     *
     * @return bool
     */
    $log_errors = apply_filters( 'am_automation_log_email_errors', true, $email, $args );

    if( ! $result && $log_errors === true) {
        $log_message = sprintf(
            __( "[AM_Automation] Email failed to send to %s with subject: %s", Auto_Mail::DOMAIN ),
            ( is_array( $email['to'] ) ? implode( ',', $email['to'] ) : $email['to'] ),
            $email['subject']
        );

        error_log( $log_message );
    }

    return $result;

}

/**
 * Function to set the mail content type
 *
 * @since 1.0.0
 *
 * @param string $content_type
 *
 * @return string
 */
function am_automation_set_html_content_type( $content_type = 'text/html' ) {
    return 'text/html';
}

/**
 * Function to set the mail content type
 *
 * @since 1.0.0
 *
 * @param string $content_type
 *
 * @return string
 */
function am_woo_schedule_email( $args = array() ) {
    global $wpdb;
    $schedule_emails_table = $wpdb->prefix . 'am_automation_emails';

    $email_details = array(
        // Email parameters
        'from'              => $args['from'],
        'to'                => $args['to'],
        'subject'           => $args['subject'],
        'message'           => $args['message'],
        'status'            => 'schedule',
        'schedule_time'     => $args['schedule_time']
    );

    // Inserting row into Database.
    $wpdb->insert(
        $schedule_emails_table,
        $email_details
    );
}