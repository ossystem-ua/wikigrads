<?php if ($notification instanceof sfOutputEscaper) : ?>
    <?php $notification = $notification->getRawValue() ?>
<?php endif; ?>

<?php echo $form->renderFormTag(url_for('@ajax_comment_add?notification_id='.$notification->getId()), array(
    'id' => 'form-comment-add-'.$notification->getId(),
    'class' => 'comment-add-form clear-float',
    'data-id' => $notification->getId()
)) ?>
<?php
    $user_staff = 0;
        $result = Doctrine::getTable('InstructorCourse')
            ->createQuery('c')
            ->where('c.user_id = ?', $profile->getId())
            ->andWhere('c.course_id = ?', $courseId)
            ->execute();
        if (count($result) > 0) {
            $user_staff = 1;
        }
?>
    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form->renderHiddenFields() ?>

<div class="wiki-add-to-coversation-wiki" id="wiki-add-to-coversation-wiki-comment-block-<?php echo $notification->getId(); ?>">
    <span class="wg-required" id="wg-status-comm-<?php echo $notification->getId(); ?>"></span>
    <div class="add-to-conv-holder">
        <div class="photo-area">
            <?php if (isset($profile)): ?>
                <?php echo (image_tag($profile->getThumbnailImagePath(100, 100), array('class' => 'add-to-conv-form'))); ?>
            <?php endif; ?>
        </div>
        <div class="text-area">
            <div class="txtdiv">
                <?php echo $form['content']->render(array(
                    'rows'=>'1',
                    'value'=>'post a comment',
                    'class'=>'wg-edit-area wg-textarea-no-border wg-form-comm-'.$notification->getId())) ?>
            </div>
            <div class="ahrefdiv">
                <a id="wiki-comment-fx" href="#" onclick="javascript:OpenLatexEditor(<?php echo $notification->getId(); ?>)" class="tooltip3 fx-add wg-none-href" title="fx" data-id="<?php echo $notification->getId(); ?>">fx</a>
            </div>
            <div class="ahrefdiv">
                <a href="#" class="tooltip4 img-upl wg-none-href" title="Upload image" data-id="<?php echo $notification->getId(); ?>"></a>
            </div>
            <div class="ahrefdiv">
                <a href="#" class="doc-upl wg-none-href tooltip4" title="Upload document" data-id="<?php echo $notification->getId(); ?>"></a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="wiki-right wg-submit-block" data-id="<?php if ($user_staff==1) echo 'wg-instructor'; else echo 'wg-student'; ?>">
            <a class="tooltip3 wg-post-button-edit-2 href-cursor" data-id="<?php echo $notification->getId(); ?>" OnClick="onSendEditForm(this, 'form-comment-add-', 2, 1);" title="Post">Post</a>
        </div>
        <div id="equation-field-<?php echo $notification->getId(); ?>"  style="display: none;">
            <?php echo image_tag('new_design/wiki-close.png', array('id' => 'delete-equation-'.$notification->getId(), 
                                                                    'class' => 'delete-comment-equation',
                                                                    'onclick'=>'deleteEquation('.$notification->getId().')')); ?>
            <div id="wg-show-comment-equation-<?php echo $notification->getId(); ?>" style="display: none;" class="wg-comment-equation"></div>
            <div id="wg-comment-equation-text-<?php echo $notification->getId(); ?>" style="display: none;"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="wg-form-comment-status">
        <div id="wiki-comm-attach-doc-<?php echo $notification->getId(); ?>" style="display:none !important" class="wiki-inline wg-attach-block"><span></span><a class="wg-close wg-close-w tooltip" title="Delete" OnClick="onClearAttached('wiki-comm-attach-doc-', <?php echo $notification->getId(); ?>, 1);">&nbsp;</a></div>
        <div id="wiki-comm-attach-img-<?php echo $notification->getId(); ?>" style="display:none !important" class="wiki-inline wg-attach-block"><span></span><a class="wg-close wg-close-w tooltip" title="Delete" OnClick="onClearAttached('wiki-comm-attach-img-', <?php echo $notification->getId(); ?>, 2);">&nbsp;</a></div>
    </div>
</div>
    <div style="display: none;">
        <input type="image" src="<?php echo image_path('btn-post.png') ?>" style="vertical-align: bottom;"/>
        <?php echo $form['content']->renderError() ?>
        <?php echo $form['attachment_id']->render(array('id' => 'com-att-id-'.$notification->getId())) ?>
        <?php echo $form['document_id']->render(array('id' => 'com-doc-id-'.$notification->getId())) ?>
        <?php echo $form['attachment_url']->render(array('id' => 'com-att-url-'.$notification->getId())) ?>
    </div>
</form>

<div style="display: none;">
    <form name="hiddeFormLoadImageComment" id="hiddeFormLoadImageComment-<?php echo $notification->getId(); ?>" action="upload.php" method="post" enctype="multipart/form-data">
        <input data-id="<?php echo $notification->getId(); ?>" name="files" class="files-comment-<?php echo $notification->getId(); ?>" id="files-comment" type="file" accept="image/*" />
        <input type="reset"/>
    </form>
    <form name="hiddeFormLoadDocComment" id="hiddeFormLoadDocComment-<?php echo $notification->getId(); ?>" action="<? echo url_for('@useruploaddoc') ?>" method="post" enctype="multipart/form-data">
        <input data-id="<?php echo $notification->getId(); ?>" name="file" class="docs-comment-<?php echo $notification->getId(); ?>" id="docs-comment" type="file" />
        <input type="text" id="doc-course-id" name="course_id" value="<?php echo $courseId; ?>" />
        <input type="text" id="doc-name" name="name" />
        <textarea id="doc-desciption" name="description"></textarea>
        <input type="reset"/>
    </form>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
       var defText = 'Add to the conversation';
       var object = jQuery('.wg-form-comm-<?php echo $notification->getId(); ?>');
       var value = object.val();
       if (value == '') {
           object.val(defText);
       }

       object.focus(function(){
           var val = object.val();
           if (val == defText) {
               object.val('');
           }
       });

       object.blur(function(){
           var val = object.val();
           if (val == '') {
               object.val(defText);
           }
       });

    });

    function onSendComm(submit, id) {
        var object = jQuery('.wg-form-comm-<?php echo $notification->getId(); ?>');
        var defText = 'Add to the conversation';
        alert('<?php echo $notification->getId(); ?>');
        if (object.val() == '' || object.val() == defText) {
            if ((jQuery('#com-att-id-<?php echo $notification->getId(); ?>').val() != 0 || jQuery('#com-doc-id-<?php echo $notification->getId(); ?>').val() != 0)) {
                onSendEditForm(submit, id, 2, 1);
            } else {
                jQuery('#wg-status-comm-<?php echo $notification->getId(); ?>').html('Required');
            }
        } else {
            onSendEditForm(submit, id, 2, 1);
        }
    }

    function onClearAttached(objectId, dataId, type) {
        jQuery('#'+objectId+dataId+' span').html('');
        jQuery('#'+objectId+dataId).attr('style', 'display: none !important');

        /*
         * TYPE
         * 1 - Document
         * 2 - Image
         */
        switch (type) {
            case 1: {
                jQuery('#com-doc-id-'+dataId).val(0);
            }break;
            case 2: {
                jQuery('#com-att-id-'+dataId).val(0);
                jQuery('#com-att-url-'+dataId).val('');
            }break;
        }
    }
</script>