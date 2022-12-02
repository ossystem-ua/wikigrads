<?php use_stylesheet('user');?>


<div class="content-pad">
    <?php if(count($friends)):?>
        <?php foreach ($friends as $index => $friend): ?>
            <?php include_partial('sfGuardUser/singleMember', array('user' => $friend, 'index' => $index))?>
        <?php endforeach; ?>
    <?php else: ?>
        You have no WikiMates at this time.
    <?php endif;?>
</div>
