<?php

/**
 * BaseUserSubject
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $subject_id
 * @property sfGuardUser $User
 * @property Subject $Subject
 * 
 * @method integer     getUserId()     Returns the current record's "user_id" value
 * @method integer     getSubjectId()  Returns the current record's "subject_id" value
 * @method sfGuardUser getUser()       Returns the current record's "User" value
 * @method Subject     getSubject()    Returns the current record's "Subject" value
 * @method UserSubject setUserId()     Sets the current record's "user_id" value
 * @method UserSubject setSubjectId()  Sets the current record's "subject_id" value
 * @method UserSubject setUser()       Sets the current record's "User" value
 * @method UserSubject setSubject()    Sets the current record's "Subject" value
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUserSubject extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user_subject');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('subject_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('Subject', array(
             'local' => 'subject_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}