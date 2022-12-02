<?php use_stylesheet('user'); ?>
<div id="new-member-list-container" class="content-pad">
    <?php if(isset($users)):?>
        <?php include_partial('list_new_members', array('users'=>$users, 'autopager'=>$autopager, 'isAjaxRequest'=>$isAjaxRequest)) ?>
    <?php else: ?>
        No members.
    <?php endif; ?>
</div>