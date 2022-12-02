<?php use_helper('I18N', 'Date') ?>
<?php include_partial('user_school/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('User school List', array(), 'messages') ?></h1>

  <?php include_partial('user_school/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('user_school/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('user_school/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('user_school_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('user_school/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('user_school/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('user_school/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('user_school/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
<?php 
    if(isset($userSchoolId)) {
        $user_id = $userSchoolId['user_id']; 
        $school_id = $userSchoolId['school_id'];
    }
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#autocomplete_user_school_filters_user_id').val('<?php echo $user_id; ?>');
        $('#autocomplete_user_school_filters_school_id').val('<?php echo $school_id; ?>');
        
        var noResult = jQuery('.sf_admin_list').children('p').html(),
            sorry = jQuery('#user_school_filters_major').val()
        if (noResult === 'No result' && sorry === 'Sorry, no results!') {
            jQuery('#user_school_filters_major').val('');
        }
    });
</script>