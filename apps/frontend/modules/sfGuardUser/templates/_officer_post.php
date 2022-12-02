<h2>My posts</h2>

<div id="">
    <table class="wg-tb-course" border="0" cellspacing="0">
    <tbody>
        <tr>
            <td class="wg-tb-caption wg-tb-td">Date</td>
            <td class="wg-tb-caption wg-tb-td">Course</td>
            <td class="wg-tb-caption wg-tb-td">Type</td>
            <td class="wg-tb-caption wg-tb-td">Content</td>
        </tr>
        <?php foreach ($entities as $record): ?>
            <?php
                $courseName = "";
                $typeName   = "";
                $post = Doctrine::getTable('Post')->findOneBy("id", $record->getId());
                if ($post) {
                    if ($post->getObjectName() == "Course") {
                        $typeName = "Post";
                        $course = Doctrine::getTable("Course")->findOneBy("id", $post->getObjectId());
                        if ($course) {
                            $courseName = $course->getShortName()." (".$course->getName().")";
                        }
                    } elseif($post->getObjectName() == "Notification") {
                        $typeName = "Comment";
                        $not = Doctrine::getTable("Notification")->findOneBy("id", $post->getObjectId());
                        if ($not) {
                            if ($not->getRelatedObjectName() == "Course") {
                                $course = Doctrine::getTable("Course")->findOneBy("id", $not->getRelatedObjectId());
                                if ($course) {
                                    $courseName = $course->getShortName()." (".$course->getName().")";
                                }
                            }
                        }
                    } else {
                        $typeName = "unknown";
                    }
                }
            ?>
            <tr>
                <td class="wg-tb-td"><?php echo $record->getCreatedAt(); ?></td>
                <td class="wg-tb-td"><?php echo $courseName; ?></td>
                <td class="wg-tb-td"><?php echo $typeName; ?></td>
                <td class="wg-tb-td"><?php echo $record->getContent(); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
    <?php include_partial("sfGuardUser/officer_pagin", array('options' => $options, 'link' => '/officer/post')); ?>
</div>