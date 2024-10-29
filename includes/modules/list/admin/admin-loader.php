<?php
/**
 * Auto_Mail_List_Admin Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_List_Admin' ) ) :

class Auto_Mail_List_Admin extends Auto_Mail_Admin_Module {

	/**
	 * Init module admin
	 *
	 * @since 1.0
	 */
	public function init() {
		$this->module       = Auto_Mail_List::get_instance();
		$this->page         = 'auto-mail-lists';
		$this->page_edit    = 'auto-mail-list-wizard';
	}

	/**
	 * Include required files
	 *
	 * @since 1.0
	 */
	public function includes() {
		include_once dirname( __FILE__ ) . '/admin-page-new.php';
		include_once dirname( __FILE__ ) . '/admin-page-view.php';
	}

	/**
	 * Add module pages to Admin
	 *
	 * @since 1.0
	 */
	public function add_menu_pages() {
		new Auto_Mail_List_Page( $this->page, 'list/list', esc_html__( 'Lists', Auto_Mail::DOMAIN ), esc_html__( 'Lists', Auto_Mail::DOMAIN ), 'auto-mail' );
		new Auto_Mail_List_New_Page( $this->page_edit, 'list/wizard', esc_html__( 'Edit List', Auto_Mail::DOMAIN ), esc_html__( 'New List', Auto_Mail::DOMAIN ), 'auto-mail' );
	}

	/**
	 * Remove necessary pages from menu
	 *
	 * @since 1.0
	 */
	public function hide_menu_pages() {
		remove_submenu_page( 'auto-mail', $this->page_edit );
	}

	/**
	 * Return template
	 *
	 * @since 1.0
	 * @return Auto_Mail_Template|false
	 */
	private function get_template() {
		if( isset( $_GET['template'] ) )  {
			$id = trim( sanitize_text_field( $_GET['template'] ) );
		} else {
			$id = 'blank';
		}

		foreach ( $this->module->templates as $key => $template ) {
			if ( $template->options['id'] === $id ) {
				return $template;
			}
		}

		return false;
	}
}

endif;
