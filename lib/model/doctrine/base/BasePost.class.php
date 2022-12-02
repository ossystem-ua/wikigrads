<?php

/**
 * BasePost
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $object_id
 * @property string $object_name
 * @property integer $parent_post_id
 * @property integer $count_like
 * @property integer $user_id
 * @property integer $attachment_id
 * @property string $attachment_url
 * @property integer $ftype
 * @property array $content
 * @property boolean $is_pinned
 * @property boolean $flagget
 * @property boolean $everyone
 * @property string $ftext
 * @property integer $document_id
 * @property integer $private
 * @property integer $link_data_id
 * @property UserAttachment $UserAttachment
 * @property sfGuardUser $User
 * @property Post $ParentPost
 * @property LinkData $LinkData
 * @property Doctrine_Collection $Post
 * @property Doctrine_Collection $UserTracker
 * 
 * @method integer             getObjectId()       Returns the current record's "object_id" value
 * @method string              getObjectName()     Returns the current record's "object_name" value
 * @method integer             getParentPostId()   Returns the current record's "parent_post_id" value
 * @method integer             getCountLike()      Returns the current record's "count_like" value
 * @method integer             getUserId()         Returns the current record's "user_id" value
 * @method integer             getAttachmentId()   Returns the current record's "attachment_id" value
 * @method string              getAttachmentUrl()  Returns the current record's "attachment_url" value
 * @method integer             getFtype()          Returns the current record's "ftype" value
 * @method array               getContent()        Returns the current record's "content" value
 * @method boolean             getIsPinned()       Returns the current record's "is_pinned" value
 * @method boolean             getFlagget()        Returns the current record's "flagget" value
 * @method boolean             getEveryone()       Returns the current record's "everyone" value
 * @method string              getFtext()          Returns the current record's "ftext" value
 * @method integer             getDocumentId()     Returns the current record's "document_id" value
 * @method integer             getPrivate()        Returns the current record's "private" value
 * @method integer             getLinkDataId()     Returns the current record's "link_data_id" value
 * @method UserAttachment      getUserAttachment() Returns the current record's "UserAttachment" value
 * @method sfGuardUser         getUser()           Returns the current record's "User" value
 * @method Post                getParentPost()     Returns the current record's "ParentPost" value
 * @method LinkData            getLinkData()       Returns the current record's "LinkData" value
 * @method Doctrine_Collection getPost()           Returns the current record's "Post" collection
 * @method Doctrine_Collection getUserTracker()    Returns the current record's "UserTracker" collection
 * @method Post                setObjectId()       Sets the current record's "object_id" value
 * @method Post                setObjectName()     Sets the current record's "object_name" value
 * @method Post                setParentPostId()   Sets the current record's "parent_post_id" value
 * @method Post                setCountLike()      Sets the current record's "count_like" value
 * @method Post                setUserId()         Sets the current record's "user_id" value
 * @method Post                setAttachmentId()   Sets the current record's "attachment_id" value
 * @method Post                setAttachmentUrl()  Sets the current record's "attachment_url" value
 * @method Post                setFtype()          Sets the current record's "ftype" value
 * @method Post                setContent()        Sets the current record's "content" value
 * @method Post                setIsPinned()       Sets the current record's "is_pinned" value
 * @method Post                setFlagget()        Sets the current record's "flagget" value
 * @method Post                setEveryone()       Sets the current record's "everyone" value
 * @method Post                setFtext()          Sets the current record's "ftext" value
 * @method Post                setDocumentId()     Sets the current record's "document_id" value
 * @method Post                setPrivate()        Sets the current record's "private" value
 * @method Post                setLinkDataId()     Sets the current record's "link_data_id" value
 * @method Post                setUserAttachment() Sets the current record's "UserAttachment" value
 * @method Post                setUser()           Sets the current record's "User" value
 * @method Post                setParentPost()     Sets the current record's "ParentPost" value
 * @method Post                setLinkData()       Sets the current record's "LinkData" value
 * @method Post                setPost()           Sets the current record's "Post" collection
 * @method Post                setUserTracker()    Sets the current record's "UserTracker" collection
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePost extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('post');
        $this->hasColumn('object_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('object_name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('parent_post_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('count_like', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('attachment_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('attachment_url', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('ftype', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('content', 'array', null, array(
             'type' => 'array',
             'notnull' => true,
             ));
        $this->hasColumn('is_pinned', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => false,
             ));
        $this->hasColumn('flagget', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => false,
             ));
        $this->hasColumn('everyone', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => false,
             ));
        $this->hasColumn('ftext', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('document_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('private', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('link_data_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             'default' => 0,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('UserAttachment', array(
             'local' => 'user_attachment_id',
             'foreign' => 'id'));

        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('Post as ParentPost', array(
             'local' => 'parent_post_id',
             'foreign' => 'id'));

        $this->hasOne('LinkData', array(
             'local' => 'link_data_id',
             'foreign' => 'id'));

        $this->hasMany('Post', array(
             'local' => 'id',
             'foreign' => 'parent_post_id'));

        $this->hasMany('UserTracker', array(
             'local' => 'private',
             'foreign' => 'private'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}