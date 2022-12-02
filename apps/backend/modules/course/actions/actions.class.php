<?php

require_once dirname(__FILE__) . '/../lib/courseGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/courseGeneratorHelper.class.php';

/**
 * course actions.
 *
 * @package    Wikigrads
 * @subpackage course
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class courseActions extends autoCourseActions {
    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        $course = $request->getParameter("course");
        $courseName = $course['name'];
        $dep = $request->getParameter("course");
        $dep = (int)$dep['department_id'];
        $courseNew = false;
        $department = NULL;
        
        if (is_integer($dep) && $dep != 0) {
            $department = Doctrine_Core::getTable("Department")->find($dep);
        }

        if ($department === NULL) {
            $this->getUser()->setFlash('error', 'You must choose a department.', false);
        }
        
        if ($department instanceof Department) {
            //search for course
            $c = Doctrine_Core::getTable("Course")->findOneByDepartmentAndName($department, strtolower($courseName));
            if ($c instanceof Course) {
                $course = Doctrine_Core::getTable("Course")->find($c->getId());
            }
        }

        if (isset($course) && $course instanceof Course && $course->getId()) {
            $courseNew = true;
        }

        if ($form->isValid() && !$courseNew) {
            $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';
            try {
                $course = $form->save();
            } catch (Doctrine_Validator_Exception $e) {

                $errorStack = $form->getObject()->getErrorStack();

                $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ? 's' : null) . " with validation errors: ";
                foreach ($errorStack as $field => $errors) {
                    $message .= "$field (" . implode(", ", $errors) . "), ";
                }
                $message = trim($message, ', ');

                $this->getUser()->setFlash('error', $message);
                return sfView::SUCCESS;
            }

            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $course)));

            if ($request->hasParameter('_save_and_add')) {
                $this->getUser()->setFlash('notice', $notice . ' You can add another one below.');

                $this->redirect('@course_course_new');
            } else {
                $this->getUser()->setFlash('notice', $notice);

                $this->redirect(array('sf_route' => 'course_course_edit', 'sf_subject' => $course));
            }
        } else {
            if ($department === NULL) {
                $this->getUser()->setFlash('error', 'You must choose a department.', false);
            }else if ($courseNew) {
                $this->getUser()->setFlash('error', 'Such a course already exists.', false);
            } else {
                $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
            }
        }
    }

    public function executeFilter(sfWebRequest $request) {

        $this->setPage(1);

        if ($request->hasParameter('_reset')) {
            $this->setFilters($this->configuration->getFilterDefaults());

            $this->redirect('@course_course');
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());

        $idd = array();
        $departments = $this->findDepartments($request);
        if ($departments) {
            foreach ($departments as $d) {
                $idd[] = $d->getId();
            }
        }
        
        $ids = array();
        $schools = $this->findSchools($request);
        if ($schools) {
            foreach ($schools as $s) {
                $ids[] = $s->getId();
            }
        }
        
        $xxx = $request->getParameter($this->filters->getName());

        if (!empty($idd)) {
            $xxx['department_id'] = implode(",", $idd);
        } else {
            $xxx['department_id'] = '';
        }
        
        if (!empty($ids)) {
            $xxx['school_id'] = implode(",", $ids);
        } else {
            $xxx['school_id'] = '';
        }
        
        $this->filters->bind($xxx);
        if ($this->filters->isValid()) {
            $dataQuery = $this->filters->getValues();
            if ($xxx['school_id'] == '' &&
                $xxx['department_id'] == '' &&
                $xxx['name']['text'] == '' &&
                $xxx['code']['text'] == '') {
//                    $yyy = $request->getPostParameter('autocomplete_course_filters');
//                    $dataQuery['name']['text'] = $yyy['department_id'];
                    $dataQuery['name']['text'] = 'Sorry, no results!';
            }

            $this->setFilters($dataQuery);
//            $this->setFilters($this->filters->getValues());
//            $this->redirect('@course_course');
        }
        $this->pager = $this->getPager();
        $this->sort = $this->getSort();
        $this->courseDepartmentId = $request->getParameter('autocomplete_course_filters');
 
        $this->setTemplate('index');
    }

    public function findDepartments(sfWebRequest $request) {
        $departments = false;
        $departmentNameFragment = $request->getPostParameter('autocomplete_course_filters');
        $departmentNameFragment = $departmentNameFragment['department_id'];
        if ($departmentNameFragment) {
            
            $departmentNameFragment = '%' . $departmentNameFragment . '%';

            $departments = Doctrine::getTable('Department')->createQuery('d')
                    ->where('d.name like ?', $departmentNameFragment)
                    ->execute();
        }
        return $departments;
    }
    
    public function findSchools(sfWebRequest $request) {
        $schools = false;
        $schoolNameFragment = $request->getPostParameter('autocomplete_course_filters');
        $schoolNameFragment = $schoolNameFragment['school_id'];
        if ($schoolNameFragment) {
            
            $schoolNameFragment = '%' . $schoolNameFragment . '%';

            $schools = Doctrine::getTable('School')->createQuery('s')
                    ->where('s.name like ?', $schoolNameFragment)
                    ->execute();
        }
        return $schools;
    }

    public function executeImport(sfWebRequest $request) {
        $form = new CourseImportForm();

        if ($request->isMethod('post') && $request->hasParameter($form->getName())) {
            $data = $request->getParameter($form->getName());
            $files = $request->getFiles($form->getName());

            $form->bind($data, $files);

            if ($form->isValid()) {
                $file = $form->getValue('file');
                $school_id = $form->getValue('school_id');
                $academic_term_id = $form->getValue('academic_term_id');

                $course_import = new CourseImport($file->getTempName(), $school_id, $academic_term_id);
                $course_import->import();

                $import_errors = $course_import->getErrors();


                $imported_count = array(
                    'department' => $course_import->countImportDepartment(),
                    'course' => $course_import->countImportCourse(),
                    'rows' => $course_import->countImportRow(),
                    'duration' => $course_import->countDuration(),
                );

                $this->getUser()->setFlash('notice', $course_import->countImportRow() . ' courses successfully uploaded.');

                //Utils::pfa();
            }
        }


        $this->errors = isset($import_errors) ? $import_errors : false;

        //var_dump($this->errors); exit;
        $this->imported_count = isset($imported_count) ? $imported_count : false;

        $this->form = $form;

        // update subject list
        $this->updateSubjectList();
    }

    private function updateSubjectList() {

        // get all subject
        $subjects = Doctrine::getTable('Subject')->createQuery('s')
                ->execute();

        $subjects_arr = Array();
        foreach ($subjects as $record) {
            $subjects_arr[] = $record->getName();
        }

        // get all groups
        // which not in db
        $groups = Doctrine::getTable('Course')->createQuery('g')
                ->andWhere('g.category IS NOT NULL')
                ->andWhere('g.deleted_at IS NULL')
                ->andWhere('not g.name = g.category')
                ->andWhereNotIn('g.category', $subjects_arr)
                ->groupBy('g.category')
                ->orderBy('g.category')
                ->execute();

        // add sunbjects and update records
        foreach ($groups as $record) {

            // add
            $subject = new Subject();
            $subject->setName($record->getCategory());
            $subject->save();

            // update subject in course
            Doctrine_Query::create()
                    ->update('Course c')
                    ->set('c.subject_id', '?', $subject->getId())
                    ->where('c.category = ?', $subject->getName())
                    ->execute();
        }
    }

    public function executeCoursefilter(sfWebRequest $request) {
        $userId = $request->getParameter('userId', 0);
        $type = $request->getParameter('queryType', 0);
        $courseId = $request->getParameter('courseId', 0);

        $this->entities = array();
        $this->userId = $userId;

        if ($userId > 0 && $type > 0) {
            $conn = Doctrine_Manager::connection();
            $sql = 'SELECT
                    *
                FROM
                    course as c
                WHERE
                    (c.department_id in (
                        SELECT
                            d.id as id
                        FROM
                            department as d
                        WHERE
                            (d.school_id in (
                                SELECT
                                    us.school_id
                                FROM
                                    user_school as us
                                WHERE
                                    (us.user_id = ' . $userId . ')                                
                            ) AND d.deleted_at is null)                        
                       ) AND (
                       c.deleted_at is null
                    ))
                  GROUP BY
                    c.id
                  ORDER BY
                    c.name';

            if ($type == 2) {
                $sql = 'SELECT 
                    *
                  FROM
                    sf_guard_user AS u
                  WHERE
                    u.id in (
                        SELECT
                            ic.user_id
                        FROM 
                            instructor_course AS ic';
                if ($courseId > 0) {
                    $sql .= ' WHERE ic.course_id = ' . $courseId . ' ';
                }
                $sql .= '
                        GROUP BY
                            ic.user_id
                    )';
            }
            $pdo = $conn->execute($sql);
            $this->type = $type;
            $this->result = $pdo->fetchAll();

            // auto set is_staff user
            if ($type == 1) {
                $userProfile = Doctrine::getTable('sfGuardUserProfile')->findOneBy('user_id', $userId);
                if ($userProfile) {
                    $courses = Doctrine::getTable('InstructorCourse')->findBy('user_id', $userId);
                    if (count($courses) > 0) {
                        $userProfile->setIsStaff(1);
                        $userProfile->setIsTutor(1);
                    } else {
                        //$userProfile->setIsStaff(0);
                        //$userProfile->setIsTutor(0);
                    }
                    $userProfile->save();
                }
            }
        }
    }

}
