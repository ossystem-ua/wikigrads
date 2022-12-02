<?php if ($notification instanceof sfOutputEscaper) : ?>
    <?php $notification = $notification->getRawValue() ?>
<?php endif; ?>

<?php
    if (strlen($post_url) > 0 && $notification['object']['is_pinned'] == 0) {
        echo '<img class="img-silde" src="'.$post_url.'" alt="Image" />';
        if ($post_content == 'image') $post_content = '';
    }
?>

<?php echo $form->renderFormTag(url_for('@ajax_post_edit?notification_id='.$notification->getId()), array(
    'id' => 'form-post-edit-'.$notification->getId(),
    'class' => '',
    'data-id' => $notification->getId()
)) ?>
    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form->renderHiddenFields() ?>
    
    <?php echo $form['content']->render(array(
        'value' => $post_content, 
        'class' => 'wg-edit-area'
        )) 
    ?>

    <div class="wiki-right">
        <a class="wg-post-button-edit href-cursor" data-id="<?php echo $notification->getId(); ?>" OnClick="onSendEditForm(this, 'form-post-edit-', 1);" title="Post">Post</a>
    </div>

<!--    <div style="display: none;">
        <input type="image" src="<?php // echo image_path('btn-post.png') ?>" OnClick="checkContent(<?php // echo $notification->getId(); ?>);" style="vertical-align: bottom;" />
        <?php // echo $form['content']->renderError() ?>
    </div>-->
        
</form>