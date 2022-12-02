<?php

require_once dirname(__FILE__).'/../lib/documentGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/documentGeneratorHelper.class.php';

/**
 * document actions.
 *
 * @package    Wikigrads
 * @subpackage document
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class documentActions extends autoDocumentActions
{
    
  /**
   * Download file .. check if user has proper credentials
   * 
   * @param sfWebRequest $request
   */
  public function executeDownload(sfWebRequest $request){
      
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->forward404Unless($document = DocumentTable::getDocumentBySlug($slug));

    $user = $this->getUser()->getGuardUser();

    if(!is_file($document->getLocalPath())){
        return $this->renderPartial('document/fileNotExist');
    }

    header('Content-disposition: attachment; filename="'.$document->getSanitizedFileName().'"');

    header('Content-type: '.$document->getMimeType());

    readfile($document->getLocalPath());

    exit;
      
  }    
}
