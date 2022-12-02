<?php
class myActions extends sfActions
{
    /**
    * The content-title can be overridden by calling this.
    * The $source should be a substring that matches an image file,
    * e.g. if the image file = banner-friend_list.png, source should be 'friend_list'.
    *
    * @param mixed $source -
    */
    protected function setContentTitleSource($source) {
        $this->getResponse()->setSlot("content-title", $source);
    }



////////////////////////////////////////////////////////////////
//                                                           //
// PAGER                                                    //
//                                                         //
////////////////////////////////////////////////////////////
    /**
     * Returns doctrine pager with applicable class and sql objects set
     *
     * @param unknown_type $class = Object
     * @param unknown_type $sql = Doctrine_Query
     * @param unknown_type $page
     * @param unknown_type $limit
     * @return unknown
     */
    protected function getPager($class, $sql = null, $page = 1, $limit = 10) {
        $pager = new sfDoctrinePager($class, $limit);

        if ($sql !== null) {
            $pager->setQuery($sql);
        }

        $pager->setPage($page);
        $pager->init();

        return $pager;
    }

    /**
     * Get the page from the request.
     *
     * If the page doesn't exist, attempt to get it from the session, else default: 1
     *
     * @param unknown_type $request
     * @param unknown_type $param
     * @return unknown
     */
    protected function getPage(sfWebRequest $request, $param = 'page')
    {
        return $request->getParameter($param, $this->getUser()->getAttribute($param, 1, $this->namespace));
    }

    /**
     * Set the page to the user's session
     *
     * @param unknown_type $page
     * @param unknown_type $param
     */
    protected function setPage($page, $param = 'page')
    {
        $this->getUser()->setAttribute($param, $page, $this->namespace);
    }

    /**
     * Get the number of items displayed on a page from the request.
     *
     * If the page doesn't exist, attempt to get it from the session, else default: 10
     *
     * @return unknown
     */
    protected function getShowPerPage($request)
    {
        if($request->hasParameter('show_per_page')) {
            $show_per_page = $request->getParameter('show_per_page');

            #reset page to the first page if there is a new value for show_per_page
            $this->setPage(1);
        }
        else {
            $show_per_page = $this->getUser()->getAttribute('show_per_page', 10, $this->namespace);
        }
        return $show_per_page;
    }

