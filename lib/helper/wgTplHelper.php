<?php
    function truncateString($str, $numChars) {
        if(strlen($str)<=$numChars) {
            return $str;
        }
        return substr($str, 0, $numChars).'&hellip;';
    }

    function makeClickableLinks($text) {
        $text = preg_replace('/((<!<img src=")((f|ht){1}(tp:|tps:)\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" target="_blank">\\1</a>', $text);
        $text = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2" target="_blank">\\2</a>', $text);
        $text = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" target="_blank">\\1</a>', $text);
        $text = str_replace("\n", "<br/>", $text);
        return $text;
    }

    // return position
    function getNextPos($text, $tag, $begPos, $count, $startCount = 0) {
        $begPos = strpos($text, $tag, $begPos);
        if ($begPos === false) { return -1; }
        $startCount++;
        if ($startCount == $count) return $begPos;
        $begPos += strlen($tag);
        return getNextPos($text, $tag, $begPos, $count, $startCount);
    }

    function checkUrl($url) {
        if (filesize($url) > 0) return true;
        return false;
    }
    
    function getFxPos($content) {
        
        $fx_start_pos = strpos($content, '<div class="wg-fx-field">');
        $fx_end_pos = strpos($content, '</div>');
        
        $fx_length = $fx_end_pos - $fx_start_pos;
        
        $fxPos[0] = $fx_start_pos;
        $fxPos[1] = $fx_end_pos;
        $fxPos[2] = $fx_length;
        
        return $fxPos;
    }
    
    function getFx($content) {
//
//        $decodedContent = htmlspecialchars_decode($content);
//        $matches = array();
//
//        preg_match_all("/<img.*class=\"latex\".*\/>/isU", $decodedContent, $matches);
//
//        if( count($matches[0]) > 0 ){
//            $rebuildedContent = "";
//            $startPos = 0;
//            $endPos = 0;
//            foreach($matches[0] as $match) {
//                $endPos = strpos($decodedContent, $match, $startPos);
//                $part = substr($decodedContent, $startPos, $endPos-$startPos);
//                $rebuildedContent .= htmlspecialchars ( $part );
//                $rebuildedContent .= $match;
//                $startPos = $endPos + strlen( $match );
//            }
//            $content = $rebuildedContent;
//        }
//
//        return $content;
//        $content = htmlspecialchars_decode($content);
//        
//        $fx_start_pos = strpos($content, '<fx>');
//        if ($fx_start_pos || $fx_start_pos === 0) {
//            $fx_end_pos = strpos($content, '</fx>', $fx_start_pos + 4);
//            if (!$fx_end_pos) {
//                return $content;
//            }
//            $fx_length = $fx_end_pos - $fx_start_pos+3;
//            $fx_replace = substr($content, $fx_start_pos, $fx_length+2);
//            $fx = substr($content, $fx_start_pos + 4, $fx_length - 7);
//            $fx = '<div class="wg-fx-field"><img src="http://latex.codecogs.com/svg.latex?'.$fx.'" alt="'.$fx.'" border="0" class="latex" align="middle" /></div>';
//                if ($fx_start_pos !== 0) { $fx = '<br/>'.$fx; }
//            $content = str_replace($fx_replace, $fx, $content);
//            $content = str_replace("<br/>", "\n", $content);
////            $content = str_replace("lt;", "<", $content);
////            $content = str_replace("gt;", ">", $content);
//            return getFx($content);
//        } else {
//            return $content;
//        }
//        return false;
        $content = htmlspecialchars_decode($content);
        
        $fx_start_pos = strpos($content, '$$');
        if ($fx_start_pos || $fx_start_pos === 0) {
            $fx_end_pos = strpos($content, '$$', $fx_start_pos + 2);
            if (!$fx_end_pos) {
                return $content;
            }
            $fx_length = $fx_end_pos - $fx_start_pos;
            $fx_replace = substr($content, $fx_start_pos, $fx_length + 2);
            $fx = substr($content, $fx_start_pos + 2, $fx_length - 2);
            $fx = '<div class="wg-fx-field"><img src="http://latex.codecogs.com/svg.latex?'.$fx.'" alt="'.$fx.'" border="0" class="latex" align="middle" /></div>';
                if ($fx_start_pos !== 0) { $fx = '<br/>'.$fx; }
            $content = str_replace($fx_replace, $fx, $content);
            $content = str_replace("<br/>", "\n", $content);
            return getFx($content);
        } else {
            return $content;
        }
        return false;
    }

    function getLen($content, $len, $endPos) {
        $fx_start_pos = strpos($content, '$$', $endPos);
        if (($fx_start_pos || $fx_start_pos === 0) && $fx_start_pos < $len) {
            $fx_end_pos = strpos($content, '$$', $fx_start_pos + 1);
            if ($fx_start_pos < $len && $fx_end_pos > $len) {
                $len = $fx_end_pos + 1;
                return $len;
            } elseif ($fx_end_pos < $len) {
                return getLen($content, $len, $fx_end_pos + 1);
            }
        }
        return $len;
    }
    /*
    function checkImg ($url) {
        $server = "http://".$_SERVER["SERVER_NAME"];


        $filename = "";
        if (strpos($url, $server) !== false) {
            $filename = $url;
        } else {
            if ($url[0] != "/") $server .= "/";
            $filename = $server.$url;
        }

        $file_headers = @get_headers($filename);
        if(strpos($file_headers[0], "200", 0)) return true;
        return false;
    }

    function setDefaultFile ($url, $defaultValue) {
        if (!checkImg ($url)) return $defaultValue;
        return $url;
    }*/

    /*function checkNewNotification($courseId, $userId, $type) {
        if ($type == 'Post') {
            $result = Doctrine::getTable('UserCourse')->createQuery('us')
                ->andWhere('us.user_id = ?', $userId)
                ->andWhere('us.course_id = ?', $courseId)
                ->fetchOne();
            if (!$result) {
                $userCourse = new UserCourse();
                $userCourse->setCourseId($courseId);
                $userCourse->setUserId($userId);
                $userCourse->save();

                $notification = new Notification();
                $notification->setObjectId($userCourse->getId());
                $notification->setObjectName('UserCourse');
                $notification->setRelatedObjectId($courseId);
                $notification->setRelatedObjectName('Course');
                $notification->setType('Classmate');
                $notification->setAction('Add');
                $notification->save();
            }
        }
        return false;
    }*/

    function formatDatetime($dt_string, $format = null, $timezone = null) {
        $format = $format ? $format : 'm/d/y h:i A';

        ## Initially using server timezone
        ## so we set the timezone for the datetime to the provided timezone
        ## Note: timestamp value represented by the dateTime object is not modified when you set the timezone
        ## using this method
        if ($timezone) {
            $tz = new DateTimeZone($timezone);
            $date = new DateTime($dt_string);
            $date->setTimezone($tz);

            return $date->format($format);
        }

        return date($format, strtotime($dt_string));
    }

    function getUserThumbnail($user_id, $user_image, $width, $height = 0, $square = false, $absolute = false) {
        if (!$user_id) return "";
        $userProfileImageDir = '/uploads/profile/' . $user_id;
        /**
         * @var $user sfGuardUser
         */
//        $user = sfGuardUserTable::getInstance()->findOneById($user_id);

        if(!$user_image) {
            $file = '/images/default_avatar.png';
        } else {
            $file = $userProfileImageDir . '/' . $user_image;
        }

        $testFile = (__DIR__)."/../../web".$file;
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
            $path = $file; #:/
        }

        return $path;
    }
?>
