<?php
$templates = array(
    'restaurant' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/restaurant.png',
        'description' => 'Restaurant',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/restaurant.png'
    ),
    'black' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/black.png',
        'description' => 'Black Friday',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/black.png'
    ),
    'hotel' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/hotel.png',
        'description' => 'Hotel',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/hotel.png'
    ),
    'tech' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/tech.png',
        'description' => 'Tech',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/tech.png'
    ),
    'fashion' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/fashion.png',
        'description' => 'Fashion',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/fashion.png'
    ),
    'business' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/business.png',
        'description' => 'Business',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/business.png'
    ),
    'travel' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/travel.png',
        'description' => 'Travel',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/travel.png'
    ),
    'estate' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/estate.png',
        'description' => 'Real Estate',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/estate.png'
    ),
    'music' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/music.png',
        'description' => 'Music',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/music.png'
    ),
    'lawyer' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/lawyer.png',
        'description' => 'Lawyer',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/lawyer.png'
    ),
    'drones' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/drones.png',
        'description' => 'Drones',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/drones.png'
    ),
    'store' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/store.png',
        'description' => 'Store',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/store.png'
    ),
    'interior' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/interior.png',
        'description' => 'Interior',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/interior.png'
    ),
    'charity' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/charity.png',
        'description' => 'Charity',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/charity.png'
    ),
    'hairstyle' => array(
        'image'       => AUTO_MAIL_URL . '/assets/images/template/hairstyle.png',
        'description' => 'Hairstyle',
        'preview' => AUTO_MAIL_URL . '/assets/images/template/hairstyle.png'
    ),
);

$free_version = array('restaurant', 'black', 'hotel');
?>
<div>
    <div class="auto-mail-templates">
        <?php foreach ( $templates as $template_name => $data ) { ?>
            <div class="hui-template-card" tabindex="0">
                <img class="hui-template-image auto-mail-popup-preview" data-template="<?php echo $template_name; ?>" src="<?php echo $data['image']; ?>" alt="<?php echo $data['description']; ?>">
                <div class="hui-template-info">
                    <h5 class="mailpoet-h5" title="<?php echo $data['description']; ?>"><?php echo $data['description']; ?></h5>
                        <button class="auto-mail-button auto-mail-button-blue <?php echo esc_attr(auto_mail_template_class($template_name)); ?>" data-template="<?php echo $template_name; ?>">
                            <span>
                                <?php
                                    if(in_array($template_name, $free_version)){
                                        esc_html_e( 'Free Version', Auto_Mail::DOMAIN );
                                    }else{
                                        esc_html_e( 'Pro Version', Auto_Mail::DOMAIN );
                                    }
                                ?>
                            </span>
                        </button>
                </div>
                <div class="modal <?php echo $template_name; ?>">
                    <div class="modal-content modal-content-preview">
                        <span class="auto-mail-close-button">×</span>
                        <img class="hui-template-preview" src="<?php echo $data['preview']; ?>" class="" alt="<?php echo $data['description']; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>