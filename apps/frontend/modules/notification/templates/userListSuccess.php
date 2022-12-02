<div id="wiki-private-feed-main">
    <h2>
        <?php echo $courseName; ?> <span>| Private Feed Inbox</span>
    </h2>
    <table class="my-students-table" cellpadding="0" cellspacing="0">
        <tr align="left">
            <th style="padding-left: 20px;"><span style="display: block; float: left; padding-left: 10px;">Student&nbsp;name</span></th>
            <th>Messages</th>
            <th></th>
        </tr>
        <?php  ?>
        <?php foreach ($users as $user): ?>
        <tr>
            <td style="padding-left: 20px;">
                <?php echo link_to($user['full_name'], '@notification_private_feed?id='.$courseId.'&user='.$user['user_id'], array('class' => 'tooltip3 message', 'title' => '')); ?> 
            </td>
            <td style="text-align: left; padding-left: 20px;">
                <?php if ($user['post_count'] !== ' - '): ?>
                    <?php if (isset($newPosts[$user['user_id']]) && $newPosts[$user['user_id']]['post'] > 0): ?>
                        <span class="new-message"><?php echo $newPosts[$user['user_id']]['post']; ?></span>
                        <?php echo link_to('New messages', '@notification_private_feed?id='.$courseId.'&user='.$user['user_id'], array('class' => 'tooltip3 message', 'title' => '')); ?>
                        <?php if ($newPosts[$user['user_id']]['attachment']): ?>
                            <span class="new-attachment"></span>
                        <?php endif; ?>
                    <?php elseif(!isset($newPosts[$user['user_id']])): ?>
                        <span class="new-message"><?php echo $user['post_count']; ?></span>
                        <?php echo link_to('New messages', '@notification_private_feed?id='.$courseId.'&user='.$user['user_id'], array('class' => 'tooltip3 message', 'title' => '')); ?>
                        <?php if ($user['attachment'] > 0): ?>
                            <span class="new-attachment"></span>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php echo $user['post_count']." ".link_to('Messages', '@notification_private_feed?id='.$courseId.'&user='.$user['user_id'], array('class' => 'tooltip3 message', 'title' => '')); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo $user['post_count']; ?>
                <?php endif; ?>
                <span id="private-post-not-<?php echo $courseId; ?>" class="wiki-private-post-block"></span>
            </td>
            <td>
                <?php if ($user['post_date'] !== ' - '): ?>
                    <?php 
                        $lastPost = strtotime($user['post_date']);
                        $todayStart = strtotime(date('Y-m-d', time()));
                        $todayEnd = $todayStart+86400;
                    ?>
                    <?php if ($lastPost >= $todayStart && $lastPost < $todayEnd): ?>
                        <?php echo date("h:i A", $lastPost); ?>
                    <?php else: ?>
                        <?php echo date("F j, Y \a\\t h:i A", $lastPost); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo $user['post_date']; ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr><td colspan="3"><hr width="97%" height="1px" color="#d4dedf"/></td></tr>
        <?php endforeach; ?>
    </table>
</div>