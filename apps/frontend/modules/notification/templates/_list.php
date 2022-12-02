<?php use_helper('wgTpl'); ?>
<div id="notification-list">

<?php if($notifications):?>
    <div class="pinned-posts">
            <?php foreach($pinned as $n_id=>$notification):
                include_partial('notification/list_item_post', array('notification_id'=>$n_id, 'notification'=>$notification, 'tabType'=>$type, 'timezone' => $timezone, 'IsStaff' => $IsStaff, 'courseId' => 0));
            ?>
                <div id="comment-add-form-container-<?php echo $n_id ?>"></div>
                <div
                    id="notification-comment-list-<?php echo $n_id ?>"
                    class="notification-comment-list"
                    data-action="<?php echo url_for('@notification_comment_list?id='.$n_id)?>"
                    style="display: none"
                >
                <?php if($notification['has_comments']): ?>
                    <?php include_partial('notification/notification_comment_list', array('comments' => $notification['comments'], 'timezone' => $timezone, 'IsStaff' => $IsStaff)) ?>
                <?php endif;?>
                </div>
                <hr />
            <?php endforeach; ?>
    </div>
    <?php foreach($notifications as $n_id=>$notification):?>
        <?php if(0): // debug info, set to 1 to view. ?>
            <?php echo "$notification[object_name] - $notification[related_object_name] : $notification[related_object_id] - $notification[action]]" ?>
        <?php endif; ?>

        <?php

        $IsPinned = false;
        if (isset($notification['object'])) {
            if (isset($notification['object']['is_pinned'])) {
                $IsPinned = $notification['object']['is_pinned'];
            }
        }

        switch($notification['object_name']) {
            case 'Post':
                if(!$IsPinned):
                    include_partial('notification/list_item_post', array('notification_id'=>$n_id, 'notification'=>$notification, 'tabType'=>$type, 'timezone' => $timezone, 'IsStaff' => $IsStaff, 'courseId' => 0));
                endif;
                break;
            case 'Document':
                include_partial('notification/list_item_document', array('notification_id'=>$n_id, 'notification'=>$notification, 'timezone' => $timezone));
                break;
            case 'UserCourse':
                include_partial('notification/list_item_user_course', array('CurrCourse' => $CurrCourse, 'notification_id'=>$n_id, 'notification'=>$notification, 'timezone' => $timezone, 'courseId' => $courseId));
                break;
            case 'UserSchool':
                //include_partial('notification/list_item_user_school', array('notification_id'=>$n_id, 'notification'=>$notification, 'timezone' => $timezone));
                break;
            case 'Friend':
                //include_partial('notification/list_item_friend', array('notification_id'=>$n_id, 'notification'=>$notification, 'timezone' => $timezone));
            default:
                break;
        }
        if(!$notification['object_name']=="Post" || !$IsPinned) :
        ?>

        <div id="comment-add-form-container-<?php echo $n_id ?>"></div>
        <div
            id="notification-comment-list-<?php echo $n_id ?>"
            class="notification-comment-list"
            data-action="<?php echo url_for('@notification_comment_list?id='.$n_id)?>"
            style="display: none"
        >
        <?php if($notification['has_comments']): ?>
            <?php include_partial('notification/notification_comment_list', array('comments' => $notification['comments'], 'timezone' => $timezone, 'IsStaff' => $IsStaff)) ?>
        <?php endif;?>
        </div>

        <hr />
        <?php endif; ?>
    <?php endforeach; ?>


<?php else: ?>
    No notifications.
<?php endif;?>
</div>
    <?php if($autopager->isLastPage()): ?>
        <div class="autopager-container"><!--no more notifications--></div>
    <?php else: ?>
        <div id="autopager" class="autopager-container">
            <?php echo link_to("more", $autopager->getPageNextLink()) ?>
        </div>
    <?php endif; ?>
<!--<script type="text/javascript">
//    AutoPager.addCallback('USER.fsicon.tooltips()');  // for any new content loaded, attach tooltips to the fsicons
//    AutoPager.addCallback('POST.flag_as_inappropriate.tooltips()');  // attach tooltips for 'flag as inappropriate' link
//    AutoPager.init('#notification-list');
</script>-->
