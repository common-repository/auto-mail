<?php
$template = isset( $_GET['template'] ) ? sanitize_text_field( $_GET['template'] ) : 'minimal';

$default_content = array(
    'minimal' => array(
        'feature_image' => AUTO_MAIL_URL . 'assets/images/form/default-minimal-feature.png',
        'main_title' => "Our Core Collection",
        'sub_title' => "Best of women's wear – 2020",
        'main_content' => "Discover this season’s new collection built around staple pieces and trend-focused items for women."
    ),
    'fashion' => array(
        'feature_image' => AUTO_MAIL_URL . 'assets/images/form/default-fashion-feature.png',
        'main_title' => "Spring Collection",
        'sub_title' => "Subscribe to get 10% discount for your purchase",
        'main_content' => "Discover this season’s new collection built around staple pieces and trend-focused items for women."
    ),
    'tech' => array(
        'feature_image' => AUTO_MAIL_URL . 'assets/images/form/default-tech-feature.png',
        'main_title' => "Request Beta",
        'sub_title' => "Join 50,000+ online store owners and marketers",
        'main_content' => "Discover a new way of shopping for furniture by downloading our AI-based App."
    ),
    'commerce' => array(
        'feature_image' => AUTO_MAIL_URL . 'assets/images/form/default-commerce-feature.png',
        'main_title' => "50% Off",
        'sub_title' => "Subscribe to our newsletter and get a discount",
        'main_content' => "Discover a new way of shopping for furniture by downloading our AI-based App."
    ),
    'black' => array(
        'feature_image' => AUTO_MAIL_URL . 'assets/images/form/default-black-feature.png',
        'main_title' => "Win $100",
        'sub_title' => "Subscribe to our newsletter to get a chance to win a $100 gift card",
        'main_content' => "Discover this season’s new collection built around staple pieces and trend-focused items for women."
    ),
    'stay' => array(
        'feature_image' => AUTO_MAIL_URL . 'assets/images/form/default-stay-feature.png',
        'main_title' => "Special Offer",
        'sub_title' => "Up to 30% off on all the items in online shop with coupon",
        'main_content' => "Discover a new way of shopping for furniture by downloading our AI-based App."
    ),
);

// Feature Image
$default_image = $default_content[$template]['feature_image'];
$empty_image = AUTO_MAIL_URL . 'assets/images/transparency.png';
if ( !empty( $settings['feature_image'] ) ) {
    $image_attributes = wp_get_attachment_image_src( $settings['feature_image'], 'full' );
    $src = $image_attributes[0];
    $feature_image = $settings['feature_image'];
} else {
    $src = $default_image;
    $feature_image = '';
}

?>
<div class="auto-mail-box-settings-row">

    <div class="auto-mail-box-settings-col-1">
        <span class="auto-mail-settings-label"><?php esc_html_e( 'Form Name', Auto_Mail::DOMAIN ); ?></span>
    </div>

    <div class="auto-mail-box-settings-col-2">

        <div>
            <input
                type="text"
                name="auto_mail_form_name"
                placeholder="<?php esc_html_e( 'Enter your Form Name here', Auto_Mail::DOMAIN ); ?>"
                value="<?php if(isset($settings['auto_mail_form_name'])){echo esc_attr($settings['auto_mail_form_name']);}?>"
                id="auto_mail_form_name"
                class="auto-mail-form-control"
                aria-labelledby="auto_mail_form_name"
            />
        </div>


    </div>

</div>

<div class="auto-mail-box-settings-row">

    <div class="auto-mail-box-settings-col-1">
        <span class="auto-mail-settings-label"><?php esc_html_e( 'Title', Auto_Mail::DOMAIN ); ?></span>
        <span class="auto-mail-description"><?php esc_html_e( 'Type a header which attracts attention or calls to action. You can leave this field empty.', Auto_Mail::DOMAIN ); ?></span>
    </div>

    <div class="auto-mail-box-settings-col-2">

        <div>
            <input
                type="text"
                name="auto_mail_main_title"
                placeholder="<?php esc_html_e( 'Enter your header title here', Auto_Mail::DOMAIN ); ?>"
                value="<?php if(isset($settings['auto_mail_main_title'])){echo esc_attr($settings['auto_mail_main_title']);}else{echo esc_attr($default_content[$template]['main_title']);}?>"
                id="auto_mail_main_title"
                class="auto-mail-form-control"
                aria-labelledby="auto_mail_main_title"
            />
        </div>


    </div>

