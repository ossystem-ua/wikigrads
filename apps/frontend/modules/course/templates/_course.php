<?php if ($sf_user->getGuardUser() instanceof sfOutputEscaper) : ?>
    <?php $sf_guard_user = $sf_user->getGuardUser()->getRawValue() ?>
<?php else : ?>
    <?php $sf_guard_user = $sf_user->getGuardUser() ?>
<?php endif; ?>

<?php if ($user instanceof sfOutputEscaper) : ?>
    <?php $user = $user->getRawValue() ?>
<?php endif; ?>

<div class="entry-head clear-float">
    <div class="course-name"><?php echo $course->name ?></div>
    <div class="remove-course">
        <?php if (!isset($remove) || (isset($remove) && $remove != false)) : ?>
            <?php if ($sf_guard_user->id == $user->id) : ?>
                <?php echo content_tag('a', 'remove course', array(
                    'data-url' => url_for('@ajax_course_delete?id='.$course->id),
                    'class' => 'course-delete course-action',
                )) ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php if ($course->name == $course->category): ?>
<div class="course-list-line">
    <span class="label">type: </span>
    <span class="value">group</span>
</div>
<div class="course-list-line">
    <span class="label">course code: </span>
    <span class="value">-</span>
</div>
<div class="course-list-line">
    <span class="label">department: </span>
    <span class="value">-</span>
</div>
<?php else: ?>
<div class="course-list-line">
    <span class="label">type: </span>
    <span class="value">course</span>
</div>
<div class="course-list-line">
    <span class="label">course code: </span>
    <span class="value"><?php echo $course->code ?></span>
</div>
<div class="course-list-line">
    <span class="label">department: </span>
    <span class="value"><?php echo $course->Department->name ?></span>
</div>
<?php endif; ?>
