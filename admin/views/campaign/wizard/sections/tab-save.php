<?php
$status = isset( $settings['status'] ) ? sanitize_text_field( $settings['status'] ) : 'draft';
?>
<div id="auto-mail-builder-status" class="auto-mail-box auto-mail-box-sticky">
    <div class="auto-mail-box-status">
        <div class="auto-mail-status">
            <button id="auto-mail-back-design" class="auto-mail-button auto-mail-switch-sections" type="button">
                <span class="auto-mail-loading-text">
                    <ion-icon name="reload-circle"></ion-icon>
                    <span class="button-text automation-save-text">
                        <?php echo esc_html( 'Back to Design', Auto_Mail::DOMAIN ); ?>
                    </span>
                </span>
            </button>
        </div>
        <div class="auto-mail-actions">
            <button class="auto-mail-process-campaign auto-mail-button" type="button" data-action="save">
                <span class="auto-mail-loading-text">
                    <ion-icon name="reload-circle"></ion-icon>
                    <span class="button-text automation-save-text">
                        <?php echo esc_html( 'save as draft', Auto_Mail::DOMAIN ); ?>
                    </span>
                </span>
            </button>
            <button class="auto-mail-process-campaign auto-mail-button auto-mail-button-blue" type="button" data-action="send">
                <span class="auto-mail-loading-text">
                    <ion-icon name="save"></ion-icon>
                    <span class="button-text automation-publish-text">
                        <?php echo esc_html( 'send', Auto_Mail::DOMAIN ); ?>
                    </span>
                </span>
            </button>
        </div>
    </div>
</div>
