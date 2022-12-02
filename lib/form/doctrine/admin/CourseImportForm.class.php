<?php

class CourseImportForm extends BaseForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'academic_term_id' => new sfWidgetFormDoctrineChoice(array(
                'model' => 'AcademicTerm',
            )),
            'school_id' => new sfWidgetFormDoctrineChoice(array(
                'model' => 'School',
            )),
            'file' => new sfWidgetFormInputFile(),
        ));
        
        $this->setValidators(array(
            'academic_term_id' => new sfValidatorDoctrineChoice(array(
                'model' => 'AcademicTerm',
            )),
            'school_id' => new sfValidatorDoctrineChoice(array(
                'model' => 'School',
            )),
            'file' => new sfValidatorFile(),
        ));
        
        $this->widgetSchema->setNameFormat('course_import[%s]');
    }
}