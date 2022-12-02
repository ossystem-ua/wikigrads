<?php if($loggedIn):?> 
    <div class="newLogo">
        <?php echo link_to(image_tag("lnav-wglogo.png", array('alt'=>"WikiGrads logo", 'width'=>"", 'height'=>"32")), "@homepage");?>
    </div>  
    <?php $profileurl = ""; ?>
    <?php $iCount = 0; ?>
    <div class="top-settings"></div>    
    <?php
        $userCoursesList = $sf_user->getGuardUser()->getCourseList();
        $IsStaff = $sf_user->getGuardUser()->getStaff();
    ?>
    <?php foreach($page_links as $page_route => $link_attr):?>
        <?php 
            if (isset($link_attr["tag"]))
                if ($link_attr["tag"] == "headprofile") { $profileurl = $page_route; }
            
            if ($page_route == "@homepage") {
                $i = 0;
                $all_tab = count($userCoursesList);
                $max_rec = 5;
                if ($all_tab > $max_rec) {
                    echo '<a href="#" OnClick="return false;" id="SubscrMenu">Subscriptions</a><div id="nav">';
                }
                $itemCount = 1;
                foreach ($userCoursesList as $myCourse) {
                    $styleP = $styleC = "";
                    
                    if (isset($counters[$myCourse->getId()])) {      
                        if(!$counters[$myCourse->getId()]['new_posts']) $styleP = "style='display:none;'";
                        if(!$counters[$myCourse->getId()]['new_classmates']) $styleC = "style='display:none;'";
                    } else {
                        $styleP = "style='display:none;'";
                        $styleC = "style='display:none;'";
                    }
                    
                    $tabname = $myCourse->getShortName();                   
         
                    $i++;
                    if ($all_tab > $max_rec) {
                        $styleZ = 'vert-menu';
                    } else {
                        $styleZ = '';
                    }
                    
                    echo '<div style="display: inline;" class="href-cursor-top subcr-menu-block '.$styleZ.'">';
                    echo '<a id="ui-tabs-'.$itemCount.'" class="href-cursor" OnClick="ShowCourse('.$myCourse->getId().', '.$i.', '.$all_tab.');" style=" color: #ffffff;">'.$tabname.'</a>';
                    if (isset($counters[$myCourse->getId()])) {
                        echo '<a data-id='.$myCourse->getId().' onClick="return false;" '.$styleP.' class="new post id'.$myCourse->getId().' title="New Posts" id="tab-id-list-'.$myCourse->getId().'" >'.$counters[$myCourse->getId()]['new_posts'].'</a>';                    
                    }
                    //echo '<a data-id='.$myCourse->getId().' onClick="return false;" '.$styleC.' class="new classmate id'.$myCourse->getId().' title="New Classmates">'.$counters[$myCourse->getId()]['new_classmates'].'</a>';                    
                    echo '</div>';
                    //if (!$IsStaff) { $i++; }
                    $itemCount++;
                }
                if ($all_tab > $max_rec) {
                    echo '</div>';
                }
            } else {
                echo "".link_to(__($link_attr['text']), $page_route, isset($link_attr['options']) ? $link_attr['options']->getRawValue() : array())."";
            }
        ?>
    <?php endforeach; ?>
 
    <div class="top-setting-menu">
        <ul>
            <!--<li><?php //echo link_to('Wiki Mates', '@friend_list', array('tag' => 'friend_list', 'text' => 'WikiMates')); ?></li>-->
            <!--<li><?php //echo link_to('Wiki Requests', '@friend_request_pending_list', array('tag' => 'friend_request_pending_list', 'text' => 'WikiMate Requests')); ?></li>-->
            <?php if ($IsStaff): ?>
                <li><?php echo link_to('Privacy & Setings', $profileurl, array('text' => 'Privacy & Setings')); ?></li>
            <?php endif; ?>
            <li><?php echo link_to('New Members', '@new_member_list', array('tag' => 'new_member_list', 'text' => 'New Members')); ?></li>            
            <li><?php echo link_to('Profile', $profileurl, array('tag' => 'my_profile', 'text' => 'My Profile')); ?></li>
            <li><?php echo link_to('Change my password ', '@forgot', array('tag' => 'change_my_password ', 'text' => 'Change my password ')); ?></li>
            <li><?php echo link_to('Log out', '@sf_guard_signout', array('class' => 'logout-pic', 'text' => 'Logout')); ?></li>
        </ul>
    </div>
<?php endif; ?>