<?php echo $form->renderFormTag(url_for('@ajax_post_add'), array(
    'id' => 'form-post-add',
)) ?>

    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form->renderHiddenFields() ?>
    <?php echo $form['content']->renderError() ?>
    
    <div id="post-form-widget" class="mode-ev1">
        <?php echo $form['content']->render(array('value'=>'post a message to all students in your class')) ?>
        <div id="class-selector">
            <a href="#" class="on"></a>
        </div>
        <div id="groups-selector"><a href="#"></a></div>
        </div>        
    <input type="image" src="<?php echo image_path('btn-post-comment.png') ?>" />
        
    <div style="margin-top:20px">
        <?php echo $form['course_id']->render() ?>
        <?php echo $form['type']->render() ?>
    </div>
    
</form>
