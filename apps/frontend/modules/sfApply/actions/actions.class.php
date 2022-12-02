<?php

require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineApplyPlugin/modules/sfApply/lib/BasesfApplyActions.class.php');

class sfApplyActions extends BasesfApplyActions
{
    
    public function executeAjaxDepartmentList(sfWebRequest $request){

      $this->forward404Unless($request->isXmlHttpRequest());
      
      $school_id = $this->getRequestParameter('id');
      
      if(!$school_id){
          return $this->renderText('<div id="sfApplyApply_primary_department_id" class=""><select><option value="">Select Major</option></select></div>'); 
      }
      
      $this->forward404Unless($school = Doctrine_Core::getTable('School')->findOneById($school_id));   

      $options = array();

      $options['school'] = $school;

      $form = new sfApplyForm(null, $options);

      return $this->renderPartial('sfApply/displayMajorDropDown', array('form' => $form));

    }    

    public function executeApply(sfRequest $request)
    {
        if ($this->getUser()->isAuthenticated()) {
                $this->redirect('@homepage');
        }

        $data = $request->getParameter('sfApplyApply');
        
        $options = array();

        if (isset($data['school_id']) && $data['school_id']) {
            $school = Doctrine_Core::getTable('School')->find($data['school_id']);
            $options['school'] = $school;
        }
        
        if (isset($data['is_staff']) && $data['is_staff']) {
            $options['graduation_info_required'] = FALSE;
            $show_graduation_info_fields = false;
        }
        else{
            $show_graduation_info_fields = true;
        }
        
        $form = new sfApplyForm(null, $options);
        $form = $this->processForm($form, $request);
        
        
        $this->userRegType = 0;
        
        $routeOptions = sfContext::getInstance()->getRouting()->getOptions();
        $prefix       = $routeOptions['context']['path_info'];
        $prefix       = str_replace("apply", "", $prefix);
        $prefix       = str_replace("/", "", $prefix);
        if (strlen($prefix) > 0) $this->userRegType = intval($prefix);
        
        // if ajax and school was passed in
        // type 0 - students
        // type 1 - instructor
        if($request->isXmlHttpRequest() && $school) {
            return $this->renderPartial('sfApply/form', array(
                'form' => $form,
                'type' => $this->userRegType
            ));
        }        
        
        $departmentData = $request->getParameter("department");
        $courseData     = $request->getParameter("course");
        
        $this->courseForm = new CourseForm();
        $this->departmentForm = new DepartmentForm();
        
        if($request->isMethod('post')) {
            $this->departmentForm->bind($departmentData);
            $this->courseForm->bind($courseData);
        }
        
        if ($form->isValid()) {
            try {
                $profile = $form->getObject();
                $this->sendVerificationMail($profile);
                    if(((isset($data['is_staff']) && $data['is_staff'])
                            ||(isset($data['school_id']) && $data['school_id'])) && $prefix
                    ) {
                        if(
                            !empty($departmentData['name']) &&
                            !empty($courseData['code']) &&
                            !empty($departmentData['alias']) &&
                            !empty($courseData['name'])
                        ) {
                            //create new course and make user an instructor
                            
                            //looking for department
                            $dep = Doctrine_Core::getTable("Department")
                                    ->findOneBySchoolAndName(
                                            (int)$data['school_id'], 
                                            strtolower($departmentData['name'])
                                    );

                            if($dep instanceof Department) {
                                $department = Doctrine_Core::getTable("Department")->find($dep->getId());
                                $new = false;
                            } else {
                                $new = true;
                                //create the department
                                $department = new Department();
                                if(isset($school)) 
                                    $department->setSchool($school);
                                $department->setName($departmentData['name']);
                                $department->setAlias($departmentData['alias']);
                            }

                            if(!$new) {
                                //search for course
                                $c = Doctrine_Core::getTable("Course")->findOneByDepartmentAndName($department, strtolower($courseData['name']));
                                if($c instanceof Course) {
                                    $course = Doctrine_Core::getTable("Course")->find($c->getId());
                                }
                            }
                            
                            if(isset($course) && $course instanceof Course && $course->getId()) {
                                
                            } else {
                                //create course
                                $course = new Course();
                                $course->setDepartment($department);
                                $course->setName($courseData['name']);
                                $course->setCode($courseData['code']);
                                $course->setInstructor($profile->getUser());
                            }
                            
                            //assign instructor to course
                            $assign = new InstructorCourse();
                            $assign->setUser($profile->getUser());
                            $assign->setCourse($course);

                            $assign->save();
                                
                            
                            $usercorse = new UserCourse();
                            $usercorse->setUser($profile->getUser());
                            $usercorse->setCourse($course);
                            $usercorse->save();

                            $syspost = new Notification();
                            $syspost->setObjectId($usercorse->getId());
                            $syspost->setObjectName(get_class($usercorse));
                            $syspost->setRelatedObjectId($course->getId());
                            $syspost->setRelatedObjectName(get_class($course));
                            $syspost->setAction("add");
                            $syspost->setType("Classmate");
                            $syspost->save();
                        }
                    }
                return 'After';
            } catch (Exception $e) {
                $profile = $form->getObject();
                $user = $profile->getUser();

                $profile->delete();
                $user->delete();

                throw $e;

                // You could re-throw $e here if you want to
                // make it available for debugging purposes
                return 'MailerError';
            }
        }

        $this->form = $form;
        $this->show_graduation_info_fields = $show_graduation_info_fields;
        
        $this->getResponse()->setTitle("Register");

    }	
  
