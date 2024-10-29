<?php
$lists = array();
$list_models = Auto_Mail_List_Model::model()->get_all_models();
foreach($list_models['models'] as $key => $value){
    $lists[$key]['id'] = $value->id;
    $lists[$key]['name'] = $value->settings['auto_mail_list_name'];
}
?>
<div class="am-campaign-settings-header">
    <div class="auto-mail-form-field-subject auto-mail-form-input">
        <input
            type="text"
            name="subject"
            id="field_subject"
            placeholder="<?php esc_html_e( 'Type newsletter subject', Auto_Mail::DOMAIN ); ?>"
            maxlength="250"
            value="<?php if(isset($settings['subject'])){echo $settings['subject'];}else{esc_attr_e( 'Subject', Auto_Mail::DOMAIN );} ?>"
        />
    </div>
    <div class="auto-mail-form-field-preheader auto-mail-form-textarea">
        <textarea
            type="text"
            name="preheader"
            id="field_preheader"
            placeholder="<?php esc_html_e( 'Type preview text (usually displayed underneath the subject line in the inbox)', Auto_Mail::DOMAIN ); ?>"
            maxlength="250"><?php if(isset($settings['preheader'])){echo $settings['preheader'];}else{esc_attr_e( 'Preheader', Auto_Mail::DOMAIN );}?>
        </textarea>
    </div>
</div>
<div class="am-campaign-settings-container">
    <div class="am-campaign-column am-campaign-column-left">
        <div class="auto-mail-form-field-sender auto-mail-form-field-row">
            <h4 class="auto-mail-h4"><label for="field_sender"><?php echo esc_html( 'Sender', Auto_Mail::DOMAIN ); ?></label></h4>
            <p class="auto-mail-form-description"><?php echo esc_html( 'Your name and email', Auto_Mail::DOMAIN ); ?></p>
            <div class="auto-mail-form-field">
                <div class="regular-text auto-mail-form-input">
                    <input
                        type="text"
                        name="sender_name"
                        id="field_sender_name"
                        placeholder="<?php esc_html_e( 'John Doe', Auto_Mail::DOMAIN ); ?>"
                        data-parsley-required="true"
                        value="<?php if(isset($settings['sender_name'])){echo $settings['sender_name'];}else{esc_attr_e( 'admin', Auto_Mail::DOMAIN );} ?>"
                    />
                </div>
            </div>
            <div class="auto-mail-form-field">
                <div class="regular-text auto-mail-form-input">
                    <input
                        type="text"
                        name="sender_address"
                        id="field_sender_address"
                        placeholder="<?php esc_html_e( 'john.doe@email.com', Auto_Mail::DOMAIN ); ?>"
                        data-parsley-required="true"
                        data-parsley-type="email"
                        value="<?php if(isset($settings['sender_address'])){echo $settings['sender_address'];}else{esc_attr_e( 'wordpress@email.com', Auto_Mail::DOMAIN );} ?>"
                    />
                </div>
                <div class="regular-text"></div>
            </div>
        </div>
        <div class="auto-mail-form-field-reply-to auto-mail-form-field-row">
            <h4 class="auto-mail-h4"><label for="field_reply-to"><?php echo esc_html( 'Reply-to', Auto_Mail::DOMAIN ); ?></label></h4>
            <p class="auto-mail-form-description"><?php echo esc_html( 'When your subscribers reply to your emails, their emails will go to this address', Auto_Mail::DOMAIN ); ?></p>
            <div class="auto-mail-form-field">
                <div class="regular-text auto-mail-form-input">
                    <input
                        type="text"
                        name="reply_to_name"
                        id="field_reply_to_name"
                        placeholder="<?php esc_html_e( 'John Doe', Auto_Mail::DOMAIN ); ?>"
                        value="<?php if(isset($settings['reply_to_name'])){echo $settings['reply_to_name'];}else{esc_attr_e( 'admin', Auto_Mail::DOMAIN );} ?>"
                    />
                </div>
            </div>
            <div class="auto-mail-form-field">
                <div class="regular-text auto-mail-form-input">
                    <input
                        type="text"
                        name="reply_to_address"
                        id="field_reply_to_address"
                        placeholder="<?php esc_html_e( 'john.doe@email.com', Auto_Mail::DOMAIN ); ?>"
                        data-parsley-type="email"
                        value="<?php if(isset($settings['reply_to_address'])){echo $settings['reply_to_address'];}else{esc_attr_e( 'admin@email.com', Auto_Mail::DOMAIN );} ?>"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="am-campaign-column">
        <div class="auto-mail-form-field-segments form-field-row-segments">
            <h4 class="auto-mail-h4"><label for="field_segments"><?php echo esc_html( 'Lists', Auto_Mail::DOMAIN ); ?></label></h4>
            <p class="auto-mail-form-description"><?php echo esc_html( 'Subscribers in multiple lists will only receive one email', Auto_Mail::DOMAIN ); ?></p>
            <div class="auto-mail-form-field">
                <label><input type="checkbox" class="auto-mail-list-toggle" checked> <?php esc_html_e( 'Toggle all', Auto_Mail::DOMAIN ); ?></label>
                <ul>
			        <?php
			           foreach ( $lists as $list_key => $list ) :
				    ?>
				       <li><label><input class="auto-mail-selected-roles" type="checkbox" name="lists" value="<?php echo esc_attr( $list['id'] ); ?>" checked> <?php echo esc_html( $list['name'] ); ?></label></li>
			        <?php endforeach; ?>
			    </ul>
            </div>
        </div>
    </div>
</div>