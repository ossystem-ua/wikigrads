<?php

/**
 * UserSchool filter form.
 *
 * @package    sf_sandbox_old
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserSchoolFormFilter extends BaseUserSchoolFormFilter
{
  public function configure()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormJQueryAutocompleter(array('url' => '/autocomplite/userSchool','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'school_id'  => new sfWidgetFormJQueryAutocompleter(array('url' => '/autocomplite/School','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'major'                   => new sfWidgetFormFilterInput(),
      'primary_department_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PrimaryDepartment'), 'add_empty' => true, 'table_method' => 'getSortByName')),
      'secondary_department_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SecondaryDepartment'), 'add_empty' => true, 'table_method' => 'getSortByName')),
      'class_year'              => new sfWidgetFormFilterInput(),
      'created_at'              => new sfWidgetFormJQueryDate(array('config' => '{buttonText: "Choose Date"}', 'date_widget' => new sfWidgetFormDate(array('format'=>'%month%%day%%year%')))),
      'updated_at'              => new sfWidgetFormJQueryDate(array('config' => '{buttonText: "Choose Date"}', 'date_widget' => new sfWidgetFormDate(array('format'=>'%month%%day%%year%')))),
    ));

    $this->setValidators(array(
      'user_id'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'school_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('School'), 'column' => 'id')),
      'major'                   => new sfValidatorPass(array('required' => false)),
      'primary_department_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PrimaryDepartment'), 'column' => 'id')),
      'secondary_department_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('SecondaryDepartment'), 'column' => 'id')),
      'class_year'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('user_school_filters[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
  
  public function getFields() {
        $fields = parent::getFields();
        //the right 'virtual_column_name' is the method to filter
        $fields['user_id'] = 'user_id';
        $fields['school_id'] = 'school_id';
        return $fields;
  }
  
  public function addSchoolIdColumnQuery($query, $field, $value) {
        //add your filter query!
        //for example in your case
        $rootAlias = $query->getRootAlias();
        $query->leftJoin($rootAlias.'.School s ON '.$rootAlias.'.school_id = s.id');
        
        if ($value) {
            $query->andWhere($rootAlias.".school_id IN ($value)");
        }
        //remember to return the $query!
        return $query;
  }
    
  public function addUserIdColumnQuery($query, $field, $value) {
        $rootAlias = $query->getRootAlias();
//        $query->leftJoin( $rootAlias . '.sfGuardUser s ON s.id = ' . $rootAlias . '.user_id');
        
        if ($value) {
            $query->where("r.user_id IN ($value)");
        }
        //remember to return the $query! 
        return $query;
  }
}
