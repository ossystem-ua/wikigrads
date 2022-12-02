<?php if( ! $friend_status['is_self']): ?>
    <?php if($friend_status['is_friend']): ?>
        <?php echo image_tag('wmstatus-conf.png') ?>
    <?php elseif($friend_status['is_friend_pending']): ?>
        <?php echo image_tag('wmstatus-pend.png') ?>
    <?php else: ?>
        <a href="#" class="stat-non-friend" />
    <?php endif; ?>
<?php endif; ?>