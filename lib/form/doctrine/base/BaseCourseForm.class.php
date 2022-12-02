<?php

/**
 * Course form base class.
 *
 * @method Course getObject() Returns the current form's model object
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCourseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'department_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => false)),
      'name'               => new sfWidgetFormInputText(),
      'code'               => new sfWidgetFormInputText(),
      'instructor'         => new sfWidgetFormInputText(),
      'instructor_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'category'           => new sfWidgetFormInputText(),
      'subject_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Subject'), 'add_empty' => true)),
      'access'             => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'deleted_at'         => new sfWidgetFormDateTime(),
      'sf_guard_user_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
      'school_list'        => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'School')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'department_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Department'))),
      'name'               => new sfValidatorString(array('max_length' => 255)),
      'code'               => new sfValidatorString(array('max_length' => 10)),
      'instructor'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'instructor_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'category'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'subject_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Subject'), 'required' => false)),
      'access'             => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
      'deleted_at'         => new sfValidatorDateTime(array('required' => false)),
      'sf_guard_user_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'school_list'        => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'School', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('course[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Course';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['sf_guard_user_list']))
    {
      $this->setDefault('sf_guard_user_list', $this->object->sfGuardUser->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['school_list']))
    {
      $this->setDefault('school_list', $this->object->School->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savesfGuardUserList($con);
    $this->saveSchoolList($con);

    parent::doSave($con);
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

  public function saveSchoolList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['school_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->School->getPrimaryKeys();
    $values = $this->getValue('school_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('School', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('School', array_values($link));
    }
  }

}
