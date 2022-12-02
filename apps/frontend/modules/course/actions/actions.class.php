<?php

/**
 * course actions.
 *
 * @package    sf_sandbox_old
 * @subpackage course
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class courseActions extends myActions {

    public function executeIndex(sfWebRequest $request) {
        $this->courses = Doctrine_Core::getTable('Course')
                ->createQuery('a')
                ->execute();
    }

    public function executeCheck(sfWebRequest $request) {
        //$user = $this->getUser()->getGuardUser();
        $arr["course_id"] = intval($request->getParameter('object'));
        //$arr["user_id"]   = $user->getId();
        $arr["success"] = 0;
        $arr["result"] = Doctrine_Core::getTable('Course')->createQuery('c')
                ->andWhere('c.id = ?', $arr["course_id"])
                ->fetchOne();

        if ($arr["result"]["access"] != null) {
            $arr["success"] = 1;
        }

        echo json_encode($arr);
    }

    public function executeAddOne(sfWebRequest $request) {
        $departamentId = $request->getParameter('departamentId');
        $courseId = $request->getParameter('courseId');
        $categoryId = $request->getParameter('categoryId');
        $access = trim($request->getParameter('access'));

        $user = $this->getUser()->getGuardUser();
        if (strlen($access) <= 0 || strtolower($access) == "null")
            $access = null;

        $b = 1;
        $retListAccess = array();

        if ($this->onSetCourse($user->getId(), $courseId, $retListAccess, $access))
            $b = 0;
        if ($this->onSetCourse($user->getId(), $categoryId, $retListAccess, $access))
            $b = 0;
        
        if (count($retListAccess) > 0)
            $b = 2;
        
        $retListAccess["status"] = $b;
        echo json_encode($retListAccess);
    }

    public function executeAddInstructorOne(sfWebRequest $request) {
        $departmentName = $request->getParameter('departmentName');
        $departmentAlias = $request->getParameter('departmentAlias');
        $courseCode = $request->getParameter('courseCode');
        $courseName = $request->getParameter('courseName');
        $schoolId = $request->getParameter('schoolId');
        $access = trim($request->getParameter('access'));

        $user = $this->getUser()->getGuardUser();
        $retListAccess = array();
        $retListAccess["status"] = 0;
        $this->onSetInstructorCourse($user, $departmentName, $departmentAlias, $courseCode, $courseName, $schoolId);
        echo json_encode($retListAccess);
    }

    private function onSetInstructorCourse($user, $departmentName, $departmentAlias, $courseCode, $courseName, $schoolId) {
        if (!isset($schoolId)) { return; }
        
        if (
                !empty($departmentName) &&
                !empty($courseCode) &&
                !empty($departmentAlias) &&
                !empty($courseName)
        ) {
            //create new course and make user an instructor
            //looking for department
            $dep = Doctrine_Core::getTable("Department")
                    ->findOneBySchoolAndName(
                    (int) $schoolId, strtolower($departmentName)
            );

            if ($dep instanceof Department) {

                $department = Doctrine_Core::getTable("Department")->find($dep->getId());
                $new = false;
            } else {
                $new = true;
                //create the department
                $department = new Department();
                $department->setSchoolId($schoolId);
                $department->setName($departmentName);
                $department->setAlias($departmentAlias);
            }

            if (!$new) {
                //search for course
                $c = Doctrine_Core::getTable("Course")->findOneByDepartmentAndName($department, strtolower($courseName));
                if ($c instanceof Course) {
                    $course = Doctrine_Core::getTable("Course")->find($c->getId());
                }
            }

            if (isset($course) && $course instanceof Course && $course->getId()) {
                
            } else {
                //create course
                $course = new Course();
                $course->setDepartment($department);
                $course->setName($courseName);
                $course->setCode($courseCode);
                $course->setInstructor($user);
            }

            //assign instructor to course
            $assign = new InstructorCourse();
            $assign->setUser($user);
            $assign->setCourse($course);

            $assign->save();

            $usercorse = new UserCourse();
            $usercorse->setUser($user);
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

    private function onSetCourse($userId, $courseId, &$retListAccess, $access = null) {

        if (!$userId || !$courseId)
            return false;

        $userId = intval($userId);
        $courseId = intval($courseId);

        if ($userId <= 0 || $courseId <= 0)
            return false;

        // check if need enter a code to the course
        $result = Doctrine::getTable('InstructorCourse')
                ->createQuery('ic')
                ->where('ic.course_id = ?', $courseId)
                ->execute();
        if (count($result) > 0) {
            $bAccess = false;
            $bInstructor = false;
            foreach ($result as $record) {

                if ($record->getAccess() && strlen($record->getAccess()) > 0) {
                    if ($record->getAccess() == $access) {
                        $bAccess = true;
                    }
                }

                $user_one = Doctrine::getTable('sfGuardUserProfile')->findOneBy('user_id', $record->getUserId());
                if ($user_one && $user_one->getEnterCode()) {
                    $bInstructor = true;
                }
            }

            if (!$bAccess && !$bInstructor) {
                $bAccess = true;
            }

            if (!$bAccess) {
                $retListAccess[] = false;
                return false;
            }
        }

        $q = Doctrine::getTable('UserCourse')->createQuery('uc')
                ->andWhere('uc.user_id = ?', $userId)
                ->andWhere('uc.course_id = ?', $courseId);
        $result = $q->fetchArray();
        if (count($result) > 0)
            return false;

        $result = Doctrine::getTable('InstructorCourse')
                ->createQuery('ic')
                ->where('ic.course_id = ?', $courseId);
        if (count($result) > 0) {
            $userStaff = Doctrine::getTable('sfGuardUserProfile')->createQuery()
                         ->andWhere('user_id = ?', $userId)->fetchOne()->getIsStaff();

            // add course
            $course = new \UserCourse();
            $course->setUserId($userId);
            $course->setCourseId($courseId);
            $course->setAccess($access);
            $course->save();

            $result = Doctrine::getTable('Notification')
                    ->createQuery('n')
                    ->where('n.object_name = ?', "UserCourse")
                    ->andWhere('n.object_id = ?', $course->getId())
                    ->execute();
            if (count($result) <= 0) {
                // add user info
                $info = new Notification();
                $info->setObjectId($course->getId());
                $info->setObjectName("UserCourse");
                $info->setRelatedObjectId($courseId);
                $info->setRelatedObjectName("Course");
                $info->setAction("Add");
                $info->setType("Classmate");
                $info->save();

                $un = new UserNotification();
                $un->setNotificationId($info->getId());
                $un->setUserId($userId);
                $un->save();
                
                if (!$userStaff) {
                    $userTracker = Doctrine_core::getTable('UserTracker')->createQuery('ut')
                                 ->where('ut.user_id = ?', $userId)
                                 ->andWhere('ut.course_id = ?', $courseId)
                                 ->fetchOne();
                    
                    if (!$userTracker) {
                        $userTrackerPrivate = new UserTracker();
                        $userTrackerPrivate->setUserId($userId);
                        $userTrackerPrivate->setCourseId($courseId);
                        $userTrackerPrivate->setNotificationId(0);
                        $userTrackerPrivate->setPrivate($userId);
                        $userTrackerPrivate->save();
                    }
                    
                    $this->userTrackerAdd($userId, $courseId);
                }
            }
        } else {
            $this->getUser()->setFlash('error', 'No Instructor. Not added.');
        }
        return true;
    }
    
    public function userTrackerAdd($userId, $courseId) {
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
    
    /**
     * Add
     *
     * Add method to add courses to course list.
     *
     * @param sfWebRequest $request
     * @return unknown
     */
    public function executeAdd(sfWebRequest $request) {
        //$this->forward404Unless($request->isXmlHttpRequest());
        $this->setContentTitleSource('edit_courses');

        $user = $this->getUser()->getGuardUser();

        $school = $user->Schools->getFirst();

        $data = $request->getParameter('course_add');
        $data['department_id'] = $request->getParameter('department_id');

        $department = null;

        if (isset($data['department_id']) && $data['department_id']) {
            $department = Doctrine_Core::getTable('Department')->find($data['department_id']);
        }

        if (!isset($data["category"]))
            $data["category"] = 0;
        if (!isset($data["subject_id"]))
            $data["subject_id"] = 0;

        $form = new CourseAddForm(null, array(
            'school' => $school,
            'department' => $department,
            'category' => $data["category"],
            'subject_id' => $data["subject_id"]
        ));

        $options['flash'] = "The Course was successfully added. You can continue adding more courses, or click 'Finished' to go back to your profile.";
        //$options['redirect'] = "@course_add_another";

        $IdCourse = 0;
        $stepNum = (is_null($department)) ? 1 : 2;
        $form = $this->processForm($form, $request, $options, $IdCourse);

        // if ajax and department was passed in
        if ($request->isXmlHttpRequest() && $department) {
            return $this->renderPartial('course/formAdd', array(
                        'stepNum' => $stepNum,
                        'form' => $form,
                        'access' => 1
            ));
        }

        $this->isAddAnother = $request->getParameter('add_another'); # will be set if they just added a course and were redirected back here using @edit_courses_continue
        $this->stepNum = $stepNum;
        $this->form = $form;
    }

    /**
     * Ajax Delete
     *
     * Ajax method to delete course for user.
     *
     * @param sfWebRequest $request
     * @return unknown
     */
    public function executeAjaxDelete(sfWebRequest $request) {
        $this->forward404Unless($request->isXmlHttpRequest());
        $this->forward404Unless($id = $this->getRequestParameter('id'));
        $this->forward404Unless($course = Doctrine_Core::getTable('Course')->find($id));
        
        $user = $this->getUser()->getGuardUser();
         
        $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

        try {
            $conn->beginTransaction();

            /*
             *
             * @TODO LOG THIS ACTIVITY
              CourseFeedTable::insertActivity(CourseFeed::LEAVE_COURSE,
              $id,
              $user->getId(),
              null,
              $conn
              );
             */
            //$courses = $request->getParameter('dataId');
            
            $result = Doctrine::getTable('InstructorCourse')->createQuery('r')
                    ->andWhere('r.user_id = ?', $user->getId())
                    ->andWhere('r.course_id = ?', $id)
                    ->fetchOne();
            if ($result) { $result->delete(); }
            
            $result = Doctrine::getTable('UserCourse')->createQuery('r')
                ->andWhere('r.user_id = ?', $user->getId())
                ->andWhere('r.course_id = ?', $id)
                ->fetchOne();
            if ($result) { $result->delete(); }
            
            $user->unlink('Courses', $course->id);
            $user->save();

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            $this->getResponse()->setStatusCode(500);
            return;
        }

        return sfView::NONE;
    }

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
