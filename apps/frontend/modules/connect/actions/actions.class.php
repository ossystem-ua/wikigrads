<?php
    require_once 'OAuth.php';
    require_once 'datastore.php';
/**
 * connect actions.
 *
 * @package    Wikigrads
 * @subpackage connect
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 *
 */
class connectActions extends sfActions {

    public function OAuth($domain, $key) {
        $store = new TrivialOAuthDataStore();

        $lmsOAuth = Doctrine::getTable('lmsDomainKeySecret')->createQuery('dks')
                ->where('dks.domain = ?', $domain)
                ->andWhere('dks.key_s = ?', $key)
                ->fetchOne();

        if ($lmsOAuth instanceof LMSDomainKeySecret) {
            $consumer_key = $lmsOAuth->getKeyS();
            $shared_secret = $lmsOAuth->getSecret();
        } else {
            return false;
        }

        $store->add_consumer($consumer_key,  $shared_secret);
        $server = new OAuthServer($store);

        $method = new OAuthSignatureMethod_HMAC_SHA1();
        $server->add_signature_method($method);
        $request = OAuthRequest::from_request();

        $verify = $server->verify_request($request);
            if ($verify[2]) { return true; }
            else { return false; }
    }

    public function createUser(array $userData, $schoolId, $userRole) {
        $user = new sfGuardUser();
        $user->setEmailAddress(NULL);
        $user->setUsername(NULL);
        $user->setLmsId($userData['id']);
        $user->setIsLms(1);
        $user->setLmsEmail($userData['email']);
        $user->setLmsDomain($userData['domain']);
        $user->setFirstName($userData['firstName']);
        $user->setLastName($userData['lastName']);
        $user->setIsActive(true);

        $userProfile = new sfGuardUserProfile();
        $userProfile->setEmail(NULL);
        $userProfile->setFullname($userData['firstName']." ".$userData['lastName']);
        if ($userRole === 1) {
            $userProfile->setIsStaff(1);
        } elseif ($userRole === 2) {
            $userProfile->setIsTutor(1);
        }
        $userProfile->setUser($user);
        $userProfile->save();

        $userSchool = new UserSchool();
        $userSchool->setUserId($user->getId());
        $userSchool->setSchoolId($schoolId);
        $userSchool->save();

        return $user;
    }

    public function userRole($roles) {
        switch (true) {
            case strpos($roles, "Instructor") !== false: return 1;
            case strpos($roles, "TA") !== false: return 2;
            case strpos($roles, "Learner") !== false: return 3;
            default: return 0;
        }
    }

