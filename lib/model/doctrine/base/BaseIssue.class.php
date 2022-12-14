<?php

/**
 * BaseIssue
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property clob $description
 * @property clob $information
 * @property integer $user_id
 * @property clob $from_page
 * @property sfGuardUser $User
 * 
 * @method clob        getDescription() Returns the current record's "description" value
 * @method clob        getInformation() Returns the current record's "information" value
 * @method integer     getUserId()      Returns the current record's "user_id" value
 * @method clob        getFromPage()    Returns the current record's "from_page" value
 * @method sfGuardUser getUser()        Returns the current record's "User" value
 * @method Issue       setDescription() Sets the current record's "description" value
 * @method Issue       setInformation() Sets the current record's "information" value
 * @method Issue       setUserId()      Sets the current record's "user_id" value
 * @method Issue       setFromPage()    Sets the current record's "from_page" value
 * @method Issue       setUser()        Sets the current record's "User" value
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIssue extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('issue');
        $this->hasColumn('description', 'clob', null, array(
             'type' => 'clob',
             'notnull' => true,
             ));
        $this->hasColumn('information', 'clob', null, array(
             'type' => 'clob',
             'notnull' => true,
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('from_page', 'clob', null, array(
             'type' => 'clob',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}