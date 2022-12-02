<?php use_helper('I18N') ?>

<div class="document-header">
    <h3><?php echo __('Upload a Document') ?></h3>
    
    <div id="document-upload-button" class="expand href-cursor" style="<?php echo $form->hasErrors() ? 'display: none;': ''?>">
        <?php echo image_tag("btn-upload.png"); ?>
    </div>
    
</div>
<?php print_r($courseId); ?>
<div id="form-document" class="shadowBox" style="">
    <?php echo $form->renderFormTag(url_for('@document'), array(
            'id' => 'form-document-add',
            'class' => 'global-form-style',
            'style' => $form->hasErrors() ? '' : ''
            
            
    )) ?>

        <?php echo $form->renderGlobalErrors() ?>
        <?php echo $form->renderHiddenFields() ?>
    
        <div id="document-field-file">
            <!--?php echo $form['file']->renderLabel('Document:', array()); ?-->
            <?php echo $form['file']->render(array(
                'class' => ($form['file']->hasError() ? 'form-error' : '').' default-value',
                'value' => 'File',
                'id' => 'file',
                'data-upload-feedback' => 'Browse file...'
            )); ?>
            <?php echo $form['file']->renderError(); ?>
        </div>

        <div id="document-field-course">
            <?php echo $form['course_id']->render(array('value' => $courseId)); ?>
            <?php echo $form['course_id']->renderError(); ?>                
        </div>

        <div id="document-submit-btn">
            <input type="image" value="Submit" src="<?php echo image_path("btn-upload.png")?>" />
        </div>
    
        <div id="document-field-description" style="float: right;margin-right: 372px;">
            <?php echo $form['description']->render(array(
                    'class' => ($form['description']->hasError() ? 'form-error' : '').' default-value',
                )); ?> 
            <?php echo $form['description']->renderError(); ?>            
        </div>
        
    </form>

</div>
