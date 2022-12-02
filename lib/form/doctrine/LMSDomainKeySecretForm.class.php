<?php

/**
 * LMSDomainKeySecret form.
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LMSDomainKeySecretForm extends BaseLMSDomainKeySecretForm
{
  public function configure()
  {
      
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'domain'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('school'), 'add_empty' => true, 'method' => 'getSchoolNameAndLmsDomain')),
      'key_s'      => new sfWidgetFormInputText(),
      'secret'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'domain'     => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'key_s'      => new sfValidatorString(array('max_length' => 128, 'required' => true)),
      'secret'     => new sfValidatorString(array('max_length' => 128, 'required' => true)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lms_domain_key_secret[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
