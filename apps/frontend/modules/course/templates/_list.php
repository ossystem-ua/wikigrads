<div id="course-list">

    <h1>Current Courses</h1>
    
<?php if (count($courses)) : ?>
    <ul>
    <?php foreach ($courses as $course) : ?>
        <li>
            <?php include_partial('course/course', array(
              'user' => $user,
              'course' => $course,
              'remove' => isset($remove) ? $remove : true,
            )); ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>No Courses</p>
<?php endif; ?>

</div>