    /**
     * Set the number of items displayed on a page to the user's session
     *
     * @param int $number
     */
    protected function setShowPerPage($number = 10)
    {
        $this->getUser()->setAttribute('show_per_page', $number, $this->namespace);
    }



////////////////////////////////////////////////////////////////
//                                                           //
// FORM                                                     //
//                                                         //
////////////////////////////////////////////////////////////
    protected function processForm($form, sfWebRequest $request, $options = array(), &$IdCourse = 0) {

        if ($request->isMethod('post') && $request->hasParameter($form->getName())) {

            $data = $request->getParameter($form->getName());
            $files = $request->getFiles($form->getName());
            $user = $this->getUser()->getGuardUser();
            
            //developers hack
            if($form->getName()=='post' && (substr($data['content'], 0, 8)==">>test<<")) {
                $options['skip_notification'] = true;
            }

            $form->bind($data, $files);

            $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

            if ($form->isValid()) {

                try {
                    $conn->beginTransaction();

                    //$this->checkNewNotification ($form->getValue('course_id'), $user->getId(), $form->getName());

                    if ($form->getName() == 'course_add') {
                        $notification_type = Notification::CLASSMATE_TYPE;
                        $courseId  = $form->getValue('course_id');
                        $subjectId = $form->getValue('category');
                        $access    = $form->getValue('access');
                        $IdCourse = $courseId;

                        // check course id
                        $result = Doctrine_Core::getTable('UserCourse')->createQuery('uc')
                                ->andWhere ('uc.user_id = ?', $user->getId())
                                ->andWhere ('uc.course_id = ?', $courseId)
                                ->andWhere ('uc.object_name = ?', 'Course')
                                ->fetchArray();
                        if (count($result) > 0 || $courseId == null) $courseId = false;

                        // check subject id
                        $result = Doctrine_Core::getTable('UserCourse')->createQuery('uc')
                                ->andWhere ('uc.user_id = ?', $user->getId())
                                ->andWhere ('uc.course_id = ?', $subjectId)
                                ->andWhere ('uc.object_name = ?', 'Subject')
                                ->fetchArray();
                        if (count($result) > 0 || $subjectId == null) $subjectId = false;

                        // param access to course
                        $bAccess = false;
                        // get course access
                        $result = Doctrine_Core::getTable('Course')->createQuery('c')
                                ->andWhere ('c.id = ?', $courseId)
                                ->andWhere ('c.access is not null')
                                ->fetchOne();
                        if ($result) {
                            if ($result['access'] == $access) {
                                $bAccess = true;
                            }
                        } else {
                            $access  = null;
                            $bAccess = true;
                        }


                        if ($courseId && $bAccess) {
                            $userCourse = new UserCourse();
                            $userCourse->setUserId($user->getId());
                            $userCourse->setCourseId($courseId);
                            $userCourse->setObjectName('Course');
                            $userCourse->setAccess($access);
                            $userCourse->save();

                            //Send latest course notifications to this new classmate
                            $schoolNotifications = NotificationTable::getNotificationsByCourseId($userCourse->getCourseId(), 20);

                            foreach($schoolNotifications as $notification){
                                $userNotification = NotificationTable::saveUserNotification($user, $notification);

                            }

                            $sendNotifications = NotificationTable::insertNotifications($userCourse, Notification::ADD_ACTION, $notification_type);

                        }

                        if($subjectId && $bAccess) {
                            $userCourse = new UserCourse();
                            $userCourse->setUserId($user->getId());
                            $userCourse->setCourseId($subjectId);
                            $userCourse->setObjectName('Subject');
                            $userCourse->setAccess($access);
                            $userCourse->save();

                            //Send latest course notifications to this new classmate
                            $schoolNotifications = NotificationTable::getNotificationsByCourseId($userCourse->getCourseId(), 20);

                            foreach($schoolNotifications as $notification){
                                $userNotification = NotificationTable::saveUserNotification($user, $notification);
                            }


                            $sendNotifications = NotificationTable::insertNotifications($userCourse, Notification::ADD_ACTION, $notification_type);
                        }

                    } else {

                        if($form->getName() == 'post' && $course_id = $form->getValue('course_id')){
                            $studentId = $request->getPostParameter('studentId');
                            if (!is_null($studentId) && !empty($studentId)) {
                                $form->getObject()->setPrivate($studentId);
                            }
                            $form->getObject()->setObjectId($course_id);
                            $form->getObject()->setObjectName(Post::COURSE_OBJECT);
                            $notification_type = $form->getValue('type');

                            unset($form['course_id']);
                            unset($form['type']);

                            $IdCourse = $course_id;
                            $courseTracker = Doctrine::getTable('UserTracker')->createQuery('ut')
                                ->where('course_id = ?', $course_id)
                                ->andWhere('user_id = ?', $user->getId())
                                ->fetchOne();
                        }
                        //if post is a notification's comment so we need to set the notification type the same as the notification
                        elseif($form->getName() == 'post' && $form->getObject()->getObjectName() == Post::NOTIFICATION_OBJECT){
                            $notification_type = $form->getObject()->getObject()->getType();
                            //$sendNotifications = NotificationTable::insertNotifications($form->getObject(), Notification::ADD_ACTION, $notification_type, $conn);
                        }
                        elseif ($form->getName() == 'post') {
                            $form->getObject()->setObjectId($user->getMainSchool()->getId());
                            $form->getObject()->setObjectName(Post::SCHOOL_OBJECT);
                            $notification_type = Notification::EVERYONE_TYPE;
                        }
                        elseif ($form->getName() == 'document') {
                            $notification_type = Notification::CLASSMATE_TYPE;
                        }
                        else{
                            $notification_type = Notification::EVERYONE_TYPE;
                        }
                        $form->save();

                        if($form->getName() != 'document' && (!isset($options['skip_notification']) || !$options['skip_notification'])){

                            $sendNotifications = NotificationTable::insertNotifications($form->getObject(), Notification::ADD_ACTION, $notification_type, $conn);

                            if (!$course_id) {
                                $object_id = $form->getObject()->getObjectId();
                                $q = Doctrine::getTable('notification')->createQuery('n')
                                ->where('n.id = ?', $object_id)
                                ->fetchOne();
                                $course_id = $q->getRelatedObjectId();
                            }

                            /*
                            if(!isset($courseTracker)) {
                                $courseTracker = Doctrine::getTable('UserTracker')->createQuery('ut')
                                ->where('ut.course_id = ?', $course_id)
                                ->andWhere('ut.user_id = ?', $user->getId())
                                ->fetchOne();
                            }

                            //$courseTracker->setNewPosts(0);
                            //$courseTracker->setNewClassmates(0);
                            //$courseTracker->setNotification($sendNotifications);*/
                            //if ($courseTracker) $courseTracker->save();
                        }
                   }

                    $conn->commit();
                } catch (Exception $e) {
                    $conn->rollback();
                    throw $e;
                }

                if (isset($options['flash'])) {
                	$this->getUser()->setFlash('notice', $options['flash']);
                }

                if (isset($options['redirect'])) {
                	$this->redirect($options['redirect']);
                }
            }

        } else if ($request->isMethod('put') && $request->hasParameter($form->getName())) {

            # edit post

            $data = $request->getParameter($form->getName());

            $form->bind($data);

            $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

            if ($form->isValid()) {
                try {
                    $conn->beginTransaction();
                    $form->save();
                    $conn->commit();
                } catch (Exception $e) {
                    $conn->rollback();
                    throw $e;
                }
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



////////////////////////////////////////////////////////////////
//                                                           //
// INCLUDES                                                 //
//                                                         //
////////////////////////////////////////////////////////////
    /**
    * include a stylesheet.
    *
    * @param mixed $rel_path
    * @param mixed $position ('first' or 'last')
    */
    protected function includeCSS($rel_path, $position = '') {
        $this->getResponse()->addStylesheet($rel_path, $position);
    }

    /**
    * include a javascript file.
    * uses relative path to 'js' dir.
    *
    * @param mixed $rel_path
    */
    protected function includeJS($rel_path) {
        $this->getResponse()->addJavascript($rel_path);
    }



////////////////////////////////////////////////////////////////
//                                                           //
// FLASH MESSAGES                                           //
//                                                         //
////////////////////////////////////////////////////////////
    protected function setFlashNotice($msg) {
        $this->getUser()->setFlash('notice', $msg);
    }

    protected function setFlashError($msg) {
        $this->getUser()->setFlash('error', $msg);
    }

    protected function checkNewNotification($courseId, $userId, $type) {
        if ($type == 'Post' || $type == 'Course') {
            $userCourse = Doctrine::getTable('UserCourse')->createQuery('us')
                ->andWhere('us.user_id = ?', $userId)
                ->andWhere('us.course_id = ?', $courseId)
                ->fetchOne();

            if ($userCourse) {
                $result = Doctrine::getTable('Notification')->createQuery('n')
                    ->andWhere('n.object_id = ?', $userCourse->getId())
                    ->andWhere('n.object_name = ?', 'UserCourse')
                    ->andWhere('n.related_object_id = ?', $courseId)
                    ->andWhere('n.related_object_name = ?', 'Course')
                    ->fetchArray();

                if (count($result) <= 0) {
                    $notification = new Notification();
                    $notification->setObjectId($userCourse->getId());
                    $notification->setObjectName('UserCourse');
                    $notification->setRelatedObjectId($courseId);
                    $notification->setRelatedObjectName('Course');
                    $notification->setType('Classmate');
                    $notification->setAction('Add');
                    $notification->save();

                    $usernot = new \UserNotification();
                    $usernot->setNotificationId($notification->getId());
                    $usernot->setUserId($userId);
                    $usernot->setIsSeen(0);
                    $usernot->save();

                    $arr = array();
                    $arr['notification'] = $notification;
                    return $arr;
                }
            }
        }
        return false;
    }
}


