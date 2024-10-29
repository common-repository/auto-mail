<?php
$templates = array(
    'minimal' => array(
        'thumbnail'   => AUTO_MAIL_URL.'assets/images/form/thumbnail/auto-mail-minimal.png',
        'label'       => '',
        'description' => ''
    ),
    'fashion' => array(
        'thumbnail'   => AUTO_MAIL_URL.'assets/images/form/thumbnail/auto-mail-fashion.png',
        'label'       => '',
        'description' => ''
    ),
    'commerce' => array(
        'thumbnail'   => AUTO_MAIL_URL.'assets/images/form/thumbnail/auto-mail-commerce.png',
        'label'       => '',
        'description' => ''
    ),
    'tech' => array(
        'thumbnail'   => AUTO_MAIL_URL.'assets/images/form/thumbnail/auto-mail-tech.png',
        'label'       => '',
        'description' => ''
    ),
    'black' => array(
        'thumbnail'   => AUTO_MAIL_URL.'assets/images/form/thumbnail/auto-mail-black.png',
        'label'       => '',
        'description' => ''
    ),
    'stay' => array(
        'thumbnail'   => AUTO_MAIL_URL.'assets/images/form/thumbnail/auto-mail-stay.png',
        'label'       => '',
        'description' => ''
    ),
);
?>
<div class="modal">
        <div class="modal-content am-form-template-modal">
            <span class="auto-mail-close-button">×</span>
            <div class="auto-mail-box-header auto-mail-block-content-center">
		<h3 class="auto-mail-box-title type-title"><?php esc_html_e( 'Choose a template', Auto_Mail::DOMAIN ); ?></h3>
	</div>

    <div class="auto-mail-box-body auto-mail-block-content-center">
        <p class="auto-mail-description">
            <?php esc_html_e( 'Select your new form template.', Auto_Mail::DOMAIN ); ?>
        </p>
    </div>
    <div id="template-popup">

    <div class="auto-mail-box-body hui-templates-wrapper ">
        <div class="hui-templates">
            <?php foreach ( $templates as $template_name => $data ) { ?>
            <div class="hui-template-card" tabindex="0">
                <div class="hui-template-card--image" aria-hidden="true">
                    <img src="<?php echo esc_url( $data['thumbnail'] );?>" aria-hidden="true">
                    <div class="hui-template-card--mask" aria-hidden="true"></div>
                </div>
                <h4><?php echo esc_html($template_name);?></h4>
                <p class="hui-screen-reader-highlight" tabindex="0"><?php esc_html_e( 'Tailored to promote your seasonal offers in a modern layout.', Auto_Mail::DOMAIN ); ?></p>
                <button class="auto-mail-button auto-mail-button-blue am-template-select-button" aria-label="Build from Minimalist template" data-template="<?php echo esc_attr( $template_name );?>">
                    <?php esc_html_e( 'Choose Template', Auto_Mail::DOMAIN ); ?>
                </button>
            </div>
            <?php } ?>
        </div>
    </div>
    </div>

	<div class="auto-mail-box-footer">
	</div>
        </div>
    </div>