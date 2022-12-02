<?php
    $comm_count = 0; //intval($notification['object']['comments_count']);
    if (isset($notification['comments'])) {
        $comm_count = count($notification['comments']);
    }
    
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
<div class="wg-post-block <?php if ($IsPinPost) echo 'wg-block-pin-post'; ?>">
    <div class="wg-post-col-1 <?php if ($isStaff == 1) { echo "wg-instructor"; } else { echo "wg-student"; }?>">
        <?php echo link_to(image_tag(getUserThumbnail($notification['object']['user_id'], $notification['object']['user_image'], 50, 0, 0, 1)),'@user?id='.$notification['object']['user_id']."&name=".Utils::slugify($user_name), array('class' => 'tooltip5 user-logo', 'title' => $user_name))?>
    </div>
    <div class="wg-post-col-2">
        <div class="wg-post-row-1">
            <table class="wg-post-name"><tr>
                <td class="wiki-left <?php if ($isStaff == 1) { echo "wg-instructor"; } else { echo "wg-student"; }?>">
                    <?php if (count($notification['object']['User'])>0): ?>
                        <?php echo link_to($user_name, '@user?id='.$notification['object']['user_id']."&name=".Utils::slugify($user_name), array('class' => 'tooltip3', 'title' => $user_name))?>
                    <?php else: ?>
                        <span class="sys-msg">user was deleted</span>
                    <?php endif ?>
                </td>
                <?php if ($isStaff || $sf_user->isModerator() || $notification['object']['user_id'] === $sf_user->getGuardUser()->getId() || $sf_user->getGuardUser()->getIsOfficer() == 1) : ?>
                <td class="wiki-right wg-post-link">
                    <div class="wg-post-like">
                    <?php if($notification['object']['is_pinned'] == 1): ?>
                        <div class="wg-pin-badge tooltip" title="Pinned post"></div>
                    <?php endif; ?>
                    <?php echo link_to(image_tag('new_design/wiki-pen-1.png'), '@ajax_post_edit?notification_id='.$notification_id, array('data-id' => $notification_id, 'class' => 'wg-post-link wg-img-icon tooltip3', 'title' => 'Edit this post', 'OnClick' => 'getEditForm(this);return false;')) ?>
                    <?php echo link_to(image_tag('new_design/wiki-close.png'), '@notification_delete_post?notification_id='.$notification_id, array('data-id' => $notification_id, 'msgyesno' => 'Delete post?', 'class' => 'wg-post-link wg-img-icon tooltip', 'title' => 'Delete post', 'OnClick' => 'onDeletePost(this);return false;')) ?>
                    </div>
                </td>
                <?php endif; ?>
            </tr></table>
        </div>
        <div id="wiki-post-content-<?php echo $notification_id; ?>" class="wg-post-row-2">
            <?php
                $content = $notification['object']['content'];

                $content = makeClickableLinks($content);
                $len = 500;
                $tag = "<br/>";
                $pos = getNextPos($content, $tag, 0, 4, 0);
                if ($pos > 0) { if ($pos < $len) { $len = $pos; }}

                if (strlen($content) > $len) {
                    $part1 = substr($content, 0, $len);
                    $part2 = substr($content, $len, strlen($content) - $len);
                    $idpart = $notification['object']['id'];
                    $content = $part1.'<span class="hide-content-text" id="span_'.$idpart.'">'.$part2.'</span><p><a class="href-cursor" onClick="ShowHideText('.$idpart.');" id="href_'.$idpart.'">see more</a></p>';
                }

                $content = getFx($content);

                if ($notification['object']['document_id'] > 0) {

                    $document = Doctrine_Core::getTable('Document')->findOneById($notification['object']['document_id']);
                    if ($document) {
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
                    }
                }

                if ($content != 'image') {
                    echo '<div>'.$content.'</div>';
                } else {
                    echo '';
                }
            ?>
            <div class="wiki-float-row"></div>
            <?php if ($notification['object']['attachment_id'] > 0) {
                    if ($notification['object']['ftype'] == 0 && $notification['object']['is_pinned'] == 0) {
                        echo '<div style="display:block;">
                            <a href="'.$notification['object']['attachment_url'].'" class="zoom">
                                <img class="img-silde" src="'.$notification['object']['attachment_url'].'" alt="Image #'.$notification['object']['id'].'" />
                            </a>
                        </div>';
                    }
                }

             if( 0 !== $notification['object']['link_data_id'] && isset($notification['object']['LinkData']) ): ?>
                <?php $linkData = $notification['object']['LinkData']; ?>
                    <div class="wiki-post-link-data">
                            <div id="wg-show-equation-post" style="display: none;"></div>
                            <div class="site-information">
                                <?php #SKY: check if url contain data from youtube with video. I do not like this, but for light version it is ok.?>
                                <?php
                                    $isVideo = false;
                                    if( strstr($linkData->get('url'), "youtube.com/watch?v=") || 1 === preg_match("/youtu.be[\/][a-zA-Z1-9\-\._]+/", $linkData->get('url')) ){
                                        $isVideo = true;
                                    }
                                ?>
                                <?php if( '' !== $linkData->get('img') ): ?>
                                    <a class="link-data-href-play" href='<? echo $linkData->get('url'); ?>' target="_blank">
                                        <div class="video-frame"></div>
                                        <img class="si-image" src="<? echo $linkData->get('img'); ?>" />
                                        <?php if($isVideo):?><div class="play-button"></div><?php endif;?>
                                    </a>
                                <?php endif; ?>
                                <a class="link-data-href" href='<? echo $linkData->get('url'); ?>' target="_blank">
                                    <span class="si-title"><? echo $linkData->get('title');?></span><br/>
                                    <span class="si-description"><? echo $linkData->get('description');?></span><br/>
                                    <span class="si-link"> <? echo $linkData->get('host');?> </span>
                                    <div style="clear: both;"></div>
                                </a>
                            </div>
                    </div>
            <?php endif; ?>
        </div>
        <div class="wg-post-row-3">
            <?php if ($comm_count > 0): ?>
            <?php
                $name_show = $comm_count." comment";
                if ($comm_count > 1) $name_show .= 's';
                $name_hide = "Hide comment";
                if ($comm_count > 1) $name_hide .= 's';
            ?>

            <a href="/ajax/add-comment/notification_id/<?php echo $notification_id; ?>" data-id="<?php echo $notification_id; ?>" class="href-cursor tooltip3 wg-none-href" title="Show comments" OnClick="ShowBlock(this, 'wiki-comment-list-', <?php echo $notification_id; ?>, '<?php echo $name_show; ?>', '<?php echo $name_hide; ?>')">
                <?php echo $name_show; ?>
            </a>

            |
            <?php endif; ?>
            <?php  echo link_to('Leave comment', '@ajax_comment_add?notification_id='.$notification_id, array(
                'data-id'   =>  $notification_id,
                'class'     =>  'comment-add-link tooltip3',
                'title'     => 'Leave comment',
                'OnClick'   => 'onShowCommentForm(this, 1); return false;'
            )) ?>
            |
            Posted <?php echo formatDatetime($notification['object']['created_at'], null, isset($timezone) ? $timezone : null) ?>

            <?php
                $class = "wg-flag-button new-flag tooltip4";
                if ($notification['object']['flagget'] == 1) { $class = "wg-flag-button tooltip new-flag flagged"; }
                echo link_to('&nbsp;', '@post_flag_as_inappropriate?notification_id='.$notification_id, array(
                    'class' => $class,
                    'title' => 'Flag this post',
                    'data-id' => $notification['object']['id'],
                    'onclick' => 'flaggedPost(this); return false;'
            )) ?>
            <div class="wg-post-like">
                <?php if ($isStaff == 0 || $isTutor == 1): ?>
                    <?php if ($isTutor == 1): ?>
                        <div id="imageLike" class="image-like tooltip4 tutor tooltip3" title="Instructor endorsements" OnClick="setLike(<?php echo $notification['object']['id']; ?>, this);"></div>
                    <?php else: ?>
                        <div id="imageLike" class="image-like tooltip4 tooltip3" title="Student endorsements" OnClick="setLike(<?php echo $notification['object']['id']; ?>, this);"></div>
                    <?php endif; ?>
                    <div class="count-like" id="count_<?php echo $notification['object']['id']; ?>"><?php echo $notification['object']['count_like']; ?></div>
                    <div class="like-status" id="status_<?php echo $notification['object']['id']; ?>"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php // include_partial('notification/notification_comment_list', array(
