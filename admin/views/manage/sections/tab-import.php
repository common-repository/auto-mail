<?php
$import_options = array(
    "paste_data" => "Paste the data into a text box",
    "upload_file" => "Upload a file",
    "mailchimp" => "Import from MailChimp",
    "wordpress" => "Import from Wordpress Users"
);
$roles = get_editable_roles();
$action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';
?>
<div id="import" class="auto-mail-box-tab <?php echo auto_mail_active_action('import', $action); ?>" data-nav="import" >

	<div class="auto-mail-box-header">
		<h2 class="auto-mail-box-title"><?php esc_html_e( 'Import', Auto_Mail::DOMAIN ); ?></h2>
	</div>

    <div class="auto-mail-box-body">
        <div class="auto-mail-box-settings-row auto-mail-import-steps">
            <div class="auto-mail-box-settings-col-1">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'How would you like to import subscribers?', Auto_Mail::DOMAIN ); ?></span>
                <span class="auto-mail-description"><?php esc_html_e( 'Import new subscribers from your other sources.', Auto_Mail::DOMAIN ); ?></span>
            </div>
            <div class="auto-mail-box-settings-col-2">
                <span class="dropdown-el auto-mail-init-status-selector">
                    <?php foreach ( $import_options as $key => $value ) : ?>
                        <input type="radio" name="auto_mail_init_status" value="<?php echo esc_attr( $key ); ?>" <?php if($key == 'paste_data'){echo 'checked="checked"';} ?> id="<?php echo esc_attr( $key ); ?>">
                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></label>
                    <?php endforeach; ?>
                </span>

                <div class="shortcode-options">
                    <div class="shortcode-select paste_data current">
                        <label class="auto-mail-settings-label"><?php esc_html_e( 'Copy and paste your subscribers from Excel/Spreadsheets.', Auto_Mail::DOMAIN ); ?></label>
                        <span class="auto-mail-description"><?php esc_html_e( 'This file needs to be formatted in a CSV style (comma-separated-values.)', Auto_Mail::DOMAIN ); ?></span>
                        <div class="auto-mail-form-field">
                            <form method="post" class="auto-mail-prepare-form">
                                <textarea class="auto-mail-form-control auto-mail-form-textarea" name="paste_data" required="required" placeholder="<?php esc_html_e( "Email, First Name, Last Name\njohn@doe.com, John, Doe\nmary@smith.com, Mary, Smith\njohnny@walker.com, Johnny, Walker", Auto_Mail::DOMAIN ); ?>"></textarea>
                                <input type="hidden" name="auto_mail_nonce" value="<?php echo wp_create_nonce( 'auto-mail' );?>">
                                <div class="auto-mail-import-actions auto-mail-prepare-action">
                                    <button id="auto-mail-prepare-import" class="auto-mail-paste-method auto-mail-button auto-mail-button-blue" type="button">
                                        <?php  echo esc_html( 'Next Step', Auto_Mail::DOMAIN ); ?>
                                    </button>
                                    <div class="auto-mail-import-running">
                                        <div class="loader" id="loader-1"></div>
                                        <span><?php echo esc_html( 'Running now...', Auto_Mail::DOMAIN ); ?></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="shortcode-select upload_file">
                        <form method="post" class="auto-mail-prepare-form">
                            <div class="auto-mail-upload-import">
					            <input type="file" name="auto-mail-async-upload" id="auto-mail-async-upload" />
				            </div>
                            <div class="auto-mail-import-actions auto-mail-prepare-action">
                                <button id="auto-mail-prepare-import" class="auto-mail-upload-method auto-mail-button auto-mail-button-blue" type="button">
                                    <?php  echo esc_html( 'Next Step', Auto_Mail::DOMAIN ); ?>
                                </button>
                                <div class="auto-mail-import-running">
                                    <div class="loader" id="loader-1"></div>
                                    <span><?php echo esc_html( 'Running now...', Auto_Mail::DOMAIN ); ?></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="shortcode-select mailchimp">
                        <form method="post" class="auto-mail-mailchimp-form">
                            <p><label><?php esc_html_e( 'Enter your Mailchimp API Key.' ); ?></label></p>
                            <input type="text" name="mailchimp_api_key" value="" class="auto-mail-form-control" autocomplete="off">
                            <p class="auto-mail-mailchimp-howto"><?php printf( esc_html__( 'You can find your API Key %s.', Auto_Mail::DOMAIN ), '<a href="https://us2.admin.mailchimp.com/account/api-key-popup/" class="external">' . esc_html__( 'here', Auto_Mail::DOMAIN ) . '</a>' ); ?> <?php esc_html_e( 'Auto Mail will store this key for 24 hours.' ); ?></p>
                            <div class="auto-mail-import-actions auto-mail-prepare-action">
                                <button id="auto-mail-mailchimp-verify" class="auto-mail-mailchimp-method auto-mail-button auto-mail-button-blue" type="button">
                                    <?php echo esc_html( 'Next Step', Auto_Mail::DOMAIN ); ?>
                                </button>
                                <div class="auto-mail-import-running">
                                    <div class="loader" id="loader-1"></div>
                                    <span><?php echo esc_html( 'Running now...', Auto_Mail::DOMAIN ); ?></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="shortcode-select wordpress">
                        <label class="auto-mail-settings-label"><?php esc_html_e( 'Import your exciting WordPress users.', Auto_Mail::DOMAIN ); ?></label>
                        <span class="auto-mail-description"><?php esc_html_e( 'Select the user roles you like to import.', Auto_Mail::DOMAIN ); ?></span>
                        <div class="auto-mail-form-field">
                            <form method="post" class="auto-mail-prepare-form">
                                <label><input type="checkbox" class="auto-mail-list-toggle" checked> <?php esc_html_e( 'Toggle all', Auto_Mail::DOMAIN ); ?></label>
			                    <ul>
			                        <?php
			                            foreach ( $roles as $role_key => $role ) :
				                    ?>
				                        <li><label><input class="auto-mail-selected-roles" type="checkbox" name="roles[]" value="<?php echo esc_attr( $role_key ); ?>" checked> <?php echo esc_html( $role['name'] ); ?></label></li>
			                        <?php endforeach; ?>
			                    </ul>
                                <input type="hidden" name="auto_mail_nonce" value="<?php echo wp_create_nonce( 'auto-mail' );?>">
                                <div class="auto-mail-import-actions auto-mail-prepare-action">
                                    <button id="auto-mail-prepare-import" class="auto-mail-wordpress-method auto-mail-button auto-mail-button-blue" type="button">
                                        <?php  echo esc_html( 'Next Step', Auto_Mail::DOMAIN ); ?>
                                    </button>
                                    <div class="auto-mail-import-running">
                                        <div class="loader" id="loader-1"></div>
                                        <span><?php echo esc_html( 'Running now...', Auto_Mail::DOMAIN ); ?></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>


</div>
