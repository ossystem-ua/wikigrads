<?php

/**
 * PostTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PostTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PostTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Post');
    }

    /**
     * Return a single post with related user info
     * Used mainly to display the comment that was just posted by the user
     *
     * @static
     * @param $postId
     * @return mixed
     */
    public static function getPostDetailsById($postId, $userId) {
        $sql = Doctrine_Core::getTable('Post')->createQuery("p")
            ->select("p.*, u.id AS u_id, up.is_staff as is_staff, up.id AS up_id, CONCAT(u.first_name, ' ', u.last_name) AS user_name, up.image AS user_image")
            ->leftJoin('p.User u')
            ->leftJoin('u.Profile AS up')
            ->where('p.id = ?', $postId);

        $comment = $sql->fetchOne(array(), Doctrine::HYDRATE_ARRAY);

        return $comment;
    }

    protected function _getRecUserFriendStatus($user_id, $other_user_id, $object_name = '') {
        $isSelf = ($user_id == $other_user_id);

        $isFriend = $isFriendPending = false;       // init to false
        if( ! $isSelf) {
            $isFriend = (isset($this->friends[$other_user_id]));
            if( ! $isFriend) {
                $isFriendPending = (isset($this->friendsPending[$other_user_id]));
            }
        }

        $friend_status = array(
            'other_user_id'     =>  $other_user_id,
            'is_self'           =>  $isSelf,
            'is_friend'         =>  $isFriend,
            'is_friend_pending' =>  $isFriendPending
        );
        return $friend_status;
    }
}