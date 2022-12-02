<div class="wiki_header_line<?php if (!$loggedIn): ?> landing_header_line<?php endif; ?>">
<div id="wiki-header" class="<?php if ($loggedIn): ?>wiki-height-100<?php endif; ?>">
    <div class="<?php if ($loggedIn): ?>wiki-logo wiki-logo-login<?php else: ?>landing_page_logo<?php endif; ?>">
        <?php if ($loggedIn): ?>
            <?php echo link_to(image_tag('new_design/logo.png', array('height'=>'40px', 'alt'=>"WikiGrads logo", 'title' => 'Wikigrads')), "@homepage");?>
        <?php else: ?>
           <?php echo link_to(image_tag('new_design/logo_landing_page.png', array('height'=>'50px', 'alt'=>"WikiGrads logo", 'title' => 'Wikigrads')), "@homepage");?>
        <?php endif; ?>    
    </div>
    <div class="wiki-menu <?php if ($loggedIn){ echo "wiki-menu-login"; } ?>">
            <?php if ($loggedIn): ?>
                  &nbsp;
              <ul style="position: relative;">
                <?php // if ($userProfile->getIsLms() !== '0'): ?>
                    <?php // include_component('main', 'mainNav') ?>
                <?php // endif; ?>
                
                <?php //if ($userProfile->getIsLms() !== '0'): ?>
                <?php if(count($courses) > 1 && $userProfile->getIsLms() == '0'): ?>
                <li class="wiki-main-menu-auth courses course-menu" style="position: relative;"><?php echo link_to("Courses", "@dashboard", array('title' => 'Courses', 'class' => 'tooltip')); ?>
                    <span id="post-not-sum" class="wiki-notification-sum-course-block"></span>
                    <div id="wiki-main-menu-course-list" class="wiki-hide">
                        <?php include_component('main', 'mainNav'); ?>
                    </div>
                </li>
                <?php elseif ($userProfile->getIsLms() !== '0'): ?>
                    <li class="wiki-main-menu-auth courses course-menu" style="position: relative;">
                        <?php 
                        $routeOptions = $sf_context->getInstance()->getRouting()->getOptions();
                        $currentUrl   = $routeOptions['context']['prefix'].$routeOptions['context']['path_info'];
                        $routeName    = $sf_context->getInstance()->getRouting()->getCurrentRouteName();
                        $routeUrl     = '@notification_course_list?type=course&slug=';
//                        echo link_to($course->getId(), $routeUrl.$course->getId(), array('title' => '', 'class' => 'tooltip')); 
                        echo link_to($course->getShortName(), $routeUrl.$course->getId(), array('title' => $course->getShortName(), 'class' => 'tooltip')); ?>
                        
                        <?php //echo link_to($course->getShortName(), "@dashboard", array('title' => $course->getShortName(), 'class' => 'tooltip')); ?>
                        <span id="post-not-<?php echo $course->getId(); ?>" class="wiki-notification-sum-course-block"></span>
                    </li>
                <?php else: ?>
                    <li class="wiki-main-menu-auth courses course-menu" style="position: relative;">
                        
                        <?php 
                        $routeOptions = $sf_context->getInstance()->getRouting()->getOptions();
                        $currentUrl   = $routeOptions['context']['prefix'].$routeOptions['context']['path_info'];
                        $routeName    = $sf_context->getInstance()->getRouting()->getCurrentRouteName();
                        $routeUrl     = '@notification_course_list?type=course&slug=';
//                        $course->getShortName()
                        echo link_to($course->getShortName(), $routeUrl.$course->getId(), array('title' => $course->getShortName(), 'class' => 'tooltip')); ?>
                        
                        <?php // echo link_to($course->getShortName(), "@dashboard", array('title' => $course->getShortName(), 'class' => 'tooltip')); ?>
                        <span id="post-not-<?php echo $course->getId(); ?>" class="wiki-notification-sum-course-block"></span>
                    </li>
                <?php endif; ?>
                <?php //endif; ?>
                
                <?php if($statusUser && $userProfile->getIsLms() === '0'): ?>
                    <li class="wiki-main-menu-auth my-students"><?php echo link_to("My students", "@my_students", array('title' => 'My students', 'class' => 'tooltip')); ?></li>
                <?php endif; ?>
                <li class="wiki-main-menu-auth documents document-menu" style="position: relative;"><?php echo link_to("Documents", "@document", array('title' => 'Documents', 'class' => 'tooltip')); ?>
                    <span id="post-doc-sum" class="wiki-documents-sum-block"></span>
                    <div id="wiki-main-menu-document-list" class="wiki-hide">
                    <?php if(count($courses) > 1 && $userProfile->getIsLms() == '0'):?> 
                            <?php include_component('main', 'documentMainNav'); ?>
                    <?php endif; ?>
                    </div>
                </li>
                <li class="wiki-main-menu-auth profile"><?php echo link_to("Profile", "@my_profile", array('title' => 'Profile', 'class' => 'tooltip')); ?></li>
              </ul>
            <?php else: ?>
<!--              <ul class="wiki-menu-no-auth-ul">
                <li class="about"><?php // echo link_to("About", "@about", array('title' => 'About', 'class' => 'tooltip')); ?></li>
                <li class="how-it-works"><?php // echo link_to("How it works", "@tour", array('title' => 'How it works', 'class' => 'tooltip')); ?></li>  @tour 
              </ul>-->
            <?php endif; ?>    
    </div>
    <div class="wiki-form <?php if ($loggedIn){ echo "wiki-form-login"; } ?>">
        <?php if ($loggedIn): ?>
            <div class="wiki-auth-form">
                <?php if(!$userProfile->getIsLms()): ?>
                    <?php echo link_to(image_tag('new_design/wiki-setting.png'), '@privacy', array('tag' => 'privacy', 'text' => 'Privacy', 'class' => 'tooltip wiki-inline', 'title' => 'Privacy & Settings')); ?>
                    &nbsp;
                    <?php echo link_to(image_tag('new_design/wiki-logout.png'), '@sf_guard_signout', array('class' => 'logout-pic', 'text' => 'Logout', 'class' => 'tooltip wiki-inline', 'title' => 'Logout')); ?>
                <?php else: ?>
                    <?php echo link_to(image_tag('new_design/wiki-setting.png'), '@privacy', array('tag' => 'privacy', 'text' => 'Privacy', 'class' => 'tooltip wiki-inline', 'title' => 'Privacy & Settings')); ?>
                    &nbsp;
                    <?php echo link_to(image_tag('new_design/wiki-logout.png'), '@sf_guard_signout', array('class' => 'logout-pic', 'text' => 'Logout', 'class' => 'tooltip wiki-inline', 'title' => 'Logout')); ?>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php include_component('sfApply', 'login') ?>
        <?php endif; ?>
    </div>
</div>
</div>
