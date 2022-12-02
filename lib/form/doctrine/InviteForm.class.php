<?php

class InviteForm extends sfForm
{
  public function configure()
  {
    parent::configure();

   $this->setWidget('full_name',
      new sfWidgetFormInput(
        array(), array('maxlength' => 100)));
   
   $this->setValidator('full_name', new sfValidatorString(array('required' => true,
                'trim' => true,
                'required' => true,
                'min_length' => 4,
                'max_length' => 30)));
   
   $this->setWidget('email_address',
      new sfWidgetFormInput(
        array(), array('maxlength' => 100)));

    $this->setValidator('email_address',
      new sfValidatorAnd(
        array(
          new sfValidatorOr(
            array(
              new sfValidatorString(array('required' => true,
                'trim' => true,
                'min_length' => 4,
                'max_length' => 30)),
              new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser',
                'column' => 'email_address'), array("invalid" => "The user has already signed up. Look for them under new members list.")))),
          new sfValidatorEmail(array('required' => true)))));
    
    $this->setWidget('message', new sfWidgetFormTextarea());
    
    $this->setValidator('message', new sfValidatorPass());
        
    
    $this->widgetSchema->setNameFormat('invite[%s]');
    
    $this->widgetSchema->setFormFormatterName('list');
    
  }
}
