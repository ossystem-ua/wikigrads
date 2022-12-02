<?php echo $form->renderFormTag(url_for('@user_edit'), array(
    'id' => 'form_user_edit',
)); ?>

    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form->renderHiddenFields() ?>
    
    <div id="profileImageContainer" style="<?php if ($emails == 1){ echo "display: none;"; }?>">
        <?php echo $form['image']->render(array(
        	'id' => 'file',
            'data-upload-feedback' => 'Update profile pic...'
        )) ?>
        <?php echo $form['image']->renderError() ?>
    </div>
    
    <?php if(!$form->getObject()->getIsStaff()):?>
        <?php foreach ($form->getObject()->getUser()->getSchools() as $school): ?>
            <?php $form_name = $school->getUserSchoolFormName(); ?>	
            <?php if (isset($form[$form_name])): ?>
                <div class="clear-float">
                <?php include_partial('formUserSchoolEdit', array(
                        'form' => $form[$form_name] 
                )); ?>
            </div>    
            <?php endif; ?>
            <?php break; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <div style="margin-top:20px; <?php if ($emails == 1){ echo "display: none;"; }?>">
        <?php echo $form['about']->renderLabel() ?>
        <?php echo $form['about']->render() ?>
        <?php echo $form['about']->renderError() ?>
    </div>
    <div style="<?php if ($emails == 1){ echo "display: none;"; }?>">
        <?php echo $form['activity']->renderLabel('Interests') ?>
        <?php echo $form['activity']->render() ?>
        <?php echo $form['activity']->renderError() ?>
    </div>
    <?php if ($emails == 1): ?>
        <table style="margin-left: 70px;">
            <?php if($IsStaff): ?>
            <tr>
                <td><label>Enter a code in order to join your class</label></td>
                <td><?php echo $form['enter_code']->render() ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td><label>E-mail all posts in my courses</label></td>
                <td><?php echo $form['email_post']->render() ?></td>
            </tr>
            <tr>
                <td><label>Only e-mail replies to my posts</label></td>
                <td><?php echo $form['email_reply']->render() ?></td>
            </tr>
            <tr>
                <td><label>No e-mails from WikiGrads</label></td>
                <td><?php echo $form['email_from']->render() ?></td>
            </tr>
        </table>
    <?php endif; ?>
    <div class="actions" style="<?php if ($emails == 1) { echo "float:right;margin-top:-60px;"; }?>">
        <input  <?php if ($emails != 1) {?>style="margin-top: 20px;"<?php } ?> type="image" src="<?php if ($emails == 1) { echo image_path('btn-done.png'); } else { echo image_path('btn-save-changes.png'); } ?>" />
    </div>
</form>
