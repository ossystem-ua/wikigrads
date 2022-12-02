<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserAdminForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm
{
  /**
   * @see sfForm
   */
  public function configure() {
    parent::configure();
    $profileForm = new sfGuardUserProfileForm($this->object->sfGuardUserProfile);
    unset($profileForm['id'], $profileForm['sf_guard_user_id']);
    unset($profileForm['user_id'], $profileForm['sf_guard_user_id']);
    unset($profileForm['image'], $profileForm['sf_guard_user_id']);
    unset($profileForm['about'], $profileForm['sf_guard_user_id']);
    unset($profileForm['activity'], $profileForm['sf_guard_user_id']);
    unset($profileForm['validate'], $profileForm['sf_guard_user_id']);
    unset($profileForm['email_post'], $profileForm['sf_guard_user_id']);
    unset($profileForm['email_reply'], $profileForm['sf_guard_user_id']);
    unset($profileForm['email_from'], $profileForm['sf_guard_user_id']);
    unset($profileForm['email_private'], $profileForm['sf_guard_user_id']);
    unset($profileForm['enter_code'], $profileForm['sf_guard_user_id']);
    unset($profileForm['has_modified_profile'], $profileForm['sf_guard_user_id']);
    unset($profileForm['created_at'], $profileForm['sf_guard_user_id']);
    unset($profileForm['updated_at'], $profileForm['sf_guard_user_id']);
    unset($profileForm['deleted_at'], $profileForm['sf_guard_user_id']);
    unset($profileForm['birthday'], $profileForm['sf_guard_user_id']);
    $this->embedForm('Profile', $profileForm);
  }
}
