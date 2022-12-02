<?php //use_helper('wgTpl'); ?>
<?php echo $form->renderFormTag(url_for('@user_edit'), array(
    'id' => 'form_user_edit',
)); ?>
<?php echo $form->renderGlobalErrors(); ?>
<?php echo $form->renderHiddenFields(); ?>
<div id="my-profile">
	<div class="container">
                <?php // if ($user->getIsLms() != 1): ?>
                <!--<div class="my-courses-left">-->
                    <?php
//                        $routeOptions = $sf_context->getInstance()->getRouting()->getOptions();
//                        $currentUrl   = $routeOptions['context']['prefix'].$routeOptions['context']['path_info'];
//                        $routeName    = $sf_context->getInstance()->getRouting()->getCurrentRouteName();
//                        $routeUrl     = '@notification_course_list?type=course&slug=';
                     ?>
                    <?php // if (count($courses) > 0): ?>
<!--                        <span class="my-courses">My Courses
                        </span>
                        <p class="lines"></p>-->
                        <?php // foreach ($courses as $course):?>
<!--                            <div class="one-course-line" id="course-<?php // echo $course->getId(); ?>">
                                <span class="one-course-left-title">-->
                                    <?php // echo link_to($course->getShortName(), $routeUrl.$course->getId(), array(