//    'timezone' => $timezone,
//    'object_id' => $notification_id,
//    'notification' => $notification,
//    'profile' => $profile,
//    'courseId' => $courseId
//    )) ?>
    
    <?php if(isset($load_wgTpl) && $load_wgTpl) { use_helper('wgTpl'); } # if called directly from action, need to specify to load wgTpl helper ?>

    <div class="wiki-comment-block" id="wiki-comment-list-<?php echo $notification_id; ?>" style="display: none;">
       <div id="wg-add-comment-<?php echo $notification_id; ?>"></div>
    <?php if (isset($notification['comments'])): ?>
        <?php $comments = $notification['comments']; ?>
     <?php if($comments): ?>
        <?php
            $i = 0;
            $seemore = true;
            $c = count($comments);
            $vm = $c - 2;
        ?>
        <?php //foreach($comments as $key => $comment): ?>
        <?php for($j=$c-1;$j >= 0; $j--): ?>
            <?php 
                $comment = $comments[$j];

                $isStaff = 0;
                if (isset($comment['is_staff'])) {
                    $isStaff = intval($comment['is_staff']);
                }

                $isTutor = 0;
                if (isset($comment['tutor'])) {
                    $isTutor = intval($comment['tutor']);
                }

                $user_name = $comment['user_name'];
            ?>
            <?php if ($i == 0 && $c>2): ?>
                <div class="wiki-see-more-comments" data-id="<?php echo $notification_id; ?>">
            <?php endif; ?>

            <?php if ($i == $vm-1): ?>
                <?php $seemore = false; ?>
            <?php endif; ?>

            <div id="wiki-comment-block-<?php echo $comment['id']; ?>" class="wiki-comment-content">
                <div class="wg-post-col-1 <?php if ($isStaff == 1) { echo "wg-instructor"; } else { echo "wg-student"; }?>">
                    <?php echo link_to(image_tag(getUserThumbnail($comment['user_id'], $comment['user_image'], '50', 0, 0, 1)),'@user?id='.$comment['user_id']."&name=".Utils::slugify($user_name), array('class' => 'user-logo tooltip5', 'title' => $user_name))?>
                </div>
                <div class="wg-post-col-2">
                    <div class="wg-post-row-1">
                        <table class="wg-post-name"><tr>
                        <td class="wiki-left <?php if ($isStaff == 1) { echo "wg-instructor"; } else { echo "wg-student"; }?>">
                            <?php echo link_to($user_name, '@user?id='.$comment['user_id']."&name=".Utils::slugify($user_name), array('class' => 'tooltip3', 'title' => $user_name))?>
                        </td>
                        <?php if ($isStaff || $sf_user->isModerator() || $comment['u_id'] === $sf_user->getGuardUser()->getId() || $sf_user->getGuardUser()->getIsOfficer() == 1): ?>
                        <td class="wiki-right wg-post-link">
                            <div class="wg-post-like">
                                <?php echo link_to(image_tag('new_design/wiki-pen-1.png'), '@ajax_comment_edit?post_id='.$comment['id'], array('data-id' => $comment['id'], 'class' => 'wg-post-link wg-img-icon tooltip3', 'title' => 'Edit this post', 'OnClick' => 'getEditForm(this);return false;')) ?>
                                <?php echo link_to(image_tag('new_design/wiki-close.png'), '@post_delete_comment?post_id='.$comment['id'], array('data-id' => $comment['id'], 'msgyesno' => 'Delete post?', 'class' => 'wg-post-link wg-img-icon tooltip3', 'title' => 'Delete post', 'OnClick' => 'onDeleteComment(this);return false;')) ?>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr></table>
                    </div>
                    <div id="wiki-post-content-<?php echo $comment['id']; ?>" class="wg-post-row-2">
                        <?php
                    $content = $comment['content'];

                    if ($content == 'image' || strtolower(trim($content)) == strtolower('Add to the conversation')) {
                        $content = '';
                    }

                    $content = makeClickableLinks($content);
                    $len = 500;
    //                $len = getLen($content, 500, 0);
                    $tag = "<br/>";
                    $pos = getNextPos($content, $tag, 0, 4, 0);
                    if ($pos > 0) { if ($pos < $len) { $len = $pos; }}

                    if (strlen($content) > $len) {
                        $part1 = substr($content, 0, $len);
                        $part2 = substr($content, $len, strlen($content) - $len);
                        $idpart = $comment['id'];
                        $content = $part1.'<span class="hide-content-text" id="span_'.$idpart.'">'.$part2.'</span><p><a class="href-cursor" onClick="ShowHideText('.$idpart.');" id="href_'.$idpart.'">see more</a></p>';
                    }

                    $content = getFx($content);

                    if ($comment['attachment_id'] > 0) {
                        if ($comment['ftype'] == 0 && $comment['is_pinned'] == 0) {
                            echo '<div style="display:block;">
                                <a href="'.$comment['attachment_url'].'" class="zoom">
                                    <img class="img-silde" src="'.$comment['attachment_url'].'" alt="Image #'.$comment['id'].'" />
                                </a>
                            </div>';
                        }
                    }

                    if ($comment['document_id'] > 0) {
                        $document = Doctrine_Core::getTable('Document')->findOneById($comment['document_id']);
                        if ($document) {
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
                        }
                    }

                    if ($content != 'image')
                        echo '<div>'.$content.'</div>';
                    else
                        echo '';
                    ?>
                    </div>

                    <div class="wg-post-row-3">
                        Posted <?php echo formatDatetime($comment['created_at'], null, isset($timezone) ? $timezone : null) ?>

                        <?php
                            $class = "wg-flag-button tooltip4 new-flag";
                            if ($comment['flagget'] == 1) { $class = "wg-flag-button tooltip new-flag flagged"; }
                            echo link_to('&nbsp;', '@post_flag_as_inappropriate?notification_id='.$comment['id'], array(
                                'class' => $class,
                                'title' => 'Flag this post',
                                'data-id' => $comment['id'],
                                'onclick' => 'flaggedPost(this); return false;'
                        )) ?>

                    <div class="wg-post-like">
                        <?php if ($isStaff == 0 || $isTutor == 1): ?>
                            <?php if ($comment['tutor'] == 1): ?>
                            <div id="imageLike" class="image-like tutor tooltip4" title="Instructor endorsements" OnClick="setLike(<?php echo $comment['id']; ?>, this);"></div>
                            <?php else: ?>
                            <div id="imageLike" class="image-like tooltip4" title="Student endorsements" OnClick="setLike(<?php echo $comment['id']; ?>, this);"></div>
                            <?php endif; ?>
                            <div class="count-like" id="count_<?php echo $comment['id']; ?>"><?php echo $comment['count_like']; ?></div>
                            <div class="like-status" id="status_<?php echo $comment['id']; ?>"></div>
                        <?php endif; ?>
                    </div>
                    </div>
                </div>
            </div>
            <div class="wiki-float-row"></div>
            <?php $i++; ?>
            <?php //endforeach;?>
        <?php if($i == $vm): ?>
            </div>
        <?php endif; ?>
            <?php endfor;?>
        <?php if ($c>2): ?>
            <?php $vm_holder = 'block'; ?>
        <?php else: ?>
            <?php $vm_holder = 'none'; ?>
        <?php endif; ?>
        <div class="vm-holder" id="vm-holder-<?php echo $notification_id; ?>" style="display: <?php echo $vm_holder; ?>;">
            <a href="#" data-id = "<?php echo $notification_id; ?>">View <?php echo $vm; ?> more comments</a>
        </div>
        <div id="wg-form-add-comment-2<?php echo $notification_id; ?>" class="wiki-comment-content">
            <!-- new form for add a comment -->
        </div>
    <?php endif;?>
    <?php endif;?>
        <div id="wg-form-add-comment-<?php echo $notification_id; ?>" class="wiki-comment-content"></div>
    </div>
<div class="wiki-float-row"></div>
</div>