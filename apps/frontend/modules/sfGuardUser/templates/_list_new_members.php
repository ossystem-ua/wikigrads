<div id="new-member-list">
    <div class="clear-float">
    <?php foreach ($users as $index => $user): ?>
        <?php include_partial('sfGuardUser/singleMember', array('user' => $user, 'index' => $index))?>
    <?php endforeach; ?>
    </div>
    
    <?php if($autopager->isLastPage()): ?>
        <div class="autopager-container">all new members have been displayed</div>
    <?php else: ?>
        <div id="autopager" class="autopager-container">
            <?php echo link_to("more", $autopager->getPageNextLink()) ?>
        </div>
    <?php endif; ?>
    
    <?php if($isAjaxRequest): ?>
    <script>
        AutoPager.addCallback('USER.fsicon.tooltips()');  // for any new content loaded, attach tooltips to the fsicons
        AutoPager.init('#new-member-list');
    </script>
    <?php endif; ?>
</div>




