<?php
/**
 * AM_Automation_Generator_Page Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'AM_Automation_Generator_Page' ) ) :

	class AM_Automation_Generator_Page extends Auto_Mail_Admin_Page {

		/**
         * Add page screen hooks
         *
         * @since 1.0.0
         *
         * @param $hook
         */
        public function enqueue_scripts( $hook ) {
            // Load admin styles
            auto_mail_admin_enqueue_styles( AUTO_MAIL_VERSION );

            $auto_mail_data = new Auto_Mail_Admin_Data();

            // Load admin generator scripts
            auto_mail_admin_enqueue_scripts_generator(
                AUTO_MAIL_VERSION,
                $auto_mail_data->get_options_data()
            );
        }

        /**
         * Render page container
         *
         * @since 1.0.0
         */
        public function render() {
            ?>
                <main class="auto-mail-wrap <?php echo esc_attr( 'auto-mail-' . $this->page_slug ); ?>">

                    <?php
                    $this->render_page_content();
                    ?>

                </main>

                <?php
            }
	}

endif;
