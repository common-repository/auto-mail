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
                    <input type="hidden" name="auto_mail_nonce" value="<?php echo wp_create_nonce( 'auto-mail-campaign-request' );?>">
                    <input type="hidden" name="_wp_http_referer" value="<?php admin_url( 'admin.php?page=auto-mail-campaign' ); ?>">
                    <input type="hidden" name="ids" id="auto-mail-select-campaigns-ids" value="">

                    <label for="auto-mail-check-all-campaigns" class="auto-mail-checkbox">
                        <input type="checkbox" id="auto-mail-check-all-campaigns">
                        <span aria-hidden="true"></span>
                        <span class="auto-mail-screen-reader-text">Select all</span>
                    </label>

                    <div class="auto-mail-select-wrapper">
                        <select name="auto_mail_bulk_action" id="bulk-action-selector-top">
                            <option value=""><?php esc_html_e( 'Bulk Action', Auto_Mail::DOMAIN ); ?></option>
                            <?php foreach ( $bulk_actions as $val => $label ) : ?>
                                <option value="<?php echo esc_attr( $val ); ?>"><?php echo esc_html( $label ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button class="auto-mail-button auto-mail-bulk-action-button">Apply</button>

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
                            <input type="checkbox" id="wpf-module-<?php echo esc_attr( $module['id'] ); ?>" class="auto-mail-check-single-campaign" value="<?php echo esc_html( $module['id'] ); ?>">
                            <span aria-hidden="true"></span>
                            <span class="auto-mail-screen-reader-text"><?php esc_html_e( 'Select this form', Auto_Mail::DOMAIN ); ?></span>
                        </label>
                        <span class="auto-mail-trim-text">
                            <?php echo auto_mail_get_campaign_name( $module['id'] ); ?>
                        </span>
                        <?php
                        if ( 'publish' === $module['status'] ) {
                            echo '<span class="auto-mail-tag auto-mail-tag-blue">' . esc_html__( 'Published', Auto_Mail::DOMAIN ) . '</span>';
                        }

                        if ( 'sent' === $module['status'] ) {
                            echo '<span class="auto-mail-tag auto-mail-tag-blue">' . esc_html__( 'Sent', Auto_Mail::DOMAIN ) . '</span>';
                        }

                        if ( 'scheduled' === $module['status'] ) {
                            echo '<span class="auto-mail-tag auto-mail-tag-green">' . esc_html__( 'Scheduled', Auto_Mail::DOMAIN ) . '</span>';
                        }

                        if ( 'draft' === $module['status'] ) {
                            echo '<span class="auto-mail-tag">' . esc_html__( 'Draft', Auto_Mail::DOMAIN ) . '</span>';
                        }
                        ?>
                    </div>

                    <div class="auto-mail-accordion-item-date">
                        <span>
                            <?php
                                $total = Auto_Mail_Queue::total_subscribers_amonut($module['id']);
                                $sent = Auto_Mail_Queue::sent_subscribers_amonut($module['id']);
                                $sending_text = sprintf(/* translators: ... */
                                    __( '%u of %u', Auto_Mail::DOMAIN ),
                                    $sent,
                                    $total
                                );
                                echo $sending_text;
                            ?>
                        </span>
                        <strong><?php esc_html_e( 'Sent', Auto_Mail::DOMAIN ); ?></strong>
                    </div>

                    <div class="auto-mail-accordion-col-auto">

                        <a href="<?php echo admin_url( 'admin.php?page=auto-mail-campaign-wizard&id=' . $module['id'] ); ?>"
                           class="auto-mail-button auto-mail-button-ghost auto-mail-accordion-item-action auto-mail-desktop-visible">
                            <ion-icon name="pencil" class="auto-mail-icon-pencil"></ion-icon>
                            <?php esc_html_e( 'Edit', Auto_Mail::DOMAIN ); ?>
                        </a>

                        <div class="auto-mail-dropdown auto-mail-accordion-item-action">
                            <button class="auto-mail-button-icon auto-mail-dropdown-anchor">
                                <ion-icon name="settings"></ion-icon>
                            </button>
                            <ul class="auto-mail-dropdown-list">

                                <li>
                                    <form method="post">
                                        <input type="hidden" name="auto_auto-mail_single_action" value="update-status">
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
                                        <input type="hidden" id="auto_auto-mail_nonce" name="auto_auto-mail_nonce" value="<?php echo wp_create_nonce('auto-mail-campaign-request'); ?>">
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
                                    <a href="#delete-popup" class="open-popup-delete" data-effect="mfp-zoom-in">
                                    <button
                                        class="auto-mail-option-red auto-mail-delete-action"
                                        data-campaign-id="<?php echo esc_attr( $module['id'] ); ?>">
                                        <ion-icon class="auto-mail-icon-trash" name="trash"></ion-icon> <?php esc_html_e( 'Delete', Auto_Mail::DOMAIN ); ?>
                                    </button>
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <button class="auto-mail-button-icon auto-mail-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', Auto_Mail::DOMAIN ); ?>">
                            <ion-icon name="chevron-down"></ion-icon>
                        </button>


                    </div>

                </div>
                <div class="auto-mail-accordion-item-body auto-mail-campaign-detail-hide">
                    <ul class="auto-mail-accordion-item-data">
                        <li data-col="large">
                            <strong><?php esc_html_e( 'Last Run', Auto_Mail::DOMAIN ); ?></strong>
                            <?php esc_html_e( $module['last_run_time'] ); ?>
                        </li>
                        <li data-col="large">
                            <strong><?php esc_html_e( 'Type', Auto_Mail::DOMAIN ); ?></strong>
                            <?php esc_html_e( $module['type'] ); ?>
                        </li>
                        <li data-col="large">
                            <strong><?php esc_html_e( 'Keywords', Auto_Mail::DOMAIN ); ?></strong>
                            <?php esc_html_e( $module['keywords'] ); ?>
                        </li>
                    </ul>
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

            <p><?php esc_html_e( 'Create campaign for all your needs with pre-template. And send a newsletter with images, buttons, dividers, and social bookmarks', Auto_Mail::DOMAIN ); ?></p>

            <p>
                <a href="<?php echo admin_url( 'admin.php?page=auto-mail-campaign-wizard' ); ?>">
                    <button class="auto-mail-button auto-mail-button-blue"><?php esc_html_e( 'Create', Auto_Mail::DOMAIN ); ?></button>
                </a>
            </p>


        </div>

    </div>

<?php } ?>
