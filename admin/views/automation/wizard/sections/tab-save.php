<div class="am-automation-save-wrapper">
    <div class="auto-mail-delay-settings">
                        <h2><?php _e('Delay', Auto_Mail::DOMAIN); ?></h2>
                        <p><?php _e("Wait for a specified number of hours, days, or week before continuing.", Auto_Mail::DOMAIN); ?></p>
                        <div class="range-slider">
                            <input class="range-slider__range" type="range" value="<?php if(isset($settings['update_frequency'])){echo $settings['update_frequency'];}else{echo esc_html('100');}?>" min="0" max="500">
                            <span class="range-slider__value">0</span>
                        </div>

                        <div class="select-container">
                            <span class="dropdown-handle" aria-hidden="true">
                                <ion-icon name="chevron-down" class="robot-icon-down"></ion-icon>
                            </span>

                        <div class="select-list-container">
                            <button type="button" class="list-value" id="robot-field-unit-button" value="Minutes">
                                <?php
                                    if(isset($settings['update_frequency_unit'])){
                                        echo $settings['update_frequency_unit'];
                                    }else{
                                        esc_html_e( 'Minutes', Auto_Mail::DOMAIN );
                                }
                                ?>
                            </button>
                            <ul tabindex="-1" role="listbox" class="list-results robot-sidenav-hide-md" >
                                <li><?php esc_html_e( 'Minutes', Auto_Mail::DOMAIN ); ?></li>
                                <li><?php esc_html_e( 'Hours', Auto_Mail::DOMAIN ); ?></li>
                                <li><?php esc_html_e( 'Days', Auto_Mail::DOMAIN ); ?></li>
                            </ul>
                        </div>
                        </div>
                    </div>
    </div>
<div class="am-automation-save-buttons-wrapper">
<div class="am-automation-save-buttons">
        <div class="am-automation-save-left">
            <a href="#">
    	    <button type="submit" class="auto-mail-button auto-mail-button-gray">
                <?php esc_html_e( 'Save as Draft', Auto_Mail::DOMAIN ); ?>
            </button>
            </a>
        </div>
        <div class="am-automation-save-right">
            <a href="#" class="am-save-automation-button">
    	    <button type="submit" class="auto-mail-button auto-mail-button-blue">
                <?php esc_html_e( 'Save & Active', Auto_Mail::DOMAIN ); ?>
            </button>
            </a>
        </div>
</div>
</div>