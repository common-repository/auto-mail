<?php
if(!isset($settings['delivery_method'])){
    $settings['delivery_method'] = 'smtp';
}
$sending_frequency = isset($settings['sending_frequency']) ? $settings['sending_frequency']  : "5";
$frequency = array(
    "1" => "Every mimute",
    "2" => "Every 2 mimutes",
    "5" => "Every 5 mimutes(recommended)",
    "10" => "Every 10 mimutes",
    "15" => "Every 15 mimutes",
    "30" => "Every 30 mimutes"
);
$sending_limit = isset($settings['sending_limit ']) ? $settings['sending_limit']  : "25";
?>
<div id="delivery" class="auto-mail-box-tab" data-nav="delivery" >

	<div class="auto-mail-box-header">
		<h2 class="auto-mail-box-title"><?php esc_html_e( 'Delivery', Auto_Mail::DOMAIN ); ?></h2>
	</div>

    <div class="auto-mail-box-body">
        <div class="auto-mail-box-settings-row">
            <div class="auto-mail-box-settings-col-1">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'Delivery Method', Auto_Mail::DOMAIN ); ?></span>
                <span class="auto-mail-description"><?php esc_html_e( "It's recommend to go with a dedicate ESP to prevent rejections and server blocking.", Auto_Mail::DOMAIN ); ?></span>
            </div>
            <div class="auto-mail-box-settings-col-2">
                <div class="sui-side-tabs">
                    <div class="sui-tabs-menu">
                        <div class="sui-tab-item <?php echo ( $settings['delivery_method'] == 'smtp' ? 'active' : '' ); ?>" data-nav="smtp">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/email.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'SMTP', Auto_Mail::DOMAIN ); ?>">
                        </div>
                        <div class="sui-tab-item <?php echo ( $settings['delivery_method'] == 'sendgrid' ? 'active' : '' ); ?>" data-nav="sendgrid">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/sendgrid.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'SendGrid', Auto_Mail::DOMAIN ); ?>">
                        </div>
                        <div class="sui-tab-item <?php echo ( $settings['delivery_method'] == 'amazon' ? 'active' : '' ); ?>" data-nav="amazon">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/aws.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'Amazon', Auto_Mail::DOMAIN ); ?>">
                        </div>
                        <div class="sui-tab-item <?php echo ( $settings['delivery_method'] == 'gmail' ? 'active' : '' ); ?>" data-nav="gmail">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/gmail.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'Gmail', Auto_Mail::DOMAIN ); ?>">
                        </div>
                        <div class="sui-tab-item <?php echo ( $settings['delivery_method'] == 'sendinblue' ? 'active' : '' ); ?>" data-nav="sendinblue">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/sendinblue.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'Sendinblue', Auto_Mail::DOMAIN ); ?>">
                        </div>
                        <div class="sui-tab-item <?php echo ( $settings['delivery_method'] == 'mailjet' ? 'active' : '' ); ?>" data-nav="mailjet">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/mailjet.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'Mailjet', Auto_Mail::DOMAIN ); ?>">
                        </div>
                        <div class="sui-tab-item <?php echo ( $settings['delivery_method'] == 'mailgun' ? 'active' : '' ); ?>" data-nav="mailgun">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/mailgun.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'Mailgun', Auto_Mail::DOMAIN ); ?>">
                        </div>
                        <div class="sui-tab-item <?php echo ( $settings['delivery_method'] == 'sparkpost' ? 'active' : '' ); ?>" data-nav="sparkpost">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/sparkpost.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'Sparkpost', Auto_Mail::DOMAIN ); ?>">
                        </div>
                    </div>
                </div>
                <div class="sui-tabs-content">
                    <div class="sui-tab-content auto-mail-box-settings-inputs <?php echo ( $settings['delivery_method'] == 'smtp' ? 'active' : '' ); ?>" id="smtp">
                        <input
                            type="text"
                            name="smtp_host_name"
                            placeholder="<?php esc_html_e( 'SMTP host name', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['smtp_host_name'])){echo $settings['smtp_host_name'];} ?>"
                            id="smtp_host_name"
                            class="auto-mail-form-control"
                        />
                        <input
                            type="text"
                            name="smtp_login"
                            placeholder="<?php esc_html_e( 'Login', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['smtp_login'])){echo $settings['smtp_login'];} ?>"
                            id="smtp_login"
                            class="auto-mail-form-control"
                        />
                        <input
                            type="text"
                            name="smtp_password"
                            placeholder="<?php esc_html_e( 'Password', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['smtp_password'])){echo $settings['smtp_password'];} ?>"
                            id="smtp_password"
                            class="auto-mail-form-control"
                        />
                    </div>
                    <div class="sui-tab-content <?php echo ( $settings['delivery_method'] == 'sendgrid' ? 'active' : '' ); ?>" id="sendgrid">
                        <input
                            type="text"
                            name="sendgrid_api_key"
                            placeholder="<?php esc_html_e( 'SendGrid API Key', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['sendgrid_api_key'])){echo $settings['sendgrid_api_key'];} ?>"
                            id="sendgrid_api_key"
                            class="auto-mail-form-control"
                        />
                    </div>
                    <div class="sui-tab-content <?php echo ( $settings['delivery_method'] == 'amazon' ? 'active' : '' ); ?>" id="amazon">
                        <input
                            type="text"
                            name="amazon_api_key"
                            placeholder="<?php esc_html_e( 'Amazon API Key', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['amazon_api_key'])){echo $settings['amazon_api_key'];} ?>"
                            id="amazon_api_key"
                            class="auto-mail-form-control"
                        />
                    </div>
                    <div class="sui-tab-content <?php echo ( $settings['delivery_method'] == 'gmail' ? 'active' : '' ); ?>" id="gmail">
                        <input
                            type="text"
                            name="gmail_api_key"
                            placeholder="<?php esc_html_e( 'Gmail API Key', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['gmail_api_key'])){echo $settings['gmail_api_key'];} ?>"
                            id="gmail_api_key"
                            class="auto-mail-form-control"
                        />
                    </div>
                    <div class="sui-tab-content <?php echo ( $settings['delivery_method'] == 'sendinblue' ? 'active' : '' ); ?>" id="sendinblue">
                        <input
                            type="text"
                            name="sendinblue_api_key"
                            placeholder="<?php esc_html_e( 'Sendinblue API Key', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['sendinblue_api_key'])){echo $settings['sendinblue_api_key'];} ?>"
                            id="sendinblue_api_key"
                            class="auto-mail-form-control"
                        />
                    </div>
                    <div class="sui-tab-content <?php echo ( $settings['delivery_method'] == 'mailjet' ? 'active' : '' ); ?>" id="mailjet">
                        <input
                            type="text"
                            name="mailjet_api_key"
                            placeholder="<?php esc_html_e( 'MailJet API Key', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['mailjet_api_key'])){echo $settings['mailjet_api_key'];} ?>"
                            id="mailjet_api_key"
                            class="auto-mail-form-control"
                        />
                    </div>
                    <div class="sui-tab-content <?php echo ( $settings['delivery_method'] == 'mailgun' ? 'active' : '' ); ?>" id="mailgun">
                        <input
                            type="text"
                            name="mailgun_api_key"
                            placeholder="<?php esc_html_e( 'Mailgun API Key', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['mailgun_api_key'])){echo $settings['mailgun_api_key'];} ?>"
                            id="mailgun_api_key"
                            class="auto-mail-form-control"
                        />
                    </div>
                    <div class="sui-tab-content <?php echo ( $settings['delivery_method'] == 'sparkpost' ? 'active' : '' ); ?>" id="sparkpost">
                        <input
                            type="text"
                            name="sparkpost_api_key"
                            placeholder="<?php esc_html_e( 'Sparkpost API Key', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['sparkpost_api_key'])){echo $settings['sparkpost_api_key'];} ?>"
                            id="sparkpost_api_key"
                            class="auto-mail-form-control"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="auto-mail-box-settings-row">
            <div class="auto-mail-box-settings-col-1">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'Sending Frequency', Auto_Mail::DOMAIN ); ?></span>
                <span class="auto-mail-description"><?php esc_html_e( "You may break the terms of your web host or provider by sending more than the recommended emails per day. Contact your host if you want to send more.", Auto_Mail::DOMAIN ); ?></span>
            </div>
            <div class="auto-mail-box-settings-col-2">
                <input
                    type="text"
                    name="sending_limit"
                    placeholder="<?php esc_html_e( 'Emails', Auto_Mail::DOMAIN ); ?>"
                    value="<?php echo $sending_limit; ?>"
                    id="auto_mail_sending_limit"
                    class="auto-mail-form-control"
                />
                <span class="dropdown-el auto-mail-region-selector">
                    <?php foreach ( $frequency as $key => $value ) : ?>
                        <input type="radio" name="sending_frequency" value="<?php echo esc_attr( $key ); ?>" <?php if($key == $sending_frequency){echo 'checked="checked"';} ?> id="<?php echo esc_attr( $key ); ?>">
                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></label>
                    <?php endforeach; ?>
                </span>
            </div>
        </div>
   </div>


</div>