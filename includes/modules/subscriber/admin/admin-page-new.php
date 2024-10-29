<?php
/**
 * Auto_Mail_Subscriber_New_Page Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Subscriber_New_Page' ) ) :

class Auto_Mail_Subscriber_New_Page extends Auto_Mail_Admin_Page {


    /**
     * Get wizard title
     *
     * @since 1.0
     * @return mixed
     */
    public function getWizardTitle() {
        if ( isset( $_REQUEST['id'] ) ) { // WPCS: CSRF OK
            return esc_html__( "Edit Subscriber", Auto_Mail::DOMAIN );
        } else {
            return esc_html__( "New Subscriber", Auto_Mail::DOMAIN );
        }
    }

    /**
     * Add page screen hooks
     *
     * @since 1.0.0
     * @param $hook
     */
    public function enqueue_scripts( $hook ) {
        // Load admin styles
        auto_mail_admin_enqueue_styles( AUTO_MAIL_VERSION );

        $auto_mail_data = new Auto_Mail_Admin_Data();

        // Load admin subscriber edit scripts
        auto_mail_admin_enqueue_scripts_subscriber_edit(
            AUTO_MAIL_VERSION,
            $auto_mail_data->get_options_data()
        );

    }

    /**
     * Render page header
     *
     * @since 1.0
     */
    protected function render_header() { ?>
        <?php
        if ( $this->template_exists( $this->folder . '/header' ) ) {
            $this->template( $this->folder . '/header' );
        } else {
            ?>
            <h1 class="auto-mail-header-title"><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <?php } ?>
        <?php
    }

    /**
     * Return subscriber model
     *
     * @since 1.0.0
     *
     * @param int $id
     *
     * @return array
     */
    public function get_single_model( $id ) {
        $data = Auto_Mail_Subscriber_Model::model()->get_single_model( $id );

        return $data;
    }



}

endif;
