<?php
/**
 * Integration Woocommerce Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Triggers
require_once plugin_dir_path( __FILE__ ) . 'triggers/cart-abandonment.php';

// Actions
require_once plugin_dir_path( __FILE__ ) . 'actions/schedule-email.php';