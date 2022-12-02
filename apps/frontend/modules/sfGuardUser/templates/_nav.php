<?php if($courses && count($courses)):?>
    <ul>
        <?php foreach ($courses as $course):?>
            <li class="tab-menu-<?php echo $course->getId(); ?>">
                <?php
                    $tabname = $course->getShortName();
                ?>
                <?php echo link_to(
                    $tabname,
                    '@notification_course_list?type=course&slug='.$course->getId().'|'.Utils::slugify($course->getName()),
                    array(
                        'data-id' => $course->getId(),
                        'id' => 'ui-tab-'.$course->getId()
                    )
                );?>
                <?php //counters
                /*
                        $styleP = $styleC = "";
                        if(!$counters[$course->getId()]['new_posts']) $styleP = "style='display:none;'";
                        if(!$counters[$course->getId()]['new_classmates']) $styleC = "style='display:none;'";
                        
                        echo "<a data-id='{$course->getId()}' ''onClick='return false;' $styleP class='new post id{$course->getId()}' href='#' title='New Posts'>".$counters[$course->getId()]['new_posts']."</a>";
                        echo "<a data-id='{$course->getId()}' onClick='return false;' $styleC class='new classmate id{$course->getId()}' href='#' title='New Classmates'>".$counters[$course->getId()]['new_classmates']."</a>";
                 * 
                 */
                ?>
            </li>
            <?php /*
            <?php if (!$isStaff): ?>   
            <li class="tab-menu-<?php echo $course->getId(); ?>-1">
                <?php echo link_to(
                    "Everyone",
                    '@notification_course_list?type=course&slug='.$course->getId().'|1',
                    array(
                        'data-id' => '0',
                        'id' => 'ui-tab-'.$course->getId().'-1'
                    )
                );?>
            </li>
            <?php endif; ?>
             
             */?>
        <?php endforeach;?>
    </ul>
<?php else: ?>
    <p class="no-courses-note">You are not enrolled in any courses. <?php echo link_to('Add a course', '@course_add') ?> to get started.</p>
<?php endif; ?>
