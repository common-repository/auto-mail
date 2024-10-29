<?php
$triggers = Auto_Mail_Admin_Triggers::get_list();
$template = isset( $_GET['template'] ) ? sanitize_text_field( $_GET['template'] ) : '';
?>
<?php if ( !empty($template) ) { ?>
    <div class="auto-mail-box auto-mail-message am-user-selected-trigger">
        <div class="auto-mail-accordion auto-mail-accordion-block">
            <div class="auto-mail-accordion-item">
                <div class="auto-mail-accordion-item-header">
                    <div class="auto-mail-accordion-item-title auto-mail-trim-title">
                        <span class="auto-mail-trim-text am-trigger-type"><?php echo am_trigger_type_by_template($template); ?></span>
                        <span class="auto-mail-tag auto-mail-tag-green am-trigger-name"><?php echo am_get_trigger_by_template($template); ?></span>
                    </div>
                    <div class="auto-mail-accordion-item-date">
                        <strong><?php esc_html_e( 'Last Run', Auto_Mail::DOMAIN ); ?></strong>
                        <?php esc_html_e( 'Never', Auto_Mail::DOMAIN ); ?>
                    </div>
                    <div class="auto-mail-accordion-col-auto">
                        <a href="#" class="auto-mail-button am-trigger-event-trash auto-mail-button-ghost auto-mail-accordion-item-action auto-mail-desktop-visible">
                            <ion-icon name="trash" class="auto-mail-icon-trash"/></ion-icon>
                            <?php esc_html_e( 'Delete', Auto_Mail::DOMAIN ); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } elseif ( isset($settings['trigger-name']) && !empty($settings['trigger-name']) ) { ?>
        <div class="auto-mail-box auto-mail-message am-user-selected-trigger">
        <div class="auto-mail-accordion auto-mail-accordion-block">
            <div class="auto-mail-accordion-item">
                <div class="auto-mail-accordion-item-header">
                    <div class="auto-mail-accordion-item-title auto-mail-trim-title">
                        <span class="auto-mail-trim-text am-trigger-type"><?php echo $settings['trigger-type']; ?></span>
                        <span class="auto-mail-tag auto-mail-tag-green am-trigger-name"><?php echo $settings['trigger-name']; ?></span>
                    </div>
                    <div class="auto-mail-accordion-item-date">
                        <strong><?php esc_html_e( 'Last Run', Auto_Mail::DOMAIN ); ?></strong>
                        <?php esc_html_e( 'Never', Auto_Mail::DOMAIN ); ?>
                    </div>
                    <div class="auto-mail-accordion-col-auto">
                        <a href="#" class="auto-mail-button am-trigger-event-trash auto-mail-button-ghost auto-mail-accordion-item-action auto-mail-desktop-visible">
                            <ion-icon name="trash" class="auto-mail-icon-trash"/></ion-icon>
                            <?php esc_html_e( 'Delete', Auto_Mail::DOMAIN ); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="auto-mail-box auto-mail-message am-user-selected-trigger">

        <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/trigger.png'); ?>" class="auto-mail-image auto-mail-image-center" aria-hidden="true" alt="<?php esc_attr_e( 'Auto Mail', Auto_Mail::DOMAIN ); ?>">

        <div class="auto-mail-message-content">
            <p><?php esc_html_e( 'Select trigger event for your marketing automation.', Auto_Mail::DOMAIN ); ?></p>
            <p>
                <a href="#" class="auto-mail-add-trigger">
                    <button class="auto-mail-button auto-mail-button-blue popup-trigger">
                        <?php esc_html_e( 'Add Trigger', Auto_Mail::DOMAIN ); ?>
                    </button>
                </a>
            </p>
        </div>

    </div>
<?php } ?>

