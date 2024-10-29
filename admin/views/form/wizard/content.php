<?php
$id = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
$template = isset( $_GET['template'] ) ? sanitize_text_field( $_GET['template'] ) : 'minimal';

// Campaign Settings
$settings = array();
$shortcode = 'You shortcode is empty now, Please add your phone to build the shortcode';
if(!empty($id)){
    $model    = $this->get_single_model( $id );
    $settings = $model->settings;
    $settings['status'] = $model->status;
    $template = $settings['template'];
    $shortcode = '[auto-mail-form id="'.$id.'"]Here is hidden content[/auto-mail-form]';
}

$on_submit = isset( $settings['on_submit'] ) ? $settings['on_submit'] : 'show_message';

?>
<div class="form-wizard-editor-wrapper am-form-editor">

<div class="auto-mail-row-with-sidenav">

    <div class="auto-mail-sidenav">

        <div class="auto-mail-mobile-select">
            <span class="auto-mail-select-content"><?php esc_html_e( 'General', Auto_Mail::DOMAIN ); ?></span>
            <ion-icon name="chevron-down" class="auto-mail-icon-down"></ion-icon>
        </div>

        <ul class="auto-mail-vertical-tabs auto-mail-sidenav-hide-md">

            <li class="auto-mail-vertical-tab current">
                <a href="#" data-nav="general"><?php esc_html_e( 'General', Auto_Mail::DOMAIN ); ?></a>
            </li>

			<li class="auto-mail-vertical-tab">
                <a href="#" data-nav="settings"><?php esc_html_e( 'Settings', Auto_Mail::DOMAIN ); ?></a>
            </li>

			<li class="auto-mail-vertical-tab">
                <a href="#" data-nav="integration"><?php esc_html_e( 'Integration', Auto_Mail::DOMAIN ); ?></a>
            </li>
        </ul>

    </div>

    <form class="auto-mail-form-data" method="post" name="auto-mail-form-data" action="">

    <div class="auto-mail-box-tabs">
		<?php $this->template( 'form/wizard/sections/tab-save', $settings); ?>
        <?php $this->template( 'form/wizard/sections/tab-general', $settings); ?>
		<?php $this->template( 'form/wizard/sections/tab-settings',  $settings); ?>
		<?php $this->template( 'form/wizard/sections/tab-integration',  $settings); ?>
    </div>
        <input type="hidden" name="form_id" value="<?php echo esc_html($id); ?>">
        <input type="hidden" name="template" value="<?php echo esc_html($template); ?>">
		<input type="hidden" name="on_submit" value="<?php echo esc_html($on_submit); ?>">
    </form>
</div>

    <div class="modal">
        <div class="modal-content">
            <span class="auto-mail-close-button">×</span>
            <div class="auto-mail-box-header auto-mail-block-content-center">
		        <h3 class="auto-mail-popup-title"><?php esc_html_e( 'Insert Fields', Auto_Mail::DOMAIN ); ?></h3>
	        </div>

            <div class="auto-mail-box-body auto-mail-block-content-center">
			        <p>
                        <small>
                            <?php esc_html_e( 'Choose which fields you want to insert into your opt-in form.', Auto_Mail::DOMAIN ); ?>
                        </small>
                    </p>
                    <div class="hub-box-selectors">
					<ul class="type-list">
						<li>
							<label for="hub-type-email" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-email" class="hub-type" value="email">
								<span class="hub-plantform" data-plantform="email">
                                    <ion-icon name="mail" class="auto-mail-icon-email"></ion-icon>
									<?php esc_html_e( 'Email', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
						<li>
							<label for="hub-type-name" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-name" class="hub-type" value="name">
								<span class="hub-plantform" data-plantform="name">
                                <ion-icon name="person" class="auto-mail-icon-name"></ion-icon>
                                <?php esc_html_e( 'Name', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
						<li>
							<label for="hub-type-phone" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-phone" class="hub-type" value="phone">
								<span class="hub-plantform" data-plantform="phone">
                                <ion-icon name="call" class="auto-mail-icon-phone"></ion-icon>
                                <?php esc_html_e( 'Phone', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
						<li>
							<label for="hub-type-address" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-address" class="hub-type" value="address" >
								<span class="hub-plantform" data-plantform="address">
                                <ion-icon name="location" class="auto-mail-icon-address"></ion-icon>
                                <?php esc_html_e( 'Address', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
						<li>
							<label for="hub-type-website" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-website" class="hub-type" value="website" >
								<span class="hub-plantform" data-plantform="website">
                                <ion-icon name="globe" class="auto-mail-icon-website"></ion-icon>
                                <?php esc_html_e( 'Website', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
						<li>
							<label for="hub-type-text" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-text" class="hub-type" value="text" >
								<span class="hub-plantform" data-plantform="text">
                                    <ion-icon name="text" class="auto-mail-icon-text"></ion-icon>
                                	<?php esc_html_e( 'Text', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
                        <li>
							<label for="hub-type-number" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-number" class="hub-type" value="number" >
								<span class="hub-plantform" data-plantform="number">
                                    <ion-icon name="calendar-number" class="auto-mail-icon-number"></ion-icon>
                                	<?php esc_html_e( 'Number', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
                        <li>
							<label for="hub-type-datepicker" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-datepicker" class="hub-type" value="datepicker" >
								<span class="hub-plantform" data-plantform="datepicker">
                                    <ion-icon name="calendar" class="auto-mail-icon-datepicker"></ion-icon>
                                	<?php esc_html_e( 'Datepicker', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
                        <li>
							<label for="hub-type-timepicker" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-timepicker" class="hub-type" value="timepicker" >
								<span class="hub-plantform" data-plantform="timepicker">
                                    <ion-icon name="time" class="auto-mail-icon-timepicker"></ion-icon>
                                	<?php esc_html_e( 'Timepicker', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
                        <li>
							<label for="hub-type-recaptcha" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-recaptcha" class="hub-type" value="recaptcha" >
								<span class="hub-plantform" data-plantform="recaptcha">
                                    <ion-icon name="refresh-circle" class="auto-mail-icon-recaptcha"></ion-icon>
                                	<?php esc_html_e( 'reCaptcha', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
                        <li>
							<label for="hub-type-gdrp" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-gdrp" class="hub-type" value="gdrp" >
								<span class="hub-plantform" data-plantform="gdrp">
                                    <ion-icon name="shield-checkmark" class="auto-mail-icon-gdrp"></ion-icon>
                                	<?php esc_html_e( 'GDRP', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
                        <li>
							<label for="hub-type-hidden" class="hub-box-selector hub-box-selector-vertical">
								<input type="radio" name="hub-selected-type" id="hub-type-hidden" class="hub-type" value="hidden" >
								<span class="hub-plantform" data-plantform="hidden">
                                    <ion-icon name="eye-off" class="auto-mail-icon-hidden"></ion-icon>
                                	<?php esc_html_e( 'Hidden', Auto_Mail::DOMAIN ); ?>
								</span>
							</label>
						</li>
					</ul>
				</div>
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
					<a href="#">
                            <button class="auto-mail-button auto-mail-button-blue">
                                <?php esc_html_e( 'Insert Field', Auto_Mail::DOMAIN ); ?>
                            </button>
                    </a>
				</div>
			</div>
        </div>
    </div>
</div>

<?php $this->template( 'form/wizard/sections/tab-preview', $settings); ?>

