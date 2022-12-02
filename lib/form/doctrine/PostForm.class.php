<?php

/**
 * Post form.
 *
 * @package    sf_sandbox_old
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PostForm extends BasePostForm
{
  public function configure()
  {
        $fields = array(
            'content'
        );

        //Only add course_id
        if($include_course = $this->getOption('include_course')){

            $fields[] = 'course_id';

            $default_course = is_numeric($include_course) ? $include_course : '';

            $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array(
                'choices' => array(''=> 'Select One') + $this->getObject()->getUser()->getFormattedCourseList(),
                'default' => $default_course
            ));

            $this->validatorSchema['course_id'] = new sfValidatorChoice(array(
                'choices' => array_keys($this->getObject()->getUser()->getFormattedCourseList()),
                'required' => true
            ));

            $type_choices = array(
                Notification::FRIEND_TYPE => 'Friends Only',
                Notification::CLASSMATE_TYPE => 'Classmates'
            );

            $fields[] = 'type';

            $this->widgetSchema['type'] = new sfWidgetFormChoice(array(
                    'choices' => $type_choices,
                    'expanded' => true,
                    'default' => Notification::CLASSMATE_TYPE
            ));

            $this->validatorSchema['type'] = new sfValidatorChoice(array(
                'choices' => array_keys($type_choices),
                'required' => true
            ));
        }
        $this->useFields($fields);
        $this->widgetSchema['content'] = new sfWidgetFormTextarea();
        $this->validatorSchema['content'] = new sfValidatorString(array('required' => true));
    }
}
