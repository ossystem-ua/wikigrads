<td class="sf_admin_foreignkey sf_admin_list_td_domain">
  <?php echo $lms_domain_key_secret->getDomainName($lms_domain_key_secret->getDomain()) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_key_s">
  <?php echo $lms_domain_key_secret->getKeyS() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_secret">
  <?php echo $lms_domain_key_secret->getSecret() ?>
</td>
<td class="sf_admin_date sf_admin_list_td_updated_at">
  <?php echo false !== strtotime($lms_domain_key_secret->getUpdatedAt()) ? format_date($lms_domain_key_secret->getUpdatedAt(), "f") : '&nbsp;' ?>
</td>
