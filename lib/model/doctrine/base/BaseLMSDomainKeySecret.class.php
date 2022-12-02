<?php

/**
 * BaseLMSDomainKeySecret
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $domain
 * @property string $key_s
 * @property string $secret
 * 
 * @method string             getDomain() Returns the current record's "domain" value
 * @method string             getKeyS()   Returns the current record's "key_s" value
 * @method string             getSecret() Returns the current record's "secret" value
 * @method LMSDomainKeySecret setDomain() Sets the current record's "domain" value
 * @method LMSDomainKeySecret setKeyS()   Sets the current record's "key_s" value
 * @method LMSDomainKeySecret setSecret() Sets the current record's "secret" value
 * @property school $
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLMSDomainKeySecret extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('lms_domain_key_secret');
        $this->hasColumn('domain', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('key_s', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
        $this->hasColumn('secret', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('school', array(
             'local' => 'domain',
             'foreign' => 'lms_domain',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}