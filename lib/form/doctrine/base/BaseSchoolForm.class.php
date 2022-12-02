<?php

/**
 * School form base class.
 *
 * @method School getObject() Returns the current form's model object
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSchoolForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'name'               => new sfWidgetFormInputText(),
      'short_school'       => new sfWidgetFormInputText(),
      'twitter_list'       => new sfWidgetFormInputText(),
      'first_friend_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FirstFriend'), 'add_empty' => true)),
      'default_user_image' => new sfWidgetFormInputText(),
      'timezone'           => new sfWidgetFormInputText(),
      'is_lms'             => new sfWidgetFormInputText(),
      'lms_domain'         => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'deleted_at'         => new sfWidgetFormDateTime(),
      'slug'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 100)),
      'short_school'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'twitter_list'       => new sfValidatorString(array('max_length' => 255)),
      'first_friend_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FirstFriend'), 'required' => false)),
      'default_user_image' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'timezone'           => new sfValidatorString(array('max_length' => 255)),
      'is_lms'             => new sfValidatorInteger(array('required' => false)),
      'lms_domain'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
      'deleted_at'         => new sfValidatorDateTime(array('required' => false)),
      'slug'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'School', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('school[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'School';
  }

}
