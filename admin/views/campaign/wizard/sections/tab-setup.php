<?php
$id = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
// Campaign Name
if(!empty($id)){
    $model    = $this->get_single_model( $id );
    $campaign_name = $model->name;
}
?>
<div class="auto-mail-row-with-sidenav">
    <form class="am-newsletter-setup-form" method="post" name="am-newsletter-setup-form" action="">
    <div class="auto-mail-setup-tabs">
        <div id="general" class="auto-mail-setup-tab" data-nav="general" >
            <div class="auto-mail-box-body auto-mail-campaign-setup">
                <div class="auto-mail-campaign-setup-row">
                    <div class="auto-mail-box-settings-col-1">
                        <span class="auto-mail-settings-label"><?php esc_html_e( 'Campaign Name', Auto_Mail::DOMAIN ); ?></span>
                    </div>
                    <div class="auto-mail-box-settings-col-2">
                            <input
                                type="text"
                                name="auto_mail_campaign_name"
                                placeholder=""
                                value="<?php if(isset($campaign_name)){echo $campaign_name;}?>"
                                id="auto_mail_campaign_name"
                                class="auto-mail-form-control"
                            />
                            <span class="auto-mail-error-message-name" style="display: none;"><?php _e("Campaign name cannot be empty.", Auto_Mail::DOMAIN); ?></span>
                    </div>
                </div>
            </div>
            <div class="auto-mail-box-footer">
                <div class="auto-mail-actions-left auto-mail-campaign-left">
                    <button class="auto-mail-newsletter-setup auto-mail-button auto-mail-button-blue" type="submit">
                        <span class="auto-mail-loading-text">
                            <?php
                             if(!empty($id)){
                                 esc_html_e( 'Next', Auto_Mail::DOMAIN );
                             }else{
                                 esc_html_e( 'Create Campaign', Auto_Mail::DOMAIN );
                             }
                            ?>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="campaign_id" value="<?php echo esc_html($id); ?>">
    </form>
</div>