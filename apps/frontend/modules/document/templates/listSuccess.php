<?php use_helper('wgTpl'); ?>

<div class="wiki-float-row"></div>

<?/*
<div class="wiki-post-form">
    <?php include_partial('document/form', array('form' => $form, 'courseId' => $courseId));?>
</div>    
*/?>

<div id="wiki-notification-list">
    <div class="wiki-float-row"></div>
    <?php foreach ($documents as $document): ?>
        <?php include_partial('document/document', array('document' => $document));?>
    <?php endforeach; ?>
</div>

<?php if(count($documents) > 0): ?>
    <?php if($autopager->isLastPage()): ?>
        <div class="autopager-container"><!--The end--></div>
    <?php else: ?>
        <div id="autopager" class="autopager-container">
            <?php //echo link_to("more", $autopager->getPageNextLink()) ?>
            <?php echo link_to("&nbsp;", $autopager->getPageNextLink()) ?>
        </div>
    <?php endif; ?>  
<?php endif; ?>
