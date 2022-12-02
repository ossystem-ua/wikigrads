<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: components.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class mainComponents extends sfComponents
{
    public function executeQuickUserInfo(sfWebRequest $request) {
        $this->user = $this->getUser()->getGuardUser();
        $this->expanded = $request->getParameter('qui_expand');
    }

    public function executeHeaderNav(){
        $this->loggedIn = $this->getUser()->isAuthenticated();

        $user= $this->getUser()->getGuardUser();

        if ($this->loggedIn)
        {

            $this->page_links = array(
                '@homepage' => array(
                        'text' => 'Home',
                        'tag'	=>	'headdash'
                    ),
                '@user?id='.$user->getId().'&name='.Utils::slugify($user->getName()) => array(
                        'text' => 'Profile',
                        'tag'	=>	'headprofile'
                    ),
                '@document' => array(
                        'text' => 'Documents',
                        'tag'	=>	'headdocuments'
                    )
            );

        }
    }

    public function executeFooterNav(){
		$this->page_links = array(
			'@terms' => array(
					'text' => 'Terms',
					'tag'	=>	'footterms'
				),
			'@about' => array(
					'text' => 'About Us',
					'tag'	=>	'footabout'
				),
			'@contact' => array(
					'text' => 'Contact Us',
					'tag'	=>	'footcontact',
					'last'  => true
				)
		);
    }

    public function executeLeftNav(){
        $this->loggedIn = $this->getUser()->isAuthenticated();
        $user = $this->getUser()->getGuardUser();

        if ($this->loggedIn) {
            $this->page_links = array(
                '@homepage' => array(
                        'text'	=>	'Home',
                        'tag'	=>	'dashboard'
                    ),
                '@user?id='.$user->getId().'&name='.Utils::slugify($user->getName()) => array(
                        'text'	=>	'My Profile',
                        'tag'	=>	'my_profile'
                    ),
                '@document' => array(
                        'text'	=>	'WikiDocuments',
                        'tag'	=>	'document'
                    ),
                '@new_member_list' => array(
                        'text' => 'New Members',
                        'tag'	=>	'new_member_list'
                    )
            );

            $this->user = $user;

        } else {
            $this->page_links = array(
                '@tour' => array(
                        'text' => 'Take a Tour',
                        'tag'	=>	'tour'
                    ),
                '@about' => array(
                        'text' => 'About Wiki Grads',
                        'tag'	=>	'about'
                    ),
                '@keep_in_touch' => array(
                        'text' => 'Keep in Touch',
                        'tag'	=>	'keep_in_touch'
                    )
            );

        }
    }


    //  NEW WIKI CODE
    public function executeWikiHeader(){
        $this->userNameCaption = "";
        $user = $this->getUser();
        $guard = $user->getGuardUser();
        $this->loggedIn = $user->isAuthenticated();
        $this->userProfile = $user->getGuardUser();

        $this->session_course_id = new sfSessionStorage();
        $this->sessionCourseId = $this->session_course_id->read('cId');

        if ($this->loggedIn) {
            $this->userId = $user->getGuardUser()->getId();
            if($guard->getSfGuardUserProfile()->getIsTutor()) {
                $this->status = false;
            } else {
                $this->status = $guard->getSfGuardUserProfile()->getIsStaff();
            }

            if ($guard->getSfGuardUserProfile()->getIsTutor() ||
                $guard->getSfGuardUserProfile()->getIsStaff()) {
                    $this->statusUser = 1;
            } else {
                $this->statusUser = 0;
            }

            $this->courses = $user->getGuardUser()->getCourseList();

            $this->postList($this->userId, $this->courses);
            
            if (count($this->courses) <= 0) {
                
            } else if (count($this->courses) == 1) {
                foreach ($this->courses as $course) {
                    $this->course = $course;
                    break;
                }
            } else {
                foreach ($this->courses as $course) {
                    if ($course->getId() == $this->sessionCourseId) {
                        $this->course = $course;
                        break;
                    }
                }
            }

            $this->userImage = $this->getUserThumbnail($user->getGuardUser()->getId(), $guard->getSfGuardUserProfile()->getImage(), 40, 0, 0, 1);
            $this->userNameCaption = $guard->getFirstName()." ".$guard->getLastName();
            $this->profileurl = '@user?id='.$user->getGuardUser()->getId().'&name='.Utils::slugify($user->getGuardUser()->getName());
        }
    }

    public function executeWikiFooter(){
        $this->loggedIn = $this->getUser()->isAuthenticated();
        $user = $this->getUser();
        $this->userProfile = $user->getGuardUser();

        if ($this->getUser()->isAuthenticated()) {
        $session_documents = new sfSessionStorage();
        $docId = $session_documents->read('documentId');
        $imgId = $session_documents->read('imageId');

        if ($docId !== null) {

            $post = Doctrine_Core::getTable('Post')->createQuery('p')
                    ->where("p.document_id = ?", $docId)
                    ->andWhere("p.deleted_at IS NULL")
                    ->fetchOne();

            if (!$post) {
                $deleteDoc = Doctrine_Core::getTable('Document')->findOneById($docId);
                if ($deleteDoc) {
                    $deleteDoc->delete();
                }
            }

            $session_documents->remove('documentId');
        }

        if ($imgId !== null) {

            $post = Doctrine_Core::getTable('Post')->createQuery('p')
                    ->where("p.attachment_id = ?", $imgId)
                    ->andWhere("p.deleted_at IS NULL")
                    ->fetchOne();

            if (!$post) {
                $deleteImg = Doctrine_Core::getTable('UserAttachment')->findOneById($imgId);
                if ($deleteImg) {
                    $deleteImg->delete();
                }
            }

            $session_documents->remove('imageId');
        }
        }

    }

    public function executeWikiContent(){
        $this->loggedIn = $this->getUser()->isAuthenticated();
    }

    public function executeMainNav(sfRequest $request){

        $this->courses = array();
        $user = $this->getUser();
        $this->loggedIn = $user->isAuthenticated();

        if ($this->loggedIn) {
            $this->courses = $user->getGuardUser()->getCourseList();
            if (count($this->courses) <= 0) {

            }
        }
        $this->currentUser = $user->getGuardUser();
    }

    public function executePrivateFeedNav(sfRequest $request){

        $this->courses = array();
        $user = $this->getUser();
        $guard = $user->getGuardUser();
        $this->loggedIn = $user->isAuthenticated();

        if ($this->loggedIn) {
            $this->userId = $user->getGuardUser()->getId();
            if($guard->getSfGuardUserProfile()->getIsTutor()) {
                $this->status = false;
            } else {
                $this->status = $guard->getSfGuardUserProfile()->getIsStaff();
            }

            if ($guard->getSfGuardUserProfile()->getIsTutor() ||
                $guard->getSfGuardUserProfile()->getIsStaff()) {
                    $this->statusUser = 1;
            } else {
                $this->statusUser = 0;
            }

            $this->courses = $user->getGuardUser()->getCourseList();
            if (count($this->courses) <= 0) {

            }
        }
        $this->currentUser = $user->getGuardUser();
    }

    public function executeStatisticsNav(sfRequest $request){

        $this->courses = array();
        $user = $this->getUser();
        $guard = $user->getGuardUser();
        $this->loggedIn = $user->isAuthenticated();

        if ($this->loggedIn) {
            $this->userId = $user->getGuardUser()->getId();
            if($guard->getSfGuardUserProfile()->getIsTutor()) {
                $this->status = false;
            } else {
                $this->status = $guard->getSfGuardUserProfile()->getIsStaff();
            }

            if ($guard->getSfGuardUserProfile()->getIsTutor() ||
                $guard->getSfGuardUserProfile()->getIsStaff()) {
                    $this->statusUser = 1;
            } else {
                $this->statusUser = 0;
            }

            $this->courses = $user->getGuardUser()->getCourseList();
            if (count($this->courses) <= 0) {

            }
        }
        $this->currentUser = $user->getGuardUser();
    }

    public function executeDocumentMainNav() {
        $this->courses = array();
        $user = $this->getUser();
        $this->loggedIn = $user->isAuthenticated();

        if ($this->loggedIn) {
            $this->courses = $user->getGuardUser()->getCourseList();
            if (count($this->courses) <= 0) {

            }
        }
        $this->currentUser = $user->getGuardUser();
    }

    private function getUserThumbnail($user_id, $user_image, $width, $height = 0, $square = false, $absolute = false) {
        if (!$user_id) return "";
        $userProfileImageDir = '/uploads/profile/' . $user_id;
        /**
         * @var $user sfGuardUser
         */
        $user = sfGuardUserTable::getInstance()->findOneById($user_id);
        if(!$user_image) {
            $file = '/images/default_avatar.png';
        } else {
            $file = $userProfileImageDir . '/' . $user_image;
        }

        $testFile = (__DIR__)."/../../../../../web".$file;
        if (!file_exists($testFile)) {
            $file = '/images/default_avatar.png';
        }

        $thumb_path = $userProfileImageDir . '/thumbnails';

        $relurl = sfContext::getInstance()->getRequest()->getRelativeUrlRoot();
        if ($relurl && strpos($file, $relurl) !== false) {
            $file = substr($file, strlen($relurl));
        }

        try {

            if ( ! file_exists(sfConfig::get('sf_web_dir') . $file)) {
                $file = '/uploads/default_profile/' . $user->getMainSchool()->getDefaultUserImage();
            }

            $image_size = 0;
            $file_name = sfConfig::get('sf_web_dir') . $file;
            if (is_file($file_name)) {
                $image_size = getimagesize(sfConfig::get('sf_web_dir') . $file);
            }

            // do not thumbnail if the image is smaller than the thumbnail
            if ($image_size[0] < $width && $image_size[1] < $height) {
                $path = $file;
            } else {
                $path = Utils::thumbnail_path($file, $thumb_path, array(
                    'width' => $width,
                    'height' => $height,
                    'square' => $square,
                    'absolute' => $absolute,
                ));
            }
        } catch (Exception $e) {
            $path = $file;
        }

        return $path;
    }
    
    protected function postList($userId = 0, $courses = 0) {
        if ($courses && $userId) {
            $session_posts = new sfSessionStorage();
            $lastPosts = $session_posts->read('posts');
            if (empty($lastPosts)) {
                $courseList = array();
                foreach ($courses as $course) {
                    $courseList[$course->getId()] = $course->getId();
                }

                $lastPost = Doctrine_Core::getTable('userTracker')->createQuery('ut INDEXBY ut.course_id')
                           ->select('ut.notification_id, ut.course_id')
                           ->where('ut.private = 0')
                           ->whereIn('ut.course_id', $courseList)
                           ->andWhere('ut.user_id = ?', $userId)
                           ->fetchArray();
                $session_posts->write('posts', $lastPost);
            }
        }
    }
}