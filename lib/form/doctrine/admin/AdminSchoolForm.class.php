<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rbarona
 * Date: 4/8/13
 * Time: 2:38 PM
 * To change this template use File | Settings | File Templates.
 */
class AdminSchoolForm extends BaseSchoolForm
{
    public function configure () {

        $this->useFields(array(
            'name',
            'twitter_list',
            'first_friend_id',
            'timezone'
        ));

        $this->setWidget('timezone', new sfWidgetFormI18nChoiceTimezone());
        $this->setValidator('timezone', new sfValidatorString());

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');        
        $this->widgetSchema['default_user_image'] = new sfWidgetFormInputFileEditable(array(
            'file_src' => image_path('/uploads/default_profile/' . $this->getObject()->getDefaultUserImage()),
            'edit_mode' => true,
            'is_image' => true,
            'with_delete' => false,
        ));
        $this->validatorSchema['default_user_image'] = new sfValidatorFile(array(
            'path' => sfConfig::get('sf_upload_dir') . '/default_profile/',
            'mime_types' => 'web_images',
            'required' => false,
        ));
    }
}
