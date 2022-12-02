<?php use_helper('I18N') ?>

<div class="wiki-float-row"></div>
<div class="wiki-apply" style="text-align: left; padding: 20px;">  

    <?php echo include_partial('sfApply/form', array('form' => $form,
        'departmentForm' => $departmentForm, 'courseForm' => $courseForm,
        'show_graduation_info_fields' => $show_graduation_info_fields,
        'type' => $userRegType));?>

</div>
<div class="wiki-float-row"></div>
