<?php

/**
 * sfGuardUserTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class sfGuardUserTable extends PluginsfGuardUserTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object sfGuardUserTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardUser');
    }

    /**
     * Get User By Slug
     *
     * Fetch user by slug.
     *
     * @param unknown_type $slug
     * @return unknown
     */
    public static function getUserBySlug($slug)
    {
        $id = current(preg_split('#\|#', $slug, 2));

        $sql = Doctrine_Core::getTable('sfGuardUser')->createQuery('u')
            ->where('u.id = ?', $id)
        ;

        return $sql->fetchOne();
    }

    /**
     * Returns newest members
     * @static
     * @param int $limit
     * @return mixed
     */
    public static function getNewMembersOBSOLETE($school_id = NULL, $limit = 20){

       $sql = self::getInstance()->createQuery('u')
                ->orderBy('u.created_at DESC')
                ->limit($limit);

       if($school_id){
           $sql->leftJoin('u.UserSchool us')
                ->where('us.school_id = ?', $this->getSchoolId());           
       }
       
       return $sql->execute();
    }

    /**
     * Return flag-as-inappropriate notification recipients' names and email addresses
     * @static
     * @return array of strings (associative array of name and email)
     */
    public static function getNotificationRecipientsNamesAndEmails()
    {
        $q = self::getInstance()
            ->createQuery('u')
            ->addSelect('u.first_name')
            ->addSelect('DISTINCT u.email_address')
            ->leftJoin('u.Groups g')
            ->where('u.is_super_admin = ?', true)
            ->orWhere('g.name = ?', sfGuardGroup::MODERATOR);

        return $q->fetchArray();
    }
    
    public static function getOnlyParentsId() {
        
        $q = Doctrine_Query::create()
                ->from('sfGuardUserProfile up')
                ->where('up.is_staff = 1')
                ->orWhere('up.is_tutor = 1');
        $result = $q->fetchArray();
        $str = "";
        foreach ($result as $val) {
            if (strlen($str) > 0) $str .= ",";
            $str .= $val['user_id'];
        }
        
        
        $q = Doctrine_Query::create()
                ->from('sfGuardUser u')
                ->where('u.id in ('.$str.')')
                ->orderBy('u.first_name');
        return $q->execute();
    }
    
    public function getSortByName() {
        $q = Doctrine_Query::create()
                ->from('sfGuardUser d')
                ->orderBy('d.first_name');
        return $q->execute();
    }
    
    public function doGetUserList ($q) {
        $rootAlias = $q->getRootAlias();
        $q->select($rootAlias.'.*, c.is_staff AS is_staff, (SELECT COUNT(p.id) FROM InstructorCourse p WHERE (p.user_id=c.user_id)) AS number_of_course');
        $q->leftJoin($rootAlias . '.sfGuardUserProfile c');
        return $q;
    }

    public function findOneLmsUser($conditions)
    {
        $queryAlias = 's';
        $domain = $conditions['domain'];
//        if(isset($conditions['email']) && $conditions['email']) {
//            $value = $conditions['email'];
//            $match = $this->createQuery($queryAlias)
//                ->where("LOWER($queryAlias.lms_email) = ?", trim(strtolower($conditions['email'])))
//                ->andWhere("LOWER($queryAlias.lms_domain) = ?", trim(strtolower($domain)))
//                ->andWhere("$queryAlias.is_lms = ?", true);
//        } else {
        if(isset($conditions['id']) && $conditions['id']) {
            $value = $conditions['id'];
            $match = $this->createQuery($queryAlias)
                ->where("$queryAlias.lms_id = ?", $conditions['id'])
                ->andWhere("LOWER($queryAlias.lms_domain) = ?", trim(strtolower($domain)))
                ->andWhere("$queryAlias.is_lms = ?", true);
        }
        //using plain SQL because DQL does not support UNION
        $fullQuery = $match->buildSqlQuery();
        
        //prioritize exact match, then starts with, then contains
        $userArray = $this->getConnection()->fetchRow(
            $fullQuery,
            array($value, $domain, true)
        );
        //do some jank here to remove the table alias prefixes so we can hydrate the object
        if ($userArray) {
            $userKeys = array_keys($userArray);
            array_walk($userKeys, function(&$match) use ($queryAlias){
                $match = str_replace($queryAlias . '__', '', $match);
            });
            $userArray = array_combine($userKeys, array_values($userArray));
        }
        
        if (!empty($userArray)) {
            $user = new sfGuardUser();
            $user->setArray($userArray);
            return $user;
        }
        return false;
    }
}