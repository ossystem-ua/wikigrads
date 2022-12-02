<?php

/**
 * Notification filter form base class.
 *
 * @package    Wikigrads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseNotificationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'object_id'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'object_name'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'related_object_id'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'related_object_name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'template'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'action'              => new sfWidgetFormChoice(array('choices' => array('' => '', 'Add' => 'Add', 'Delete' => 'Delete'))),
      'type'                => new sfWidgetFormChoice(array('choices' => array('' => '', 'Classmate' => 'Classmate', 'Friend' => 'Friend', 'Everyone' => 'Everyone'))),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'object_id'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'object_name'         => new sfValidatorPass(array('required' => false)),
      'related_object_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'related_object_name' => new sfValidatorPass(array('required' => false)),
      'template'            => new sfValidatorPass(array('required' => false)),
      'action'              => new sfValidatorChoice(array('required' => false, 'choices' => array('Add' => 'Add', 'Delete' => 'Delete'))),
      'type'                => new sfValidatorChoice(array('required' => false, 'choices' => array('Classmate' => 'Classmate', 'Friend' => 'Friend', 'Everyone' => 'Everyone'))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'deleted_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('notification_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Notification';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'object_id'           => 'Number',
      'object_name'         => 'Text',
      'related_object_id'   => 'Number',
      'related_object_name' => 'Text',
      'template'            => 'Text',
      'action'              => 'Enum',
      'type'                => 'Enum',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'deleted_at'          => 'Date',
    );
  }
}
