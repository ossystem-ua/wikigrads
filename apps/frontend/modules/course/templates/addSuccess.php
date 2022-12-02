<div id="edit-courses">
    <div class="content-inputarea">
        <div class="add-course-form border-radius-5">
            <?php include_partial('formAdd', array('stepNum'=>$stepNum, 'form' => $form)) ?>
        </div>
<?php if($isAddAnother): ?>
        <div id="finished" class="clear-float">
            <hr>
            <h2>If you are done adding classes, click 'Finished' to return to your profile.</h2>
            <div class="r-float">
                <?php echo link_to(image_tag('btn-finished.png'), '@my_profile'); ?>
            </div>
        </div>
<?php endif; ?>
    </div>
    
    <div class="content-pad">
        <?php include_component('course', 'list') ?>
    </div>
</div>