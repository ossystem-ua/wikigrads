<?php

/**
 * BaseCourse
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $department_id
 * @property string $name
 * @property string $code
 * @property string $instructor
 * @property integer $instructor_id
 * @property string $category
 * @property integer $subject_id
 * @property string $access
 * @property Department $Department
 * @property sfGuardUser $User
 * @property Subject $Subject
 * @property Doctrine_Collection $sfGuardUser
 * @property Doctrine_Collection $Event
 * @property Doctrine_Collection $AcademicTermCourse
 * @property Doctrine_Collection $InstructorCourse
 * @property Doctrine_Collection $UserCourse
 * @property Doctrine_Collection $Document
 * @property Doctrine_Collection $UserTracker
 * 
 * @method integer             getDepartmentId()       Returns the current record's "department_id" value
 * @method string              getName()               Returns the current record's "name" value
 * @method string              getCode()               Returns the current record's "code" value
 * @method string              getInstructor()         Returns the current record's "instructor" value
 * @method integer             getInstructorId()       Returns the current record's "instructor_id" value
 * @method string              getCategory()           Returns the current record's "category" value
 * @method integer             getSubjectId()          Returns the current record's "subject_id" value
 * @method string              getAccess()             Returns the current record's "access" value
 * @method Department          getDepartment()         Returns the current record's "Department" value
 * @method sfGuardUser         getUser()               Returns the current record's "User" value
 * @method Subject             getSubject()            Returns the current record's "Subject" value
 * @method Doctrine_Collection getSfGuardUser()        Returns the current record's "sfGuardUser" collection
 * @method Doctrine_Collection getEvent()              Returns the current record's "Event" collection
 * @method Doctrine_Collection getAcademicTermCourse() Returns the current record's "AcademicTermCourse" collection
 * @method Doctrine_Collection getInstructorCourse()   Returns the current record's "InstructorCourse" collection
 * @method Doctrine_Collection getUserCourse()         Returns the current record's "UserCourse" collection
 * @method Doctrine_Collection getDocument()           Returns the current record's "Document" collection
 * @method Doctrine_Collection getUserTracker()        Returns the current record's "UserTracker" collection
 * @method Course              setDepartmentId()       Sets the current record's "department_id" value
 * @method Course              setName()               Sets the current record's "name" value
 * @method Course              setCode()               Sets the current record's "code" value
 * @method Course              setInstructor()         Sets the current record's "instructor" value
 * @method Course              setInstructorId()       Sets the current record's "instructor_id" value
 * @method Course              setCategory()           Sets the current record's "category" value
 * @method Course              setSubjectId()          Sets the current record's "subject_id" value
 * @method Course              setAccess()             Sets the current record's "access" value
 * @method Course              setDepartment()         Sets the current record's "Department" value
 * @method Course              setUser()               Sets the current record's "User" value
 * @method Course              setSubject()            Sets the current record's "Subject" value
 * @method Course              setSfGuardUser()        Sets the current record's "sfGuardUser" collection
 * @method Course              setEvent()              Sets the current record's "Event" collection
 * @method Course              setAcademicTermCourse() Sets the current record's "AcademicTermCourse" collection
 * @method Course              setInstructorCourse()   Sets the current record's "InstructorCourse" collection
 * @method Course              setUserCourse()         Sets the current record's "UserCourse" collection
 * @method Course              setDocument()           Sets the current record's "Document" collection
 * @method Course              setUserTracker()        Sets the current record's "UserTracker" collection
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCourse extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('course');
        $this->hasColumn('department_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('code', 'string', 10, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 10,
             ));
        $this->hasColumn('instructor', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('instructor_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('category', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('subject_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('access', 'string', 10, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 10,
             ));


        $this->index('code', array(
             'fields' => 
             array(
              0 => 'code',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Department', array(
             'local' => 'department_id',
             'foreign' => 'id'));

        $this->hasOne('sfGuardUser as User', array(
             'local' => 'instructor_id',
             'foreign' => 'id'));

        $this->hasOne('Subject', array(
             'local' => 'subject_id',
             'foreign' => 'id'));

        $this->hasMany('sfGuardUser', array(
             'refClass' => 'UserCourse',
             'local' => 'course_id',
             'foreign' => 'user_id'));

        $this->hasMany('Event', array(
             'local' => 'id',
             'foreign' => 'course_id'));

        $this->hasMany('AcademicTermCourse', array(
             'local' => 'id',
             'foreign' => 'course_id'));

        $this->hasMany('InstructorCourse', array(
             'local' => 'id',
             'foreign' => 'course_id'));

        $this->hasMany('UserCourse', array(
             'local' => 'id',
             'foreign' => 'course_id'));

        $this->hasMany('Document', array(
             'local' => 'id',
             'foreign' => 'course_id'));

        $this->hasMany('UserTracker', array(
             'local' => 'id',
             'foreign' => 'course_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}