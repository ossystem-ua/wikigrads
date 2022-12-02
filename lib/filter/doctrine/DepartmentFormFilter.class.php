<?php

/**
 * Department filter form.
 *
 * @package    sf_sandbox_old
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DepartmentFormFilter extends BaseDepartmentFormFilter
{
  public function configure()
  {
    $this->setWidgets(array(
      'school_id'  => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/School','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'name'       => new sfWidgetFormFilterInput(),
      'alias'      => new sfWidgetFormFilterInput(),
      'sort'       => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormJQueryDate(array('config' => '{buttonText: "Choose Date"}', 'date_widget' => new sfWidgetFormDate(array('format'=>'%year%%month%%day%')))),
      'updated_at' => new sfWidgetFormJQueryDate(array('config' => '{buttonText: "Choose Date"}', 'date_widget' => new sfWidgetFormDate(array('format'=>'%year%%month%%day%')))),
      'deleted_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'school_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('School'), 'column' => 'id')),
      'name'       => new sfValidatorPass(array('required' => false)),
      'alias'      => new sfValidatorPass(array('required' => false)),
      'sort'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'deleted_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('department_filters[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
  
  public function getFields() {
        $fields = parent::getFields();
        //the right 'virtual_column_name' is the method to filter
        $fields['school_id'] = 'school_id';
        //var_dump($fields); exit;
        return $fields;
  }
  
  public function addSchoolIdColumnQuery($query, $field, $value) {
        //add your filter query!
        //for example in your case
        $rootAlias = $query->getRootAlias();
        $query->leftJoin($rootAlias . '.School s ON r.school_id = s.id');

        if ($value) {
            $query->andWhere("s.id IN ($value)");
        }
        
        //remember to return the $query!
        return $query;
  }
  
}
