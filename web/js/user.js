(function($) {
    if (!window.USER) {
        USER = {};
    }
    
    USER.register = {
        init: function() {
            if ($('#sfApplyApply_school_id').length) {
                //$('#sfApplyApply_school_id').live('change', USER.register.events.update_department_dropdown);
                $("#sfApplyApply_is_staff").click(USER.register.events.toggle_graduation_info);
            }
        },
        
        events: {
            toggle_graduation_info: function(){
                $("#apply-graduation-info").toggle();
            },
            update_department_dropdown: function(event) {
                var element = $(this);
                //alert("here");
                
                $.ajax({
                    url: element.attr('data-action')+'?id='+element.val(),
                    type: 'GET',
                    success: function(data, textStatus, XMLHttpRequest) {
                        $('#applymajor').html(data);
                        
                        
                        $('select#sfApplyApply_primary_department_id').uniform();
                    }
                });
            }
        }
    };    
    
    USER.add_friend = {
        init: function() {
            
            // text friend and unfriend links
            if ($('#sfguarduser_index').length || $('#document-tabs').length || $("#my-profile").length) {
                $('.friend-action').live('click', USER.add_friend.events.add_friend);
            }
            
            $('.fsicon-pend').qtip({
               content: 'You sent a WikiMate request to this user',
               position: wgQTipConfig.position,
               style: wgQTipConfig.style
            });
        },
        
        events: {
            add_friend: function(event) {
                
                var element = $(this);
                
                $.ajax({
                    url: element.attr('data-url'),
                    success: function(data, textStatus, XMLHttpRequest) {
                        
                        dataId = element.attr('data-id');
                        
                        //if this function was called from a page where can be multiple friend requests links within the page
                        if(dataId){
                               $('.friend-request-actions-'+dataId).html(data);
                            
                        }
                        else{
                            $('.friend-request-actions').html(data);
                        }
                    }
                });
            },
            
            fsicon_add_friend: function(ele) {
                var do_outline = ($('#notification-tabs').length > 0) ? 1 : 0; // friend pending icon in notification list is impossible to see with an outline.
                var af_options = { friend_pending_outline: do_outline };
                
                var jqo = $(ele);
                $('.qtip-active').remove(); // get rid of tooltip on link (otherwise when it reloads content and the tooltip never goes away)
                
                var url = jqo.attr('data-url'); //alert(url);
                $.ajax({
                    url: url,
                    dataType: 'html',
                    data: af_options,
                    success: function(data, textStatus, XMLHttpRequest) {
                        data_id = jqo.attr('data-id');
                        
                        //if this function was called from a page where can be multiple friend requests links within the page
                        if(data_id){
                            $('.fsicon-user-'+data_id).replaceWith(data);
                            USER.fsicon.tooltips();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        //alert(textStatus);
                    }
                });
            }
        }
    };
   
    USER.fsicon = {
        tooltips: function() {
            $('.fsicon-conf').qtip({
               content: 'You are WikiMates with this user',
               position: wgQTipConfig.position,
               style: wgQTipConfig.style
            });
            $('.fsicon-pend').qtip({
               content: 'You have a pending WikiMate request with this user',
               position: wgQTipConfig.position,
               style: wgQTipConfig.style
            });
            $('.fsicon-non-friend').qtip({
               content: 'Click this icon to send a WikiMate request to this user',
               position: wgQTipConfig.position,
               style: wgQTipConfig.style
            });
            
        }
    }
    
    USER.new_member = {
        autopager: function() {
            if($('#new-member-list').length) {
                AutoPager.addCallback('USER.fsicon.tooltips()');  // for any new content loaded, attach tooltips to the fsicons
                AutoPager.init('#new-member-list');    
            }
        }
    }
    
})(jQuery);