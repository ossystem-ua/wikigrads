<?php
$moduleName = $sf_context->getModuleName();
$actionName = $sf_context->getActionName();
$sectionName = $sf_context->getInstance()->getRouting()->getCurrentRouteName();
?>
    
<?php if($loggedIn):?>
	<?php include_component('main', 'quickUserInfo') ?>
<!--
	<div class="navlinksloggedin">
	<?php
		foreach($page_links as $page_route => $link_attr) {
			if ($isCurrentPage = ($link_attr['tag'] == $sectionName)) {
				echo '<div class="current">' . $link_attr['text'] .'</div>';
			} else {
				echo '<div>' . link_to($link_attr['text'],$page_route, array('class'=>'link')) . '</div>';
			}
        }
	?>
	</div>
-->
<?php else :?>
	<?php include_component('sfApply', 'login') ?>

    <!--<div id="left-nav-or">OR</div>-->
    
	<?php echo image_tag("lnav-hr-or", array("height" => "24", "width"=>"240", "alt" => "", "class" => "lnavhr"))?>
	
	
	<?php echo link_to(image_tag($sectionName=="apply"?'lnav-apply-active':'lnav-apply', array("id" => "applybutton")), '@apply') ?>

	<?php echo image_tag("lnav-hr", array("height" => "24", "width"=>"240", "alt" => "", "class" => "lnavhr"))?>

	<div class="navlinks">
        <?php foreach($page_links as $page_route => $link_attr):?>
            <?php $imgcode = ($isCurrentPage = ($link_attr['tag'] == $sectionName)) ? $link_attr['tag'] . "-active" : $link_attr['tag']; ?>

            <?php  
              if(file_exists(sfConfig::get('sf_web_dir').'/images/lnav-'.$imgcode.'.png'))
              {
                  $imgtag = image_tag("lnav-$imgcode", array("class" => "lnavlink"));
              }
              else
              {
                  $imgtag = $imgcode;  
              }
              if (!$isCurrentPage)
              { 
                  echo link_to($imgtag, $page_route, array());
              }
              else
              {
                  echo $imgtag;
              }
            ?>
        <?php endforeach; ?>
	</div>

<?php endif;?>


<?php /*
	<div class="navlinksloggedin" id="ambassadors">
		<H4>Student ambassadors needed!</H4>
		<P>We're searching for energetic students to help promote WikiGrads on your campus!</P>
		<P>Contact <?php echo mail_to('lucas@wikigrads.com','lucas@wikigrads.com',array('encode' => true)); ?> for more information!</P>
	</div>
*/
?>


<?php /* 
<h3 style="position:absolute;left:5px;top:100px;color:#666;font-size:10pt;">
    <?php echo $moduleName.'/'.$actionName.'/'.$sectionName ?>
</h3>

*/ ?>

	
