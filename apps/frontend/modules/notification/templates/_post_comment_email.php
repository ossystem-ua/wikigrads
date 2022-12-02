<?php use_helper('I18N', 'Url') ?>

<?php //Check if post was done as a comment or regular post ?>

<?php 
    $doc = false;
    $img = false;
    $lnk = false;
?>

<?php if($notification = $post->getNotification()):?>
    <?php $post_type = "comment"; ?>
    <?php $course = $notification->getRelatedObject()?>
    <?php $comment_msg_doc = $comment_msg_lnk = ""; ?>
    <?php
        $attachId = $post->getAttachmentId();
        if ($attachId) {
            if ($attachId > 0) {
                $attach = Doctrine::getTable('UserAttachment')->findOneBy("id", $attachId);
                if ($attach) {
                    $img = true;
                    $comment_msg_img = 'image ('.$attach->getFile().')';
                }
            }
        }

        $docId = $post->getDocumentId();
        if ($docId) {
            if ($docId > 0) {
                $document = Doctrine::getTable('Document')->findOneBy("id", $docId);
                if ($document) {
                    $doc = true;
                    $comment_msg_doc = 'document ('.$document->getName().')';
                }
            }
        }
    ?>
<?php else: ?>
    <?php $post_type = "post"; ?>
    <?php $course = $post->getCourse();?>
    <?php $comment_msg_doc = $comment_msg_img = $comment_msg_lnk = ""; ?>
    <?php
        $attachId = $post->getAttachmentId();
        if ($attachId) {
            if ($attachId > 0) {
                $attach = Doctrine::getTable('UserAttachment')->findOneBy("id", $attachId);
                if ($attach) {
                    $img = true;
                    $comment_msg_img = 'image ('.$attach->getFile().')';
                }
            }
        }

        $docId = $post->getDocumentId();
        if ($docId) {
            if ($docId > 0) {
                $document = Doctrine::getTable('Document')->findOneBy("id", $docId);
                if ($document) {
                    $doc = true;
                    $comment_msg_doc = 'document ('.$document->getName().')';
                }
            }
        }
        
        $linkId = $post->getLinkDataId();
        if ($linkId) {
            if ($linkId > 0) {
                $link = Doctrine::getTable('LinkData')->findOneBy("id", $linkId);
                if ($link) {
                    $lnk = true;
                    $comment_msg_lnk = 'link ('.$link->getUrl().')';
                }
            }
        }
    ?>
<?php endif;?>

<?php
    $content = $post->getContent();
    if($content == 'Add to the conversation') {
        $content = '';
    }

    $comment_msg = $post->getUser()->getName().' made the following '.$post_type.' in '.$course->getShortName().'.<br/>';
    
    if ($doc || $img || $lnk) {
        $comment_msg .= " and attached ";
    }
    
    if ($doc && !$img && !$lnk) {
        $comment_msg .= $comment_msg_doc;
    } elseif (!$doc && $img && !$lnk) {
        $comment_msg .= $comment_msg_img;
    } elseif (!$doc && !$img && $lnk) {
        $comment_msg .= $comment_msg_lnk;
    } elseif ($doc && $img && !$lnk) {
        $comment_msg .= $comment_msg_doc." and ".$comment_msg_img;
    } elseif ($doc && !$img && $lnk) {
        $comment_msg .= $comment_msg_doc." and ".$comment_msg_lnk;
    } elseif (!$doc && $img && $lnk) {
        $comment_msg .= $comment_msg_img." and ".$comment_msg_lnk;
    } elseif ($doc && $img && $lnk) {
        $comment_msg .= $comment_msg_doc.", ".$comment_msg_img." and ".$comment_msg_lnk;
    }
?>

<?php echo __(<<<EOM
<p>
    Hi $user_first_name,
</p>

<p>
$comment_msg 
</p>

<p>
%3%
</p>

<p>
Happy collaborating!

<br/>
-Lucas & the WikiGrads team.

</p>
EOM
, array(
    "%1%" => $post->getUser()->getName(),
    "%3%" => url_for('@dashboard', true)
)) ?>