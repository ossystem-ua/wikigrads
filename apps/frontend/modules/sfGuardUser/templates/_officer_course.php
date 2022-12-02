<h2>Instructor course</h2>

<div id="">
    <table class="wg-tb-course" border="0" cellspacing="0">
    <tbody>
        <tr>
            <td class="wg-tb-caption wg-tb-td">User name</td>
            <td class="wg-tb-caption wg-tb-td">Course</td>
            <td class="wg-tb-caption wg-tb-td">Code</td>
        </tr>
        <?php if(count($entities)>0): ?>
            <?php foreach ($entities as $record): ?>
                <tr id="block-course-<?php echo $record->getId();?>" data-id="<?php echo $record->getId();?>" class="wg-tb-tr">
                    <td class="wg-tb-td">
                        <a data-id="<?php echo $record->getId();?>" class="remove-instructor-course" href="<?php echo url_for('instructor_course_delete', array('id'=>$record->getId())); ?>" class="tooltip leave-community tb-hide tb-a-sys-<?php echo $record->getId();?>" title="Remove instructor from course">
                            <?php echo image_tag('new_design/wiki-close.png', array('size' => '14x14')); ?>
                        </a>
                        <?php echo $record->getUser()->getFirstName()." ".$record->getUser()->getLastName()." (".$record->getUser()->getEmailAddress().")"; ?>
                    </td>
                    <td class="wg-tb-td"><?php echo $record->getCourse()->getShortName(); ?></td>
                    <td class="wg-tb-td">
                        <input class="input-access" data-id="<?php echo $record->getId(); ?>" type="text" value="<?php echo $record->getAccess(); ?>" />
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    </table> 
    <?php include_partial("sfGuardUser/officer_pagin", array('options' => $options, 'link' => '/officer/course')); ?>
</div>
