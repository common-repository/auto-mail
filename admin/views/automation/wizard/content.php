<?php
$id = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
// Campaign Settings
$settings = array();
if(!empty($id)){
    $model    = $this->get_single_model( $id );
    $settings = $model->settings;
}
?>
<form method="post" class="auto-mail-automation-form">
<div class="auto-mail-box-tabs">
    <div id="auto-mail-select-setup" class="auto-mail-box-tab setup active">
        <?php $this->template( 'automation/wizard/sections/tab-setup', $settings); ?>
    </div>
    <div id="auto-mail-select-actions" class="auto-mail-box-tab actions">
        <?php $this->template( 'automation/wizard/sections/tab-actions', $settings); ?>
    </div>
    <div id="auto-mail-prepare-save" class="auto-mail-box-tab save">
        <?php $this->template( 'automation/wizard/sections/tab-save', $settings); ?>
    </div>
</div>
<input type="hidden" name="id" value="<?php echo esc_html($id); ?>">
</form>