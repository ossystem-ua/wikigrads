<?php

/**
 * Department form.
 *
 * @package    sf_sandbox_old
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DepartmentForm extends BaseDepartmentForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'school_id'  => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/School','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'name'       => new sfWidgetFormInputText(),
      'alias'      => new sfWidgetFormInputText(),
      'sort'       => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'school_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('School'))),
      'name'       => new sfValidatorString(array('max_length' => 100)),
      'alias'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'sort'       => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('department[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
