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
$triggers = Auto_Mail_Admin_Triggers::get_list();
?>
<div id="auto-mail-welcome-wrap">
    <form id="am-generate-automation-form" method="post" name="am-generate-automation-form" action="">
        <section class="cd-slider-wrapper cd-generator-slider-wrapper">
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

                <li class="auto-mail-slide am-slide-automation-name">
                    <div>
                        <h2><?php _e('Automation Name', Auto_Mail::DOMAIN); ?></h2>
                        <p><?php _e("Name your new automation, then let's start auto mail marketing!", Auto_Mail::DOMAIN); ?></p>
                        <input
                            type="text"
                            name="am_automation_name"
                            placeholder="<?php esc_html_e( 'Enter your automation name here', Auto_Mail::DOMAIN ); ?>"
                            value=""
                            class="am_automation_name"
                            aria-labelledby="am_automation_name"
                        />
                        <span class="auto-mail-error-message-name" style="display: none;"><?php _e("Automation name cannot be empty.", Auto_Mail::DOMAIN); ?></span>
                    </div>
                </li>

                <li class="auto-mail-slide am-slide-action-email">
                    <div class="auto-mail-delivery-title">
                        <h2><?php _e('Email Setup', Auto_Mail::DOMAIN); ?></h2>
                        <p><?php _e("Your email settings after the trigger event.", Auto_Mail::DOMAIN); ?></p>
                    </div>

                    <div class="auto-mail-box-body auto-mail-box-actions auto-mail-email-content">
                    <div class="auto-mail-form-field-sender auto-mail-form-field-row">
                    <h4 class="auto-mail-h4 am-email-title"><label><?php echo esc_html( 'Subject', Auto_Mail::DOMAIN ); ?></label></h4>
                    <div class="auto-mail-form-field">
                    <div class="regular-text auto-mail-form-input">
                    <input
                        type="text"
                        name="woo_automation_email_subject"
                        id="woo_automation_email_subject"
                        value="<?php if(isset($settings['woo_automation_email_subject'])){echo $settings['woo_automation_email_subject'];}else{esc_attr_e( 'admin', Auto_Mail::DOMAIN );} ?>"
                    />
                    </div>
                    </div>
                    <h4 class="auto-mail-h4 am-email-title"><label><?php echo esc_html( 'Email Content', Auto_Mail::DOMAIN ); ?></label></h4>
                    <div class="auto-mail-form-field">
                    <?php
                    $value = isset($settings['pretty_message']) ? $settings['pretty_message'] : '<p>Here is the automation email content for your customers.</p>';
                    wp_editor( $value, 'pretty_message', array(
                        'textarea_name' => 'pretty_message',
                        'wpautop' => false,
                        'teeny' => true,
                        'tinymce' => true
                    ));
                    ?>
                    </div>
                    </div>
                    </div>
                </li>

                <li class="auto-mail-slide am-slider-delay">
                    <div class="auto-mail-delay-settings">
                        <h2><?php _e('Delay', Auto_Mail::DOMAIN); ?></h2>
                        <p><?php _e("Wait for a specified number of hours, days, or week before continuing.", Auto_Mail::DOMAIN); ?></p>
                        <div class="range-slider">
                            <input class="range-slider__range" type="range" value="<?php if(isset($settings['update_frequency'])){echo $settings['update_frequency'];}else{echo esc_html('100');}?>" min="0" max="500">
                            <span class="range-slider__value">0</span>
                        </div>

                        <div class="select-container">
                            <span class="dropdown-handle" aria-hidden="true">
                                <ion-icon name="chevron-down" class="robot-icon-down"></ion-icon>
                            </span>

                        <div class="select-list-container">
                            <button type="button" class="list-value" id="robot-field-unit-button" value="Minutes">
                                <?php
                                    if(isset($settings['update_frequency_unit'])){
                                        echo $settings['update_frequency_unit'];
                                    }else{
                                        esc_html_e( 'Minutes', Auto_Mail::DOMAIN );
                                }
                                ?>
                            </button>
                            <ul tabindex="-1" role="listbox" class="list-results robot-sidenav-hide-md" >
                                <li><?php esc_html_e( 'Minutes', Auto_Mail::DOMAIN ); ?></li>
                                <li><?php esc_html_e( 'Hours', Auto_Mail::DOMAIN ); ?></li>
                                <li><?php esc_html_e( 'Days', Auto_Mail::DOMAIN ); ?></li>
                            </ul>
                        </div>
                        </div>
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
                        <p><a href="<?php echo admin_url('admin.php?page=auto-mail-automations') ?>" class="am-welcome-link-button"><?php _e('Go to your automations', Auto_Mail::DOMAIN); ?></a></p>
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