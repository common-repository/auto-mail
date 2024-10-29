<?php
/**
 * Auto_Mail_Subscriber_Page Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Subscriber_Page' ) ) :

class Auto_Mail_Subscriber_Page extends Auto_Mail_Admin_Page {

    /**
     * Page number
     *
     * @var int
     */
    protected $page_number = 1;

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

        // Load admin backups scripts
        auto_mail_admin_enqueue_scripts_subscriber_list(
            AUTO_MAIL_VERSION,
            $auto_mail_data->get_options_data()
        );
    }

    /**
     * Initialize
     *
     * @since 1.0.0
     */
    public function init() {
        $pagenum           = isset( $_REQUEST['paged'] ) ? absint( $_REQUEST['paged'] ) : 0; // WPCS: CSRF OK
        $this->page_number = max( 1, $pagenum );
        $this->processRequest();
    }

    /**
     * Process request
     *
     * @since 1.0.0
     */
    public function processRequest() {

        if ( ! isset( $_POST['auto_mail_nonce'] ) ) {
            return;
        }

        $nonce = sanitize_text_field($_POST['auto_mail_nonce']);
        if ( ! wp_verify_nonce( $nonce, 'auto-mail-subscriber-request' ) ) {
            return;
        }

        $is_redirect = true;
        $action = "";
        if(isset($_POST['auto_mail_bulk_action'])){
            $action = sanitize_text_field($_POST['auto_mail_bulk_action']);
            $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : '';
        }else if(isset($_POST['auto_mail_single_action'])){
            $action = sanitize_text_field($_POST['auto_mail_single_action']);
            $id = isset( $_POST['id'] ) ? sanitize_text_field( $_POST['id'] ) : '';
        }

        switch ( $action ) {
            case 'delete':
                if ( isset( $id ) && !empty( $id ) ) {
                    $this->delete_module( $id );
                }
                break;

            case 'update-status':
                if ( isset( $id ) && !empty( $id ) ) {
                    $this->update_module_status( $id, sanitize_text_field($_POST['status']) );
                }
                break;


            case 'delete-subscribers' :
                if ( isset( $ids ) && !empty( $ids ) ) {
                    $subscriber_ids = explode( ',', $ids );
                    if ( is_array( $subscriber_ids ) && count( $subscriber_ids ) > 0 ) {
                        foreach ( $subscriber_ids as $id ) {
                            $this->delete_module( $id );
                        }
                    }
                }
                break;

            case 'publish-subscribers' :
                if ( isset( $ids ) && !empty( $ids ) ) {
                    $subscriber_ids = explode( ',', $ids );
                    if ( is_array( $subscriber_ids ) && count( $subscriber_ids ) > 0 ) {
                        foreach ( $subscriber_ids as $subscriber_id ) {
                            $this->update_module_status( $subscriber_id, 'publish' );
                        }
                    }
                }
                break;

            case 'draft-subscribers' :
                if ( isset( $ids ) && !empty( $ids ) ) {
                    $subscriber_ids = explode( ',', $ids );
                    if ( is_array( $subscriber_ids ) && count( $subscriber_ids ) > 0 ) {
                        foreach ( $subscriber_ids as $subscriber_id ) {
                            $this->update_module_status( $subscriber_id, 'draft' );
                        }
                    }
                }
                break;

            default:
                break;
        }

        if ( $is_redirect ) {
            $fallback_redirect = admin_url( 'admin.php' );
            $fallback_redirect = add_query_arg(
                array(
                    'page' => $this->get_admin_page(),
                ),
                $fallback_redirect
            );
            $this->maybe_redirect_to_referer( $fallback_redirect );
        }

        exit;
    }

	/**
	 * Count modules
	 *
	 * @since 1.0.0
	 * @return int
	 */
	public function countModules( $status = '' ) {
		return Auto_Mail_Subscriber_Model::model()->count_all( $status );
	}

	/**
	 * Return modules
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function getModules($status = '', $keyword = '') {
		$modules = array();
		$limit   = null;
		if ( defined( 'AUTO_MAIL_FORMS_LIST_LIMIT' ) && AUTO_MAIL_FORMS_LIST_LIMIT ) {
			$limit = AUTO_MAIL_FORMS_LIST_LIMIT;
		}
        if(empty($status) && empty($keyword)){
            $data = $this->get_models( $limit );
        }else{
            $data = Auto_Mail_Subscriber_Model::model()->get_all_models( $status, $limit, $keyword );
        }

		// Fallback
		if ( ! isset( $data['models'] ) || empty( $data['models'] ) ) {
			return $modules;
		}

		foreach ( $data['models'] as $model ) {
            $settings = $model->get_settings();
            $modules[] = array(
				"id"              => $model->id,
				"date"            => date( 'F j, Y, g:i a', strtotime( $model->raw->post_date ) ),
				"status"          => $model->status,
            );
		}

		return $modules;
	}

    /**
     * Return models
     *
     * @since 1.0.0
     *
     * @param int $limit
     *
     * @return array
     */
    public function get_models( $limit = null ) {
        $data = Auto_Mail_Subscriber_Model::model()->get_all_paged( $this->page_number, $limit );

        return $data;
    }

    /**
     * Return models by status
     *
     * @since 1.0.0
     *
     * @param string $status
     *
     * @return array
     */
    public function get_models_by_status( $status ) {
        $data = Auto_Mail_Subscriber_Model::model()->get_all_models( $status );
        return $data;
    }

    /**
     * Delete module
     *
     * @since 1.0.0
     *
     * @param $id
     */
    public function delete_module( $id ) {
        //check if this id is valid and the record is exists
        $model = Auto_Mail_Subscriber_Model::model()->load( $id );
        if ( is_object( $model ) ) {
            wp_delete_post( $id );
        }
    }

    /**
     * Bulk actions
     *
     * @since 1.0
     * @return array
     */
    public function bulk_actions() {
        return apply_filters(
            'auto-mail_subscriber_bulk_actions',
            array(
                'publish-subscribers'    => esc_html__( "Publish", Auto_Mail::DOMAIN ),
                'draft-subscribers'      => esc_html__( "Unpublish", Auto_Mail::DOMAIN ),
                'delete-subscribers'     => esc_html__( "Delete", Auto_Mail::DOMAIN ),
            ) );
    }

    /**
     * Update Module Status
     *
     * @since 1.0.0
     *
     * @param $id
     * @param $status
     */
    public function update_module_status( $id, $status ) {
        // only publish and draft status avail
        if ( in_array( $status, array( 'publish', 'draft' ), true ) ) {
            $model = Auto_Mail_Subscriber_Model::model()->load( $id );
            if ( $model instanceof Auto_Mail_Subscriber_Model ) {
                $model->status = $status;
                $model->save();
            }
        }
    }

    /**
     * Pagination
     *
     * @since 1.0
     */
    public function pagination() {
        $count = $this->countModules();
        auto_mail_list_pagination( $count, 'subscribers' );
    }


}

endif;
