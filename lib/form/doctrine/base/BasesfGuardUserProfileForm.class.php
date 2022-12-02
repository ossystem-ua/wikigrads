<?php

/**
 * sfGuardUserProfile form base class.
 *
 * @method sfGuardUserProfile getObject() Returns the current form's model object
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserProfileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'user_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'email'                => new sfWidgetFormInputText(),
      'fullname'             => new sfWidgetFormInputText(),
      'image'                => new sfWidgetFormInputText(),
      'birthday'             => new sfWidgetFormInputText(),
      'about'                => new sfWidgetFormTextarea(),
      'activity'             => new sfWidgetFormTextarea(),
      'validate'             => new sfWidgetFormInputText(),
      'is_staff'             => new sfWidgetFormInputCheckbox(),
      'is_tutor'             => new sfWidgetFormInputCheckbox(),
      'email_post'           => new sfWidgetFormInputCheckbox(),
      'email_reply'          => new sfWidgetFormInputCheckbox(),
      'email_from'           => new sfWidgetFormInputCheckbox(),
      'email_private'        => new sfWidgetFormInputCheckbox(),
      'enter_code'           => new sfWidgetFormInputCheckbox(),
      'has_modified_profile' => new sfWidgetFormInputCheckbox(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'deleted_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'email'                => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'fullname'             => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'image'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'birthday'             => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'about'                => new sfValidatorString(array('required' => false)),
      'activity'             => new sfValidatorString(array('required' => false)),
      'validate'             => new sfValidatorString(array('max_length' => 17, 'required' => false)),
      'is_staff'             => new sfValidatorBoolean(array('required' => false)),
      'is_tutor'             => new sfValidatorBoolean(array('required' => false)),
      'email_post'           => new sfValidatorBoolean(array('required' => false)),
      'email_reply'          => new sfValidatorBoolean(array('required' => false)),
      'email_from'           => new sfValidatorBoolean(array('required' => false)),
      'email_private'        => new sfValidatorBoolean(array('required' => false)),
      'enter_code'           => new sfValidatorBoolean(array('required' => false)),
      'has_modified_profile' => new sfValidatorBoolean(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
      'deleted_at'           => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }

}
