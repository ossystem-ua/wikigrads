<?php use_helper('I18N') ?>
<div class="wiki-float-row"></div>
<div class="wiki-apply" style="text-align: left; padding: 20px;">
<?php echo __(<<<EOM
<p>
An error took place during the email delivery process. Please try
again later.
</p>
EOM
) ?>
<?php include_partial('sfApply/continue') ?>
</div>
<div class="wiki-float-row"></div>