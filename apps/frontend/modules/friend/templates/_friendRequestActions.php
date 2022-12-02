<?php if ($sf_user->getGuardUser() instanceof sfOutputEscaper) : ?>
    <?php $sf_guard_user = $sf_user->getGuardUser()->getRawValue() ?>
<?php else : ?>
    <?php $sf_guard_user = $sf_user->getGuardUser(); ?>
<?php endif; ?>

<?php if ($friend instanceof sfOutputEscaper) : ?>
    <?php $friend = $friend->getRawValue() ?>
<?php endif; ?>



<?php //$data_id is set to determine which element is going to be updated when this partial is called multiple times in same page ?>
<?php $data_id = isset($data_id) && $data_id ? $data_id : null;?>

<?php // If user is friend, allow to unfriend ?>
<?php if($sf_guard_user->hasFriend($friend)) : ?>

    <?php echo content_tag('a', 'Unfriend', array(
        'class' => 'friend-action',
        'data-url' => url_for('@ajax_friend_delete?id='.$friend->getId()),
        'data-id' => $data_id

    )) ?>

<?php // If user has requested this friend but friend has not responded, show pending request message ?>
<?php elseif ($sf_guard_user->hasFriendRequest($friend, FriendRequest::PENDING_STATUS)) : ?>
  
    <DIV>Pending Friend Request</DIV>

<?php // If user has not requested this friend at all?>        
<?php elseif(!$sf_guard_user->hasFriendRequest($friend)) : ?>

    <?php echo content_tag('a', 'Send Friend Request', array(
        'class' => 'friend-action',
        'data-url' => url_for('@ajax_friend_request_add?id='.$friend->getId()),
        'data-id' => $data_id
    )) ?>    

<?php else:?>

<?php endif; ?>
