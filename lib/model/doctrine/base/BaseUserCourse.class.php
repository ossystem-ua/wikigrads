<?php

/**
 * BaseUserCourse
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $course_id
 * @property string $object_name
 * @property string $access
 * @property sfGuardUser $User
 * @property Course $Course
 * 
 * @method integer     getUserId()      Returns the current record's "user_id" value
 * @method integer     getCourseId()    Returns the current record's "course_id" value
 * @method string      getObjectName()  Returns the current record's "object_name" value
 * @method string      getAccess()      Returns the current record's "access" value
 * @method sfGuardUser getUser()        Returns the current record's "User" value
 * @method Course      getCourse()      Returns the current record's "Course" value
 * @method UserCourse  setUserId()      Sets the current record's "user_id" value
 * @method UserCourse  setCourseId()    Sets the current record's "course_id" value
 * @method UserCourse  setObjectName()  Sets the current record's "object_name" value
 * @method UserCourse  setAccess()      Sets the current record's "access" value
 * @method UserCourse  setUser()        Sets the current record's "User" value
 * @method UserCourse  setCourse()      Sets the current record's "Course" value
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUserCourse extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user_course');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('course_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('object_name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('access', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
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

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}