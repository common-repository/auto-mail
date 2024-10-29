<?php
    $all_forms = Auto_Mail_Form_Model::model()->get_all_paged( $this->page_number, $limit );
?>

<?php if ( count($all_forms['models']) > 0 ) { ?>
    <?php foreach ( $all_forms['models'] as $key => $form ) : ?>
        <?php
            // Include template file
            include AUTO_MAIL_DIR . '/admin/views/front/template/'.$form->settings['template'].'.php';
        ?>
    <?php endforeach; ?>
<?php } ?>

