<?php

/**
 * BaseUserSchool
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $school_id
 * @property string $major
 * @property integer $primary_department_id
 * @property integer $secondary_department_id
 * @property integer $class_year
 * @property sfGuardUser $User
 * @property School $School
 * @property Department $PrimaryDepartment
 * @property Department $SecondaryDepartment
 * 
 * @method integer     getUserId()                  Returns the current record's "user_id" value
 * @method integer     getSchoolId()                Returns the current record's "school_id" value
 * @method string      getMajor()                   Returns the current record's "major" value
 * @method integer     getPrimaryDepartmentId()     Returns the current record's "primary_department_id" value
 * @method integer     getSecondaryDepartmentId()   Returns the current record's "secondary_department_id" value
 * @method integer     getClassYear()               Returns the current record's "class_year" value
 * @method sfGuardUser getUser()                    Returns the current record's "User" value
 * @method School      getSchool()                  Returns the current record's "School" value
 * @method Department  getPrimaryDepartment()       Returns the current record's "PrimaryDepartment" value
 * @method Department  getSecondaryDepartment()     Returns the current record's "SecondaryDepartment" value
 * @method UserSchool  setUserId()                  Sets the current record's "user_id" value
 * @method UserSchool  setSchoolId()                Sets the current record's "school_id" value
 * @method UserSchool  setMajor()                   Sets the current record's "major" value
 * @method UserSchool  setPrimaryDepartmentId()     Sets the current record's "primary_department_id" value
 * @method UserSchool  setSecondaryDepartmentId()   Sets the current record's "secondary_department_id" value
 * @method UserSchool  setClassYear()               Sets the current record's "class_year" value
 * @method UserSchool  setUser()                    Sets the current record's "User" value
 * @method UserSchool  setSchool()                  Sets the current record's "School" value
 * @method UserSchool  setPrimaryDepartment()       Sets the current record's "PrimaryDepartment" value
 * @method UserSchool  setSecondaryDepartment()     Sets the current record's "SecondaryDepartment" value
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUserSchool extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user_school');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('school_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('major', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('primary_department_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('secondary_department_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('class_year', 'integer', 2, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => 2,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('School', array(
             'local' => 'school_id',
             'foreign' => 'id'));

        $this->hasOne('Department as PrimaryDepartment', array(
             'local' => 'primary_department_id',
             'foreign' => 'id'));

        $this->hasOne('Department as SecondaryDepartment', array(
             'local' => 'secondary_department_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}