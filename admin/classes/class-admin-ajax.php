<?php
/**
 * Auto_Mail_Admin_AJAX Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Admin_AJAX' ) ) :

    class Auto_Mail_Admin_AJAX {

        /**
         * Auto_Mail_Admin_AJAX constructor.
         *
         * @since 1.0
         */
        public function __construct() {
            // WP Ajax Actions.
            add_action( 'wp_ajax_auto_mail_save_automation', array( $this, 'save_automation' ) );
            add_action( 'wp_ajax_auto_mail_save_form', array( $this, 'save_form' ) );
            add_action( 'wp_ajax_auto_mail_load_form', array( $this, 'load_form' ) );
            add_action( 'wp_ajax_nopriv_auto_mail_load_form', array( $this, 'load_form' ) );
            add_action( 'wp_ajax_am_form_submit', array( $this, 'front_submit_form' ) );
            add_action( 'wp_ajax_nopriv_am_form_submit', array( $this, 'front_submit_form' ) );

            add_action( 'wp_ajax_auto_mail_save_design', array( $this, 'save_design' ) );
            add_action( 'wp_ajax_auto_mail_process_campaign', array( $this, 'process_campaign' ) );
            add_action( 'wp_ajax_auto_mail_save_subscriber', array( $this, 'save_subscriber' ) );
            add_action( 'wp_ajax_auto_mail_save_list', array( $this, 'save_list' ) );
            add_action( 'wp_ajax_auto_mail_save_settings', array( $this, 'save_settings' ) );
            add_action( 'wp_ajax_auto_mail_test_email', array( $this, 'test_email' ) );
            add_action( 'wp_ajax_am_send_test_email', array( $this, 'am_send_test_email' ) );

            // Import subscribers actions
            add_action( 'wp_ajax_auto_mail_import_handler', array( &$this, 'import_handler' ) );
            add_action( 'wp_ajax_auto_mail_show_import_data', array( &$this, 'show_import_data' ) );
            add_action( 'wp_ajax_auto_mail_do_import', array( &$this, 'do_import' ) );
            add_action( 'wp_ajax_auto_mail_mailchimp_verify', array( &$this, 'mailchimp_verify' ) );

            // Export subscribers actions
            add_action( 'wp_ajax_auto_mail_do_export', array( &$this, 'do_export' ) );

            // Download export file
            add_action( 'wp_ajax_auto_mail_download_export_file', array( &$this, 'download_export_file' ) );

            // Store user details from the current checkout page.
			add_action( 'wp_ajax_am_save_cart_abandonment_data', array( $this, 'save_cart_abandonment_data' ) );
			add_action( 'wp_ajax_nopriv_am_save_cart_abandonment_data', array( $this, 'save_cart_abandonment_data' ) );

            // Generate Automation
            add_action( 'wp_ajax_auto_mail_generate_automation', array( $this, 'generate_automation' ) );
        }

        /**
	    * Save cart abandonment tracking and schedule new event.
	    *
	    * @since 1.0.0
	    */
	    public function save_cart_abandonment_data() {

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            $post_data = am_sanitize_post_data();

            if ( isset( $post_data['wcf_email'] ) ) {
                $user_email = sanitize_email( $post_data['wcf_email'] );
                global $wpdb;
                $cart_abandonment_table = $wpdb->prefix . 'am_cart_abandonment';

                // Verify if email is already exists.
                $session_id               = WC()->session->get( 'wcf_session_id' );
                $session_checkout_details = null;
                if ( isset( $session_id ) ) {
                    $session_checkout_details = am_get_checkout_details( $session_id );
                } else {
                    $session_checkout_details = am_get_checkout_details_by_email( $user_email );
                    if ( $session_checkout_details ) {
                        $session_id = $session_checkout_details->session_id;
                        WC()->session->set( 'wcf_session_id', $session_id );
                    } else {
                        $session_id = md5( uniqid( wp_rand(), true ) );
                    }
                }

                $checkout_details = am_prepare_abandonment_data( $post_data );

                if ( isset( $session_checkout_details ) && AM_CART_COMPLETED_ORDER === $session_checkout_details->order_status ) {
                    WC()->session->__unset( 'wcf_session_id' );
                    $session_id = md5( uniqid( wp_rand(), true ) );
                }

                if ( isset( $checkout_details['cart_total'] ) && $checkout_details['cart_total'] > 0 ) {

                    if ( ( ! is_null( $session_id ) ) && ! is_null( $session_checkout_details ) ) {

                        // Updating row in the Database where users Session id = same as prevously saved in Session.
                        $wpdb->update(
                            $cart_abandonment_table,
                            $checkout_details,
                            array( 'session_id' => $session_id )
                        );

                    } else {

                        $checkout_details['session_id'] = sanitize_text_field( $session_id );
                        // Inserting row into Database.
                        $wpdb->insert(
                            $cart_abandonment_table,
                            $checkout_details
                        );

                        // Storing session_id in WooCommerce session.
                        WC()->session->set( 'wcf_session_id', $session_id );

                    }
                } else {
                    $wpdb->delete( $cart_abandonment_table, array( 'session_id' => sanitize_key( $session_id ) ) );
                }

                wp_send_json_success();
            }

	    }

        /**
        * Front submit form
        *
        * @since 1.0.0
        */
        public function front_submit_form() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            if ( isset( $_POST['fields_data'] ) ) {
                $fields  = $_POST['fields_data'];
                $form_id      = isset( $fields['form_id'] ) ? sanitize_text_field($fields['form_id']) : null;
                $email = isset( $fields['email'] ) ? sanitize_text_field( $fields['email'] ) : '';

                // From Settings
                $settings = array();
                if(!empty($form_id)){
                    $model    = Auto_Mail_Form_Model::model()->get_single_model( $form_id );
                    $settings = $model->settings;
                    $lists = $settings['lists'];
                }

                $form_model = new Auto_Mail_Subscriber_Model();
                // Set settings to model
                $form_model->settings = array(
                    'email_address' => $email,
                    'lists' => $lists
                );

                $form_model->status = 'subscribed';
                // Save data
                $id = $form_model->save(false, $email);

                if (!$id) {
                    wp_send_json_error( $id );
                }else{
                    wp_send_json_success( __( 'Submit form successfully.', Auto_Mail::DOMAIN ) );
                }
            } else {
                wp_send_json_error( __( 'User submit data are empty!', Auto_Mail::DOMAIN ) );
            }


        }

        /**
        * Do Export
        *
        * @since 1.0.0
        */
        public function do_export() {

            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            // Try to write content to export tmp file
            if ( ! is_dir( AUTO_MAIL_UPLOAD_DIR ) ) {
				wp_mkdir_p( AUTO_MAIL_UPLOAD_DIR );
			}

			$filename = AUTO_MAIL_UPLOAD_DIR . '~auto_mail_export_' . date( 'Y-m-d-H-i-s' ) . '.tmp';

            global $wp_filesystem;

            if (empty($wp_filesystem)) {
                require_once (ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            if ( ! ( $wp_filesystem->put_contents( $filename, '', FS_CHMOD_FILE ) ) ) {
                $return['msg'] = sprintf( esc_html__( 'Not able to create file in %s. Please make sure WordPress can write files to your filesystem!', Auto_Mail::DOMAIN ), AUTO_MAIL_UPLOAD_DIR );
            }

			update_option( 'auto_mail_export_filename', $filename );

            // Get export tmp filename
            $filename = get_option( 'auto_mail_export_filename' );

            if ( ! file_exists( $filename ) || ! wp_is_writable( $filename ) ) {
                $return['msg'] = esc_html__( 'Not able to write export file', Auto_Mail::DOMAIN );
                wp_send_json( $return );
            }

            $d = $_POST['fields_data'];

            $offset   = 0;
            $limit    = 1000;
            $raw_data = array();

            $listids  = isset( $d['lists'] ) ? array_filter( sanitize_text_field($d['lists']), 'is_numeric' ) : array();
            $statuses = isset( $d['status'] ) ? array_filter( sanitize_text_field($d['status']), 'is_numeric' ) : array();

            $outputformat = sanitize_text_field($d['outputformat']);
            $useheader = sanitize_text_field($d['header']);
            $separator    = ",";

            $offset = $offset * $limit;

            $args = array(
                'lists'      => $listids,
                'status'     => $statuses,
                'limit'      => $limit,
                'offset'     => $offset,
            );

            $raw_data = Auto_Mail_Subscriber_Model::model()->search( $args );

            $output = '';

            if ( 'html' == $outputformat ) {

                if ( $useheader ) {
                    $firstrow = array_shift( $raw_data );
                    $output  .= '<tr>' . "\n";
                    foreach ( $firstrow as $key => $r ) {
                        $output .= '<th>' . strip_tags( $r ) . '</th>' . "\n";
                    }
                    $output .= '</tr>' . "\n";
                }else{
                    array_shift( $raw_data );
                }

                foreach ( $raw_data as $row ) {
                    $output .= '<tr>' . "\n";
                    foreach ( $row as $key => $r ) {
                        $output .= '<td>' . esc_html( $r ) . '</td>' . "\n";
                    }
                    $output .= '</tr>' . "\n";
                }
            } elseif ( 'xls' == $outputformat ) {

                if ( $useheader ) {
                    $firstrow = array_shift( $raw_data );
                    $output  .= '<automail:Row automail:StyleID="1">' . "\n";
                    foreach ( $firstrow as $key => $r ) {
                        $output .= '<automail:Cell><automail:Data automail:Type="String">' . strip_tags( $r ) . '</automail:Data></automail:Cell>' . "\n";
                    }
                    $output .= '</automail:Row>' . "\n";
                }
                foreach ( $raw_data as $row ) {
                    $output .= '<automail:Row>' . "\n";

                    foreach ( $row as $key => $r ) {
                        $type = 'String';
                        if ( in_array( $key, array( 'ID', '_number', '_statuscode', 'rating', 'timeoffset' ) ) ) {
                            $type = 'Number';
                        }
                        $output .= '<automail:Cell><automail:Data automail:Type="' . $type . '">' . esc_html( $r ) . '</automail:Data></automail:Cell>' . "\n";
                    }
                    $output .= '</automail:Row>' . "\n";
                }
            } else {
                foreach ( $raw_data as $row ) {
                    $output .= implode( $separator, $row ) . "\n";
                }
            }

            try {

                if ( $output ) {
                    am_export_file_put_contents( $filename, $output, 'a' );
                    $file_size = @filesize( $filename );

                    $finalname = AUTO_MAIL_UPLOAD_DIR . '/auto_mail_export_' . date( 'Y-m-d-H-i-s' ) . '.' . $outputformat;
                    if ( file_exists( $filename ) ) {
                        copy( $filename, $finalname );
                        $file_size = filesize( $filename );
                        update_option( 'auto_mail_export_filename', $finalname );
                        unlink( $filename );
                    }
                    $return['url'] = admin_url( 'admin-ajax.php?action=auto_mail_download_export_file&file=' . basename( $finalname ) . '&format=' . $outputformat . '&_wpnonce=' . wp_create_nonce( 'auto-mail' ) );
                }

                $return['total'] = $file_size ? size_format( $file_size, 2 ) : 0;

            } catch ( Exception $e ) {

                $return['msg'] = $e->getMessage();
                wp_send_json_error( $return );

            }

            wp_send_json_success( $return );


        }

        /**
        * Mailchimp Verify
        *
        * @since 1.0.0
        */
        public function mailchimp_verify() {

            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            $integration = new Auto_Mailchimp_Import();
            $integration->valid_credentials(sanitize_text_field($_POST['mailchimp_api_key']));
        }

        /**
        * Do Import
        *
        * @since 1.0.0
        */
        public function do_import() {

            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            global $wpdb;

            $import_options = $_POST['fields_data'];

            $import_order = array();
            foreach($import_options as $key => $value){
                if(strpos($key, 'order') !== false){
                    $import_order[] = $value;
                }
            }

            $identifier        = sanitize_text_field($import_options['identifier']);
            $canceled          = ! ! ( sanitize_text_field($import_options['canceled']) === 'true' );
            $new_custom_fields = isset( $import_options['customfields'] ) ? (array) $import_options['customfields'] : null;
            $imported          = 0;
            $errors            = 0;
            $import_data       = wp_parse_args(
                get_transient( '_auto_mail_bulk_import_' . $identifier ),
                array(
                    'lists'       => isset( $import_options['lists'] ) ? (array) $import_options['lists'] : array(),
                    'tags'        => isset( $import_options['_tags'] ) ? (array) $import_options['_tags'] : array(),
                    'order'       => isset( $import_options['_order'] ) ? (array) $import_options['_order'] : array(),
                    'signupdate'  => $import_options['signupdate'],
                    'existing'    => $import_options['existing'],
                    'status'      => $import_options['status'],
                    'page'        => 1,
                    'errors'      => 0,
                    'imported'    => 0,
                    'encoding'    => null,
                    'performance' => ! ! ( $import_options['performance'] === 'true' ),
                ),
            );

            $memory_limit       = ini_get( 'memory_limit' );
            $max_execution_time = ini_get( 'max_execution_time' );

            ini_set( 'display_errors', 0 );

            set_time_limit( 0 );

            if ( (int) $max_execution_time < 300 ) {
                ini_set( 'max_execution_time', 300 );
            }
            if ( (int) $memory_limit < 256 ) {
                ini_set( 'memory_limit', '256M' );
            }

            if ( ! ( $erroremails = get_transient( '_auto_mail_bulk_import_errors_' . $identifier ) ) ) {
                $erroremails = array();
            }

            if ( ! $canceled ) {

                // get chunk of import based on the part section
                switch ( $import_data['type'] ) {
                    case 'paste':
                        $integration = new Auto_Mail_Paste_Import();
                        $parts = $integration->get_import_part( $import_data );
                        break;
                    case 'upload':
                        $integration = new Auto_Mail_Upload_Import();
                        $parts = $integration->get_import_part( $import_data );
                        break;
                    case 'mailchimp':
                        $integration = new Auto_MailChimp_Import();
                        $parts = $integration->get_import_part( $import_data );
                        break;
                    case 'wordpress':
                        $integration = new Auto_Mail_Wordpress_Import();
                        $parts = $integration->get_import_part( $import_data );
                        break;
                    default:
                        break;
                }

                if ( $parts === $import_data ) {
                    $return['msg'] = sprintf( esc_html__( 'No Integration for %s found.', Auto_Mail::DOMAIN ), $import_data['type'] );
                    wp_send_json_error( $return );
                    exit;
                }

                if ( is_wp_error( $parts ) ) {
                    $return['msg'] = $parts->get_error_message();
                    wp_send_json_error( $return );
                    exit;
                }

                foreach($parts as $part){
                    $email_column_key = array_search('email', $import_order);
                    $email_address = $part[$email_column_key];

                    $first_column_key = array_search('firstname', $import_order);
                    $first_name = $part[$first_column_key];

                    // Prepare subscriber data
                    $subscriber_data = array(
                        'email_address' => $email_address,
                        'first_name' => $first_name,
                        'optin_status'  => 'subscribed',
                        'subscriber_status' => 'publish',
                        'lists' => $import_options['lists'],
                    );

                    $form_model = new Auto_Mail_Subscriber_Model();
                    $form_model->settings = $subscriber_data;
                    $form_model->status = 'subscribed';
                    // Save data
                    $subscriber_id = $form_model->save(false, $email_address);

                    if ( is_wp_error( $subscriber_id ) ) {
                        $erroremails[] = array(
                            'email'  => $email_address,
                            'reason' => $subscriber_id->get_error_message(),
                        );
                        $errors++;
                        continue;
                    }
                }

            }

            $import_data['imported'] += $imported;
            $import_data['errors']   += $errors;

            $return['memoryusage']   = size_format( memory_get_peak_usage( true ), 2 );
            $return['errors']        = $import_data['errors'];
            $return['errors_turn']   = $errors;
            $return['imported']      = $import_data['imported'];
            $return['imported_turn'] = $imported;
            $return['total']         = $import_data['total'];
            $return['p']             = ( $import_data['imported'] ) / $import_data['total'];
            $return['p_total']       = ( $import_data['imported'] + $import_data['errors'] ) / $import_data['total'];
            $return['f_p']           = round( $return['p'] * 100, 1 );
            $return['f_errors']      = number_format_i18n( $import_data['errors'] );
            $return['f_imported']    = number_format_i18n( $import_data['imported'] );
            $return['f_total']       = number_format_i18n( $import_data['total'] );
            $return['canceled']      = $canceled;

            $return['html'] = '';

                if ( $import_data['errors'] ) {
                    $return['html'] .= '<h4>' . sprintf( esc_html__( 'Following %s contacts were not imported', Auto_Mail::DOMAIN ), count( $erroremails ) ) . '</h4>';
                    $return['html'] .= '<section>';
                    $return['html'] .= '<div class="table-wrap">';
                    $return['html'] .= '<table class="wp-list-table widefat">';
                    $return['html'] .= '<thead><tr><td width="5%">#</td><td>' . auto_mail_text( 'email' ) . '</td><td>' . esc_html__( 'Reason', Auto_Mail::DOMAIN ) . '</td></tr></thead><tbody>';
                    foreach ( $erroremails as $i => $contacts ) {
                        $return['html'] .= '<tr' . ( $i % 2 ? '' : ' class="alternate"' ) . '><td>' . ( ++$i ) . '</td><td>' . esc_html( $contacts['email'] ) . '</td><td>' . esc_html( $contacts['reason'] ) . '</td></tr></thead>';
                    }
                    $return['html'] .= '</tbody></table>';
                    $return['html'] .= '</div>';
                    $return['html'] .= '</section>';
                }

                $return['html'] .= '<section>';
                admin_url( 'admin.php?page=auto-mail-gallery-wizard&id=' . $module['id'] . '&status=' . $module['status'] );
                $return['html'] .= '<a href="' . admin_url( 'admin.php?page=auto-mail-manage' ) . '" class="button button-primary">' . esc_html__( 'Import more Contacts', Auto_Mail::DOMAIN ) . '</a> ';
                $return['html'] .= '<a href="' . admin_url( 'admin.php?page=auto-mail-subscribers' ) . '" class="button">' . esc_html__( 'View your Subscribers', Auto_Mail::DOMAIN ) . '</a>';
                $return['html'] .= '</section>';

                delete_transient( '_auto_mail_bulk_import' . $identifier );
                delete_transient( '_auto_mail_bulk_import_errors_' . $identifier );

            wp_send_json_success( $return );
        }

        /**
        * Import Handler
        *
        * @since 1.0.0
        */
        public function import_handler() {

            $type = sanitize_text_field( $_POST['type'] );
            $identifier = uniqid();

            switch ( $type ) {
                case 'paste':
                    $integration = new Auto_Mail_Paste_Import();
                    $import_data = $integration->get_import_data(sanitize_text_field($_POST['paste_data']));
                    break;
                case 'upload':
                    $integration = new Auto_Mail_Upload_Import();
                    $import_data = $integration->get_import_data($_FILES['file']['tmp_name']);
                    break;
               case 'mailchimp':
                    $integration = new Auto_Mailchimp_Import();
                    $mailchimp_data = array();
                    $mailchimp_data['lists'] = $_POST['lists'];
                    $mailchimp_data['statuses'] = $_POST['statuses'];
                    $import_data = $integration->get_import_data($mailchimp_data);
                    break;
                case 'wordpress':
                    $integration = new Auto_Mail_Wordpress_Import();
                    $wp_user_data = array();
                    $wp_user_data['roles'] = $_POST['roles'];
                    $import_data = $integration->get_import_data($wp_user_data);
                    break;
                default:
                    break;
            }

            if ( is_wp_error( $import_data ) ) {
                $return['msg'] = $import_data->get_error_message();
                wp_send_json_error( $return );
                exit;
            }

            if ( ! isset( $import_data['sample'] ) || empty( $import_data['sample'] ) ) {
                $return['msg'] = esc_html__( 'Your selection doesn\'t contain any subscriber', Auto_Mail::DOMAIN );
                wp_send_json_error( $return );
                exit;
            }

            $import_data = wp_parse_args(
                $import_data,
                array(
                    'header'    => null,
                    'removed'   => 0,
                    'extra_map' => array(),
                    'defaults'  => array(),
                )
            );

            $import_data['type']       = $type;
            $import_data['identifier'] = $identifier;
            $import_data['page']       = 1;

            $import_data['defaults'] = wp_parse_args(
                $import_data['defaults'],
                array(
                    'status'      => 1,
                    'existing'    => 'skip',
                    'signup'      => true,
                    'performance' => false,
                )
            );

            set_transient( '_auto_mail_bulk_import_' . $identifier, $import_data, DAY_IN_SECONDS );

            $return['identifier'] = $identifier;

            wp_send_json_success( $return );

        }

        /**
        * Show Import Data
        *
        * @since 1.0.0
        */
        public function show_import_data() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            $return['identifier'] = $identifier = sanitize_text_field($_POST['identifier']);

            $import_data = get_transient( '_auto_mail_bulk_import_' . $identifier );
            $data        = $import_data['sample'];
            $first       = $data[0];
            $last        = end( $data );
            reset( $data );

            $firstline    = $first[0];
            $cols         = count( $first );
            $contactcount = $import_data['total'];
            $samplecount  = count( $data );
            $removed      = $import_data['removed'];
            $defaults     = $import_data['defaults'];
            $header       = is_array( $import_data['header'] ) ? array_values( $import_data['header'] ) : array();
            $map          = is_array( $import_data['header'] ) ? array_keys( $import_data['header'] ) : null;

            $fields     = array(
                'email'      => 'Email',
                'firstname'  => 'Firstname',
                'lastname'   => 'Lastname',
                'first_last' => 'Firstname &#x23B5; Lastname',
                'last_first' => 'Lastname &#x23B5; Firstname',
            );
            $meta_dates = array(
                '_signup'         => esc_html__( 'Signup Date', Auto_Mail::DOMAIN ),
                '_confirm'        => esc_html__( 'Confirm Date', Auto_Mail::DOMAIN ),
                '_confirm_signup' => esc_html__( 'Signup + Confirm Date', Auto_Mail::DOMAIN ),
            );
            $meta_ips   = array(
                '_ip'                => esc_html__( 'IP Address', Auto_Mail::DOMAIN ),
                '_ip_signup'         => esc_html__( 'Signup IP Address', Auto_Mail::DOMAIN ),
                '_ip_confirm'        => esc_html__( 'Confirm IP Address', Auto_Mail::DOMAIN ),
                '_ip_confirm_signup' => esc_html__( 'Confirm + Signup IP Address', Auto_Mail::DOMAIN ),
                '_ip_all'            => esc_html__( 'all IP Addresses', Auto_Mail::DOMAIN ),
            );
            $meta_other = array(
                '_lists'      => esc_html__( 'Lists', Auto_Mail::DOMAIN ) . ' (' . esc_html__( 'comma separated', Auto_Mail::DOMAIN ) . ')',
                '_tags'       => esc_html__( 'Tags', Auto_Mail::DOMAIN ) . ' (' . esc_html__( 'comma separated', Auto_Mail::DOMAIN ) . ')',
                '_status'     => esc_html__( 'Status', Auto_Mail::DOMAIN ),
                '_lang'       => esc_html__( 'Language', Auto_Mail::DOMAIN ),
                '_timeoffset' => esc_html__( 'Timeoffset to UTC', Auto_Mail::DOMAIN ),
                '_timezone'   => esc_html__( 'Timezone', Auto_Mail::DOMAIN ),
                '_lat'        => esc_html__( 'Latitude', Auto_Mail::DOMAIN ),
                '_long'       => esc_html__( 'Longitude', Auto_Mail::DOMAIN ),
                '_country'    => esc_html__( 'Country', Auto_Mail::DOMAIN ),
                '_city'       => esc_html__( 'City', Auto_Mail::DOMAIN ),
            );



            $html  = '<form id="subscriber-import-table" method="post">';
            $html .= '<h2>';
            $html .= sprintf( esc_html__( _n( '%s contact to import.', '%s contacts to import.', $contactcount, Auto_Mail::DOMAIN ) ), number_format_i18n( $contactcount ) );
            if ( ! empty( $removed ) ) {
                $html .= ' <span class="howto">' . sprintf( esc_html__( _n( '%s entry without valid email address has been removed.', '%s entries without valid email address have been removed.', $removed, Auto_Mail::DOMAIN ) ), number_format_i18n( $removed ) ) . '</span>';
            }
            $html .= '</h2>';
            $html .= '<h4>' . esc_html__( 'Match column labels to contact information. Each column can represent one field. You can ignore columns which you like to skip.', Auto_Mail::DOMAIN ) . '</h4>';
            $html .= '<section>';
            // $html .= '<p class="howto">' . esc_html__( 'Match column labels to contact information. Each column can represent one field. You can ignore columns which you like to skip.', Auto_Mail::DOMAIN ) . '</p>';

            if ( ! empty( $header ) ) {
                $email_key = -1;
                foreach ( $header as $key => $value) {
                    if($value == 'email'){
                        $email_key = $key;
                    }
                }
            }

            $html .= '<div class="table-wrap">';
            $html .= '<table class="wp-list-table widefat">';
            $html .= '<thead>';
            $html .= '<tr><td style="width:20px;">#</td>';
            for ( $i = 0; $i < $cols; $i++ ) {
                $select  = '<select name="order_' . $i . '" class="column-selector" data-for="' . ( ! empty( $header[ $i ] ) ? $header[ $i ] : '' ) . '">';
                $select .= '<option value="-1">' . esc_html__( 'Ignore column', Auto_Mail::DOMAIN ) . '</option>';
                $select .= '<option value="-1">----------</option>';
                $select .= '<option value="_new">' . esc_html__( 'Create new Field', Auto_Mail::DOMAIN ) . '</option>';
                $select .= '<option value="-1">----------</option>';
                $select .= '<optgroup label="' . esc_html__( 'Basic', Auto_Mail::DOMAIN ) . '">';
                foreach ( $fields as $key => $value ) {
                    $is_selected = false;
                    // Paste, Upload and Mailchimp import
                    if($key == 'email' && $header[ $i ] == 'email'){
                        $is_selected = true;
                    }else if($key == 'firstname' && ($header[ $i ] == 'first' || $header[ $i ] == 'first_last')){
                        $is_selected = true;
                    }
                    // Wordpress user type import
                    if(isset($import_data['type']) && $import_data['type'] == 'wordpress'){
                        if($key == 'email' && $i == 0){
                            $is_selected = true;
                        }else if($key == 'firstname' && $i == 1){
                            $is_selected = true;
                        }
                    }
                    $select .= '<option value="' . esc_attr( $key ) . '" ' . ( $is_selected ? 'selected' : '' ) . '>' . esc_html( $value ) . '</option>';
                }
                $select .= '</optgroup>';

                    $select .= '<optgroup label="' . esc_html__( 'no Custom Fields defined!', Auto_Mail::DOMAIN ) . '">';
                    $select .= '<option value="_new">' . esc_html__( 'Create new Field', Auto_Mail::DOMAIN ) . '</option>';
                    $select .= '</optgroup>';

                $select .= '<optgroup label="' . esc_html__( 'Time Options', Auto_Mail::DOMAIN ) . '">';
                foreach ( $meta_dates as $key => $value ) {
                    $is_selected = $map && $key === $map[ $i ];
                    $select     .= '<option value="' . esc_attr( $key ) . '" ' . ( $is_selected ? 'selected' : '' ) . '>' . esc_html( $value ) . '</option>';
                }
                $select .= '</optgroup>';
                $select .= '<optgroup label="' . esc_html__( 'IP Options', Auto_Mail::DOMAIN ) . '">';
                foreach ( $meta_ips as $key => $value ) {
                    $is_selected = $map && $key === $map[ $i ];
                    $select     .= '<option value="' . esc_attr( $key ) . '" ' . ( $is_selected ? 'selected' : '' ) . '>' . esc_html( $value ) . '</option>';
                }
                $select .= '</optgroup>';
                $select .= '<optgroup label="' . esc_html__( 'Other Meta', Auto_Mail::DOMAIN ) . '">';
                foreach ( $meta_other as $key => $value ) {
                    $is_selected = $map && $key === $map[ $i ];
                    $select     .= '<option value="' . esc_attr( $key ) . '" ' . ( $is_selected ? 'selected' : '' ) . '>' . esc_html( $value ) . '</option>';
                }
                $select   .= '</optgroup>';
                $select   .= '</select>';
                    $html .= '<td>' . $select . '</td>';
            }
            $html .= '</tr>';
            if ( ! empty( $header ) ) {
                $html .= '<tr><td style="width:20px;">&nbsp;</td>';
                for ( $i = 0; $i < $cols; $i++ ) {
                        $html .= '<td>' . esc_html( $header[ $i ] ) . '</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</thead>';
            $html .= '<tbody>';
            for ( $i = 0; $i < min( $samplecount, $contactcount ); $i++ ) {
                $html .= '<tr class="' . ( $i % 2 ? '' : 'alternate' ) . '"><td>' . number_format_i18n( $i + 1 ) . '</td>';
                foreach ( $data[ $i ] as $j => $cell ) {
                        $html .= '<td title="' . esc_attr( strip_tags( $cell ) ) . '">' . esc_html( $cell ) . '</td>';
                }
                $html .= '<tr>';
            }
            if ( $contactcount > $samplecount + 1 ) {
                $html .= '<tr class="' . ( $i++ % 2 ? '' : 'alternate' ) . '"><td>&nbsp;</td><td colspan="' . ( $cols ) . '"><i>&hellip;' . sprintf( esc_html__( '%s contacts are hidden', Auto_Mail::DOMAIN ), number_format_i18n( $contactcount - $samplecount - 1 ) ) . '&hellip;</i></td></tr>';

                if ( isset( $import_data['sample_last'] ) ) {
                    $html .= '<tr class="' . ( $i++ % 2 ? '' : 'alternate' ) . '"><td>' . number_format_i18n( $contactcount ) . '</td>';
                    foreach ( $import_data['sample_last'] as $cell ) {
                        $html .= '<td title="' . esc_attr( strip_tags( $cell ) ) . '">' . esc_html( $cell ) . '</td>';
                    }
                    $html .= '</tr>';
                }
            } else {
                $html .= '<tr class="' . ( $i++ % 2 ? '' : 'alternate' ) . '"><td>&nbsp;</td><td colspan="' . ( $cols ) . '"><i>&hellip;' . sprintf( esc_html__( '%s total contacts', Auto_Mail::DOMAIN ), number_format_i18n( $contactcount ) ) . '&hellip;</i></td></tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';
            $html .= '</section>';
            $html .= '<h4>' . esc_html__( 'Add contacts to following lists', Auto_Mail::DOMAIN ) . '</h4>';
            $html .= '<section id="section-lists">';
            $html .= '<p class="howto">' . esc_html__( 'Lists can also be matched above.', Auto_Mail::DOMAIN ) . '</p>';
            $html .= '<ul>';
            $lists = array();
            $list_models = Auto_Mail_List_Model::model()->get_all_models();
            foreach($list_models['models'] as $key => $value){
                $lists[$key]['id'] = $value->id;
                $lists[$key]['name'] = $value->settings['auto_mail_list_name'];
            }
            if ( $lists ) {
			    foreach ( $lists as $list ) {
				    $html .= '<li><label><input name="import_lists" value="' . esc_attr( $list['id'] ) . '" type="checkbox"> ' . esc_html( $list['name'] ) . '</label></li>';
			    }
		    }
		    $html .= '</ul>';
            $html .= '<p><label for="new_list_name">' . esc_html__( 'Add new list', Auto_Mail::DOMAIN ) . ': </label><input type="text" id="new_list_name" value=""> <button class="button" id="addlist">' . esc_html__( 'Add', Auto_Mail::DOMAIN ) . '</button></p>';

            $html .= '</section>';
            $html .= '<h4>' . esc_html__( 'Assign following tags to these contacts', Auto_Mail::DOMAIN ) . '</h4>';
            $html .= '<section id="section-tags">';
            $html .= '<p>';
            $html .= '<select multiple name="_tags[]" class="tags-input">';
            $html .= '<option></option>';

            $html .= '</select>';
            $html .= '</p>';

            $html    .= '</section>';
            $html    .= '<h4>' . esc_html__( 'Import as', Auto_Mail::DOMAIN ) . '</h4>';
            $html    .= '<section>';

            $html .= '<p class="description">' . esc_html__( 'The status will be applied to contacts if no other is defined via the columns.', Auto_Mail::DOMAIN ) . '</p>';
            $html .= '<div class="pending-info error inline"><p><strong>' . esc_html__( 'Choosing "pending" as status will force a confirmation message to the subscribers.', Auto_Mail::DOMAIN ) . '</strong></p></div>';

            $html .= '</section>';
            $html .= '<h4>' . esc_html__( 'Existing subscribers', Auto_Mail::DOMAIN ) . '</h4>';
            $html .= '<section id="section-existing">';
            $html .= '<p>';
            $html .= '<label> <input type="radio" name="existing" value="skip" ' . checked( $defaults['existing'], 'skip', false ) . '> ' . esc_html__( 'skip', Auto_Mail::DOMAIN ) . '</label> &mdash; <span class="description">' . esc_html__( 'will skip the contact if the email address already exists. Status will not be changed.', Auto_Mail::DOMAIN ) . '</span><br>';
            $html .= '<label><input type="radio" name="existing" value="overwrite" ' . checked( $defaults['existing'], 'overwrite', false ) . '> ' . esc_html__( 'overwrite', Auto_Mail::DOMAIN ) . '</label> &mdash; <span class="description">' . esc_html__( 'will overwrite all values of the contact. Status will be overwritten.', Auto_Mail::DOMAIN ) . '</span><br>';
            $html .= '<label><input type="radio" name="existing" value="merge" ' . checked( $defaults['existing'], 'merge', false ) . '> ' . esc_html__( 'merge', Auto_Mail::DOMAIN ) . '</label> &mdash; <span class="description">' . esc_html__( 'will overwrite only defined values and keep old ones. Status will not be changed unless defined via the columns.', Auto_Mail::DOMAIN ) . '</span>';
            $html .= '</p>';
            $html .= '</section>';
            $html .= '<h4>' . esc_html__( 'Other', Auto_Mail::DOMAIN ) . '</h4>';
            $html .= '<section id="section-other">';
            $html .= '<p><label><input type="checkbox" id="signup" name="signup" ' . checked( $defaults['signup'], true, false ) . '>' . esc_html__( 'Use a signup date if not defined', Auto_Mail::DOMAIN ) . ': <input type="text" value="' . date( 'Y-m-d' ) . '" class="datepicker" id="signupdate" name="signupdate"></label>';
            $html .= '<br><span class="description">' . esc_html__( 'Some Auto responder require a signup date. Define it here if it is not set or missing', Auto_Mail::DOMAIN ) . '</span></p>';
            $html .= '<p><label><input type="checkbox" id="performance" name="performance" ' . checked( $defaults['performance'], true, false ) . '> ' . esc_html__( 'Low memory usage (slower)', Auto_Mail::DOMAIN ) . '</label></p>';
            $html .= '<input type="hidden" id="import-identifier" value="' . esc_attr( $identifier ) . '">';

            $html .= '</section>';
            $html .= '<section>';

            $html .= '<div class="auto-mail-import-actions"><button class="auto-mail-do-import auto-mail-button auto-mail-button-blue">' . ( sprintf( _n( 'Import %s contact', 'Import %s contacts', $contactcount, Auto_Mail::DOMAIN ), number_format_i18n( $contactcount ) ) ) . '</button>';
            $html .= '<div class="auto-mail-import-running"><div class="loader" id="loader-1"></div><span>'. esc_html__( 'Running now...', Auto_Mail::DOMAIN ) .'</span></div></div>';
            $html .= '</section>';
            $html .= '</form>';

            $return['html'] = $html;

            wp_send_json_success( $return );

        }

        /**
        * Process Campaign
        *
        * @since 1.0.0
        */
        public function process_campaign() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            if ( isset( $_POST['fields_data'] ) ) {
                $fields  = $_POST['fields_data'];
                $id      = isset( $fields['id'] ) ? sanitize_text_field($fields['id']) : null;
                $id      = intval( $id );

                if ( is_null( $id ) || $id <= 0 ) {
                    // create campaign model
                    $campaign_model = new Auto_Mail_Campaign_Model();
                    $action = 'create';
                } else {
                    $action = 'update';
                    // update exist model
                    $campaign_model = Auto_Mail_Campaign_Model::model()->load( $id );
                    if ( ! is_object( $campaign_model ) ) {
                        wp_send_json_error( esc_html__( "Campaign model doesn't exist", Auto_Mail::DOMAIN ) );
                    }
                }

                // Set template to model
                $campaign_model->settings = $fields['settings'];
                $campaign_model->template = $fields['template'];
                $campaign_model->html = $fields['html'];
                $campaign_model->name = $fields['name'];

                //status
                if($fields['action'] == 'send'){
                    $campaign_model->status = Auto_Mail_Campaign_Model::STATUS_SCHEDULED;
                }else{
                    $campaign_model->status = Auto_Mail_Campaign_Model::STATUS_DRAFT;
                }

                // Save data
                $id = $campaign_model->save();

                if (!$id) {
                    wp_send_json_error( $id );
                }else{
                    if($fields['action'] == 'send'){
                        // Filter subscribers from selected lists
                        $lists = $fields['lists'];
                        $status = "subscribed";
                        $allSubscribers = Auto_Mail_Subscriber_Model::model()->get_all_models( $status );
                        $subscribers = array();
                        foreach($allSubscribers['models'] as $key => $item){
                            foreach($item->settings['lists'] as $key => $list){
                                if(in_array($list, $lists)){
                                    $subscribers[] = $item->settings;
                                }
                            }
                        }

                        $unique_subscribers = array_map("unserialize", array_unique(array_map("serialize", $subscribers)));

                        // Add this campaign to sending queue
                        foreach($unique_subscribers as $key => $item){
                            $sendQueue = new Auto_Mail_Queue();
                            $sendQueue->add($id, $item['email_address'], $item['first_name']);
                        }

                        wp_send_json_success( esc_html__( 'Your newsletter has been shceduled to sending queue successfully!', Auto_Mail::DOMAIN ) );
                    }

                    wp_send_json_success( $id );
                }



            } else {
                wp_send_json_error( esc_html__( 'User submit data are empty!', Auto_Mail::DOMAIN ) );
            }
        }

        /**
        * Save Design
        *
        * @since 1.0.0
        */
        public function save_design() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            if ( isset( $_POST['fields_data'] ) ) {
                $fields  = $_POST['fields_data'];
                $id      = isset( $fields['id'] ) ? sanitize_text_field($fields['id']) : null;
                $id      = intval( $id );
                $template = sanitize_text_field( $fields['template'] );

                if ( is_null( $id ) || $id <= 0 ) {
                    // create campaign model
                    $campaign_model = new Auto_Mail_Campaign_Model();
                } else {
                    // update exist model
                    $campaign_model = Auto_Mail_Campaign_Model::model()->load( $id );
                    if ( ! is_object( $campaign_model ) ) {
                        wp_send_json_error( esc_html__( "Campaign model doesn't exist", Auto_Mail::DOMAIN ) );
                    }
                }

                // Set template to model
                $campaign_model->template = $template;

                // status
                $campaign_model->status = Auto_Mail_Campaign_Model::STATUS_PUBLISH;

                // Save data
                $id = $campaign_model->save();

                if (!$id) {
                    wp_send_json_error( $id );
                }else{
                    wp_send_json_success( $id );
                }

            } else {
                wp_send_json_error( esc_html__( 'User submit data are empty!', Auto_Mail::DOMAIN ) );
            }
        }

        /**
        * Save Automation
        *
        * @since 1.0.0
        */
        public function save_automation() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            if ( isset( $_POST['fields_data'] ) ) {
                $fields  = $_POST['fields_data'];
                $id      = isset( $fields['id'] ) ? sanitize_text_field($fields['id']) : null;
                $id      = intval( $id );
                $status  = isset( $fields['status'] ) ? sanitize_text_field( $fields['status'] ) : '';

                // settings
                $settings = $fields;

                if ( is_null( $id ) || $id <= 0 ) {
                    $form_model = new Auto_Mail_Automation_Model();
                    $action     = 'create';

                    if ( empty( $status ) ) {
                        $status = Auto_Mail_Automation_Model::STATUS_DRAFT;
                    }

                    // Set settings to model
                    $form_model->settings = $settings;

                    // status
                    $form_model->status = $status;

                    // Save data
                    $id = $form_model->save();

                    if (!$id) {
                        wp_send_json_error( $id );
                    }else{
                        // Add automation actions
                        foreach($fields['actions'] as $key => $action){
                            $action_id = am_add_action($id, $action);
                            // Add automation actions meta
                            am_add_action_meta($action_id, 'subject', $fields['woo_automation_email_subject']);
                            am_add_action_meta($action_id, 'content', $fields['pretty_message']);
                            am_add_action_meta($action_id, 'delay', $fields['update_frequency']);
                            am_add_action_meta($action_id, 'unit', $fields['update_frequency_unit']);
                        }
                        wp_send_json_success( $id );
                    }

                } else {
                    $form_model = Auto_Mail_Automation_Model::model()->load( $id );
                    $action     = 'update';

                    if ( ! is_object( $form_model ) ) {
                        wp_send_json_error( esc_html__( "Form model doesn't exist", Auto_Mail::DOMAIN ) );
                    }

                    if ( empty( $status ) ) {
                        $status = $form_model->status;
                    }

                    // Set settings to model
                    $form_model->settings = $settings;

                    // status
                    $form_model->status = $status;

                    // Save data
                    $id = $form_model->save();

                    $actions = am_automation_get_automation_actions($id);

                    $action_id = $actions[0]->id;
                    // Update automation actions meta
                    am_update_action_meta($action_id, 'subject', $fields['woo_automation_email_subject']);
                    am_update_action_meta($action_id, 'content', $fields['pretty_message']);
                    am_update_action_meta($action_id, 'delay', $fields['update_frequency']);
                    am_update_action_meta($action_id, 'unit', $fields['update_frequency_unit']);

                    wp_send_json_success( $id );
                }



                // // Set settings to model
                // $form_model->settings = $settings;

                // // status
                // $form_model->status = $status;

                // // Save data
                // $id = $form_model->save();

                // if (!$id) {
                //     wp_send_json_error( $id );
                // }else{
                //     // Add automation actions
                //     foreach($fields['actions'] as $key => $action){
                //         $action_id = am_add_action($id, $action);
                //         // Add automation actions meta
                //         am_add_action_meta($action_id, 'subject', $fields['woo_automation_email_subject']);
                //         am_add_action_meta($action_id, 'content', $fields['pretty_message']);
                //         am_add_action_meta($action_id, 'delay', $fields['update_frequency']);
                //         am_add_action_meta($action_id, 'unit', $fields['update_frequency_unit']);
                //     }
                //     wp_send_json_success( $id );
                // }

            } else {
                wp_send_json_error( esc_html__( 'User submit data are empty!', Auto_Mail::DOMAIN ) );
            }
        }

        /**
        * Generate Automation
        *
        * @since 1.0.0
        */
        public function generate_automation() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            if ( isset( $_POST['fields_data'] ) ) {
                $fields  = $_POST['fields_data'];
                $id      = isset( $fields['id'] ) ? sanitize_text_field($fields['id']) : null;
                $id      = intval( $id );
                $status  = isset( $fields['status'] ) ? sanitize_text_field( $fields['status'] ) : '';

                if ( is_null( $id ) || $id <= 0 ) {
                    $form_model = new Auto_Mail_Automation_Model();
                    $action     = 'create';

                    if ( empty( $status ) ) {
                        $status = Auto_Mail_Automation_Model::STATUS_DRAFT;
                    }
                } else {
                    $form_model = Auto_Mail_Automation_Model::model()->load( $id );
                    $action     = 'update';

                    if ( ! is_object( $form_model ) ) {
                        wp_send_json_error( esc_html__( "Form model doesn't exist", Auto_Mail::DOMAIN ) );
                    }

                    if ( empty( $status ) ) {
                        $status = $form_model->status;
                    }

                }

                // settings
                $settings = $fields;

                // Set settings to model
                $form_model->settings = $settings;

                // status
                $form_model->status = $status;

                // Save data
                $id = $form_model->save();

                if (!$id) {
                    wp_send_json_error( $id );
                }else{
                    // Add automation actions
                    foreach($fields['actions'] as $key => $action){
                        $action_id = am_add_action($id, $action);
                        // Add automation actions meta
                        am_add_action_meta($action_id, 'subject', $fields['woo_automation_email_subject']);
                        am_add_action_meta($action_id, 'content', $fields['pretty_message']);
                        am_add_action_meta($action_id, 'delay', $fields['update_frequency']);
                        am_add_action_meta($action_id, 'unit', $fields['update_frequency_unit']);
                    }
                    wp_send_json_success( $id );
                }

            } else {
                wp_send_json_error( esc_html__( 'User submit data are empty!', Auto_Mail::DOMAIN ) );
            }
        }

        /**
        * Save From
        *
        * @since 1.0.0
        */
        public function save_form() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            if ( isset( $_POST['fields_data'] ) ) {
                $fields  = $_POST['fields_data'];
                $id      = isset( $fields['form_id'] ) ? sanitize_text_field($fields['form_id']) : null;
                $id      = intval( $id );
                $status  = isset( $fields['form_status'] ) ? sanitize_text_field( $fields['form_status'] ) : '';

                if ( is_null( $id ) || $id <= 0 ) {
                    $form_model = new Auto_Mail_Form_Model();
                    $action     = 'create';

                    if ( empty( $status ) ) {
                        $status = Auto_Mail_Form_Model::STATUS_DRAFT;
                    }
                } else {
                    $form_model = Auto_Mail_Form_Model::model()->load( $id );
                    $action     = 'update';

                    if ( ! is_object( $form_model ) ) {
                        wp_send_json_error( esc_html__( "Form model doesn't exist", Auto_Mail::DOMAIN ) );
                    }

                    if ( empty( $status ) ) {
                        $status = $form_model->status;
                    }

                }

                // settings
                $settings = $fields;

                // Set settings to model
                $form_model->settings = $settings;

                // status
                $form_model->status = $status;

                // Save data
                $id = $form_model->save();

                if (!$id) {
                    wp_send_json_error( $id );
                }else{
                    wp_send_json_success( $id );
                }

            } else {
                wp_send_json_error( esc_html__( 'User submit data are empty!', Auto_Mail::DOMAIN ) );
            }
        }

        /**
        * Load From
        *
        * @since 1.0.0
        */
        public function load_form() {

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            // Grab php file output from server
            include AUTO_MAIL_DIR . '/admin/views/front/form.php';
            wp_die();

        }

        /**
        * Automation Send Test Email
        *
        * @since 1.0.0
        */
        public function am_send_test_email() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            if ( isset( $_POST['reveiver'] ) && !empty($_POST['reveiver']) ) {
                $settings = get_option('auto_mail_global_settings');
                $options = array(
                    'recipient_address' => sanitize_email($_POST['reveiver']),
                    'recipient_name' => 'admin'
                );

                $sender = new Auto_Mail_Sender($settings['delivery_method'], $options);
                $result = $sender->do_send(true);

                if($result['success']){
                    wp_send_json_success( $result['message'] );

                }else{
                    wp_send_json_error( $result['message'] );
                }

            } else {
                wp_send_json_error( __( 'Please input a valid email address!', Auto_Mail::DOMAIN ) );
            }


        }

        /**
        * Test email
        *
        * @since 1.0.0
        */
        public function test_email() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            if ( isset( $_POST['reveiver'] ) && !empty($_POST['reveiver']) ) {
                $settings = get_option('auto_mail_global_settings');
                $options = array(
                    'recipient_address' => sanitize_email($_POST['reveiver']),
                    'recipient_name' => 'admin'
                );

                $sender = new Auto_Mail_Sender($settings['delivery_method'], $options);
                $result = $sender->do_send(true);

                if($result['success']){
                    wp_send_json_success( $result['message'] );

                }else{
                    wp_send_json_error( $result['message'] );
                }

            } else {
                wp_send_json_error( __( 'Please input a valid email address!', Auto_Mail::DOMAIN ) );
            }


        }

        /**
        * Save Settings
        *
        * @since 1.0.0
        */
        public function save_settings() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            if ( isset( $_POST['fields_data'] ) ) {
                update_option( 'auto_mail_global_settings', $_POST['fields_data'] );

                wp_send_json_success( __( 'Global Settings has been saved successfully.', Auto_Mail::DOMAIN ) );
            } else {
                wp_send_json_error( __( 'User submit data are empty!', Auto_Mail::DOMAIN ) );
            }


        }

        /**
        * Save Subscriber
        *
        * @since 1.0.0
        */
        public function save_subscriber() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            if ( isset( $_POST['fields_data'] ) ) {
                $fields  = $_POST['fields_data'];
                $id      = isset( $fields['form_id'] ) ? sanitize_text_field($fields['form_id']) : null;
                $id      = intval( $id );
                $status  = isset( $fields['optin_status'] ) ? sanitize_text_field( $fields['optin_status'] ) : '';
                $email_address  = isset( $fields['email_address'] ) ? sanitize_email( $fields['email_address'] ) : '';
                if ( is_null( $id ) || $id <= 0 ) {
                    $form_model = new Auto_Mail_Subscriber_Model();
                    $action     = 'create';

                    if ( empty( $status ) ) {
                        $status = Auto_Mail_Subscriber_Model::STATUS_DRAFT;
                    }
                } else {
                    $form_model = Auto_Mail_Subscriber_Model::model()->load( $id );
                    $action     = 'update';
                    $form_model->id = $id;

                    if ( ! is_object( $form_model ) ) {
                        wp_send_json_error( esc_html__( "Form model doesn't exist", Auto_Mail::DOMAIN ) );
                    }

                }

                // Set settings to model
                $form_model->settings = $fields;

                // status
                $form_model->status = $status;

                // Save data
                $id = $form_model->save(false, $email_address);

                if (!$id) {
                    wp_send_json_error( $id );
                }else{
                    if($action == 'create'){
                        wp_send_json_success( __( 'Add subscriber successfully!', Auto_Mail::DOMAIN ) );
                    }else if($action == 'update'){
                        wp_send_json_success( __( 'Update subscriber successfully!', Auto_Mail::DOMAIN ) );
                    }
                }

            } else {
                wp_send_json_error( esc_html__( 'User submit data are empty!', Auto_Mail::DOMAIN ) );
            }
        }

        /**
        * Save List
        *
        * @since 1.0.0
        */
        public function save_list() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_POST['_ajax_nonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            if ( isset( $_POST['fields_data'] ) ) {
                $fields  = $_POST['fields_data'];
                $id      = isset( $fields['list_id'] ) ? sanitize_text_field($fields['list_id']) : null;
                $id      = intval( $id );
                $status  = isset( $fields['list_status'] ) ? sanitize_text_field( $fields['list_status'] ) : '';

                if(empty($fields['auto_mail_list_name'])){
                    wp_send_json_error( esc_html__( "Please specify a list name", Auto_Mail::DOMAIN ) );
                }

                if ( is_null( $id ) || $id <= 0 ) {
                    $form_model = new Auto_Mail_List_Model();
                    if ( empty( $status ) ) {
                        $status = Auto_Mail_List_Model::STATUS_PUBLISH;
                    }
                } else {
                    $form_model = Auto_Mail_List_Model::model()->load( $id );
                    if ( ! is_object( $form_model ) ) {
                        wp_send_json_error( esc_html__( "Form model doesn't exist", Auto_Mail::DOMAIN ) );
                    }
                    if ( empty( $status ) ) {
                        $status = $form_model->status;
                    }
                }

                // Set settings to model
                $form_model->settings = $fields;

                // status
                $form_model->status = $status;

                // Save data
                $id = $form_model->save();

                if (!$id) {
                    wp_send_json_error( $id );
                }else{
                    wp_send_json_success( __( 'Add list successfully!', Auto_Mail::DOMAIN ) );
                }

            } else {
                wp_send_json_error( esc_html__( 'User submit data are empty!', Auto_Mail::DOMAIN ) );
            }
        }

        public function download_export_file() {

            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! wp_verify_nonce($_GET['_wpnonce'], 'auto-mail') ) {
                wp_send_json_error( esc_html__( 'You are not allowed to perform this action', Auto_Mail::DOMAIN ) );
            }

            $folder = AUTO_MAIL_UPLOAD_DIR;

            $filename = basename( $_REQUEST['file'] );
            $file     = $folder . '/' . $filename;

            if ( ! file_exists( $file ) ) {
                die( 'not found' );
            }

            $format = $_REQUEST['format'];

            send_nosniff_header();
            nocache_headers();

            switch ( $format ) {
                case 'html':
                    header( 'Content-Type: text/html; name="' . $filename . '"' );
                    break;
                case 'xls':
                    header( 'Content-Type: application/vnd.ms-excel; name="' . $filename . '"' );
                    break;
                case 'csv':
                    header( 'Content-Type: text/csv; name="' . $filename . '"' );
                    header( 'Content-Transfer-Encoding: binary' );
                    break;
                default;
                die( 'format not allowed' );
            }

            header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
            header( 'Connection: close' );

            if ( 'html' == $format ) {
                echo '<table>' . "\n";
            } elseif ( 'xls' == $format ) {
                echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
                echo '<automail:Workbook xmlns:automail="urn:schemas-microsoft-com:office:spreadsheet">' . "\n";
                echo '<automail:Styles><automail:Style automail:ID="1"><automail:Font automail:Bold="1"/></automail:Style></automail:Styles>' . "\n";
                echo '<automail:Worksheet automail:Name="' . esc_attr__( 'Auto Mail Subscribers', 'automail' ) . '">' . "\n";
                echo '<automail:Table>' . "\n";
            }

            readfile( $file );

            if ( 'html' == $format ) {
                echo '</table>';
            } elseif ( 'xls' == $format ) {
                echo '</automail:Table>' . "\n";
                echo '</automail:Worksheet>' . "\n";
                echo '</automail:Workbook>';
            }

            global $wp_filesystem;

            if (empty($wp_filesystem)) {
                require_once (ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            $wp_filesystem->delete( $file );
            exit;
        }

    }

endif;
