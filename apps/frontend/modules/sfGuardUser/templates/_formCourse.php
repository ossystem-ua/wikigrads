<div id="wg-edit-course-box" class="join-course-box editbox">
    <!--<span class="editbox-title">Add a course by first selecting the department, then selecting the class. Click "Add course" button when done.</span>-->
    <div class="custom-select add-course float-l">
        <?php echo $form['department_id']->render(array(
            'id' => 'wiki-sel-dep',
            'data-url' => url_for('@course_add')
        )); ?>
    </div>
    <?php if (isset($form['course_id'])): ?>
    <div class="custom-select class-select float-l">
        <?php echo $form['course_id']->render(); ?>
    </div>
    <?php endif; ?>
    <div class="clear"></div>
    <div class="editbox-control">
        <button id="wg-cancel-button-1" class="cansel-course-box float-r cancel-button" type="button">Cancel</button>
	<button data-con="wg-cancel-button-1" class="add-new-course float-r wg-form-add-course" type="button">Join</button>
	<div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