//                                    'current-url' => $currentUrl,
//                                    'data-id' => $course->getId()
//                                )); ?>
<!--                                </span>
                                <div class="wiki-notification-left" id="post-no-<?php // echo $course->getId(); ?>" style="display: none;"></div>
                            </div>
                            <div class="clear"></div>
                            <p class="lines left-line-id-<?php // echo $course->getId(); ?>"></p>-->
                        <?php // endforeach; ?>
                    <?php // endif; ?>
                <!--</div>-->
                <?php // endif; ?>
		<div class="float-l userinfo-block">
			<div class="user-avatar">

                                <?php if($my_profile):?>
				<a href="#" title="Add new profile picture" class="tooltip2">
                                    <?php echo image_tag($user->getThumbnailImagePath(240, 240), array('class'=>(($isStaff == 1 || $isTutor == 1)?'instructor':'student'), 'size' => '240x240'));?>
				</a>
                                <?php else: ?>
                                    <?php echo image_tag($user->getThumbnailImagePath(240, 240), array('class'=>(($isStaff == 1 || $isTutor == 1)?'instructor':'student'), 'size' => '240x240'));?>
                                <?php endif; ?>

                                <div id="wg-user-logo" class="wiki-hide-9">
                                <?php echo $form['image']->render(array(
                                    'id' => 'file-ava',
                                    'data-upload-feedback' => 'Update profile pic...'
                                )) ?>
                                </div>

                                <?php if($my_profile):?>
				<div id="wg-profile-ava" class="avatar-overlay">
                                    <p class="avatar-overlay-add-icon"></p>
                                    <span class="avatar-overlay-title">Add new profile picture</span>
				</div>
                                <?php endif; ?>
			</div>

			<div class="user-info">
                            <?php foreach($user->getUserSchool() as $school): ?>
                                <?php if ($isStaff == 1 || $isTutor == 1): ?>
                                    <span class="user-name float-l"><?php echo $userNameCaption; ?></span>
                                <?php else: ?>
                                    <span class="user-name float-l"><?php echo $userNameStudentCaption; ?></span>
                                <?php endif; ?>
				<?php if (!$isStaff && $my_profile && $isTutor == 0): ?>
                                <span class="user-edit-button float-r" style="white-space: nowrap;">
					<a id="edit-graduate-info" href="#" class="tooltip4" title="Edit your info">
						<?php echo image_tag('new_design/wiki-pen-1.png', array('size'=>'15x15')) ?>
					</a>
                                <?php endif; ?>
                                </span>
				<span class="clear"></span>
				<span class="user-grade">
                                        <?php if ($user->getIsOfficer() == 1): ?>
                                            Officer
                                        <?php else: ?>
                                               <?php if ($isStaff == 1): ?>
                                                   <?php if ($isTutor == 1): ?>
                                                       Tutor
                                                   <?php else: ?>
                                                       Instructor
                                                   <?php endif; ?>
                                               <?php else: ?>
                                                       <?php if ($isTutor == 1): ?>
                                                            Tutor
                                                        <?php else: ?>
                                                            Student
                                                       <?php endif;?>
                                               <?php endif; ?>
                                                
                                        <?php endif; ?>
				</span>

				<span class="user-university"><?php echo $school->getSchool()->getName(); ?></span>
				<span class="user-graduate"><?php echo $school->getClassYear() ? 'Class of '.$school->getClassYear() : '' ?></span>
				<span class="user-major">
                                    <?php $major = $school->getMajorOrPrimaryDepartmentName(); ?>
                                    <?php if ($major): ?>
                                        <?php if (strtolower($major) != strtolower("Major")): ?>
                                            <?php echo 'Majoring in '.$major; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
                                <?php break; ?>
                            <?php endforeach; ?>
			</div>
                    <?php if(!$form->getObject()->getIsStaff()):?>
                        <?php foreach ($form->getObject()->getUser()->getSchools() as $school): ?>
                            <?php $form_name = $school->getUserSchoolFormName(); ?>
                            <?php $formSchool = $form[$form_name]; ?>
                        <div class="user-graduate-editor">
                                <?php
                                    $defaultval = 'Major';
                                    echo $formSchool['major']->render(array(
                                        'class' => 'graduate-input',
                                        'maxlength' => '50',
                                        'onfocus' => 'formFieldFocus(this,"'.$defaultval.'",0)',
                                        'onblur' => 'formFieldBlur(this,"'.$defaultval.'",0)'));
                                ?>
                            <div class="custom-select class-year-select">
                                <?php echo $formSchool['class_year']->render() ?>
                            </div>
                            <button data-close="wg-close-button-3" class="save-new-graduate wiki-form-submit-profile" type="button">Save</button>
                            <button id="wg-close-button-3" class="cansel-graduate-editor float-r" type="button">Cancel</button>
                            <div class="clear"></div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div class="wiki-float-row"></div>
		</div>
		<div class="float-l user-actions">
                    <?php if($user->getIsLms() != 1): ?>
			<div class="user-courses">
                                <?php 
                                    if($isStaff==1 || $isTutor==1): 
                                        if ($isStaff==1):
                                            $schoolId = $school->getSchool()->getId();
                                        endif;
                                        
                                        if ($isTutor==1):
                                            $schoolId = $school->getId();
                                        endif;
                                ?>
                                <span class="actions-title float-l"><?php if($my_profile):?>My <?php endif; ?>Courses</span>
				<span class="user-edit-button float-l">
                                    <?php if($my_profile):?>
                                    <a id="create-course" href="#" class="tooltip4" title="Join a course">
                                        <?php echo image_tag('new_design/add-button.png', array('size'=>'16x16')) ?>
                                    </a>
                                    <?php endif; ?>
				</span>
				<div class="clear"></div>                                
             <div id="edit-course-box" class="create-course-box editbox">
    <div>
            <?php
            $defaultval = "Subject/Department Name, e.g. Chemistry";
            echo $departmentForm['name']->render(array(
                'class' => 'sdnc',
                'placeholder' => $defaultval
            )); ?>
        </div>
        <div>
                <?php
                $defaultval = "Subject Code, e.g. ENGL";
                echo $departmentForm['alias']->render(array(
                    'class' => 'cn-1',
                    'placeholder' => $defaultval
                )); ?>
           </div>
        <div> 
                <?php
                $defaultval = "Course Number, e.g. 121";
                echo $courseForm['code']->render(array(
                    'class' => 'cn-2',
                    'placeholder' => $defaultval
                )); ?>
            </div>
        <div>
            <?php
            $defaultval = "Course Title";
            echo $courseForm['name']->render(array(
                    'class' => 'sdnc',
                    'placeholder' => $defaultval
                )); ?>
            </div>
        <input id="school_id" type="hidden" value="<?php echo $schoolId; ?>"/>
