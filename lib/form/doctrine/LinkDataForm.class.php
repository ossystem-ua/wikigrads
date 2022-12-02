<?php

/**
 * LinkData form.
 *
 * @package    Wikigrads
 * @subpackage form
 * @author     SkyBird
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LinkDataForm extends BaseLinkDataForm
{
  public function configure()
  {
       $fields = array(
            'url',
            'img',
            'title',
            'description',
            'host'
        );

        // URL
        $this->widgetSchema['url'] = new sfWidgetFormInputHidden();
        $this->validatorSchema['url'] = new sfValidatorString(array('required' => false));

        //IMAGE URL
        $this->widgetSchema['img'] = new sfWidgetFormInputHidden();
        $this->validatorSchema['img'] = new sfValidatorString(array('required' => false));

        //TITLE
        $this->widgetSchema['title'] = new sfWidgetFormInputHidden();
        $this->validatorSchema['title'] = new sfValidatorString(array('required' => false));

        //DESCRIPTION
        $this->widgetSchema['description'] = new sfWidgetFormInputHidden();
        $this->validatorSchema['description'] = new sfValidatorString(array('required' => false));

        //HOST
        $this->widgetSchema['host'] = new sfWidgetFormInputHidden();
        $this->validatorSchema['host'] = new sfValidatorString(array('required' => false));

        // GENERAL SETUP
        $this->useFields($fields);
        $this->widgetSchema->setNameFormat('post[%s]');

        $this->mergePostValidator(new LinkDataValidatorSchema());
  }
}
