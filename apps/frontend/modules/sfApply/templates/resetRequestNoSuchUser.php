<?php use_helper('I18N') ?>
<div class="wiki-float-row"></div>
<div class="wiki-apply" style="text-align: left; padding: 20px;">
<p>
<?php echo(__(<<<EOM
Sorry, there is no user with that username or email address.
EOM
)) ?>
</p>
<?php include_partial('sfApply/continue') ?>
</div>
<div class="wiki-float-row"></div>