<div class="clear"></div>
    <div class="editbox-control">
        <button id="wg-cancel-button-1" class="cansel-course-box float-r cancel-button" type="button">Cancel</button>
	<button data-con="wg-cancel-button-1" class="add-new-course float-r wg-form-add-instructor-course" type="button">Create</button>
	<div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
                            <?php include_partial('sfGuardUser/formCourse', array('form' => $formCourse)); ?>
                                <?php elseif ($user->getIsLms() != 1): ?>
                                    <?php if($my_profile):?>
                                <span class="actions-title float-l"><?php if($my_profile):?>My <?php endif; ?>Courses</span>
				<span class="user-edit-button float-l">
                                    <?php if($my_profile):?>
                                    <a id="join-course" href="#" class="tooltip4" title="Join a course">
                                        <?php echo image_tag('new_design/add-button.png', array('size'=>'16x16')) ?>
                                    </a>
                                    <?php endif; ?>
				</span>
				<div class="clear"></div>
                                        <?php include_partial('sfGuardUser/formCourse', array('form' => $formCourse)); ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                               
				<p class="lines"></p>
				<div class="course-list">
					<?php $courseCount = 0; ?>
					<?php foreach($courses as $c): ?>
						<?php if ($c->getCategory() != $c->getName()): ?>
						<?php $courseCount++; ?>
							<div class="one-course-line" id="<?php echo $c->getId(); ?>">
                                                                <?php if ($c->getDepartment()): ?>
								<span class="one-course-id"><?php echo $c->getDepartment()->getAlias(). $c->code ?></span>
                                                                <?php endif; ?>
								<span class="one-course-title">
                                                                    <?php echo link_to2($c->name, "notification_course_list", array("type"=>"course", "slug"=>$c->getId())); ?>
                                                                </span>
								<div class="remove-icon">
                                                                    <?php if($my_profile):?>
                                                                        <a class="wg-course-delete tooltip4 leave-community" data-id="<?php echo $c->getId(); ?>" href="<?php echo url_for('@ajax_course_delete?id='.$c->getId()); ?>" title="Remove course">
                                                                            <?php echo image_tag('new_design/wiki-close.png', array('size' => '14x14')); ?>
                                                                        </a>
                                                                    <?php endif; ?>
								</div>
							</div><div class="clear"></div>
							<p class="lines main-line-id-<?php echo $c->getId(); ?>"></p>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<?php // display if no courses ?>
				<?php if (!$courseCount): ?>
					<span class="brief-description"><?php if($my_profile):?>You <?php endif; ?>haven’t enrolled in any courses.</span>
				<?php endif; ?>
			</div>
                    <?php endif; ?>
