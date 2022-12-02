<?php

class Utils
{
    public static function pfa($array)
    {
        echo '<pre>';
        if(is_array($array)) {
            print_r($array);
        } else {
            var_dump($array);
        }
        echo '</pre>';
    }

    public static function dlog($msg) {
        $log = sfContext::getInstance()->getLogger();
        $log->debug($msg);
    }

    /**
    * Returns option value if set, otherwise false.
    *
    * @param mixed $options
    * @param mixed $key
    * @param mixed $default - if value is not present, this will be returned
    */
    public static function getOptionValue($options, $key, $default = false) {
        $val = (isset($options[$key]) && $options[$key]) ? $options[$key] : $default;
        return $val;
    }

    public static function slugify($text)
    {
        $text = preg_replace('#[^a-zA-Z0-9]+#', '-', $text);

        $text = trim($text);

        $text = strtolower($text);

        return $text;
    }

    /**
     * Doctrine Query to SQL
     *
     * This translates a Doctrine_Query object into human readable sql
     *
     * @param Doctrine_Query $query
     * @param unknown_type $truncate_select
     * @param unknown_type $newline
     * @return unknown
     */
    public static function dq_to_sql(Doctrine_Query $query, $truncate_select = false, $newline = '<br />')
    {
        $mysql_keywords = array(
            'SELECT',
            'FROM',
            'LEFT JOIN',
            'WHERE',
            'AND',
            'OR',
            'ORDER BY',
            'GROUP BY',
            'HAVING',
            'LIMIT'
        );

        # clone the query so the object is not updated - since php passes objects by reference
        $sql = clone $query;

        # get a flattened list of parameters to iterate over - prepared statement parameters
        $params = $sql->getFlattenedParams();
        $sql = $sql->getSqlQuery();

        # update the query with the proper parameters
        foreach ($params as $param) {
            $sql = preg_replace('#[\?]#', "'".$param."'", $sql, 1);
        }

        # find all mysql_keywords that were used in the statement
        preg_match_all('#'.join('|', $mysql_keywords).'#', $sql, $matches);
        $keywords = $matches[0];

        # if enabled -truncate the select statement to seelct *
        if ($truncate_select) {
            $sql = preg_replace('#(SELECT).*?(FROM)#', '${1} * ${2}', $sql, 1);
        }

        # format the query
        for ($i = 0; $i < count($keywords); $i++) {
            $sql = preg_replace('#[\s]{1,}?'.$keywords[$i].'#', $newline.$keywords[$i], $sql);
        }

        echo $sql;
    }

    public static function sanitizeFileName($string = ''){
      // Replace all weird characters with dashes
      $string = preg_replace("/[^a-z0-9]\./", " ", strtolower($string));

      // Only allow one dash separator at a time
      return preg_replace('/__+/u', '_', $string);

    }

    public static function thumbnail_path($source, $thumb_path, $options = array())
    {
    	sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

    	$width = isset($options['width']) ? intval($options['width']) : 100;
    	$height = isset($options['height']) ? intval($options['height']) : 100;
    	$absolute = isset($options['absolute']) ? $options['absolute'] : false;
    	$square = isset($options['square']) ? $options['square'] : false;

		if (substr($source, 0, 1) == '/') {
			$realpath = sfConfig::get('sf_web_dir') . $source;
		} else {
			$realpath = sfConfig::get('sf_web_dir') . '/images/' . $source;
		}

		$thumb_name = preg_replace('/^(.*?)(\..+)?$/', '$1_' . $width . 'x' . $height . '$2', basename($source));

		$img_from = $realpath;
		$thumb = $thumb_path . '/' . $thumb_name;

		$img_to = sfConfig::get('sf_web_dir') . $thumb;

                if (!is_dir(dirname($img_to))) {
			if (!mkdir(dirname($img_to), 0777, true)) {
				throw new Exception('Cannot create directory for thumbnail : ' . $img_to);
			}
		}

		if (!is_file($img_to) || filemtime($img_from) > filemtime($img_to)) {
			$thumbnail = new sfThumbnail($width, $height, true, false, 100, 'sfGDAdapter', array(
				'square' => $square
			));

			$thumbnail->loadFile($img_from);
			$thumbnail->save($img_to);
		}

		return image_path($thumb, $absolute);
	}

    public static function getUserProfileImageDirectory($user_id) {
        return '/uploads/profile/' . $user_id;
    }

    public static function getFormStatus($form) {
        // form/request status
        $formErrors = array();
        foreach($form->getErrorSchema()->getErrors() as $field=>$e) {
            $formErrors[$field] = $e->__toString();
        }
        $globalErrors = array();
        foreach($form->getGlobalErrors() as $name=>$e) {
            $globalErrors[$name] = $e;
        }

        $formStatus = array(
            'is_success'    =>  $form->isValid(),
            'form_errors'   =>  $formErrors,
            'global_errors' =>  $globalErrors
        );

        return $formStatus;
    }
}