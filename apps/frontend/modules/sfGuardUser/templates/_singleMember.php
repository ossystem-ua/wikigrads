<?php $last_column_class = ($index + 1)  % 3 == 0 ? 'last-column' : ''; ?>

<div class="single-member <?php echo $last_column_class?>">
    <div class="member-image">
        <?php echo link_to(image_tag($user->getThumbnailImagePath(190, 190)),'@user?id='.$user->getId().'&name='.Utils::slugify($user->getName()) )?>
    </div>

    <div class="member-name">
        <?php echo link_to($user->getName(),'@user?id='.$user->getId().'&name='.Utils::slugify($user->getName()) )?>
<!--        <div class="status-icon">--><?php //include_component('friend', 'friendStatusIcon', array('other_user_id' => $user->getId())) ?><!--</div>-->
    </div>
</div>