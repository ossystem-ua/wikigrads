<div class="content-pad">

<?php
$extLink = array(
	'facebook'	=>	'https://www.facebook.com/pages/WikiGrads/191614884208856',
	'twitter'	=>	'https://twitter.com/wikigrads'
);
?>

<div id="keepintouch">
<h3>Connect to WikiGrads Through...</h3>
<?php echo link_to(image_tag('kit-1face.png',array('class'=>'rollover','id'=>'kitface','rel'=> image_path('kit-1face-on.png'))),$extLink['facebook'],array('target'=>'_blank'));?>
<?php echo image_tag('kit-2or.png');?>
<?php echo link_to(image_tag('kit-3tweet.png',array('class'=>'rollover','id'=>'kittwit','rel'=> image_path('kit-3tweet-on.png'))),$extLink['twitter'],array('target'=>'_blank'));?>
<p>
Like our Facebook page or follow our Twitter account for updates on WikiGrads
</p>
</div>


</div>
