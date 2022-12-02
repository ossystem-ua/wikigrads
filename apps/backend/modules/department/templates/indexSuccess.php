<?php use_helper('I18N', 'Date') ?>
<?php include_partial('department/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Department List', array(), 'messages') ?></h1>

  <?php include_partial('department/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('department/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('department/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('department_department_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('department/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('department/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('department/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('department/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
<?php 
    if(isset($DepartmentSchoolId)) {
        $school_id = $DepartmentSchoolId['school_id'];
    }
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#autocomplete_department_filters_school_id').val('<?php echo $school_id; ?>');
        
        var noResult = jQuery('.sf_admin_list').children('p').html(),
            sorry = jQuery('#department_filters_name').val()
        if (noResult === 'No result' && sorry === 'Sorry, no results!') {
            jQuery('#department_filters_name').val('');
        }
    });
</script>