<?php

/**
 * document actions.
 *
 * @package    sf_sandbox_old
 * @subpackage document
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class documentActions extends myActions
{

    /**
     * Ajax Delete
     *
     * Ajax method to delete documents from courses.
     *
     * @param sfWebRequest $request
     * @return unknown
     */
    public function executeAjaxDelete(sfWebRequest $request) {
        $this->forward404Unless($request->isXmlHttpRequest());
        $this->forward404Unless($id = $this->getRequestParameter('id'));

        $this->forward404Unless($document = Doctrine_Core::getTable('document')->find($id));


        $user = $this->getUser()->getGuardUser();


        // forward to dashboard if user is not moderator or not document's owner
        if (! $this->getUser()->isModerator() && ! $document->isOwner($user)) {
            $this->forward('main', 'index');
        }

        $docPath = $document->getLocalPath();

        $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

        try {

            $conn->beginTransaction();

            /*
            //Delete notification
            $notification = $document->getNotification();
            $notification->delete();

            //delete comments
            //delete user notifications
            $document->delete();
            /**/
            $time = new \DateTime();
            $time = $time->format('Y-m-d H:i:s');
            Doctrine_Query::create()
                    ->update('Document d')
                    ->set('d.deleted_at', '?', $time)
                    ->where('d.id = ?', $document->getId())
                    ->execute();

            Doctrine_Query::create()
                    ->update('Post p')
                    ->set('p.deleted_at', '?', $time)
                    ->andWhere('p.attachment_id = ?', $document->getId())
                    ->andWhere('p.ftype = 1')
                    ->execute();

            $q = Doctrine::getTable('Post')->createQuery('p')
                    ->andWhere('p.deleted_at = ?', $time)
                    ->andWhere('p.ftype = 1')
                    ->andWhere('p.attachment_id = ?', $document->getId());

            $result = $q->fetchOne();
            if ($result) {
                Doctrine_Query::create()
                    ->update('Notification n')
                    ->set('n.deleted_at', '?', $time)
                    ->andWhere('n.object_id = ?', $result['id'])
                    ->andWhere("n.object_name = 'Post'")
                    ->execute();
            }

            $conn->commit();

        } catch (Exception $e) {
            $conn->rollback();
            $this->getResponse()->setStatusCode(500);
            return;
        }

        unlink($docPath);

        return sfView::NONE;
  }


  /**
   * Download file .. check if user has proper credentials
   *
   * @param sfWebRequest $request
   */
  public function executeDownload(sfWebRequest $request){

    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->forward404Unless($document = DocumentTable::getDocumentBySlug($slug));

    $user = $this->getUser()->getGuardUser();

    //If user is not owner
//    $this->forwardUnless($document->isOwner($user) || $user->hasFriend($document->getUser()), 'main', 'index');
    if (!is_file($document->getLocalPath())) {
        $this->redirect('@homepage');
    } else {
        $this->forward404Unless(is_file($document->getLocalPath()));
//        header('Content-disposition: attachment; filename="'.$document->getSanitizedFileName().'"');
        header('Content-disposition: attachment; filename="'.$document->getName().'"');
        header('Content-type: '.$document->getMimeType());
        readfile($document->getLocalPath());
    }
    exit();
    return "None";
  }


  /**
   * Document mangement page.. handles document upload as well
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request){
    $user            = $this->getUser()->getGuardUser();
    $document_fields = $request->getParameter('document');
    $course_id       = $document_fields['course_id'];
    $name            = $document_fields['name'];

    $document = new Document();
    $document->setName($name);
    $document->setUserId($user->getId());
    $document->setCourseId($course_id);
    if ($course_id > 0) {
        $document->save();
    }

    $form = new DocumentAddForm($document, array());
    $options['flash']    = "File has been added";
    $options['course_id']= $course_id;

    $form = $this->processForm($form, $request, $options);

    $this->form    = $form;
    $this->courses = $user->getCourseList();
    $this->isDocument = true;
    $this->document_id = $document->getId();

    $docCourseId = 0;
    if ($user){
        $course_list = $user->getCourseList();
        if ($course_list) {
            foreach ($course_list as $record) {
                $docCourseId = $record->getId();
                break;
            }
        }
    }
    $this->first_document_id = $docCourseId;

    $this->getResponse()->setTitle('WikiDocuments');
  }

  public function executeList(sfWebRequest $request){
    $this->autopager = new AutoPager(array('recs_per_page' => 5));
    $pageNum = $request->getParameter('page', 1);   // grab and set page number
    $this->autopager->setPageNum($pageNum);

    $documents = $this->getDocumentList($request);

    $this->documents = $documents;
    $this->courseId  = $request->getParameter('slug');
    $this->executeIndex($request);

    /*
    return $this->renderPartial('document/list', array(
        'documents' => $documents,
        'autopager' => $this->autopager
    ));
    */
  }

  protected function updateListDocument() {
      // while download documents
    $q = Doctrine::getTable('Document')->createQuery('d')
            ->where('d.deleted_at is null');
    $result = $q->fetchArray();

    // s:4:"post";
    foreach ($result as $value) {
        $courseId = $value['course_id'];
        $userId   = $value['user_id'];
        $content  = $value['description'];
        $name     = $value['name'];
        $created_at = $value['created_at'];

        $bAccess = true;
        $q = Doctrine::getTable('post')->createQuery('p')
            ->andWhere('p.object_id = ?', $courseId)
            ->andWhere("p.object_name = 'Course'")
            ->andWhere('p.attachment_id = ?',  $value['id'])
            ->andWhere('p.ftype = 1');
        $res = $q->fetchArray();
        if (count($res) > 0) { $bAccess = false; }

        //$url = "uploads/document/course/".$courseId."/".$value['file'];
        $url = @document_download;
        $params = array();
        $params['slug'] = $value['id'];
        $this->generateUrl($url, $params);
        $url = $this->generateUrl($url, $params);
//        $url = "/download-document/".$value['id'];

        if($bAccess) {
            // add record in post table
            $ext = $this->get_file_extension($value['file']);
            if (!$ext) { $ext = ''; }
            else $ext = '.'.$ext;
            $tmp = $name.''.$ext;
            //$content = "[H3]".$name.''.$ext."[/H3]".$content;

            $post = new Post();
            $post->setAttachmentId($value['id']);
            $post->setAttachmentUrl($url);
            $post->setCountLike(0);
            $post->setContent($content);
            $post->setEveryone(0);
            $post->setIsPinned(0);
            $post->setObjectId($courseId);
            $post->setObjectName('Course');
            $post->setUserId($userId);
            $post->setFtype(1);
            $post->setFtext($tmp);
            $post->save();

            $notification = new Notification();
            $notification->setObjectId($post->getId());
            $notification->setObjectName('Post');
            $notification->setRelatedObjectId($courseId);
            $notification->setRelatedObjectName('Course');
            $notification->setType('Classmate');
            $notification->setAction('Add');
            $notification->save();

            $userNotif = new \UserNotification();
            $userNotif->setIsSeen(0);
            $userNotif->setUserId($userId);
            $userNotif->setNotificationId($notification->getId());
            $userNotif->save();

            // send mail
            /*$user = $this->getUser()->getGuardUser();
            $profile = $user->getSfGuardUserProfile();
            if(!$profile->getEmailFrom()){
                $mailer = sfContext::getInstance()->getMailer();
                $email_subject = "New document";
                $email_body = get_partial('notification/document_email', array(
                    'user_first_name' => $user->getFirstName(),
                    'post' => $activityObject
                ));
                $address = sfConfig::get('app_address_noreply');
                $email   = $user->getEmailAddress();
                $message = $mailer->compose($address,
                          $email,
                          $email_subject,
                          $email_body
                );
                $message->setContentType("text/html");
                $mailer->send($message);
            }*/
        }
    }
  }

  public function get_file_extension($file_path) {
        $basename = basename($file_path); // получение имени файла
        if ( strrpos($basename, '.')!==false ) { // проверка на наличии в имени файла символа точки
            // вырезаем часть строки после последнего символа точки в имени файла
            $file_extension = substr($basename, strrpos($basename, '.')+1);
        } else {
            // в случае отсутствия символа точки в имени файла возвращаем false
            $file_extension = false;
        }
        return $file_extension;
    }

  protected function getDocumentList(sfWebRequest $request) {

      // create post document in post block
      //$this->updateListDocument();

    // note: for $this->autopager->setBaseLink()... this should match the routes used for the tabs (see modules/document/templates/_nav.php)
      $type = $request->getParameter('type');
      if($type == "course"){
          $this->forward404Unless($slug = $request->getParameter('slug'));
          $this->forward404Unless($course = CourseTable::getCourseBySlug($slug));

          $this->autopager->setBaseLink('@document_course_list?type=course&slug='.$course->getId().'|'.Utils::slugify($course->getName()));



          $recCount = DocumentTable::getDocumentListBy($course, array('return_count'=>true));
          $this->autopager->setRecCount($recCount);

          $documents = DocumentTable::getDocumentListBy($course, array(
            'offset'        => $this->autopager->getOffset(),
            'recs_per_page' => $this->autopager->getRecsPerPage()
          ));

      } elseif ($type == 'my') {
          $user = $this->getUser()->getGuardUser();
          $this->autopager->setBaseLink('@document_list?type=my');

          $recCount = DocumentTable::getDocumentListBy($user, array('return_count'=>true));
          $this->autopager->setRecCount($recCount);
          $documents = DocumentTable::getDocumentListBy($user, array(
            'offset'        => $this->autopager->getOffset(),
            'recs_per_page' => $this->autopager->getRecsPerPage()
          ));

      } else {
          $user = $this->getUser()->getGuardUser();
          $this->autopager->setBaseLink('@document_list?type=all');

          $school = $user->getMainSchool();

          $recCount = DocumentTable::getDocumentListBy($school, array('return_count'=>true));

          $this->autopager->setRecCount($recCount);
          $documents = DocumentTable::getDocumentListBy($school, array(
            'offset'        => $this->autopager->getOffset(),
            'recs_per_page' => $this->autopager->getRecsPerPage()
          ));
      }

      return $documents;
  }
};
