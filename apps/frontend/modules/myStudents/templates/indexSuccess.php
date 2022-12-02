<div id="wiki-content-main-inner">
    <div id="my-profile">
        <div class="container">
            <div class="float-l my-students-block">
                <?php if (!empty($courseName)): ?>
                        <h2>
                            <?php echo $courseName; ?> <span>| Statistics</span>
                        </h2>
                        <p>
                            Total contributions: <strong><?php echo $totalPosts; ?></strong> posts, 
                                                 <strong><?php echo $totalComments; ?></strong> comments, and 
                                                 <strong><?php echo $totalAttachment; ?></strong> documents, images, and/or links
                        </p>
                        <?php $studentsCount = 0; ?>
                        <?php foreach ($myStudents as $studentsList): ?>
                            <?php if ($studentsList['course_id'] == $course_id): ?>
                                <?php if ($studentsCount == 0): ?>
                                <table class="my-students-table" cellpadding="0" cellspacing="0">
                                <tr align="left">
                                    <th style="padding-left: 30px;">
                                        <?php echo link_to('Name <span class="statistics-arrow-'.$arrow['name'].'"></span>',
                                                           "@my_students_order?course=".$course_id."&order=name&desc=".$order['name'], 
                                                            array("class"=>"statistics-table-order")); 
                                        ?>
                                    </th>
                                    <th>
                                        <?php echo link_to('Total&nbsp;posts<span class="statistics-arrow-'.$arrow['post'].'"></span>',
                                                               "@my_students_order?course=".$course_id."&order=post&desc=".$order['post'],
                                                               array("class"=>"statistics-table-order")); 
                                        ?>
                                    </th>
                                    <th>
                                        <?php echo link_to('Total&nbsp;Comments<span class="statistics-arrow-'.$arrow['comment'].'"></span>', 
                                                               "@my_students_order?course=".$course_id."&order=comment&desc=".$order['comment'],
                                                               array("class"=>"statistics-table-order")); 
                                        ?>
                                    </th>
                                    <th style="padding-left: 20px;">
                                        <?php echo link_to('Activity*<span class="statistics-arrow-'.$arrow['activity'].'"></span>', 
                                                               "@my_students_order?course=".$course_id."&order=activity&desc=".$order['activity'],
                                                               array("class"=>"statistics-table-order")); 
                                        ?>
                                    </th>
                                    <th>
                                        <?php echo link_to('Instructor<br/>endorsements<span class="statistics-arrow-'.$arrow['instr'].'"></span>', 
                                                               "@my_students_order?course=".$course_id."&order=instr&desc=".$order['instr'],
                                                               array("class"=>"statistics-table-order")); 
                                        ?>
                                    </th>
                                    <th>
                                        <?php echo link_to('Student<br/>endorsements<span class="statistics-arrow-'.$arrow['stud'].'"></span>',
                                                               "@my_students_order?course=".$course_id."&order=stud&desc=".$order['stud'],
                                                               array("class"=>"statistics-table-order")); 
                                        ?>
                                    </th>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td>
                                        <?php
                                            $color = '10878e';
                                            if ($studentsList['instructor']) $color = 'f07d18';
                                            $userName = $studentsList['first_name']." ".$studentsList['last_name'];
                                            echo link_to($userName,
                                                    '@user?id='.$studentsList['user_id']."&name=".Utils::slugify($userName),
                                                    array('style' => 'color: #'.$color.';'));
                                        ?>
                                    </td>
                                    <td><?php echo $studentsList['posts']; ?></td>
                                    <td><?php echo $studentsList['replies']; ?></td>
                                    <td><?php echo $studentsList['activity']; ?></td>
                                    <td><?php echo $studentsList['instructor_likes']; ?></td>
                                    <td><?php echo $studentsList['user_likes']; ?></td>
                                </tr>
                                <tr><td colspan="6"><hr width="97%" height="1px" color="#d4dedf"/></td></tr>
                                <?php $studentsCount++; ?>
                            <?php endif;?>
                        <?php endforeach; ?>
                        <?php if ($studentsCount != 0): ?>
                                </table>
                        <?php else: ?>
                            <p>No students on this course</p>
                        <?php endif;?>
                        <p><em>*Activity indicates the average number of comments that were made per post</em></p>
                <?php else: ?>
                    <h4 class="short-course-name">You have not created a single course</h4>
                <?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>