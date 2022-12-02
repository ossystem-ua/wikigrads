<?php

/**
 * LMSDomainKeySecret form base class.
 *
 * @method LMSDomainKeySecret getObject() Returns the current form's model object
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLMSDomainKeySecretForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'domain'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('school'), 'add_empty' => true)),
      'key_s'      => new sfWidgetFormInputText(),
      'secret'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'domain'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('school'), 'required' => false)),
      'key_s'      => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'secret'     => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
      'deleted_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lms_domain_key_secret[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LMSDomainKeySecret';
  }

}
