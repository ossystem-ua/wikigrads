<?php use_helper('I18N') ?>
<?php //slot('sf_apply_login')  ?>
<?php //end_slot()  ?>

<?php echo $sf_response->setTitle('Password Reset'); ?>

<div class="wiki-float-row"></div>
<div class="wiki-apply" style="text-align: left; padding: 20px;">

    <form method="POST" action="<?php echo url_for("sfApply/reset") ?>" name="sf_apply_reset_form" id="sf_apply_reset_form">
        <p>
            <?php echo __("Thanks for confirming your email address. You may now change your password using the form below."); ?>
        </p>
        
        <ul>
        <?php echo $form ?>
        <li class="reset-button">
            <div>
                <input type="submit" class="rst-btn" value="<?php echo __("Reset My Password") ?>">
                <?php //echo __("or") ?>
                <?php echo link_to(__('Cancel'), 'sfApply/resetCancel', array('class'=>'cncl-rst-btn')) ?>
            </div>
        </li>
        </ul>

    </form>
</div>
<div class="wiki-float-row"></div>
