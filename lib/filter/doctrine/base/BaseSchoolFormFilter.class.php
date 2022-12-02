<?php

/**
 * School filter form base class.
 *
 * @package    Wikigrads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSchoolFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'short_school'       => new sfWidgetFormFilterInput(),
      'twitter_list'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'first_friend_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FirstFriend'), 'add_empty' => true)),
      'default_user_image' => new sfWidgetFormFilterInput(),
      'timezone'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_lms'             => new sfWidgetFormFilterInput(),
      'lms_domain'         => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'slug'               => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'               => new sfValidatorPass(array('required' => false)),
      'short_school'       => new sfValidatorPass(array('required' => false)),
      'twitter_list'       => new sfValidatorPass(array('required' => false)),
      'first_friend_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FirstFriend'), 'column' => 'id')),
      'default_user_image' => new sfValidatorPass(array('required' => false)),
      'timezone'           => new sfValidatorPass(array('required' => false)),
      'is_lms'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lms_domain'         => new sfValidatorPass(array('required' => false)),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'deleted_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'               => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('school_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'School';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'name'               => 'Text',
      'short_school'       => 'Text',
      'twitter_list'       => 'Text',
      'first_friend_id'    => 'ForeignKey',
      'default_user_image' => 'Text',
      'timezone'           => 'Text',
      'is_lms'             => 'Number',
      'lms_domain'         => 'Text',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'deleted_at'         => 'Date',
      'slug'               => 'Text',
    );
  }
}
