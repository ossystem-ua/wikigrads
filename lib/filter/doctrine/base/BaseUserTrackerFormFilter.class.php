<?php

/**
 * UserTracker filter form base class.
 *
 * @package    Wikigrads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserTrackerFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'course_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Course'), 'add_empty' => true)),
      'notification_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Notification'), 'add_empty' => true)),
      'new_posts'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'new_classmates'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'private'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Post'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'user_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'course_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Course'), 'column' => 'id')),
      'notification_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Notification'), 'column' => 'id')),
      'new_posts'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'new_classmates'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'private'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Post'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('user_tracker_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserTracker';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'user_id'         => 'ForeignKey',
      'course_id'       => 'ForeignKey',
      'notification_id' => 'ForeignKey',
      'new_posts'       => 'Number',
      'new_classmates'  => 'Number',
      'private'         => 'ForeignKey',
    );
  }
}
