<?php
    $isStaff = 0;
    if (isset($notification['object']['is_staff'])) {
        $isStaff = intval($notification['object']['is_staff']);
    }

    $isTutor = 0;
    if (isset($notification['object']['tutor'])) {
        $isTutor = intval($notification['object']['tutor']);
    }

    $user_name = $notification['object']['user_name'];
    
    $comm_count = 0; //intval($notification['object']['comments_count']);
    if (isset($notification['comments'])) {
        $comm_count = count($notification['comments']);
    }
    
    $user_school = "";
    if(isset($notification['user_school'])) {
        $user_school = $notification['user_school'];
    }
?>
<div class="wg-post-block <?php if ($IsPinPost) echo 'wg-block-pin-post'; ?>">
    <div class="wg-post-col-1 <?php if ($isStaff==1 || $isTutor == 1) { echo "wg-instructor"; } else { echo "wg-student"; }?>">
        <?php echo link_to(image_tag(getUserThumbnail($notification['object']['User']['id'], $notification['object']['user_image'], 50, 0, 0, 1)),'@user?id='.$notification['object']['User']['id'].'&name='.Utils::slugify($user_name), array('class' => 'user-logo'))?>
    </div>
    <div class="wg-post-col-2">
        <div class="wg-post-row-1">
            <table class="wg-post-name"><tr>
                <td class="wiki-left <?php if ($isStaff == 1 || $isTutor == 1) { echo "wg-instructor"; } else { echo "wg-student"; }?>">
                    <?php echo link_to($user_name, '@user?id='.$notification['object']['User']['id'].'&name='.Utils::slugify($user_name), array('class' => 'tooltip3', 'title' => $user_name))?>
                    <span>has joined <b><?php echo $courseName; ?></b></span>
                </td>
            </tr></table>
        </div>
        <div class="wg-post-row-2" style="display: table; width: 100%;">
            <div class="wg-post-col-1" style="width: 50%; text-align:left;">
                <?php if ($isStaff == 1): ?>
                    <?php if ($isTutor == 1): ?>
                        <p>Tutor <?php if (isset($notification['user_school'])): ?> at <?php echo $notification['user_school']; ?><?php endif; ?></p>
                    <? else: ?>
                        <p>Instructor <?php if (isset($notification['user_school'])): ?> at <?php echo $notification['user_school']; ?><?php endif; ?></p>
                    <?php endif; ?>
                <?php else: ?>
                        <?php if(isset($notification['user_school'])): ?>
                            <p>Student at  <?php echo $notification['user_school']; ?></p>
                        <?php endif; ?>
                        <?php if($notification['user_major']): ?>
                            <p><i>Major: <?php echo $notification['user_major'] ?><?php if($notification['user_class_year']): ?>, Class of <?php echo $notification['user_class_year']; endif; ?></i></p>
                        <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="wg-post-col-2" style="width: 50%; text-align:right;">
            <?php if (!$CurrCourse['IsGroup']): ?>
                <div class="col-3"><!--<?php echo image_tag('badge-newclassmate.png') ?>--></div>
            <?php endif; ?>
            </div>
        </div>
        <div class="wg-post-row-3">

            Posted <?php echo formatDatetime($notification['created_at'], null, isset($timezone) ? $timezone : null) ?>

        </div>
    </div>
</div>
<?php if (isset($notification['comments'])): ?>
<?php include_partial('notification/notification_comment_list', array(
    'comments' => $notification['comments'],
    'timezone' => $timezone,
    'IsStaff' => $IsStaff,
    'object_id' => $notification_id
        )) ?>
<?php endif; ?>
<div class="wiki-float-row"></div>
<?php //endif; ?>

