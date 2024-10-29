<?php
$id = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
// Campaign Settings
$settings = array();
if(!empty($id)){
    $model    = $this->get_single_model( $id );
    $settings = $model->settings;
    $settings['status'] = $model->status;
}
$status_list = array(
    "subscribed" => "Subscribed",
    "unconfirmed" => "Unconfirmed",
    "confirmed" => "Confirmed",
    "unsubscribed" => "Unsubscribed",
    "bounced" => "Bounced",
    "spam" => "Spam"
);
$lists = array();
$list_models = Auto_Mail_List_Model::model()->get_all_models();
foreach($list_models['models'] as $key => $value){
    $lists[$key]['id'] = $value->id;
    $lists[$key]['name'] = $value->settings['auto_mail_list_name'];
}
?>
<div class="auto-mail-row-with-sidenav">

<form class="auto-mail-subscriber-form" method="post" name="auto-mail-subscriber-form" action="">
    <div class="auto-mail-box-tabs">
        <div id="general" class="auto-mail-box-tab active" data-nav="general" >
            <div class="auto-mail-box-body">
                <div class="auto-mail-box-settings-row auto-mail-list-row">
                    <div class="auto-mail-box-settings-col-1">
                        <span class="auto-mail-settings-label"><?php esc_html_e( 'Email', Auto_Mail::DOMAIN ); ?></span>
                    </div>
                    <div class="auto-mail-box-settings-col-2">
                            <input
                                type="text"
                                name="email_address"
                                placeholder=""
                                value="<?php if(isset($settings['email_address'])){echo $settings['email_address'];}?>"
                                id="email_address"
                                class="auto-mail-form-control"
                            />
                    </div>
                </div>
                <div class="auto-mail-box-settings-row auto-mail-list-row">
                    <div class="auto-mail-box-settings-col-1">
                        <span class="auto-mail-settings-label"><?php esc_html_e( 'First Name', Auto_Mail::DOMAIN ); ?></span>
                    </div>
                    <div class="auto-mail-box-settings-col-2">
                        <input
                                type="text"
                                name="first_name"
                                placeholder=""
                                value="<?php if(isset($settings['first_name'])){echo $settings['first_name'];}?>"
                                id="first_name"
                                class="auto-mail-form-control"
                            />
                    </div>
                </div>
                <div class="auto-mail-box-settings-row auto-mail-list-row">
                    <div class="auto-mail-box-settings-col-1">
                        <span class="auto-mail-settings-label"><?php esc_html_e( 'Status', Auto_Mail::DOMAIN ); ?></span>
                    </div>
                    <div class="auto-mail-box-settings-col-2">
                        <select name="optin_status">
                            <?php foreach ( $status_list as $key => $value ) : ?>
                                <option value="<?php echo esc_attr( $key ); ?>" <?php if($key == $settings['status']){echo "selected";}?>><?php echo esc_html( $value ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="auto-mail-box-settings-row auto-mail-list-row">
                    <div class="auto-mail-box-settings-col-1">
                        <span class="auto-mail-settings-label"><?php esc_html_e( 'Lists', Auto_Mail::DOMAIN ); ?></span>
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
            <div class="auto-mail-box-footer">
                <div class="auto-mail-actions-left auto-mail-list-left">
                    <button class="auto-mail-subscriber-save auto-mail-button auto-mail-button-blue" type="submit">
                        <span class="auto-mail-loading-text"><?php esc_html_e( 'Save', Auto_Mail::DOMAIN ); ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="form_id" value="<?php echo esc_html($id); ?>">
    </form>
</div>