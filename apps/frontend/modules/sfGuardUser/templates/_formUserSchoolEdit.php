<div class="selMajorContainer global-form-style">
    <?php echo $form['major']->renderLabel('Major') ?>
    <div class="grey-input">
        <?php echo $form['major']->render() ?>
        <?php echo $form['major']->renderError() ?>
    </div>
</div>
<div class="selClassYearContainer">
    <?php echo $form['class_year']->renderLabel('Class of') ?>
    <?php echo $form['class_year']->render() ?>
    <?php echo $form['class_year']->renderError() ?>
</div>
