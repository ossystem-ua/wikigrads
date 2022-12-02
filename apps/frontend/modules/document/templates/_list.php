<div id="document-list">
<?php if(count($documents)): ?>
    <div class="clear-float">
    <?php foreach ($documents as $document): ?>
        <?php include_partial('document/document', array('document' => $document));?>
    <?php endforeach; ?>
    </div>
    
    <?php if($autopager->isLastPage()): ?>
        <div class="autopager-container"><!--no more documents--></div>
    <?php else: ?>
        <div id="autopager" class="autopager-container">
            <?php echo link_to("more", $autopager->getPageNextLink()) ?>
        </div>
    <?php endif; ?>
        
<?php else:?>
    No documents
<?php endif; ?>

    <script>
        AutoPager.init('#document-list');
    </script>
</div>