</div>

<div class="auto-mail-box-settings-row">

    <div class="auto-mail-box-settings-col-1">
        <span class="auto-mail-settings-label"><?php esc_html_e( 'Sub Title', Auto_Mail::DOMAIN ); ?></span>
        <span class="auto-mail-description"><?php esc_html_e( 'Type a header which attracts attention or calls to action. You can leave this field empty.', Auto_Mail::DOMAIN ); ?></span>
    </div>

    <div class="auto-mail-box-settings-col-2">

        <div>
            <input
                type="text"
                name="auto_mail_sub_title"
                placeholder="<?php esc_html_e( 'Enter your sub title here', Auto_Mail::DOMAIN ); ?>"
                value="<?php if(isset($settings['auto_mail_sub_title'])){echo esc_attr($settings['auto_mail_sub_title']);}else{echo esc_attr($default_content[$template]['sub_title']);}?>"
                id="auto_mail_sub_title"
                class="auto-mail-form-control"
                aria-labelledby="auto_mail_sub_title"
            />
        </div>


    </div>

</div>

<div class="auto-mail-box-settings-row">

    <div class="auto-mail-box-settings-col-1">
        <span class="auto-mail-settings-label"><?php esc_html_e( 'Feature Image', Auto_Mail::DOMAIN ); ?></span>
        <span class="auto-mail-description"><?php esc_html_e( 'Type a message which will appear under the header.', Auto_Mail::DOMAIN ); ?></span>
    </div>

    <div class="auto-mail-box-settings-col-2">
            <img data-src="<?php echo esc_attr($empty_image); ?>" name="" class="am-feature-image" src="<?php echo esc_attr($src); ?>" />
            <div>
                <input type="hidden" name="feature_image" id="" value="<?php echo esc_attr($feature_image); ?>" />
                <button type="submit" class="am-upload-image-button button"><?php esc_html_e( 'Upload', Auto_Mail::DOMAIN ); ?></button>
                <button type="submit" class="am-remove-image-button button">&times;</button>
            </div>
    </div>

</div>

<div class="auto-mail-box-settings-row">

    <div class="auto-mail-box-settings-col-1">
        <span class="auto-mail-settings-label"><?php esc_html_e( 'Main Content', Auto_Mail::DOMAIN ); ?></span>
        <span class="auto-mail-description"><?php esc_html_e( 'Type a message which will appear under the header.', Auto_Mail::DOMAIN ); ?></span>
    </div>

    <div class="auto-mail-box-settings-col-2">

        <div class='auto-mail-form-wp-editor'>
            <?php
                $value = isset($settings['auto_mail_message']) ? $settings['auto_mail_message'] : $default_content[$template]['main_content'];
                wp_editor( $value, 'auto_mail_message', array(
                    'textarea_name' => 'auto_mail_message',
                    'wpautop' => false,
                    'teeny' => true,
                    'tinymce' => true
                ));
            ?>
        </div>


    </div>

</div>

<div class="auto-mail-box-settings-row">

    <div class="auto-mail-box-settings-col-1">
        <span class="auto-mail-settings-label"><?php esc_html_e( 'Button Text', Auto_Mail::DOMAIN ); ?></span>
        <span class="auto-mail-description"><?php esc_html_e( 'The text on the button. Call to action!', Auto_Mail::DOMAIN ); ?></span>
    </div>

    <div class="auto-mail-box-settings-col-2">

    <div>
            <input
                type="text"
                name="auto_mail_button_text"
                placeholder="<?php esc_html_e( 'Enter your button text here', Auto_Mail::DOMAIN ); ?>"
                value="<?php if(isset($settings['auto_mail_button_text'])){echo esc_attr($settings['auto_mail_button_text']);}?>"
                id="auto_mail_button_text"
                class="auto-mail-form-control"
                aria-labelledby="auto_mail_button_text"
            />
        </div>


    </div>

</div>
