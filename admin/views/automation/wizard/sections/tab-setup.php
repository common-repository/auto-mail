<div class="auto-mail-row-with-sidenav">
    <div class="auto-mail-setup-tabs">
        <div id="general" class="auto-mail-setup-tab" data-nav="general" >
            <div class="auto-mail-box-body auto-mail-automation-setup">
                <div class="auto-mail-automation-setup-row">
                    <div class="auto-mail-box-settings-col-1">
                        <span class="auto-mail-settings-label"><?php esc_html_e( 'Automation Name', Auto_Mail::DOMAIN ); ?></span>
                    </div>
                    <div class="auto-mail-box-settings-col-2">
                            <input
                                type="text"
                                name="am_automation_name"
                                placeholder=""
                                value="<?php if(isset($settings['am_automation_name'])){echo $settings['am_automation_name'];}?>"
                                id="am_automation_name"
                                class="auto-mail-form-control"
                            />
                            <span class="auto-mail-error-message-name" style="display: none;"><?php _e("automation name cannot be empty.", Auto_Mail::DOMAIN); ?></span>
                    </div>
                </div>
            </div>
            <div class="auto-mail-box-footer">
                <div class="auto-mail-actions-left auto-mail-automation-left">
                    <button class="auto-mail-automation-name auto-mail-button auto-mail-button-blue" type="submit">
                        <span class="auto-mail-loading-text">
                            <?php
                             if(!empty($id)){
                                 esc_html_e( 'Next', Auto_Mail::DOMAIN );
                             }else{
                                 esc_html_e( 'Next', Auto_Mail::DOMAIN );
                             }
                            ?>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>