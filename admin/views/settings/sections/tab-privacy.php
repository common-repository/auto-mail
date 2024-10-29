<?php
$gdpr_enable_checked = isset($settings['gdpr_enable']) && $settings['gdpr_enable']== 'on' ? 'checked' : '';
$track_open_checked = isset($settings['track_open']) && $settings['track_open']== 'on' ? 'checked' : '';
?>
<div id="privacy" class="auto-mail-box-tab" data-nav="privacy" >

	<div class="auto-mail-box-header">
		<h2 class="auto-mail-box-title"><?php esc_html_e( 'Privacy', Auto_Mail::DOMAIN ); ?></h2>
	</div>

    <div class="auto-mail-box-body">
        <div class="auto-mail-box-settings-row">
            <div class="auto-mail-box-settings-col-1">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'Tracking', Auto_Mail::DOMAIN ); ?></span>
            </div>
            <div class="auto-mail-box-settings-col-2">
                <label class="switch" for="track_open">
                   <input type="checkbox" id="track_open" name='track_open' <?php echo esc_attr($track_open_checked); ?> />
                   <div class="slider round"></div>
                </label>
                <span class="switch-option-text"><?php esc_html_e( 'Track opens in your campaigns.', Auto_Mail::DOMAIN ); ?></span>
            </div>
        </div>
        <div class="auto-mail-box-settings-row">
            <div class="auto-mail-box-settings-col-1">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'GDPR Compliance Forms', Auto_Mail::DOMAIN ); ?></span>
                <span class="auto-mail-description"><?php esc_html_e( 'Users must check this checkbox to submit the form.', Auto_Mail::DOMAIN ); ?></span>
            </div>
            <div class="auto-mail-box-settings-col-2">
                <label class="switch" for="gdpr">
                   <input type="checkbox" id="gdpr" name='gdpr_enable' <?php echo esc_attr($gdpr_enable_checked); ?> />
                   <div class="slider round"></div>
                </label>
                <span class="switch-option-text"><?php esc_html_e( ' Add a checkbox on your forms for user consent.', Auto_Mail::DOMAIN ); ?></span>
            </div>
        </div>
   </div>


</div>