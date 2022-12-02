<?php use_helper('wgTpl'); ?>
<?php slot('content-title'); ?>
my_profile
<?php end_slot(); ?>
<?php slot('changeprofile'); ?>
<?php end_slot(); ?>
<div id="my-profile">
    <div class="content-inputarea">

        <div class="btn-toggle-container"><a href="#" id="collapse-summary" class="togarw-up-lgt"></a></div>

        <?php if(!$my_profile):?>
            <div>
                <div class="user-name"><?php echo $user->getName()?></div>
                <div><?php echo image_tag($user->getThumbnailImagePath(200, 200));?></div>

            </div>
        <?php endif; ?>

        <div id="profile-summary">
            <?php foreach($user->getUserSchool() as $school): ?>
                <div class="row-1">
                    <div class="col-1 heading">School: <span class="font-normal"><?php echo $school->getSchool()->getName(); ?></span></div>
                    <?php if(!$profile->getIsStaff()):?>
                        <div class="col-2 heading">Major: <span class="font-normal"><?php if ($school->getMajorOrPrimaryDepartmentName()): ?><?php echo $school->getMajorOrPrimaryDepartmentName(); ?><?php endif; ?></span></div>
                        <div class="col-3 heading">Class: <span class="font-normal"><?php echo $school->getClassYear() ? ' '.$school->getClassYear() : '' ?></span></div>
                    <?php endif;?>
                    <div class="clear-force"></div>
                </div>
            <?php endforeach; ?>

            <hr />
            <div class="row-3" id="courses-quick-list">
                <div class="col-1"><div class="heading">Courses</div></div>
                <div class="col-2">
                    <?php if(isset($courses)): ?>
                        <table>
                            <?php foreach($courses as $c): ?>
                                <tr>
                                    <td><?php if ($c->getDepartment()): ?><?php echo $c->getDepartment()->getAlias(). $c->code ?> &ndash; <?php echo truncateString($c->name, 45) ?><?php else: ?>&nbsp;<?php endif; ?></td>
                                    <td class="td-remove">
                                    <?php if ($my_profile) : ?>
                                        <?php echo content_tag('a', '', array(
                                            'data-url' => url_for('@ajax_course_delete?id='.$c->id),
                                            'class' => 'btn-remove course-delete'
                                        )); ?>
                                    <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif;?>
                </div>
                <div class="clear-force"></div>
<?php if($my_profile): ?>
                <div class="btn-edit-courses">
                    <?php echo link_to(image_tag('btn-addcourses.png'), '@course_add'); ?>
                </div>
<?php endif; ?>
            </div>
        </div>
    </div>

    <div class="content-pad">
<?php if(0): ?>
        <h1>TODO: MESSAGE LIST</h1>
        <p>only shows messages sent from other users (wikimates/nonwikimates) to you.  non-threaded.</p>
<?php endif; ?>

<?php if(!$my_profile): ?>
            <div class="friend-request-actions">
                <?php
                    include_partial('friend/friendRequestActions', array(
                        'friend' => $user,
                    ));
                ?>
            </div>

<?php endif;?>

    </div>

</div>