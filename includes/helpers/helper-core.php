<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Return needed cap for admin pages
 *
 * @since 1.0.0
 * @return string
 */
function auto_mail_get_admin_cap() {
    $cap = 'manage_options';

    if ( is_multisite() && is_network_admin() ) {
        $cap = 'manage_network';
    }

    return apply_filters( 'auto_mail_admin_cap', $cap );
}

/**
 * Enqueue admin styles
 *
 * @since 1.0.0
 *
 * @param $version
 */
function auto_mail_admin_enqueue_styles( $version ) {
    wp_enqueue_style( 'auto-mail-main-style', AUTO_MAIL_URL . 'assets/css/admin/main.css', array(), $version, false );
    wp_enqueue_style( 'magnific-popup', AUTO_MAIL_URL . 'assets/css/magnific-popup.css', array(), $version, false );
}

/**
 * Enqueue admin dashboard scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_dashboard( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );
    wp_register_script(
        'auto-mail-dashboard',
        AUTO_MAIL_URL . 'assets/js/admin/dashboard.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-dashboard' );

    wp_localize_script( 'auto-mail-dashboard', 'Auto_Mail_Data', $data );
}

/**
 * Enqueue admin generator scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_generator( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );
    wp_register_script(
        'auto-mail-generator',
        AUTO_MAIL_URL . 'assets/js/admin/generator.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_register_script(
		'auto-mail-snap',
		AUTO_MAIL_URL . '/assets/js/library/snap.svg-min.js',
		array(),
		$version,
		true
	);

    wp_enqueue_script( 'auto-mail-snap' );

    wp_enqueue_script( 'auto-mail-generator' );

    wp_localize_script( 'auto-mail-generator', 'Auto_Mail_Data', $data );
}

function auto_mail_admin_enqueue_scripts_settings( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );
    wp_register_script(
        'auto-mail-settings',
        AUTO_MAIL_URL . 'assets/js/admin/settings.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-settings' );

    wp_localize_script( 'auto-mail-settings', 'Auto_Mail_Data', $data );
}

function auto_mail_admin_enqueue_scripts_setup( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );
    wp_register_script(
        'auto-mail-setup',
        AUTO_MAIL_URL . 'assets/js/admin/setup.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_register_script(
		'auto-mail-snap',
		AUTO_MAIL_URL . '/assets/js/library/snap.svg-min.js',
		array(),
		$version,
		true
	);

    wp_enqueue_script( 'auto-mail-snap' );

    wp_enqueue_script( 'auto-mail-setup' );

    wp_localize_script( 'auto-mail-setup', 'Auto_Mail_Data', $data );
}

function auto_mail_admin_enqueue_scripts_manage( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );
    wp_register_script(
        'auto-mail-manage',
        AUTO_MAIL_URL . 'assets/js/admin/manage.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-manage' );

    wp_localize_script( 'auto-mail-manage', 'Auto_Mail_Data', $data );
}

/**
 * Enqueue admin form list scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_form_list( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );

    wp_register_script(
		'auto-mail-snap',
		AUTO_MAIL_URL . '/assets/js/library/snap.svg-min.js',
		array(),
		$version,
		true
	);

    wp_enqueue_script( 'auto-mail-snap' );

    wp_register_script(
        'auto-mail-form-list',
        AUTO_MAIL_URL . 'assets/js/admin/form-list.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-form-list' );

    wp_localize_script( 'auto-mail-form-list', 'Auto_Mail_Data', $data );
}

/**
 * Enqueue admin form editor scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_form_edit( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );

    wp_register_script(
        'auto-mail-form-editor',
        AUTO_MAIL_URL . 'assets/js/admin/form-editor.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-form-editor' );

    wp_localize_script( 'auto-mail-form-editor', 'Auto_Mail_Data', $data );
}

/**
 * Enqueue admin automation list scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_automation_list( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );

    wp_enqueue_script( 'am-magnific-popup', AUTO_MAIL_URL . '/assets/js/library/jquery.magnific-popup.min.js', array( 'jquery' ), $version, false );

    wp_register_script(
        'auto-mail-automation-list',
        AUTO_MAIL_URL . 'assets/js/admin/automation-list.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-automation-list' );

    wp_localize_script( 'auto-mail-automation-list', 'Auto_Mail_Data', $data );
}

/**
 * Enqueue admin form editor scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_automation_edit( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );

    wp_register_script(
        'auto-mail-automation-editor',
        AUTO_MAIL_URL . 'assets/js/admin/automation-editor.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-automation-editor' );

    wp_localize_script( 'auto-mail-automation-editor', 'Auto_Mail_Data', $data );
}

/**
 * Enqueue admin subscriber list scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_subscriber_list( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );

    wp_register_script(
        'auto-mail-subscriber-list',
        AUTO_MAIL_URL . 'assets/js/admin/subscriber-list.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-subscriber-list' );

    wp_localize_script( 'auto-mail-subscriber-list', 'Auto_Mail_Data', $data );
}

/**
 * Enqueue admin form editor scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_subscriber_edit( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );

    wp_register_script(
        'auto-mail-subscriber-editor',
        AUTO_MAIL_URL . 'assets/js/admin/subscriber-editor.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-subscriber-editor' );

    wp_localize_script( 'auto-mail-subscriber-editor', 'Auto_Mail_Data', $data );
}

/**
 * Enqueue admin campaign list scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_campaign_list( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );

    wp_register_script(
        'auto-mail-campaign-list',
        AUTO_MAIL_URL . 'assets/js/admin/campaign-list.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-campaign-list' );

    wp_localize_script( 'auto-mail-campaign-list', 'Auto_Mail_Data', $data );
}

/**
 * Enqueue admin form editor scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_campaign_edit( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );
    wp_enqueue_script( 'auto-mail-react', AUTO_MAIL_URL . 'react_app/build/static/js/all_in_one_file.js', array(), $version, true );

    wp_register_script(
        'auto-mail-campaign-editor',
        AUTO_MAIL_URL . 'assets/js/admin/campaign-editor.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-campaign-editor' );

    wp_localize_script( 'auto-mail-campaign-editor', 'Auto_Mail_Data', $data );
}

/**
 * Enqueue admin list list scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_list_list( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );

    wp_register_script(
        'auto-mail-list-list',
        AUTO_MAIL_URL . 'assets/js/admin/list-list.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-list-list' );

    wp_localize_script( 'auto-mail-list-list', 'Auto_Mail_Data', $data );
}

/**
 * Enqueue admin form editor scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function auto_mail_admin_enqueue_scripts_list_edit( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.esm.js', array(), $version, false );
    wp_enqueue_script( 'ionicons-no-module', AUTO_MAIL_URL . 'assets/js/library/ionicons/ionicons.js', array(), $version, false );

    wp_register_script(
        'auto-mail-list-editor',
        AUTO_MAIL_URL . 'assets/js/admin/list-editor.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'auto-mail-list-editor' );

    wp_localize_script( 'auto-mail-list-editor', 'Auto_Mail_Data', $data );
}

/**
 * Return AJAX url
 *
 * @since 1.0.0
 * @return mixed
 */
