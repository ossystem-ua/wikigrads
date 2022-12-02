<?php
/**
* A class that generates an array of notifications
*/
class NotificationList {
    const NL_NAMESPACE = 'NotificationList';

    protected $options = array();
    protected $user = null; // User object
    protected $list = null;
    protected $everyone = null;

    // query parts
    protected $sqlFromWhere = null;
//    protected $recCount = null; // number of total notifications

    // used to internally calculate/set Friend Status and Permissions
    protected $courses = null;
    protected $friends = null;
    protected $friendsPending = null;

    public function __construct($options = array()) {
        $this->options = $options;
        $this->type = Utils::getOptionValue($options, 'type');
        $this->user = Utils::getOptionValue($options, 'user');
        $this->pinned = Utils::getOptionValue($options, 'pinned');
        $this->pinnedList = array();
        $this->studentId = Utils::getOptionValue($options, 'studentId');
        $this->everyone = Utils::getOptionValue($options, 'arr_everyone');
        $this->gCourseId = Utils::getOptionValue($options, 'gCourseId');
//$test = "SET SESSION query_cache_type = OFF;";
//$conn = Doctrine_Manager::connection();
//$pdo = $conn->execute($test);
        $this->setSqlFromWhere();
//        $this->setRecCount();
    }

    protected function setSqlFromWhere() {
        $type                   = Utils::getOptionValue($this->options, 'type');
        $related_object         = Utils::getOptionValue($this->options, 'related_object');
        $notification_id        = Utils::getOptionValue($this->options, 'notification_id'); // if only one notification's data is desired (e.g. if refreshing comments for one notification)
        $object_name_exclude    = Utils::getOptionValue($this->options, 'object_name_exclude');

        ////////////////////////////////////////////////////////////////
        // BUILD WHERE
        $where = array('n.deleted_at IS NULL');
        if($this->user) {
            $where[] = ' AND un.user_id = '.$this->user->getId();
        }

        if(is_array($type)) {
            $in = "'".implode("', '", $type)."'";
            $where[] = 'AND n.type IN('.$in.')';
        } elseif($type) {
            $where[] = "AND n.type = '$type'";
        }

        if($related_object && $this->everyone[1] == 0) {
            $where[] = "AND n.related_object_id = ".$related_object->getId();
            $where[] = "AND n.related_object_name = '".$related_object->getTable()->getTableName()."'";
        }

        if($notification_id) {
            $where[] = "AND n.id = $notification_id";
        }

        if($object_name_exclude) {
            if(is_array($object_name_exclude)) {
                $in = "'".implode("', '", $object_name_exclude)."'";
                $where[] = "AND n.object_name NOT IN($in)";
            } else {
                $where[] = "AND n.object_name <> '$object_name_exclude'";
            }
        }

        if($this->pinned) {
            $where[] = "AND n.object_name = 'Post'";
//            $where[] = "p.is_pinned = 1";
        }

        /////////////////////////////////////////////////////////////
        // COMPILE FROM/WHERE PART OF QUERY
        $this->sqlFromWhere = "FROM notification AS n ";
        $this->sqlFromWhere .= "LEFT JOIN user_notification AS un ON un.notification_id = n.id ";

        if($this->pinned) {
//            $this->sqlFromWhere .= "LEFT JOIN post AS p ON n.object_id = p.id";
        }
        $this->sqlFromWhere .= "WHERE ".implode(' ', $where);

    }

//    protected function setRecCount() {
//        $sqlCount = "SELECT COUNT(n.id) AS c ".$this->sqlFromWhere;
//        $this->recCount = DataUtils::rawSelectOne($sqlCount, array('scalar_field'=>'c'));
//    }


/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                    //
// SET LIST                                                                          //
//                                                                                  //
/////////////////////////////////////////////////////////////////////////////////////
    function setList($offset = false, $recsPerPage = false, $filter = NULL, $type = false, $studentId = false) {
        /////////////////////////////////////////////////////////////
        // ORDER BY
        
        $order_by = 'ORDER BY ' . Utils::getOptionValue($this->options, 'order_by', 'n.created_at DESC');
        ////////////////////////////////////////////////////////////
        // Post type
        $instructors = Doctrine_Core::getTable('InstructorCourse')->createQuery('ic')
                    ->where('ic.course_id = ?', $this->gCourseId)
                    ->fetchArray();
        
        if (!empty($instructors)) {
            foreach ($instructors as $ins) {
                if (!isset($sId)) { $sId = ''; }
                else { $sId = $sId.', '; }

                $sId = $sId.$ins['user_id'];
            }
        } else {
            $instructors = Doctrine_Core::getTable('course')->createQuery('c')
                           ->select('c.instructor')
                           ->where($this->gCourseId)
                           ->fetchOne();
            
            $user = Doctrine_core::getTable('sfGuardUserProfile')->createQuery('sf')
                    ->select('sf.is_staff, sf.is_tutor')
                    ->where('sf.user_id = ?', $instructors->getInstructor())
                    ->fetchOne();
            
            if ($instructors instanceof Course && 
                $user instanceof sfGuardUserProfile && 
                ($user->getIsStaff() || $user->getIsTutor())) {
                $sId = $instructors->getInstructor();
                
                $instructorCourse = new InstructorCourse();
                
                $instructorCourse->setUserId($sId);
                $instructorCourse->setCourseId($this->gCourseId);
                $instructorCourse->save();
                
            } else {
                return false;
            }
        }

        $instructorsId = $sId;
        
        if ($type && $studentId) {
            $sId = $sId.', '.$studentId;
            $postType = 'AND p.private = '.$studentId.' AND p.user_id IN ('.$sId.')';
        }
        else {
            $postType = 'AND p.private = 0';
        }
        ////////////////////////////////////////////////////////////
        // LIMIT
        $limit = '';

        if($this->pinned) {
            $limit = "LIMIT $offset, 99";
        } else {
            if( ($offset !== false) && ($recsPerPage) ) {
                $limit = "LIMIT $offset, $recsPerPage";
            }
        }

        ////////////////////////////////////////////////////////////
        // FINAL QUERY
        $sql = "SELECT *, n.id AS n_id, 0 AS has_comments $this->sqlFromWhere $order_by $limit";

        switch ($filter) {
            case 'Documents': $filterQuery = 'AND p.document_id <> 0 AND n.object_name <> "UserCourse"'; break;
            case 'Images': $filterQuery = 'AND p.attachment_id <> 0 AND n.object_name <> "UserCourse"'; break;
            case 'Links': $filterQuery = 'AND p.link_data_id <> 0'; break;
            case 'instructorContent': $filterQuery = 'AND p.user_id IN ('.$instructorsId.')'; break;
            case 'All': $filterQuery = ''; break;
            default: $filterQuery = ''; break;
        }

        if ($this->gCourseId) {
            // work sql
            $sql = "SELECT
                        n.id AS id,
                        n.object_id AS object_id,
                        n.object_name AS object_name,
                        n.related_object_id AS related_object_id,
                        n.related_object_name AS related_object_name,
                        n.created_at AS created_at,
                        n.deleted_at AS deleted_at,
                        n.id AS n_id
                    FROM
                        notification AS n
                    LEFT JOIN
                        post AS p
                    ON p.id = n.object_id
                    WHERE (
                        n.related_object_id = ".$this->gCourseId."
                            ".$postType." AND
                        n.related_object_name = 'Course'
                            AND
                        n.deleted_at IS NULL ".$filterQuery."
                          )
                    $order_by $limit";
        }
        $this->list = DataUtils::rawSelect($sql, array('index_on'=>'n_id')); 
        if (empty($this->list)) { return array(); }

        $this->setListObjects(); 
        $this->setListRelatedObjects();
        $this->setListComments(); 
        $this->setQuickAccessKeys(); 

        if($this->user) {
            $this->setUserRelatedResources();
            $this->setPermissions();
        }

        if($this->pinned) {
            foreach ($this->list as $notiffication) {
                if (isset($notiffication['object'])) {
                    if (isset($notiffication['object']['is_pinned'])) {
                        if($notiffication['object']['is_pinned']) {
                            $this->pinnedList[$notiffication['id']] = $notiffication;
                        }
                    }
                }
            }
            return $this->pinnedList;
        }

        return $this->list;
    }

