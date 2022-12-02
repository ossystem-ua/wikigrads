<?php if ($sf_user->isAuthenticated()) : ?>
<div id="wiki-header" class="wiki-height-100">
    <div class="wiki-logo wiki-logo-login">
        <div id="wiki-auth-pre" class="wiki-logo-auth">
            <div class="wiki-logo-auth-img wiki-head-logo-a">
                <a href="/">&nbsp;</a>
            </div>
            <!--<div class="wiki-logo-auth-text">
                Hello, <span><?php //echo $profile->getFullName(); ?></span>
            </div>-->
        </div>

    </div>
    <div class="wiki-menu wiki-menu-login"></div>
    <div class="wiki-form wiki-form-login">
        <div class="wiki-auth-form">
            <a class="tooltip wiki-inline" text="Logout" title="Logout" href="/guard/logout"><img src="/images/new_design/wiki-logout.png" /></a>
        </div>
    </div>
</div>
<div class="wiki-win-line"></div>
<div class="wiki-float-row"></div>
<div class="wiki-inline wiki-block-left">

    <!-- menu block -->
    <div class="wiki-block-point">
        <ul class="wiki-left-menu">
            <?php foreach ($menu as $label => $route) : ?>
                <li><?php echo link_to('<span>'.$label.'</span>', $route) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="wiki-inline wiki-block-left">
    <div class="wiki-filter" id="wg-filter-block">
        <h2>Filters</h2>
        <div id="form-bar" class="wiki-block-point"></div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        if (jQuery('#sf_admin_bar')) {
            var bar = jQuery('#sf_admin_bar').html();
            if(bar) {
                jQuery('#sf_admin_bar').remove();
                jQuery('#form-bar').html(bar);
                jQuery('#wg-filter-block').css('display', 'block');
            } else {
                jQuery('#wg-filter-block').css('display', 'none');
            }
        }

        jQuery('.sf_admin_list_td_is_staff').each(function(index,object){
            var val = jQuery.trim(jQuery(object).html());

            if (val == 1) {
                jQuery(object).html('<img alt="Checked" title="Checked" src="/sfDoctrinePlugin/images/tick.png">');
            } else {
                jQuery(object).html('');
            }
        });

        jQuery('.sf_admin_list_td_number_of_course').each(function(index,object){
            var val = jQuery.trim(jQuery(object).html());
            if (val == '0') {
                jQuery(object).html('');
            } else {
                jQuery(object).attr('title', 'Number of courses in which the user is assigned an instructor');
            }
        });
    });
</script>
<?php endif; ?>

