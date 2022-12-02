<?php

/**
 * UserTracker form base class.
 *
 * @method UserTracker getObject() Returns the current form's model object
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserTrackerForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'user_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'course_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Course'), 'add_empty' => false)),
      'notification_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Notification'), 'add_empty' => false)),
      'new_posts'       => new sfWidgetFormInputText(),
      'new_classmates'  => new sfWidgetFormInputText(),
      'private'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Post'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'course_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Course'))),
      'notification_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Notification'))),
      'new_posts'       => new sfValidatorInteger(array('required' => false)),
      'new_classmates'  => new sfValidatorInteger(array('required' => false)),
      'private'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Post'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_tracker[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserTracker';
  }

}
