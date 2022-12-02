<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

#require_once(dirname(__FILE__).'/../lib/BasesfGuardAuthActions.class.php');
require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class sfGuardAuthActions extends BasesfGuardAuthActions {
    public function executeSignin($request) {
        $user = $this->getUser();
        if ($user->isAuthenticated()) {
            return $this->redirect('@homepage');
        }
        
        $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin'); 
        $this->form = new $class();

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('signin'));

            
            // SUCCESSFUL LOGIN
            if ($this->form->isValid()) {
                $values = $this->form->getValues(); 

                $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);
                $signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $user->getReferer($request->getReferer()));
                
                return $this->redirect('' != $signinUrl ? $signinUrl : '@homepage');

            // FAILED LOGIN
            } else {
                $formStatus = Utils::getFormStatus($this->form);
                sfContext::getInstance()->getUser()->setFlash('login_error', $formStatus['form_errors']['username']);
                $failureSigninUrl = sfConfig::get('app_sf_guard_plugin_failure_signin_url', $user->getReferer($request->getReferer()));  
                return $this->redirect($failureSigninUrl != '' ? $failureSigninUrl : '@homepage');
            }
        
        // if they made it here, then this is a page load after their session has timed out. this page is not directly linked to.
        } else {
            if ($request->isXmlHttpRequest()) {
                $this->getResponse()->setHeaderOnly(true);
                $this->getResponse()->setStatusCode(401);
                return sfView::NONE;
            }

            // if we have been forwarded, then the referer is the current URL
            // if not, this is the referer of the current request
            $user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

             //  var_dump($user->getReferer($request->getReferer())); exit;
            $module = sfConfig::get('sf_login_module');
            if ($this->getModuleName() != $module)
            {
              return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
            }

            $this->getResponse()->setStatusCode(401);
            
          //  var_dump( $user->getReferer($request->getReferer())); exit;
       //     sfContext::getInstance()->getUser()->setFlash('login_error', 'Your login has expired. Please login again.');
            $failureSigninUrl = ''; // sfConfig::get('app_sf_guard_plugin_failure_signin_url', $user->getReferer($request->getReferer()));  
            return $this->redirect($failureSigninUrl != '' ? $failureSigninUrl : '@homepage');

        }
        
    }
    
}