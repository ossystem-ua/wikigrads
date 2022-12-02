
<?php if(isset($load_wgTpl) && $load_wgTpl) { use_helper('wgTpl'); } # if called directly from action, need to specify to load wgTpl helper ?>

<div class="wiki-comment-block" id="wiki-comment-list-<?php echo $object_id; ?>" style="display: none;">
   <div id="wg-add-comment-<?php echo $object_id; ?>"></div>
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
            <div class="wiki-see-more-comments" data-id="<?php echo $object_id; ?>">
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
                
                $content = getFx($content);
                    
                $fxPos = getFxPos($content);

                if ($fxPos[0] < 500 && $fxPos[1] && $fxPos[1] >= 500) {
                    $len = $fxPos[1]+6;
                }
                
                if (strlen($content) > $len+1) {
                    $part1 = substr($content, 0, $len);
                    $part2 = substr($content, $len, strlen($content) - $len);
                    $idpart = $comment['id'];
                    $content = $part1.'<span class="hide-content-text" id="span_'.$idpart.'">'.$part2.'</span><p><a class="href-cursor" onClick="ShowHideText('.$idpart.');" id="href_'.$idpart.'">see more</a></p>';
                }

                $content = getFx($content);

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

                if ($content != 'image') {
                    echo '<div>'.$content.'</div>';
                } else {
                    echo '';
                } ?>
                <div class="wiki-float-row"></div>
                <?php if ($comment['attachment_id'] > 0) {
                    if ($comment['ftype'] == 0 && $comment['is_pinned'] == 0) {
                        echo '<div style="display:block;">
                            <a href="'.$comment['attachment_url'].'" class="zoom">
                                <img class="img-silde" src="'.$comment['attachment_url'].'" alt="Image #'.$comment['id'].'" />
                            </a>
                        </div>';
                    }
                } ?>
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
    <div class="vm-holder" id="vm-holder-<?php echo $object_id; ?>" style="display: <?php echo $vm_holder; ?>;">
        <a href="#" data-id = "<?php echo $object_id; ?>">View <?php echo $vm; ?> more comments</a>
    </div>
    <div id="wg-form-add-comment-2<?php echo $object_id; ?>" class="wiki-comment-content">
        <!-- new form for add a comment -->
    </div>
<?php endif;?>
<?php endif;?>
    <div id="wg-form-add-comment-<?php echo $object_id; ?>" class="wiki-comment-content"></div>
</div>

