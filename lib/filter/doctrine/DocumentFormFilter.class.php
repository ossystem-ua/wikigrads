<?php

/**
 * Document filter form.
 *
 * @package    sf_sandbox_old
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DocumentFormFilter extends BaseDocumentFormFilter
{
  public function configure()
  {
    # school_id
    $this->widgetSchema['school_id'] = new sfWidgetFormDoctrineChoice(array(
        'model' => 'School',
        'add_empty' => 'School'
    ));

    $this->validatorSchema['school_id'] = new sfValidatorDoctrineChoice(
        array(
            'model' => 'School',
            'required' => true
        ),
        array(
            'required' => 'Please select your school'
        )
    );
  }
  
  public function getFields()
  {
    $fields = parent::getFields();
    //the right 'virtual_column_name' is the method to filter
    $fields['school_id'] = 'school_id';
    return $fields;
  }  
  
  public function addSchoolIdColumnQuery($query, $field, $value)
  {
    $rootAlias = $query->getRootAlias();
  
    $query->leftJoin($rootAlias . '.Course c')
            ->leftJoin('c.Department d')
            ->addWhere('d.school_id = ? ', $value )
            ;

    return $query;
  }  

  
  
  
  
}
