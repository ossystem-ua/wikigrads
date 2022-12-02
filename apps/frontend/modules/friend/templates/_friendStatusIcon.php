<?php /* ?>
<?php if( ! $friend_status['is_self']): ?>
    <span class="fsicon-user-<?php echo $friend_status['other_user_id'] ?>">
    <?php if($friend_status['is_friend']): ?>
        <img class="fsicon-conf" src="<?php echo image_path('wmstatus-conf.png') ?>" />
    <?php elseif($friend_status['is_friend_pending']): ?>
        <img class="fsicon-pend" src="<?php echo image_path('wmstatus-pend'.($friend_pending_outline ? '-ol' : '').'.png') ?>" />
    <?php else: ?>
        <a href="#" 
            class="fsicon-non-friend" 
            data-url="<?php echo url_for('@ajax_friend_status_icon_friend_request?id='.$friend_status['other_user_id']) ?>"
            data-id="<?php echo $friend_status['other_user_id'] ?>"
            onclick="USER.add_friend.events.fsicon_add_friend(this); return false;"
        ></a>
    <?php endif; ?>
    </span>
<?php endif; ?>
<?php */ ?>