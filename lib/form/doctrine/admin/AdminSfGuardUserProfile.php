<?php

class AdminSfGuardUserProfile extends sfGuardUserProfileForm
{
    public function setup() {
        parent::setup();
        unset(
            //$this['user_id'],
            //$this['email'],
            //$this['fullname'],
            $this['image'],
            $this['birthday'],
            $this['about'],
            $this['activity'],
            $this['validate'],
            //$this['is_staff'],
            //$this['is_tutor'],
            $this['email_post'],
            $this['email_reply'],
            $this['email_from'],
            $this['email_private'],
            $this['enter_code'],
            $this['has_modified_profile'],
            $this['created_at'],
            $this['updated_at'],
            $this['deleted_at']
        );
    }
}

