<?php

class sfApplyForm extends sfApplyApplyForm
{
    public function configure()
    {
        parent::configure();

        $this->useFields(array(
            'email',
            'password',
            'password2',
            'is_staff',
            'is_tutor'
        ));

        $this->widgetSchema['email']->setDefault('');

        # first_name
        $this->widgetSchema['first_name'] = new sfWidgetFormInput();
        $this->widgetSchema['first_name']->setDefault('');
        $this->validatorSchema['first_name'] = new sfValidatorString();

        # last_name
        $this->widgetSchema['last_name'] = new sfWidgetFormInput();
        $this->widgetSchema['last_name']->setDefault('');
        $this->validatorSchema['last_name'] = new sfValidatorString();

        // Removed from registration and initial profile edit.
//        $this->widgetSchema['image'] = new sfWidgetFormInputFile();
//        $this->validatorSchema['image'] = new sfValidatorFile(array(
//            'path' => sfConfig::get('sf_upload_dir') . '/profile/',
//            'mime_types' => 'web_images',
//            'required' => true,
//        ));


        $school = $this->getOption('school');

        $graduation_info_required = !is_null($this->getOption('graduation_info_required')) ? $this->getOption('graduation_info_required') : TRUE;

        if ($school && !$school instanceof School) {
                throw new Exception('$school must be an instance of School');
        }


        # school_id
        $this->widgetSchema['school_id'] = new sfWidgetFormDoctrineChoice(array(
            'model' => 'School',
            'add_empty' => 'School',
            'query' => SchoolTable::getNonLmsSchoolsSql()
        ));
        $this->widgetSchema['school_id']->addOption('order_by',array('name','asc'));

        $this->validatorSchema['school_id'] = new sfValidatorDoctrineChoice(
            array(
                'model' => 'School',
                'required' => true
            ),
            array(
                'required' => 'Please select your school'
            )
        );

        $this->widgetSchema['major'] = new sfWidgetFormInputText(array(

        ));

        $this->validatorSchema['major'] = new sfValidatorString(array(
            'required' => false
            )
        );

        # school
        if ($school) {
            $this->setDefault('school_id', $school->getId());


//            $this->widgetSchema['primary_department_id'] = new sfWidgetFormDoctrineChoice(array(
//                'model' => 'Department',
//                'method' => 'getDoctrineChoiceOption',
//                'query' => DepartmentTable::getDepartmentsBySchoolIdSql($school->getId()),
//                'add_empty' => 'Select Major',
//            ));
//
//            $this->validatorSchema['primary_department_id'] = new sfValidatorDoctrineChoice(array(
//                'model' => 'Department',
//                'required' => $graduation_info_required
//            ));
        }


        $this->widgetSchema['class_year'] = new sfWidgetFormChoice(array(
            'choices' => array('' => 'Class Year') + SchoolTable::getClassYearChoices(),

        ));

        $this->validatorSchema['class_year'] = new sfValidatorChoice(
            array(
                'choices' => array_keys(SchoolTable::getClassYearChoices()),
                'required' => false
                //'required' => $graduation_info_required
            ),
            array(
                'required' => 'Please select your class'
            )
        );


        $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
            new sfValidatorCallback(array(
                'callback' => array(
                    $this,
                    'validateStringValues',
                )
            )),
            new sfValidatorSchemaCompare(
                'password',
                sfValidatorSchemaCompare::EQUAL,
                'password2',
                array(),
                array('invalid' => 'Passwords do not match.')
            )
        )));

    }

    public function validateStringValues($validator, $values)
    {
        $errors = new sfValidatorErrorSchema($validator);


//        if (isset($values['first_name']) && $values['first_name'] == $this->widgetSchema['first_name']->getDefault()) {
//            $errors->addError(new sfValidatorError($validator, 'required'), 'first_name');
//        }
//
//        if (isset($values['last_name']) && $values['last_name'] == $this->widgetSchema['last_name']->getDefault()) {
//            $errors->addError(new sfValidatorError($validator, 'required'), 'last_name');
//        }

        if (isset($values['email']) && $values['email']) {

        	// disabled school_email and allow all .edu emails
        	if (
                    sfConfig::get('app_sfApplyPlugin_add_check_enabled', true) === true
                    &&
        		false === stripos($values['email'], sfConfig::get('app_sfApplyPlugin_register_email'))
        	) {

        		$errors['email'] = new sfValidatorError($this->getValidator('email'), sfConfig::get('app_error_invalid_email'));
        	}
        }

        if (!empty($errors)) {
           throw new sfValidatorErrorSchema($validator, $errors);
        }

        return $values;
    }

    public function doSave($con = null)
    {
        $this->values['username'] = $this->values['email'];
        $this->values['email_address'] = $this->values['email'];

        $user = $this->getObject()->getUser();
        $user->fromArray($this->values);

        # they must confirm their account first
        $user->setIsActive(false);
        $user->save();

        $userSchool = new UserSchool();
        $userSchool->setUserId($user->getId());

        # add school information
        $school = Doctrine_Core::getTable('School')->find($this->values['school_id']);
        $userSchool->setSchoolId($school->getId());

        if(isset($this->values['primary_department_id']) && $this->values['primary_department_id']){
            $department = Doctrine_Core::getTable('Department')->find($this->values['primary_department_id']);
        } elseif(isset($this->values['major']) && $this->values['major']) {
            $userSchool->setMajor($this->values['major']);
            $department = Doctrine_Core::getTable('Department')->findOneBySchoolAndName($school->getId(), $this->values['major']);
        }

        if(isset($department) && $department) {
            $userSchool->setPrimaryDepartmentId($department->getId());
        }
        $userSchool->setClassYear($this->values['class_year']);

        $userSchool->save();

        # used in the parent::updateObject();
        $this->userId = $user->getId();

        # skip parent::doSave($con);
        $this->getObject()->setImage($school->getDefaultUserImage());
        sfGuardUserProfileForm::doSave($con);

        $this->moveFileToUserDir($school);
    }

    /**
     * Move file from upload profile folder to upload user profile folder
     */
    protected function moveFileToUserDir(School $school){
        $userProfile = $this->getObject();

        $oldFile = sfConfig::get('sf_upload_dir') . '/default_profile/'. $school->getDefaultUserImage();
        $newFile = $userProfile->getUser()->getLocalImagePath();

        if(is_file($oldFile) && !is_file($newFile)){
            $old = umask(0);
            mkdir($userProfile->getUser()->getLocalImagePath(true), 0755);
            umask($old);

            if(copy($oldFile, $newFile)){
                //unlink($oldFile);
            }
        }
    }


    public function doUpdateObject($values = null)
    {
        $values['fullname'] = $this->values['first_name'].' '.$this->values['last_name'];

        parent::doUpdateObject($values);
    }


}