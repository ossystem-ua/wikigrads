<?php

class ndrValidatorFile extends sfValidatorFile
{
    static $ignoreMimeForExtensions = array(
        'pptx',
        'docx',
        'xlsx',
        'txt',
        'avi',
        'mp3',
        'zip'
    );
// doc .docx .ppt .pptx .xls .xlsx
  /**
   * This validator always returns a sfValidatedFile object.
   *
   * The input value must be an array with the following keys:
   *
   *  * tmp_name: The absolute temporary path to the file
   *  * name:     The original file name (optional)
   *  * type:     The file content type (optional)
   *  * error:    The error code (optional)
   *  * size:     The file size in bytes (optional)
   *
   * @see sfValidatorBase
   */
  protected function doClean($value)
  {
    if (!is_array($value) || !isset($value['tmp_name']))
    {
      throw new sfValidatorError($this, 'invalid', array('value' => (string) $value));
    }

    if (!isset($value['name']))
    {
      $value['name'] = '';
    }

    if (!isset($value['error']))
    {
      $value['error'] = UPLOAD_ERR_OK;
    }

    if (!isset($value['size']))
    {
      $value['size'] = filesize($value['tmp_name']);
    }

    if (!isset($value['type']))
    {
      $value['type'] = 'application/octet-stream';
    }

    switch ($value['error'])
    {
      case UPLOAD_ERR_INI_SIZE:
        $max = ini_get('upload_max_filesize');
        if ($this->getOption('max_size'))
        {
          $max = min($max, $this->getOption('max_size'));
        }
        throw new sfValidatorError($this, 'max_size', array('max_size' => $max, 'size' => (int) $value['size']));
      case UPLOAD_ERR_FORM_SIZE:
        throw new sfValidatorError($this, 'max_size', array('max_size' => 0, 'size' => (int) $value['size']));
      case UPLOAD_ERR_PARTIAL:
        throw new sfValidatorError($this, 'partial');
      case UPLOAD_ERR_NO_TMP_DIR:
        throw new sfValidatorError($this, 'no_tmp_dir');
      case UPLOAD_ERR_CANT_WRITE:
        throw new sfValidatorError($this, 'cant_write');
      case UPLOAD_ERR_EXTENSION:
        throw new sfValidatorError($this, 'extension');
    }

    // check file size
    if ($this->hasOption('max_size') && $this->getOption('max_size') < (int) $value['size'])
    {
      throw new sfValidatorError($this, 'max_size', array('max_size' => $this->getOption('max_size'), 'size' => (int) $value['size']));
    }

    $mimeType = $this->getMimeType((string) $value['tmp_name'], (string) $value['type']);


    // check mime type
    if ($this->hasOption('mime_types'))
    {
      $mimeTypes = is_array($this->getOption('mime_types')) ? $this->getOption('mime_types') : $this->getMimeTypesFromCategory($this->getOption('mime_types'));
      if (!in_array($mimeType, array_map('strtolower', $mimeTypes)))
      {
          $extension = pathinfo($value['name'], PATHINFO_EXTENSION);
          if (in_array($extension, self::$ignoreMimeForExtensions)) {
              $mimeType = 'application/msword';
          } else {
              throw new sfValidatorError($this, 'mime_types', array('mime_types' => $mimeTypes, 'mime_type' => $mimeType));
          }

      }
    }

    $class = $this->getOption('validated_file_class');

    return new $class($value['name'], $mimeType, $value['tmp_name'], $value['size'], $this->getOption('path'));
  }

  /**
   * Returns the mime type of a file.
   *
   * This methods call each mime_type_guessers option callables to
   * guess the mime type.
   *
   * This method always returns a lower-cased string as mime types are case-insensitive
   * as per the RFC 2616 (http://www.w3.org/Protocols/rfc2616/rfc2616-sec3.html#sec3.7).
   *
   * @param  string $file      The absolute path of a file
   * @param  string $fallback  The default mime type to return if not guessable
   *
   * @return string The mime type of the file (fallback is returned if not guessable)
   */
  protected function getMimeType($file, $fallback)
  {
    foreach ($this->getOption('mime_type_guessers') as $method)
    {
      $type = call_user_func($method, $file);

      if (null !== $type && $type !== false)
      {
        return strtolower($type);
      }
    }

    return strtolower($fallback);
  }

  /**
   * Guess the file mime type with PECL Fileinfo extension
   *
   * @param  string $file  The absolute path of a file
   *
   * @return string The mime type of the file (null if not guessable)
   */
  protected function guessFromFileinfo($file)
  {
    if (!function_exists('finfo_open') || !is_readable($file))
    {
      return null;
    }

    if (!$finfo = new finfo(FILEINFO_MIME))
    {
      return null;
    }

    $type = $finfo->file($file);

    // remove charset (added as of PHP 5.3)
    if (false !== $pos = strpos($type, ';'))
    {
      $type = substr($type, 0, $pos);
    }

    return $type;
  }

  /**
   * Guess the file mime type with mime_content_type function (deprecated)
   *
   * @param  string $file  The absolute path of a file
   *
   * @return string The mime type of the file (null if not guessable)
   */
  protected function guessFromMimeContentType($file)
  {
    if (!function_exists('mime_content_type') || !is_readable($file))
    {
      return null;
    }

    return mime_content_type($file);
  }

  /**
   * Guess the file mime type with the file binary (only available on *nix)
   *
   * @param  string $file  The absolute path of a file
   *
   * @return string The mime type of the file (null if not guessable)
   */
  protected function guessFromFileBinary($file)
  {
    ob_start();
    //need to use --mime instead of -i. see #6641
    passthru(sprintf('file -b --mime %s 2>/dev/null', escapeshellarg($file)), $return);
    if ($return > 0)
    {
      ob_end_clean();

      return null;
    }
    $type = trim(ob_get_clean());

    if (!preg_match('#^([a-z0-9\-]+/[a-z0-9\-.]+)#i', $type, $match))
    {
      // it's not a type, but an error message
      return null;
    }

    return $match[1];
  }

  protected function getMimeTypesFromCategory($category)
  {
    $categories = $this->getOption('mime_categories');

    if (!isset($categories[$category]))
    {
      throw new InvalidArgumentException(sprintf('Invalid mime type category "%s".', $category));
    }

    return $categories[$category];
  }

  /**
   * @see sfValidatorBase
   */
  protected function isEmpty($value)
  {
    // empty if the value is not an array
    // or if the value comes from PHP with an error of UPLOAD_ERR_NO_FILE
    return
      (!is_array($value))
        ||
      (is_array($value) && isset($value['error']) && UPLOAD_ERR_NO_FILE === $value['error']);
  }
}
