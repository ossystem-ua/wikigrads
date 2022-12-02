<?php

/**
 * Notification form base class.
 *
 * @method Notification getObject() Returns the current form's model object
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNotificationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'object_id'           => new sfWidgetFormInputText(),
      'object_name'         => new sfWidgetFormInputText(),
      'related_object_id'   => new sfWidgetFormInputText(),
      'related_object_name' => new sfWidgetFormInputText(),
      'template'            => new sfWidgetFormInputText(),
      'action'              => new sfWidgetFormChoice(array('choices' => array('Add' => 'Add', 'Delete' => 'Delete'))),
      'type'                => new sfWidgetFormChoice(array('choices' => array('Classmate' => 'Classmate', 'Friend' => 'Friend', 'Everyone' => 'Everyone'))),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'deleted_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'object_id'           => new sfValidatorInteger(),
      'object_name'         => new sfValidatorString(array('max_length' => 255)),
      'related_object_id'   => new sfValidatorInteger(),
      'related_object_name' => new sfValidatorString(array('max_length' => 255)),
      'template'            => new sfValidatorString(array('max_length' => 255)),
      'action'              => new sfValidatorChoice(array('choices' => array(0 => 'Add', 1 => 'Delete'), 'required' => false)),
      'type'                => new sfValidatorChoice(array('choices' => array(0 => 'Classmate', 1 => 'Friend', 2 => 'Everyone'), 'required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'deleted_at'          => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('notification[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Notification';
  }

}
