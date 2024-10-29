<div id="fields" class="auto-mail-box-tab" data-nav="fields" >
    <div class="auto-mail-box-header">
		<h2 class="auto-mail-box-title"><?php esc_html_e( 'Form Fields', Auto_Mail::DOMAIN ); ?></h2>
	</div>

    <div class="auto-mail-box-body">
        <div class="auto-mail-box-settings-row">

            <div class="auto-mail-box-settings-col-1">
                <span class="auto-mail-settings-label"><?php esc_html_e( 'Opt-in Form Fields', Auto_Mail::DOMAIN ); ?></span>
                <span class="auto-mail-description"><?php esc_html_e( 'Configure the fields you want to be displayed in the opt-in form.', Auto_Mail::DOMAIN ); ?></span>
            </div>

            <div class="auto-mail-box-settings-col-2">

                <div class="sui-box-builder" style="margin-bottom: 10px;">

                    <div class="sui-box-builder-header">
                        <a href="#" class="auto-mail-form-insert-field">
                            <button class="popup-trigger auto-mail-button auto-mail-button-blue">
                                <?php esc_html_e( 'Insert Field', Auto_Mail::DOMAIN ); ?>
                            </button>
                        </a>
                    </div>

                    <div class="sui-box-builder-body">
                        <div id="am-form-fields-container" class="sui-builder-fields ui-sortable">
                            <div id="am-optin-field--phone" class="sui-builder-field sui-can-move ui-sortable-handle" data-field-id="phone" style="">

                                    <span class="sui-icon-drag" aria-hidden="true"></span>

                                    <div class="sui-builder-field-label">
                                        <span class="sui-icon-phone" aria-hidden="true"></span>
                                        <span class="am-field-label"><span class="am-field-label-text">Phone Number</span> <span class="sui-error" style="display:none;">*</span></span>
                                    </div>

                                    <div class="auto-mail-dropdown auto-mail-accordion-item-action">
                                        <button class="auto-mail-button-icon auto-mail-dropdown-anchor">
                                            <ion-icon name="settings"></ion-icon>
                                        </button>
                                        <ul class="auto-mail-dropdown-list">
                                            <li>
                                                <a href="#delete-popup" class="open-popup-delete" data-effect="mfp-zoom-in">
                                                    <button class="auto-mail-option-red auto-mail-delete-action">
                                                        <ion-icon class="auto-mail-icon-trash" name="trash"></ion-icon>
                                                        <?php esc_html_e( 'Delete', Auto_Mail::DOMAIN ); ?>
                                                    </button>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#delete-popup" class="open-popup-delete" data-effect="mfp-zoom-in">
                                                    <button class="auto-mail-option-red auto-mail-delete-action">
                                                        <ion-icon class="auto-mail-icon-trash" name="trash"></ion-icon>
                                                        <?php esc_html_e( 'Duplicate', Auto_Mail::DOMAIN ); ?>
                                                    </button>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                            </div>
                            <div id="am-optin-field--email" class="sui-builder-field sui-can-move ui-sortable-handle" data-field-id="email" style="">

                                <span class="sui-icon-drag" aria-hidden="true"></span>

                                <div class="sui-builder-field-label">
                                    <span class="sui-icon-mail" aria-hidden="true"></span>
                                    <span class="am-field-label"><span class="am-field-label-text">Email</span> <span class="sui-error">*</span></span>
                                </div>

                                <div class="auto-mail-dropdown auto-mail-accordion-item-action">
                                        <button class="auto-mail-button-icon auto-mail-dropdown-anchor">
                                            <ion-icon name="settings"></ion-icon>
                                        </button>
                                        <ul class="auto-mail-dropdown-list">
                                            <li>
                                                <a href="#delete-popup" class="open-popup-delete" data-effect="mfp-zoom-in">
                                                    <button class="auto-mail-option-red auto-mail-delete-action">
                                                        <ion-icon class="auto-mail-icon-trash" name="trash"></ion-icon>
                                                        <?php esc_html_e( 'Delete', Auto_Mail::DOMAIN ); ?>
                                                    </button>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#delete-popup" class="open-popup-delete" data-effect="mfp-zoom-in">
                                                    <button class="auto-mail-option-red auto-mail-delete-action">
                                                        <ion-icon class="auto-mail-icon-trash" name="trash"></ion-icon>
                                                        <?php esc_html_e( 'Duplicate', Auto_Mail::DOMAIN ); ?>
                                                    </button>
                                                </a>
                                            </li>
                                        </ul>
                                </div>

                            </div>
                        </div>
                        <button class="sui-button sui-button-dashed am-optin-field--add">
                            <span class="sui-icon-plus" aria-hidden="true"></span> Insert Field
                        </button>
                    </div>

                    <div class="sui-box-builder-footer">
                        <div id="am-optin-field--submit" class="sui-builder-field sui-can_open" data-field-id="submit">
                            <div class="sui-builder-field-label">
                                <span class="sui-icon-send" aria-hidden="true"></span>
                                <span class="am-field-label-text">Get Discount</span>
                            </div>
                            <div class="sui-dropdown">
                                <button class="sui-button-icon sui-dropdown-anchor">
                                    <span class="sui-icon-widget-settings-config" aria-hidden="true"></span>
                                    <span class="sui-screen-reader-text">Submit settings</span>
                                </button>
                            <ul>
                                <li><button class="am-optin-field--edit">
                                <span class="sui-icon-pencil" aria-hidden="true"></span> Edit Field </button></li>
                            </ul>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>