<?php

/**
 * school actions.
 *
 * @package    sf_sandbox_old
 * @subpackage school
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class schoolActions extends sfActions
{
  public function executeActivity(sfWebRequest $request)
  {
    $this->schools = Doctrine_Core::getTable('School')
      ->createQuery('a')
      ->execute();
  }
  

}
