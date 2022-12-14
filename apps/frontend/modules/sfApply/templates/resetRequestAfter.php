<?php use_helper('I18N') ?>
<?php //slot('sf_apply_login') ?>
<?php //end_slot() ?>

<?php echo $sf_response->setTitle('Retrieve Password'); ?>

<div class="wiki-float-row"></div>
<div class="wiki-apply" style="text-align: left; padding: 20px;">
<?php echo __(<<<EOM
<p>
For security reasons, a confirmation message has been sent to 
the email address associated with this account. Please check your
email for that message. You will need to click on a link provided
in that email in order to change your password. If you do not see
the message, be sure to check your "spam" and "bulk" email folders.
</p>
<p>
We apologize for the inconvenience.
</p>
EOM
) ?>
    
<?php include_partial('sfApply/continue') ?>
</div>
<div class="wiki-float-row"></div>
