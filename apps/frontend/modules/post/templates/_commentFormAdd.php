<?/*
<?php if ($notification instanceof sfOutputEscaper) : ?>
    <?php $notification = $notification->getRawValue() ?>
<?php endif; ?>
 */?>

<?php echo $form->renderFormTag(url_for('@ajax_comment_add?notification_id='.$notification->getId()), array(
    'id' => 'form-comment-add0-'.$notification->getId(),
    'class' => 'comment-add-form clear-float',
    'data-id' => $notification->getId()
)) ?>

    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form->renderHiddenFields() ?>

<div class="wiki-add-to-coversation-wiki" id="wiki-add-to-coversation-wiki-comment-block-<?php echo $notification->getId(); ?>">
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
                    'class'=>'wg-edit-area wg-textarea-no-border')) ?>
            </div>
            <div class="ahrefdiv">
                <a class="img-upl"></a>
            </div>
            <div class="ahrefdiv">
                <a class="doc-upl"></a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="wiki-right">
            <a class="wg-post-button-edit-2 href-cursor" data-id="<?php echo $notification->getId(); ?>" OnClick="onSendEditForm(this, 'form-comment-add0-', 2, 1);" title="Post">Post</a>
        </div>
        <div class="clear"></div>
    </div>
</div>
    <div style="display: none;">
        <input type="image" src="<?php echo image_path('btn-post.png') ?>" style="vertical-align: bottom;"/>
        <?php echo $form['content']->renderError() ?>
    </div>
</form>
