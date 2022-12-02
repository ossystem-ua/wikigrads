<?php use_helper('I18N', 'Date') ?>
<?php include_partial('course/assets') ?>
<div id="sf_admin_container">
  <h1><?php echo __('Course List', array(), 'messages') ?></h1>

  <?php include_partial('course/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('course/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('course/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('course_course_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('course/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('course/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('course/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('course/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
<?php 
    if(isset($courseDepartmentId)) {
        $department_id = $courseDepartmentId['department_id']; 
        $school_id = $courseDepartmentId['school_id'];
    }
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#autocomplete_course_filters_department_id').val('<?php echo $department_id; ?>');
        jQuery('#autocomplete_course_filters_school_id').val('<?php echo $school_id; ?>');
        
        var noResult = jQuery('.sf_admin_list').children('p').html(),
            sorry = jQuery('#course_filters_name').val()
        if (noResult === 'No result' && sorry === 'Sorry, no results!') {
            jQuery('#course_filters_name').val('');
        }
    });
</script>