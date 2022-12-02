<?php

require_once dirname(__FILE__).'/../lib/user_schoolGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/user_schoolGeneratorHelper.class.php';

/**
 * user_school actions.
 *
 * @package    Wikigrads
 * @subpackage user_school
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class user_schoolActions extends autoUser_schoolActions
{
    public function executeFilter(sfWebRequest $request) {

        $this->setPage(1);

        if ($request->hasParameter('_reset')) {
            $this->setFilters($this->configuration->getFilterDefaults());

            $this->redirect('@user_school');
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());

        $idu = array();
        $users = $this->findUsers($request);
        if ($users) {
            foreach ($users as $u) {
                $idu[] = $u->getUserId();
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
        if (!empty($idu)) {
            $xxx['user_id'] = implode(",", $idu);
        } else {
            $xxx['user_id'] = '';
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
                $xxx['user_id'] == '' &&
                $xxx['major']['text'] == '' &&
                $xxx['class_year']['text'] == '') {
                    $dataQuery['major']['text'] = 'Sorry, no results!';
            }
            $this->setFilters($dataQuery);

        }
        
        $this->pager = $this->getPager();
        $this->sort = $this->getSort();
        $this->userSchoolId = $request->getParameter('autocomplete_user_school_filters');
        
        $this->setTemplate('index');
    }

    public function findUsers(sfWebRequest $request) {
        $users = false;
        $userNameFragment = $request->getPostParameter('autocomplete_user_school_filters');
        $userNameFragment = $userNameFragment['user_id'];
        if ($userNameFragment) {
            
            $userNameFragment = '%' . $userNameFragment . '%';

            $users = Doctrine::getTable('sfGuardUserProfile')->createQuery('d')
                    ->where('d.fullname like ?', $userNameFragment)
                    ->execute();
        }
        return $users;
    }
    
    public function findSchools(sfWebRequest $request) {
        $schools = false;
        $schoolNameFragment = $request->getPostParameter('autocomplete_user_school_filters');
        $schoolNameFragment = $schoolNameFragment['school_id'];
        if ($schoolNameFragment) {
            
            $schoolNameFragment = '%' . $schoolNameFragment . '%';

            $schools = Doctrine::getTable('School')->createQuery('s')
                    ->where('s.name like ?', $schoolNameFragment)
                    ->execute();
        }
        return $schools;
    }
}
