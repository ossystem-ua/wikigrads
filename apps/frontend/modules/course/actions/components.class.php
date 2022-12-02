<?php
class courseComponents extends sfComponents {
  
  public function executeList(sfWebRequest $request) {
    $user = $this->user;
        
    if ($slug = $request->getParameter('slug')) {
      $user = sfGuardUserTable::getUserBySlug($slug);
    }
    
    if (!$user) {
      $user = $this->getUser()->getGuardUser();
    }
    if (!$this->getUser()->getGuardUser()->getsfGuardUserProfile()->getHasModifiedProfile()) {
      $this->class = 'close-disable';
    } else {
      $this->class = '';
    }
    
    $this->user = $user;
    $this->courses = $user->getCourseList();    
  }
  
  
}
