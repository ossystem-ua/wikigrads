<?php
   $routeOptions = $sf_context->getInstance()->getRouting()->getOptions();
   $currentUrl   = $routeOptions['context']['prefix'].$routeOptions['context']['path_info'];
   $routeName    = $sf_context->getInstance()->getRouting()->getCurrentRouteName();
   $routeUrl     = '@notification_course_list?type=course&slug=';
?>
<?php if (count($courses) > 1 || $currentUser->getIsOfficer() == 1): ?>
    <ul>
    <?php foreach ($courses as $course):?>
        <li>
            <a href="/documents/course/<?php echo $course->getId(); ?>"><?php echo $course->getShortName(); ?></a>
            <span id="post-doc-<?php echo $course->getId(); ?>" class="wiki-documents-course-block"></span>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>