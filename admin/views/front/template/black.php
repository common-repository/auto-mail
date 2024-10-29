<?php
if($form->settings['feature_image']){
    $image_attributes = wp_get_attachment_image_src( $form->settings['feature_image'], 'full' );
    $feature_image_src = $image_attributes[0];
}else{
    $feature_image_src = AUTO_MAIL_URL . 'assets/images/form/default-black-feature.png';
}

?>
<div id="modal-<?php echo $form->id;?>" class="modal black-template">
    <div class="modal-content am-form-modal-content">
        <div class="am-form-popup">
        <div class="am-form-close-button">
            <span class="auto-mail-close-button">×</span>
        </div>
        <div class="am-form-container">
            <div class="am-form-images">
                <img src="<?php echo esc_url($feature_image_src); ?>" >
            </div>
            <div class="am-form-body">
                <div class="am-form-content">
                    <div class="am-form-content-wrap">
                        <div class="am-form-group-title">
                            <span class="am-form-title"><?php echo esc_html($form->settings['auto_mail_main_title']); ?></span>
                            <span class="am-form-subtitle"><?php echo esc_html($form->settings['auto_mail_sub_title']); ?></span>
                        </div>
                        <div class="am-form-group-content">
                            <p><?php echo $form->settings['auto_mail_message']; ?></p>
                        </div>
                    </div>
                    <form method="post" class="am-subscribe-form-data">
                        <div class="am-form-fields">
                            <div class="am-form-field am-form-email">
                                <input id="email" class="am-form-input-text" required="" type="email" name="email" autocomplete="off" placeholder="Email address">
                            </div>
                        </div>
                        <div class="am-form-submit">
                            <button class="am-form-button am-submit-form-button">
                                <span class="am-form-button-text"><?php esc_html_e( 'Start Shooping', Auto_Mail::DOMAIN ); ?></span>
                            </button>
                        </div>
                        <input type="hidden" name="on_submit" value="<?php echo esc_attr($form->settings['on_submit']); ?>">
                        <input type="hidden" name="go_page" value="<?php echo esc_attr($form->settings['go_page']); ?>">
                        <input type="hidden" name="show_message" value="<?php echo esc_attr($form->settings['show_message']); ?>">
                        <input type="hidden" name="form_id" value="<?php echo esc_attr($form->id); ?>">
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

