<?php use_helper('wgTpl'); ?>

<div class="comment-row clear-float">
    <div class="col-1">
        <?php echo link_to(image_tag(getUserThumbnail($post_detail_updated['user_id'], $post_detail_updated['user_image'], '32', 0, 0, 1)),'@user?id='.$post_detail_updated['user_id'].'&name='.Utils::slugify($post_detail_updated['user_name'] ))?>
    </div>
    <div class="col-2">
        <div class="name">
            <div class="user-name"><?php echo link_to($post_detail_updated['user_name'], '@user?id='.$post_detail_updated['user_id'].'&name='.Utils::slugify($post_detail_updated['user_name'] ))?></div>
        </div>
        <div class="content"><?php echo $post_detail_updated['content'] ?></div>
        <div class="created-at">
            Posted <?php echo formatDatetime($post_detail_updated['created_at'], null, isset($timezone) ? $timezone : null) ?>
        </div>
    </div>
</div>