function auto_mail_ajax_url() {
    return admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' );
}

/**
 * Return current action
 *
 * @since 1.0.0
 * @return mixed
 */
function auto_mail_current_action($current, $request) {

    if(empty($request) && $current == 'import'){
        return 'current';
    }else if($request == $current){
        return 'current';
    }

    return '';
}

/**
 * Return active tab
 *
 * @since 1.0.0
 * @return mixed
 */
function auto_mail_active_action($current, $request) {

    if(empty($request) && $current == 'import'){
        return 'active';
    }else if($request == $current){
        return 'active';
    }

    return '';
}

/**
*
*
* @param unknown $filename
* @param unknown $data     (optional)
* @param unknown $flags    (optional)
* @return unknown
*/
function am_export_file_put_contents( $filename, $data = '', $flags = 'w' ) {

        global $wp_filesystem;

        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

		if ( ! is_dir( dirname( $filename ) ) ) {
			wp_mkdir_p( dirname( $filename ) );
		}

		if ( $file_handle = fopen( $filename, $flags ) ) {
			fwrite( $file_handle, $data );
			fclose( $file_handle );
		}

		return is_file( $filename );
}

/**
 * Get template class name
 */
function auto_mail_template_class($template){
    $single_class = '';
    $free_version = array('restaurant', 'black', 'hotel');
    // get custom single class
    if(in_array($template, $free_version)){
        $single_class = 'auto-mail-template-button';
    }else{
        $single_class = 'auto-mail-pro-template-button';
    }
    return $single_class;
}

/**
 * Calculate schedule time
 *
 * @since 1.0.0
 * @return int
 */
function am_calculate_schedule_time($update_frequency, $update_frequency_unit){
    $time_length = 0;

    switch ( $update_frequency_unit ) {
        case 'Minutes':
            $time_length = $update_frequency*60;
            break;
        case 'Hours':
            $time_length = $update_frequency*60*60;
            break;
        case 'Days':
            $time_length = $update_frequency*60*60*24;
            break;
        default:
            break;
    }

    return $time_length;
}