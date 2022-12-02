<?php

/**
 * Post form base class.
 *
 * @method Post getObject() Returns the current form's model object
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePostForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'object_id'      => new sfWidgetFormInputText(),
      'object_name'    => new sfWidgetFormInputText(),
      'parent_post_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ParentPost'), 'add_empty' => true)),
      'count_like'     => new sfWidgetFormInputText(),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'attachment_id'  => new sfWidgetFormInputText(),
      'attachment_url' => new sfWidgetFormInputText(),
      'ftype'          => new sfWidgetFormInputText(),
      'content'        => new sfWidgetFormInputText(),
      'is_pinned'      => new sfWidgetFormInputCheckbox(),
      'flagget'        => new sfWidgetFormInputCheckbox(),
      'everyone'       => new sfWidgetFormInputCheckbox(),
      'ftext'          => new sfWidgetFormInputText(),
      'document_id'    => new sfWidgetFormInputText(),
      'private'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserTracker'), 'add_empty' => true)),
      'link_data_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LinkData'), 'add_empty' => true)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'deleted_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'object_id'      => new sfValidatorInteger(),
      'object_name'    => new sfValidatorString(array('max_length' => 255)),
      'parent_post_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ParentPost'), 'required' => false)),
      'count_like'     => new sfValidatorInteger(array('required' => false)),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'attachment_id'  => new sfValidatorInteger(),
      'attachment_url' => new sfValidatorString(array('max_length' => 255)),
      'ftype'          => new sfValidatorInteger(),
      'content'        => new sfValidatorPass(),
      'is_pinned'      => new sfValidatorBoolean(array('required' => false)),
      'flagget'        => new sfValidatorBoolean(array('required' => false)),
      'everyone'       => new sfValidatorBoolean(array('required' => false)),
      'ftext'          => new sfValidatorString(array('max_length' => 255)),
      'document_id'    => new sfValidatorInteger(),
      'private'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserTracker'), 'required' => false)),
      'link_data_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LinkData'), 'required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'deleted_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('post[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Post';
  }

}
