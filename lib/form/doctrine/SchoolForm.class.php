<?php

/**
 * School form.
 *
 * @package    sf_sandbox_old
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SchoolForm extends BaseSchoolForm
{
  public function configure()
  {
	$this->useFields(array(
	    'name',
            'short_school',
	    'twitter_list',
	    'first_friend_id',
            'is_lms',
            'lms_domain'
	));
      sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
        $this->widgetSchema['default_user_image'] = new sfWidgetFormInputFileEditable(array(
            'file_src' => image_path('/uploads/default_profile/' . $this->getObject()->getDefaultUserImage()),
            'edit_mode' => true,
            'is_image' => true,
            'with_delete' => false,
        ));
        $this->validatorSchema['default_user_image'] = new sfValidatorFile(array(
            'path' => sfConfig::get('sf_upload_dir') . '/default_profile/',
            'mime_types' => 'web_images',
            'required' => false,
        ));
        
        $this->widgetSchema['is_lms'] = new sfWidgetFormInputCheckbox();
        $this->validatorSchema['is_lms'] = new sfValidatorBoolean(array('required' => false));
        
        $this->widgetSchema['lms_domain'] = new sfWidgetFormInputText();
        $this->validatorSchema['lms_domain'] = new sfValidatorString(array('max_length' => 255, 'required' => false));
  	
  }
}
