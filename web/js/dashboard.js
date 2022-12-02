(function($) {
    
    if (!window.DASHBOARD) {
        DASHBOARD = {};
    }
   
    DASHBOARD.notification_tabs = {
        init: function() {
            var notificationTabs = $('#notification-tabs');
            var courseId = $('#thisactivetab').attr('thisactiveid');
            $('#tmp_course_id').val(courseId);
            if (notificationTabs.length) {
                notificationTabs.tabs({
                    select: function(event, ui) {
                        //alert($('#notification-tabs').tabs().tabs('option', 'selected')); // get selected tab
                        
                        //Need to remove the other notification list so the comment form displays in the correct div
                        $("#notification-list").remove();
                        
                        var data_id = $(ui.tab).attr('data-id');
                        
                        // 'everyone' has no id
                        if(!data_id) { 
                            data_id = ''; // set to empty string so it will exactly match first select option (instead of data_id = null).
                            $('#post-form-widget').removeClass('mode-cls').addClass('mode-ev1');
                        } else {
                            $('#post-form-widget').removeClass('mode-ev1').addClass('mode-cls');
                        }
                        
                        $('#tmp_course_id').val(data_id);
                        $('#post_course_id').val(data_id);
                    },                    
                    
                    load: function(event, ui) {                                                
                        DASHBOARD.post_comment.setModeDescription();
                        USER.fsicon.tooltips();
                    },                    
                    
                    ajaxOptions: {
                        error: function( xhr, status, index, anchor ) {                            
                            $(anchor.hash).html("Couldn't load this tab. We'll try to fix this as soon as possible.");
                        }
                    }
                });
            }
        }
    };  
    
    DASHBOARD.post_comment = {
        init: function() {
            DASHBOARD.post_comment.init_selectors();
            
            $('#post_content').val(DASHBOARD.post_comment.mode_description.classmates); // when first loads, tab is 'classmates', so set textbox msg for classmates
            
            // when msg textbox receives focus, if the content is one of the mode_descriptions, then clear the textbox.
            $('#post_content').focus(function(){
                for(var k in DASHBOARD.post_comment.mode_description) {
                    if(this.value == DASHBOARD.post_comment.mode_description[k]) {
                        this.value = '';
                        $('#post_content').css('height', '36px');  // reset TEXTAREA height
                        break;
                    }
                } 
            });
            
            // when the msg textbox loses focus, if nothing is present then reset the mode_description
            $('#post_content').blur(function(){
              if(this.value == '') {
                 // reset placeholder text
                 DASHBOARD.post_comment.setModeDescription({force:true}); 

                 // reset TEXTAREA height
                 $('#post_content').css('height', '36px');
              }   
            });

            // set TEXTAREA autosize
            $('#post_content').autosize({append: "\n"});
        },
        init_selectors: function() {
            var classSel = $('#post-form-widget #class-selector');
            var classSelA = classSel.children('a');
            var groupsSel = $('#post-form-widget #groups-selector');
            var groupsSelA = groupsSel.children('a');
            
            classSel.click(function(){
               classSelA.addClass('on');
               groupsSelA.removeClass('on');
               $('#post_type_Classmate').attr('checked', 'checked');
               DASHBOARD.post_comment.setModeDescription();
               return false; 
            });
            classSel.qtip({
               content: 'Ask a question or post a comment to all classmates',
               position: wgQTipConfig.position,
               style: wgQTipConfig.style
            });
                        
            groupsSel.click(function(){
               groupsSelA.addClass('on');
               classSelA.removeClass('on');
               $('#post_type_Friend').attr('checked', 'checked');
               DASHBOARD.post_comment.setModeDescription();
               return false; 
            });
            groupsSel.qtip({
               content: 'Ask, Discuss, Blog',
               position: wgQTipConfig.position,
               style: wgQTipConfig.style
            });
        },
        
        mode_description: { // used for setting default content in post_content text input
            'classmates':   'Ask, Discuss, Blog',
            'groups':       'Ask, Discuss, Blog',
            'everyone':     'Ask, Discuss, Blog'
        },
        
        setModeDescription: function(options) {
            var options = options || {force:false};
                       
            if( ! options.force) {
                var value = $('#post_content').val();
                var cancelOp = false;
                
                if(value != '') { // if field is empty, we want to set the mode description
                    var isModeDescription = false; // default to false, and as soon as match is made below, set to true and break the loop
                    for(var k in DASHBOARD.post_comment.mode_description) {
                        if(value == DASHBOARD.post_comment.mode_description[k]) {
                            isModeDescription = true;
                            break;
                        }
                    }
                    cancelOp = ( ! isModeDescription);
                }
                
                if(cancelOp) { return; }
            }
            
            var data_id = $('.ui-tabs-selected').find('a').attr('data-id');
            
            if (data_id != 0) {
                $(".ui-state-default").each(function(){
                    if ($(this).html() == $('.tab-menu-' + data_id).html()) {
                        $(this).css('display', 'inline');
                        $('.tab-menu-' + data_id + '-1').css('display', 'inline');
                        $(this).attr('id', 'thisactivetab');
                        $(this).attr('thisactiveid', data_id);
                        //$('a#ui-tab-0').attr('href', '/notification/list/course/' + data_id + '|1');
                    } else {
                        if ($(this).html() != $('.tab-menu-' + data_id + '-1').html()) {
                            $(this).css('display', 'none');
                            $(this).attr('id', '');
                            $(this).attr('thisactiveid', 0);
                        }
                    }
                });               
            }
            
            if( ! data_id) { // is 'everyone' tab
                $('#post_content').val(DASHBOARD.post_comment.mode_description.everyone);
            } else if($('#post_type_Classmate').attr('checked') == 'checked') {
                $('#post_content').val(DASHBOARD.post_comment.mode_description.classmates);
            } else {
                $('#post_content').val(DASHBOARD.post_comment.mode_description.groups);
            }
        },

//        initAutosize: function() {
//
//
//        }
        }
    
    
    DASHBOARD.post_comment.init();
    
    function update_counters(){
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "/update_counters",
            async: false,
            success: function(data) {
                $.each(data, function(key, value) {
                    $.each(value, function(k,v) {
                        if(v != 0 && v) {
                            $("."+k+".id"+key).css('display', 'inline');
                            $("."+k+".id"+key).html(v);
                        } else {
                            $("."+k+".id"+key).css('display', 'none');
                        }
                    });
                });
            }
        }).complete(function(){
            setTimeout(function(){update_counters();}, 60000);
        });
    }
    update_counters();
    
    $("#notification-tabs ul li a").click(function(){
        
        var course_id = $(this).data("id");
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "/reset_counter/"+course_id,
            success: function(data) {                
                if(data.success) {
                    //$(".post"+".id"+course_id).html("");
                    //$(".post"+".id"+course_id).css('display', 'none');
                    
                    $("#tab-id-list-"+course_id).html("");
                    $("#tab-id-list-"+course_id).css('display', 'none');
                    
                    $(".classmate"+".id"+course_id).html("");
                    $(".classmate"+".id"+course_id).css('display', 'none');
                }
            }
        })
    })
          
})(jQuery);