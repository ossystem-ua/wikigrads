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
?>
<div id="wiki-post-block-<?php echo $notification_id; ?>">
<div class="wg-post-block">
    <div class="wg-post-col-1 <?php if ($isStaff==1) { echo "wg-instructor"; } else { echo "wg-student"; }?>">
        <?php echo link_to(image_tag(getUserThumbnail($doc_user->getId(), $notification['object']['user_image'], 50, 0, 0, 1)),'@user?id='.$notification['object']['user_id'].'&name='.Utils::slugify($user_name), array('class' => 'user-logo', 'title' => $user_name))?>
    </div>
    <div class="wg-post-col-2">
        <div class="wg-post-row-1">
            <table class="wg-post-name"><tr>
                <td class="wiki-left <?php if ($isStaff==1) { echo "wg-instructor"; } else { echo "wg-student"; }?>">
                    <?php echo link_to($user_name, '@user?id='.$notification['object']['user_id'] . '&name=' . Utils::slugify($user_name), array('class' => 'tooltip3', 'title' => $user_name))?>
                </td>
                <?php if ($sf_user->isModerator() || $doc_user->getId() === $sf_user->getGuardUser()->getId()) : ?>
                <td class="wiki-right wg-post-link">
                    <div class="wg-post-like">
                    <?php echo link_to(image_tag('new_design/wiki-pen-1.png'), '@ajax_post_edit?notification_id='.$notification_id, array('data-id' => $notification_id, 'class' => 'wg-post-link wg-img-icon tooltip3', 'title' => 'Edit this post', 'OnClick' => 'getEditForm(this);return false;')) ?>
                    <?php echo link_to(image_tag('new_design/wiki-close.png'), '@notification_delete_post?notification_id='.$notification_id, array('data-id' => $notification_id, 'msgyesno' => 'Delete post?', 'class' => 'wg-post-link wg-img-icon tooltip', 'title' => 'Delete post', 'OnClick' => 'onDeletePost(this);return false;')) ?>
                    </div>
                </td>
                <?php endif; ?>
            </tr></table>
        </div>
        <div id="wiki-post-content-<?php echo $notification_id; ?>" class="wg-post-row-2">
            <?php
                $content = '';


                    $url = link_to(str_replace('_', ' ', $document->getName()),
                    '@document_download?slug='.$document->getId().'|'.Utils::slugify($document->getName(),
                     array(
                         'class' => 'wiki-doc-upload'
                     )) );

                    $content .= '<div class="wiki-float-row-2"></div><div class="wiki-doc-block">
                        <table><tr>
                            <td valign="top"><div class="wiki-doc-upload-img">'.$url.'</div></td>
                            <td valign="top"><p><b>'.str_replace('_', ' ', $document->getName()).'</b></p><p>'.$document->getDescription().'</p></td>
                        </tr></table>
                    </div>';


                if ($content != 'image')
                    echo '<div>'.$content.'</div>';
                else
                    echo '';
            ?>
        </div>
        <div class="wg-post-row-3">

            Posted <?php echo formatDatetime($notification['object']['created_at'], null, isset($timezone) ? $timezone : null) ?>

        </div>
    </div>
</div>
<div class="wiki-float-row"></div>
</div>

