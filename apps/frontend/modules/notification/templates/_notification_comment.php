<?php use_helper('wgTpl'); ?>
<?php
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
<?php // var_dump($comment); exit; ?>
<a name="#<?php echo $comment['id']; ?>"></a>
        <div id="wiki-comment-block-<?php echo $comment['id']; ?>" class="wiki-comment-content">
            <div class="wg-post-col-1">
                <?php echo link_to(image_tag(getUserThumbnail($comment['user_id'], $comment['user_image'], '50', 0, 0, 1)),'@user?id='.$comment['user_id'].'&name='.Utils::slugify($user_name), array('class' => 'user-logo tooltip5', 'title' => $user_name))?>
            </div>
            <div class="wg-post-col-2">
                <div class="wg-post-row-1">
                    <table class="wg-post-name"><tr>
                    <td class="wiki-left">
                        <?php echo link_to($user_name, '@user?id='.$comment['user_id'].'&name='.Utils::slugify($user_name), array('class' => 'tooltip4', 'title' => $user_name))?>
                    </td>
                    <?php if ($comment['u_id'] === $sf_user->getGuardUser()->getId()): ?>
                    <td class="wiki-right wg-post-link">
                        <div class="wg-post-like">
                            <?php echo link_to(image_tag('new_design/wiki-close.png'), '@post_delete_comment?post_id='.$comment['id'], array('data-id' => $comment['id'], 'msgyesno' => 'Delete post?', 'class' => 'wg-post-link wg-img-icon tooltip4', 'title' => 'Delete post', 'OnClick' => 'onDeleteComment(this);return false;')) ?>
                            <?php echo link_to(image_tag('new_design/wiki-pen-1.png'), '@ajax_comment_edit?post_id='.$comment['id'], array('data-id' => $comment['id'], 'class' => 'wg-post-link wg-img-icon tooltip4', 'title' => 'Edit this post', 'OnClick' => 'getEditForm(this);return false;')) ?>
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
                            <table>
                                <tr><td valign="top"><div class="wiki-doc-upload-img">'.$url.'</div></td></tr>
                                <tr><td valign="top"><p>'.$document->getDescription().'</p></td></tr>
                            </table>
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
                }
                ?>
                </div>

                <div class="wg-post-row-3">
                    Posted <?php echo formatDatetime($comment['created_at'], null, isset($timezone) ? $timezone : null) ?>

                    <?php echo link_to('&nbsp;', '@post_flag_as_inappropriate?notification_id='.$comment['id'], array(
                        'class' => 'wg-flag-button tooltip4 new-flag',
                        'title' => 'Flag this post',
                        'data-id' => $comment['id'],
                        'onclick' => 'flaggedPost(this); return false;'
                    )) ?>

                <div class="wg-post-like">
                    <?php if ($user_staff == 0 || $isTutor == 1): ?>
                        <div id="imageLike" class="image-like tooltip4" title="Student endorsements" OnClick="setLike(<?php echo $comment['id']; ?>);"></div>
                        <div class="count-like" id="count_<?php echo $comment['id']; ?>"><?php echo $comment['count_like']; ?></div>
                        <div class="like-status" id="status_<?php echo $comment['id']; ?>"></div>
                    <?php endif; ?>
                </div>
                </div>
            </div>
        </div>
        <div class="wiki-float-row"></div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var instOrStud = jQuery('.instrOrStud').attr('title');
        jQuery("#wiki-comment-block-<?php echo $comment['id']; ?> .wg-post-col-1").attr('class', "wg-post-col-1 "+instOrStud);
        jQuery("#wiki-comment-block-<?php echo $comment['id']; ?> .wiki-left").attr('class', "wiki-left "+instOrStud);
    });
</script>