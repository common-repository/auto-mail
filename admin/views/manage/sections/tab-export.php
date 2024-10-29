<?php
$action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';
$lists = array();
$list_models = Auto_Mail_List_Model::model()->get_all_models();
foreach($list_models['models'] as $key => $value){
    $lists[$key]['id'] = $value->id;
    $lists[$key]['name'] = $value->settings['auto_mail_list_name'];
}
$output_format = array(
    'xls' => 'Excel Spreadsheet',
    'csv' => 'CSV',
    'html' => 'HTML',
);
?>
<div id="export" class="auto-mail-box-tab <?php echo auto_mail_active_action('export', $action); ?>" data-nav="export" >
    <form class="auto-mail-export-form" method="post" name="auto-mail-export-form" action="">

	<div class="auto-mail-box-header">
		<h2 class="auto-mail-box-title"><?php esc_html_e( 'Export', Auto_Mail::DOMAIN ); ?></h2>
	</div>

    <div class="auto-mail-box-body">
        <div class="auto-mail-box-settings-row">
            <div class="auto-mail-box-settings-col-1">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'Pick one or multiple subscribers lists', Auto_Mail::DOMAIN ); ?></span>
            </div>
            <div class="auto-mail-box-settings-col-2">
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

   <div class="auto-mail-box-footer">
       <div class="auto-mail-actions-left auto-mail-list-left">
            <button class="auto-mail-do-export auto-mail-button auto-mail-button-blue" type="submit">
                <span class="auto-mail-loading-text"><?php esc_html_e( 'Export', Auto_Mail::DOMAIN ); ?></span>
            </button>
        </div>
   </div>

   <input type="hidden" name="auto_mail_nonce" value="<?php echo wp_create_nonce( 'auto-mail' );?>">

    </form>
</div>
