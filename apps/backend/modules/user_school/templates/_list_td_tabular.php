<td class="sf_admin_text sf_admin_list_td_user">
  <?php if ($user_school->getUser()->getIsLms() === 0): ?>
    <?php echo $user_school->getUser(); ?>
  <?php elseif ($user_school->getUser()->getLmsEmail() != NULL): ?>
    <?php echo $user_school->getUser()->getFirstName()." ".
               $user_school->getUser()->getLastName()." (".
               $user_school->getUser()->getLmsEmail().")";?>
  <?php else: ?>
    <?php echo $user_school->getUser(); ?>
  <?php endif; ?>
</td>
<td class="sf_admin_text sf_admin_list_td_school">
  <?php echo $user_school->getSchool() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_major">
  <?php echo $user_school->getMajor() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_class_year">
  <?php echo $user_school->getClassYear() ?>
</td>
