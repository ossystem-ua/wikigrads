<div class="content-pad">
    
    <?php if(count($friendRequests)):?>
        <?php foreach($friendRequests as $friendRequest):?>
            <DIV>
                <?php echo $friendRequest->getUser()->getName();?>
                <?php echo link_to('Accept', '@ajax_friend_request_respond?response=accept&user_id='.$friendRequest->getUserId())?>
                <?php echo link_to('Decline', '@ajax_friend_request_respond?response=decline&user_id='.$friendRequest->getUserId())?>
            </DIV>

        <?php endforeach; ?>
    <?php else:?>
		<H4>You have no WikiMate requests at this time.</H4>
    <?php endif;?>
</div>