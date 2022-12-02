<?php

/**
 * sfGuardUser form base class.
 *
 * @method sfGuardUser getObject() Returns the current form's model object
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'post_count'             => new sfWidgetFormInputText(),
      'first_name'             => new sfWidgetFormInputText(),
      'last_name'              => new sfWidgetFormInputText(),
      'email_address'          => new sfWidgetFormInputText(),
      'username'               => new sfWidgetFormInputText(),
      'algorithm'              => new sfWidgetFormInputText(),
      'salt'                   => new sfWidgetFormInputText(),
      'password'               => new sfWidgetFormInputText(),
      'is_active'              => new sfWidgetFormInputCheckbox(),
      'is_super_admin'         => new sfWidgetFormInputCheckbox(),
      'is_officer'             => new sfWidgetFormInputCheckbox(),
      'last_login'             => new sfWidgetFormDateTime(),
      'lms_id'                 => new sfWidgetFormInputText(),
      'is_lms'                 => new sfWidgetFormInputText(),
      'lms_email'              => new sfWidgetFormInputText(),
      'lms_domain'             => new sfWidgetFormInputText(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
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
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'post_count'             => new sfValidatorInteger(array('required' => false)),
      'first_name'             => new sfValidatorString(array('max_length' => 80)),
      'last_name'              => new sfValidatorString(array('max_length' => 80)),
      'email_address'          => new sfValidatorString(array('max_length' => 255)),
      'username'               => new sfValidatorString(array('max_length' => 128)),
      'algorithm'              => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'salt'                   => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'password'               => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'is_active'              => new sfValidatorBoolean(array('required' => false)),
      'is_super_admin'         => new sfValidatorBoolean(array('required' => false)),
      'is_officer'             => new sfValidatorBoolean(array('required' => false)),
      'last_login'             => new sfValidatorDateTime(array('required' => false)),
      'lms_id'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_lms'                 => new sfValidatorPass(array('required' => false)),
      'lms_email'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'lms_domain'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
      'groups_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => false)),
      'permissions_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false)),
      'courses_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Course', 'required' => false)),
      'events_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Event', 'required' => false)),
      'friends_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'schools_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'School', 'required' => false)),
      'instructor_course_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'InstructorCourse', 'required' => false)),
      'sf_guard_user_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('email_address'))),
        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('username'))),
      ))
    );

    $this->widgetSchema->setNameFormat('sf_guard_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUser';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['groups_list']))
    {
      $this->setDefault('groups_list', $this->object->Groups->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['permissions_list']))
    {
      $this->setDefault('permissions_list', $this->object->Permissions->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['courses_list']))
    {
      $this->setDefault('courses_list', $this->object->Courses->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['events_list']))
    {
      $this->setDefault('events_list', $this->object->Events->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['friends_list']))
    {
      $this->setDefault('friends_list', $this->object->Friends->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['schools_list']))
    {
      $this->setDefault('schools_list', $this->object->Schools->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['instructor_course_list']))
    {
      $this->setDefault('instructor_course_list', $this->object->InstructorCourse->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['sf_guard_user_list']))
    {
      $this->setDefault('sf_guard_user_list', $this->object->sfGuardUser->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveGroupsList($con);
    $this->savePermissionsList($con);
    $this->saveCoursesList($con);
    $this->saveEventsList($con);
    $this->saveFriendsList($con);
    $this->saveSchoolsList($con);
    $this->saveInstructorCourseList($con);
    $this->savesfGuardUserList($con);

    parent::doSave($con);
  }

  public function saveGroupsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['groups_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Groups->getPrimaryKeys();
    $values = $this->getValue('groups_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Groups', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Groups', array_values($link));
    }
  }

  public function savePermissionsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['permissions_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Permissions->getPrimaryKeys();
    $values = $this->getValue('permissions_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Permissions', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Permissions', array_values($link));
    }
  }

  public function saveCoursesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['courses_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Courses->getPrimaryKeys();
    $values = $this->getValue('courses_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Courses', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Courses', array_values($link));
    }
  }

  public function saveEventsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['events_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Events->getPrimaryKeys();
    $values = $this->getValue('events_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Events', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Events', array_values($link));
    }
  }

  public function saveFriendsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['friends_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Friends->getPrimaryKeys();
    $values = $this->getValue('friends_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Friends', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Friends', array_values($link));
    }
  }

  public function saveSchoolsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['schools_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Schools->getPrimaryKeys();
    $values = $this->getValue('schools_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Schools', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Schools', array_values($link));
    }
  }

  public function saveInstructorCourseList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['instructor_course_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->InstructorCourse->getPrimaryKeys();
    $values = $this->getValue('instructor_course_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('InstructorCourse', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('InstructorCourse', array_values($link));
    }
  }

  public function savesfGuardUserList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['sf_guard_user_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->sfGuardUser->getPrimaryKeys();
    $values = $this->getValue('sf_guard_user_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('sfGuardUser', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('sfGuardUser', array_values($link));
    }
  }

}
