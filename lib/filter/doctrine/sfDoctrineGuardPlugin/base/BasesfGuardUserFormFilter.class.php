<?php

/**
 * sfGuardUser filter form base class.
 *
 * @package    Wikigrads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'post_count'             => new sfWidgetFormFilterInput(),
      'first_name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'last_name'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email_address'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'username'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'algorithm'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'salt'                   => new sfWidgetFormFilterInput(),
      'password'               => new sfWidgetFormFilterInput(),
      'is_active'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_super_admin'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_officer'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'last_login'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'lms_id'                 => new sfWidgetFormFilterInput(),
      'is_lms'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lms_email'              => new sfWidgetFormFilterInput(),
      'lms_domain'             => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'groups_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup')),
      'permissions_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission')),
      'courses_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Course')),
      'events_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Event')),
      'friends_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
      'schools_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'School')),
      'instructor_course_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'InstructorCourse')),
      'sf_guard_user_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'post_count'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'first_name'             => new sfValidatorPass(array('required' => false)),
      'last_name'              => new sfValidatorPass(array('required' => false)),
      'email_address'          => new sfValidatorPass(array('required' => false)),
      'username'               => new sfValidatorPass(array('required' => false)),
      'algorithm'              => new sfValidatorPass(array('required' => false)),
      'salt'                   => new sfValidatorPass(array('required' => false)),
      'password'               => new sfValidatorPass(array('required' => false)),
      'is_active'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_super_admin'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_officer'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'last_login'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'lms_id'                 => new sfValidatorPass(array('required' => false)),
      'is_lms'                 => new sfValidatorPass(array('required' => false)),
      'lms_email'              => new sfValidatorPass(array('required' => false)),
      'lms_domain'             => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'groups_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => false)),
      'permissions_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false)),
      'courses_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Course', 'required' => false)),
      'events_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Event', 'required' => false)),
      'friends_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'schools_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'School', 'required' => false)),
      'instructor_course_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'InstructorCourse', 'required' => false)),
      'sf_guard_user_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addGroupsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.sfGuardUserGroup sfGuardUserGroup')
      ->andWhereIn('sfGuardUserGroup.group_id', $values)
    ;
  }

  public function addPermissionsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.sfGuardUserPermission sfGuardUserPermission')
      ->andWhereIn('sfGuardUserPermission.permission_id', $values)
    ;
  }

  public function addCoursesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.UserCourse UserCourse')
      ->andWhereIn('UserCourse.course_id', $values)
    ;
  }

  public function addEventsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.UserEvent UserEvent')
      ->andWhereIn('UserEvent.event_id', $values)
    ;
  }

  public function addFriendsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.Friend Friend')
      ->andWhereIn('Friend.friend_id', $values)
    ;
  }

  public function addSchoolsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.UserSchool UserSchool')
      ->andWhereIn('UserSchool.school_id', $values)
    ;
  }

  public function addInstructorCourseListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.InstructorCourse InstructorCourse')
      ->andWhereIn('InstructorCourse.user_id', $values)
    ;
  }

  public function addSfGuardUserListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.Friend Friend')
      ->andWhereIn('Friend.user_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'sfGuardUser';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'post_count'             => 'Number',
      'first_name'             => 'Text',
      'last_name'              => 'Text',
      'email_address'          => 'Text',
      'username'               => 'Text',
      'algorithm'              => 'Text',
      'salt'                   => 'Text',
      'password'               => 'Text',
      'is_active'              => 'Boolean',
      'is_super_admin'         => 'Boolean',
      'is_officer'             => 'Boolean',
      'last_login'             => 'Date',
      'lms_id'                 => 'Text',
      'is_lms'                 => 'Text',
      'lms_email'              => 'Text',
      'lms_domain'             => 'Text',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'groups_list'            => 'ManyKey',
      'permissions_list'       => 'ManyKey',
      'courses_list'           => 'ManyKey',
      'events_list'            => 'ManyKey',
      'friends_list'           => 'ManyKey',
      'schools_list'           => 'ManyKey',
      'instructor_course_list' => 'ManyKey',
      'sf_guard_user_list'     => 'ManyKey',
    );
  }
}
