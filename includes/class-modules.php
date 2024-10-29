<?php
/**
 * Auto_Mail_Modules Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Modules' ) ) :

class Auto_Mail_Modules {

	/**
	 * Store modules objects
	 *
	 * @var array
	 */
	public $modules = array();

	/**
	 * Auto_Mail_Modules constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		$this->includes();
		$this->load_modules();
	}

	/**
	 * Includes
	 *
	 * @since 1.0
	 */
	private function includes() {

		require_once AUTO_MAIL_DIR . '/includes/abstracts/abstract-class-module.php';
	}

	/**
	 * Load modules
	 *
	 * @since 1.0
	 */
	private function load_modules() {
		/**
		 * Filters modules list
		 */
		$modules = apply_filters( 'auto_mail_modules', array(
			'automation' => array(
				'class'	  => 'Automation',
				'slug'  => 'automation',
				'label'	  => esc_html__( 'automation', Auto_Mail::DOMAIN )
			),
			'campaign' => array(
				'class'	  => 'Campaign',
				'slug'  => 'campaign',
				'label'	  => esc_html__( 'campaign', Auto_Mail::DOMAIN )
			),
			'subscriber' => array(
				'class'	  => 'Subscriber',
				'slug'  => 'subscriber',
				'label'	  => esc_html__( 'subscriber', Auto_Mail::DOMAIN )
			),
			'form' => array(
				'class'	  => 'Form',
				'slug'  => 'form',
				'label'	  => esc_html__( 'form', Auto_Mail::DOMAIN )
			),
			'list' => array(
				'class'	  => 'List',
				'slug'  => 'list',
				'label'	  => esc_html__( 'list', Auto_Mail::DOMAIN )
			),
		) );

		array_walk( $modules, array( $this, 'load_module' ) );
	}

	/**
	 * Load module
	 *
	 * @since 1.0
	 * @param $data
	 * @param $id
	 */
	public function load_module( $data, $id ) {
		$module_class = 'Auto_Mail_' . $data[ 'class' ];
		$module_slug = $data[ 'slug' ];
		$module_label = $data[ 'label' ];

		// Include module
		$path = AUTO_MAIL_DIR . '/includes/modules/' . $module_slug . '/loader.php';
        if ( file_exists( $path ) ) {
			include_once $path;
		}

		if ( class_exists( $module_class ) ) {
			$module_object = new $module_class( $id, $module_label );

			$this->modules[ $id ] = $module_object;
		}
	}

	/**
	 * Retrieve modules objects
	 *
	 * @since 1.0
	 * @return array
	 */
	public function get_modules() {
		return $this->modules;
	}
}

endif;
