<div id="general" class="auto-mail-box-tab active" data-nav="general" >

	<div class="auto-mail-box-header">
		<h2 class="auto-mail-box-title"><?php esc_html_e( 'General', Auto_Mail::DOMAIN ); ?></h2>
	</div>

    <div class="auto-mail-box-body">
        <div class="auto-mail-box-settings-row">
            <div class="auto-mail-box-settings-col-1">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'Default sender', Auto_Mail::DOMAIN ); ?></span>
                <span class="auto-mail-description"><?php esc_html_e( 'These email addresses will be selected by default for each new email.', Auto_Mail::DOMAIN ); ?></span>
            </div>
            <div class="auto-mail-box-settings-col-2 auto-mail-box-settings-inputs">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'From', Auto_Mail::DOMAIN ); ?></span>
                <input
                    type="text"
                    name="from_name"
                    placeholder="<?php esc_html_e( 'Your name', Auto_Mail::DOMAIN ); ?>"
                    value="<?php if(isset($settings['from_name'])){echo $settings['from_name'];} ?>"
                    id="auto_mail_from_name"
                    class="auto-mail-form-control"
                />
                <input
                    type="text"
                    name="from_address"
                    placeholder="<?php esc_html_e( 'from@domain.com', Auto_Mail::DOMAIN ); ?>"
                    value="<?php if(isset($settings['from_address'])){echo $settings['from_address'];} ?>"
                    id="auto_mail_from_address"
                    class="auto-mail-form-control"
                />
                </br>
                <span class="auto-mail-settings-label"><?php esc_html_e( 'Reply-to', Auto_Mail::DOMAIN ); ?></span>
                <input
                    type="text"
                    name="reply_name"
                    placeholder="<?php esc_html_e( 'Reply name', Auto_Mail::DOMAIN ); ?>"
                    value="<?php if(isset($settings['reply_name'])){echo $settings['reply_name'];} ?>"
                    id="auto_mail_reply_name"
                    class="auto-mail-form-control"
                />
                <input
                    type="text"
                    name="reply_address"
                    placeholder="<?php esc_html_e( 'reply@domain.com', Auto_Mail::DOMAIN ); ?>"
                    value="<?php if(isset($settings['reply_address'])){echo $settings['reply_address'];} ?>"
                    id="auto_mail_reply_address"
                    class="auto-mail-form-control"
                />
            </div>
        </div>
   </div>

   <div class="auto-mail-box-footer">

        <div class="auto-mail-actions-right">

            <button class="auto-mail-save-settings auto-mail-button auto-mail-button-blue" type="button">
                <span class="auto-mail-loading-text"><?php esc_html_e( 'Save Settings', Auto_Mail::DOMAIN ); ?></span>
            </button>

        </div>

    </div>


</div>