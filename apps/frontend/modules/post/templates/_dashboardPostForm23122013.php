<?php echo $form->renderFormTag(url_for('@process_dashboard_post_form'), array(
    'id' => 'dashboard-post-form',
)) ?>
  
<?php echo $form->renderGlobalErrors() ?>
<?php echo $form->renderHiddenFields() ?>
<?php echo $form['content']->renderError() ?>

<ul class="form-menu">
    <li class="photo-add"><a id="class-upload" class="form-link">Add Photo</a></li>    
    <!--<li class="document-add"><a id="class-upload-doc" class="form-link">Add Document</a></li>-->
    <li class="document-add"><?php echo link_to('Add Document', '@document', array('tag' => 'headdocuments', 'text' => 'Documents', 'class' => 'form-link')); ?></li>
    <li class="upload-status"></li>
</ul>

<div id="post-form-widget" class="<?php if($isStaff || $sf_user->isModerator()) : echo "with-pin"; endif; ?>">
    <?php if($isStaff || $sf_user->isModerator()) : ?>
        <?php echo $form['is_pinned']->render() ?>
        <label id="pin" for="post_is_pinned"></label>
    <?php endif; ?>
    <?php echo $form['content']->render() ?>    
    <input type="image" src="<?php echo image_path('btn-post-comment-ask.png') ?>" id="form-sumit-ask" />
</div>  


<div style="display:none; margin-top:20px">    
    <?php echo $form['course_id']->render() ?>        
    <?php echo $form['type']->render() ?>
    <?php echo $form['everyone']->render() ?>
    
</div>
<?php echo $form['attachment_id']->render() ?>
<?php echo $form['attachment_url']->render() ?>
</form>
<div style="height: 16px;"></div>
    <div style="display:none; margin-top:20px">
        <?php echo $form['course_id']->render() ?>        
        <?php echo $form['type']->render() ?>
    </div>
    <?php echo $form['attachment_id']->render() ?>
    <?php echo $form['attachment_url']->render() ?>
</form>

<input type='hidden' id='tmp_course_id' value='0' />
<form id="hiddeForm" action="upload.php" method="post" enctype="multipart/form-data">
    <input name="files" id="files" type="file" style="display: none;" accept="image/*" />
</form>
