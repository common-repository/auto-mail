<?php
/**
 * Auto_Mail_Upload_Import Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Upload_Import' ) ) :

class Auto_Mail_Upload_Import extends Auto_Mail_Import{
	protected $type = 'upload';
	protected $name = 'Upload';

	private $api;

	function init() {}


	public function get_import_part( &$import_data ) {

		$raw_data = file_get_contents( $import_data['file'] );
		$data     = maybe_unserialize( $raw_data );
		$limit    = $import_data['performance'] ? 10 : 2500;
		$offset   = ( $import_data['page'] - 1 ) * $limit;

		return array_slice( $data, $offset, $limit );

	}

	public function get_import_data($file_tmp_name) {

		$raw_data    = file_get_contents( $file_tmp_name );
		$header      = null;
		$sample_size = 10;

		$encoding = mb_detect_encoding( $raw_data, 'auto' );

		if ( function_exists( 'mb_convert_encoding' ) ) {
			$raw_data = mb_convert_encoding( $raw_data, 'UTF-8', mb_detect_encoding( $raw_data, 'UTF-8, ISO-8859-1', true ) );
		}

		$raw_data = trim( $raw_data );

		$total_lines = substr_count( $raw_data, "\n" ) + 1;
		$data        = $this->sanitize_raw_data( $raw_data );
		if ( isset( $data['header'] ) ) {
			$total_lines--;
			$header = array_shift( $data );
		}
		$total   = $total_batch = count( $data );
		$removed = $total_lines - $total;

		$filename = wp_tempnam();
		auto_mail_file_put_contents( $filename, serialize( $data ) );

		$sample = array_splice( $data, 0, $sample_size );

		return array(
			'file'        => $filename,
			'total'       => $total,
			'removed'     => $removed,
			'header'      => $header,
			'sample'      => $sample,
			'sample_last' => end( $data ),
			'encoding'    => $encoding,
		);

	}

	public function filter( $insert, $data, $import_data ) {

		$insert['referer'] = 'import';

		return $insert;
	}


}

endif;