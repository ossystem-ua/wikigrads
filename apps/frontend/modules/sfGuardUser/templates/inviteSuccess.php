<?php use_helper('I18N') ?>
<div class="wiki-float-row"></div>
<div class="wiki-body-content">
    <h3>Invite Someone To WikiGrads</h3>
    <?php exit("Send invite!"); ?>
    <?php echo $form->renderFormTag(url_for('@user_invite'), array(
        'class' => 'global-form-style',
        'id' => 'wiki-invite-form')); ?>
        <?php echo $form->renderGlobalErrors(); ?>
        <?php echo $form->renderHiddenFields(); ?>

        <table class="wiki-ivite-table">
            <tr>
                <td>
                    <?php
                    $defaultval = "Recipient's name";
                    echo $form['full_name']->render(array(
                        'value' => $defaultval,
                        'onfocus' => 'formFieldFocus(this,"'.$defaultval.'",0)',
                        'onblur' => 'formFieldBlur(this,"'.$defaultval.'",0)',
                        'class' => 'wg-invite-input'
                    )); ?>
                </td>
                <td>
                    <?php 
                    $defaultval = "Recipient's email";
                    echo $form['email_address']->render(array(
                        'value' => $defaultval,
                        'onfocus' => 'formFieldFocus(this,"'.$defaultval.'",0)',
                        'onblur' => 'formFieldBlur(this,"'.$defaultval.'",0)',
                        'class' => 'wg-invite-input'
                    )); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form['full_name']->renderError(); ?></td>
                <td><?php echo $form['email_address']->renderError(); ?></td>
            </tr>
        </table>
        <div class="wiki-float-row-2"></div>
        <div class="wiki-block">
            <?php echo $form['message']->render(array(
                'class' => 'wg-edit-area wg-invite-area',
            )); ?>   
            <?php echo $form['message']->renderError(); ?>
        </div>
        
        <div class="wiki-right">
            <a class="wg-post-button-edit href-cursor" OnClick="onClickObject('wg-invite-submit');" title="Send">Send</a>
        </div>
    
        <div style="display: none;">
            <input type="image" value="Send" id="wg-invite-submit" src="<?php echo image_path('btn-invite.png')?>">
        </div>
    </form>
</div>
<div class="wiki-float-row"></div>
