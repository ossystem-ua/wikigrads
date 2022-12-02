<?php if ($sf_user->hasFlash('notice')) : ?>
    <div class="flash-container">
        <div class="flash-notice">
            <?php echo $sf_user->getFlash('notice') ?>
        </div>
    </div>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error')) : ?>
    <div class="flash-container">
        <div class="flash-error">
            <?php echo $sf_user->getFlash('error') ?>
        </div>
    </div>
<?php endif; ?>