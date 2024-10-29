<?php
$settings = get_option('auto_mail_global_settings');
$aws_region = isset($settings['aws_region']) ? $settings['aws_region']  : 'us-east-1';
$regions = array(
    "us-east-1" => "US East (N. Virginia)",
    "us-east-2" => "US East (Ohio)",
    "us-west-1" => "US West (N. California)",
    "us-west-2" => "US West (Oregon)",
    "eu-west-1" => "EU (Ireland)",
    "eu-west-2" => "EU (London)",
    "eu-central-1" => "EU (Frankfurt)",
    "eu-west-3" => "EU (Paris)",
    "eu-north-1" => "EU (Stockholm)",
    "ca-central-1" => "Canada (Central)",
    "ap-south-1" => "Asia Pacific (Mumbai)",
    "ap-northeast-2" => "Asia Pacific (Seoul)",
    "ap-southeast-1" => "Asia Pacific (Singapore)",
    "ap-southeast-2" => "Asia Pacific (Sydney)",
    "ap-northeast-1" => "Asia Pacific (Tokyo)",
    "sa-east-1" => "South America (Sao Paulo)",
    "us-gov-west-1" => "AWS GovCloud (US)",
);
$sending_frequency = isset($settings['sending_frequency']) ? $settings['sending_frequency']  : "5";
$frequency = array(
    "1" => "Every mimute",
    "2" => "Every 2 mimutes",
    "5" => "Every 5 mimutes(recommended)",
    "10" => "Every 10 mimutes",
    "15" => "Every 15 mimutes",
    "30" => "Every 30 mimutes"
);
$sending_limit = isset($settings['sending_limit']) ? $settings['sending_limit']  : "25";
?>
<div id="auto-mail-welcome-wrap">
    <form id="auto-mail-setup-form" method="post" name="auto-mail-setup-form" action="">
        <section class="cd-slider-wrapper cd-setup-slider-wrapper">
            <ul class="cd-slider">
                <li class="auto-mail-slide visible auto-mail-first-slide">
                    <div>
                        <img class="auto-mail-logo-big" src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/auto-mail.png'); ?>">
                        <p>
                        <?php
                            printf(
                                esc_html__( 'Thank you for choosing Auto Mail %1$s, the best mail management system for Wordpress! - %2$s', Auto_Mail::DOMAIN ),
                                AUTO_MAIL_VERSION,
				                '<a href="https://wpautomail.com/pricing/" class="auto-mail-welcome-homepage" target="_blank">Visit Plugin Homepage</a>'
                            );
                        ?>
                        </p>
                        <p>
                        <?php _e('In this short tutorial we will guide you through some of the basic settings to get the most out of our plugin. ', Auto_Mail::DOMAIN); ?>
                        </p>
                    </div>

                </li>

                <li class="auto-mail-slide auto-mail-slide-sender">
                    <div>
                        <h2><?php _e('Default Sender', Auto_Mail::DOMAIN); ?></h2>
                        <p><?php _e("Choose which name and email address you'd like to appear as the sender of your newsletters.", Auto_Mail::DOMAIN); ?></p>
                        <input
                            type="text"
                            name="from_name"
                            placeholder="<?php esc_html_e( 'From Name', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['from_name'])){echo $settings['from_name'];} ?>"
                            class="from_name"
                            aria-labelledby="from_name"
                        />
                        <input
                            type="text"
                            name="from_address"
                            placeholder="<?php esc_html_e( 'From Address', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['from_address'])){echo $settings['from_address'];} ?>"
                            class="from_address"
                            aria-labelledby="from_address"
                        />
                    </div>
                </li>

                <li class="auto-mail-slide auto-mail-send-frequency">
                    <div>
                        <h2><?php _e('Sending Frequency', Auto_Mail::DOMAIN); ?></h2>
                        <p><?php _e("You may break the terms of your web host or provider by sending more than the recommended emails per day. Contact your host if you want to send more.", Auto_Mail::DOMAIN); ?></p>
                        <div class="auto-mail-delivery-content">
                            <div class="delivery-option">
                                <input
                                    type="text"
                                    name="sending_limit"
                                    placeholder="<?php esc_html_e( 'Emails', Auto_Mail::DOMAIN ); ?>"
                                    value="<?php echo $sending_limit; ?>"
                                    class="auto-mail-form-control"
                                    aria-labelledby="sending_limit"
                                />
                            </div>
                            <div class="delivery-option">
                                <span class="dropdown-el auto-mail-region-selector">
                                    <?php foreach ( $frequency as $key => $value ) : ?>
                                        <input type="radio" name="sending_frequency" value="<?php echo esc_attr( $key ); ?>" <?php if($key == $sending_frequency){echo 'checked="checked"';} ?> id="<?php echo esc_attr( $key ); ?>">
                                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></label>
                                    <?php endforeach; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="auto-mail-slide auto-mail-slide-delivery-type">
                    <div class="auto-mail-delivery-title">
                        <h2><?php _e('Delivery', Auto_Mail::DOMAIN); ?></h2>
                        <p><?php _e("Choose how to send your campaigns. It's recommend to go with a dedicate ESP to prevent rejections and server blocking", Auto_Mail::DOMAIN); ?></p>
                    </div>

                    <div class="auto-mail-delivery-content">
                    <div class="sui-side-tabs">
                    <div class="sui-tabs-menu">
                        <div class="sui-tab-item delivery-method <?php if(isset($settings['delivery_method']) && $settings['delivery_method'] == 'php'){echo 'active';}else if(!isset($settings['delivery_method'])){echo 'active';}?>" data-nav="php">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/php.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'PHP', Auto_Mail::DOMAIN ); ?>">
                        </div>
                        <div class="sui-tab-item delivery-method <?php if(isset($settings['delivery_method']) && $settings['delivery_method'] == 'smtp'){echo 'active';} ?>" data-nav="smtp">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/email.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'SMTP', Auto_Mail::DOMAIN ); ?>">
                        </div>
                        <div class="sui-tab-item delivery-method <?php if(isset($settings['delivery_method']) && $settings['delivery_method'] == 'sendgrid'){echo 'active';}?>" data-nav="sendgrid">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/sendgrid.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'SendGrid', Auto_Mail::DOMAIN ); ?>">
                        </div>
                        <div class="sui-tab-item delivery-method <?php if(isset($settings['delivery_method']) && $settings['delivery_method'] == 'aws'){echo 'active';}?>" data-nav="amazon">
                            <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/providers/aws.png'); ?>" class="auto-mail-providers-image" aria-hidden="true" alt="<?php esc_attr_e( 'Amazon', Auto_Mail::DOMAIN ); ?>">
                        </div>
                    </div>
                </div>
                <div class="sui-tabs-content">
                    <div class="sui-tab-content <?php if(isset($settings['delivery_method']) && $settings['delivery_method'] == 'php'){echo 'active';}?>" id="php">
                    <span><?php esc_attr_e( "You currently have the Default (none) mailer selected, which won't improve email deliverability. Please select any other email provider
            and use the easy setup wizard to configure it.", Auto_Mail::DOMAIN ); ?>
                        </span>
                    </div>
                    <div class="sui-tab-content auto-mail-box-settings-inputs  <?php if(isset($settings['delivery_method']) && $settings['delivery_method'] == 'smtp'){echo 'active';}else if(!isset($settings['delivery_method'])){echo 'active';} ?>" id="smtp">
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
                            name="smtp_port"
                            placeholder="<?php esc_html_e( 'Port', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['smtp_port'])){echo $settings['smtp_port'];} ?>"
                            id="smtp_port"
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
                    <div class="sui-tab-content <?php if(isset($settings['delivery_method']) && $settings['delivery_method'] == 'sendgrid'){echo 'active';}?>" id="sendgrid">
                        <input
                            type="text"
                            name="sendgrid_api_key"
                            placeholder="<?php esc_html_e( 'SendGrid API Key', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['sendgrid_api_key'])){echo $settings['sendgrid_api_key'];} ?>"
                            id="sendgrid_api_key"
                            class="auto-mail-form-control"
                        />
                    </div>
                    <div class="sui-tab-content auto-mail-box-settings-inputs <?php if(isset($settings['delivery_method']) && $settings['delivery_method'] == 'amazon'){echo 'active';}?>" id="amazon">
                        <span class="dropdown-el auto-mail-region-selector">
                            <?php foreach ( $regions as $key => $value ) : ?>
                                <input type="radio" name="aws_region" value="<?php echo esc_attr( $key ); ?>" <?php if($key == $aws_region){echo 'checked="checked"';} ?> id="<?php echo esc_attr( $key ); ?>">
                                <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></label>
                            <?php endforeach; ?>
                        </span>
                        <input
                            type="text"
                            name="amazon_access_key"
                            placeholder="<?php esc_html_e( 'Access Key', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['amazon_access_key'])){echo $settings['amazon_access_key'];} ?>"
                            id="amazon_access_key"
                            class="auto-mail-form-control"
                        />
                        <input
                            type="text"
                            name="amazon_secret_key"
                            placeholder="<?php esc_html_e( 'Secret Key', Auto_Mail::DOMAIN ); ?>"
                            value="<?php if(isset($settings['amazon_secret_key'])){echo $settings['amazon_secret_key'];} ?>"
                            id="amazon_secret_key"
                            class="auto-mail-form-control"
                        />
                    </div>

                </div>
                    </div>
                </li>

                <li class="auto-mail-slide auto-mail-test-mail">
                    <div>
                    <h2><?php _e('Send Test Email', Auto_Mail::DOMAIN); ?></h2>
                        <p><?php _e("Check if your website can send emails correctly.", Auto_Mail::DOMAIN); ?></p>
                        <div class="delivery-option delivery-test-email">
                                        <input
                                            type="text"
                                            name="test_email_receiver"
                                            placeholder="<?php esc_html_e( 'Test Email Receiver', Auto_Mail::DOMAIN ); ?>"
                                            value=""
                                            class="test_email_receiver"
                                            aria-labelledby="test_email_receiver"
                                        />
                                </div>
                                <div class="delivery-option">
                                        <button class="auto-mail-test-button auto-mail-button auto-mail-button-blue">
                                            <?php esc_html_e( 'Send test email', Auto_Mail::DOMAIN ); ?>
                                        </button>
                        </div>
                    </div>
                </li>

                <li class="auto-mail-slide auto-mail-test-mail">
                    <div>
                    <h2><?php _e('Create Subscription Form Popup', Auto_Mail::DOMAIN); ?></h2>
                        <p><?php _e("Check if your website can send emails correctly.", Auto_Mail::DOMAIN); ?></p>
                    </div>
                </li>

                <li class="auto-mail-slide auto-mail-last-slide">
                    <div>
                        <svg style="margin-bottom: 25px;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 48 48" xml:space="preserve" width="64" height="64"><g class="nc-icon-wrapper"><path fill="#FFD764" d="M24,47C11.31738,47,1,36.68213,1,24S11.31738,1,24,1s23,10.31787,23,23S36.68262,47,24,47z"></path> <path fill="#444444" d="M17,19c-0.55273,0-1-0.44775-1-1c0-1.10303-0.89746-2-2-2s-2,0.89697-2,2c0,0.55225-0.44727,1-1,1 s-1-0.44775-1-1c0-2.20557,1.79395-4,4-4s4,1.79443,4,4C18,18.55225,17.55273,19,17,19z"></path> <path fill="#444444" d="M37,19c-0.55273,0-1-0.44775-1-1c0-1.10303-0.89746-2-2-2s-2,0.89697-2,2c0,0.55225-0.44727,1-1,1 s-1-0.44775-1-1c0-2.20557,1.79395-4,4-4s4,1.79443,4,4C38,18.55225,37.55273,19,37,19z"></path> <path fill="#FFFFFF" d="M35.6051,32C35.85382,31.03912,36,30.03748,36,29c0-0.55225-0.44727-1-1-1H13c-0.55273,0-1,0.44775-1,1 c0,1.03748,0.14618,2.03912,0.3949,3H35.6051z"></path> <path fill="#AE453E" d="M12.3949,32c1.33734,5.16699,6.02551,9,11.6051,9s10.26776-3.83301,11.6051-9H12.3949z"></path> <path fill="#FA645A" d="M18.01404,39.38495C19.77832,40.40594,21.81903,41,24,41s4.22168-0.59406,5.98596-1.61505 C28.75952,37.35876,26.54126,36,24,36S19.24048,37.35876,18.01404,39.38495z"></path></g></svg>
                        <h2><?php _e('Hooooray!', Auto_Mail::DOMAIN); ?></h2>
                        <p><?php _e('You\'re now ready to begin using Auto Mail!', Auto_Mail::DOMAIN); ?></p>
                        <div class="auto-mail-flex-grid-thirds">
                            <div class="auto-mail-col">
                                <p><?php _e('Take on bigger projects, earn more clients and grow your business.', Auto_Mail::DOMAIN); ?></p>
                                <a target="_blank" href="https://wpautomail.com/pricing/" class="auto-mail-promote-link-button"><?php _e('Buy Pro Version', Auto_Mail::DOMAIN); ?></a>
                            </div>
                            <div class="auto-mail-col">
                            <p><?php _e('WordPress Hosting - Fast and Secure Managed by Experts.', Auto_Mail::DOMAIN); ?></p>
                                <a target="_blank" href="https://www.siteground.com/go/digital" class="auto-mail-promote-link-button"><?php _e('WordPress Hosting', Auto_Mail::DOMAIN); ?></a>
                            </div>
                            <div class="auto-mail-col">
                            <p><?php _e('Reach for Auto Mail official documentation ith more features.', Auto_Mail::DOMAIN); ?></p>
                                <a target="_blank" href="https://wpautomail.com/document/" class="auto-mail-promote-link-button"><?php _e('Document', Auto_Mail::DOMAIN); ?></a>
                            </div>
                        </div>
                </li>
            </ul> <!-- .cd-slider -->

            <div class="cd-slider-navigation">
                <a class="auto-mail-welcome-prev" style="display: none" href="#"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" xml:space="preserve" width="16" height="16"><g class="nc-icon-wrapper" fill="#ffffff"><path fill="#ffffff" d="M17,23.414L6.293,12.707c-0.391-0.391-0.391-1.023,0-1.414L17,0.586L18.414,2l-10,10l10,10L17,23.414z"></path></g></svg><?php _e('Previous', Auto_Mail::DOMAIN); ?></a>
                <a class="auto-mail-welcome-next" href="#"><?php _e('Next', Auto_Mail::DOMAIN); ?><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" xml:space="preserve" width="16" height="16"><g class="nc-icon-wrapper" fill="#ffffff"><path fill="#ffffff" d="M7,23.414L5.586,22l10-10l-10-10L7,0.586l10.707,10.707c0.391,0.391,0.391,1.023,0,1.414L7,23.414z"></path></g></svg></a>
            </div>

            <div class="cd-svg-cover" data-step1="M1402,800h-2V0.6c0-0.3,0-0.3,0-0.6h2v294V800z" data-step2="M1400,800H383L770.7,0.6c0.2-0.3,0.5-0.6,0.9-0.6H1400v294V800z" data-step3="M1400,800H0V0.6C0,0.4,0,0.3,0,0h1400v294V800z" data-step4="M615,800H0V0.6C0,0.4,0,0.3,0,0h615L393,312L615,800z" data-step5="M0,800h-2V0.6C-2,0.4-2,0.3-2,0h2v312V800z" data-step6="M-2,800h2L0,0.6C0,0.3,0,0.3,0,0l-2,0v294V800z" data-step7="M0,800h1017L629.3,0.6c-0.2-0.3-0.5-0.6-0.9-0.6L0,0l0,294L0,800z" data-step8="M0,800h1400V0.6c0-0.2,0-0.3,0-0.6L0,0l0,294L0,800z" data-step9="M785,800h615V0.6c0-0.2,0-0.3,0-0.6L785,0l222,312L785,800z" data-step10="M1400,800h2V0.6c0-0.2,0-0.3,0-0.6l-2,0v312V800z">
                <svg height='100%' width="100%" preserveAspectRatio="none" viewBox="0 0 1400 800">
                <title><?php _e('SVG cover layer', Auto_Mail::DOMAIN); ?></title>
                <desc><?php _e('an animated layer to switch from one slide to the next one', Auto_Mail::DOMAIN); ?></desc>
                <path id="cd-changing-path" d="M1402,800h-2V0.6c0-0.3,0-0.3,0-0.6h2v294V800z"/>
                </svg>
            </div>  <!-- .cd-svg-cover -->
        </section> <!-- .cd-slider-wrapper -->
    </form>
</div>