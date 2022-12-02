<?php use_helper('I18N') ?>
<?php $is_error = $sf_user->hasFlash('login_error') ?>

<div id="wiki-login">
    <form method="POST" action="<?php echo url_for("@homepage") ?>" name="sf_guard_signin" id="sf_guard_signin" class="sf_apply_signin_inline">
        <?php echo $form->renderGlobalErrors(); ?>
        <?php echo $form->renderHiddenFields(); ?>
        
        <div class="wiki-form-col">
            <div class="wiki-input-keep">
                <?php echo $form['remember']->render(array()); ?>
                <?php echo $form['remember']->renderLabel('Keep me logged in') ?>
                <?php echo $form['remember']->renderError()?>
            </div>
            <div class="wiki-input-login">
            <?php echo $form['username']->render(array(
                $defaultval = "Username",
                'class' => 'shade '.($form['username']->hasError() ? 'form-error' : ''),
                'value' => $defaultval,                
                'onfocus' => 'formFieldFocus(this,"'.$defaultval.'",0)',
                'onblur' => 'formFieldBlur(this,"'.$defaultval.'",0)',
                'tabindex' => 1
            )); ?>
            </div>
        </div>
        
        <div class="wiki-form-col">
            <div class="wiki-input-forgot">
                <?php echo link_to(__('Forgot Your Password?'), '@forgot')  ?>
            </div> 
            <div class="wiki-input-password">
            <?php
                $defaultval = "Password";
                echo $form['password']->render(array(
                    'type'  => 'password',
                    'placeholder' => $defaultval,
                    'autocomplete' => 'true',
                    'class' => 'shade '.($form['password']->hasError() ? 'form-error' : ''),
                    'value' => '',
                    'onfocus' => 'formFieldFocus(this,"'.$defaultval.'",1)',
                    'onblur' => 'formFieldBlur(this,"'.$defaultval.'",1)',
                    'tabindex' => 2
                )); 
            ?>
            </div>
        </div>
        <div class="wiki-form-col wiki-center">
            <div class="wiki-input-forgot wiki-hide-1" id="wiki-clear-row">&nbsp;</div>
            <div class="wiki-arrow-right">
                <input type=image value="<?php echo __('sign in') ?>" src="<?php echo image_path("new_design/lg-btn.png")?>" id="loginbutton" />
            </div>
        </div>
    </form>
</div>
