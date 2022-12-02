<?php //var_dump($errors);?>

<?php if(isset($errors) && $errors):?>
    <?php foreach($errors as $error):?>
        <?php echo 'ERROR - '.$error."<br>";?>
    <?php endforeach?>
<?php endif;?>

<?php if($imported_count && is_array($imported_count)):?>
    <?php Utils::pfa($imported_count);?>
<?php endif;?>

<?php echo $form->renderFormTag(url_for('@course_import')) ?>

    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form->renderHiddenFields() ?>
    
<div class="wg-import-form">
    <table>
        <tr>
            <td><?php echo $form['academic_term_id']->renderLabel() ?></td>
            <td><?php echo $form['academic_term_id']->render() ?><?php echo $form['academic_term_id']->renderError() ?></td>
        </tr>
        <tr>
            <td><?php echo $form['school_id']->renderLabel() ?></td>
            <td><?php echo $form['school_id']->render() ?><?php echo $form['school_id']->renderError() ?></td>
        </tr>
        <tr>
            <td><?php echo $form['file']->renderLabel() ?></td>
            <td><?php echo $form['file']->render() ?><?php echo $form['file']->renderError() ?></td>
        </tr>
    </table>   
    <div class="wiki-float-row-2"></div>
    <input type="submit" value="Register" />
</div>
  
    
</form>