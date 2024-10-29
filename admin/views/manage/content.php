<?php
$action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';
?>
<div class="auto-mail-row-with-sidenav">

    <div class="auto-mail-sidenav">
        <div class="auto-mail-mobile-select">
            <span class="auto-mail-select-content"><?php esc_html_e( 'Global Settings', Auto_Mail::DOMAIN ); ?></span>
            <ion-icon name="chevron-down" class="auto-mail-icon-down"></ion-icon>
        </div>

        <ul class="auto-mail-vertical-tabs auto-mail-sidenav-hide-md">

            <li class="auto-mail-vertical-tab <?php echo auto_mail_current_action('import', $action); ?>">
                <a href="#" data-nav="import"><?php esc_html_e( 'Import', Auto_Mail::DOMAIN ); ?></a>
            </li>

            <li class="auto-mail-vertical-tab <?php echo auto_mail_current_action('export', $action); ?>">
                <a href="#" data-nav="export"><?php esc_html_e( 'Export', Auto_Mail::DOMAIN ); ?></a>
            </li>

        </ul>

    </div>

    <div class="auto-mail-box-tabs">
         <?php $this->template( 'manage/sections/tab-import'); ?>
         <?php $this->template( 'manage/sections/tab-export'); ?>
    </div>
</div>