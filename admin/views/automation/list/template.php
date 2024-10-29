
<?php
$templates = array(
    'Abandoned Cart Reminder' => array(
        'type'        => 'cart',
        'title'       => 'Abandoned Cart Reminder',
        'description' => 'A simple 3-part abandoned cart reminder sequence with well-planned to delays to recover more carts.',
        'template'    => 'abandoned-cart'
    ),
    'Abandoned Cart Reminder Pro' => array(
        'type'        => 'cart',
        'title'       => 'Abandoned Cart Reminder Pro',
        'description' => 'A simple abandoned cart reminder sequence of 3 emails that are sent to the users based on the cart total.',
        'template'    => 'abandoned-cart-pro'
    ),
    'Abandoned Cart Reminder Pro' => array(
        'type'        => 'cart',
        'title'       => 'Abandoned cart (Per Product)',
        'description' => 'A customized abandoned cart recovery sequence for a specific product in user cart.',
        'template'    => 'abandoned-cart-per-product'
    ),
    'Discount for Next Purchase (Post-Purchase)' => array(
        'type'        => 'customer',
        'title'       => 'Discount for Next Purchase (Post-Purchase)',
        'description' => 'A simple post-purchase sequence based on their order total for providing a special discount coupon for their next purchase.'
    ),
    'New Customer - First Order' => array(
        'type'        => 'customer',
        'title'       => 'New Customer - First Order',
        'description' => 'Give a special welcome to your first-time customers through this email.'
    ),
    'Specific Product Education (Post-Purchase)' => array(
        'type'        => 'customer',
        'title'       => 'Specific Product Education (Post-Purchase)',
        'description' => 'A simple product education email that teaches the customer about a specific product that they have purchased.'
    ),
    'Customer WinBack Campaign (With Coupon)' => array(
        'type'        => 'customer',
        'title'       => 'Customer WinBack Campaign (With Coupon)',
        'description' => 'Win back lapsed customers with a discount coupon code and incentivize their purchase.'
    ),
    'Customer WinBack Campaign (Without Coupon)' => array(
        'type'        => 'customer',
        'title'       => 'Customer WinBack Campaign (Without Coupon)',
        'description' => 'A simple condition-based winback sequence to ask for the reason of inactivity and get suggestions to make things better.'
    ),
    'First Purchase Anniversary' => array(
        'type'        => 'customer',
        'title'       => 'First Purchase Anniversary',
        'description' => 'Congratulate customers on their first anniversary and offer them a celebratory offer (a discount coupon code) for next purchase.'
    ),
    'Incentivize Next Purchase' => array(
        'type'        => 'customer',
        'title'       => 'Incentivize Next Purchase',
        'description' => 'Send email to a customer after their purchase thanking them and offering a discount for their next purchase.'
    ),
    'WC Subscription Before Renewal' => array(
        'type'        => 'subscription',
        'title'       => 'WC Subscription Before Renewal',
        'description' => 'Inform users about an upcoming auto-renewal to minimize refunds or chargebacks.'
    ),
    'WC Subscription Renewal Payment Failed' => array(
        'type'        => 'subscription',
        'title'       => 'WC Subscription Renewal Payment Failed',
        'description' => 'Deliver failed payment notice and request payment information update with this sequence.'
    ),
    'WC Subscription Card About To Expire' => array(
        'type'        => 'subscription',
        'title'       => 'WC Subscription Card About To Expire',
        'description' => 'Reach out with timely reminders to change the card on file and facilitate charge.'
    ),
    'Review Collection Email (Post-Purchase)' => array(
        'type'        => 'reviews',
        'title'       => 'Review Collection Email (Post-Purchase)',
        'description' => 'Ask for a review on a purchase made a defined time period ago using this automated email. Reviews help boost brand credibility.'
    ),
);
?>
<div class='am-automation-template-wrap wp-osprey-hide-form-builder'>
<section class="private-template__section private-template__section--header">
        <div class="private-tool-bar private-tool-bar--dark" role="group">
            <div class="private-tool-bar__inner">
                <div class="private-tool-bar__group has--horizontal-spacing">
                    <nav role="navigation" class="private-breadcrumbs private-back-button private-breadcrumbs--no-wrap">
                    <a id="back-button" class="am-automation-template-close private-link private-link--on-dark private-breadcrumbs__item" href="#">
                        <span>
                            <ion-icon name="chevron-back-outline" class="wp-osprey-icon-back"></ion-icon>
                            <?php esc_html_e( 'Back to Automations', Auto_Mail::DOMAIN ); ?>
                        </span>
                    </a>
                    </nav>
                </div>
                <div class="private-tool-bar__group has--horizontal-spacing"></div>
                <div class="private-tool-bar__group has--horizontal-spacing">
                    <button class="am-automation-template-next private-button private-button--primary private-button--default private-button--non-link" type="button">
                            <?php esc_html_e( 'Next', Auto_Mail::DOMAIN ); ?>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="cd-slider-wrapper">
            <ul class="cd-slider">
                <li class="robot-slide visible robot-first-slide">
                    <div id="wp-osprey-form-type">
                        <h2><?php _e('Form Type', Auto_Mail::DOMAIN); ?></h2>
                        <p><?php _e('Choose your form type', Auto_Mail::DOMAIN); ?></p>
                        <div class="container filtering">
    <ul class="nav nav-pills nav-filter-cat">
        <li><button class="am-template-filter cat-all"><?php _e('All', Auto_Mail::DOMAIN); ?></button></li>
        <li><button class="am-template-filter" data-cat="cart"><?php _e('Cart', Auto_Mail::DOMAIN); ?></button></li>
        <li><button class="am-template-filter" data-cat="customer"><?php _e('Customer', Auto_Mail::DOMAIN); ?></button></li>
        <li><button class="am-template-filter" data-cat="subscription"><?php _e('Subscription', Auto_Mail::DOMAIN); ?></button></li>
        <li><button class="am-template-filter" data-cat="reviews"><?php _e('Reviews', Auto_Mail::DOMAIN); ?></button></li>
    </ul>