<div class="modal">
        <div class="modal-content modal-triggers-popup">
            <span class="auto-mail-close-button">×</span>
            <div class="auto-mail-box-header auto-mail-block-content-center">
		        <h3 class="auto-mail-popup-title"><?php esc_html_e( 'Choose a trigger event', Auto_Mail::DOMAIN ); ?></h3>
	        </div>
            <div class="am-trigger-message-box"></div>

            <div class="auto-mail-box-body auto-mail-box-triggers">

                    <div class="hub-box-selectors">
					    <ul class="type-list auto-mail-triggers-list">
                            <?php foreach ( $triggers as $key => $trigger ) { ?>
                            <li>
							    <label class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" class="hub-type hub-type-integration" data-trigger= "<?php echo esc_html($trigger['name']); ?>" value="<?php echo esc_html($trigger['name']); ?>" checked="checked">
								<span class="hub-plantform" data-plantform="<?php echo esc_html($trigger['name']); ?>">
                                    <img src="<?php echo esc_html($trigger['thumbnail']); ?>">
                                	<?php echo esc_html($trigger['name']); ?>
								</span>
							</label>
						    </li>
                        <?php } ?>
					    </ul>
                        <div class="am-single-trigger-wordpress wp-osprey-hide-form-builder">
                                <button class="auto-mail-button auto-mail-trigger-event auto-mail-button-white" data-type="wordpress" data-event="user-created">
                                    <?php esc_html_e( 'User Created', Auto_Mail::DOMAIN ); ?>
                                </button>
                                <button class="auto-mail-button auto-mail-trigger-event auto-mail-button-white" data-type="wordpress" data-event="user-login">
                                    <?php esc_html_e( 'User Login', Auto_Mail::DOMAIN ); ?>
                                </button>
                                <div class="am-single-event-cancel">
                                <button class="auto-mail-button auto-mail-button-blue am-single-trigger-cancel" data-trigger="wordpress">
                                    <?php esc_html_e( 'Cancel', Auto_Mail::DOMAIN ); ?>
                                </button>
                                </div>
                        </div>
                        <div class="am-single-trigger-woocommerce wp-osprey-hide-form-builder">
                            <div class="am-single-trigger-type">
                                <h3><?php esc_html_e( 'Cart', Auto_Mail::DOMAIN ); ?></h3>
                            </div>
                                <button class="auto-mail-button am-triggers-pro-button auto-mail-trigger-event auto-mail-button-white">
                                    <?php esc_html_e( 'Cart Abandoned', Auto_Mail::DOMAIN ); ?>
                                    <ion-icon class="auto-mail-icon-lock" name="lock-closed"></ion-icon>
                                </button>
                                <button class="auto-mail-button am-triggers-pro-button auto-mail-trigger-event auto-mail-button-white">
                                    <?php esc_html_e( 'Cart Recovered', Auto_Mail::DOMAIN ); ?>
                                    <ion-icon class="auto-mail-icon-lock" name="lock-closed"></ion-icon>
                                </button>

                            <div class="am-single-trigger-type">
                                <h3><?php esc_html_e( 'Orders', Auto_Mail::DOMAIN ); ?></h3>
                            </div>
                                <button class="auto-mail-button am-triggers-pro-button auto-mail-trigger-event auto-mail-button-white">
                                    <?php esc_html_e( 'Order Created', Auto_Mail::DOMAIN ); ?>
                                    <ion-icon class="auto-mail-icon-lock" name="lock-closed"></ion-icon>
                                </button>
                                <button class="auto-mail-button am-triggers-pro-button auto-mail-trigger-event auto-mail-button-white">
                                    <?php esc_html_e( 'Order Status Changed', Auto_Mail::DOMAIN ); ?>
                                    <ion-icon class="auto-mail-icon-lock" name="lock-closed"></ion-icon>
                                </button>
                                <div class="am-single-event-cancel">
                                    <button class="auto-mail-button auto-mail-button-blue am-single-trigger-cancel" data-trigger="woocommerce">
                                        <?php esc_html_e( 'Cancel', Auto_Mail::DOMAIN ); ?>
                                    </button>
                                </div>
                        </div>
				    </div>
            </div>

            <div class="auto-mail-box-footer">
				<div class="auto-mail-actions-left">
					<a href="#">
                            <button class="auto-mail-button auto-mail-close-button">
                                <?php esc_html_e( 'Close', Auto_Mail::DOMAIN ); ?>
                            </button>
                    </a>
				</div>
				<div class="auto-mail-actions-right">
					<a href="#" id="auto-mail-quick-add-subscriber">
                            <button class="auto-mail-button am-add-trigger-button auto-mail-button-blue">
                                <?php esc_html_e( 'Done', Auto_Mail::DOMAIN ); ?>
                            </button>
                    </a>
				</div>
			</div>
        </div>
    </div>
