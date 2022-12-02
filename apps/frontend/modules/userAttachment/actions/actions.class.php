<?php

/**
 * uploads actions.
 *
 * @package    sf_sandbox_old
 * @subpackage uploads
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userAttachmentActions extends myActions
{
    private function checkImageFile(array $val, array $img) {
        $arrExt = array('jpg', 'jpeg', 'png', 'gif');
        $checkExt = in_array($img["ext"], $arrExt);

        if (empty($val["tmp_name"]) || !getimagesize($val["tmp_name"])) {
            $img["error"] = 1;
            $img['message'] = 'The download file is not an image';
        } else {
            $checkImage = getimagesize($val["tmp_name"]);
            if (!($checkImage['mime'] === $val['type'])) {
                $img["error"] = 1;
                $img['message'] = 'Error file type';
            }
            if (!$checkExt) {
                $img["error"] = 1;
                $img['message'] = 'Error file extension';
            }
        }
        return $img;
    }
    
    public function executeDelattach(sfWebRequest $request) {
        
        $user = $this->getUser();
        
        $arr = array();
        $arr['type'] = $request->getParameter('type');
        $arr['attachId'] = intval($request->getParameter('attachId'));
        $arr['msg'] = 'Deleted';
        $arr['status'] = 0;
        $arr['object'] = null;

        if (!$user == null || !$user->isAuthenticated()) {
            $arr['attachId'] = 0;
        } else {
            $userId = (int)$user->getGuardUser()->getId();
            $session_documents = new sfSessionStorage();
        }
        
        if ($arr['attachId'] > 0) {
            switch ($arr['type']) {
                case "document": {
                    $attachTable = 'Document';
                    $attachSession = 'documentId';
                }break;
                case "image": {
                    $attachTable = 'UserAttachment';
                    $attachSession = 'imageId';
                }break;
                default: { $arr['msg'] = 'Unknown type: '.$arr['type']; $arr['status'] = 1; }break;
            }
            
            $result = Doctrine_Core::getTable($attachTable)->findOneById($arr['attachId']);
            if ($userId !== (int)$result->getUserId()) {
                $arr['msg'] = 'Permission denied';
                $arr['status'] = 1;
            } else {
                $result->delete();
                $arr['object'] = $result;
                $session_documents->remove($attachSession);
            }
            
        } else {
            $arr['msg'] = 'Unknown attachment id: '.$arr['attachId'];
            $arr['status'] = 1;
        }
        
        echo json_encode($arr);
    }

    public function executeGetattach(sfWebRequest $request) {
        
        $arr = array();
        $arr['type'] = $request->getParameter('type');
        $arr['attachId'] = intval($request->getParameter('attachId'));
        $arr['msg'] = '';
        $arr['name'] = '';
        $arr['status'] = 0;
        $arr['object'] = null;
        
        if ($arr['attachId'] > 0) {
            switch ($arr['type']) {
                case "document": {
                    $q = Doctrine::getTable('Document')->createQuery('d')
                        ->andWhere('d.id = ?', $arr['attachId']);
                    $result = $q->fetchOne();
                    $arr['name'] = $result['name'];
                    $arr['object'] = $result;
                }break;
                case "image": {
                    $q = Doctrine::getTable('UserAttachment')->createQuery('ua')
                        ->andWhere('ua.id = ?', $arr['attachId']);
                    $result = $q->fetchOne();
                    $arr['name'] = $result['file'];
                    $arr['object'] = $result;
                }break;
                default: { $arr['msg'] = 'Unknown type: '.$arr['type']; $arr['status'] = 1; }break;
            }
        } else {
            $arr['msg'] = 'Unknown attachment id: '.$arr['attachId'];
            $arr['status'] = 1;
        }

        echo json_encode($arr);
    }

    public function executeLoaddoc(sfWebRequest $request) {
        $maxFileSize = sfConfig::get('app_sf_guard_plugin_max_file_size');
        $user = $this->getUser()->getGuardUser();
        $files    = $request->getFiles();
        $courseId = $request->getParameter('course_id');
        $userId   = $user->getId();
        $name     = $request->getParameter('name');

        $description = $request->getParameter('description');
        $def_dir  = (__DIR__)."/../../../../../web/uploads/document/course/".$courseId."/";
        $arr = array();
        foreach ($files as $file) {
            if (!is_dir($def_dir)) mkdir ($def_dir);
            if (is_dir($def_dir)) {
//                $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
                $arr['name'] = $file["name"];
                $fileName = md5($file['name'].time().mt_rand(0, 9999));
                $originalName = $file["name"];
                $filename = $def_dir."/".$fileName;
                if (file_exists($filename)){
//                    $fl_name = time();
                    $fl_name = md5($fileName.time().mt_rand(0, 9999));
//                    $file["name"] = $fl_name.".".$ext;
                    $filename = $def_dir."/".$fl_name;
                }
                if (filesize($file["tmp_name"]) !== false && filesize($file["tmp_name"]) < $maxFileSize) {
                    if (move_uploaded_file ($file["tmp_name"], $filename)) {
                        if ($name == "Document name" || $name == '')
                            $name = $originalName;
                        if ($description == "Brief description")
                            $description = "";
                        $document = new Document();
                        $document->setName($name);
                        $document->setDescription($description);
                        $document->setUserId($userId);
                        $document->setCourseId($courseId);
                        $document->setFile(basename($filename));
                        $document->save();
                        $document->setDate($document->getCreatedAt());
                        $document->save();
                        $arr['id'] = $document->getId();
                        
                        $session_document = new sfSessionStorage();
                        $session_document->write('documentId', $arr['id']);
                        
                    } else $arr['msg'] = 'error move file';
                } else $arr['msg'] = 'error limit max size';
            } else {
                $arr['msg'] = 'error directory';
            }
        }
        echo json_encode($arr);
        return "None";
    }

    public function executeIndex(sfWebRequest $request)
    {
        $maxFileSize = sfConfig::get('app_sf_guard_plugin_max_file_size');
        $user = $this->getUser()->getGuardUser();
        $hostName = $request->getHost();
        // load and add new attachment
        $files = $request->getFiles();
        $def_dir = (__DIR__)."/../../../../../web/images/uploads";
        $arr     = array();
        $img     = array();
        
        foreach ($files as $val) {
            if (is_dir($def_dir)) {
                $ext = pathinfo($val["name"], PATHINFO_EXTENSION);
                $name = time();
                $filename = $def_dir."/".$name.".".$ext;
                $img["original_name"] = $val["name"];
                $img["ext"]           = $ext;
                $img["name"]          = $name;
                $img["url"]           = "http://".$hostName."/images/uploads/".$name.".".$ext;
                $img["error"]         = 0;
                $img["id"]            = 0;
                if (file_exists($filename)){
                    unlink($filename);
                }
                
                $img[] = $this->checkImageFile($val, $img);
                
                if (filesize($val["tmp_name"]) !== false && 
                    filesize($val["tmp_name"]) < $maxFileSize &&
                    $img['error'] !== 1
                   ) {
                    
                    if (move_uploaded_file ($val["tmp_name"], $filename)) {
                        $record = new UserAttachment();
                        $record->setName($img["name"])
                           ->setFile($img["original_name"])
                           ->setUrl($img["url"])
                           ->setUserId($user->getId());
                        $record->save();
                        
                        $img["id"] = $record->getIncremented();

                        $session_document = new sfSessionStorage();
                        $session_document->write('imageId', $img["id"]);
                    } else {
                        $img["error"] = 1;
                    }
                } else {
                    $img["error"] = 1;
                    if (filesize($val["tmp_name"]) === false)
                        $img["message"] = "Error upload file size";
                    else
                        $img["message"] = "Maximum file size 100M";
                }
                $arr[] = $img;
            }
        }

        if (count($arr) <= 0) {
            $img["error"] = 1;
            $img["files"] = $files;
            $img["dir"]   = $def_dir;
            $img["rights"] = substr(decoct(fileperms($def_dir)), -3);
            $arr[] = $img;
        }
        foreach ($arr as $val) {
            if ($val["error"] == 1) {
                $this->getUser()->setFlash('error', $val["message"]);
            }
        }
        echo json_encode($arr);
    }
}