    public function verificationCourse(array $courseData, $schoolId, $userRole, $user = NULL, array $userData = NULL) {
        if (
                empty($courseData['departmentName']) &&
                empty($courseData['departmentAlias']) &&
                empty($courseData['courseName'])
        ) {
            $this->error = "Not enough data to create course!";
            return;
        }

        if ($userRole != 3 && $user === NULL && $userData) {
            $user = $this->createUser($userData, $schoolId, $userRole);
            $this->getUser()->signIn($user);
        }

        $dep = Doctrine_Core::getTable("Department")
                ->findOneBySchoolAndName(
                (int) $schoolId, strtolower($courseData['departmentName'])
        );

        if ($dep instanceof Department) {

            $department = Doctrine_Core::getTable("Department")->find($dep->getId());
            $new = false;
        } else {
            if ($userRole === 3) {
                $this->error = "A student can not create department";
                return;
            }

            $new = true;

            //create the department
            $department = new Department();
            $department->setSchoolId($schoolId);
            $department->setName($courseData['departmentName']);
            $department->setAlias($courseData['departmentAlias']);
        }

        if (!$new) {
            //search for course
            $c = Doctrine_Core::getTable("Course")->findOneByDepartmentAndName($department, strtolower($courseData['courseName']));
            if ($c instanceof Course) {
                $course = Doctrine_Core::getTable("Course")->find($c->getId());
            }
        }

        if (isset($course) && $course instanceof Course && $course->getId()) {
            if ($user === NULL && $userData && $userRole === 3) {
                $user = $this->createUser($userData, $schoolId, $userRole);
                $this->getUser()->signIn($user);
            }
            $userCourse = Doctrine_Core::getTable("userCourse")->createQuery('uc')
                          ->where("uc.user_id = ?", $user->getId())
                          ->andWhere("uc.course_id = ?", $course->getId())
                          ->fetchOne();
            if (!$userCourse) {
                $usercorse = new UserCourse();
                $usercorse->setUserId($user->getId());
                $usercorse->setCourseId($course->getId());
                $usercorse->setAccess('NULL');
                $usercorse->save();

                if ($userRole === 1 || $userRole === 2) {
                    $assign = new InstructorCourse();
                    $assign->setUserId($user->getId());
                    $assign->setCourse($course);
                    $assign->save();
                }

                $syspost = new Notification();
                $syspost->setObjectId($usercorse->getId());
                $syspost->setObjectName(get_class($usercorse));
                $syspost->setRelatedObjectId($course->getId());
                $syspost->setRelatedObjectName(get_class($course));
                $syspost->setAction("add");
                $syspost->setType("Classmate");
                $syspost->save();
                
                $this->addUserTracker($course->getId(), $user->getId(), $userRole);

                $url = @notification_course_list;
                $params = array();
                $params['type'] = 'course';
                $params['slug'] = $course->getId();
                $redirectUrl = $this->generateUrl($url, $params);

                $this->session_course_id = new sfSessionStorage();
                $this->session_course_id->write('cId', $course->getId());

                $this->redirect($redirectUrl);
            }

            $this->addUserTracker($course->getId(), $user->getId(), $userRole);
            
            $url = @notification_course_list;
            $params = array();
            $params['type'] = 'course';
            $params['slug'] = $course->getId();
            $redirectUrl = $this->generateUrl($url, $params);

            $this->session_course_id = new sfSessionStorage();
            $this->session_course_id->write('cId', $course->getId());

            $this->redirect($redirectUrl);

        } else {
            if ($userRole === 3) {
                $this->error = "A student can not create course";
                return;
            }

            //create course
            $course = new Course();
            $course->setDepartment($department);
            $course->setName($courseData['courseName']);
            $course->setInstructor($user);

            //assign instructor to course
            $assign = new InstructorCourse();
            $assign->setUserId($user->getId());
            $assign->setCourse($course);
            $assign->save();

            $usercorse = new UserCourse();
            $usercorse->setUserId($user->getId());
            $usercorse->setCourseId($course->getId());
            $usercorse->setAccess('NULL');
            $usercorse->save();

            $syspost = new Notification();
            $syspost->setObjectId($course->getId());
            $syspost->setObjectName(get_class($course));
            $syspost->setRelatedObjectId($course->getId());
            $syspost->setRelatedObjectName(get_class($course));
            $syspost->setAction("add");
            $syspost->setType("Classmate");
            $syspost->save();
            
            $this->addUserTracker($course->getId(), $user->getId(), $userRole);
            
            $url = @notification_course_list;
            $params = array();
            $params['type'] = 'course';
            $params['slug'] = $course->getId();
            $redirectUrl = $this->generateUrl($url, $params);

            $this->session_course_id = new sfSessionStorage();
            $this->session_course_id->write('cId', $course->getId());
//                    $this->redirect('@dashboard');
//                $this->redirect('/notification/course/'.$course->getId());
            $this->redirect($redirectUrl);
        }

    }
    
