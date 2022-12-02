<div id="edit-profile">
    <div class="content-inputarea">
        <div id="profile-summary">
            <div class="row-1">
                <div class="col-1">
                    <div class="heading">About</div>
<?php if($profile->about): ?>
                    <p><?php echo $profile->about ?></p>
<?php else: ?>
                    <p class="missing-info-prompt">let your classmates know a little bit about yourself.</p>
<?php endif; ?>
                </div>
                <div class="col-2">
                    <div class="heading">Interests</div>
<?php if($profile->activity): ?>
                    <p><?php echo $profile->activity ?></p>
<?php else: ?>
                    <p class="missing-info-prompt">let your classmates know what you're into.</p>
<?php endif; ?>
                </div>
                <div class="clear-force"></div>
            </div>
        </div>
        <hr />
        
        <?php include_partial('sfGuardUser/formEdit', array('form' => $form, 'emails' => 0, 'IsStaff' => $profile->getIsStaff()))?>
    </div>
</div>
