<?php
   $routeOptions = $sf_context->getInstance()->getRouting()->getOptions();
   $currentUrl   = $routeOptions['context']['prefix'].$routeOptions['context']['path_info'];
   $routeName    = $sf_context->getInstance()->getRouting()->getCurrentRouteName();
   $routeUrl     = '@notification_user_list?type=course&id=';
?>
<?php if (count($courses) > 0 || $currentUser->getIsOfficer() == 1): ?>
    
    <?php foreach ($courses as $course):?>
        <li>
            <?php echo link_to($course->getShortName(), '@my_students?course='.$course->getId(), array(
                     'title' => '', 
                     'class' => 'tooltip'));
            ?>
        <span id="private-not-<?php echo $course->getId(); ?>" class="wiki-notification-course-block"></span>
        </li>
    <?php endforeach; ?>
        
    <?php if ($currentUser->getIsOfficer() == 1): ?>
    <?php echo link_to("Officer", "@officer", array(
            'current-url' => $currentUrl,
            'data-id' => "-100"
    )); ?>
    <?php endif; ?>

<?php endif; ?>