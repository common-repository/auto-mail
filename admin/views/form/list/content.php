<?php
// Count total forms
$count        = $this->countModules();
$count_active = $this->countModules( 'publish' );

// available bulk actions
$bulk_actions = $this->bulk_actions();
?>

<?php if ( $count > 0 ) { ?>
    <!-- START: Bulk actions and pagination -->
    <div class="auto-mail-listings-pagination">

        <div class="auto-mail-pagination-mobile auto-mail-pagination-wrap">
            <span class="auto-mail-pagination-results">
                            <?php /* translators: ... */ echo esc_html( sprintf( _n( '%s result', '%s results', $count, Auto_Mail::DOMAIN ), $count ) ); ?>
                        </span>
            <?php $this->pagination(); ?>
        </div>

        <div class="auto-mail-pagination-desktop auto-mail-box">
            <div class="auto-mail-box-search">
                <form method="post" name="auto-mail-bulk-action-form" class="auto-mail-search-left">
                    <input type="hidden" name="auto_mail_nonce" value="<?php echo wp_create_nonce( 'auto-mail-form-request' );?>">
                    <input type="hidden" name="_wp_http_referer" value="<?php admin_url( 'admin.php?page=auto-mail-campaign' ); ?>">
                    <input type="hidden" name="ids" id="auto-mail-select-forms-ids" value="">
                    <label for="auto-mail-check-all-forms" class="auto-mail-checkbox">
                        <input type="checkbox" id="auto-mail-check-all-forms">
                        <span aria-hidden="true"></span>
                        <span class="auto-mail-screen-reader-text"><?php esc_html_e( 'Select all', Auto_Mail::DOMAIN ); ?></span>
                    </label>
                    <div class="auto-mail-select-wrapper">
                        <select name="auto_mail_bulk_action" id="bulk-action-selector-top">
                            <option value=""><?php esc_html_e( 'Bulk Action', Auto_Mail::DOMAIN ); ?></option>
                            <?php foreach ( $bulk_actions as $val => $label ) : ?>
                                <option value="<?php echo esc_attr( $val ); ?>"><?php echo esc_html( $label ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="auto-mail-button auto-mail-bulk-action-button"><?php esc_html_e( 'Apply', Auto_Mail::DOMAIN ); ?></button>
                </form>

                <div class="auto-mail-search-right">
                    <div class="auto-mail-pagination-wrap">
                        <span class="auto-mail-pagination-results">
                            <?php /* translators: ... */ echo esc_html( sprintf( _n( '%s result', '%s results', $count, Auto_Mail::DOMAIN ), $count ) ); ?>
                        </span>
                        <?php $this->pagination(); ?>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- END: Bulk actions and pagination -->

    <div class="auto-mail-accordion auto-mail-accordion-block" id="auto-mail-modules-list">

        <?php
        foreach ( $this->getModules() as $module ) {
        ?>
            <div class="auto-mail-accordion-item">
                <div class="auto-mail-accordion-item-header">

                    <div class="auto-mail-accordion-item-title auto-mail-trim-title">
                        <label for="wpf-module-<?php echo esc_attr( $module['id'] ); ?>" class="auto-mail-checkbox auto-mail-accordion-item-action">
                            <input type="checkbox" id="wpf-module-<?php echo esc_attr( $module['id'] ); ?>" class="auto-mail-check-single-form" value="<?php esc_attr_e( $module['id'] ); ?>">
                            <span aria-hidden="true"></span>
                            <span class="auto-mail-screen-reader-text"><?php esc_html_e( 'Select this form', Auto_Mail::DOMAIN ); ?></span>
                        </label>
                        <span class="auto-mail-trim-text">
                            <?php echo auto_mail_get_form_name( $module['id'] ); ?>
                        </span>
                        <?php
                        if ( 'publish' === $module['status'] ) {
                            echo '<span class="auto-mail-tag auto-mail-tag-blue">' . esc_html__( 'Published', Auto_Mail::DOMAIN ) . '</span>';
                        }
                        ?>

                        <?php
                        if ( 'draft' === $module['status'] ) {
                            echo '<span class="auto-mail-tag">' . esc_html__( 'Draft', Auto_Mail::DOMAIN ) . '</span>';
                        }
                        ?>
                    </div>

                    <div class="auto-mail-accordion-item-date">
                        <strong><?php esc_html_e( 'Shortcode', Auto_Mail::DOMAIN ); ?></strong>
                        <?php
                            $shortcode_text = '[auto-mail id="'.$module['id'].'"]';
                            esc_html_e( $shortcode_text );
                        ?>
                    </div>

                    <div class="auto-mail-accordion-col-auto">

                        <a href="<?php echo admin_url( 'admin.php?page=auto-mail-form-wizard&id=' . $module['id'] . '&status=' . $module['status'] ); ?>"
                           class="auto-mail-button auto-mail-button-ghost auto-mail-accordion-item-action auto-mail-desktop-visible">
                            <ion-icon name="pencil" class="auto-mail-icon-pencil"></ion-icon>
                            <?php esc_html_e( 'Edit', Auto_Mail::DOMAIN ); ?>
                        </a>

                        <div class="auto-mail-dropdown auto-mail-accordion-item-action">
                            <button class="auto-mail-button-icon auto-mail-dropdown-anchor" data-id=<?php echo esc_attr( $module['id'] ); ?>>
                                <ion-icon name="settings-outline"></ion-icon>
                            </button>
                            <ul class="auto-mail-dropdown-list" data-id=<?php echo esc_attr( $module['id'] ); ?>>
                                <li>
                                    <form method="post">
                                        <input type="hidden" name="auto_mail_nonce" value="<?php echo wp_create_nonce( 'auto-mail-gallery-request' );?>">
                                        <input type="hidden" name="auto_mail_single_action" value="update-status">
                                        <input type="hidden" name="id" value="<?php echo esc_attr( $module['id'] ); ?>">
                                        <?php
                                        if ( 'publish' === $module['status'] ) {
                                            ?>
                                            <input type="hidden" name="status" value="draft">
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ( 'draft' === $module['status'] ) {
                                            ?>
                                            <input type="hidden" name="status" value="publish">
                                            <?php
                                        }
                                        ?>
                                        <button type="submit">
                                            <ion-icon class="auto-mail-icon-cloud" name="cloud"></ion-icon>
                                            <?php
                                            if ( 'publish' === $module['status'] ) {
                                                echo esc_html__( 'Unpublish', Auto_Mail::DOMAIN );
                                            }
                                            ?>

                                            <?php
                                            if ( 'draft' === $module['status'] ) {
                                                echo esc_html__( 'Publish', Auto_Mail::DOMAIN );
                                            }
                                            ?>
                                        </button>
                                    </form>
                                </li>

                                <li>
                                    <form method="post">
                                        <input type="hidden" name="auto_mail_nonce" value="<?php echo wp_create_nonce( 'auto-mail-gallery-request' );?>">
                                        <input type="hidden" name="auto_mail_single_action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo esc_attr( $module['id'] ); ?>">
                                        <button type="submit">
                                            <ion-icon class="auto-mail-icon-trash" name="trash"></ion-icon>
                                            <?php esc_html_e( 'Delete', Auto_Mail::DOMAIN ); ?>
                                        </button>
                                    </form>
                                </li>

                            </ul>
                        </div>

                        <button class="auto-mail-button-icon auto-mail-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', Auto_Mail::DOMAIN ); ?>">
                            <ion-icon name="chevron-down"></ion-icon>
                        </button>


                    </div>

                </div>
            </div>

        <?php

        }

        ?>

    </div>


<?php } else { ?>
<div class="auto-mail-box auto-mail-message auto-mail-message-lg">

    <img src="<?php echo esc_url(AUTO_MAIL_URL.'/assets/images/auto-mail.png'); ?>" class="auto-mail-image auto-mail-image-center" aria-hidden="true" alt="<?php esc_attr_e( 'Auto Mail', Auto_Mail::DOMAIN ); ?>">

    <div class="auto-mail-message-content">

        <p><?php esc_html_e( 'Create popup forms to build your email lists and funnels, and make more profit and increase your conversion rates.', Auto_Mail::DOMAIN ); ?></p>

        <p>
            <a href="#" class="am-form-popup-template">
                <button class="auto-mail-button auto-mail-button-blue">
                    <?php esc_html_e( 'Create', Auto_Mail::DOMAIN ); ?>
                </button>
            </a>
        </p>

    </div>

</div>

<?php } ?>