    public function addUserTracker($courseId, $userId, $userRole) {
        if ($userRole === 1 || $userRole === 2) {
            $params = array();
            $params['courseId'] = $courseId;

            $conn = Doctrine_Manager::connection();
            $students = $conn->execute("SELECT uc.user_id
                                          FROM user_course AS uc
                                     LEFT JOIN sf_guard_user_profile AS up ON up.user_id = uc.user_id
                                         WHERE uc.course_id = :courseId
                                           AND up.is_staff = 0
                                           AND up.is_tutor = 0", $params)->fetchAll();
            
            $users = array();
            
            foreach ($students as $key => $student) {
                $users[$key] = $student['user_id'];
            }
            
            $ut = Doctrine_core::getTable("UserTracker")->createQuery("ut")
                    ->where("ut.user_id = ?", $userId)
                    ->andWhere("ut.course_id = ?", $courseId)
                    ->andWhereIn("ut.private", $users)
                    ->fetchArray();
            foreach ($users as $key => $user) {
                foreach ($ut as $value) {
                    if ($user == $value['private']) {
                        unset($users[$key]);
                    }
                }
            }
            
            if (!empty($ut)) {
                foreach ($users as $user) {
                    $userTrackerPrivate = new UserTracker();
                    $userTrackerPrivate->setUserId($userId);
                    $userTrackerPrivate->setCourseId($courseId);
                    $userTrackerPrivate->setNotificationId(0);
                    $userTrackerPrivate->setPrivate((int)$user);
                    $userTrackerPrivate->save();
                }
            }
        } elseif ($userRole === 3) {
            $instructors = Doctrine_core::getTable('InstructorCourse')->createQuery()
                         ->select("user_id")
                         ->where('course_id = ?', $courseId)
                         ->fetchArray();

            foreach ($instructors as $key => $instructor) {
                $instructors[$key] = $instructor['user_id'];
            }

            $userTracker = Doctrine_core::getTable('UserTracker')->createQuery('ut')
                         ->whereIn('ut.user_id', $instructors)
                         ->andWhere('ut.course_id = ?', $courseId)
                         ->andWhere('ut.private = ?', $userId)
                         ->fetchArray();

            foreach ($instructors as $key => $instructor) {
                foreach ($userTracker as $user) {
                    if ($instructor === $user['user_id']) {
                        unset($instructors[$key]);
                    }
                }
            }

            if (!empty($instructors)) {
                foreach ($instructors as $instructor) {
                    $userTrackerPrivate = new UserTracker();
                    $userTrackerPrivate->setUserId($instructor);
                    $userTrackerPrivate->setCourseId($courseId);
                    $userTrackerPrivate->setNotificationId(0);
                    $userTrackerPrivate->setPrivate($userId);
                    $userTrackerPrivate->save();
                }
            }
        }
        return;
    }
    
    public function executeIndex(sfRequest $request) {
        $this->getUser()->signOut();
        
        $url = $request->getReferer();
        $lmsDomain = parse_url($url, PHP_URL_HOST);
        $key = $request->getParameter('oauth_consumer_key', NULL);
        
        if (!$lmsDomain) {
            $this->error = "Permission denied!";
            return;
        }
        
        $lms = Doctrine_core::getTable('LmsDomainKeySecret')->findOneBy('key_s', $key);
        if (!$lms) {
            $this->error = "This LMS is not registered!";
            return;
        }

        $school = Doctrine_core::getTable('School')->findOneBy('id', $lms->getDomain());
        if (!$school) {
            $this->error = "School is not found or has not been created";
            return;
        }
        
        $schoolName = $school->getName();
        $domain = $school->getId();

        $lmsOAuth = $this->OAuth($domain, $key);
        if (!$lmsOAuth) {
            $this->error = "This LMS is not registered!";
            return;
        }

        $id = $request->getParameter("user_id", null);
        $email = $request->getParameter("lis_person_contact_email_primary", null);
        $firstName = $request->getParameter("lis_person_name_given", null);
        $lastName = $request->getParameter("lis_person_name_family", null);

        $userData = array();
            if ($id) {
                $userData['id'] = $id;
            }

            if ($domain) {
                $userData['domain'] = $domain;
            }

            if ($email) {
                $userData['email'] = $email;        
            } else {
                $userData['email'] = '';
            }

            if ($firstName) {
                $userData['firstName'] = $firstName;
                if ($lastName) $userData['lastName'] = $lastName;
            } elseif ((int)$id === 0) {
                $userData['firstName'] = 'User';
                $userData['lastName'] = 'Sakai';
            } else {
                $userData['firstName'] = 'User';
                $userData['lastName'] = 'Sakai';
            }

        $courseName = $request->getParameter("context_title", null);
        $departmentName = $courseName;
        $departmentAlias = $request->getParameter("context_label", null);

        $courseData = array();
            if ($courseName) $courseData['courseName'] = $courseName;
            if ($departmentName) $courseData['departmentName'] = $departmentName;
            if ($departmentAlias) $courseData['departmentAlias'] = $departmentAlias;

        $conditions = array();
            if ($id) $conditions['id'] = $id;
            if ($email) $conditions['email'] = $email; else $conditions['email'] = NULL;
            if ($schoolName) $conditions['domain'] = $domain;

        if (empty($conditions)) {
            $this->error = "Not enough data to define user!";
            return;
        }
        
        $user = Doctrine_Core::getTable("sfGuardUser")->findOneLmsUser($conditions);

        if($user) {
            $sfGuardUser = Doctrine_Core::getTable('sfGuardUser')->find($user->getId());
            $this->getUser()->signIn($sfGuardUser);

            $sfGuardUserProfile = Doctrine_Core::getTable('sfGuardUserProfile')->createQuery('u')
                                  ->where("u.user_id = ?", $user->getId())
                                  ->fetchOne();

            if ($sfGuardUser->getLmsEmail() !== $conditions['email']) {
                $sfGuardUser->setLmsEmail($conditions['email']);
                $sfGuardUser->save();
            }

            if ($sfGuardUserProfile->getIsStaff() === true) {
                $userRole = 1;
            } elseif ($sfGuardUserProfile->getIsTutor() === true) {
                $userRole = 2;
            } else {
                $userRole = 3;
            }
            
            $this->verificationCourse($courseData, $school->getId(), $userRole, $user);
        } else {

            $roles = $request->getParameter("roles", null);
            $userRole = $this->userRole($roles);

            $user = NULL;

            $this->verificationCourse($courseData, $school->getId(), $userRole, $user, $userData);
        }
    }
    
}
