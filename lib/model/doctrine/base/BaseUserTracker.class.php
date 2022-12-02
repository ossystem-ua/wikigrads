<?php

/**
 * BaseUserTracker
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $course_id
 * @property integer $notification_id
 * @property integer $new_posts
 * @property integer $new_classmates
 * @property integer $private
 * @property sfGuardUser $User
 * @property Course $Course
 * @property Notification $Notification
 * @property Post $Post
 * 
 * @method integer      getUserId()          Returns the current record's "user_id" value
 * @method integer      getCourseId()        Returns the current record's "course_id" value
 * @method integer      getNotificationId()  Returns the current record's "notification_id" value
 * @method integer      getNewPosts()        Returns the current record's "new_posts" value
 * @method integer      getNewClassmates()   Returns the current record's "new_classmates" value
 * @method integer      getPrivate()         Returns the current record's "private" value
 * @method sfGuardUser  getUser()            Returns the current record's "User" value
 * @method Course       getCourse()          Returns the current record's "Course" value
 * @method Notification getNotification()    Returns the current record's "Notification" value
 * @method Post         getPost()            Returns the current record's "Post" value
 * @method UserTracker  setUserId()          Sets the current record's "user_id" value
 * @method UserTracker  setCourseId()        Sets the current record's "course_id" value
 * @method UserTracker  setNotificationId()  Sets the current record's "notification_id" value
 * @method UserTracker  setNewPosts()        Sets the current record's "new_posts" value
 * @method UserTracker  setNewClassmates()   Sets the current record's "new_classmates" value
 * @method UserTracker  setPrivate()         Sets the current record's "private" value
 * @method UserTracker  setUser()            Sets the current record's "User" value
 * @method UserTracker  setCourse()          Sets the current record's "Course" value
 * @method UserTracker  setNotification()    Sets the current record's "Notification" value
 * @method UserTracker  setPost()            Sets the current record's "Post" value
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUserTracker extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user_tracker');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('course_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('notification_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('new_posts', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('new_classmates', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('private', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             'default' => 0,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('Course', array(
             'local' => 'course_id',
             'foreign' => 'id'));

        $this->hasOne('Notification', array(
             'local' => 'notification_id',
             'foreign' => 'id'));

        $this->hasOne('Post', array(
             'local' => 'private',
             'foreign' => 'private'));
    }
}