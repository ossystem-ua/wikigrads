<div class="wg-officer-main-block">

    <ul id="officer-menu">
        <li><?php echo link_to("Officer page", "@officer", array('data-id' => "-100")); ?></li>
        <li>&nbsp;|&nbsp;</li>
        <li><?php echo link_to("Instructor course", "/officer/course", array('data-id' => "-100")); ?></li>
        <li>&nbsp;|&nbsp;</li>
        <li><?php echo link_to("Join to course", "/officer/join", array('data-id' => "-100")); ?></li>
        <?php /*
        <li>&nbsp;|&nbsp;</li>
        <li><?php echo link_to("My posts", "/officer/post", array('data-id' => "-100")); ?></li>
        */?>
    </ul>
    <hr/>

    <?php if($type == "course"): ?>
        <?php include_partial("sfGuardUser/officer_course", array('entities' => $entities, 'options' => $options)); ?>
    <?php elseif ($type == "join"): ?>
        <?php include_partial("sfGuardUser/officer_join", array('entities' => $entities, 'options' => $options)); ?>
    <?php elseif ($type == "post"): ?>
        <?php include_partial("sfGuardUser/officer_post", array('entities' => $entities, 'options' => $options)); ?>
    <?php else: ?>
        <?php include_partial("sfGuardUser/officer_page", array('entities' => $entities, 'options' => $options)); ?>
    <?php endif; ?>

</div>
