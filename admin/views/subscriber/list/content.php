<?php
$status = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '';
$keyword = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';


// Count total forms
$count        = $this->countModules();
$count_active = $this->countModules( $status );

// available bulk actions
$bulk_actions = $this->bulk_actions();

$status_list = array(
    "subscribed" => "Subscribed",
    "unconfirmed" => "Unconfirmed",
    "confirmed" => "Confirmed",
    "unsubscribed" => "Unsubscribed",
    "bounced" => "Bounced",
    "spam" => "Spam"
);
?>

<?php if ( $count > 0 ) { ?>
    <!-- START: Filter actions -->
    <div class="auto-mail-listings-pagination">
        <div class="auto-mail-pagination-desktop auto-mail-box auto-mail-filter-box">
            <div class="auto-mail-box-search">
                <div class="auto-mail-search-left">
                    <div class="subscribers-status-count">
                        <a href="<?php echo admin_url( 'admin.php?page=auto-mail-subscribers' ); ?>">
                            <?php esc_html_e( 'All', Auto_Mail::DOMAIN ); ?>
                            <span class="count"><?php echo $count; ?></span>
                        </a>
                        <?php foreach ( $status_list as $key => $value ) : ?>
                            <a href="<?php echo admin_url( 'admin.php?page=auto-mail-subscribers&status='.$key ); ?>">
                                <?php echo esc_attr( $value ); ?>
                                <span class="count"><?php echo auto_mail_subscribers_count_by_status($key); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="auto-mail-search-right">
                    <div class="auto-mail-subscribers-search">
                        <form method="get">
			                <input type="hidden" name="page" class="regular-text" value="auto-mail-subscribers">
                            <input type="text" name="s" class="input" placeholder="<?php esc_html_e( 'Name or Email', Auto_Mail::DOMAIN ); ?>">
                            <button type="submit" class="auto-mail-button auto-mail-button-blue">
                                <?php esc_html_e( 'Search', Auto_Mail::DOMAIN ); ?>
                            </button>
                    	</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Filter actions -->

    <form method="post" name="auto-mail-bulk-action-form">
    <div class="auto-mail-box">
        <div class="auto-mail-box-body fui-box-actions">
            <div class="auto-mail-box-search">
                <div class="auto-mail-search-left">
                    <input type="hidden" name="auto_mail_nonce" value="<?php echo wp_create_nonce( 'auto-mail-subscriber-request' );?>">
                    <input type="hidden" name="_wp_http_referer" value="<?php admin_url( 'admin.php?page=auto-mail-subscribers' ); ?>">
                    <input type="hidden" name="ids" id="auto-mail-select-subscribers-ids" value="">
                    <div class="auto-mail-select-wrapper">
                        <select name="auto_mail_bulk_action" class="auto_mail_subscribers_bulk_action" id="bulk-action-selector-top">
                            <option value=""><?php esc_html_e( 'Bulk Action', Auto_Mail::DOMAIN ); ?></option>
                            <?php foreach ( $bulk_actions as $val => $label ) : ?>
                                <option value="<?php echo esc_attr( $val ); ?>"><?php echo esc_html( $label ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="auto-mail-button auto-mail-bulk-action-button"><?php esc_html_e( 'Apply', Auto_Mail::DOMAIN ); ?></button>
                </div>
                <div class="auto-mail-search-right">
                    <div class="auto-mail-pagination-wrap">
                    <?php if ( empty($keyword) ) { ?>
                        <span class="auto-mail-pagination-results">
                            <?php /* translators: ... */ echo esc_html( sprintf( _n( '%s result', '%s results', $count_active, Auto_Mail::DOMAIN ), $count_active ) ); ?>
                        </span>
                    <?php } ?>
                        <?php $this->pagination(); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if ( $count_active == 0 || empty($this->getModules($status, $keyword))) { ?>
            <div class="auto-mail-subscribers-not-found">
                <p><?php esc_html_e( 'No subscribers were found', Auto_Mail::DOMAIN ); ?></p>
            </div>
        <?php } else { ?>
        <table class="auto-mail-table auto-mail-table-flushed auto-mail-accordion fui-table-entries">
            <thead>
                <tr>
                    <th class="check-column">
                        <label for="auto-mail-check-all-subscribers" class="auto-mail-checkbox">
                            <input type="checkbox" id="auto-mail-check-all-subscribers">
                            <span aria-hidden="true"></span>
                            <span class="auto-mail-screen-reader-text"><?php esc_html_e( 'Select all', Auto_Mail::DOMAIN ); ?></span>
                        </label>
            	    </th>
			        <th><?php esc_html_e( 'Email Address', Auto_Mail::DOMAIN ); ?></th>
				    <th><?php esc_html_e( 'First Name', Auto_Mail::DOMAIN ); ?></th>
				    <th><?php esc_html_e( 'Subscriber On', Auto_Mail::DOMAIN ); ?></th>
                    <th><?php esc_html_e( 'Status', Auto_Mail::DOMAIN ); ?></th>
		        </tr>
            </thead>
            <tbody>
                <?php
                    foreach ( $this->getModules($status, $keyword) as $module ) {
                ?>
                    <tr class="auto-mail-subscriber-item" data-entry-id="<?php echo esc_attr( $module['id'] ); ?>">
                    <th class="check-column">
				        <label class="auto-mail-checkbox">
					        <input type="checkbox" id="wpf-module-<?php echo esc_attr( $module['id'] ); ?>" class="auto-mail-check-single-subscriber" value="<?php echo esc_html( $module['id'] ); ?>">
				        </label>
            	    </th>
                        <td>
                            <div class="auto-mail-single-subscriber-item">
                                <?php echo auto_mail_get_subscriber_email( $module['id'] ); ?>
                            </div>
                            <div class="auto-mail-row-actions">
                                <span class="edit"><a href="<?php echo admin_url( 'admin.php?page=auto-mail-subscriber-wizard&id='.$module['id'] ); ?>"><?php esc_html_e( 'Edit', Auto_Mail::DOMAIN ); ?></a> | </span>
                                <span class="trash"><a href="<?php echo admin_url( 'admin.php?page=auto-mail-subscribers&action=trash&id='.$module['id'] ); ?>"><?php esc_html_e( 'Spam', Auto_Mail::DOMAIN ); ?></a> | </span>
                                <span class="delete"><a class="auto-mail-single-delete-popup auto-mail-single-delete-action" data-subscriber-id = "<?php echo $module['id']; ?>" href="#"><?php esc_html_e( 'Delete', Auto_Mail::DOMAIN ); ?></a></span>
                            </div>
                        </td>
                        <td>
                            <div class="auto-mail-single-subscriber-item">
                                <?php echo auto_mail_get_subscriber_name( $module['id'] ); ?>
                            </div>
                        </td>
                        <td>
                            <div class="auto-mail-single-subscriber-item">
                                <?php echo $module['date']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="auto-mail-single-subscriber-item">
                                <?php echo $module['status']; ?>
                            </div>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
            </table>
        <?php
            }
        ?>
    </div>
    </form>


<?php } else { ?>
<div class="auto-mail-box auto-mail-message auto-mail-message-lg">

    <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/auto-mail.png'); ?>" class="auto-mail-image auto-mail-image-center" aria-hidden="true" alt="<?php esc_attr_e( 'Auto Mail', Auto_Mail::DOMAIN ); ?>">

    <div class="auto-mail-message-content">

        <p><?php esc_html_e( 'Create new subscriber to build your email lists.', Auto_Mail::DOMAIN ); ?></p>

        <p>
            <a href="#">
                <button class="popup-trigger auto-mail-button auto-mail-button-blue" data-modal="custom_forms">
                    <i class="auto-mail-icon-plus" aria-hidden="true"></i>
                    <?php esc_html_e( 'Add New', Auto_Mail::DOMAIN ); ?>
                </button>
            </a>
        </p>

    </div>

</div>
<?php } ?>

<div class="modal">
        <div class="modal-content">
            <span class="auto-mail-close-button">×</span>
            <div class="auto-mail-box-header auto-mail-block-content-center">
		        <h3 class="auto-mail-popup-title"><?php esc_html_e( 'Add Subscriber', Auto_Mail::DOMAIN ); ?></h3>
	        </div>

            <div class="auto-mail-box-body auto-mail-block-content-center">
			        <p>
                        <small>
                            <?php esc_html_e( 'Add new subscriber quickly with the following fields', Auto_Mail::DOMAIN ); ?>
                        </small>
                    </p>
                    <form class="auto-mail-quick-subscriber-form" method="post" name="auto-mail-quick-subscriber-form" action="">
                    <div class="hub-box-selectors">
					<ul class="subscribers-list">
						<li>
							<label for="first-name">
                                <?php esc_html_e( 'First Name', Auto_Mail::DOMAIN ); ?>
                            </label>
                            <input
                                type="text"
                                name="first_name"
                                placeholder="<?php esc_html_e( 'John', Auto_Mail::DOMAIN ); ?>"
                            />
						</li>
                        <li>
							<label for="last-name">
                                <?php esc_html_e( 'Last Name', Auto_Mail::DOMAIN ); ?>
                            </label>
                            <input
                                type="text"
                                name="last_name"
                                placeholder="<?php esc_html_e( 'Doe', Auto_Mail::DOMAIN ); ?>"
                            />
						</li>
                        <li>
							<label for="email_address">
                                <?php esc_html_e( 'Email Address', Auto_Mail::DOMAIN ); ?>
                            </label>
                            <input
                                type="text"
                                name="email_address"
                                placeholder="<?php esc_html_e( 'John@example.com', Auto_Mail::DOMAIN ); ?>"
                            />
						</li>
                        <li>
							<label for="optin_status">
                                <?php esc_html_e( 'Optin Status', Auto_Mail::DOMAIN ); ?>
                            </label>
                            <select name="optin_status">
                                <?php foreach ( $status_list as $key => $value ) : ?>
                                    <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
                                <?php endforeach; ?>
                            </select>
						</li>
					</ul>
				    </div>
                    </form>
            </div>

            <div class="auto-mail-box-footer">
				<div class="auto-mail-actions-left">
					<a href="#">
                            <button class="auto-mail-button auto-mail-close-button">
                                <?php esc_html_e( 'Cancel', Auto_Mail::DOMAIN ); ?>
                            </button>
                    </a>
				</div>
				<div class="auto-mail-actions-right">
					<a href="#" id="auto-mail-quick-add-subscriber">
                            <button class="auto-mail-button auto-mail-button-blue">
                                <?php esc_html_e( 'Add Subscriber', Auto_Mail::DOMAIN ); ?>
                            </button>
                    </a>
				</div>
			</div>
        </div>
    </div>

<div class="delete-modal">
   <div class="delete-modal-content">
        <span class="auto-mail-delete-close-button">×</span>
        <div class="auto-mail-box-header auto-mail-block-content-center">
		        <h3 class="auto-mail-popup-title"><?php esc_html_e( 'Delete Subscriber', Auto_Mail::DOMAIN ); ?></h3>
	    </div>

            <div class="auto-mail-box-body auto-mail-block-content-center">
                <p>
                    <small>
                        <?php esc_html_e( 'Are you sure you wish to permanently delete this subscriber?', Auto_Mail::DOMAIN ); ?>
                    </small>
                </p>
            </div>

            <div class="auto-mail-box-footer">
				<div class="auto-mail-actions-left">
					<a href="#">
                            <button class="auto-mail-button auto-mail-delete-close-button">
                                <?php esc_html_e( 'Cancel', Auto_Mail::DOMAIN ); ?>
                            </button>
                    </a>
				</div>
				<div class="auto-mail-actions-right">
                    <form method="post" class="delete-action">
                        <input type="hidden" name="auto_mail_single_action" value="delete">
                        <input type="hidden" class="auto-mail-delete-id" name="id" value="">
                        <input type="hidden" name="auto_mail_nonce" value="<?php echo wp_create_nonce( 'auto-mail-subscriber-request' );?>">
                        <input type="hidden" name="_wp_http_referer" value="<?php admin_url( 'admin.php?page=auto-mail-subscribers' ); ?>">
                        <button type="submit" class="auto-mail-button auto-mail-button-ghost auto-mail-button-red">
                            <ion-icon class="auto-mail-icon-trash" name="trash"></ion-icon>
                            <?php esc_html_e( 'Delete', Auto_Mail::DOMAIN ); ?>
                        </button>
                    </form>
				</div>
			</div>
    </div>
</div>