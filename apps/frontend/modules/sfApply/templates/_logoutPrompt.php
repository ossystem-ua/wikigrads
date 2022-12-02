<?php use_helper('I18N') ?>
<div id="sf_apply_logged_in_as">
<p>
<?php echo __("Logged in as %1%", 
  array("%1%" => $sf_user->getGuardUser()->getUsername())) ?>
</p>

<?php include_component('main', 'leftNav')?>


</div>

