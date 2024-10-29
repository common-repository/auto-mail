<div class="sui-row">
    <div class="sui-col-lg-6">
        <div class="sui-box">
            <div class="sui-box-header">
                <h3 class="sui-box-title"><?php esc_html_e( 'Upgrade to Auto Mail Pro', Auto_Mail::DOMAIN ); ?></h3>
            </div><!-- end sui-box-title -->

            <div class="sui-box-body">
                <p>
                    <?php
						$integration_url = '<a target="_blank" href="'.esc_url('https://wpautomail.com/pricing').'">upgrade to Auto Mail Premium</a>';
              			printf(
                  			esc_html__( 'Get Auto Mail Pro, our full lineup of WordPress marketing tools and more for free when you %1$s which include below features & more..', Auto_Mail::DOMAIN ),
                  			$integration_url
              			);
              		?>
                </p>
                <ul class="auto-mail-features-list">
			        <li><ion-icon name="checkmark-circle-outline" class="auto-mail-icon-check"></ion-icon><?php esc_html_e( 'Unlimited Pop-ups, Optin Forms, and Newsletter Emails', Auto_Mail::DOMAIN  ); ?></li>
			        <li><ion-icon name="checkmark-circle-outline" class="auto-mail-icon-check"></ion-icon><?php esc_html_e( 'Integrates with many reliable and popular email marketing providers, CRMs', Auto_Mail::DOMAIN  ); ?></li>
                    <li><ion-icon name="checkmark-circle-outline" class="auto-mail-icon-check"></ion-icon><?php esc_html_e( 'Addons for Mailchimp, Mailerlite, MailPoet, ActiveCampaign, Sendinblue', Auto_Mail::DOMAIN  ); ?></li>
                    <li><ion-icon name="checkmark-circle-outline" class="auto-mail-icon-check"></ion-icon><?php esc_html_e( 'Full marketing suite including WordPress solutions', Auto_Mail::DOMAIN  ); ?></li>
                    <li><ion-icon name="checkmark-circle-outline" class="auto-mail-icon-check"></ion-icon><?php esc_html_e( 'Grow your business, drive more traffic, and convert more high-quality leads', Auto_Mail::DOMAIN  ); ?></li>
                    <li><ion-icon name="checkmark-circle-outline" class="auto-mail-icon-check"></ion-icon><?php esc_html_e( 'Send emails with Web Host, SMTP, SendGrid', Auto_Mail::DOMAIN  ); ?></li>
                    <li><ion-icon name="checkmark-circle-outline" class="auto-mail-icon-check"></ion-icon><?php esc_html_e( '24/7 live WordPress support', Auto_Mail::DOMAIN  ); ?></li>
		        </ul>
                <a href="<?php echo esc_url('https://wpautomail.com/pricing') ?>" target="_blank">
                    <button class="auto-mail-button auto-mail-button-purple"><?php esc_html_e( 'Get Auto Mail Premium →', Auto_Mail::DOMAIN ); ?></button>
                </a>
            </div><!-- end box_content_class -->
        </div>
    </div>
    <div class="sui-col-lg-6">
        <div class="sui-box">
            <div class="sui-box-header">
                <h3 class="sui-box-title"><?php esc_html_e( 'Newsletters', Auto_Mail::DOMAIN ); ?></h3>
            </div><!-- end sui-box-title -->

            <div class="sui-box-body">
                <p><?php esc_html_e("Easy-to-use drag and drop composer to build responsive newsletters. Build and send newsletters with WordPress.", Auto_Mail::DOMAIN ); ?></p>
                <a href="<?php echo admin_url( 'admin.php?page=auto-mail-campaigns' ); ?>">
                    <button class="auto-mail-button auto-mail-button-blue"><?php esc_html_e( 'Manage Newsletters', Auto_Mail::DOMAIN ); ?></button>
                </a>
            </div><!-- end box_content_class -->
        </div>
    </div>
</div>

<div class="sui-row">
    <div class="sui-col-lg-6">
        <div class="sui-box">
            <div class="sui-box-header">
                <h3 class="sui-box-title"><?php esc_html_e( 'Forms', Auto_Mail::DOMAIN ); ?></h3>
            </div><!-- end sui-box-title -->

            <div class="sui-box-body">
                <p><?php esc_html_e("Create and add a newsletter subscription form to your website. Use forms with your funnel builder and automate your form submission.", Auto_Mail::DOMAIN ); ?></p>
                <a href="<?php echo admin_url( 'admin.php?page=auto-mail-forms' ); ?>">
                    <button class="auto-mail-button auto-mail-button-blue"><?php esc_html_e( 'Edit Forms', Auto_Mail::DOMAIN ); ?></button>
                </a>
            </div><!-- end box_content_class -->
        </div>
    </div>
    <div class="sui-col-lg-6">
        <div class="sui-box">
            <div class="sui-box-header">
                <h3 class="sui-box-title"><?php esc_html_e( 'Lists', Auto_Mail::DOMAIN ); ?></h3>
            </div><!-- end sui-box-title -->

            <div class="sui-box-body">
                <p><?php esc_html_e("Manage your subscribers and subscriber lists in WordPress. Manage your customer relationships, build your email lists.", Auto_Mail::DOMAIN ); ?></p>
                <a href="<?php echo admin_url( 'admin.php?page=auto-mail-lists' ); ?>">
                    <button class="auto-mail-button auto-mail-button-blue"><?php esc_html_e( 'Manage Lists', Auto_Mail::DOMAIN ); ?></button>
                </a>
            </div><!-- end box_content_class -->
        </div>
    </div>
</div>

<div class="sui-row">
    <div class="sui-col-lg-6">
        <div class="sui-box">
            <div class="sui-box-header">
                <h3 class="sui-box-title"><?php esc_html_e( 'Subscribers', Auto_Mail::DOMAIN ); ?></h3>
            </div><!-- end sui-box-title -->

            <div class="sui-box-body">
                <p><?php esc_html_e("Manage your customer relationships, build your email lists. Manage your subscribers and subscriber lists in WordPress.", Auto_Mail::DOMAIN ); ?></p>
                <a href="<?php echo admin_url( 'admin.php?page=auto-mail-subscribers' ); ?>">
                    <button class="auto-mail-button auto-mail-button-blue"><?php esc_html_e( 'Manage Subscribers', Auto_Mail::DOMAIN ); ?></button>
                </a>
            </div><!-- end box_content_class -->
        </div>
    </div>
    <div class="sui-col-lg-6">
        <div class="sui-box">
            <div class="sui-box-header">
                <h3 class="sui-box-title"><?php esc_html_e( 'Setup Guide', Auto_Mail::DOMAIN ); ?></h3>
            </div><!-- end sui-box-title -->

            <div class="sui-box-body">
                <p><?php esc_html_e("In this short tutorial we will guide you through some of the basic settings to get the most out of our plugin.", Auto_Mail::DOMAIN ); ?></p>
                <a href="<?php echo admin_url( 'admin.php?page=auto-mail-setup' ); ?>">
                    <button class="auto-mail-button auto-mail-button-blue"><?php esc_html_e( 'Basic Settings', Auto_Mail::DOMAIN ); ?></button>
                </a>
            </div><!-- end box_content_class -->
        </div>
    </div>
</div>