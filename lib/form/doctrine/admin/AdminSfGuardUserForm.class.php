<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rbarona
 * Date: 4/4/13
 * Time: 4:55 PM
 * To change this template use File | Settings | File Templates.
 */
class AdminSfGuardUserForm extends sfGuardUserAdminForm
{
    public function setup() {
        parent::setup();
        unset(
            $this['courses_list'],
            $this['events_list'],
            $this['friends_list'],
            $this['sf_guard_user_list'],
            $this['permissions_list'],
            $this['username'],
            $this['post_count']
        );
    }

    /**
     * Updates the values of the object with the cleaned up values.
     *
     * @param  array $values An array of values
     *
     * @return mixed The current updated object
     */
    public function updateObject($values = null)
    {
        if (null === $values)
        {
            $values = $this->values;
        }

        $values = $this->processValues($values);

        ## Set the username using the email_address
        $values['username'] = $values['email_address'];

        $this->doUpdateObject($values);

        // embedded forms
        $this->updateObjectEmbeddedForms($values);

        return $this->getObject();
    }
}
