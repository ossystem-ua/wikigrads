<?php

/**
 * LMSDomainKeySecret actions.
 *
 * @package    Wikigrads
 * @subpackage LMSDomainKeySecret
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LMSDomainKeySecretActions extends autoLMSDomainKeySecretActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
//  public function executeIndex(sfWebRequest $request)
//  {
//    $this->forward('default', 'module');
//  }

    public function executeNew(sfWebRequest $request)
    {
        $this->form = $this->configuration->getForm();
        $this->lms_domain_key_secret = $this->form->getObject();
    }
  
    public function executeCreate(sfWebRequest $request)
    {
        $this->form = $this->configuration->getForm();
        $this->lms_domain_key_secret = $this->form->getObject();

        $school = $request->getParameter($this->form->getName());
        $schoolId = (int)$school['domain'];
        $school['domain'] = $schoolId;
        $request->setParameter($this->form->getName(), $school);

        $this->processForm($request, $this->form);

        $this->setTemplate('new');
    }
    
    public function executeEdit(sfWebRequest $request)
    {
        $this->lms_domain_key_secret = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->lms_domain_key_secret);
    }
    public function executeUpdate(sfWebRequest $request)
    {
        $this->lms_domain_key_secret = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->lms_domain_key_secret);
        
        $school = $request->getPostParameter($this->form->getName());
        $school['domain'] = $this->lms_domain_key_secret->getDomain();
        $request->setParameter($this->form->getName(), $school);
        
        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }
    
}
