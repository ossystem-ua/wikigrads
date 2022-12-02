<?php

class CourseAddForm extends BaseForm
{
    public function configure()
    {
        $school     = $this->getOption('school');
        $department = $this->getOption('department');
        $subjectId  = $this->getOption('subject_id');
        $access     = $this->getOption('access');
            
        if ($school != null) {
            if (!$school instanceof School) {
        	throw new Exception('$school must be an instance of School');
            }   
        } 
        
        if ($department && !$department instanceof Department) {
        	throw new Exception('$department must be an instance of Department');
        }
        
        if ($department) {
        	$this->setDefault('department_id', $department->id);
        }
        
        #subject
        $this->widgetSchema['subject_id'] = new sfWidgetFormDoctrineChoice(array(
            'model' => 'Subject',
            'method' => 'getSubjectName',
            'query' => SubjectTable::getSubjectName(),
            'add_empty' => ''            
        ));
        $this->validatorSchema['subject_id'] = new sfValidatorDoctrineChoice(array(
                'model' => 'Subject',
                'required' => false
        ));
        
        #access
        $this->validatorSchema['access'] = new sfValidatorString(array('required' => false));
        $this->widgetSchema['access']    = new sfWidgetFormInputText();
        
        #category
        $this->widgetSchema['category'] = new sfWidgetFormDoctrineChoice(array(
            'model' => 'Course',
            'method' => 'getCourseCategoryName',
            'query' => CourseTable::getCourseCategory(),
            'add_empty' => 'Choose a community'
        ));
        $this->validatorSchema['category'] = new sfValidatorDoctrineChoice(array(
                'model' => 'Course',
                'required' => false
        ));
        
        # department
        
        if (!$school instanceof School) $schoolId = 0;
        else $schoolId = $school->id;
        $this->widgetSchema['department_id'] = new sfWidgetFormDoctrineChoice(array(
            'model' => 'Department',
            'method'=> 'getAlias',
            'query' => DepartmentTable::getDepartmentsBySchoolIdSql($schoolId),
            'add_empty' => 'Choose department',
        ));
        
        $this->validatorSchema['department_id'] = new sfValidatorDoctrineChoice(array(
            'model' => 'Department',
            'required' => false
        ));
        
        # course
        if ($department) {
            $this->widgetSchema['course_id'] = new sfWidgetFormDoctrineChoice(array(
                'model' => 'Course',
                'method' => 'getDoctrineChoiceOption',
                'query' => CourseTable::getCourseByDepartmentIdSql($department->id),
                'add_empty' => '--------'
            ));
            
            $this->validatorSchema['course_id'] = new sfValidatorDoctrineChoice(array(
                'model' => 'Course'
            ));
        }
        
        $this->widgetSchema->setNameFormat('course_add[%s]');
    }
}
