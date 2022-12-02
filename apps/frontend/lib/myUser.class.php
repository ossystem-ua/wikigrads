<?php

class myUser extends sfGuardSecurityUser {
    
    
    
    /**
    * executed when user SUCCESSFULLY signs into the system.... this code does NOT process a login attempt.
    * 
    * @param mixed $user - instance of sfGuardUser
    * @param mixed $remember - if cookie should be set
    * @param mixed $con - db connection
    */
    public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
    {
        // disable timeout anyway, doesn't matter, what user checked
        $options['timeout'] = false;
        parent::initialize($dispatcher, $storage, $options);
    }
    
    
    public function signIn($user, $remember = true, $con = null) {
        parent::signIn($user, $remember, $con);
    }
        
    public function isModerator() {
        if($this->getGuardUser()->getIsSuperAdmin()) {
            return true;
        }
        return $this->hasGroup('Moderator');
    }
        
        
        
    }
