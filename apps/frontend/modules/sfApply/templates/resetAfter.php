<?php use_helper('I18N') ?>

<?php echo $sf_response->setTitle('Apply Reset'); ?>

<div class="wiki-float-row"></div>
<div class="wiki-apply" style="text-align: left; padding: 20px;">
    <p>
    <?php echo __("Your password has been successfully reset. You are now logged
    in to this site. In the future, be sure to log in with your new password.") ?>
    </p>
    <?php include_partial('sfApply/continue') ?>
</div>
<div class="wiki-float-row"></div>