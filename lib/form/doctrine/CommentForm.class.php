<?php

/**
 * Post form.
 *
 * @package    sf_sandbox_old
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CommentForm extends BasePostForm {
    public function configure() {
        $fields = array(
            'content',
            'attachment_id',
            'document_id',
            'attachment_url'
        );    
        $this->useFields($fields);
        $this->widgetSchema['content'] = new sfWidgetFormTextarea();
        $this->validatorSchema['content'] = new sfValidatorString(array('required' => true));
        // ATTACHMENT_ID
        $this->validatorSchema['document_id'] = new sfValidatorInteger(array('required' => false));
        $this->validatorSchema['attachment_id'] = new sfValidatorInteger(array('required' => false));
        $this->validatorSchema['attachment_url'] = new sfValidatorString(array('required' => false));
    }
}
