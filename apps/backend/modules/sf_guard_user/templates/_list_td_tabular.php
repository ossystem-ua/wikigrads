<td class="sf_admin_text sf_admin_list_td_first_name">
  <?php echo $sf_guard_user->getFirstName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_last_name">
  <?php echo $sf_guard_user->getLastName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email_address">
    <?php if ($sf_guard_user->getIsLms() == 0): ?>
        <?php echo $sf_guard_user->getEmailAddress() ?>
    <?php elseif ($sf_guard_user->getLmsEmail() != NULL): ?>
        <?php echo $sf_guard_user->getLmsEmail() ?>
    <?php else: ?>
        <?php echo "This user has no email" ?>
    <?php endif; ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_is_active">
  <?php echo get_partial('sf_guard_user/list_field_boolean', array('value' => $sf_guard_user->getIsActive())) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_is_staff">
  <?php echo $sf_guard_user->getIsStaff() ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_is_officer">
  <?php echo get_partial('sf_guard_user/list_field_boolean', array('value' => $sf_guard_user->getIsOfficer())) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_number_of_course">
  <?php echo $sf_guard_user->getNumberOfCourse() ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_is_super_admin">
  <?php echo get_partial('sf_guard_user/list_field_boolean', array('value' => $sf_guard_user->getIsSuperAdmin())) ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo false !== strtotime($sf_guard_user->getCreatedAt()) ? format_date($sf_guard_user->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_last_login">
  <?php echo false !== strtotime($sf_guard_user->getLastLogin()) ? format_date($sf_guard_user->getLastLogin(), "f") : '&nbsp;' ?>
</td>
