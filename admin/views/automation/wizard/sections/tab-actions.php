<?php
print_r($settings);
?>
<div class="auto-mail-box auto-mail-message am-user-add-action-section">
<div class="auto-mail-box-body auto-mail-box-actions auto-mail-email-content">
                    <div class="auto-mail-form-field-sender auto-mail-form-field-row">
                    <h4 class="auto-mail-h4 am-email-title"><label><?php echo esc_html( 'Subject', Auto_Mail::DOMAIN ); ?></label></h4>
                    <div class="auto-mail-form-field">
                    <div class="regular-text auto-mail-form-input">
                    <input
                        type="text"
                        name="woo_automation_email_subject"
                        id="woo_automation_email_subject"
                        value="<?php if(isset($settings['woo_automation_email_subject'])){echo $settings['woo_automation_email_subject'];}else{esc_attr_e( 'admin', Auto_Mail::DOMAIN );} ?>"
                    />
                    </div>
                    </div>
                    <h4 class="auto-mail-h4 am-email-title"><label><?php echo esc_html( 'Email Content', Auto_Mail::DOMAIN ); ?></label></h4>
                    <div class="auto-mail-form-field">
                    <?php
                    $value = isset($settings['pretty_message']) ? $settings['pretty_message'] : '<p>Here is the automation email content for your customers.</p>';
                    wp_editor( $value, 'pretty_message', array(
                        'textarea_name' => 'pretty_message',
                        'wpautop' => false,
                        'teeny' => true,
                        'tinymce' => true
                    ));
                    ?>
                    </div>
                    </div>
                    </div>
</div>