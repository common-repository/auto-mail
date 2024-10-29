<?php if ( isset( $_GET['id'] ) ) : ?>
    <div class="fsp-container">
    <div class="fsp-header">
        <div class="fsp-nav auto-mail-setps-tab">
            <a class="fsp-nav-link auto-mail-step setup current" data-nav="setup">
                <div class="auto-mail-step-badge">
                    <?php esc_html_e( '1', Auto_Mail::DOMAIN ); ?>
                </div>
                <div class="auto-mail-step-title">
                    <?php esc_html_e( 'Setup', Auto_Mail::DOMAIN ); ?>
                </div>
            </a>
            <a class="fsp-nav-link auto-mail-step design" data-nav="design">
                <div class="auto-mail-step-badge">
                    <?php esc_html_e( '2', Auto_Mail::DOMAIN ); ?>
                </div>
                <div class="auto-mail-step-title">
                    <?php esc_html_e( 'Design', Auto_Mail::DOMAIN ); ?>
                </div>
            </a>
            <a class="fsp-nav-link auto-mail-step send" data-nav="send">
                <div class="auto-mail-step-badge">
                    <?php esc_html_e( '3', Auto_Mail::DOMAIN ); ?>
                </div>
                <div class="auto-mail-step-title">
                    <?php esc_html_e( 'Send', Auto_Mail::DOMAIN ); ?>
                </div>
            </a>
        </div>
    </div>
</div>
<?php else: ?>
    <div class="fsp-container">
    <div class="fsp-header">
        <div class="fsp-nav auto-mail-setps-tab">
            <a class="fsp-nav-link auto-mail-step setup current" data-nav="setup">
                <div class="auto-mail-step-badge">
                    <?php esc_html_e( '1', Auto_Mail::DOMAIN ); ?>
                </div>
                <div class="auto-mail-step-title">
                    <?php esc_html_e( 'Setup', Auto_Mail::DOMAIN ); ?>
                </div>
            </a>
            <a class="fsp-nav-link auto-mail-step template" data-nav="template">
                <div class="auto-mail-step-badge">
                    <?php esc_html_e( '2', Auto_Mail::DOMAIN ); ?>
                </div>
                <div class="auto-mail-step-title">
                    <?php esc_html_e( 'Template', Auto_Mail::DOMAIN ); ?>
                </div>
            </a>
            <a class="fsp-nav-link auto-mail-step design" data-nav="design">
                <div class="auto-mail-step-badge">
                    <?php esc_html_e( '3', Auto_Mail::DOMAIN ); ?>
                </div>
                <div class="auto-mail-step-title">
                    <?php esc_html_e( 'Design', Auto_Mail::DOMAIN ); ?>
                </div>
            </a>
            <a class="fsp-nav-link auto-mail-step send" data-nav="send">
                <div class="auto-mail-step-badge">
                    <?php esc_html_e( '4', Auto_Mail::DOMAIN ); ?>
                </div>
                <div class="auto-mail-step-title">
                    <?php esc_html_e( 'Send', Auto_Mail::DOMAIN ); ?>
                </div>
            </a>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="clear"></div>