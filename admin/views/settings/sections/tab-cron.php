<?php
if(!isset($settings['cron_type'])){
    $settings['cron_type'] = 'wp_cron';
}
?>
<div id="cron" class="auto-mail-box-tab" data-nav="cron" >

	<div class="auto-mail-box-header">
		<h2 class="auto-mail-box-title"><?php esc_html_e( 'Cron', Auto_Mail::DOMAIN ); ?></h2>
	</div>

    <div class="auto-mail-box-body">
        <div class="auto-mail-box-settings-row">
            <div class="auto-mail-box-settings-col-1">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'Newsletter task scheduler (cron)', Auto_Mail::DOMAIN ); ?></span>
                <span class="auto-mail-description"><?php esc_html_e( "Select what will activate your newsletter queue.", Auto_Mail::DOMAIN ); ?></span>
            </div>
            <div class="auto-mail-box-settings-col-2">
                <div class="sui-side-tabs">
                    <div class="sui-tabs-menu">
                        <div class="sui-tab-item <?php echo ( $settings['cron_type'] == 'wp_cron' ? 'active' : '' ); ?>" data-nav="wp_cron"><?php esc_html_e( 'Visitors to your website (recommended)', Auto_Mail::DOMAIN ); ?></div>
                        <div class="sui-tab-item <?php echo ( $settings['cron_type'] == 'linux_cron' ? 'active' : '' ); ?>" data-nav="linux_cron"><?php esc_html_e( 'Server side cron (Linux cron)', Auto_Mail::DOMAIN ); ?></div>
                    </div>
                </div>
                <div class="sui-tabs-content">
                    <div class="sui-tab-content auto-mail-box-settings-inputs <?php echo ( $settings['cron_type'] == 'wp_cron' ? 'active' : '' ); ?>" id="wp_cron">

                    </div>
                    <div class="sui-tab-content <?php echo ( $settings['cron_type'] == 'linux_cron' ? 'active' : '' ); ?>" id="linux_cron">
                        <p><?php esc_html_e( 'To use this option please add this command to your crontab', Auto_Mail::DOMAIN ); ?></p>
                    </div>

                </div>
            </div>
        </div>
   </div>


</div>