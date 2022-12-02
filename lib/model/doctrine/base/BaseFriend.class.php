<?php

/**
 * BaseFriend
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $friend_id
 * @property sfGuardUser $User
 * @property sfGuardUser $Friend
 * 
 * @method integer     getUserId()    Returns the current record's "user_id" value
 * @method integer     getFriendId()  Returns the current record's "friend_id" value
 * @method sfGuardUser getUser()      Returns the current record's "User" value
 * @method sfGuardUser getFriend()    Returns the current record's "Friend" value
 * @method Friend      setUserId()    Sets the current record's "user_id" value
 * @method Friend      setFriendId()  Sets the current record's "friend_id" value
 * @method Friend      setUser()      Sets the current record's "User" value
 * @method Friend      setFriend()    Sets the current record's "Friend" value
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFriend extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('friend');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('friend_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('sfGuardUser as Friend', array(
             'local' => 'friend_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}