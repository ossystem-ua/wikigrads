Main = {
    setToggleVisibilityArea: function(toggle_ele, toggle_btn, btn_type) {
        $(toggle_btn).click(function(){
            $(toggle_ele).slideToggle();
            $(toggle_btn).toggleClass('togarw-up-'+btn_type+' togarw-dn-'+btn_type);
        });
    },
    
    // JS ROLLOVER
    rollover: {
        init: function() {
            $(".rollover").hover(   //mouse over
                function(){    
                    src_off = $(this).attr('src'); //grab original image
                    src_on = $(this).attr('rel'); //grab rollover image
                    $(this).attr('src', src_on); //swap images
                    $(this).attr('rel', src_off); //swap images 
                },
                function(){ //mouse out
                    src_on = $(this).attr('src'); //grab rollover image
                    src_off = $(this).attr('rel'); //grab original image
                    $(this).attr('src', src_off); //swap images
                    $(this).attr('rel', src_on); //swap images
            });
            
            //preload images
            var cache = new Array();
            //cycle through all rollover elements and add rollover img src to cache array
            $(".rollover").each(function(){
                var cacheImage = document.createElement('img');
                cacheImage.src = $(this).attr('rel');
                cache.push(cacheImage);
            }); 
        }
    }
}





$(document).ready(function() { 
    //top-settings
    //top-setting-menu
    $('.top-settings').mouseover(function(){
        $('.top-setting-menu').css('display', 'block');
        $('.top-settings').css('background-color', '#222222');
    });
    
    $('.top-settings').mouseout(function(){
        $('.top-setting-menu').css('display', 'none');
        $('.top-settings').css('background-color', '');
    });
    
    $('.top-setting-menu').mouseover(function(){
        $('.top-setting-menu').css('display', 'block');
        $('.top-settings').css('background-color', '#222222');
    });
    
    $('.top-setting-menu').mouseout(function(){
        $('.top-setting-menu').css('display', 'none');
        $('.top-settings').css('background-color', '');
    });
    
    /*****************************************                                        
     * Harumi's JS  @ Endertech                              
     */
                 
    COURSE.add_course.init();
    COURSE.delete_course.init();


    DASHBOARD.notification_tabs.init();

    // DOCUMENT.add_document.init();
    DOCUMENT.course_tabs.init();
    DOCUMENT.delete_document.init();
    DOCUMENT.toggle_form.init();
    DOCUMENT.list.autopager();

    POST.add_post.init();
    POST.edit_post_link.init();
    POST.add_comment_link.init();
    POST.edit_comment_link.init();
    POST.submit_comment_form.init();

    // TODO: Make the tooltip for flag-as-inappropriate links on Dashboard (top page) gets initialized properly on the first page load.
    //       Currently, the tooltip only activates AFTER one additional content (post and nested comment) is AJAX-loaded by pagination.
    //       The commented line below does NOT solve this problem. I must find the right place to insert this line. (ynakano, 2013-10-21)
    POST.flag_as_inappropriate.tooltips();

    USER.add_friend.init();
    USER.register.init();
    USER.fsicon.tooltips();

    USER.new_member.autopager();
    
    Profile.initQuickUserProfile();   
    
    Main.rollover.init();         

    $("select").uniform();

    $('#file').customFileInput();

    //Set default form inputs focuse/blur
    $('.default-value').each(function() {
        var default_value = this.value;
        $(this).focus(function() {
            if(this.value == default_value) {
                this.value = '';
            }
        });
        $(this).blur(function() {
            if(this.value == '') {
                this.value = default_value;
            }
        });
    });
    
});
   




function formFieldFocus(inputElement,defaultVal,isPasswd) {
    if (inputElement.value == defaultVal) {
        inputElement.value="";
        if (isPasswd) changeInputType(inputElement,"password");
    }
}
function formFieldBlur(inputElement,defaultVal,isPasswd) {
    if (inputElement.value == "" ) {
        inputElement.value = defaultVal;
        if (isPasswd) changeInputType(inputElement,"text");
    }
}

function changeInputType(obj,otype) {
    obj.setAttribute('type',otype);
}

console.trace()


    

