<h2>Join to course</h2>

<div id="">
    <table class="wg-tb-course" border="0" cellspacing="0">
    <tbody>
        <tr>
            <td class="wg-tb-caption wg-tb-td">Department</td>
            <td class="wg-tb-caption wg-tb-td">Name</td>
            <td class="wg-tb-caption wg-tb-td">Code</td>
        </tr>
        <?php foreach ($entities as $record): ?>
            <tr>
                <td class="wg-tb-td"><?php echo $record->getDepartment()->getName(); ?></td>
                <td class="wg-tb-td">
                    <a data-id="<?php echo $record->getId();?>" href="<?php echo url_for('@officer_join_course?courseId='.$record->getId()); ?>" class="tooltip wg-join-course" title="Join to course">
                        <?php echo image_tag('new_design/button-join.png', array('style' => 'height: 15px;')); ?>
                    </a>
                    <?php echo $record->getName(); ?>
                </td>
                <td class="wg-tb-td"><?php echo $record->getShortName(); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
    <?php include_partial("sfGuardUser/officer_pagin", array('options' => $options, 'link' => '/officer/join')); ?>
</div>