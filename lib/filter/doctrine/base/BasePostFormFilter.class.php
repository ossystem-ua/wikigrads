<?php

/**
 * Post filter form base class.
 *
 * @package    Wikigrads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePostFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'object_id'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'object_name'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'parent_post_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ParentPost'), 'add_empty' => true)),
      'count_like'     => new sfWidgetFormFilterInput(),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'attachment_id'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'attachment_url' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ftype'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'content'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_pinned'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'flagget'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'everyone'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ftext'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'document_id'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'private'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserTracker'), 'add_empty' => true)),
      'link_data_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LinkData'), 'add_empty' => true)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'object_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'object_name'    => new sfValidatorPass(array('required' => false)),
      'parent_post_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ParentPost'), 'column' => 'id')),
      'count_like'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'attachment_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'attachment_url' => new sfValidatorPass(array('required' => false)),
      'ftype'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'content'        => new sfValidatorPass(array('required' => false)),
      'is_pinned'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'flagget'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'everyone'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ftext'          => new sfValidatorPass(array('required' => false)),
      'document_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'private'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserTracker'), 'column' => 'id')),
      'link_data_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LinkData'), 'column' => 'id')),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'deleted_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('post_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Post';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'object_id'      => 'Number',
      'object_name'    => 'Text',
      'parent_post_id' => 'ForeignKey',
      'count_like'     => 'Number',
      'user_id'        => 'ForeignKey',
      'attachment_id'  => 'Number',
      'attachment_url' => 'Text',
      'ftype'          => 'Number',
      'content'        => 'Text',
      'is_pinned'      => 'Boolean',
      'flagget'        => 'Boolean',
      'everyone'       => 'Boolean',
      'ftext'          => 'Text',
      'document_id'    => 'Number',
      'private'        => 'ForeignKey',
      'link_data_id'   => 'ForeignKey',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'deleted_at'     => 'Date',
    );
  }
}
