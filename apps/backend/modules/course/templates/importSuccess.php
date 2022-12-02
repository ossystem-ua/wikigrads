<?php use_helper('I18N', 'Date') ?>

<?php include_partial('course/flashes') ?>

<?php include_partial('course/formCourseImport', array(
    'form' => $form,
    'errors' => $errors,
    'imported_count' => $imported_count
)); ?>