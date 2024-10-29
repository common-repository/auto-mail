<?php
$status = isset( $settings['status'] ) ? sanitize_text_field( $settings['status'] ) : 'draft';
?>
<div id="auto-mail-builder-status" class="auto-mail-box auto-mail-box-sticky">
    <div class="auto-mail-box-status">
        <div class="auto-mail-status">
            <div class="auto-mail-status-module">
                <?php esc_html_e( 'Status', Auto_Mail::DOMAIN ); ?>
                    <?php
                    if( $status === 'draft'){
                        ?>
                    <span class="auto-mail-tag auto-mail-tag-draft">
                        <?php esc_html_e( 'draft', Auto_Mail::DOMAIN ); ?>
                    </span>
                    <?php
                    }else if($status === 'publish'){
                        ?>
                    <span class="auto-mail-tag auto-mail-tag-published">
                       <?php esc_html_e( 'published', Auto_Mail::DOMAIN ); ?>
                    </span>
                    <?php
                    }
                    ?>
            </div>
            <div class="auto-mail-status-changes">

            </div>
        </div>
        <div class="auto-mail-actions">
            <button id="auto-mail-form-preview" class="auto-mail-button" type="button">
                <span class="auto-mail-loading-text">
                    <ion-icon name="save"></ion-icon>
                    <span class="button-text form-preview-text">
                        <?php
                            echo esc_html( 'preview', Auto_Mail::DOMAIN );
                        ?>
                    </span>
                </span>
            </button>
            <button id="auto-mail-form-publish" class="auto-mail-button auto-mail-button-blue" type="button">
                <span class="auto-mail-loading-text">
                    <ion-icon name="save"></ion-icon>
                    <span class="button-text form-publish-text">
                        <?php
                        if($status === 'publish'){
                            echo esc_html( 'update', Auto_Mail::DOMAIN );
                        }else{
                            echo esc_html( 'publish', Auto_Mail::DOMAIN );
                        }
                        ?>
                    </span>
                </span>
            </button>
        </div>
    </div>
</div>
