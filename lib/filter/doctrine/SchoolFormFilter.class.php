<?php

/**
 * School filter form.
 *
 * @package    sf_sandbox_old
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SchoolFormFilter extends BaseSchoolFormFilter
{
  public function configure()
  {
    $this->setWidgets(array(
      'name'               => new sfWidgetFormFilterInput(),
      'short_school'       => new sfWidgetFormFilterInput(),
      'twitter_list'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'first_friend_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FirstFriend'), 'add_empty' => true)),
      'default_user_image' => new sfWidgetFormFilterInput(),
      'timezone'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'         => new sfWidgetFormJQueryDate(array('config' => '{buttonText: "Choose Date"}', 'date_widget' => new sfWidgetFormDate(array('format'=>'%month%%day%%year%'))) ),
      'updated_at'         => new sfWidgetFormJQueryDate(array('config' => '{buttonText: "Choose Date"}', 'date_widget' => new sfWidgetFormDate(array('format'=>'%month%%day%%year%'))) ),
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
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'deleted_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'               => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('school_filters[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
