<?php

/**
 * sfGuardUserProfile filter form base class.
 *
 * @package    Wikigrads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserProfileFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'email'                => new sfWidgetFormFilterInput(),
      'fullname'             => new sfWidgetFormFilterInput(),
      'image'                => new sfWidgetFormFilterInput(),
      'birthday'             => new sfWidgetFormFilterInput(),
      'about'                => new sfWidgetFormFilterInput(),
      'activity'             => new sfWidgetFormFilterInput(),
      'validate'             => new sfWidgetFormFilterInput(),
      'is_staff'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_tutor'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'email_post'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'email_reply'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'email_from'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'email_private'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'enter_code'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'has_modified_profile' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'user_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'email'                => new sfValidatorPass(array('required' => false)),
      'fullname'             => new sfValidatorPass(array('required' => false)),
      'image'                => new sfValidatorPass(array('required' => false)),
      'birthday'             => new sfValidatorPass(array('required' => false)),
      'about'                => new sfValidatorPass(array('required' => false)),
      'activity'             => new sfValidatorPass(array('required' => false)),
      'validate'             => new sfValidatorPass(array('required' => false)),
      'is_staff'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_tutor'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'email_post'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'email_reply'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'email_from'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'email_private'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'enter_code'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'has_modified_profile' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'deleted_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'user_id'              => 'ForeignKey',
      'email'                => 'Text',
      'fullname'             => 'Text',
      'image'                => 'Text',
      'birthday'             => 'Text',
      'about'                => 'Text',
      'activity'             => 'Text',
      'validate'             => 'Text',
      'is_staff'             => 'Boolean',
      'is_tutor'             => 'Boolean',
      'email_post'           => 'Boolean',
      'email_reply'          => 'Boolean',
      'email_from'           => 'Boolean',
      'email_private'        => 'Boolean',
      'enter_code'           => 'Boolean',
      'has_modified_profile' => 'Boolean',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
      'deleted_at'           => 'Date',
    );
  }
}