    protected function setListObjects() {
        $purge_no_object = Utils::getOptionValue($this->options, 'purge_no_object', true); // purge_no_object removes notifications for which an object record cannot be found.
        $user = $this->user->getId();
        $count = 0;
        // first collect ids per object type
        $objIDs = array();
        foreach($this->list as $n) {
            $objIDs[$n['object_name']][] = $n['object_id'];
            $count = $n['related_object_id'];
        }
        
        $table = 'Post';
        $ids = array();
        foreach($objIDs as $objectName => $obj) {
            $table = $objectName;
            $ids = $obj;

            $dq = Doctrine_Core::getTable($table)->createQuery('o INDEXBY o.id')
                    ->select('
                        o.id,
                        up.is_staff as is_staff,
                        up.is_tutor as tutor,
                        u.id AS u_id,
                        up.id AS up_id,
                        (CASE 1 WHEN up.is_staff THEN CONCAT(u.first_name, " ", u.last_name) 
                                WHEN up.is_tutor THEN CONCAT(u.first_name, " ", u.last_name) 
                                ELSE CONCAT(u.first_name, " ", LEFT(u.last_name, 1)) END) AS user_name,
                        up.image AS user_image')
                    ->leftJoin('o.User u') // 'User' is sfGuardUser in schema
                    ->leftJoin('u.Profile AS up');
            $dq->whereIn('o.id', $ids);

            if ($table == 'Post') { //If Post, then get link data for it.
                $dq->addSelect("
                    o.*, ld.*,
                    ld.id AS link_data_id,")
                    ->leftJoin('o.LinkData as ld')
                    ;
            }

            // update query as needed for each specific object
            $methodName = '_updateQueryFor'.$table;
            if(method_exists($this, $methodName)) {
                $this->$methodName($dq);
            }

            #Utils::dq_to_sql($dq);
            $objs[$objectName] = $dq->fetchArray();
        }

        // update the notifications with object data
        $nIDs_no_object = array(); // contains ids of notifications where its object could not be found.
        foreach($this->list as $nID=>&$n) {
            $oID = $n['object_id'];
            $oName = $n['object_name'];
            if(isset($objs[$oName][$oID])) {
                $n['object'] = $objs[$oName][$oID];
            } else {
                $nIDs_no_object[] = $nID;
            }
        }

        $lastLogin = Doctrine_core::getTable('sfGuardUser')->createQuery('sf')
                     ->where('sf.id = ?', $user)
                     ->fetchOne();
        $session_posts = new sfSessionStorage();
        $lastPosts = $session_posts->read('posts');
        if (null !== $lastPosts) {
            foreach ($this->list as $id => $userCourse) {
                if ($userCourse['object_name'] === 'UserCourse') {
                    if (isset($lastPosts[$userCourse['related_object_id']]['notification_id'])) {
                        if ($id <= (int)$lastPosts[$userCourse['related_object_id']]['notification_id']) {
                            unset($this->list[$id]);
                        }
                    } else {
                        continue;
                    }
                }
            }
        }
        
        if($purge_no_object) {
            foreach($nIDs_no_object as $id) {
                unset($this->list[$id]);
            }
        }
    }

    protected function _updateQueryForUserCourse($dq) {
        $dq->addSelect('us.*, pd.*')
            ->leftJoin('u.UserSchool AS us')
            ->leftJoin('us.PrimaryDepartment AS pd')
        ;
    }
    protected function _updateQueryForUserSchool($dq) {
        $dq->addSelect('d.*')
            ->leftJoin('o.PrimaryDepartment AS d')
        ;
    }
    protected function _updateQueryForDocument($dq) {
        $dq->addSelect('c.id AS c_id, c.code, d.id AS d_id, d.name, d.alias')
            ->leftJoin('o.Course AS c')
            ->leftJoin('c.Department AS d')
        ;
    }

    protected function setListComments() {
        $nIDs = array_keys($this->list);
        $count = 0;
        $user = $this->user->getId();
        if (isset($nIDs[0]))
            $count = $this->list[$nIDs[0]]["related_object_id"];

        if ($count <= 0) { return false; }

        $comms = Doctrine_Core::getTable('Post')
                ->createQuery('p')
                ->select('p.*,
                    up.is_staff as is_staff,
                    up.is_tutor as tutor,
                    p.count_like AS count_like,
                    u.id AS u_id,
                    up.id AS up_id,
                    u.post_count AS post_count,
                    (CASE 1 WHEN up.is_staff THEN CONCAT(u.first_name, " ", u.last_name) 
                            WHEN up.is_tutor THEN CONCAT(u.first_name, " ", u.last_name) 
                            ELSE CONCAT(u.first_name, " ", LEFT(u.last_name, 1)) END) AS user_name,
                    up.image AS user_image')
                ->leftJoin('p.User u')
                ->leftJoin('u.Profile AS up')
                ->andWhere('p.object_name = ?', Post::NOTIFICATION_OBJECT)
                ->andWhere('p.deleted_at IS NULL')
                ->whereIn('p.object_id', $nIDs)
                ->orderBy('p.created_at DESC')
                ->fetchArray();

        foreach($comms as $c) {
            $this->list[$c['object_id']]['has_comments'] = true;
            $this->list[$c['object_id']]['comments'][] = $c;
        }
    }

    protected function setListRelatedObjects() {
        // first collect ids per related_object type
        $relObjIDs = array();
        foreach($this->list as $n) {
            if($n['related_object_id']) {
                $relObjIDs[$n['related_object_name']][] = $n['related_object_id'];
            }
        }
        
        // run query to get related objects
        foreach($relObjIDs as $objectName => $ids) {
            $dq = Doctrine_Core::getTable($objectName)->createQuery('o INDEXBY o.id')
                ->whereIn('o.id', $ids);
            if($objectName == 'Course') {
                $dq->leftJoin('o.Department');
            }
            $objs[$objectName] = $dq->fetchArray();
        }
        
        // update the notifications with object data
        foreach($this->list as $nID => &$n) {
            $oID = $n['related_object_id'];
            $oName = $n['related_object_name'];
            if(isset($objs[$oName][$oID])) {
                $n['related_object'] = $objs[$oName][$oID];
            }
        }
    }


    /**
    * set class member resources used to internally calculate/set Friend Status and Permissions.
    *
    */
    protected function setUserRelatedResources() {
        $this->courses = $this->user->getCourseList(array(
            'hydration_mode'    =>  Doctrine_Core::HYDRATE_ARRAY,
            'index_by'          =>  'c.id'
        ));
    }

    protected function setPermissions() {
        foreach($this->list as &$n) {
            if (isset($n['object_name'])) {
                if($n['object_name'] == 'Document') {
                    if(isset($n['object'])) {
                        $obj_user_id    = $n['object']['user_id'];
                        $user_id = $this->user->getId();

                        if($obj_user_id == $user_id) { // user can always download their own docs
                            $n['permissions']['download'] = true;

                        } else {
                            $obj_course_id  = $n['object']['course_id'];

                            $hasCourse = true; // default to true, so if $obj_course_id is not set, then $hasCourse = true (basically the doc was uploaded to everyone)
                            if($obj_course_id) {
                                $hasCourse = (isset($this->courses[$obj_course_id]));
                            }
//                            $isFriend = (isset($this->friends[$n['object']['user_id']]));
                            #Utils::pfa(array('isFriend'=>$isFriend, 'hasCourse'=> $hasCourse, 'docCourseID'=>$course_id));

                            $n['permissions']['download'] = ($hasCourse && $isFriend);
                        }
                    }
                }
            }
        }
    }

    /**
    * Takes data nested in convoluted hierarchy of array keys and creates top level
    * easy-to-access keys for use in templates.
    */
    protected function setQuickAccessKeys() {
        foreach($this->list as &$n) {
            if (isset($n['object_name'])) {
                switch($n['object_name']) {
                    case 'UserSchool':
                        $n['user_class_year'] = $n['object']['class_year'];
                        $n['user_major'] = isset($n['object']['major']) ? $n['object']['major'] : (isset($n['object']['PrimaryDepartment']) ? $n['object']['PrimaryDepartment']['name'] : '');
                        break;
                    case 'UserCourse':
                        if (isset($n['object']['User']['UserSchool'][0])) {
                            $school = $n['object']['User']['UserSchool'][0];

                            if (isset($n['related_object']) && isset($school['school_id'])) {
                                $n['course_name'] = $n['related_object']['name'];
                                $n['user_school'] = SchoolTable::getInstance()->findOneById($school['school_id']);
                                $n['user_class_year'] = $school['class_year'];
                                $n['user_major'] = isset($school['major']) ? $school['major'] : (isset($school['PrimaryDepartment']) ? $school['PrimaryDepartment']['name'] : '');
                            }
                        }
                        break;
                    case 'Document':
                        $n['department_alias'] = $n['object']['Course']['Department']['alias'];
                        $n['course_code'] = $n['object']['Course']['code'];

                        $file_parts = explode('.', $n['object']['file']);
                        $extension = strtolower(array_pop($file_parts));
                        $n['object']['sanitized_file_name'] = Utils::sanitizeFileName($n['object']['name']).'.'.$extension;
                        break;
                }
            }

            if (isset($n['related_object_name'])) {
                switch($n['related_object_name']) {
                    case 'Course':
                        if (isset($n['related_object']) && isset($n['related_object']['code']) && isset($n['related_object']['Department']['alias']))
                            $n['department_course_code'] = $n['related_object']['Department']['alias'].$n['related_object']['code'];
                        else
                            $n['department_course_code'] = '';
                        break;
                }
            }
        }
    }

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                    //
// GET                                                                               //
//                                                                                  //
/////////////////////////////////////////////////////////////////////////////////////
//    function getRecCount() {
//        return $this->recCount;
//    }

    function getList($offset = false, $recsPerPage = false, $filter = NULL, $type = false, $studentId = false, $t = 0) {

        switch ($type) {
            case 'course': $type = 0; break;
            case 'private': $type = 1; break;
            default: $type = false;
        }
        if($this->pinned) {
 
            if(!$this->pinnedList) {
                $this->setList($offset, $recsPerPage, $filter, $type, $studentId, $t);
            }

            return $this->pinnedList;
        } else {

            if(!$this->list) {
                $this->setList($offset, $recsPerPage, $filter, $type, $studentId, $t);
            }

            return $this->list;
        }
    }


    /**
    * Retrieve the first notification from the list.
    * Used to retrieve comments when refreshing the comments list for a notification.
    *
    */
    function getOne() {
        if( ! $this->list) {
            $this->setList();
        }
        return reset($this->list);
    }
};
?>
