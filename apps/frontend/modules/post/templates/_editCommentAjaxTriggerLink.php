<?php  echo link_to('Edit', '@ajax_comment_edit?post_id='.$post_id, array(
    'data-id' => $post_id,
    'class'   => 'comment-edit-link'
)) ?>