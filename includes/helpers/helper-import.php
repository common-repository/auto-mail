<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 *
 *
 * @param unknown $option
 * @param unknown $fallback (optional)
 * @return unknown
 */
function auto_mail_text( $option, $fallback = '' ) {

	$auto_mail_texts = auto_mail_texts();

	$string = isset( $auto_mail_texts[ $option ] ) ? $auto_mail_texts[ $option ] : $fallback;

	return apply_filters( 'auto_mail_text', $string, $option, $fallback );
}


/**
 *
 *
 * @return unknown
 */
function auto_mail_texts() {
	return get_option( 'auto_mail_texts', array() );
}

/**
	 *
	 *
	 * @param unknown $filename
	 * @param unknown $data     (optional)
	 * @param unknown $flags    (optional)
	 * @return unknown
	 */
function auto_mail_file_put_contents( $filename, $data = '', $flags = 'w' ) {

		auto_mail_require_filesystem();

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
 *
 *
 * @param unknown $redirect (optional)
 * @param unknown $method   (optional)
 * @param unknown $showform (optional)
 * @return unknown
 */
function auto_mail_require_filesystem( $redirect = '', $method = '', $showform = true ) {

	global $wp_filesystem;

	// force direct method
	add_filter(
		'filesystem_method',
		function() {
			return 'direct';
		}
	);

	if ( ! function_exists( 'request_filesystem_credentials' ) ) {

		require_once ABSPATH . 'wp-admin/includes/file.php';

	}

	ob_start();

	if ( false === ( $credentials = request_filesystem_credentials( $redirect, $method ) ) ) {
		$data = ob_get_contents();
		ob_end_clean();
		if ( ! empty( $data ) ) {
			include_once ABSPATH . 'wp-admin/admin-header.php';
			echo esc_html($data);
			include ABSPATH . 'wp-admin/admin-footer.php';
			exit;
		}
		return false;
	}

	if ( ! $showform ) {
		return false;
	}

	if ( ! WP_Filesystem( $credentials ) ) {
		request_filesystem_credentials( $redirect, $method, true ); // Failed to connect, Error and request again
		$data = ob_get_contents();
		ob_end_clean();
		if ( ! empty( $data ) ) {
			include_once ABSPATH . 'wp-admin/admin-header.php';
			echo esc_html($data);
			include ABSPATH . 'wp-admin/admin-footer.php';
			exit;
		}
		return false;
	}

	return $wp_filesystem;

}

/**
 *
 *
 * @param unknown $email
 * @return unknown
 */
function auto_mail_is_email( $email ) {

	$pre_check = apply_filters( 'auto_mail_is_email', null, $email );
	if ( ! is_null( $pre_check ) ) {
		return (bool) $pre_check;
	}

	// First, we check that there's one @ symbol, and that the lengths are right
	if ( ! preg_match( '/^[^@]{1,64}@[^@]{1,255}$/', $email ) ) {
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	// Split it into sections to make life easier
	$email_array = explode( '@', $email );
	$local_array = explode( '.', $email_array[0] );
	for ( $i = 0; $i < sizeof( $local_array ); $i++ ) {
		if ( ! preg_match( "/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[ $i ] ) ) {
			return false;
		}
	}
	if ( ! preg_match( '/^\[?[0-9\.]+\]?$/', $email_array[1] ) ) {
		// Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode( '.', $email_array[1] );
		if ( sizeof( $domain_array ) < 2 ) {
			return false; // Not enough parts to domain
		}
		for ( $i = 0; $i < sizeof( $domain_array ); $i++ ) {
			if ( ! preg_match( '/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/', $domain_array[ $i ] ) ) {
				return false;
			}
		}
	}

	return true;

}