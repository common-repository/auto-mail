<h1 class="auto-mail-header-title"><?php esc_html_e( 'Subscribers', Auto_Mail::DOMAIN ); ?></h1>
<div class="auto-mail-actions-left">
    <a href="#" class="auto-mail-subscriber-builder">
        <button class="popup-trigger auto-mail-button auto-mail-button-blue">
            <?php esc_html_e( 'Add New', Auto_Mail::DOMAIN ); ?>
        </button>
    </a>
    <a href="<?php echo admin_url( 'admin.php?page=auto-mail-manage' ); ?>" class="auto-mail-subscriber-import">
        <button class="auto-mail-button">
            <?php esc_html_e( 'Import', Auto_Mail::DOMAIN ); ?>
        </button>
    </a>

    <a href="<?php echo admin_url( 'admin.php?page=auto-mail-manage&action=export' ); ?>" class="auto-mail-subscriber-export">
        <button class="auto-mail-button">
            <?php esc_html_e( 'Export', Auto_Mail::DOMAIN ); ?>
        </button>
    </a>
</div>
<div class="auto-mail-actions-right">
		<a href="https://wpautomail.com/document/" target="_blank" class="auto-mail-button auto-mail-button-ghost">
			<ion-icon class="auto-mail-icon-document" name="document-text-sharp"></ion-icon>
			<?php esc_html_e( 'View Documentation', Auto_Mail::DOMAIN ); ?>
		</a>
</div>