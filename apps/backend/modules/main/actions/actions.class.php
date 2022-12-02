<?php

/**
 * main actions.
 *
 * @package    sf_sandbox_old
 * @subpackage main
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class mainActions extends sfActions
{
    /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    public function executeIndex(sfWebRequest $request) {

    }

    public function executeAutocomplite(sfWebRequest $request) {
        $arr = array();
        $arr['query'] = strtolower($request->getParameter('q', ''));
        $arr['time']  = $request->getParameter('timestamp');
        $arr['type']  = $request->getParameter('type');

        $answer = array();
        if ($arr['type'] && strlen($arr['query']) >= 3) {
            
            if ($arr['type'] == 'instructorCourse' || $arr['type'] == 'userSchool') {
                $arr['query'] = "%".$arr['query']."%";
                $users = Doctrine::getTable('sfGuardUserProfile')->createQuery('u')
                        ->where('u.fullname like ?', $arr['query'])
                        ->execute();
            
                $idu = array();

                if ($users) {
                    foreach ($users as $u) {
                        $user = Doctrine::getTable($arr['type'])->findOneBy('user_id', $u->getUserId());
                        if ($user) {
                            $idu[] = $user->getUserId();
                        }
                    }
                }
                
                if (!empty($idu)) {
                    $temp = implode(',', $idu);
                } else {
                    $temp = '';
                }
                $result = Doctrine::getTable('sfGuardUserProfile')->createQuery('sf')
                        ->where("sf.user_id IN ($temp)")
                        ->execute();
            } else {
                
                $result = Doctrine::getTable($arr['type'])
                        ->createQuery('t');

                switch($arr['type']) {
                    case "sfGuardUser": {
                        $result->where("LOWER(t.first_name) LIKE '%".$arr['query']."%'");
                        $result->orWhere("LOWER(t.last_name) LIKE '%".$arr['query']."%'");
                        $result->orderBy("t.last_name", 'ASC');
                        $result->orderBy("t.first_name", 'ASC');
                    }break;
                    default: {
                        $result->where("LOWER(t.name) LIKE '%".$arr['query']."%'");
                        $result->orderBy('t.name', 'ASC');
                    }break;
                }

                $result = $result->execute();
            }

            $i = 0;
            foreach($result as $record) {
                if ($i < 25) {
                    $name = '';

                    switch($arr['type']) {
                        case "instructorCourse": {
                            $name = $record->getFullname();
                        }break;
                        case "sfGuardUser": {
                            $name = $record->getFirstName()." ".$record->getLastName();
                        }break;
                        default: {
                            $name = $record->getName();
                        }break;
                    }

                    $answer[$record->getId()] = $name;
                }  else {
                    break;
                }
                $i++;
            }
        }
        echo json_encode($answer);
        return "None";
    }

    public function executeAutotextcomplite(sfWebRequest $request) {
        $table = $request->getParameter('table', null);
        $value = $request->getParameter('value', null);
        $field = $request->getParameter('field', null);

        $params = array();
        $params[':value'] = "%".$value."%";
        $t = Doctrine::getTable($table);
        if(in_array($field, $t->getColumnNames())) {
            $result = $t
                    ->createQuery('t')
                    ->where("LOWER(t.$field) LIKE :value",$params)
                    ->orderBy("t.$field", 'ASC');
                    $result = $result->execute();
        } else {
            $result = array();
        }
        
        $source = array();
        $source['table'] = $table;
        $source['field'] = $field;
        $source['value'] = $value;
        $source['total'] = count($result);

        $records = array();
        $success = 1;
        if ($source['total'] <= 0) {
            $success = 0;
        } else {
            foreach($result as $record) {
                $records[] = $record[$field];
            }
        }
        return $this->renderPartial('main/result_field', array('records' => $records, 'source' => $source, 'success' => $success));
    }


    public function executeCheckobject(sfWebRequest $request) {
        $arr['type']  = $request->getParameter('type');
        $arr['value'] = $request->getParameter('value', 0);
        $arr['name']  = '';
        
        $result = Doctrine::getTable($arr['type'])->findOneBy("id", $arr['value']);
        if ($result) {
            if ($arr['type'] == 'sfGuardUser') {
                $arr['name'] = $result->getFirstName()." ".$result->getLastName();
            } else {
                $arr['name'] = $result->getName();
            }
        }
        echo json_encode($arr);
        return "None";
    }

}