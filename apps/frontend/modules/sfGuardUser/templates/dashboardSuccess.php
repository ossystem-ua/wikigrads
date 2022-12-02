<?php
    $routeName    = $sf_context->getInstance()->getRouting()->getCurrentRouteName();
?>

<?php if ($routeName == 'dashboard'): ?>
<div class="wiki-inwork">
    <!--Main dashboard page - in work!-->
    <?php if ($first_user_course > 0): ?>
        <script>window.location.href = '<?php echo url_for('@notification_course_list?type=course&slug='.$first_user_course); ?>';</script>
    <?php else: ?>
        <script>window.location.href = '<?php echo url_for('@my_profile'); ?>';</script>
    <?php endif; ?>
</div>

<?php else: ?>

<div id="dashboard">
    <div class="content-inputarea">
        <?php include_partial('post/dashboardPostForm', array(
            'form' => $form,
            'isStaff' => $isStaff,
            'formdoc' => $form
        ))?>
    </div>

    <div id="notification-tabs">
        <?php
            include_partial('sfGuardUser/nav', array('courses' => $courses, 'counters' => $counters, 'isStaff' => $isStaff));
        ?>
    </div>
</div>

<?php endif; ?>