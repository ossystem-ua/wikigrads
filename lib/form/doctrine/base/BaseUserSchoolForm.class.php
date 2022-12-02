<?php

/**
 * UserSchool form base class.
 *
 * @method UserSchool getObject() Returns the current form's model object
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserSchoolForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'user_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'school_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('School'), 'add_empty' => true)),
      'major'                   => new sfWidgetFormInputText(),
      'primary_department_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PrimaryDepartment'), 'add_empty' => true)),
      'secondary_department_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SecondaryDepartment'), 'add_empty' => true)),
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
      'created_at'              => new sfValidatorDateTime(),
      'updated_at'              => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('user_school[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserSchool';
  }

}
