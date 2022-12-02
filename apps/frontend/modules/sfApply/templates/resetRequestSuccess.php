<?php use_helper('I18N') ?>

<?php echo $sf_response->setTitle('Retrieve Password'); ?>
<div id="wiki-form-registration">
    <div class="wiki-caption-1">
        <span class="wg-text-forgot">Forgot your password?</span> 
        <span class="wg-text-noproblem">No problem!</span>
        <p class="wg-text-paragraph">You will receive an email message containing a link permitting</p>
        <p class="wg-text-paragraph">you to change your password.</p>
        <p class="wg-text-didnt">Didn't get an email yet?</p>
        <div class="wiki-clear"></div>
    </div>
    <div class="wiki-form-reg">
        <?php  echo $form->renderFormTag(url_for('sfApply/resetRequest'), array('class' => 'global-form-style')); ?>
            <?php echo $form->renderGlobalErrors(); ?>
            <?php echo $form->renderHiddenFields(); ?>
        
            <div class="wiki-block wiki-width-forgot wiki-center">
                <?php echo $form['username_or_email']->renderError(); ?>
                <?php 
                $defaultval = "E-Mail";
                echo $form['username_or_email']->render(array(
                    'class' => 'wiki-width-forgot-input default-value '.($form['username_or_email']->hasError() ? ' form-error' : ''),
                    'placeholder' => 'E-Mail',
                    'value' => $defaultval,
                    'type'  => 'text',
                    'onfocus' => 'formFieldFocus(this,"'.$defaultval.'",1)',
                    'onblur' => 'formFieldBlur(this,"'.$defaultval.'",1)'
                )); 
                ?> 
        
                <div class="wiki-clear"></div>
                <div class="wiki-block wiki-width-forgot-button">
                    <a href="" OnClick="onSubmitForm('#resetbutton'); return false;">Reset my password</a>
                </div>
                <div class="wiki-clear"></div>
            </div>
            <div class="wiki-none">
                <input type="image" value="<?php echo __("Submit") ?>" src="<?php echo image_path("btn-resetpassword.png");?>" id="resetbutton" style="margin-right: 10px;">
                <?php echo link_to(image_tag('btn-cancel.png', array("id" => "cancelbutton")), sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>
            </div>
        </form>
    </div>    
</div>

            

    






<?/*
<div id="forgotform" class="content-pad">

    <div class="chatty-2">
        <p class="important" style="font-size: 16px;">
            Forgot your password? No problem! Just enter your email address and click "Reset My Password."
            You will receive an email message containing a link permitting you to change your password if you wish.
        </p>
    </div>

    <?php  echo $form->renderFormTag(url_for('sfApply/resetRequest'), array('class' => 'global-form-style')); ?>
        <?php echo $form->renderGlobalErrors(); ?>
        <?php echo $form->renderHiddenFields(); ?>
        <div class="apply-field">
            <div><?php echo $form['username_or_email']->renderLabel('Email Address');?></div>
            <div id="applyfirst" class="grey-input">

                <?php echo $form['username_or_email']->render(array(
                    'class' => 'default-value '.($form['username_or_email']->hasError() ? ' form-error' : '')
                )); ?>  
            </div>
            <?php echo $form['username_or_email']->renderError(); ?>

        </div>    

        <div class="submit-btn">
            <input type="image" value="<?php echo __("Submit") ?>" src="<?php echo image_path("btn-resetpassword.png");?>" id="resetbutton" style="margin-right: 10px;">
            <?php echo link_to(image_tag('btn-cancel.png', array("id" => "cancelbutton")), sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>
        </div>
    </form>
</div>
*/
?>