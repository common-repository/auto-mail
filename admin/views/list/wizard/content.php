<?php
$id = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
// Campaign Settings
$settings = array();
if(!empty($id)){
    $model    = $this->get_single_model( $id );
    $settings = $model->settings;
    $settings['status'] = $model->status;
}
?>
<div class="auto-mail-row-with-sidenav">
    <form class="auto-mail-list-form" method="post" name="auto-mail-list-form" action="">
    <div class="auto-mail-box-tabs">
        <div id="general" class="auto-mail-box-tab active" data-nav="general" >
            <div class="auto-mail-box-body">
                <div class="auto-mail-box-settings-row auto-mail-list-row">
                    <div class="auto-mail-box-settings-col-1">
                        <span class="auto-mail-settings-label"><?php esc_html_e( 'Name', Auto_Mail::DOMAIN ); ?></span>
                    </div>
                    <div class="auto-mail-box-settings-col-2">
                            <input
                                type="text"
                                name="auto_mail_list_name"
                                placeholder=""
                                value="<?php if(isset($settings['auto_mail_list_name'])){echo $settings['auto_mail_list_name'];}?>"
                                id="auto_mail_list_name"
                                class="auto-mail-form-control"
                            />
                    </div>
                </div>
                <div class="auto-mail-box-settings-row auto-mail-list-row">
                    <div class="auto-mail-box-settings-col-1">
                        <span class="auto-mail-settings-label"><?php esc_html_e( 'Description', Auto_Mail::DOMAIN ); ?></span>
                    </div>
                    <div class="auto-mail-box-settings-col-2">
                        <textarea class="auto-mail-form-control auto-mail-form-textarea" name="auto_mail_list_desc"><?php if(isset($settings['auto_mail_list_desc'])){echo $settings['auto_mail_list_desc'];}?></textarea>
                    </div>
                </div>
            </div>
            <div class="auto-mail-box-footer">
                <div class="auto-mail-actions-left auto-mail-list-left">
                    <button class="auto-mail-list-save auto-mail-button auto-mail-button-blue" type="submit">
                        <span class="auto-mail-loading-text"><?php esc_html_e( 'Save', Auto_Mail::DOMAIN ); ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="list_id" value="<?php echo esc_html($id); ?>">
    </form>
</div>