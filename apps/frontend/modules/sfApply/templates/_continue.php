<div id="continue-btn">
<?php echo link_to('Continue', 
	$sf_user->isAuthenticated() ? sfConfig::get('app_sfApplyPlugin_afterLogin', sfConfig::get('app_sfApplyPlugin_after', '@homepage')) : sfConfig::get('app_sfApplyPlugin_after', $sf_user->getReferer('@homepage'))) ?>
</div>