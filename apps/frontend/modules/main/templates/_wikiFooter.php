<!--<div class="wiki-line"></div>-->
<div id="wiki-footer-block">
    <div class="wiki-footer-block">
    <div id="wiki-footer-menu">
    <div id="fb-root"></div>
    <script type="text/javascript">
        window.fbAsyncInit = function() {
		FB.Event.subscribe('edge.create', function () {
                    jQuery("#ref_fb").addClass("highlight");
                });
		FB.Event.subscribe('edge.remove', function () {
                    jQuery("#ref_fb").removeClass("highlight");
                });
            FB.init({
                appId      : '418568394885939',
                status     : true,
                xfbml      : true
            });
            FB.getLoginStatus(function(response) {
                if(response.status=="connected") {
                    FB.api({
                        method: 'fql.query',
                        query: 'SELECT uid,page_id FROM page_fan WHERE uid = me() AND page_id="191614884208856"'
                    },
                    function(response) {
                        if(response.length) {
                            //highlight the button
                            jQuery("#ref_fb").addClass("highlight");
                        }
                    });
                };
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
        <ul>
            <?php // if (!$loggedIn || ($loggedIn && $userProfile->getIsLms() == 0)): ?>
<!--                <li>
                    <div id="ref_fb" class="fb-like" data-href="https://www.facebook.com/pages/WikiGrads/191614884208856" data-height="32" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
                </li>
                <li>
                    <a id="ref_tw" target="_blank" title="Share on Twitter" href="http://twitter.com/share?text=<?php echo urlencode("WikiGrads | Academic Network: "); ?>&url=<?php echo urlencode("https://twitter.com/WikiGrads");?>" class="btn btn-counter" rel="nofollow"></a>
                </li>
                <li><?php // echo link_to("Home", "@homepage", array('title' => 'Home', 'class' => 'tooltip')); ?></li>-->
            <?php // endif; ?>
            <?php if (!$loggedIn || ($loggedIn && $userProfile->getIsLms() == 0)): ?>
            <li><?php echo link_to("Home", "@", array('title' => 'Home', 'class' => 'tooltip4')); ?></li>
            <?php endif; ?>
            <li><?php echo link_to("How it Works", "@tour", array('title' => 'How it works', 'class' => 'tooltip4')); ?></li> <!-- @tour -->
            <li><?php echo link_to("Why WikiGrads?", "@why_wiki", array('title' => 'Why WikiGrads?', 'class' => 'tooltip4')); ?></li>
            <li><?php echo link_to("About", "@about", array('title' => 'About', 'class' => 'tooltip4')); ?></li>
            <!--<li><?php //echo link_to("Blog", "@blog", array('title' => 'Blog', 'class' => 'tooltip')); ?></li>-->
            <li><?php echo link_to("Privacy & Terms", "@terms", array('title' => 'Terms', 'class' => 'tooltip4')); ?></li>
            <li><?php echo link_to("Contact us", "@contact", array('title' => 'Contact', 'class' => 'tooltip4')); ?></li>
        </ul>
    </div>
    <div id="wiki-copy">
        Copyright <?php echo date("Y"); ?> WikiGrads
        <div style="width: 32px; height: 32px;" id="ref_fb" title="" class="fb-like" data-href="https://www.facebook.com/pages/WikiGrads/191614884208856" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
        <a id="ref_tw" target="_blank" title="Share on Twitter" href="http://twitter.com/share?text=<?php echo urlencode("WikiGrads | Academic Network: "); ?>&url=<?php echo urlencode("https://twitter.com/WikiGrads");?>" class="btn btn-counter" rel="nofollow"></a>
    </div>
    <div class="clear"></div>
</div>
</div>
<?php if(!is_null($sf_user->getFlash('login_error'))){
   echo ' <div class="login-error" style="display: none">'.$sf_user->getFlash('login_error').'</div>';
} ?>

<?php if(!is_null($sf_user->getFlash('error'))){
   echo ' <div class="login-error" style="display: none">'.$sf_user->getFlash('error').'</div>';
} ?>

<div id="wg-equation"></div>
    <div id="wiki-math-editor"></div>

<div id="wiki-win"></div>
<div id="idZoomWindow"></div>