</div>
                            <div class="hui-templates filter-cat-results">
                                <?php foreach ( $templates as $template_name => $data ) { ?>
                                    <div class="hui-template-card f-cat active" data-template="<?php echo esc_html($data['template']); ?>" data-cat="<?php echo esc_html($data['type']); ?>">
                                        <span class="private-big">
                                            <?php echo esc_html($data['title']); ?>
                                        </span>
                                        <div>
                                            <small>
                                                <?php echo esc_html($data['description']); ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                    </div>
                </li>


            </ul> <!-- .cd-slider -->

            <div class="cd-svg-cover" data-step1="M1402,800h-2V0.6c0-0.3,0-0.3,0-0.6h2v294V800z" data-step2="M1400,800H383L770.7,0.6c0.2-0.3,0.5-0.6,0.9-0.6H1400v294V800z" data-step3="M1400,800H0V0.6C0,0.4,0,0.3,0,0h1400v294V800z" data-step4="M615,800H0V0.6C0,0.4,0,0.3,0,0h615L393,312L615,800z" data-step5="M0,800h-2V0.6C-2,0.4-2,0.3-2,0h2v312V800z" data-step6="M-2,800h2L0,0.6C0,0.3,0,0.3,0,0l-2,0v294V800z" data-step7="M0,800h1017L629.3,0.6c-0.2-0.3-0.5-0.6-0.9-0.6L0,0l0,294L0,800z" data-step8="M0,800h1400V0.6c0-0.2,0-0.3,0-0.6L0,0l0,294L0,800z" data-step9="M785,800h615V0.6c0-0.2,0-0.3,0-0.6L785,0l222,312L785,800z" data-step10="M1400,800h2V0.6c0-0.2,0-0.3,0-0.6l-2,0v312V800z">
                <svg height='100%' width="100%" preserveAspectRatio="none" viewBox="0 0 1400 800">
                <title><?php _e('SVG cover layer', Auto_Mail::DOMAIN); ?></title>
                <desc><?php _e('an animated layer to switch from one slide to the next one', Auto_Mail::DOMAIN); ?></desc>
                <path id="cd-changing-path" d="M1402,800h-2V0.6c0-0.3,0-0.3,0-0.6h2v294V800z"/>
                </svg>
            </div>  <!-- .cd-svg-cover -->
    </section> <!-- .cd-slider-wrapper -->
</div>


