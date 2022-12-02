<?php

/**
 * BasesfGuardUserProfile
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property string $email
 * @property string $fullname
 * @property string $image
 * @property string $birthday
 * @property clob $about
 * @property clob $activity
 * @property string $validate
 * @property boolean $is_staff
 * @property boolean $is_tutor
 * @property boolean $email_post
 * @property boolean $email_reply
 * @property boolean $email_from
 * @property boolean $email_private
 * @property boolean $enter_code
 * @property boolean $has_modified_profile
 * @property sfGuardUser $User
 * 
 * @method integer            getUserId()               Returns the current record's "user_id" value
 * @method string             getEmail()                Returns the current record's "email" value
 * @method string             getFullname()             Returns the current record's "fullname" value
 * @method string             getImage()                Returns the current record's "image" value
 * @method string             getBirthday()             Returns the current record's "birthday" value
 * @method clob               getAbout()                Returns the current record's "about" value
 * @method clob               getActivity()             Returns the current record's "activity" value
 * @method string             getValidate()             Returns the current record's "validate" value
 * @method boolean            getIsStaff()              Returns the current record's "is_staff" value
 * @method boolean            getIsTutor()              Returns the current record's "is_tutor" value
 * @method boolean            getEmailPost()            Returns the current record's "email_post" value
 * @method boolean            getEmailReply()           Returns the current record's "email_reply" value
 * @method boolean            getEmailFrom()            Returns the current record's "email_from" value
 * @method boolean            getEmailPrivate()         Returns the current record's "email_private" value
 * @method boolean            getEnterCode()            Returns the current record's "enter_code" value
 * @method boolean            getHasModifiedProfile()   Returns the current record's "has_modified_profile" value
 * @method sfGuardUser        getUser()                 Returns the current record's "User" value
 * @method sfGuardUserProfile setUserId()               Sets the current record's "user_id" value
 * @method sfGuardUserProfile setEmail()                Sets the current record's "email" value
 * @method sfGuardUserProfile setFullname()             Sets the current record's "fullname" value
 * @method sfGuardUserProfile setImage()                Sets the current record's "image" value
 * @method sfGuardUserProfile setBirthday()             Sets the current record's "birthday" value
 * @method sfGuardUserProfile setAbout()                Sets the current record's "about" value
 * @method sfGuardUserProfile setActivity()             Sets the current record's "activity" value
 * @method sfGuardUserProfile setValidate()             Sets the current record's "validate" value
 * @method sfGuardUserProfile setIsStaff()              Sets the current record's "is_staff" value
 * @method sfGuardUserProfile setIsTutor()              Sets the current record's "is_tutor" value
 * @method sfGuardUserProfile setEmailPost()            Sets the current record's "email_post" value
 * @method sfGuardUserProfile setEmailReply()           Sets the current record's "email_reply" value
 * @method sfGuardUserProfile setEmailFrom()            Sets the current record's "email_from" value
 * @method sfGuardUserProfile setEmailPrivate()         Sets the current record's "email_private" value
 * @method sfGuardUserProfile setEnterCode()            Sets the current record's "enter_code" value
 * @method sfGuardUserProfile setHasModifiedProfile()   Sets the current record's "has_modified_profile" value
 * @method sfGuardUserProfile setUser()                 Sets the current record's "User" value
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasesfGuardUserProfile extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('sf_guard_user_profile');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('email', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             ));
        $this->hasColumn('fullname', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             ));
        $this->hasColumn('image', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('birthday', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('about', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('activity', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('validate', 'string', 17, array(
             'type' => 'string',
             'length' => 17,
             ));
        $this->hasColumn('is_staff', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('is_tutor', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('email_post', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => true,
             ));
        $this->hasColumn('email_reply', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('email_from', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('email_private', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('enter_code', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('has_modified_profile', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}