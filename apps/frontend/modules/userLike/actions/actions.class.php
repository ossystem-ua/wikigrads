<?php

/**
 * uploads actions.
 *
 * @package    sf_sandbox_old
 * @subpackage uploads
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userLikeActions extends myActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $user = $this->getUser()->getGuardUser();

        $arr["object_id"] = $request->getParameter('object');
        $arr["user_id"]   = $user->getId();
        $arr["success"]   = 0;
        $arr["like"]      = 0;
        $arr["message"]   = "";
        $arr["staff"]     = 0;
        $arr["data_like"] = 2;

        // check is_staff sfGuardUserProfile
        $result = Doctrine::getTable('sfGuardUserProfile')->findOneBy("user_id", $arr["user_id"]);
        $arr["ustaff"] = 0;
        if ($result) {
            if ($result->getIsStaff())
                $arr["ustaff"] = 1;
        }

        // switch off like block
        $arr["staff"] = 0;

        $bAccess = true;
        if ($arr["object_id"] > 0 && $arr["user_id"] > 0)
        {

            // check on this user - this post
            $q = Doctrine::getTable('Post')->createQuery('p')
                    ->andWhere('p.user_id = ?', $arr["user_id"])
                    ->andWhere('p.id = ?', $arr["object_id"]);
            $result = $q->fetchArray();
            if (count($result) > 0) $bAccess = false;

            // check instructor's post
            $userspost = 0;
            $q = Doctrine::getTable('Post')->createQuery('p')
                    ->where ('p.id = ?', $arr["object_id"]);
            $result = $q->fetchOne();
            if ($result) { $userspost = $result['user_id']; }

            $arr["staff"] = $this->checkUsersStaff($arr["object_id"], $userspost);

            $q = Doctrine::getTable('sfGuardUserProfile')->createQuery('up')
                    ->andWhere('up.user_id = ?', $userspost);
            $result = $q->fetchOne();
            if ($result) { if ($arr["staff"] == 1) { $bAccess = false; } }


            if ($arr["staff"] == 0 && $bAccess == true) {
                $q = Doctrine::getTable('UserLike')->createQuery('u')
                    ->andWhere('u.user_id = ?', $arr["user_id"])
                    ->andWhere('u.object_id = ?', $arr["object_id"]);
                $result = $q->fetchArray();
                if (count($result) > 0) {
                    // update record like
                    $data = $result[0];

                    switch(intval($data["count_like"])) {
                        //case -1: { $data["count_like"] = 1;  }break;
                        //case 0:  { $data["count_like"] = -1; }break;
                        case 0:  { $data["count_like"] = 1;  }break;
                        default: { $data["count_like"] = 0;  }break;
                    }

                    Doctrine_Query::create()
                        ->update('UserLike u')
                        ->set('u.count_like', '?', $data["count_like"])
                        ->where('u.id = ?', $data["id"])
                        ->execute();
                } else {
                    // insert new record
                    $arr["data_like"] = 1;
                    $record = new UserLike();
                    $record->setUserId($arr["user_id"])
                        ->setObjectId($arr["object_id"])
                        ->setCountLike('1')
                        ->save();
                }
            }
            // get all summ
            $q = Doctrine_Query::create()
                    ->select('SUM(u.count_like) as counts')
                    ->from('UserLike u')
                    ->where('u.object_id = ?', $arr["object_id"]);
            $result = $q->fetchArray();
            $arr["like"] = $result[0]["counts"];
            $arr["data_like"] = $data["count_like"];
            if ($arr["staff"] == 0 && $bAccess) {
                // update likes in post comments
                Doctrine_Query::create()
                    ->update('Post p')
                    ->set('p.count_like', '?', $arr["like"])
                    ->where('p.id = ?', $arr["object_id"])
                    ->execute();
            }
        } else {
            $arr["message"] = "Object or User id not found.";
        }
        if (!$bAccess) {
            $arr["data_like"] = 2;
            $arr["message"] = "You can't vote yourself";   // "You can't vote yourself";
        }

        if ($arr["staff"] != 0) {
            $arr["success"] = 1;
            $arr["message"] = "Only students";
        }

        echo json_encode($arr);
    }

    public function checkUsersStaff($postId, $userId) {
        $post = Doctrine::getTable('Post')->findOneBy("id", $postId);
        if (!$post) return 0;

        $courseId = 0;

        if ($post->getObjectName() == "Course" && $courseId == 0) {
            $courseId = $post->getObjectId();
        }

        if ($post->getObjectName() == "Notification" && $courseId == 0) {
            $notification = Doctrine::getTable('Notification')->findOneBy("id", $postId);
            if ($notification) {
                if ($notification->getRelatedObjectName() == "Course") {
                    $courseId = $notification->getRelatedObjectId();
                }
            }
        }
        $currentUser = Doctrine::getTable('sfGuardUserProfile')->findOneBy("user_id", $userId);

        if ($currentUser) {
            if ($currentUser->getIsTutor() == 1)
                return 0;
        }

        $instructor = Doctrine::getTable('InstructorCourse')
                ->createQuery('c')
                ->where('c.user_id = ?', $userId)
                ->andWhere('c.course_id = ?', $courseId)
                ->execute();
        if (count($instructor) > 0)
            return 1;
        else
            return 0;
    }
}
