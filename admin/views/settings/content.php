<?php
$settings = get_option('auto_mail_global_settings');
?>
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
                <a href="#" data-nav="privacy"><?php esc_html_e( 'Privacy', Auto_Mail::DOMAIN ); ?></a>
            </li>

            <li class="auto-mail-vertical-tab">
                <a href="#" data-nav="delivery"><?php esc_html_e( 'Delivery', Auto_Mail::DOMAIN ); ?></a>
            </li>

            <li class="auto-mail-vertical-tab">
                <a href="#" data-nav="cron"><?php esc_html_e( 'Cron', Auto_Mail::DOMAIN ); ?></a>
            </li>

            <li class="auto-mail-vertical-tab">
                <a href="#" data-nav="company"><?php esc_html_e( 'Company', Auto_Mail::DOMAIN ); ?></a>
            </li>

            <li class="auto-mail-vertical-tab">
                <a href="#" data-nav="advanced"><?php esc_html_e( 'Advanced', Auto_Mail::DOMAIN ); ?></a>
            </li>

        </ul>

    </div>

    <form class="auto-mail-settings-form" method="post" name="auto-mail-settings-form" action="">
        <div class="auto-mail-box-tabs">
            <?php $this->template( 'settings/sections/tab-general',  $settings); ?>
            <?php $this->template( 'settings/sections/tab-privacy', $settings); ?>
            <?php $this->template( 'settings/sections/tab-delivery', $settings); ?>
            <?php $this->template( 'settings/sections/tab-cron', $settings); ?>
            <?php $this->template( 'settings/sections/tab-company', $settings); ?>
            <?php $this->template( 'settings/sections/tab-advanced', $settings); ?>
        </div>
    </form>
</div>