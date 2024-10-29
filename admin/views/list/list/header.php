<h1 class="auto-mail-header-title"><?php esc_html_e( 'Lists', Auto_Mail::DOMAIN ); ?></h1>
<div class="auto-mail-actions-left">
    <a href="<?php echo admin_url( 'admin.php?page=auto-mail-list-wizard' ); ?>" class="auto-mail-list-builder">
        <button class="auto-mail-button auto-mail-button-blue auto-mail-button-blue-first">
            <?php esc_html_e( 'Create', Auto_Mail::DOMAIN ); ?>
        </button>
    </a>
    <a href="https://wpautomail.com/pricing/" target="_blank">
    	<button class="auto-mail-button auto-mail-button-blue">
            <?php esc_html_e( 'Get Pro Version', Auto_Mail::DOMAIN ); ?>
        </button>
    </a>
</div>
<div class="auto-mail-actions-right">
	<a href="https://wpautomail.com/document/" target="_blank" class="auto-mail-button auto-mail-button-ghost">
		<ion-icon class="auto-mail-icon-document" name="document-text-sharp"></ion-icon>
		<?php esc_html_e( 'View Documentation', Auto_Mail::DOMAIN ); ?>
	</a>
</div>