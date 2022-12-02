<?php
/**
 * LinkDataValidatorSchema
 *
 * This class checked data from the LinkData form
 *
 */
class LinkDataValidatorSchema extends sfValidatorSchema
{

    protected function configure($options = array(), $messages = array())
    {
        $this->addMessage('url', 'The url is required.');
        $this->addMessage('title', 'The title is required.');
        $this->addMessage('host', 'The host is required.');
    }

    protected function doClean($value)
    {
        $errorSchema = new sfValidatorErrorSchema($this);
        $errorSchemaLocal = new sfValidatorErrorSchema($this);
        if( !$value['url'] && !$value['title'] && !$value['host'] ){
            unset($value['url']);
            unset($value['title']);
            unset($value['host']);
            unset($value['img']);
            unset($value['description']);
        } else {
            if (!$value['url']) {
                $errorSchemaLocal->addError(new sfValidatorError($this, 'required'), 'url');
            }

            if(!$value['title']) {
                $errorSchemaLocal->addError(new sfValidatorError($this, 'required'), 'title');
            }

            if(!$value['host']) {
                $errorSchemaLocal->addError(new sfValidatorError($this, 'required'), 'host');
            }
        }
        // this form contains some errors
        if(count($errorSchemaLocal)) {
            $errorSchema->addError($errorSchemaLocal);
        }

        // transfer error to the main form
        if(count($errorSchema)) {
            throw new sfValidatorErrorSchema($this, $errorSchema);
        }

        return $value;
    }

}
