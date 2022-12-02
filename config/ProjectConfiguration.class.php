<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {

    sfConfig::set('sf_images_dir', sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'images');
    sfConfig::set('sf_previews_dir', sfConfig::get('sf_images_dir').DIRECTORY_SEPARATOR.'previews');

	$this->enablePlugins(array(
	    'sfDoctrinePlugin',
	    'sfDoctrineGuardPlugin',
	    'sfDoctrineApplyPlugin',
            'sfAdminThemejRollerPlugin',
            'npAssetsOptimizerPlugin',
            'sfFormExtraPlugin'
	));
  }
}
