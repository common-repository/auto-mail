<?php
    $count = $this->countModules();
    if($count >= 1){
        $href_link = '#test-popup';
        $create_class = 'open-popup-pro auto-mail-button auto-mail-button-blue';
    }else{
        $href_link = admin_url( 'admin.php?page=auto-mail-generator' );
        $create_class = 'auto-mail-button auto-mail-button-blue';
    }
 ?>
<h1 class="auto-mail-header-title"><?php esc_html_e( 'Automations', Auto_Mail::DOMAIN ); ?></h1>
<div class="auto-mail-actions-left">
    <a href="<?php echo $href_link; ?>" class="<?php echo $create_class; ?>" data-effect="mfp-zoom-in">
        <?php esc_html_e( 'Create', Auto_Mail::DOMAIN ); ?>
    </a>
</div>
<div class="auto-mail-actions-right">
		<a href="https://wpautomail.com/document/" target="_blank" class="auto-mail-button auto-mail-button-ghost">
			<ion-icon class="auto-mail-icon-document" name="document-text-sharp"></ion-icon>
			<?php esc_html_e( 'View Documentation', Auto_Mail::DOMAIN ); ?>
		</a>
</div>

<div id="test-popup" class="white-popup mfp-with-anim mfp-hide">

		<div class="auto-mail-box-header auto-mail-block-content-center">
			<h3 class="auto-mail-box-title type-title"><?php esc_html_e( 'Upgrade to Pro', Auto_Mail::DOMAIN ); ?></h3>
		</div>

        <div class="auto-mail-box-body auto-mail-pro-popup-body">
            <div class="robot-getting-started__content">
                <div class="features-list-body">
                    <table id="pricing-table" class="mb0">
                        <tbody>
                        <tr>
                            <td><?php esc_html_e( 'Live-capture the cart as soon as the user enters the email', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Abandoned cart recovery emails', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Easy-to-use Drag and drop composer to build responsive newsletters', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Build and send newsletters with WordPress', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Create and add a newsletter subscription form to your website', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Use forms with your funnel builder and automate your form submission', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Manage your customer relationships, build your email lists', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Send emails from 3rd services provider like Amazon SES, SendGrid or any SMTP services provider', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Pre-built and customizable email and subscription form templates', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Unlimited Pop-ups, Optin Forms, and Newsletter Emails', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Integrates with many reliable and popular email marketing providers, CRMs', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Addons for Mailchimp, Mailerlite, MailPoet, ActiveCampaign, Sendinblue', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Full marketing suite including WordPress solutions', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Grow your business, drive more traffic, and convert more high-quality leads', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( '24/7 live WordPress support', Auto_Mail::DOMAIN ); ?></td>
                            <td><i class="dashicons dashicons-yes green" title="Feature is available"></i></td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="auto-mail-box-footer auto-mail-box-footer-center auto-mail-pro-popup-footer">

          <a href="<?php echo esc_url( 'https://wpautomail.com/pricing', Auto_Mail::DOMAIN ); ?>" target="_blank" class="auto-mail-button auto-mail-button-blue">
                    <?php esc_html_e( 'Try pro version today', Auto_Mail::DOMAIN ); ?>
                </a>
        </div>

		<img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/auto-mail.png'); ?>" class="auto-mail-image auto-mail-image-center" aria-hidden="true" alt="<?php esc_attr_e( 'Auto Robot', Auto_Mail::DOMAIN ); ?>">
</div>