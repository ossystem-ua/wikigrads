
<?php if ($post instanceof sfOutputEscaper) : ?>
    <?php $post = $post->getRawValue() ?>
<?php endif; ?>

<?php echo $form->renderFormTag(url_for('@ajax_comment_edit?post_id='.$post->getId()), array(
    'id' => 'form-comment-edit-'.$post->getId(),
    'class' => 'clear-float post-edit-form',
    'data-id' => $post->getId()
)) ?>

    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form->renderHiddenFields() ?>
    
    <?php echo $form['content']->render(array(
        'value' => $post_content,
        'class' => 'wg-edit-area'
        ))
    ?>
    
    <div class="wiki-right">
        <a class="wg-post-button-edit href-cursor" data-id="<?php echo $post->getId(); ?>" OnClick="onSendEditForm(this, 'form-comment-edit-', 2);" title="Post">Post</a>
    </div>
<!--    <div style="display: none;">
        <input type="image" src="<?php // echo image_path('btn-post.png') ?>" OnClick="checkContent(<?php // echo $post->getId(); ?>);" style="vertical-align: bottom;" />
        <?php // echo $form['content']->renderError(); ?>
        <?php // echo $form['attachment_id']->render(); ?>
        <?php // echo $form['attachment_url']->render(); ?>
        <?php // echo $form['document_id']->render(); ?>
    </div>-->

</form>