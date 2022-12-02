<?php

/**
 * myStudents actions.
 *
 * @package    Wikigrads
 * @subpackage myStudents
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class myStudentsActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->forward404Unless($course_id = $this->getRequestParameter('course'));
        $user = $this->getUser()->getGuardUser();
        $this->isTutor = 0;
        
        $this->courses = $user->getCourseList();
        $this->profile = $user->getSfGuardUserProfile();
        $this->user = $user;
        $this->userNameCaption = $user->getFirstName() . " " . $user->getLastName();
        $this->userId = $user->getId();
        
        $params = array();
        $params['user_id'] = $this->userId;
        $params['course'] = $course_id;
        
        $orderField = $this->getRequestParameter('order');
        $orderDesc = $this->getRequestParameter('desc');
        $this->order = array("name"=>0, "post"=>0, "comment"=>0, "activity"=>0, "instr"=>0, "stud"=>0);
        $this->arrow = array("name"=>"down", "post"=>"down", "comment"=>"down", "activity"=>"down", "instr"=>"down", "stud"=>"down");
        $this->arrowColor = array("name"=>"", "post"=>"", "comment"=>"", "activity"=>"", "instr"=>"", "stud"=>"");
        $this->arrowColor[$orderField] = "statistic-arrow-color";
        
        if ($orderDesc == 1) {
            $params['desc'] = "DESC";
            $orderDesc = 0;
        } else {
            $params['desc'] = " ";
            $orderDesc = 1;
        }
        $this->arrow[$orderField] = ($orderDesc) ? 'down' : 'up';
        
        switch($orderField) {
            case 'name':
                $params['order'] = "full_name";
                $this->order["name"] = $orderDesc;
                break;
            case 'post':
                $params['order'] = "posts";
                $this->order["post"]= $orderDesc;
                break;
            case 'comment':
                $params['order'] = "replies";
                $this->order["comment"]= $orderDesc;
                break;
            case 'activity':
                $params['order'] = "activity";
                $this->order["activity"]= $orderDesc;
                break;
            case 'instr':
                $params['order'] = "instructor_likes";
                $this->order["instr"]= $orderDesc;
                break;
            case 'stud':
                $params['order'] = "user_likes";
                $this->order["stud"]= $orderDesc;
                break;
            default:
                $params['order'] = "full_name";
        }
        
        $conn = Doctrine_Manager::connection();
        $pdo = $conn->execute("SELECT ic.course_id,          
                       uc.user_id, 
                       u.first_name, 
                       u.last_name,
                       CONCAT(u.first_name, ' ', u.last_name) AS full_name,
                       c.name,
                       COUNT(pc.object_name), 
                       SUM(CASE WHEN pc.object_name = 'Course' AND pc.object_id = :course THEN 1 ELSE 0 END) AS posts,
                       SUM(CASE WHEN n.object_name = 'Post' AND n.related_object_id = :course THEN 1 ELSE 0 END) AS replies,
                       CASE WHEN 
                              SUM(CASE WHEN pc.object_name = 'Course' AND pc.object_id = :course THEN 1 ELSE 0 END) > 0
                            THEN 
                              ROUND(SUM(CASE WHEN n.object_name = 'Post' AND n.related_object_id = :course THEN 1 ELSE 0 END) /
                              SUM(CASE WHEN pc.object_name = 'Course' AND pc.object_id = :course THEN 1 ELSE 0 END), 1)
                            ELSE 0 END AS activity,
                       SUM(CASE WHEN ((pc.object_name = 'Course' AND pc.object_id = :course) OR
                                     (n.object_name = 'Post' AND n.related_object_id = :course)) AND
                                     (pc.document_id > 0 OR pc.attachment_id > 0 OR pc.link_data_id > 0)
                                THEN 1 ELSE 0 END) AS attachment,
                       COUNT(pc.id),
                       COUNT(CASE WHEN uc.user_id = :user_id then null else uc.user_id end) AS user_id_c,
                       COUNT(CASE WHEN up.is_staff = 1 OR up.is_tutor = 1 THEN ul.user_id ELSE null END) AS instructor_likes,
                       COUNT(CASE WHEN up.is_staff = 0 AND up.is_tutor = 0 THEN ul.user_id ELSE null END) AS user_likes
                FROM instructor_course AS ic
                LEFT JOIN user_course AS uc ON uc.course_id = ic.course_id
                LEFT JOIN sf_guard_user AS u ON u.id = uc.user_id
                LEFT JOIN course AS c ON c.id = ic.course_id
                LEFT JOIN post AS pc ON pc.user_id = uc.user_id
                LEFT JOIN user_like AS ul ON ul.object_id = pc.id
                LEFT JOIN sf_guard_user_profile AS up ON up.user_id = ul.user_id
                LEFT JOIN notification AS n ON n.id = pc.object_id
                WHERE ic.user_id = :user_id
                  AND ic.course_id = :course
                  AND pc.deleted_at is null
                GROUP BY ic.course_id, uc.user_id, u.first_name, u.last_name, c.name
                ORDER BY ".$params['order']." ".$params['desc'], $params);
        $this->myStudents = $pdo->fetchAll();
        $this->courseName = "";
        $courseTemp = 0;
        
        $courseName = Doctrine::getTable('Course')
                         ->createQuery('c')
                         ->where("c.id = ?", $course_id)
                         ->fetchOne();
        if ($courseName instanceof Course) {
            $this->courseName = $courseName->getShortName();
        }
        
        $this->course_id = $course_id;
        
        $instructors = Doctrine::getTable('instructorCourse')
                         ->createQuery('ic')
                         ->select("ic.user_id")
                         ->where("ic.course_id = ?", $course_id)
                         ->fetchArray();
        
        $this->totalPosts = 0;
        $this->totalComments = 0;
        $this->totalAttachment = 0;
        foreach ($this->myStudents as $key => $counts) {
            $this->totalPosts = $this->totalPosts+$counts['posts'];
            $this->totalComments = $this->totalComments+$counts['replies'];
            $this->totalAttachment = $this->totalAttachment+$counts['attachment'];
            foreach ($instructors as $instr) {
                if ($counts['user_id'] == $instr['user_id']) {
                    $this->myStudents[$key]['instructor'] = 1;
                    break;
                } else {
                    $this->myStudents[$key]['instructor'] = 0;
                }
            }
        }
        
    }

}
