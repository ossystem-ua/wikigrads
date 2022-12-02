<?php
    $user_staff = intval($notification['object']['is_staff']);
    $comm_count = 0; //intval($notification['object']['comments_count']);
    if (isset($notification['comments'])) {
        $comm_count = count($notification['comments']);
    }
?>
<?php if (isset($notification['object']['friend_id'])): ?>
<div class="wg-post-block">
    <div class="wg-post-col-1 wg-student">
        <?php echo link_to(image_tag(getUserThumbnail($notification['object']['user_id'], $notification['object']['user_image'], 50, 0, 0, 1)),'@user?id='.$notification['object']['user_id'].'&name='.Utils::slugify($notification['object']['user_name'] ), array('class' => 'user-logo'))?>
    </div>
    <div class="wg-post-col-2">
        <div class="wg-post-row-1">
            <table class="wg-post-name"><tr>
                <td class="wiki-left <?php if ($user_staff==1) { echo "wg-instructor"; } else { echo "wg-student"; }?>">
                    <?php echo link_to($notification['object']['user_name'], '@user?id='.$notification['object']['user_id'].'&name='.Utils::slugify($notification['object']['user_name'] ), array('class' => 'tooltip3', 'title' => $notification['object']['user_name']))?>
                </td>
            </tr></table>
        </div>
        <div class="wg-post-row-2" style="display: table; width: 100%;">
            <div class="wg-post-col-1" style="width: 50%; text-align:left;">


                Became friends with: <?php echo link_to($notification['object']['friend_name'], '@user?id='.$notification['object']['friend_id'].'&name='.Utils::slugify($notification['object']['friend_name'] ))?></span>


            </div>
            <div class="wg-post-col-2" style="width: 50%; text-align:right;">
                <div class="col-3"><?php //echo image_tag('badge-newmember.png') ?></div>
            </div>
        </div>
        <div class="wg-post-row-3">

            Posted <?php echo formatDatetime($notification['object']['created_at'], null, isset($timezone) ? $timezone : null) ?>

        </div>
    </div>
</div>
<div class="wiki-float-row"></div>
<?php endif; ?>
