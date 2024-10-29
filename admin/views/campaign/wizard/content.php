<?php
$id = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
// Campaign Settings
$settings = array();
if(!empty($id)){
    $model    = $this->get_single_model( $id );
    $settings = $model->settings;
}
?>
<div class="auto-mail-box-tabs">
    <div id="auto-mail-select-setup" class="auto-mail-box-tab setup active">
    <?php $this->template( 'campaign/wizard/sections/tab-setup'); ?>
    </div>
    <div id="auto-mail-select-template" class="auto-mail-box-tab template">
        <?php $this->template( 'campaign/wizard/sections/tab-templates'); ?>
    </div>
    <div id="hi-react" class="auto-mail-box-tab design"></div>
    <div id="auto-mail-prepare-send" class="auto-mail-box-tab send">
        <form method="post" class="auto-mail-campaign-form">
            <?php $this->template( 'campaign/wizard/sections/tab-save'); ?>
            <?php $this->template( 'campaign/wizard/sections/tab-settings', $settings); ?>
            <input type="hidden" name="id" value="<?php echo esc_html($id); ?>">
        </form>
    </div>
</div>