    public function executeConfirm(sfRequest $request)
    {
        // 0.6.3: oops, this was in sfGuardUserProfilePeer in my application
        // and therefore never got shipped with the plugin until I built
        // a second site and spotted it!

        // Note that this only works if you set foreignAlias and
        // foreignType correctly 
        $validate = $this->request->getParameter('validate');
        if (!strlen($validate)) {
            return 'Invalid';
        }
        
        $sfGuardUser = Doctrine_Query::create()->
                from("sfGuardUser u")->
                innerJoin("u.Profile p with p.validate = ?", $validate)->
                fetchOne();

        if (!$sfGuardUser) {
            return 'Invalid';
        }

        $type = self::getValidationType($validate);

        $profile = $sfGuardUser->getProfile();
        if (!$profile) return 'Invalid';
        
        $profile->setValidate(null);
        $profile->save();

        if ($type == 'New') {
            $sfGuardUser->setIsActive(true);  

            // disable for now
//            $sfGuardUser->addFirstFriend();  

            $sfGuardUser->save();
            
            //Notify users about this new student in school
            $userSchools = $sfGuardUser->getUserSchool();
            $userSchool = $userSchools[0]; 
            
            if ($userSchool) {
                //Send latest school notifications to this new user
                //$schoolNotifications = NotificationTable::getNotificationsBySchoolId($userSchool->getSchoolId(), 20);
                //foreach($schoolNotifications as $notification){
                //    $userNotification = NotificationTable::saveUserNotification($sfGuardUser, $notification);
                //}
                //$sendNotifications = NotificationTable::insertNotifications($userSchool, Notification::ADD_ACTION, Notification::EVERYONE_TYPE);
            }
            $this->getUser()->signIn($sfGuardUser);
            
            return $this->redirect('@my_profile_first');
        }

        if ($type == 'Reset') {
                $this->getUser()->setAttribute('sfApplyReset', $sfGuardUser->getId());
                return $this->redirect('sfApply/reset');
        }
    }  
    
    protected function processForm($form, sfWebRequest $request, $options = array())
    {
        if ($request->isMethod('post') && $request->hasParameter($form->getName())) {
            $data = $this->getRequestParameter($form->getName());
            $files = $request->getFiles($form->getName());                        

            $form->bind($data, $files);

            if ($form->isValid()) {
                $guid = "n" . self::createGuid();

                $form->setValidate($guid);
                $form->save();

                if (isset($options['flash'])) {
                        $this->getUser()->setFlash('notice', $options['flash']);
                }

                if (isset($options['redirect'])) {
                        $this->redirect($options['redirect']);
                }
            }
        }

        return $form;

    }
    
