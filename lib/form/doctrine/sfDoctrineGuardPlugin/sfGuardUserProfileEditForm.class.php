<?php

class sfGuardUserProfileEditForm extends sfGuardUserProfileForm
{
    public function configure()
    {
        $this->useFields(array(
            'image',
            'birthday',
            'about',
            'activity',    
            'email_post',
            'email_reply',
            'email_from',
            'email_private',
            'enter_code',
        ));
        
        $user = $this->getObject()->getUser();

        # image
        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
        
        /*$this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
            'label' => 'Profile Image',
            'file_src' => $this->object->image ? $user->getThumbnailImagePath(40, 40) : '',
            'is_image' => true,
            'edit_mode' => $this->object->image ? true : false,
        ));*/
        
        $this->widgetSchema['image'] = new sfWidgetFormInputFile();        
        $this->validatorSchema['image'] = new sfValidatorFile(array(
            'path' => $user->getLocalImagePath(true),
            'mime_types' => 'web_images',
            //'required' => $this->object->image ? false : true,
            'required' => false,
        ));
        
        $this->validatorSchema['image_delete'] = new sfValidatorPass();
        
        # birthday
        $this->widgetSchema['birthday'] = new sfWidgetFormDate(array(
            'format' => '%month% %day% %year%',
            'months' => $this->getMonths(),
            'years' => $this->getYears(),
        ));
        
        $this->validatorSchema['birthday'] = new sfValidatorDate(array(
        	'required' => false
        ));
        
        $this->validatorSchema['about']->setOption('required', false);
        $this->validatorSchema['activity']->setOption('required', false);
        $this->validatorSchema['email_post']->setOption('required', false);
        $this->validatorSchema['email_reply']->setOption('required', false);
        $this->validatorSchema['email_from']->setOption('required', false);
        $this->validatorSchema['email_private']->setOption('required', false);
        $this->validatorSchema['enter_code']->setOption('required', false);

        $graduation_info_required = $this->getObject()->getIsStaff() ? false : true;

        $this->embedSchoolEditForm($graduation_info_required);
    }
    
    private function getMonths()
    {
        return array (
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        );
    }
    
    private function getYears()
    {
        $max = date('Y');
        $min = round(($max - 100) / 100) * 100;
        
        $range = range($max, $min);
        
        return array_combine($range, $range);
    }
    
    protected function doBind(array $values)
    {
        $this->getObject()->setHasModifiedProfile(1);
        parent::doBind($values);
    }
    
    protected function embedSchoolEditForm($graduation_info_required)
    {
    	$user = $this->getObject()->getUser();
    	$school_links = $user->UserSchool;
    	
    	foreach ($school_links as $school_link) {
    		$name = $school_link->School->getUserSchoolFormName();
    		    		
    		$this->embedForm($name, new UserSchoolEditForm($school_link, array('graduation_info_required' => $graduation_info_required)));
    	}    	
    }
}