<?php

/**
 * PluginsfGuardUser form.
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage filter
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: PluginsfGuardUserFormFilter.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
abstract class PluginsfGuardUserFormFilter extends BasesfGuardUserFormFilter
{
     public function getFields() {
        $fields = parent::getFields();
        //the right 'virtual_column_name' is the method to filter
        $fields['is_staff'] = 'is_staff';
        return $fields;
    }
    
    public function addIsStaffColumnQuery($query, $field, $value) {
        //add your filter query!
        //for example in your case
        $rootAlias = $query->getRootAlias();
        $query->innerJoin($rootAlias.'.sfGuardUserProfile up')
           ->andWhere('up.is_staff = ?', $value);

        //remember to return the $query!
        return $query;
    }
}