<?/*
			<div class="user-communities">
				<span class="actions-title float-l">My Communities</span>
				<span class="user-edit-button float-l">
					<a id="join-community" href="#" class="tooltip" title="Join a new community">
						<?php echo image_tag('new_design/add-button.png', array('size'=>'16x16')) ?>
					</a>
				</span>
				<div class="clear"></div>
				<div class="join-community-box editbox">
					<span class="editbox-title">Join a comunity by selecting it from the list below and clicking "Join".</span>
					<div class="custom-select community-select">
                                            <?php
                                                echo $formCourse['category']->render(array(
                                                    'id' => 'wiki-sel-cat'));
                                            ?>
					</div>
					<div class="editbox-control">
						<button id="wg-cancel-button-2" class="cansel-community-box float-r cancel-button" type="button">Cancel</button>
						<button data-con="wg-cancel-button-2" class="join-community float-r wg-form-add-course" type="button">Join</button>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<p class="lines"></p>
				<div class="course-list">
					<?php $communityCount = 0; ?>
					<?php foreach($courses as $c): ?>
						<?php if ($c->getCategory() == $c->getName()): ?>
							<?php $communityCount++; ?>
							<div class="one-course-line">
								<span class="one-course-title"><?php echo $c->name; ?></span>
								<div class="remove-icon">
									<a id="leave-community" href="<?php //echo url_for('@ajax_course_delete?id='.$c->id); ?>" class="tooltip leave-community" title="Leave community">
										<?php echo image_tag('new_design/wiki-close.png', array('size' => '14x14')); ?>
									</a>
								</div>
							</div>
							<p class="lines"></p>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<?php // display if no community ?>
				<?php if (!$communityCount): ?>
					<span class="brief-description">You haven’t joined any communities.</span>
				<?php endif; ?>
			</div>
*/?>
                        <div class="user-about <?php if(!$isStaff){ echo 'float-l'; } else { echo 'float-l'; } ?>">
				<span class="actions-title float-l">About<?php if($my_profile):?> Me<?php endif; ?></span>
				<span class="user-edit-button float-l">
                                    <?php if($my_profile):?>
					<a id="edit-about-info" href="#" class="tooltip4" title="Edit your info">
						<?php echo image_tag('new_design/wiki-pen-1.png', array('size'=>'15x15')) ?>
					</a>
                                    <?php endif; ?>
				</span>
				<div class="clear"></div>
				<div class="user-about-editor editbox">
                                    <?php if($my_profile):?>
					<?php echo $form['about']->render(array('class' => 'about-textarea')) ?>
					<?php echo $form['about']->renderError() ?>
					<button id="wg-close-button-1" class="cansel-about-editor float-r cancel-button" type="button">Cancel</button>
					<button data-close="wg-close-button-1" class="save-new-about float-r wiki-form-submit-profile" type="button">Save edits</button>
					<div class="clear"></div>
                                    <?php endif; ?>
				</div>
				<p class="lines"></p>
				<span id="about" class="brief-description">
                                    <?php if (strlen($profile['about']) > 0 && $my_profile): ?>
                                        <?php echo $profile['about']; ?>
                                    <?php else: ?>
                                        <?php if(!$my_profile):?>
                                            <?php echo $user->getSfGuardUserProfile()->getAbout(); ?>
                                        <?php else: ?>
                                            Add a brief description about yourself
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
			</div>
			<div class="user-interests clear-r float-l">
				<span class="actions-title float-l"><?php if($my_profile):?>My <?php endif; ?>Interests</span>
				<span class="user-edit-button float-l">
                                    <?php if($my_profile):?>
					<a id="edit-interests-info" href="#" class="tooltip4" title="Edit your interests">
						<?php echo image_tag('new_design/wiki-pen-1.png', array('size'=>'15x15')) ?>
					</a>
                                    <?php endif; ?>
				</span>
				<div class="clear"></div>
				<div class="user-interests-editor editbox">
                                    <?php if($my_profile):?>
					<?php echo $form['activity']->render(array('class' => 'interests-textarea')) ?>
					<?php echo $form['activity']->renderError() ?>
					<button id="wg-close-button-2" class="cansel-interests-editor float-r cancel-button" type="button">Cancel</button>
					<button data-close="wg-close-button-2" class="save-new-interests float-r wiki-form-submit-profile" type="button">Save edits</button>
					<div class="clear"></div>
                                    <?php endif; ?>
				</div>
				<p class="lines"></p>
				<span id="interests" class="brief-description">
                                    <?php if (strlen($profile['activity']) > 0 && $my_profile): ?>
                                        <?php echo $profile['activity']; ?>
                                    <?php else: ?>
                                        <?php if(!$my_profile):?>
                                            <?php echo $user->getSfGuardUserProfile()->getActivity(); ?>
                                        <?php else: ?>
                                            Add a few of your interests.
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
			</div>

			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
</form>

<?php if($my_profile):?>
<?php echo $formCourse->renderFormTag(url_for('@course_add'), array(
    'id' => 'form-course-add',
    'class' => 'global-form-style-hide'
)); ?>
    <?php echo $formCourse->renderGlobalErrors() ?>
    <?php echo $formCourse->renderHiddenFields() ?>
    <input id="wg-input-dep" type="text" name="course_add[department_id]" value="" />
    <input id="wg-input-cour" type="text" name="course_add[course_id]" value="" />
    <input id="wg-input-cat" type="text" name="course_add[category]" value="" />
    <input id="btn-add-course" type="image" style="float: right;" value="submit" src="<?php echo image_path('btn-done.png') ?>" />
</form>
<?php endif; ?>