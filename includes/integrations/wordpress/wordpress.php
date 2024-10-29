<?php
/**
 * Integration Trigger Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Triggers
require_once plugin_dir_path( __FILE__ ) . 'triggers/register.php';
require_once plugin_dir_path( __FILE__ ) . 'triggers/login.php';

// Actions
require_once plugin_dir_path( __FILE__ ) . 'actions/send-email.php';