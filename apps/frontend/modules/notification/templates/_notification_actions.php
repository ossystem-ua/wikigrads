<?php  echo link_to('Comment', '@ajax_comment_add?notification_id='.$notification_id, array(
    'data-id'   =>  $notification_id, 
    'class'     =>  'comment-add-link'
)) ?> 