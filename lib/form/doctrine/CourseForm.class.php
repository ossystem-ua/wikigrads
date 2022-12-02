<?php

/**
 * Course form.
 *
 * @package    sf_sandbox_old
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CourseForm extends BaseCourseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'department_id'      => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/Department','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'name'               => new sfWidgetFormInputText(),
      'code'               => new sfWidgetFormInputText(),
      'instructor'         => new sfWidgetFormInputText(),
      'instructor_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'category'           => new sfWidgetFormInputText(),
      'subject_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Subject'), 'add_empty' => true)),
      'access'             => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'deleted_at'         => new sfWidgetFormDateTime(),
      'sf_guard_user_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'department_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Department'))),
      'name'               => new sfValidatorString(array('max_length' => 255)),
      'code'               => new sfValidatorString(array('max_length' => 10)),
      'instructor'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'instructor_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'category'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'subject_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Subject'), 'required' => false)),
      'access'             => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
      'deleted_at'         => new sfValidatorDateTime(array('required' => false)),
      'sf_guard_user_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('course[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
