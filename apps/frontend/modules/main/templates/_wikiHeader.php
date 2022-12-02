    <?php
    $routeOptions = $sf_context->getInstance()->getRouting()->getOptions();
    $currentUrl   = $routeOptions['context']['prefix'].$routeOptions['context']['path_info'];
    $routeName    = $sf_context->getInstance()->getRouting()->getCurrentRouteName();
    $routeUrl     = '@notification_course_list?type=course&slug=';
?>
<div class="wiki_header_line<?php if (!$loggedIn): ?> landing_header_line<?php endif; ?>">
<div id="wiki-header" class="<?php if ($loggedIn): ?>wiki-height-100<?php endif; ?>">
    <div class="<?php if ($loggedIn): ?>wiki-logo wiki-logo-login<?php else: ?>landing_page_logo<?php endif; ?>">
        <?php if ($loggedIn && $userProfile->getIsLms() === '0'): ?>
            <?php echo link_to(image_tag('new_design/logo.png', array('height'=>'27px', 'alt'=>"WikiGrads logo", 'title' => 'Wikigrads')), "@homepage");?>
        <?php elseif ($loggedIn && $userProfile->getIsLms() !== '0'): ?>
            <?php echo link_to(image_tag('new_design/logo.png', array('height'=>'27px', 'alt'=>"WikiGrads logo", 'title' => 'Wikigrads')), $routeUrl.$course->getId());?>
        <?php else: ?>
            <?php echo link_to(image_tag('new_design/logo_landing_page.png', array('height'=>'40px', 'alt'=>"WikiGrads logo", 'title' => 'Wikigrads')), "@homepage");?>
            <div class="logo-title">
                Bridging Theory and Practice
            </div>
        <?php endif; ?>
    </div>
    
    <div class="wiki-menu <?php if ($loggedIn): { echo "wiki-menu-login"; } endif; ?>">
            <?php if ($loggedIn): ?>
                  &nbsp;
              <ul id="wiki-main-menu-course">
                <?php if(count($courses) > 1 && $userProfile->getIsLms() == '0'): ?>
                    <li><a href="" class="tooltip collapsed" title="Course">Course Feeds</a>
                        <ul class="course-feed">
                            <?php // include_component('main', 'mainNav'); ?>
                            <?php if (count($courses) > 0 || $userProfile->getIsOfficer() == 1): ?>
                            <?php foreach ($courses as $course): ?>
                                <li>
                                <?php echo link_to($course->getShortName(), $routeUrl.$course->getId(), array(
                                    'current-url' => $currentUrl,
                                    'data-id' => $course->getId()
                                )); ?>
                                <span id="post-not-<?php echo $course->getId(); ?>" class="wiki-notification-course-block"></span>
                                </li>
                            <?php endforeach; ?>

                            <?php if ($userProfile->getIsOfficer() == 1): ?>
                            <?php echo link_to("Officer", "@officer", array(
                                    'current-url' => $currentUrl,
                                    'data-id' => "-100"
                            )); ?>
                            <?php endif; ?>

                        <?php endif; ?>
                        </ul>
                        <span id="post-not-sum" class="wiki-notification-sum-course-block"></span>
                    </li>
                    <li><a href="" class="tooltip collapsed" title="Private Feeds">Private Feeds</a>
                        <ul class="private-feed">
                            <?php // include_component('main', 'privateFeedNav'); ?>
                            <?php if (count($courses) > 0 || $userProfile->getIsOfficer() == 1): ?>
                            <?php foreach ($courses as $course):?>
                                <li>
                                    <?php
                                     if ($statusUser) {
                                         echo link_to($course->getShortName(), '@notification_user_list?type=course&id='.$course->getId(), array(
                                             'title' => '', 
                                             'class' => 'tooltip'
                                         ));
                                     } else {
                                        echo link_to($course->getShortName(), '@notification_private_feed?id='.$course->getId().'&user='.$userId, array(
                                            'title' => '', 
                                            'class' => 'tooltip'
                                        ));
                                     }
                                     ?>
                                <span id="private-not-<?php echo $course->getId(); ?>" class="wiki-notification-course-block"></span>
                                </li>
                            <?php endforeach; ?>

                            <?php if ($userProfile->getIsOfficer() == 1): ?>
                            <?php echo link_to("Officer", "@officer", array(
                                    'current-url' => $currentUrl,
                                    'data-id' => "-100"
                            )); ?>
                            <?php endif; ?>

                        <?php endif; ?>
                        </ul>
                        <span id="post-private-sum" class="wiki-notification-sum-course-block"></span>
                    </li>
                    <?php if($statusUser && $userProfile->getIsLms() === '0'): ?>
                    <li class="stat"><a href="" class="tooltip collapsed" title="Statistics">Statistics</a>
                        <ul class="statistics">
                            <?php //include_component('main', 'statisticsNav'); ?>
                            <?php if (count($courses) > 0 || $userProfile->getIsOfficer() == 1): ?>
                            <?php foreach ($courses as $course):?>
                                <li>
                                    <?php echo link_to($course->getShortName(), '@my_students?course='.$course->getId(), array(
                                             'title' => '', 
                                             'class' => 'tooltip'));
                                    ?>
                                <span id="private-not-<?php echo $course->getId(); ?>" class="wiki-notification-course-block"></span>
                                </li>
                            <?php endforeach; ?>

                            <?php if ($userProfile->getIsOfficer() == 1): ?>
                            <?php echo link_to("Officer", "@officer", array(
                                    'current-url' => $currentUrl,
                                    'data-id' => "-100"
                            )); ?>
                            <?php endif; ?>

                        <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                <?php elseif ($userProfile->getIsLms() !== '0'): ?>
                    <li><?php echo link_to('Course Feed', $routeUrl.$course->getId(), array('title' => 'Course Feed', 'class' => 'tooltip')); ?>
                        <span id="post-not-<?php echo $course->getId(); ?>" class="wiki-notification-sum-block"></span>
                    </li>
                    <li>
                         <?php
                         if ($statusUser):
                             echo link_to("Private Feed", '@notification_user_list?type=course&id='.$course->getId(), array(
                                 'title' => 'Private Feed',
                                 'class' => 'tooltip'
                             ));
                         else:
                            echo link_to("Private Feed", '@notification_private_feed?id='.$course->getId().'&user='.$userId, array(
                                'title' => 'Private Feed',
                                'class' => 'tooltip'
                            ));
                         endif;
                         ?>
                        <span id="post-private-sum" class="wiki-notification-sum-block"></span>
                     </li>
                 <?php elseif (count($courses) <= 0): ?>
                 <?php else: ?>
                     <li><?php echo link_to('Course Feed', $routeUrl.$course->getId(), array('title' => 'Course Feed', 'class' => 'tooltip')); ?>
                        <span id="post-not-<?php echo $course->getId(); ?>" class="wiki-notification-sum-block"></span>
                    </li>
                    <li>
                        <?php
                         if ($statusUser):
                             echo link_to("Private Feed", '@notification_user_list?type=course&id='.$course->getId(), array(
                                 'title' => 'Private Feed',
                                 'class' => 'tooltip'
                             ));
                         else:
                            echo link_to("Private Feed", '@notification_private_feed?id='.$course->getId().'&user='.$userId, array(
                                'title' => 'Private Feed',
                                'class' => 'tooltip'
                            ));
                         endif;
                         ?>
                        <span id="post-private-sum" class="wiki-notification-sum-block"></span>
                    </li>
                    <?php if($statusUser && $userProfile->getIsLms() === '0'): ?>
                        <li class="stat"><?php echo link_to("Statistics", "@my_students?course=".$course->getId(), array('title' => 'My students', 'class' => 'tooltip')); ?></li>
                    <?php endif; ?>
                <?php endif; ?>
              </ul>
            <?php else: ?>
            <?php endif; ?>
    </div>
    <div class="wiki-form <?php if ($loggedIn){ echo "wiki-form-login"; } ?>">
        <?php if ($loggedIn): ?> 
            <div class="wiki-auth-form">
                <?php if(!$userProfile->getIsLms()): ?>
                <ul id="wiki-main-menu">
                  <li><a href="" class="collapsed"><?php echo image_tag($userImage); ?></a>
                    <ul>
                        <li>
                            <?php echo link_to('Privacy & Settings','@privacy', array('tag' => 'privacy', 'text' => 'Privacy', 'class' => '', 'title' => 'Privacy & Settings')); ?>
                        </li>
                        <li>
                            <?php echo link_to("Profile", "@my_profile", array('title' => 'Profile', 'class' => '')); ?>
                        </li>
                        <li>
                            <?php echo link_to('Logout', '@sf_guard_signout', array('class' => 'logout-pic', 'text' => 'Logout', 'class' => '', 'title' => 'Logout')); ?>
                        </li>
                    </ul>
                  </li>
                </ul>
                <?php else: ?>
                <ul id="wiki-main-menu">
                  <li><a href="" class="collapsed"><?php echo image_tag($userImage); ?></a>
                    <ul>
                        <li>
                            <?php echo link_to('Privacy & Settings','@privacy', array('tag' => 'privacy', 'text' => 'Privacy', 'class' => '', 'title' => 'Privacy & Settings')); ?>
                        </li>
                        <li>
                            <?php echo link_to("Profile", "@my_profile", array('title' => 'Profile', 'class' => '')); ?>
                        </li>
                        <!--<li>-->
                            <?php // echo link_to('Logout', '@sf_guard_signout', array('class' => 'logout-pic', 'text' => 'Logout', 'class' => '', 'title' => 'Logout')); ?>
                        <!--</li>-->
                    </ul>
                  </li>
                </ul>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php include_component('sfApply', 'login') ?>
        <?php endif; ?>
    </div>
</div>
</div>
