<?php

/**
 * UserSchool
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf_sandbox_old
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class UserSchool extends BaseUserSchool
{
    public function getMajorOrPrimaryDepartmentName()
    {
        if (!isset($this->major) || !$this->major) {
            if ($this->getPrimaryDepartmentId()) {
                return $this->getPrimaryDepartment()->getName();
            } else {
                return false;
            }
        } else {
            return $this->major;
        }
    }
}
