<div id="edit-courses">
    <?php if ($sf_user->getGuardUser()->id == $user->id) : ?>
        <div class="content-inputarea">
              <div class="r-align">
                    <?php echo link_to(image_tag('btn-addacourse.png'), '@course_add'); ?>
              </div>
        </div>
    <?php endif; ?>

    <div class="content-pad">
        <?php include_component('course', 'list') ?>
    </div>
</div>
