<?php use_helper('I18N', 'Date') ?>
<?php include_partial('instructorcourse/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Instructor & Course', array(), 'messages') ?></h1>

  <?php include_partial('instructorcourse/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('instructorcourse/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('instructorcourse/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('instructorcourse_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('instructorcourse/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('instructorcourse/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('instructorcourse/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('instructorcourse/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
<?php 
    if(isset($instructorCourse)) {
        $user_id = $instructorCourse['user_id']; 
        $course_id = $instructorCourse['course_id'];
    }
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#autocomplete_instructor_course_filters_user_id').val('<?php echo $user_id; ?>');
        $('#autocomplete_instructor_course_filters_course_id').val('<?php echo $course_id; ?>');
    });
</script>