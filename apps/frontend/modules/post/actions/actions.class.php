<?php

/**
 * post actions.
 *
 * @package    sf_sandbox_old
 * @subpackage post
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class postActions extends myActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  public function getUserStaff($notificationId=0, $courseId=0, $postId=0) {
        $user = $this->getUser()->getGuardUser();
        $is_current_staff = $user->getSfGuardUserProfile()->is_staff;

        if ($notificationId==0 && $courseId==0 && $postId==0) {
            return $is_current_staff;
        } else {
            if ($courseId==0) {
                if ($postId > 0) {
                    $post = Doctrine::getTable('Post')->findOneBy("id", $postId);
                    if ($post) {
                        if ($post->getObjectName() == "Course")
                            $courseId = $post->getObjectId();
                        else {
                            $not = Doctrine::getTable('Notification')
                                    ->createQuery('n')
                                    ->where('n.object_id = ?', $post)
                                    ->andWhere('n.object_name = ?', 'Post')
                                    ->execute();
                            foreach($not as $record) {
                                $notificationId = $record->getId();
                            }
                        }
                    }
                }
            }

            if ($courseId <= 0 && $notificationId > 0) {
                $not = Doctrine::getTable('Notification')->findOneBy("id", $notificationId);
                if ($not) {
                    if ($not->getRelatedObjectName() == "Course") {
                        $courseId = $not->getRelatedObjectId();
                    }
                }
            }
        }
        $result = Doctrine::getTable('InstructorCourse')
                ->createQuery('ic')
                ->where('ic.user_id = ?', $user->getId())
                ->andWhere('ic.course_id = ?', $courseId)
                ->execute();
        if (count($result) > 0)
            return 1;
        else
            return 0;
    }

    /**
     * AJAX DASHBOARD COMMENT
     */

    public function executeAjaxAddComment(sfWebRequest $request)
    {
        $user = $this->getUser()->getGuardUser();

        if ($notification_id = $request->getParameter('notification_id')) {
            $this->forward404Unless($notification = Doctrine_Core::getTable('Notification')->findOneById($notification_id));
        }
        $courseId = 0;

        $post = new Post();
        $post->setUserId($user->getId());
        $post->setObjectName("Notification");
        $post->setObjectId($notification->getId());
        $post->setEveryone(0);
        if ($notification->getRelatedObjectName() == "Course") {
            $courseId = $notification->getRelatedObjectId();
        }

        if ($notification->getObjectName() == 'Post') {
            $rec_post = Doctrine_Core::getTable('Post')->findOneById($notification->getObjectId());
            if ($rec_post) {
                $post->setEveryone($rec_post->getEveryone());
            }
        }

        $IsStaff = $this->getUserStaff($notification_id);
        
        $form = new CommentForm($post);
        $formCommentArray = $request->getParameter($form->getName());
        if ($formCommentArray['content'] === '' &&
                ($formCommentArray['document_id'] !== '' ||
                $formCommentArray['attachment_id'] !== '')) {
            $formCommentArray['content'] = ' ';
            $request->setParameter($form->getName(), $formCommentArray);
        }
        $form = $this->processForm($form, $request);

        if ($request->isMethod('post')) {
            $formStatus = Utils::getFormStatus($form);
            $json = json_encode($formStatus);

            $comment = PostTable::getPostDetailsById($form->getObject()->getId(), $user->getId());

            $user_staff = 0;
            $result = Doctrine::getTable('InstructorCourse')
                ->createQuery('c')
                ->where('c.user_id = ?', $user->getId())
                ->execute();
            if (count($result) > 0) {
                $user_staff = 1;
            }

            return $this->renderPartial('notification/notification_comment', array('comment' => $comment, 'IsStaff' => $IsStaff, 'user_staff' => $user_staff));
        }
        return $this->renderPartial('post/commentForm', array('form' => $form, 'notification' => $notification, 'profile' => $user, 'courseId' => $courseId));
    }

    public function executeAjaxEditComment(sfWebRequest $request)
    {
        $user = $this->getUser()->getGuardUser();

        if ($post_id = $request->getParameter('post_id')) {
            $this->forward404Unless($post = Doctrine_Core::getTable('Post')->findOneById($post_id));
        }

        // check ownership of post

        $isModerator = $this->getUser()->isModerator();
        $userIdSession = $user->getID();
        $userIdComment = $post->getUserId();
        $IsStaff       = $this->getUserStaff(0,0,$post_id);

        if ($request->isMethod(('get'))) {
            if (!$isModerator && $userIdSession != $userIdComment && $IsStaff == 0 && $user->getIsOfficer() == 0) {
                $this->getResponse()->setStatusCode('403');
                return $this->renderText('Permission denied');
            }
        }

        if ($rt = $request->getParameter('post')) {
            //print($rt['content']);
        }

        // process form
        $form = new CommentForm($post);
        $form = $this->processForm($form, $request, array(
            'flash' => 'Successfully edited comment',
            //'redirect' => $url
        ));


        $post_content = $post['content'];
        return $this->renderPartial('post/editCommentForm', array('form' => $form, 'post' => $post, 'post_content' => $post_content, 'profile' => $user->getSfGuardUserProfile()));
    }

    public function executeAjaxEditPost(sfWebRequest $request)
    {
        $user    = $this->getUser()->getGuardUser();

        if ($notification_id = $request->getParameter('notification_id')) {
            $this->forward404Unless($notification = Doctrine_Core::getTable('Notification')->findOneById($notification_id));
        }
        $IsStaff = $this->getUserStaff($notification_id);
        $this->forward404Unless($post = Doctrine_Core::getTable('Post')->findOneById($notification->getObject()->getId()) );

        // check ownership of notification
        $isModerator = $this->getUser()->isModerator();
        $userIdSession = $user->getID();
        $userIdPost = $post->getUserId();

        if ($request->isMethod(('get'))) {
            if (! $isModerator && $userIdSession != $userIdPost && $IsStaff == 0 && $user->getIsOfficer() == 0) {
                $this->getResponse()->setStatusCode('403');
                return $this->renderText('Permission denied');
            }
        }

        // process form
        $form = new PostForm($post);
        if($form->getObject()->getContent() == '')
            $form->getObject()->setContent('image');


        $form = $this->processForm($form, $request, array(
            'flash' => 'Successfully edited post',
            //'redirect' => $url
        ));
//        if ($request->isMethod('put')) {
//            $post_detail_updated = PostTable::getPostDetailsById($form->getObject()->getId(), $user->getId());
//            return $this->renderPartial('notification/notification_post', array('post_detail_updated' => $post_detail_updated));
//        }

        $post_content = $post->getContent();
        $post_url     = '';
        if($post['attachment_id'] > 0 && $post['ftype'] == 0)
            $post_url = $post['attachment_url'];
        return $this->renderPartial('post/editPostForm', array('form' => $form, 'notification' => $notification, 'post_content' => $post_content, 'post_url' => $post_url));
    }

  /**
   * AJAX DASHBOARD POST MESSAGE
   */

  public function executeAjaxAddPost(sfWebRequest $request) {
    $user = $this->getUser()->getGuardUser();
    $options = array();

    $data = $request->getParameter('post');
        if (isset($data['course_id']) || $request->getParameter('course_id')) {
        $options['include_course'] = $request->getParameter('course_id') ? $request->getParameter('course_id') : true;
    }
    $post = new Post();
    $post->setUserId($user->getId());
    $form = new PostForm($post, $options);
    $form = $this->processForm($form, $request, array(
       'flash' => 'You have successfully added your post.',
    ));

    return $this->renderPartial('post/postForm', array('form' => $form));
  }

  public function executeProcessDashboardPostForm(sfWebRequest $request) {
        $user = $this->getUser()->getGuardUser();
        $post = new Post();
        $post->setUserId($user->getId());
        $studentId = $request->getPostParameter('studentId');
        //force set pin to false
        if(!$user['sfGuardUserProfile']['is_staff'])
            $post->setIsPinned(false);

        $form = new DashboardPostForm($post);

        //creating image preview for LinkData
        $formNameArray = $request->getParameter($form->getName());
        $image = $formNameArray['LinkData']['img'];
        $imgUrl = 0;
        if ($image) {
            $formNameArray['LinkData']['url'] = trim($formNameArray['LinkData']['url']);
            $width = sfConfig::get("app_linkDataThumbnail_width");
            $height = sfConfig::get("app_linkDataThumbnail_height");
            $imgUrl = $this->CreateImagePreview($image, $width, $height);
            if (-1 !== $imgUrl &&  -2 !== $imgUrl && -3 !== $imgUrl) {
                $formNameArray['LinkData']['img'] = $imgUrl;
            } else {
                $formNameArray['LinkData']['img'] = '';
            }
        }
        $request->setParameter($form->getName(), $formNameArray);
        $data = $request->getParameter($form->getName());

        $form = $this->processForm($form, $request);

        if (isset($studentId) && !empty($studentId)) {
            $url = @notification_private_list;
            $params = array();
            $params['type'] = 'private';
            $params['id'] = $post->getObjectId();
            $params['user'] = $studentId;
        } else {
            $url = @notification_course_list;
            $params = array();
            $params['type'] = 'course';
            $params['slug'] = $post->getObjectId();
        }
        $formStatus = Utils::getFormStatus($form);
        $formStatus['post_url'] = $this->generateUrl($url, $params);
        
        $imageError = array(1 => 'This image type not supported', 
                            2 => 'Error loading image', 
                            3 => 'Error loading image'
                        );
        if (-1 === $imgUrl ||  -2 === $imgUrl || -3 === $imgUrl) {
            $formStatus['global_errors'] = $imageError[abs($imgUrl)];
        }

        echo json_encode($formStatus);
        exit;
        return "None";
    }

    public function executeDeleteComment(sfWebRequest $request)
    {
        # find post to be deleted
        if ($post_id = $request->getParameter('post_id')) {
            $this->forward404Unless($post = Doctrine_Core::getTable('Post')->findOneById($post_id));
        }

        $IsStaff = $this->getUserStaff(0,0,$post_id);
        # check ownership of post

        $isModerator = $this->getUser()->isModerator();
        $userIdSession = $this->getUser()->getGuardUser()->getId();
        $userIdComment = $post->getUserId();

        if ($isModerator || $userIdSession == $userIdComment || $IsStaff == 1 || $this->getUser()->getGuardUser()->getIsOfficer() == 1) {

            # delete
            if ($post->getDocumentId() > 0) {
                $delDoc = Doctrine_Core::getTable('Document')->findOneById($post->getDocumentId());
                $delDoc->delete();
            }

            if ($post->delete()) {
                $this->getUser()->setFlash('notice', 'The comment was successfully deleted.');
            } else {
                $this->getUser()->setFlash('error', 'The comment was unable to be deleted. Please try again.');
            }

        } else {
            $this->getUser()->setFlash('error', 'Permission denied. You can only delete your own post.');
        }
        $url = $request->getCookie('current_url', NULL);
        if (strlen($url) > 0) $url[0] = '@';
        else $url = '@dashboard';
        $this->redirect($url);
    }

    public function executeFlagAsInappropriate(sfWebRequest $request)
    {
        // find notification and post (or comment) to be flagged

        if ($request->hasParameter('notification_id')) {

            $notification_id = $request->getParameter('notification_id');
            $this->forward404Unless($notification = Doctrine_Core::getTable('Notification')->findOneById($notification_id));
            $this->forward404Unless($post = $notification->getObject());

        } else if ($request->hasParameter('post_id')) {

            $post_id = $request->getParameter('post_id');
            $this->forward404Unless($post = Doctrine_Core::getTable('Post')->findOneById($post_id));
            $this->forward404Unless($notification = $post->getNotification());

        } else {
            $this->forward404('notification_id or post_id is missing at calling ' . __FUNCTION__);
        }

        // TODO: save 'flagged' status somewhere in model
        //       Determine which model class will have the 'flagged' status field, or create a new model.
        //       Determine data type for the 'flagged' status field
        //         - Boolean for a simple On/Off states
        //         - Integer so that it can record 'flagged counter'

        // send notification email

        $this->sendFlagAsInappropriateEmail($notification, $post);

        $this->getUser()->setFlash('notice', 'Email has been sent to administrators and moderators. Thank you!');
        $url = $request->getCookie('current_url', NULL);
        if (strlen($url) > 0) $url[0] = '@';
        else $url = '@dashboard';
        $this->redirect($url);
    }

    public function sendFlagAsInappropriateEmail($notification, $post)
    {
        // TODO (low priority performance tuning): combine multiple DB queries made by all the lazy loading happening here into a single DQL query

        // prepare shared email contents

        $noReplyEmail = sfConfig::get('app_address_noreply');

        $user = $this->getUser()->getGuardUser();
        $notifierFullName = $user->getFirstName() . ' ' . $user->getLastName();

        $postType = ($post->getObjectName() === Post::COURSE_OBJECT) ? 'post' : 'comment';
        $subject = $notifierFullName . ' has flagged a ' . $postType . ' as inappropriate';

        $course = $notification->getRelatedObject();
        if ($course->getDepartment()) {
            $courseDepartmentAndCode = $course->getDepartment()->getAlias() . ' ' . $course->getCode();
        } else {
            $courseDepartmentAndCode = $course->getCode();
        }


        $postOwner = $post->getUser();
        $postOwnerFullName = $postOwner->getFirstName() . ' ' . $postOwner->getLastName();

        $postDate = $post->getCreatedAt();

        $postContent = $post->getContent();

        // get names and email addresses of notification recipients

        $recipients = sfGuardUserTable::getNotificationRecipientsNamesAndEmails();

        // send emails to recipients with same subject and message

        foreach ($recipients as $recipient) {

            // compose
            $message = $this->getMailer()->compose();
            $message->setTo($recipient['email_address']);
            $message->setFrom(array($noReplyEmail => $noReplyEmail));
            $message->setSubject($subject);
            $message->setBody($this->getPartial('post/flagAsInappropriateEmail', array(
                'recipientFirstName' => $recipient['first_name'],
                'notifierFullName' => $notifierFullName,
                'postType' => $postType,
                'courseDepartmentAndCode' => $courseDepartmentAndCode,
                'postOwnerFullName' => $postOwnerFullName,
                'postDate' => $postDate,
                'postContent' => $postContent
            )), 'text/html');

            // send
            $this->getMailer()->send($message);
        }
    }

    public function executeFlaggetpost(sfWebRequest $request) {
        $user = $this->getUser()->getGuardUser();

        $arr = array();
        $arr['id']    = $request->getParameter('dataId');
        $arr['href']  = $request->getParameter('dataHref');
        $arr['class'] = $request->getParameter('dataClass');
        $arr['title'] = 'Flag this post';

        $post = Doctrine::getTable('Post')->createQuery('p')
            ->andWhere('p.id = ?', $arr['id'])
            ->fetchOne();

        if (!$post->getFlagget()) {
            // set flag
            $arr['title'] = 'Flagged';
            $post->setFlagget(1);
            $post->save();

            if (strpos($arr['class'], "flagged", 0) !== false) {

            } else {
                $arr['class'] .= " flagged";
            }
        }

        echo json_encode($arr);
    }


     /**
     * Function that creates image preview and returns It's absolute address
      * ATTENTION. Supports jpg gif and png
     *
     * @param string $imgUrl
     * @param int $width
     * @param int $height
     * @return string | int
     */
    private function CreateImagePreview($imgUrl, $width = 200, $height = 200){
        $trueX = $width;
        $trueY = $height;
        $parsedUrl = parse_url($imgUrl);
        if( !isset($parsedUrl['scheme']) ){
            $imgUrl = ltrim( $imgUrl, "/");
            $imgUrl = "http://" . $imgUrl;
        }

        $imgType = 'jpg';
        if( preg_match("([^\s]+(\.(?i)(jpg))$)", $imgUrl) ){
            $imgType = 'jpg';
        }
        if( preg_match("([^\s]+(\.(?i)(gif))$)", $imgUrl) ){
            $imgType = 'gif';
        }
        if( preg_match("([^\s]+(\.(?i)(png))$)", $imgUrl) ){
            $imgType = 'png';
        }

        try {
            switch($imgType){
                case 'jpg':
                    $sourceImage = imagecreatefromjpeg($imgUrl);
                    break;
                case 'gif':
                    $sourceImage = imagecreatefromgif($imgUrl);
                    imagesavealpha($sourceImage, true);
                    break;
                case 'png':
                    $sourceImage = imagecreatefrompng($imgUrl);
                    imagesavealpha($sourceImage, true);
                    break;
                default:
                    return -1;//This image type not supported'
            }

            if(!$sourceImage) {
                throw new sfException('Function caused the exception: imagecreatefrom'.$imgType.' or imagesavealpha.');
            }
        } catch (sfException $e) {
            sfContext::getInstance()->getLogger()->err($e->getMessage());
            return -2; //Error loading image. 
        }

        $sourceImageSizeX = imagesx($sourceImage);
        $sourceImageSizeY = imagesy($sourceImage);

        $correction = $trueX/$sourceImageSizeX >= $trueY/$sourceImageSizeY ? $trueX/$sourceImageSizeX : $trueY/$sourceImageSizeY;

        $correctionX = (1-$correction) * $sourceImageSizeX;
        $correctionY = (1-$correction) * $sourceImageSizeY;

        $destImageSizeX = $sourceImageSizeX - $correctionX;
        $destImageSizeY = $sourceImageSizeY - $correctionY;
        $destImage = imagecreatetruecolor($destImageSizeX, $destImageSizeY);
        imagesavealpha($destImage, true);
        $trans_colour = imagecolorallocatealpha($destImage, 0, 0, 0, 127);
        imagefill($destImage, 0, 0, $trans_colour);
       // imagecopyresized($destImage, $sourceImage, 0, 0, 0, 0, $destImageSizeX, $destImageSizeY, $sourceImageSizeX, $sourceImageSizeY); //scale image
        imagecopyresampled($destImage, $sourceImage, 0, 0, 0, 0, $destImageSizeX, $destImageSizeY, $sourceImageSizeX, $sourceImageSizeY); //scale image, better quality and more resources needed

        $destImage2 = imagecreatetruecolor($trueX, $trueY);
        imagesavealpha($destImage2, true);
        $trans_colour = imagecolorallocatealpha($destImage2, 0, 0, 0, 127);
        imagefill($destImage2, 0, 0, $trans_colour);

        $diffX = ($destImageSizeX - $trueX)+0.5;
        $diffY = ($destImageSizeY - $trueY)+0.5;
       // imagecopyresized($destImage2, $destImage, 0, 0, $diffX/2, $diffY/2, $trueX, $trueY, $destImageSizeX-$diffX, $destImageSizeY-$diffY);//crop scaled image
        imagecopyresampled($destImage2, $destImage, 0, 0, $diffX/2, $diffY/2, $trueX, $trueY, $destImageSizeX-$diffX, $destImageSizeY-$diffY);//crop scaled image, better quality and more resources needed

        //create filename from url begin
        $file = $this->createImageFromUrl($parsedUrl, $trueX, $trueY, $imgType);
        //create filename from url end

        try {
            switch($imgType){
                case 'jpg':
                    $createImage = imagejpeg($destImage2, $file, 100);
                    break;
                case 'gif':
                    $createImage = imagegif($destImage2, $file);
                    break;
                case 'png':
                    $createImage = imagepng($destImage2, $file);
                    break;
            }
        
            if (!$createImage) {
                throw new sfException('Function caused the exception: image'.$imgType);
            }
        } catch(sfException $e) {
            sfContext::getInstance()->getLogger()->err($e->getMessage());
            return -3;
        }
        return substr($file, strlen(sfConfig::get("sf_web_dir")));
    }
    
    private function createImageFromUrl ($parsedUrl, $trueX, $trueY, $imgType) {
        $host = str_replace(".", "_", $parsedUrl['host']);
        $path = $parsedUrl['path'];
        $nameBegin = strrpos($path, "/")+1;
        $nameEnd = strrpos($path, ".");
        $imgName = substr($path, $nameBegin, $nameEnd-$nameBegin);
        $file = sfConfig::get("sf_previews_dir").DIRECTORY_SEPARATOR.$host."_".$imgName."_"."$trueX"."x"."$trueY".".".$imgType;
        return $file;
    }
}
