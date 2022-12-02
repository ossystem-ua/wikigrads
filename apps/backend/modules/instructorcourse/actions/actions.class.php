<?php

require_once dirname(__FILE__).'/../lib/instructorcourseGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/instructorcourseGeneratorHelper.class.php';

/**
 * instructorcourse actions.
 *
 * @package    Wikigrads
 * @subpackage instructorcourse
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class instructorcourseActions extends autoInstructorcourseActions
{
     public function executeNew(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->instructorcourse = $this->form->getObject();
    }

    public function executeCreate(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->instructorcourse = $this->form->getObject();

        $this->processForm($request, $this->form);

        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->instructorcourse = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->instructorcourse);
    }

    public function executeFilter(sfWebRequest $request) {

        $this->setPage(1);

        if ($request->hasParameter('_reset')) {
            $this->setFilters($this->configuration->getFilterDefaults());

            $this->redirect('@instructorcourse');
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());

        $idu = array();
        $users = $this->findInstructors($request);
        if ($users) {
            foreach ($users as $u) {
                $idu[] = $u->getUserId();
            }
        }
        
        $idc = array();
        $courses = $this->findCourses($request);
        if ($courses) {
            foreach ($courses as $c) {
                $idc[] = $c->getId();
            }
        }
        
        $xxx = $request->getParameter($this->filters->getName());
        if (!empty($idu)) {
            $xxx['user_id'] = implode(",", $idu);
        } else {
            $xxx['user_id'] = '';
        }
        
        if (!empty($idc)) {
            $xxx['course_id'] = implode(",", $idc);
        } else {
            $xxx['course_id'] = '';
        }
        
        $this->filters->bind($xxx);
        if ($this->filters->isValid()) {
            $dataQuery = $this->filters->getValues();
            if ($xxx['user_id'] == '' &&
                $xxx['course_id'] == '') {
                    $dataQuery['access']['text'] = 'Sorry, no results!';
            }
            //$this->setFilters($this->filters->getValues());
            $this->setFilters($dataQuery);

            //$this->redirect('@instructorcourse');
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();
        $this->instructorCourse = $request->getParameter('autocomplete_instructor_course_filters');

        $this->setTemplate('index');
    }

    public function findInstructors(sfWebRequest $request) {
        $users = false;
        $userNameFragment = $request->getPostParameter('autocomplete_instructor_course_filters');
        $userNameFragment = $userNameFragment['user_id'];
        if ($userNameFragment) {
            
            $userNameFragment = '%' . $userNameFragment . '%';
            
            $users = Doctrine::getTable('sfGuardUserProfile')->createQuery('u')
                    ->where('u.fullname like ?', $userNameFragment)
                    ->execute();
            
            $idu = array();
            
            if ($users) {
                foreach ($users as $u) {
                    $user = Doctrine::getTable('InstructorCourse')->findOneBy('user_id', $u->getUserId());
                    if ($user) {
                        $idu[] = $user->getUserId();
                    }
                }
            }
            
            $t = '';
            if (!empty($idu)) {
                $t = implode(",", $idu);
            }

            if(!empty($t)) {
                $users = Doctrine::getTable('sfGuardUserProfile')->createQuery('u')
                        ->where("u.user_id IN ($t)")
                        ->execute();
            }
            
          }
        return $users;
    }
    
    public function findCourses(sfWebRequest $request) {
        $courses = false;
        $courseNameFragment = $request->getPostParameter('autocomplete_instructor_course_filters');
        $courseNameFragment =  $courseNameFragment['course_id'];
        if ($courseNameFragment) {
            
            $courseNameFragment = '%' . $courseNameFragment . '%';

            $courses = Doctrine_core::getTable('Course')->createQuery('c')
                    ->where('c.name like ?', $courseNameFragment)
                    ->execute();
            
            $idc = array();
            
            if ($courses) {
                foreach ($courses as $c) {
                    $course = Doctrine::getTable('InstructorCourse')->findOneBy('course_id', $c->getId());
                    if ($course) {
                        $idc[] = $course->getCourseId();
                    }
                }
            }
            
            $t = '';
            if (!empty($idc)) {
                $t = implode(",", $idc);
            }

            if(!empty($t)) {
                $courses = Doctrine::getTable('Course')->createQuery('c')
                        ->where("c.id IN ($t)")
                        ->execute();
            }
            
        }
        return $courses;
    }
}
