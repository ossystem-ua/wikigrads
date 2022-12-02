<?php

class DocumentAddForm extends DocumentForm
{
    protected $course = null;
    protected $user = null;
    
    public function configure()
    {
 
        $fields = array(
            'file',
            'course_id',
            'description',
            'date',
            'name'
        );
                
        $this->useFields($fields);
        	
        $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array(
                        'choices' => array(''=> 'Select a Class') + $this->getObject()->getUser()->getFormattedCourseList(),
                ));
	
    	$this->validatorSchema['course_id'] = new sfValidatorChoice(array(
			'choices' => array_keys($this->getObject()->getUser()->getFormattedCourseList()),
			'required' => true
		));
        
        # file
        $this->widgetSchema['file'] = new sfWidgetFormInputFile();

        $this->validatorSchema['file'] = new ndrValidatorFile(array(
                'mime_types' => $this->getValidMimeTypes(),
	    	'path' => sfConfig::get('sf_upload_dir').'/document/course/'.$this->getObject()->getCourseId(),
	    ),
            array(
                'invalid' => 'Invalid file.',
                'mime_types' => 'Invalid file type.'
            ));

        $this->validatorSchema['file']->setOption('mime_type_guessers', array(
            array($this->validatorSchema['file'], 'guessFromFileinfo'),
            array($this->validatorSchema['file'], 'guessFromFileBinary'),
            array($this->validatorSchema['file'], 'guessFromMimeContentType'),
        ));

        # date
        $this->widgetSchema['date']->setOption('with_time', false);
        
        $this->validatorSchema['date']->setOption('with_time', false);

        $this->validatorSchema['description']->setOption('max_length', 250);
        
        $this->widgetSchema['description']->setDefault('Enter a description of the document');
        
        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'compareDefaultString'))));
        

    }
    
    
    public function generateFileFilename($file = null)
    {
        if (null === $file) {
          // use a random filename instead
          return null;
        }

        if (file_exists($file->getpath().$file->getOriginalName())) {
           return $this->appendToName($file);
        }
        
        $path_parts = pathinfo($file->getOriginalName());

        $extension = $path_parts['extension'];
        $file_name = Utils::sanitizeFileName($path_parts['filename']);
      
        
        //Set file name
        $this->getObject()->setName($file_name);
        
        return time().'-'.$this->getObject()->getUserId().'-'.$file_name.'.'.$extension;
    }
    
    
    protected function getValidMimeTypes(){
        return array(
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/tiff',
            'image/x-png',
            'image/gif',
            'application/msword',
            'application/excel',
            'application/octet-stream',
            'application/pdf',
            'application/powerpoint',
            'application/vnd.ms-excel',
            'text/plain',
            'text/rtf',
            'text/richtext'
        );
    }



    protected function doUpdateObject($values)
    {
          
        parent::doUpdateObject($values);
        
        $this->getObject()->setDate(date("Y-m-d H:i:s"));
    }
    
    public function compareDefaultString($validator, $values)
    {
      // if the field "name" is not editable, it does not exist in $values
      if (trim($values['description']) == $this->widgetSchema['description']->getDefault())
      {
        $values['description'] = '';
      }
      
      return $values;
    }    
}