<?php echo $form->renderFormTag(url_for('@user_edit'), array(
    'id' => 'form_user_edit',
)); ?>
    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form->renderHiddenFields() ?>
<div id="privacy">
	<div class="container">
		<p class="page-title">Privacy & Settings</p>
		<form action="">
                    <?php //var_dump($icourses); exit;?>
                        <?php if (count($icourses) > 0 && !$user->getIsLms()): ?>
			<div class="section">
				<div class="title-block float-l"><span>Student Enrollment</span></div>
				<div class="content-block float-l">
					<p class="code-require">
                                                Require students to enter a code in order to join your class?
                                                <span class="code-radio">
                                                    <?php echo $form['enter_code']->render(array('type' => 'radio', 'value' => '0', 'id' => 'wg-radion-def')) ?>
                                                    No
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?php echo $form['enter_code']->render(array('type' => 'radio', 'value' => '1')) ?>
                                                    Yes
                                                </span>

                                        </p>
                                        <div class="code-input">
						<input id="wg-code-edit" type="text" name="code" placeholder="Enter code"> for
						<div class="custom-select class-select">
                                                    <select id="wg-course-edit">
                                                        <option>Choose class</option>
                                                        <?php foreach ($icourses as $course): ?>
                                                            <option value="<?php echo $course->getCourseId(); ?>"><?php echo $course->getCourse()->getShortName(); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
						</div>
						<button id="wg-set-course-button" type="button">Set Code</button>
					</div>
					<div class="code-table-header">
						<p>
							<span class="course">Course</span>
							<span class="code">Code</span>
						</p>
					</div>
					<table border="1" class="code-list" cellspacing="10" cellpadding="5">
                                            <tbody>
                                                <?php foreach ($icourses as $c): ?>
                                                <?php if ($c->getAccess()): ?>
                                                <tr id="course-instructor-<?php echo $c->getCourseId(); ?>">
                                                    <td class="code-course"><?php echo $c->getCourse()->getShortName(); ?></td>
                                                    <td class="code value">
							<div class="code-value-inner">
                                                            <span id="status-access-<?php echo $c->getCourseId(); ?>"><?php echo $c->getAccess(); ?></span>
                                                            <div class="remove-icon">
								<!--<a id="leave-community" class="wg-course-delete" data-id="<?php //echo $c->getCourseId(); ?>" href="#" class="tooltip leave-community" title="Delete code">
                                                                    <?php //echo image_tag('new_design/wiki-close.png', array('size' => '14x14')); ?>
                                                                </a>-->
                                                                <a class="wg-delete-coure-code tooltip4 leave-community" data-id="<?php echo $c->getCourseId(); ?>" href="" title="Delete code">
                                                                    <?php echo image_tag('new_design/wiki-close.png', array('size' => '14x14')); ?>
								</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </tbody>
					</table>
				</div>

				<div class="clear"></div>
			</div>
                        <?php endif; ?>
			<div class="section">
				<div class="title-block float-l"><span>Email Settings</span></div>
				<div class="content-block float-l">
                                        <p class="email-settings">
                                            <?php if ($profile->getIsStaff()): ?>
                                                <?php echo $form['email_post']->render(); ?> Email me when any new post or comment is made in the "Course Feed" or "Private Feeds"<br>
                                                <?php echo $form['email_reply']->render(); ?> Only email me when students comment on one of my posts in the "Course Feed" or write me a private post<br>
                                                <?php echo $form['email_private']->render(); ?> Only email me when students write me private posts<br>
                                                <?php echo $form['email_from']->render(); ?> I do not wish to receive any emails from WikiGrads
                                            <?php else: ?>
                                                <?php echo $form['email_post']->render(); ?> Email me when any new post or comment is made in the "Course Feed" or "Private Feeds"<br>
                                                <?php echo $form['email_reply']->render(); ?> Only email me when: 1) I receive a comment to one of my posts in the "Course Feed",	2) an instructor writes me a private post, or 3) an instructor writes a post in the "Course Feed"<br>
                                                <?php echo $form['email_private']->render(); ?> Only email me when an instructor writes me a private post<br>
                                                <?php echo $form['email_from']->render(); ?> I do not wish to receive any emails from WikiGrads
                                            <?php endif; ?>
                                        </p>
				</div>
				<div class="clear"></div>
			</div>
                    <?php if (!$user->getIsLms()): ?>
			<div class="section">
				<div class="title-block float-l"><span>Change Email Address</span></div>
				<div class="content-block float-l">
					Your current email address is
                                        <span class="email">
                                            <?php echo $profile['email']; ?>
                                        </span>
					<p class="new-email">
                                            <span id="wg-email-status"></span><br/>
                                            <input id="wg-new-email" type="text" name="newemail" placeholder="New email address">
                                            <button id="wg-update-email" type="button">Update</button>
					</p>
                                        <div id="status-email"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="section">
				<div class="title-block float-l"><span>Change Password</span></div>
				<div class="content-block float-l">
                                    <p class="new-password">
                                        <input id="wg-pass-current" type="password" name="currentpassword" placeholder="Current password"><br>
					<input id="wg-pass-new-1" type="password" name="newpassword" placeholder="New password"><br>
					<input id="wg-pass-new-2" type="password" name="confirmpassword" placeholder="Confirm new password">
                                        <button id="wg-update-pass" type="button">Update</button>
                                    </p>
                                    <div id="status-pass"></div>
				</div>
				<div class="clear"></div>
			</div>
                    <?php endif; ?>
			<div class="section">
				<div class="title-block float-l"></div>
				<div class="content-block float-l">
					<button id="wg-save-all-changes" type="button" class="save-all-changes">Save all changes</button>
				</div>
				<div class="clear"></div>
			</div>
		</form>
	</div>
</div>
<div class="wiki-float-row"></div>
</form>