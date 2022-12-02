<?php

/**
 * BaseFriendRequest
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $friend_id
 * @property enum $status
 * @property string $message
 * @property sfGuardUser $User
 * @property sfGuardUser $Friend
 * 
 * @method integer       getUserId()    Returns the current record's "user_id" value
 * @method integer       getFriendId()  Returns the current record's "friend_id" value
 * @method enum          getStatus()    Returns the current record's "status" value
 * @method string        getMessage()   Returns the current record's "message" value
 * @method sfGuardUser   getUser()      Returns the current record's "User" value
 * @method sfGuardUser   getFriend()    Returns the current record's "Friend" value
 * @method FriendRequest setUserId()    Sets the current record's "user_id" value
 * @method FriendRequest setFriendId()  Sets the current record's "friend_id" value
 * @method FriendRequest setStatus()    Sets the current record's "status" value
 * @method FriendRequest setMessage()   Sets the current record's "message" value
 * @method FriendRequest setUser()      Sets the current record's "User" value
 * @method FriendRequest setFriend()    Sets the current record's "Friend" value
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFriendRequest extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('friend_request');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('friend_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'Pending',
              1 => 'Accepted',
              2 => 'Declined',
             ),
             'notnull' => false,
             ));
        $this->hasColumn('message', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
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