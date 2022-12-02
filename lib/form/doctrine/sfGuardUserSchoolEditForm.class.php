<?php

class UserSchoolEditForm extends UserSchoolForm
{
	public function configure()
    {
    	if ($this->object->isNew()) {
    		throw new Exception('sfGuardUserSchool object required in sfGuardUserSchoolEditForm');
    	}
    	
        $use_fields = array(
            'user_id',
            'school_id',
            
    	);
        
        if($this->getOption('graduation_info_required')){
            //$use_fields[] = 'primary_department_id';
            $use_fields[] = 'major';
            $use_fields[] = 'class_year';
        }
        
    	$this->useFields($use_fields);
    	
    	$this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();
    	$this->validatorSchema['user_id'] = new sfValidatorChoice(array(
    		'required' => true,
    		'choices' => array($this->object->user_id)
    	));
    	
    	$this->widgetSchema['school_id'] = new sfWidgetFormInputHidden();
    	$this->validatorSchema['school_id'] = new sfValidatorChoice(array(
    		'required' => false,
    		'choices' => array($this->object->school_id)
    	));
    	
        
        if($this->getOption('graduation_info_required')){
            //$this->widgetSchema['primary_department_id']->setOption('query', $this->getDepartmentChoicesSql());

            $this->validatorSchema['major'] = new sfValidatorString(array(
                'required' => false
            ));

            $this->widgetSchema['class_year'] = new sfWidgetFormChoice(array(            
                'choices' => array('' => 'Class Year') + SchoolTable::getClassYearChoices(),
            ));

            $this->validatorSchema['class_year'] = new sfValidatorChoice(
                array(
                    'choices' => array_keys(SchoolTable::getClassYearChoices()),
                    'required' => false,
                ),
                array(
                    'required' => 'Please select your class'
                )
            );
        }
       
    }
    
    protected function getDepartmentChoicesSql()
    {
    	return  Doctrine_Core::getTable('Department')->createQuery('d')->where('d.school_id = ?', $this->object->school_id);
    }
	
    private function getYears()
    {
        $max = date('Y');
        $min = round(($max - 100) / 100) * 100;
        
        $range = range($max, $min);
        
        return array_combine($range, $range);
    }
}