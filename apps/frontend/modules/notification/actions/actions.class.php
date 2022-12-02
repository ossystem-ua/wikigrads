<?php
//include 'mathpublisher.php';
/**
 * notification actions.
 *
 * @package    sf_sandbox_old
 * @subpackage notification
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class notificationActions extends myActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request)
    {
      $this->forward('default', 'module');
    }
    
    public function executeEditor(sfWebRequest $request)
    {
        $this->id = $this->getRequestParameter('id');
        return $this->renderPartial('notification/editor');
    }

//    public function executeMathEditor(sfWebRequest $request) {
//        $text = '<m>'.$request->getGetParameter('formula').'</m>';
//        $size = 20;
//        $pathtoimg = "/images/uploads/";
//        echo mathfilter($text, $size, $pathtoimg);
//        exit;
//    }
    
    public function getUserStaff($notificationId=0, $courseId=0, $postId=0) {
        $user = $this->getUser()->getGuardUser();
        $is_current_staff = $user->getSfGuardUserProfile()->is_staff;

        if (!$user) return 0;

        if ($notificationId==0 && $courseId==0 && $postId==0) {
            return $is_current_staff;
        } else {
            if ($courseId==0) {
                if ($postId > 0) {
                    $post = Doctrine::getTable('Post')->findOneBy("id", $postId);
                    if ($post) {
                        if ($post->getObjectName() == "Course")
                            $courseId = $post->getObjectId();
                        else {
                            $not = Doctrine::getTable('Notification')
                                    ->createQuery('n')
                                    ->where('n.object_id = ?', $post)
                                    ->andWhere('n.object_name = ?', 'Post')
                                    ->execute();
                            foreach($not as $record) {
                                $notificationId = $record->getId();
                            }
                        }
                    }
                }
            }

            if ($courseId <= 0 && $notificationId > 0) {
                $not = Doctrine::getTable('Notification')->findOneBy("id", $notificationId);
                if ($not) {
                    if ($not->getRelatedObjectName() == "Course") {
                        $courseId = $not->getRelatedObjectId();
                    }
                }
            }
        }
        $result = Doctrine::getTable('InstructorCourse')
                ->createQuery('ic')
                ->where('ic.user_id = ?', $user->getId())
                ->andWhere('ic.course_id = ?', $courseId)
                ->execute();
        if (count($result) > 0)
            return 1;
        else
            return 0;
    }

    /**
     * Returns the list of comments
     * @param sfWebRequest $request
     * @return type
     */
    public function executeCommentList(sfWebRequest $request) {
        $this->forward404Unless($request->isXmlHttpRequest());
        $this->forward404Unless($notification_id = $this->getRequestParameter('id'));
        $this->forward404Unless($notification = Doctrine_Core::getTable('Notification')->findOneById($notification_id));

        $user = $this->getUser()->getGuardUser();
        $IsStaff = $this->getUserStaff($notification_id);
        $options = array(
            'user' => $user,
            'notification_id'   => $notification_id
        );
        $nl = new NotificationList($options);
        $notification = $nl->getOne();

        return $this->renderPartial('notification/notification_comment_list', array('comments' => $notification['comments'], 'load_wgTpl'=>true, 'IsStaff' => $IsStaff, 'profile' => $user->getSfGuardUserProfile()));
    }

    /**
    * Returns notification list for everyone or a specific class - called by ajax
    *
    * sample url for direct load of course: http://wikigradsdev.com/frontend_dev.php/notification/list/course/9%7Cexternal-financial-reporting-issues
    *
    * @param sfWebRequest $request
    * @return sfView::NONE
    */
    public function executeList(sfWebRequest $request) {
        $type = $request->getParameter('type');
        $user = $this->getUser()->getGuardUser();
        $filter = $request->getParameter('filter');
        
        if ($filter) {
            $this->getResponse()->setCookie('filter', $filter, time()+3600);
        }
        $this->filter = $this->getRequest()->getCookie('filter');
        if (!$this->filter) {
            $this->filter = 'All';
        } elseif ($this->filter === 'instructorContent') {
            $this->filter = 'Instructor content';
        }
        // autopager
        $pageName = $request->getParameter('page', 1);

        $this->autopager = new AutoPager(array('recs_per_page' => 5));
        $this->autopager->setPageNum($pageName);
        $tab_id = 0;

        $notifications = $this->getNotificationList($request, $type, $user, false, $tab_id); #Utils::pfa($notifications);

        $instructor = Doctrine_core::getTable('InstructorCourse')->findOneBy("course_id", $tab_id);
        if (!$instructor) {
            $this->redirect('@my_profile');
        }
        
        $countPinned = Doctrine_core::getTable('post')->createQuery('p')
                       ->select('count(p.is_pinned)')
                       ->where('p.is_pinned > 0')
                       ->andWhere('p.deleted_at IS NULL')
                       ->andWhere('p.object_id = ?', $tab_id)
                       ->fetchOne();
        
        if ($countPinned) {
            $countPinned = $countPinned->getCount();
        } else {
            $countPinned = 0;
        }
        $pinned = array();
        if(!$request->getParameter('pager') && 
            $request->getParameter('isAutoLoad') != '1' &&
            $countPinned > 0) {
                $pinned = $this->getNotificationList($request, $type, $user, true, $tab_id); #Utils::pfa($notifications);
        }

        $school = $user->getMainSchool();
        $currentCourse = array();
        $currentCourse['id'] = $tab_id;
        $currentCourse['IsGroup'] = false;

//        $dq = Doctrine_Core::getTable('Course')->createQuery('c')
//                ->andWhere('c.name = c.category')
//                ->andWhere('c.id = ?', $tab_id)
//                ->fetchOne();
//        if (count($dq) > 0) {
//            $currentCourse['IsGroup'] = true;
//        }
        $aliasName = "";
//        if ($currentCourse['IsGroup']) {
            $result = Doctrine_Core::getTable('Course')->findOneById($tab_id);
            if ($result->getDepartment()) {
//                $aliasName = $result->getDepartment()->getAlias()." ".$result->getCode();
                $aliasName = $result->getShortName();
            } else {
                $aliasName = $result->getCode();
            }
//        }
        /* FORM */

        $post = new Post();
        $post->setUserId($user->getId());
        $courses = $user->getCourseList();

        /////////////////////////////////////////////////
        $userCourse = Doctrine::getTable("UserCourse")
                ->createQuery('uc')
                ->where('uc.user_id = ?', $user->getId())
                ->andWhere('uc.course_id = ?', $tab_id)
                ->fetchArray();
        if (!$userCourse) {
            $this->redirect('@homepage');
        }
        /////////////////////////////////////////////////
        //$options = array('default_course'=>''); // '' = everyone (i.e. no course specified)
        $default_course = count($courses) ? $tab_id : '';
        $options = array('default_course'=> $default_course); // '' = everyone (i.e. no course specified)
        $form = new DashboardPostForm($post, $options);

        $document_fields = $request->getParameter('document');
        $course_id       = $document_fields['course_id'];
        $name            = $document_fields['name'];
        $document = new Document();
        $document->setName($name);
        $document->setUserId($user->getId());
        $document->setCourseId($course_id);
        // tpl var assignments
        $this->form     = $form;
        $this->formdoc  = new DocumentAddForm($document, array());
        $this->doc_form = $form;
        $this->courses  = $courses;
        $this->counters = array();
        //check if user is staff-user to give him privilege to pin his posts
        $this->is_Staff = $this->getUserStaff(0, $tab_id);
        $this->profile = $user;
        $this->courseId = $tab_id;
        # PLEASE choose only one block
        #
        /**/
        // for content in body page

        $user = Doctrine::getTable('sfGuardUser')->findOneBy("id", $this->profile->getSfGuardUserProfile()->getUserId());
        if ($this->profile->getSfGuardUserProfile()->getIsStaff() == 1 ||
            $this->profile->getSfGuardUserProfile()->getIsTutor() == 1) {
            $this->user_name = $user->getFirstName()." ".$user->getLastName();
        } else {
            $this->user_name = $user->getFirstName()." ".substr($user->getLastName(),0,1);
        }

        $this->timezone = (isset($school))? $school->getTimezone() : NULL;
        $this->type = $type;
        $this->pinned = $pinned;
        $this->CurrCourse = $currentCourse;
        $this->courseName = $aliasName;

        $this->filter_menu = array('all'=>'', 'instructorContent'=>'', 'documents'=>'', 'images'=>'', 'links'=>'');
        switch ($this->filter) {
            case 'Documents': $this->filter_menu['documents'] = 'active'; break;
            case 'Images': $this->filter_menu['images'] = 'active'; break;
            case 'Links': $this->filter_menu['links'] = 'active'; break;
            case 'Instructor content': $this->filter_menu['instructorContent'] = 'active'; break;
            case 'All': $this->filter_menu['all'] = 'active'; break;
            default: $this->filter_menu['all'] = 'active';
        }

        $this->notifications = $notifications;

        $this->getResponse()->setTitle("Course"); 
        $this->onResetCounter($request, $currentCourse['id']);
    }

    public function onResetCounter($request, $course_id) { 
        $GU = $this->getUser()->getGuardUser();
        $private = $request->getParameter('user');
        if (is_null($private)) {
            $private = 0;
        }
        
        $tracker = Doctrine::getTable('UserTracker')->createQuery('ut')
                ->where('ut.course_id = ?', $course_id)
                ->andWhere('ut.user_id = ?', $GU->getId())
                ->andWhere('ut.private = ?', $private)
                ->fetchOne();
        if ($tracker) {

            $max_notification = $this->maxNotification($course_id, $private);
            $tracker->setNewPosts(0);
            $tracker->setNewClassmates(0);
            $tracker->setNotificationId($max_notification);
            $tracker->setPrivate($private);
            $tracker->save();
        } else {
            
            $max_notification = $this->maxNotification($course_id, $private);
            
            $tracker = new UserTracker();
            $tracker->setUserId($GU->getId());
            $tracker->setCourseId($course_id);
            $tracker->setNewPosts(0);
            $tracker->setNewClassmates(0);
            $tracker->setNotificationId($max_notification);
            $tracker->setPrivate($private);
            $tracker->save();
        }
        
    }
    
    public function maxNotification ($course_id, $private) {
        $max_notification = 0;
        $notification = Doctrine::getTable('Notification')->createQuery('n')
            ->where('n.related_object_name = "Course"')
            ->andWhere('n.related_object_id = ?', $course_id)
            ->fetchArray();
        
        if ($notification) {
            foreach ($notification as $notif) {

                if (!isset($notifId)) { $notifId = ''; }
                else { $notifId = $notifId.', '; }
                    
                if ($notif['id'] > $max_notification)
                    $max_notification = $notif['id'];

                $notifId .= $notif['id'];
            }

            $post = Doctrine::getTable('Notification')->createQuery('n')
                ->where('n.related_object_name = "Notification"')
//                ->andWhere('n.related_object_id IN ?', $notifId)
                ->andWhere('n.id > ?', $notif['id'])
                ->fetchArray();

            foreach ($post as $pt) {
                if ($pt['id'] > $max_notification)
                    $max_notification = $pt['id'];
            }
        }
        return $max_notification;
    }

    protected function getNotificationList(sfWebRequest $request, $type, $user, $pinned, &$tab_id) {
        // note: for $this->autopager->setBaseLink()... this should match the routes used for the tabs (see modules/sfGuardUser/templates/_nav.php)
        $arrEveryone    = array();
        $userId = $request->getParameter('user');
        if (is_null($userId)) {
            $userId = 0;
        }

        if($type == "course") {
            $this->forward404Unless($slug = $request->getParameter('slug'));
            $this->forward404Unless($course = CourseTable::getCourseBySlug($slug));
            $filter = $this->getRequest()->getCookie('filter');
            $arrEveryone[0] = intval($course->getId());
            $arrEveryone[1] = $course->getId();

            $options = array(
                'user'  =>  $user,
                'related_object' => $course,
                'pinned' => $pinned,
                'arr_everyone' => $arrEveryone,
                'gCourseId' => $course->getId()
            );
            $tab_id = $course->getId();

            $curId   = $course->getId();
            $curName = Utils::slugify($course->getName());

            if ($arrEveryone[1] > 0) {
                $curName = $arrEveryone[1];
            }
            $this->autopager->setBaseLink('@notification_course_list?type=course&slug='.$curId.'|'.$curName);

        } elseif ($type == "private") {
            $slug = $request->getParameter('id');
            $course = CourseTable::getCourseBySlug($slug);

            $filter = $this->getRequest()->getCookie('filter');
            $arrEveryone[0] = intval($course->getId());
            $arrEveryone[1] = $course->getId();
            $options = array(
                'user'  =>  $user,
                'type' => $type,
                'related_object' => $course,
                'pinned' => $pinned,
                'arr_everyone' => $arrEveryone,
                'studentId' => $userId,
                'gCourseId' => $course->getId()
            );
            $tab_id = $course->getId();
            $curId   = $course->getId();
            $curName = Utils::slugify($course->getName());

            if ($arrEveryone[1] > 0) {
                $curName = $arrEveryone[1];
            }
            $this->autopager->setBaseLink('@notification_private_list?type=private&id='.$curId.'&user='.$userId);
        }else {
            $type = array(Notification::EVERYONE_TYPE, Notification::CLASSMATE_TYPE);

            $options = array(
                'user'  =>  $user,
                'type'  =>  $type,
                'object_name_exclude' => 'UserCourse',
                'arr_everyone' => $arrEveryone
            );
            $tab_id = '0';
            $this->autopager->setBaseLink('@notification_list?type=everyone');
        }
        $nl = new NotificationList($options);

        //count the number of notifications
        $cntRec = $this->getCountNotification($tab_id, $filter, $type, $userId);

        $this->autopager->setRecCount($cntRec+1);
        $notifications = false; // default

        if($this->autopager->isPageNumValid()) {
            $notifications = $nl->getList(($pinned)? 0 : $this->autopager->getOffset(), $this->autopager->getRecsPerPage(), $filter, $type, $userId);
        }
        return $notifications;
    }

    protected function getNotificationList20121010(sfWebRequest $request)
    {
        $type = $request->getParameter('type');

        $user = $this->getUser()->getGuardUser();

        if($type == "course"){

            $this->forward404Unless($slug = $request->getParameter('slug'));

            $this->forward404Unless($course = CourseTable::getCourseBySlug($slug));

            $notifications = $user->getNotificationsByRelatedObject($course);            
        }

        else{
            $type = array(Notification::EVERYONE_TYPE, Notification::CLASSMATE_TYPE);
            #$notifications = $user->getNotificationsByType($type);

            $options = array(
                'user'  =>  $user,
                'type'  =>  $type
            );
            $nl = new NotificationList($options);
            $notifications = $nl->getList();
        }

        return $notifications;

    }

    /**
     * This function deletes a post.
     *   It deletes an entry in 'notification' table, not an entry in 'post' table.
     *   Deleting a notification effectively hides all related-post to be displayed.
     *
     *   TODO: Decide which class this method belongs to - Notification or Post.
     */
    public function executeDeletePost(sfWebRequest $request)
    {
        # find notification to be deleted

        if ($notification_id = $request->getParameter('notification_id')) {
            $this->forward404Unless($notification = Doctrine_Core::getTable('Notification')->findOneById($notification_id));
        }
        $IsStaff = $this->getUserStaff($notification_id);
        # check ownership of notification

        $isModerator = $this->getUser()->isModerator();
        $userIdSession = $this->getUser()->getGuardUser()->getID();
        $userIdNotification = $notification->getObject()->getUserId();
        $isOfficer =  $this->getUser()->getGuardUser()->getIsOfficer();

        if ($isModerator || $userIdSession == $userIdNotification || $IsStaff == 1 || $isOfficer == 1) {

            # delete
            $comments = Doctrine_Core::getTable('Post')->createQuery('c')
                      ->where('object_id = ?', $notification->getId())
                      ->execute();
            
            if ($comments) {
                foreach ($comments as $comment) {
                    $this->deletePost($comment);
                }
            }

            if ($notification->getObjectName() == 'Post') {
                $post = Doctrine_Core::getTable($notification->getObjectName())->findOneById($notification->getObjectId());

                if ($post->getDocumentId() > 0) {
                    $document = Doctrine_Core::getTable('Document')->findOneById($post->getDocumentId());
                    $document->delete();
                }
                $post->delete();
            }

            if ($notification->delete()) {
                $this->getUser()->setFlash('notice', 'The post was successfully deleted.');
            } else {
                $this->getUser()->setFlash('error', 'The post was unable to be deleted. Please try again.');
            }

        } else {
            $this->getUser()->setFlash('error', 'Permission denied. You can only delete your own post.');
        }
        return "None";
    }
    
    public function deletePost ($comment) {
        
        if ($comment->getDocumentId() > 0) {
            $delDoc = Doctrine_Core::getTable('Document')->findOneById($comment->getDocumentId());
            $delDoc->delete();
        }

        $comment->delete();
    }
    
    public function executeUserList(sfWebRequest $request) {
        $this->forward404Unless($this->courseId = $this->getRequestParameter('id'));
        $this->user = $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
        $this->userId = $this->getUser()->getGuardUser()->getId();
        
        $course = Doctrine_core::getTable('Course')
                ->createQuery('c')
                ->where('c.id = ?', $this->courseId)
                ->fetchOne();
        $this->courseName = $course->getShortName();
        
        $userCourse = Doctrine_core::getTable('UserCourse')
                ->createQuery('uc')
                ->where('uc.course_id = ?', $this->courseId)
                ->execute();

        $instructors = Doctrine_core::getTable('InstructorCourse')
                ->createQuery('uc')
                ->where('uc.course_id = ?', $this->courseId)
                ->fetchArray();
        $instructorIdList = array();
        foreach ($instructors as $ins) {
            $instructorIdList[] = $ins['user_id'];
        }
        
        $this->newPosts = $this->userNotification($this->courseId, $this->userId);

        $this->users = array();
        foreach ($userCourse as $key => $user) {
            if (in_array($user->getUserId(), $instructorIdList)) {
                continue;
            }
            $users = Doctrine_core::getTable('sfGuardUser')
                    ->createQuery('u')
                    ->where('u.id = ?', $user->getUserId())
                    ->fetchArray();
            if ($users) {
                $this->users[$key]['full_name'] = $users[0]['first_name']." ".$users[0]['last_name'];
                $this->users[$key]['user_id'] = $users[0]['id'];
            } else {
                continue;
            }

            $postCount = Doctrine_core::getTable('post')
                    ->createQuery('p')
                    ->where('p.private = ?', $user->getUserId())
                    ->andWhere('p.object_id = ?', $this->courseId)
                    ->fetchArray();
            $count = count($postCount);
            
            
            if ($count <= 0 && empty($postCount)) {
                $this->users[$key]['post_count'] = ' - ';
                $this->users[$key]['post_date'] = ' - ';
                $this->users[$key]['attachment'] = 0;
            } else {
                $this->users[$key]['post_count'] = $count;
                $this->users[$key]['post_date'] = $postCount[$count - 1]['created_at'];
                foreach ($postCount as $post) {
                    if ($post['attachment_id'] > 0 || $post['document_id'] > 0) {
                        $this->users[$key]['attachment'] = 1;
                    } else {
                        $this->users[$key]['attachment'] = 0;
                    }
                }
            }
        }
    }

    public function userNotification($courseId, $userId){
        $counters = array();
        $params = array();
        $params['course'] = (int)$courseId;
        $params['user'] = (int)$userId;

        //new private post
        $conn = Doctrine_Manager::connection();
        $newPrivatePost = $conn->execute('SELECT ut.course_id, ut.notification_id, ut.private,
                                 (SELECT COUNT(*)
                                    FROM notification AS n
                              INNER JOIN post p on n.object_id = p.id
                                   WHERE p.private = ut.private
                                     AND n.related_object_id = :course
                                     AND n.related_object_name = "Course"
                                     AND n.id > ut.notification_id) count,
                                 (SELECT MAX(p.attachment_id)
                                    FROM notification AS n
                              INNER JOIN post p ON n.object_id = p.id
                                   WHERE n.related_object_id = :course
                                     AND p.private = ut.private
                                     AND n.id > ut.notification_id
                                     AND p.private > 0) attachment,
                                 (SELECT MAX(p.document_id)
                                    FROM notification AS n
                              INNER JOIN post p ON n.object_id = p.id
                                   WHERE n.related_object_id = :course
                                     AND p.private = ut.private
                                     AND n.id > ut.notification_id
                                     AND p.private > 0) document
                                FROM user_tracker ut
                               WHERE ut.user_id = :user
                                 AND ut.private > 0
                                 AND ut.course_id = :course', $params)->fetchAll();
        foreach ($newPrivatePost as $courses) {
            $counters[$courses['private']]['post'] = (int)$courses['count'];
            if (($courses['document'] > 0 && !is_null($courses['document'])) ||
                ($courses['attachment'] > 0 && !is_null($courses['attachment'])))
            {
                $counters[$courses['private']]['attachment'] = 1;
            } else {
                $counters[$courses['private']]['attachment'] = 0;
            }
        }
        return $counters;
    }
    
    public function executePrivateFeed(sfWebRequest $request) {
        $this->forward404Unless($courseId = $this->getRequestParameter('id'));
        $this->forward404Unless($userId = $this->getRequestParameter('user'));
        $user = $this->getUser()->getGuardUser();
        $this->courseId = $courseId;
        $this->userId = $userId;
        
        $sfGuardUserProfile = Doctrine_Core::getTable('sfGuardUser')->createQuery('up')
                ->where('up.id = ?', $userId)
                ->fetchOne();
        
        if ($sfGuardUserProfile) {
            $this->studentName = $sfGuardUserProfile->getFirstName()." ".$sfGuardUserProfile->getLastName();
        } else {
            $this->studentName = 'Unknown user';
        }
            
        $tab_id = $courseId;
        $post = new Post();
        $post->setUserId($user->getId());
        $courses = $user->getCourseList();
        $default_course = count($courses) ? $tab_id : '';
        $options = array('default_course'=> $default_course);
        $form = new DashboardPostForm($post, $options);
        $this->form = $form;
        
        $document_fields = $request->getParameter('document');
        $course_id       = $document_fields['course_id'];
        $name            = $document_fields['name'];
        $document = new Document();
        $document->setName($name);
        $document->setUserId($user->getId());
        $document->setCourseId($course_id);
        $this->formdoc  = new DocumentAddForm($document, array());
        
        $this->IsStaff = $this->getUserStaff(0, $tab_id);
        $this->profile = $user;
        
        $filter = $request->getParameter('filter');
        if ($filter) {
            $this->getResponse()->setCookie('filter', $filter, time()+3600);
        }
        $this->filter = $this->getRequest()->getCookie('filter');
        if (!$this->filter) {
            $this->filter = 'All';
        }
        $this->filter_menu = array('all'=>'', 'instructorContent'=>'', 'documents'=>'', 'images'=>'', 'links'=>'');
        switch ($this->filter) {
            case 'Documents': $this->filter_menu['documents'] = 'active'; break;
            case 'Images': $this->filter_menu['images'] = 'active'; break;
            case 'Links': $this->filter_menu['links'] = 'active'; break;
            case 'Instructor content': $this->filter_menu['instructorContent'] = 'active'; break;
            case 'All': $this->filter_menu['all'] = 'active'; break;
            default: $this->filter_menu['all'] = 'active';
        }
        
        $school = $user->getMainSchool();
        $currentCourse = array();
        $currentCourse['id'] = $tab_id;
        $currentCourse['IsGroup'] = false;

        $dq = Doctrine_Core::getTable('Course')->createQuery('c')
                ->andWhere('c.name = c.category')
                ->andWhere('c.id = ?', $tab_id)
                ->fetchOne();
        if (count($dq) > 0) {
            $currentCourse['IsGroup'] = true;
        }
        $aliasName = "";
        if ($currentCourse['IsGroup']) {
            $result = Doctrine_Core::getTable('Course')->findOneById($tab_id);
            if ($result->getDepartment()) {
                $aliasName = $result->getShortName();
//                $aliasName = $result->getDepartment()->getAlias()." ".$result->getCode();
            } else {
                $aliasName = $result->getCode();
            }
        }
        $this->courseName = $aliasName;

        $pageName = $request->getParameter('page', 1);
        $this->autopager = new AutoPager(array('recs_per_page' => 5));
        $this->autopager->setPageNum($pageName);
        $type = 'private';
        $tab_id = 0;

        $pinned = array();
        if(!$request->getParameter('pager') && $request->getParameter('isAutoLoad') != '1') {
            $pinned = $this->getNotificationList($request, $type, $user, true, $tab_id);
        } else {
            $pinned = false;
        }
        
        $instructor = Doctrine_core::getTable('InstructorCourse')->findOneBy("course_id", $tab_id);
        if (!$instructor) {
            $this->redirect('@my_profile');
        }
        
        $this->pinned = $pinned;
        
        $notifications = $this->getNotificationList($request, $type, $user, false, $tab_id);
        $this->notifications = $notifications;
        
        $user = Doctrine::getTable('sfGuardUser')->findOneBy("id", $this->profile->getSfGuardUserProfile()->getUserId());
        if ($this->profile->getSfGuardUserProfile()->getIsStaff() == 1 ||
            $this->profile->getSfGuardUserProfile()->getIsTutor() == 1) {
            $this->user_name = $user->getFirstName()." ".$user->getLastName();
        } else {
            $this->user_name = $user->getFirstName()." ".substr($user->getLastName(),0,1);
        }
        
        $params['course_id'] = $courseId;
        $conn = Doctrine_Manager::connection();
        $this->instructors = $conn->execute('SELECT CONCAT(up.first_name, " ", up.last_name) AS fullname, up.id  
                                               FROM instructor_course AS ic
                                          LEFT JOIN sf_guard_user AS up ON ic.user_id = up.id
                                              WHERE ic.course_id = :course_id
                                           GROUP BY ic.user_id', $params)->fetchAll();
        
        $this->timezone = (isset($school))? $school->getTimezone() : NULL;
        $this->type = $type;

        $this->onResetCounter($request, $currentCourse['id']);
    }
    
    private function getCountNotification ($tab_id, $filter, $type, $userId) {
        
        $cntRec = Doctrine::getTable('Post')->createQuery('p')
                  ->select('COUNT(p.id)')
                  ->where("p.object_id = ?", $tab_id)
                  ->andWhere("p.deleted_at IS NULL");

        if ($type == 'course') {
            
        } elseif ($type == 'private') {
            $cntRec->andWhere("p.private = ?", $userId);
        } else {
            return 0;
        }

        if ('Documents' === $filter) {
            $cntRec->andWhere("p.document_id <> 0");
        } elseif ('Images' === $filter) {
            $cntRec->andWhere("p.attachment_id <> 0");
        } elseif ('Links' === $filter) {
            $cntRec->andWhere("p.link_data_id <> 0");
        } elseif ('instructorContent' === $filter) {
            $instructors = Doctrine_core::getTable('instructorCourse')->createQuery('ic')
                               ->where('ic.course_id = ?', $tab_id)
                               ->fetchArray();
                
            $instructorsList = array();
            foreach ($instructors as $instructor) {
                $instructorsList[] = (int)$instructor['user_id'];
            }

            $cntRec->andWhereIn("p.user_id", $instructorsList);
        }

        $cntRec = $cntRec->fetchArray();

        return $cntRec[0]['COUNT'];
    }

    /**
     * Function that scrapes url from the request (AJAX)
     *
     * @param sfWebRequest $request
     * @return type
     */
    public function executeScrapeUrl(sfWebRequest $request) {
        $GU = $this->getUser()->getGuardUser();
        if (!$GU) $this->redirect('@homepage');

        $url = $request->getParameter('experimentalUrl');//"http://photo.net/editors-picks/2014/snow-photography/";//
        //$url = "http://www.youtube.com/watch?v=HnYRl0p3fqo";
        $rmetas = array();
        if( FALSE === strstr( $url, "//" ) ) {
            $rmetas['url'] = "http://" . $url;
        } else {
            $rmetas['url'] = $url;
        }

        $parsedUrl = parse_url( $rmetas['url'] ); //will contain information about url

        $html = $this->file_get_contents_curl( $url );
        if( -1 === $html ){
            $rmetas['error'] = "Content not found.";
            return $this->renderText(json_encode( $rmetas ));
        }

        $doc = new DomDocument();
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8");//to fix problems with russian chars in the fields, also works with japanese etc.
        @$doc->loadHTML( $html );
        $xpath = new DOMXPath($doc);
        $query = '//*/meta[starts-with(@property, \'og:\')]'; //example: <meta property="og:image" content="//s.ytimg.com/yts/img/youtube_logo_stacked-vfl225ZTx.png">
        $metas = $xpath->query($query);
        foreach ($metas as $meta) {
            $property = $meta->getAttribute('property');
            $content = $meta->getAttribute('content');
            if( 0 === strcmp($property, "og:image")) {
                $rmetas['image'] = $content;
            }
            if( 0 === strcmp($property, "og:title") ) {
                $rmetas['title'] = $content;
            }
            if( 0 === strcmp($property, "og:description") ) {
                $rmetas['description'] = $content;
            }
        }

        ///////////////////////////////////////////////
         if( !isset($rmetas['image']) || !isset($rmetas['title']) || !isset($rmetas['description'])) {
            if( !isset($rmetas['title']) ){
               $nodes = $doc->getElementsByTagName('title');
               if( 0 === $nodes->length ) {
                   $rmetas['error'] = "No title node found.";
                   return $this->renderText(json_encode( $rmetas ));
               }
               $rmetas['title'] = $nodes->item(0)->nodeValue;
            }

            $metas1 = $doc->getElementsByTagName('meta');
            for ($i = 0; $i < $metas1->length; $i++)
            {
                $meta = $metas1->item($i);
                if($meta->getAttribute('name') == 'description' && !isset($rmetas['description']) ) {
                    $rmetas[ 'description' ] = $meta->getAttribute('content');
                }
                if($meta->getAttribute('itemprop') == 'image' && !isset($rmetas['image']) ) {
                    $image = $meta->getAttribute('content');
                    $imgUrl = parse_url( $image );
                    if( !isset( $imgUrl['host']) ) { //if image's address is relative path
                        $rmetas[ 'image' ] = $parsedUrl['scheme'] . "://" . $parsedUrl['host'] . $image; //add scheme and host to the path
                    } else {
                        $rmetas[ 'image' ] = $image;
                    }
                }
            }

            if( !isset($rmetas['image']) ) {
                $images  = $doc->getElementsByTagName('img');

                for( $i = 0; $i < $images->length; $i++ ){
                    $image = $images->item($i)->getAttribute('src');
                    $imgUrl = parse_url( $image );
                    if(preg_match("([^\s]+(\.(?i)(jpg))$)", $imgUrl['path'])) { //|png|gif|bmp <-- add this to "jpg" if you need in this extensions
                        if( !isset( $imgUrl['host']) ) { //if image's address is relative path
                            $rmetas['images'][] = $parsedUrl['scheme'] . "://" . $parsedUrl['host'] . $image;
                        } else {
                            $rmetas['images'][] = $image;
                        }
                    }
                }
                if( isset($rmetas['images']) ){
                    $rmetas['images'] = array_unique($rmetas['images']); // exclude repeatable urls
                }
            }
        }
        ///////////////////////////////////////////////
        $rmetas['host'] = $parsedUrl['host'];
        $rmetas['scheme'] = $parsedUrl['scheme'];
        $this->getResponse()->setContentType('application/json');
        return $this->renderText(json_encode( $rmetas ));
    }

    private function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $data = curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if( 400 <= $retcode || 0 === $retcode ){
            return -1;
        }
        return $data;
    }

}


