<?php

/**
 * InstructorCourse filter form.
 *
 * @package    Wikigrads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InstructorCourseFormFilter extends BaseInstructorCourseFormFilter
{
  public function configure()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/instructorCourse','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'course_id'  => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/Course','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'access'     => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormJQueryDate(array('config' => '{buttonText: "Choose Date"}', 'date_widget' => new sfWidgetFormDate(array('format'=>'%month%%day%%year%')))),
      'updated_at' => new sfWidgetFormJQueryDate(array('config' => '{buttonText: "Choose Date"}', 'date_widget' => new sfWidgetFormDate(array('format'=>'%month%%day%%year%')))),
    ));

    $this->setValidators(array(
      'user_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'course_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Course'), 'column' => 'id')),
      'access'     => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('instructor_course_filters[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
  
  public function getFields() {
        $fields = parent::getFields();
        //the right 'virtual_column_name' is the method to filter
        $fields['user_id'] = 'user_id';
        $fields['course_id'] = 'course_id';
        return $fields;
  }

  public function addUserIdColumnQuery($query, $field, $value) {
        //add your filter query!
        //for example in your case
        $rootAlias = $query->getRootAlias();
        $query->leftJoin($rootAlias . '.sfGuardUser d ON ' . $rootAlias . '.user_id = d.id');
        if ($value) {
            $query->where("r.user_id IN ($value)");
        }
//        remember to return the $query!
        return $query;
  }
    
  public function addCourseIdColumnQuery($query, $field, $value) {
        
        $rootAlias = $query->getRootAlias();
        $query->leftJoin($rootAlias . '.Course c ON ' . $rootAlias . '.course_id = c.id');
        if ($value) {
            $query->where("c.id IN ($value)");
        }
        //remember to return the $query!
        return $query;
  }
}
