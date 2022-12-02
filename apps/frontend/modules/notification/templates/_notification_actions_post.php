<?php  echo link_to('Edit', '@ajax_post_edit?notification_id='.$notification_id, array(
    'data-id' => $notification_id,
    'class'   => 'post-edit-link'    
)) ?>