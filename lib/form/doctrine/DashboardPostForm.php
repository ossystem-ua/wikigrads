<?php

/**
 * Dashboard Post Form.
 *
 */
class DashboardPostForm extends BasePostForm
{

    public function configure()
    {
        $fields = array(
            'content',
            'course_id',
            'type',
            'is_pinned',
            'attachment_id',
            'attachment_url',
            'everyone',
            'document_id'
        );

        // COURSE ID
        $default_course = $this->getOption('default_course');
        $course_choices = array('' => '') + $this->getObject()->getUser()->getFormattedCourseList();
        $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array(
            'choices' => $course_choices,
            'default' => $default_course,
        ));

        $this->validatorSchema['course_id'] = new sfValidatorChoice(array(
            'choices' => array_keys($course_choices),
            'required' => false
        ));

        // TYPE
        $type_choices = array(
            Notification::FRIEND_TYPE       => 'Friends Only',
            Notification::CLASSMATE_TYPE    => 'Classmates'
        );
        $this->widgetSchema['type'] = new sfWidgetFormChoice(array(
            'choices' => $type_choices,
            'expanded' => true,
            'default' => Notification::CLASSMATE_TYPE
        ));

        $this->validatorSchema['type'] = new sfValidatorChoice(array(
            'choices' => array_keys($type_choices),
            'required' => true
        ));

        // CONTENT
        $this->widgetSchema['content'] = new sfWidgetFormTextarea();
        $this->validatorSchema['content'] = new sfValidatorString(array('required' => true));

        // PIN
        $this->validatorSchema['is_pinned'] = new sfValidatorBoolean(array('required' => false));

        // ATTACHMENT_ID
        $this->validatorSchema['document_id'] = new sfValidatorInteger(array('required' => false));
        $this->validatorSchema['attachment_id'] = new sfValidatorInteger(array('required' => false));
        $this->validatorSchema['attachment_url'] = new sfValidatorString(array('required' => false));

        // GENERAL SETUP
        $this->useFields($fields);
        $this->widgetSchema->setNameFormat('post[%s]');

        //embed LinkData form to the Post form
        $this->embedRelation("LinkData");
    }

    public function saveEmbeddedForms($con = null, $forms = null)
    {
        if (null == $forms) {
            $linkData = $this->getValue('LinkData');
            $forms = $this->embeddedForms;
            foreach ($this->embeddedForms['LinkData'] as $name => $form) {
                if (!isset($linkData[$name])) {
                    unset($forms['LinkData'][$name]);
                }
            }
        }

        if( 0 === count($forms['LinkData'])) {
            unset( $forms['LinkData']);
        }

        return parent::saveEmbeddedForms($con, $forms);
    }

}
