<?php

/**
 * UserSchool form.
 *
 * @package    sf_sandbox_old
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserSchoolForm extends BaseUserSchoolForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/sfGuardUser','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'school_id'  => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/School','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'major'                   => new sfWidgetFormInputText(),
      'primary_department_id'      => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/Department','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'secondary_department_id'      => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/Department','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'class_year'              => new sfWidgetFormInputText(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'school_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('School'), 'required' => false)),
      'major'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'primary_department_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PrimaryDepartment'), 'required' => false)),
      'secondary_department_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SecondaryDepartment'), 'required' => false)),
      'class_year'              => new sfValidatorInteger(array('required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_school[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
