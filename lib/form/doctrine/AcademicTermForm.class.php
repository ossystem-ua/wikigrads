<?php

/**
 * AcademicTerm form.
 *
 * @package    sf_sandbox_old
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AcademicTermForm extends BaseAcademicTermForm
{
  public function configure()
  {
      $this->useFields(array(
          'term',
          'year',
          'is_active',
      ));
  }
}