    protected function sendVerificationMail($profile)
    {
        $message = $this->getMailer()->compose();
        
        $message->setSubject(sfConfig::get('app_mail_apply_subject', 'Welcome to WikiGrads confirmation'));
        
        $message->setFrom(array(
            'no-reply@wikigrads.com' => 'no-reply@wikigrads.com',
        ));
        
        $message->setTo(array(
            $profile->email => $profile->fullname,
        ));
        
        $message->setBody($this->getPartial('sfApply/sendValidateNew', array(
            'first_name' => $profile->getUser()->getFirstName(), 
            'last_name'  => $profile->getUser()->getLastName(), 
            'validate' => $profile->validate,
        )), 'text/html');
        
        $this->getMailer()->send($message);
    }
    
    public function resetRequestBody($user) {
        if (!$user) {
            return 'NoSuchUser';
        }
        $this->forward404Unless($user);
        $profile = $user->getProfile();

        if (!$user->getIsActive()) {
            $type = $this->getValidationType($profile->getValidate());
            if ($type === 'New') {
                try {
                    $this->sendVerificationMail($profile);
                } catch (Exception $e) {
                    return 'UnverifiedMailerError';
                }
                return 'Unverified';
            } elseif ($type === 'Reset') {
                // They lost their first password reset email. That's OK. let them try again
            } else {
                return 'Locked';
            }
        }
        $profile->setValidate('r' . self::createGuid());
        $profile->save();

        try {
            $message = $this->getMailer()->compose();

            $message->setSubject(sfConfig::get('app_sfApplyPlugin_reset_subject', sfContext::getInstance()->getI18N()->__("Please verify your password reset request on %1%", array('%1%' => $this->getRequest()->getHost()))));

            $message->setFrom(array(
                'no-reply@wikigrads.com' => 'no-reply@wikigrads.com',
            ));

            $message->setTo(array(
                $profile->getEmail() => $profile->getFullName(),
            ));

            $message->setBody($this->getPartial('sfApply/sendValidateReset', array(
                        'fullname' => $profile->getFullname(),
                        'validate' => $profile->getValidate(),
                        'username' => $user->getUsername()
                    )), 'text/html');

            $this->getMailer()->send($message);
        } catch (Exception $e) {

            return 'MailerError';
        }
        return 'After';
    }

    static private function createGuid()
    {
        $guid = "";
        // This was 16 before, which produced a string twice as
        // long as desired. I could change the schema instead
        // to accommodate a validation code twice as big, but
        // that is completely unnecessary and would break
        // the code of anyone upgrading from the 1.0 version.
        // Ridiculously unpasteable validation URLs are a
        // pet peeve of mine anyway.
        for ($i = 0; ($i < 8); $i++) {
            $guid .= sprintf("%02x", mt_rand(0, 255));
        }
        return $guid;
    }

    static private function getValidationType($validate)
    {
        $t = substr($validate, 0, 1);
        if ($t == 'n') {
            return 'New';
        } elseif ($t == 'r') {
            return 'Reset';
        } else {
            return sfView::NONE;
        }
    }


    //Overrode the zend loader logic.
    static private $zendLoaded = false;

    public function registerZend()
    {
        if (self::$zendLoaded)
        {
            return;
        }

        $sf_zend_lib_dir = sfConfig::get('app_zend_lib_dir', sfConfig::get('sf_lib_dir').'/vendor');

        //if ($sf_zend_lib_dir) {
        set_include_path($sf_zend_lib_dir.PATH_SEPARATOR.get_include_path());
        require_once($sf_zend_lib_dir.'/Zend/Loader/Autoloader.php');
        $loader = Zend_Loader_Autoloader::getInstance();
        //}

        # Zend 1.8.0 and thereafter
        //include_once('Zend/Loader/Autoloader.php');
        //$loader = Zend_Loader_Autoloader::getInstance();
        // Zend should NOT be the fallback autoloader, that gets in Symfony's way and generates warnings in 1.3
        $loader->setFallbackAutoloader(false);
        $loader->suppressNotFoundWarnings(false);

        self::$zendLoaded = true;

    }
}
