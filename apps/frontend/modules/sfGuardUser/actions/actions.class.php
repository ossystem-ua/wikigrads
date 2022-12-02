<?php

/**
 * sfGuardUser actions.
 *
 * @package    sf_sandbox_old
 * @subpackage sfGuardUser
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserActions extends myActions
{
    public function getUserStaff() {
        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');

        $result = Doctrine::getTable('InstructorCourse')
                ->createQuery('ic')
                ->where('ic.user_id = ?', $user->getId())
                ->execute();
        if (count($result) > 0)
            return 1;
        return 0;
    }

    public function executeUpdateCounters() {
        $GU = $this->getUser()->getGuardUser();
        if (!$GU) $this->redirect('@homepage');
        
        $counters = array();
        $params = array();
        $params['user'] = $GU->getId();
        
        $isInstructor = Doctrine_core::getTable('instructorCourse')->createQuery('ic')
                        ->where('ic.user_id = ?', $params['user']) 
                        ->fetchOne();
        if ($isInstructor) {
            $isInstructor = 'AND ut.private > 0';
        } else {
            $isInstructor = 'AND ut.private = :user';
        }
        
        $conn = Doctrine_Manager::connection();
        $studentPosts = $conn->execute("SELECT uc.user_id, uc.course_id, 
                                            (SELECT count(*)
                                               FROM post AS p
                                              WHERE p.private = uc.user_id
                                                AND p.object_id = uc.course_id
                                                AND p.deleted_at IS NULL) posts
                                         FROM  user_course AS uc
                                    LEFT JOIN sf_guard_user_profile AS up ON uc.user_id = up.user_id
                                        WHERE uc.course_id IN 
                                            (SELECT course_id 
                                               FROM user_course 
                                              WHERE user_id = :user) 
                                          AND up.is_staff = 0
                                          AND up.is_tutor = 0", $params)->fetchAll();
        
        $studentCourse = array();
        foreach ($studentPosts as $course) {
            $studentCourse[$course['course_id']][$course['user_id']] = (int)$course['posts'];
        }
        
        //new private post
        $params['private'] = 0;
        if ($GU->getIsLms() === "0") {
            $sql = "AND ut.course_id IN (SELECT course_id FROM user_course WHERE user_id = :user)";
        } else {
            $this->session_course_id = new sfSessionStorage();
            $courseId = $this->session_course_id->read('cId');
            $params['courseId'] = $courseId;
            $sql = "AND ut.course_id = :courseId";
        }
        
        $newPrivatePost = $conn->execute('SELECT ut.course_id, ut.notification_id, ut.private,
                                 (SELECT COUNT(*) 
                                    FROM notification AS n 
                              INNER JOIN post p on n.object_id = p.id
                                   WHERE p.private = ut.private
                                     AND n.related_object_id = ut.course_id
                                     AND n.related_object_name = "Course"
                                     AND n.id > ut.notification_id) count,
                                 (SELECT MAX(p.attachment_id) 
                                    FROM notification AS n 
                              INNER JOIN post p ON n.object_id = p.id 
                                   WHERE n.related_object_id = ut.course_id
                                     AND p.private = ut.private 
                                     AND n.id > ut.notification_id 
                                     AND p.private > :private) attachment,
                                 (SELECT MAX(p.document_id) 
                                    FROM notification AS n 
                              INNER JOIN post p ON n.object_id = p.id 
                                   WHERE n.related_object_id = ut.course_id 
                                     AND p.private = ut.private 
                                     AND n.id > ut.notification_id 
                                     AND p.private > :private) document
                                    FROM user_tracker ut
                               WHERE ut.user_id = :user '.$isInstructor.' '.$sql, $params)->fetchAll();

        foreach ($newPrivatePost as $course) {
            if ($course['count'] > 0) {
                $counters[$course['course_id']][$course['private']]['private_post'] = (int)$course['count'];
                if (($course['document'] > 0 && !is_null($course['document'])) || 
                    ($course['attachment'] > 0 && !is_null($course['attachment'])))
                {
                        $counters[$course['course_id']][$course['private']]['attachment'] = 1;
                }
            } else {
                $counters[$course['course_id']][$course['private']]['private_post'] = 0;
                $counters[$course['course_id']][$course['private']]['attachment'] = 0;
            } 
        }
        var_dump($counters);
        foreach ($studentCourse as $key => $value) {
            if (isset($counters[$key])) {
                foreach ($value as $user_id => $post) {
                    if (!isset($counters[$key][$user_id])) {
                        if ($counters[$key][$user_id] == $params['user']) {
                            $counters[$key][$user_id]['private_post'] = $post;
                            $counters[$key][$user_id]['attachment'] = 0;
                        }
                    }
                }
            } else {
                foreach ($value as $user_id => $post) {
                    if ($counters[$key][$user_id] == $params['user']) {
                        $counters[$key][$user_id]['private_post'] = $post;
                        $counters[$key][$user_id]['attachment'] = 0;
                    }
                }
            }
        }
        
        foreach ($counters as $key => $courses) {
            $newPost = 0;
            foreach ($courses as $userPage) {
                if (!empty($userPage['private_post'])) {
                    $newPost += $userPage['private_post'];
                }
            }
            $counters[$key]['private_post'] = $newPost;
        }

        //new posts
        $newPost = $conn->execute('SELECT ut.course_id, ut.notification_id, 
                                         (SELECT COUNT(*) 
                                            FROM notification AS n 
                                      INNER JOIN post AS p ON n.object_id = p.id 
                                           WHERE n.related_object_id = ut.course_id 
                                             AND n.related_object_name = "Course"
                                             AND p.private = :private 
                                             AND p.deleted_at IS NULL 
                                             AND n.id > ut.notification_id) countP,
                                         (SELECT COUNT(*)
                                            FROM notification AS n
                                      INNER JOIN post AS p ON n.object_id = p.id
                                       LEFT JOIN notification AS cn ON n.related_object_id = cn.id
                                           WHERE cn.related_object_id = ut.course_id 
                                             AND n.related_object_name = "Notification"
                                             AND p.private = :private
                                             AND p.deleted_at IS NULL 
                                             AND n.id > ut.notification_id) countC
                                     FROM user_tracker AS ut 
                                    WHERE ut.user_id = :user
                                      AND ut.private = :private 
                                      AND ut.notification_id <> 0 '.$sql,
                    $params)->fetchAll();

        foreach ($newPost as $course) {
            $counters[$course['course_id']]['post'] = (int)$course['countP'] + (int)$course['countC'];
        }
        
        $this->getResponse()->setContentType('application/json');
        return $this->renderText(json_encode($counters));
    }
    
//    public function executeResetCounter(sfWebRequest $request) {
//        $user = $this->getUser()->getGuardUser();
//        if (!$user) $this->redirect('@homepage');
//
//        $course_id = $request->getParameter('id');
//        if ($course_id > 0) {
//            $GU = $this->getUser()->getGuardUser();
//
//            $courseTracker = Doctrine::getTable('UserTracker')->createQuery('ut')
//                ->where('course_id = ?', $course_id)
//                ->andWhere('user_id = ?', $GU->getId())
//                ->fetchOne();
//
//            $newlyPosted = Doctrine::getTable('Notification')->createQuery('n')
//                ->where('n.related_object_name = "Course" ')
//                ->andWhere('n.related_object_id = ?', $course_id)
//                ->andWhere('n.id > ?', $courseTracker->getNotificationId())
//                ->execute();
//
//            $notification = 0;
//            foreach ($newlyPosted as $n) {
//                if($notification==0) {
//                    $notification=$n;
//                } else {
//                    if($n->getId()>$notification->getId()) {
//                        $notification=$n;
//                    }
//                }
//            }
//
//
//            //then - update counter
//            $courseTracker->setNewPosts(0);
//            $courseTracker->setNewClassmates(0);
//
//            if($notification) {
//                $courseTracker->setNotificationId($notification->getId());
//            }
//
//            $courseTracker->save();
//
//            $this->getResponse()->setContentType('application/json');
//        }
//        return $this->renderText(json_encode(array("success"=>true)));
//    }

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeDashboard(sfWebRequest $request) {
        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');
        
        $post = new Post();
        $post->setUserId($user->getId());

        $courses = $user->getCourseList();

        //$options = array('default_course'=>''); // '' = everyone (i.e. no course specified)
        $default_course = count($courses) ? $courses[0]->getId() : 0;

        $options = array('default_course'=> $default_course); // '' = everyone (i.e. no course specified)

        $form = new DashboardPostForm($post, $options);
        
        // tpl var assignments
        $this->form     = $form;
        $this->courses  = $courses;
        $this->counters = array();
        $this->doc_form = $form;

        //check if user is staff-user to give him privilege to pin his posts
        $this->isStaff = $this->getUserStaff();

        $this->first_user_course = $default_course;
        
        $this->getResponse()->setTitle("Dashboard");
    }

       /**
        * Edit
        *
        * Edit profile information.
        *
        * @param sfWebRequest $request
        */
     public function executeEdit(sfWebRequest $request) {

        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');

        $form = new sfGuardUserProfileEditForm($user->getSfGuardUserProfile());

        if ($request->isMethod('put')) {
            $request->setMethod('post');
        }

        $form = $this->processForm($form, $request, array(
            'flash' => 'You have successfully updated your profile.',
            'skip_notification' => true
        ));

        if ($form->isValid()) {
            $this->redirect("@my_profile");
        }

        $this->profile = $user['sfGuardUserProfile'];
        $this->form = $form;

     }



    /**
     * Index
     * This displays a user's profile. It can display the logged in user's profile OR someone else's profile.
     *
     * This is the profile page for a user.
     *
     * @param sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request)
    {
        // main function
        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');
        
        $this->isTutor = 0;

        if ($userId = $request->getParameter('id')) {

            $this->forward404Unless($user = sfGuarduserTable::getUserBySlug($userId));

            if ($user->getId() == $this->getUser()->getGuardUser()->getId()) {
                $this->redirect('@my_profile'); // executeIndex is where @my_profile goes, so why redirect? Redirect so that url says my-profile
            }

            $this->my_profile = false;
            $this->getResponse()->setTitle($user->getName().' Profile');
        }
        else{
            $this->my_profile = true;
            $this->getResponse()->setTitle('My Profile');
        }

        if ($user->getSfGuardUserProfile()->getIsTutor()) {
            $one = Doctrine::getTable('sfGuardUserProfile')->findOneBy("user_id", $user->getId());
            if ($one) {
                if ($one->getIsTutor())
                    $this->isTutor = 1;
            }
        }

        $this->courses = $user->getCourseList();
        $this->profile = $user->getSfGuardUserProfile();
        $this->user = $user;
        $this->userNameCaption = $user->getFirstName()." ".$user->getLastName();
        $this->userNameStudentCaption = $user->getFirstName()." ".substr($user->getLastName(),0,1);

        //
        $form = new sfGuardUserProfileEditForm($user->getSfGuardUserProfile());
        if ($request->isMethod('put')) {
            $request->setMethod('post');
        }
        $form = $this->processForm($form, $request, array(
            'flash' => 'You have successfully updated your profile.',
            'skip_notification' => true
        ));
        if ($form->isValid()) {
            $this->redirect("@my_profile");
        }
        $this->form = $form;
        $this->doc_form = $form;
        $this->isStaff = $user->getSfGuardUserProfile()->getIsStaff();

        $params = array();
        $params['user_id'] = $user->getId();
        
        $conn = Doctrine_Manager::connection();
        $pdo = $conn->execute('SELECT c.id, c.name, c.category AS category, (SELECT COUNT(uc.course_id) AS course_id FROM user_course uc WHERE(uc.course_id=c.id)) AS userCount FROM course c WHERE (c.deleted_at IS NULL AND c.instructor_id=:user_id)', $params)->fetchAll();
        $this->myCourses = $pdo;

        // get count
        $this->countInstructor = 0;
        $this->countStudent    = 0;
        $this->countPoints     = 0;

        // count points
        $points = Doctrine::getTable('Post')->findBy("user_id", $user->getId());
        if ($points) {
            $this->countPoints = count($points);
        }

        // endorsment
        $pdo = $conn->execute('SELECT ul.user_id AS userId, SUM(ul.count_like) AS sLike FROM user_like ul WHERE (ul.object_id IN (SELECT p.id FROM post AS p WHERE (p.user_id=:user_id))) GROUP BY ul.user_id', $params)
            ->fetchAll();
        foreach($pdo as $record) {
            $q = Doctrine::getTable('sfGuardUserProfile')->createQuery('up')
                    ->andWhere('up.user_id = ?', $record['userId']);
            $result = $q->fetchArray();
            $IsUserStaff = false;
            foreach($result as $up) {
                if (intval($up['is_staff']) == 1) $IsUserStaff = true;
            }
            if ($IsUserStaff) {
                $this->countInstructor += $record['sLike'];
            } else {
                $this->countStudent += $record['sLike'];
            }
        }

        // course form
        $school = $user->Schools->getFirst();
        $data = $request->getParameter('course_add');
        $department = null;
        if (isset($data['department_id']) && $data['department_id']) {
            $department = Doctrine_Core::getTable('Department')->find($data['department_id']);
        }

        $this->formCourse = new CourseAddForm(null, array(
            'school' => $school,
            'department' => $department,
            'category' => $data["category"],
            'subject_id' => $data["subject_id"]
        ));
        
        
        $this->courseForm = new CourseForm();
        $this->departmentForm = new DepartmentForm();
        
        if($request->isMethod('post')) {
            $DepartmentForm = $request->getParameter('department');
            $this->departmentForm->bind($DepartmentForm);
        }
    }

    /**
     * Index
     * This displays a user's profile. It can display the logged in user's profile OR someone else's profile.
     *
     * This is the profile page for a user.
     *
     * @param sfWebRequest $request
     */
    public function executeFirstProfileView(sfWebRequest $request)
    {
        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');

        $this->my_profile = true;

        $this->profileEditLinkAvailable = false;

        $this->getResponse()->setTitle('My Profile');


        $this->courses = $user->getCourseList();
        $this->profile = $user['sfGuardUserProfile'];
        $this->user = $user;

        $this->redirect("@my_profile");
    }

    public function executeNewMemberList(sfWebRequest $request) {
        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');
        
        $school = $user->getMainSchool();

        if($school && $recCount = $school->getNewMembersCount()){
            $autopager = new AutoPager(array('recs_per_page' => 5));
            $autopager->setBaseLink('@new_member_list');
            $pageNum = $request->getParameter('page', 1);
            $autopager->setPageNum($pageNum);
            $autopager->setRecCount($recCount);

            $offset = $autopager->getOffset();
            $rpp = $autopager->getRecsPerPage();
            $users = $school->getNewMembers(array(
                'offset'        => $offset,
                'recs_per_page' => $rpp
            ));

            if($this->isAjaxRequest = $request->isXmlHttpRequest()) {
                return $this->renderPartial('list_new_members', array(
                    'autopager'     => $autopager,
                    'users'         => $users,
                    'isAjaxRequest' => $isAjaxRequest
                ));

            } else {
                $this->autopager = $autopager;
                $this->users = $users;

            }

        }

        $this->getResponse()->setTitle('New Members');
    }

    public function executeInvite(sfWebRequest $request)
    {
        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');
        
        $form = new InviteForm();

        if ($request->isMethod('post') && $request->hasParameter($form->getName())) {

            $data = $request->getParameter($form->getName());
            $files = $request->getFiles($form->getName());

            $form->bind($data, $files);

            if($form->isValid()){
                $user = $this->getUser()->getGuardUser();
                $to_name = $form->getValue('full_name');
                $to_email = $form->getValue('email_address');
                $message = $form->getValue('message');

                $this->sendInviteMail($to_name, $to_email, $message, $user);

                $this->getUser()->setFlash('notice', 'Email has been sent. Thank you!');

                $this->redirect('@user_invite');

            }
        }

        $this->form = $form;

    }

    protected function sendInviteMail($to_name, $to_email, $message, $user)
    {
        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');
        
        $emailMessage = $this->getMailer()->compose();

        $emailMessage->setSubject(sfConfig::get('app_mail_invite_subject', 'Wikigrads invite'));

        $emailMessage->setFrom(array(
            $user->getEmailAddress() => $user->getProfile()->getFullName(),
        ));


        $emailMessage->setTo(array($to_email => $to_name));

        $emailMessage->setBody($this->getPartial('sfGuardUser/inviteEmail', array(
            'to_name' => $to_name,
            'full_name' => $user->getProfile()->getFullName(),
            'message' => $message
        )), 'text/html');

        $this->getMailer()->send($emailMessage);
    }

    public function executePrivacy(sfWebRequest $request) {
        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');
        
        $this->user = $user;
        $form = new sfGuardUserProfileEditForm($user->getSfGuardUserProfile());

        if ($request->isMethod('put')) {
            $request->setMethod('post');
        }

        $form = $this->processForm($form, $request, array(
            'flash' => 'You have successfully updated your profile.',
            'skip_notification' => true
        ));

        $this->profile = $user['sfGuardUserProfile'];
        $this->courses = $user->getCourseList();
        $this->form    = $form;
        $this->icourses= Doctrine::getTable('InstructorCourse')->createQuery('r')
                ->select('r.*')
                ->andWhere('r.user_id = ?', $user->getId())
                //->andWhere('r.deleted_at is null')
                ->execute();

        // check user cours instructor
        $userCourses = Doctrine::getTable('UserCourse')->findBy('user_id', $user->getId());
        $instCourses = Doctrine::getTable('InstructorCourse')->findBy('user_id', $user->getId());

        foreach ($instCourses as $instructor) {
            $b = false;
            foreach ($userCourses as $course) {
                if ($course['course_id'] == $instructor['course_id']) {
                    $b = true;
                    $this->onAddNotifUserCourse($course['id'], $instructor['course_id']);
                }
            }

            if (!$b) {
                // add to course
                $entity = new UserCourse();
                $entity->setUserId($user->getId());
                $entity->setCourseId($instructor['course_id']);
                $entity->save();

                // add notification
                $this->onAddNotifUserCourse($entity->getId(), $instructor['course_id']);
            }
        }

        $this->getResponse()->setTitle('Privacy and Settings');
    }

    private function onAddNotifUserCourse($objectId, $courseId) {
        $user   = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');

        $result = Doctrine::getTable('Notification')
                ->createQuery('n')
                ->where('n.object_name = ?', "UserCourse")
                ->andWhere('n.object_id = ?', $objectId)
                ->execute();
        if (count($result) <= 0) {
            $notification = new Notification();
            $notification->setObjectName("UserCourse");
            $notification->setObjectId($objectId);
            $notification->setRelatedObjectName("Course");
            $notification->setRelatedObjectId($courseId);
            $notification->setAction("Add");
            $notification->setType("Classmate");
            $notification->save();

            $un = new UserNotification();
            $un->setUserId($user->getId());
            $un->setNotificationId($notification->getId());
            $un->setIsSeen(0);
            $un->save();
        }
    }

    public function executeEditaccess(sfWebRequest $request) {
        $user     = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');
        
        $access   = $request->getParameter('access');
        $course   = $request->getParameter('course');
        $recordId = $request->getParameter('recordId');

        if ($course > 0 && !$recordId) {
            Doctrine_Query::create()
                ->update('InstructorCourse r')
                ->set('r.access', '?', $access)
                ->where('r.user_id = ?', $user->getId())
                ->where('r.course_id = ?', $course)
                ->execute();
        } else {
            if($recordId) {
                if ($recordId > 0 && $user->getIsOfficer()) {
                    Doctrine_Query::create()
                        ->update('InstructorCourse r')
                        ->set('r.access', '?', $access)
                        ->where('r.id = ?', $recordId)
                        ->execute();
                }
            }
        }

        $arr = array();
        $arr['access'] = $access;
        echo json_encode($arr);
    }

    public function executeDelaccess(sfWebRequest $request) {
        $user   = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');
        
        $course = $request->getParameter('dataId');
        $result = Doctrine::getTable('InstructorCourse')->createQuery('r')
                ->andWhere('r.user_id = ?', $user->getId())
                ->andWhere('r.course_id = ?', $course)
                //->andWhere('r.deleted_at is null')
                ->fetchOne();
        if ($result instanceof InstructorCourse) {
            $result->delete();
        }
        
        $result = Doctrine::getTable('UserCourse')->createQuery('r')
                ->andWhere('r.user_id = ?', $user->getId())
                ->andWhere('r.course_id = ?', $course)
                //->andWhere('r.deleted_at is null')
                ->fetchOne();
        if ($result instanceof UserCourse) {
            $result->delete();
        }
        
        echo "ok";
    }
    
    public function executeDeleteAccess(sfWebRequest $request) {
        $user   = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');
        $course = $request->getParameter('dataId');
        $result = Doctrine::getTable('InstructorCourse')->createQuery('ic')
                ->where('ic.course_id = ?', $course)
                ->andWhere('ic.user_id = ?', $user->getId())
                ->fetchArray();
        foreach ($result as $access) {
            if ($access instanceof InstructorCourse) {
                $access->setAccess(NULL);
                $access->save();
            }
        }
        
        return;
    }

    public function executeEditemail(sfWebRequest $request) {
        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');
        
        $email = $request->getParameter('email');
              
        $result = Doctrine::getTable('SfGuardUser')->createQuery('p')
            ->andWhere('p.email_address = ?', $email)
            ->fetchOne();
        
        if (!$result) {
            $arr = array();
            $arr['status'] = 0;
            $arr['msg'] = 'New email '.$email;

            Doctrine_Query::create()
                ->update('SfGuardUserProfile u')
                ->set('u.email', '?', $email)
                ->where('u.user_id = ?', $user->getId())
                ->execute();
            //
            Doctrine_Query::create()
                ->update('SfGuardUser u')
                ->set('u.email_address', '?', $email)
                ->where('u.id = ?', $user->getId())
                ->execute();


            echo json_encode($arr);
        }else{
            $arr = array();
            $arr['status'] = 0;
            $arr['msg'] = '<i style="color: #F07D18;">This email ('.htmlspecialchars($email).') already exists</i>';
            
            echo json_encode($arr);
        }
    }

    public function executeEditemails(sfWebRequest $request) {
        $guardUser = $this->getUser()->getGuardUser();
        if (!$guardUser) $this->redirect('@homepage');

        $enter_code = $request->getParameter('enter_code');
        $email_post = $request->getParameter('email_post');
        $email_reply = $request->getParameter('email_reply');
        $email_private = $request->getParameter('email_private');
        $email_from = $request->getParameter('email_from');
        
        if ("0" === $email_post && 
            "0" === $email_reply &&
            "0" === $email_private &&
            "0" === $email_from) { 
                return;
        }

        $result = $courseTracker = Doctrine::getTable('sfGuardUserProfile')->createQuery('p')
            ->andWhere('p.user_id = ?', $guardUser->getId())
            ->fetchOne();

        $result->setEnterCode($enter_code);
        $result->setEmailPost($email_post);
        $result->setEmailReply($email_reply);
        $result->setEmailPrivate($email_private);
        $result->setEmailFrom($email_from);
        $result->save();

        echo $guardUser->getId();
    }

    public function executeEditpass(sfWebRequest $request) {
        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect('@homepage');
        
        $currentPass = $request->getParameter('currentPass');
        $newPass1 = $request->getParameter('newPass1');
        $newPass2 = $request->getParameter('newPass2');

        $arr = array();
        $arr['status'] = 0;
        $arr['msg'] = '';
        $arr['new_pass'] = $newPass1;

        if (strlen($newPass1) > 0 && $newPass1 == $newPass2) {
            switch($user->getAlgorithm()) {
                case 'md5': {
                    $currentPass = md5($user->getSalt().$currentPass);
                }break;
                case 'sha1': {
                    $currentPass = sha1($user->getSalt().$currentPass);
                }break;
            }

            if ($user->getPassword() == $currentPass) {
                $user->setPassword($arr['new_pass']);
                $user->save();
                $arr['msg'] = 'Success';
            } else {
                $arr['status'] = 1;
                $arr['msg'] = 'Wrong password';
            }
        } else {
            $arr['status'] = 1;
            $arr['msg'] = 'Passwords do not match';
        }
        echo json_encode($arr);
    }

    public function executeRemoveInstructor(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $user = $this->getUser()->getGuardUser();
        $arr['status'] = 0;
        if ($id && $user->getIsOfficer() == 1) {
            $record = Doctrine::getTable('InstructorCourse')->findOneBy("id", $id);
            if ($record) {
                $record->delete();
                $arr['status'] = 1;
            }
        }
        echo json_encode($arr);
        return "None";
    }

    public function executeOfficerJoin(sfWebRequest $request) {
        $courseId = $request->getParameter('courseId');
        $user = $this->getUser()->getGuardUser();

        $arr['status'] = 0;

        if ($courseId && $user->getIsOfficer() == 1) {
            // this code to join course

            // save in user course
            $uc = new UserCourse();
            $uc->setCourseId($courseId);
            $uc->setUserId($user->getId());
            $uc->save();

            $arr['status'] = 1;
        }

        echo json_encode($arr);
        return "None";
    }

    public function executeOfficer(sfWebRequest $request) {

        // check user right
        $user = $this->getUser()->getGuardUser();
        if (!$user) $this->redirect ('@homepage');
        if ($user->getIsOfficer() != 1)  $this->redirect ('@homepage');

        // request params
        $limit = $request->getParameter('limit', 10);
        $page = $request->getParameter('page', 0);

        // table params
        $TableName = "";
        $sortField = "t.id ASC";

        // global params
        $this->entities = array();
        $this->type = $request->getParameter('type');
        $options = array();
        $options['limit'] = $limit;
        $options['page']  = $page;
        $options['count'] = 0;
        $options['maxpg'] = 0;
        $options['min']   = 0;
        $options['max']   = 0;

        // rules
        switch ($this->type) {
            case "course": {
                $TableName = "InstructorCourse";
                $sortField = "t.User.first_name ASC";
            } break;
            case "join": {
                $TableName = "Course";
                $sortField = "t.name ASC";
            } break;
            case "post": {
                $TableName = "Post";
                $sortField = "t.created_at DESC";
            }break;
            default: {
                $TableName = "";
            } break;
        }

        // query
        if (strlen($TableName) > 0) {

            // data
            $result = Doctrine::getTable($TableName)
                    ->createQuery('t');
            if($this->type!="course")
                    $result->orderBy($sortField);
            
            $result->offset($page * $limit)
                    ->limit($limit);

            // delete current course fron table
            if ($this->type == "join") {
                $arr = array();
                $list = Doctrine::getTable('UserCourse')->findBy("user_id", $user->getId());
                if ($list) {
                    foreach ($list as $rec) {
                        $arr[] = $rec->getCourseId();
                    }
                }
                if (count($arr) > 0) {
                    $result->andWhereNotIn('t.id', $arr);
                }
                $options['count'] = count(Doctrine::getTable($TableName)->createQuery('t')->andWhereNotIn('t.id', $arr)->fetchArray());
            } elseif ($this->type == "post") {
                $options['count'] = count(Doctrine::getTable($TableName)->createQuery('t')->andWhere('t.user_id = ?', $user->getId())->fetchArray());
                $result->andWhere('t.user_id = ?', $user->getId());
            } else {
                $options['count'] = count(Doctrine::getTable($TableName)->createQuery('t')->fetchArray());
            }




            // pagin
            $options['maxpg'] = ceil(($options['count'] / $limit));
            $options['min'] = $options['page'] - 3;
            if ($options['min'] < 0) $options['min'] = 0;
            $options['max'] = $options['min'] + 6;
            if ($options['max'] > $options['maxpg']) $options['max'] = $options['maxpg'];
            $this->entities = $result->execute();
        }

        $this->options = $options;
        // title
        $this->getResponse()->setTitle('Officer');
    }
}
