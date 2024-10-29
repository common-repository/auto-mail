<?php
$url = site_url();
?>
<div class="am-form-preview">
        <div class="hui-preview-header">
            <div class="hui-left">
                <h3 id="am-dialog--preview-title" class="hui-preview-title"><?php esc_html_e( 'Preview', Auto_Mail::DOMAIN ); ?></h3>
                <p id="am-dialog--preview-description" class="hui-preview-description"><?php esc_html_e( 'Demo', Auto_Mail::DOMAIN ); ?></p>
            </div>

            <div class="hui-center">
                <button class="auto-mail-desktop-preview am-preview-device-button hui-preview-button-left sui-tooltip sui-tooltip-bottom sui-active" aria-label="Preview on desktop" data-device="desktop" data-selected="Desktop preview enabled" data-tooltip="Desktop">
                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"><defs><path id="a" d="M0 0h16v16H0z"></path></defs><g fill="none" fill-rule="evenodd"><path d="M11.234 15a.246.246 0 00.188-.085.313.313 0 00.078-.22v-.324a.313.313 0 00-.078-.22.246.246 0 00-.188-.085h-1.5V12.45h5.282c.27 0 .502-.104.695-.314.16-.174.254-.379.281-.612L16 11.38v-9.31c0-.295-.096-.547-.29-.757A.912.912 0 0015.017 1H.984a.912.912 0 00-.695.314C.096 1.524 0 1.776 0 2.07v9.311c0 .295.096.544.29.748a.923.923 0 00.694.305h5.282v1.632H4.625a.27.27 0 00-.195.084.297.297 0 00-.086.221v.323a.297.297 0 00.21.297l.071.009h6.61zm3.016-4.451H1.75V2.886h12.5v7.663z" fill="#888" fill-rule="nonzero"></path></g></svg>
                    <span class="sui-screen-reader-text"><?php esc_html_e( 'Preview on desktop', Auto_Mail::DOMAIN ); ?></span>
                </button>
                <button class="auto-mail-mobile-preview am-preview-device-button hui-preview-button-right sui-tooltip sui-tooltip-bottom" aria-label="Preview on mobile" data-device="mobile" data-selected="Mobile preview enabled" data-tooltip="Mobile">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" aria-hidden="true"><defs><path id="a" d="M0 0h16v16H0z"></path></defs><g fill="none" fill-rule="evenodd"><path fill="#888" fill-rule="nonzero" d="M13.42 16a.57.57 0 00.58-.578V.578A.57.57 0 0013.42 0H2.547A.57.57 0 002 .563v14.874a.57.57 0 00.548.563H13.42zm-1.355-1.86H3.919V1.86h8.146v12.28zm-4.081 1.391a.464.464 0 01-.347-.14.455.455 0 01-.137-.329c0-.124.046-.234.137-.328a.464.464 0 01.347-.14c.129 0 .24.047.33.14a.455.455 0 01.138.329.455.455 0 01-.137.328.445.445 0 01-.331.14z"></path></g></svg>
                    <span class="sui-screen-reader-text"><?php esc_html_e( 'Preview on mobile', Auto_Mail::DOMAIN ); ?></span>
                </button>
            </div>

            <div tabindex="-1" class="hui-right">
                <button id="auto-mail-reload-preview" class="sui-button-icon sui-tooltip sui-tooltip-bottom" aria-label="Reload Preview" data-tooltip="Reload">
				    <span class="sui-icon-refresh sui-md" aria-hidden="true">
                        <ion-icon name="reload-outline" class="auto-mail-icon-reload" ></ion-icon>
                    </span>
				    <span class="sui-screen-reader-text"><?php esc_html_e( 'Reload Preview', Auto_Mail::DOMAIN ); ?></span>
			    </button>
                <span class="auto-mail-close-preview">×</span>
            </div>
        </div>

        <div class="hui-preview-body">
            <iframe
				id="am-preview-iframe"
				title="<?php esc_html_e( 'A preview of your module', Auto_Mail::DOMAIN ); ?>"
				data-src="<?php echo esc_url( $url ); ?>"
                src="<?php echo esc_url( $url ); ?>"
				sandbox="allow-same-origin allow-scripts"></iframe>
	    </div>
</div>