<?php

/**
 * event actions.
 *
 * @package    sf_sandbox_old
 * @subpackage event
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eventActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->events = Doctrine_Core::getTable('Event')
      ->createQuery('a')
      ->execute();
  }

}
