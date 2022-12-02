
    <!--<span class="editbox-title">Add a course by first selecting the department, then selecting the class. Click "Add course" button when done.</span>-->
    <div class="custom-select add-course float-l">
        <?php echo $form['department_id']->render(array(
            'id' => 'wiki-sel-dep',
            'data-url' => url_for('@course_add')
        )); ?>
    </div>
    <?php if (isset($form['course_id'])): ?>
    <div class="custom-select add-course float-l">
        <?php echo $form['course_id']->render(array(
            'id' => 'wiki-sel-course'
        )); ?>
    </div>
    <?php endif; ?>
    <div class="clear"></div>
    <div class="editbox-control">
        <button id="wg-cancel-button-3" class="cansel-course-box float-r cancel-button" type="button">Cancel</button>
	<button data-con="wg-cancel-button-3" class="add-new-course float-r wg-form-add-course" type="button">Join</button>
	<div class="clear"></div>
    </div>
    <div class="clear"></div>









<?php /*
<?php echo $form->renderFormTag(url_for('@course_add'), array(
    'id' => 'form-course-add',
    'class' => 'global-form-style'
)); ?>

    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form->renderHiddenFields() ?>
    
    <h2>
    <?php if($stepNum == 1): ?>
      Select a department
    <?php elseif($stepNum == 2): ?>
      Next, select the class and click &quot;Add Course&quot;    
    <?php endif; ?>  
    </h2>
    <?php if($stepNum > 0): ?>
    <div class="clear-float">
        <div class="select-container">
            <?php echo $form['department_id']->render(); ?>
            <?php echo $form['department_id']->renderError() ?>
        </div>        
        
        <?php if (isset($form['course_id'])) : ?>
        <div class="select-container">
            <?php echo $form['course_id']->render(); ?>
            <?php echo $form['course_id']->renderError() ?>            
        </div>
            <?php if ($access == 1): ?>
            <div class="select-container block-hide" id="block-hide-0">
                <?php echo $form['access']->render(); ?>
                <?php echo $form['access']->renderError() ?>            
            </div>
            <?php endif; ?> 
        <?php endif; ?>     
                
        <?php if($stepNum == 2): ?>
        <div class="clear-float" style="text-align: right;">            
            <input id="btn-add-course" type="image" style="float: right;" value="submit" src="<?php echo image_path('btn-addacourse.png') ?>" />
        </div>
        <?php endif; ?> 
    </div> 

    <!---->
    <h2>or select group</h2>
    <div class="clear-float">
        <div class="select-container">
            <?php echo $form['category']->render(); ?>
            <?php echo $form['category']->renderError() ?>
        </div>
        <div class="clear-float" style="text-align: right;">            
            <input id="btn-add-course" type="image" style="float: right;" value="submit" src="<?php echo image_path('btn-done.png') ?>" />
        </div>
    </div>
    <!---->
    <?php endif; ?>
</form>
*/?>