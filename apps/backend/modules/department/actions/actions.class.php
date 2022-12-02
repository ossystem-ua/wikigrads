<?php

require_once dirname(__FILE__).'/../lib/departmentGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/departmentGeneratorHelper.class.php';

/**
 * department actions.
 *
 * @package    Wikigrads
 * @subpackage department
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class departmentActions extends autoDepartmentActions
{
    public function executeFilter(sfWebRequest $request) {

        $this->setPage(1);

        if ($request->hasParameter('_reset')) {
            $this->setFilters($this->configuration->getFilterDefaults());

            $this->redirect('@department_department');
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        
        $ids = array();
        $schools = $this->findSchools($request);
        if ($schools) {
            foreach ($schools as $s) {
                $ids[] = $s->getId();
            }
        }
        
        $xxx = $request->getParameter($this->filters->getName());
        if (!empty($ids)) {
            $xxx['school_id'] = implode(",", $ids);
        } else {
            $xxx['school_id'] = '';
        }

        $this->filters->bind($xxx);
        if ($this->filters->isValid()) {
            $dataQuery = $this->filters->getValues();
            if ($xxx['school_id'] == '' &&
                $xxx['name']['text'] == '' &&
                $xxx['alias']['text'] == '') {
                    $dataQuery['name']['text'] = 'Sorry, no results!';
            }
            
            $this->setFilters($dataQuery);

            //$this->redirect('@department_department');
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();
        $this->DepartmentSchoolId = $request->getParameter('autocomplete_department_filters');
        $this->setTemplate('index');
    }
    
    public function findSchools(sfWebRequest $request) {
        $schools = false;
        $schoolNameFragment = $request->getPostParameter('autocomplete_department_filters');
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
