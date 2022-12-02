<?php use_helper('I18N') ?>
<div class="wiki-float-row"></div>
<div class="wiki-apply" style="text-align: left; padding: 20px;">
<p>
<?php echo(__(<<<EOM
That account was never verified. You must verify the account before you can log in or, if
necessary, reset the password. We have resent your verification email, which contains
instructions to verify your account. If you do not see that email, please be sure to check 
your "spam" or "bulk" folder.
EOM
)) ?>
</p>
<?php include_partial('sfApply/continue') ?>
</div>
<div class="wiki-float-row"></div>