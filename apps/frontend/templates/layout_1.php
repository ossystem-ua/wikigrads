<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <title>WikiGrads | <?php echo $sf_response->getTitle() ?></title>
    <link rel="shortcut icon" href="<?php echo image_path('favicon.ico')?>" />
    <?php include_optimized_stylesheets() ?>
  </head>
  <body>
    
    <div id="top-bar">
      <?php include_component('main', 'headerNav', array('counters' => array())); ?>
    </div>
    
    <div id="global-container">
        <?php 
            $isUserRegister = false;
            // sfGuardSecurityUser
            $parameterHolder = $sf_user->getAttributeHolder();            
            foreach ($parameterHolder->getNamespaces() as $ns) {
                $values[$ns] = array();
                foreach ($parameterHolder->getAll($ns) as $key => $value) {
                    if ($value) {
                        $isUserRegister = true;
                    }
                }
            }
            $isUserRegister = false;
            if ($sf_user->getGuardUser()) {
                if($sf_user->getGuardUser()->getId() > 0) $isUserRegister = true;
            }
            
            $style = $isUserRegister;
        ?>
      <?php if(!$isUserRegister || $_SERVER['REQUEST_URI'] == "/edit-user" || $_SERVER['REQUEST_URI'] == "/my-profile"):?> 
        <?php $style = false; ?>
      <div id="left-nav-container">
        <?php if(!$isUserRegister): ?>
        <div id="logo">
          <?php echo link_to(image_tag("lnav-wglogo.png", array('alt'=>"WikiGrads logo", 'width'=>"270", 'height'=>"86")), "@homepage"); ?>
        </div>        
        <?php endif; ?>
        <div id="nav-content-container">
          <?php include_component('main', 'leftNav')?>         
        </div>          
      </div>
        
     <?php endif; ?>

      <div id="content-container" <?php if ($style) { ?>style="width:100%;"<?php }?>>
         
     <?php if(!$isUserRegister):?>
        <div id="content-title">
          <?php $contentTitle = (has_slot('content-title')) ? get_slot('content-title') : $sf_context->getInstance()->getRouting()->getCurrentRouteName(); ?>
          <?php echo image_tag("banner-$contentTitle", array("alt" => "$contentTitle", "width" => "670", "height" => "86")) ?>
        </div>         
        <div id="content-title-pointer"><?php echo image_tag('content-title-pointer.png') ?></div>
     <?php endif; ?>
        <?php include_partial('global/flash', array());?>
        <?php echo $sf_content ?>
      </div>
      
    </div>
    
    <div id="footer">
      <?php include_component('main', 'footerNav')?>
    </div>

    <?php foreach (sfConfig::get('app_javascript_lib_files', array()) as $file): ?>
      <?php // Load these JavaScript lib files on the page before the combined optimized JS ?>
      <?php use_javascript($file, 'first'); ?>
    <?php endforeach; ?>
    <?php include_optimized_javascripts() ?>
      
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-26344751-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <div id="idZoomWindow"></div>
  </body>
</html>
