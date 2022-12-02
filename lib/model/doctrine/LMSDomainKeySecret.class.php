<?php

/**
 * LMSDomainKeySecret
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Wikigrads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class LMSDomainKeySecret extends BaseLMSDomainKeySecret
{
    public function getDomainName($schoolId) {
        $school = Doctrine_core::getTable('School')->createQuery('s')
                ->select("s.name, s.lms_domain")
                ->where("s.id = ?", $schoolId)
                ->fetchOne();
        if ($school instanceof School) {
            return $domainName = $school->getName()." (".$school->getLmsDomain().")";
        } else {
            return NULL;
        }
    }
}