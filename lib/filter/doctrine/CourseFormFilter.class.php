<?php

/**
 * Course filter form.
 *
 * @package    sf_sandbox_old
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CourseFormFilter extends BaseCourseFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'department_id' => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/Department', 'config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
            'name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'code' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'school_id' => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/School', 'config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
            'instructor' => new sfWidgetFormFilterInput(),
            'instructor_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
            'category' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'subject_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Subject'), 'add_empty' => true)),
            'access' => new sfWidgetFormFilterInput(),
            'created_at' => new sfWidgetFormJQueryDate(array('config' => '{buttonText: "Choose Date"}', 'date_widget' => new sfWidgetFormDate(array('format' => '%month%%day%%year%')))),
            'updated_at' => new sfWidgetFormJQueryDate(array('config' => '{buttonText: "Choose Date"}', 'date_widget' => new sfWidgetFormDate(array('format' => '%month%%day%%year%')))),
            'deleted_at' => new sfWidgetFormJQueryDate(array('config' => '{buttonText: "Choose Date"}', 'date_widget' => new sfWidgetFormDate(array('format' => '%month%%day%%year%')))),
            'sf_guard_user_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
        ));

        $this->setValidators(array(
            'department_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Department'), 'column' => 'id')),
            'name' => new sfValidatorPass(array('required' => false)),
            'code' => new sfValidatorPass(array('required' => false)),
            'school_id' => new sfValidatorPass(array('required' => false)),
            'instructor' => new sfValidatorPass(array('required' => false)),
            'instructor_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
            'category' => new sfValidatorPass(array('required' => false)),
            'subject_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Subject'), 'column' => 'id')),
            'access' => new sfValidatorPass(array('required' => false)),
            'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
            'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
            'deleted_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
            'sf_guard_user_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
        ));

        $this->widgetSchema->setNameFormat('course_filters[%s]');
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    }

    public function getFields() {
        $fields = parent::getFields();
        //the right 'virtual_column_name' is the method to filter
        $fields['school_id'] = 'school_id';
        return $fields;
    }

    public function addSchoolIdColumnQuery($query, $field, $value) {
        //add your filter query!
        //for example in your case
        $rootAlias = $query->getRootAlias();
        $query->leftJoin($rootAlias . '.Department d ON ' . $rootAlias . '.department_id = d.id')
                ->leftJoin($rootAlias . '.School s ON d.school_id = s.id');
        if ($value) {
            $query->andWhere("s.id IN ($value)");
        }
        //remember to return the $query!
        return $query;
    }
    
    public function addDepartmentIdColumnQuery($query, $field, $value) {
        
        $rootAlias = $query->getRootAlias();
        $query->leftJoin($rootAlias . '.Department dd ON ' . $rootAlias . '.department_id = dd.id');
        
        if ($value) {
            $query->andWhere("dd.id IN ($value)");
        }
        //remember to return the $query!
        return $query;
    }
}
