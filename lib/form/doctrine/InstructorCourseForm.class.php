<?php

/**
 * InstructorCourse form.
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InstructorCourseForm extends BaseInstructorCourseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/sfGuardUser','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'course_id'  => new sfWidgetFormJQueryAutocompleter(array('url' => '/backend.php/autocomplite/Course','config' => '{ width: 220,max: 25,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}')),
      'access'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'course_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Course'), 'required' => false)),
      'access'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('instructor_course[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    unset(
            $this['created_at'],
            $this['updated_at']
        );
  }
//  protected function doSave($con = null)
//  {
//      
//    $this->savesfGuardUserList($con);
//
//    parent::doSave($con);
//  }
}
