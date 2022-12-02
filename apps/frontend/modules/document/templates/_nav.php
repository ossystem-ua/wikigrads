<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $dc = 0;
    if (isset($_GET["dc"])) {
        $dc = intval($_GET["dc"]);
    }
?>
<ul id="doc-tabs">
    <?php /* ?>
        <li style="display: inline;"><?php echo link_to('All WD', '@document_list?type=all')?></li>
        <li style="display: inline;"><?php echo link_to('MY WD', '@document_list?type=my')?></li>
        */
        $i = 0;
        $idCurrent = 0;
    ?>
    <?php if($courses):?>
    <?php foreach ($courses as $course):?> 
        <li data-id-doc="<?php echo $i; ?>" class="course-id-<?php echo $course->getId(); ?>" id="doc-item-lists-<?php echo $i; ?>" <?php if($i <= 5) { echo 'style="display: inline;"'; } ?>>
            <?php echo link_to($course->getShortName(), '@document_course_list?type=course&slug='.$course->getId().'|'.Utils::slugify($course->getName()), array('data-tag' => $i));?>
        </li>
        <?php if ($course->getId() == $dc): ?>
            <?php $idCurrent = $i; ?>
        <?php endif; ?> 
    <?php $i++; ?>
    <?php endforeach;?>
    <?php endif; ?> 
</ul>
<div id="max-tab-doc" style="display: none;" max="<?php echo $i; ?>"></div>

<?php if ($idCurrent > 0): ?>

<?php endif; ?>

   

