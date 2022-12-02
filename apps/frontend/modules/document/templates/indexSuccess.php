<?php if ($document_id > 0): ?>
    <?php //print_r ($document_id); ?>
<?php else: ?>
<div class="wiki-inwork">
    <?php if ($first_document_id > 0): ?>
        <script>window.location.href = '<?php echo url_for('@document_course_list?type=course&slug='.$first_document_id); ?>';</script>
    <?php else: ?>
        <script>window.location.href = '<?php echo url_for('@my_profile'); ?>';</script>
    <?php endif; ?>
</div>
<?php endif; ?>
