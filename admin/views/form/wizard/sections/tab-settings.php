<?php
$on_submit = isset( $settings['on_submit'] ) ? $settings['on_submit'] : 'show_message';

$lists = array();
$list_models = Auto_Mail_List_Model::model()->get_all_models();
foreach($list_models['models'] as $key => $value){
    $lists[$key]['id'] = $value->id;
    $lists[$key]['name'] = $value->settings['auto_mail_list_name'];
}
?>
<div id="settings" class="auto-mail-box-tab" data-nav="settings" >
    <div class="auto-mail-box-header">
		<h2 class="auto-mail-box-title"><?php esc_html_e( 'Settings', Auto_Mail::DOMAIN ); ?></h2>
	</div>

    <div class="auto-mail-box-body">
        <div class="auto-mail-box-settings-row">

            <div class="auto-mail-box-settings-col-1">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'On Submit', Auto_Mail::DOMAIN ); ?></span>
                <span class="auto-mail-description"><?php esc_html_e( 'Configure the action after user submit form.', Auto_Mail::DOMAIN ); ?></span>
            </div>

            <div class="auto-mail-box-settings-col-2">
                <div class="sui-side-tabs">
                    <div class="sui-tabs-menu">
                        <div class="sui-tab-item sui-tab-action <?php echo ( $on_submit == 'show_message' ? 'active' : '' ); ?>" data-nav="show_message"><?php esc_html_e( 'Show Message', Auto_Mail::DOMAIN ); ?></div>
                        <div class="sui-tab-item sui-tab-action <?php echo ( $on_submit == 'go_page' ? 'active' : '' ); ?>" data-nav="go_page"><?php esc_html_e( 'Go to Page', Auto_Mail::DOMAIN ); ?></div>
                    </div>
                </div>
                <div class="sui-tabs-content">
                    <div class="sui-tab-content auto-mail-box-settings-inputs <?php echo ( $on_submit == 'show_message' ? 'active' : '' ); ?>" id="show_message">
                        <textarea class="auto-mail-form-control auto-mail-form-textarea" placeholder="<?php esc_html_e( 'Thanks for signing up!', Auto_Mail::DOMAIN ); ?>" name="show_message"><?php if(isset($settings['show_message'])){echo $settings['show_message'];}?></textarea>
                    </div>
                    <div class="sui-tab-content <?php echo ( $on_submit == 'go_page' ? 'active' : '' ); ?>" id="go_page">
                        <input type="text" name="go_page" placeholder="<?php esc_html_e( 'https://...', Auto_Mail::DOMAIN ); ?>" class="auto-mail-form-control" value="<?php if(isset($settings['go_page'])){echo $settings['go_page'];}?>">
                    </div>

                </div>
            </div>
        </div>
        <div class="auto-mail-box-settings-row">
            <div class="auto-mail-box-settings-col-1">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'Subscribe to list', Auto_Mail::DOMAIN ); ?></span>
                <span class="auto-mail-description"><?php esc_html_e( 'Select the user list after user subscribe.', Auto_Mail::DOMAIN ); ?></span>
            </div>

            <div class="auto-mail-box-settings-col-2">

                        <ul>
			                <?php
			                    foreach ( $lists as $list_key => $list ) :
				            ?>
				                <li><label><input class="auto-mail-selected-roles" type="checkbox" name="lists" value="<?php echo esc_attr( $list['id'] ); ?>" <?php if(in_array($list['id'], $settings['lists'])){echo "checked";}?>> <?php echo esc_html( $list['name'] ); ?></label></li>
			                <?php endforeach; ?>
			            </ul>

            </div>

        </div>
    </div>
</div>