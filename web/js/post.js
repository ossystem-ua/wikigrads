/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


(function($) {

    $(document).ready(function(){
        setDocsTabs();
        /*
        var t_url = window.location.href;
        if (t_url.indexOf('#') > 0)
            setCookie("current_url", t_url);
        */
       
       
        
        $("#course_add_course_id").change(function() {
            //console.log($("#course_add_course_id").val());
        });
        
        $("#post_content").keypress(function(key){
            switch (key.keyCode) {
                //case 13: { $("#form-sumit-ask").trigger('click'); }break;
            }
        });  
        
        ///////////////////   BEGIN UPLOAD FILE ////////////////////////////
        $("#post_attachment_id").attr("value", "0");
        $("#post_attachment_url").attr("value", "");
        
        
        $("#class-upload").click(function(){
            if ($("#post_attachment_id").attr("value") == '0') {                
                $("#files").trigger("click");
            } else {
                ResetImage();
            }                
        });
        
        $('#class-upload-doc').click(function(){
            console.log('click document');
        });
        
        $("#files").change(function() {
            var formData = new FormData($('#hiddeForm')[0]);
            $.ajax({
                url: '/useruploads',  //Server script to process data
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(a,b,c) {
                    var result = JSON.parse(c.responseText),
                            object = result[0];
                    if (object.error == 0) {
                        if (object.id > 0) {
                            //$('input#post_everyone').prop('checked', false);
                            $("#post_attachment_id").val(object.id);
                            $("#post_attachment_url").val(object.url);
                            // redcheckcircle.png
                            $('#class-upload').attr('title', 'Click to remove the attached image');
                            //$('#class-upload').css('background-image', 'url(../images/redcheckcircle.png)');
                            //$(".upload-status").html('<span class="span-border"><a id="linkclear" href="'+ object.url +'" target="_blank">Attach images</a>&nbsp;&nbsp;<a id="clearImage" OnClick="ResetImage();">X</a></span>');
                            $(".upload-status").html('<div style="display: inline-block; padding: 0px; margin: 0px;"><a href="'+ object.url +'" class="zoom"><img src="'+ object.url +'" style="height:20px;"></a>&nbsp;<a id="clearImage" OnClick="ResetImage();" style="vertical-align: top;">X</a></div>');
                        }
                    } else {
                        $(".upload-status").html(object.message);
                    }
                },
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    return myXhr;
                }
            });        
        });
        ///////////////////   END UPLOAD FILE ////////////////////////////
    });    
    
        
    if (!window.POST) {
        POST = {};
    }
    
    
    POST.add_post = {
        init: function() {
            if ($('#dashboard-post-form').length) {
                $('#dashboard-post-form').live('submit', POST.add_post.events.dashboard_post_submit);
            }
        },
        
        events: {
            dashboard_post_submit: function(event) {
                event.preventDefault();
                
                var form = $(this);                
                
                // if they submitted nothing, or just hit submit without changing the mode description, then do nothing.
                var contentVal = form.find('textarea').val(); 
                
                if ((contentVal == 'Ask, Discuss, Blog' || contentVal == '') && $("#post_attachment_id").val() > 0) {
                    var area = form.find('textarea');
                    area.val('image');
                    area.html('image');
                    contentVal = form.find('textarea').val();
                }
                
               if ($('#tmp_course_id').val()) $('#post_course_id').val($('#tmp_course_id').val());             
                
                if(contentVal == '') { 
                    DASHBOARD.post_comment.setModeDescription({force:true});                        
                    return false; 
                }
                if(contentVal == '') { return false; }
                // check every one                
                var postCourseId = $('#post_course_id').val(),
                    courseId = $('#thisactivetab').attr('thisactiveid');
            
                /*
                if (!postCourseId) { 
                    postCourseId = $('#tmp_course_id').val(); 
                    $('#post_course_id').val(postCourseId);
                }
                if (!postCourseId) postCourseId = 0;
                /**/
                
                if (postCourseId != courseId) {
                    if (courseId) {                        
                        form.find('select#post_course_id').val(courseId);
                        //form.find('input#post_everyone').prop('checked', true);
                        form.find('input#post_everyone').prop('checked', false);
                    } else {
                        form.find('input#post_everyone').prop('checked', false);
                    }
                } else {
                    form.find('input#post_everyone').prop('checked', false);
                }

                for(var x in DASHBOARD.post_comment.mode_description) {
                    if(contentVal == DASHBOARD.post_comment.mode_description[x]) { return; }
                }
                // end check
	        form.find('input:image').prop('disabled', true).addClass('disabled');

                $.ajax({
                    url: form.attr('action'),
                    type: "POST",
                    data: form.serialize(),                    
                    dataType: 'json',
                    success: function(data, textStatus, XMLHttpRequest) {
                        if(data.is_success) {
                            var tab_id = $('#notification-tabs').tabs().tabs('option', 'selected');
                            $('#notification-tabs').tabs('load', tab_id);
                            
                            DASHBOARD.post_comment.setModeDescription({force:true});
                            $('#post_content').blur().css('height', '36px');
                            if(contentVal != '') {
                                // attachment
                                $("#post_attachment_id").attr("value", "0");
                                $("#post_attachment_url").attr("value", "");
                                $('#class-upload').attr('title', 'Attach an image to a post');
                                $('#class-upload').css('background-image', 'url(../images/icon-upload.png)');                
                                $('#hiddeForm').trigger('reset');
                                $('#post_course_id').val(postCourseId);
                                $(".upload-status").html('');
                                $('#post_content').css('height', '36px');
                            } else{
                                $('#post_course_id').val(0);
                            }
                        }
                    },
                    complete: function(data, textStatus) {
                        form.find('input:image').prop('disabled', false).removeClass('disabled');                        
                    }
                });
            }
        }
    };    
    
    POST.edit_comment_link = {
        init: function() {
            $('.comment-edit-link').live('click', POST.edit_comment_link.events.show_edit_comment_form);
        },

        events: {
            show_edit_comment_form: function(event) {
                event.preventDefault();

                var link = $( this );
                var post_id = link.attr( 'data-id' );

                // debug by Yas
                console.dir(link.attr( 'href' ));

                $.ajax({
                    url: link.attr( 'href' ),
                    type: "GET",
                    success: function(data, textStatus, XMLHttpRequest) {
                        $( '#comment-edit-form-container-' + post_id ).html( data );
                    }
                });

            }
        }
    }

    POST.edit_post_link = {
        init: function() {
            $('.post-edit-link').live('click', POST.edit_post_link.events.show_edit_post_form);
        },

        events: {
            show_edit_post_form: function(event) {
                event.preventDefault();

                var link = $( this );
                var notification_id = link.attr( 'data-id' );

                // debug by Yas
                console.dir(link.attr( 'href' ));

                $.ajax({
                    url: link.attr( 'href' ),
                    type: "GET",
                    success: function(data, textStatus, XMLHttpRequest) {
                        // debug by Yas
                        //console.dir(data);
                        $('#notification-edit-post-container-' + notification_id).html(data);
                    }

                });
            }
        }
    }

    POST.mode_description = {
        'comment_add': 'post a comment'
    }
    POST.add_comment_link = {
        init: function(){
            $('.comment-add-link').live('click', POST.add_comment_link.events.show_comment_form);
            
            // set default content for 'post a comment' field
            $('.comment-add-form input:text')
                .live('focus', function(){ 
                    if(this.value == POST.mode_description.comment_add) { this.value = ''; } 
                })
                .live('blur', function(){ 
                    if(this.value == '') { this.value = POST.mode_description.comment_add; }
                });
        },
        events: {
            show_comment_form: function(event) {
                event.preventDefault();
                
                var link = $(this);
                var notification_id = link.attr('data-id');
                                
                $.ajax({
                    url: link.attr('href'),
                    type: "GET",
                    success: function(data, textStatus, XMLHttpRequest) {
                        $('#comment-add-form-container-'+notification_id).html(data);                    
                    }
                });
                
            }
            
        }
    };
    
    POST.submit_comment_form = {
        init: function(){
            $('.comment-add-form').live('submit', POST.submit_comment_form.events.submit_comment_form);
        },
        events: {
            submit_comment_form: function(event) {
                event.preventDefault();
                
                var form = $(this);
                
                // if they submitted nothing, or just hit submit without changing the mode description, then do nothing.
                var contentVal = form.find('input:text').val();
                if(contentVal == POST.mode_description.comment_add || contentVal == '') {
                    form.find('input:text').val(POST.mode_description.comment_add);
                    return;
                }

                var notification_id = form.attr('data-id');
                form.find('input:image').prop('disabled', true).addClass('disabled');
                
                $.ajax({
                    url: form.attr('action'),
                    type: "POST",
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(data, textStatus, XMLHttpRequest) {
                        if(data.is_success) {                            
                            // refresh comments list and remove form
                            var notification_comment_list = $("#notification-comment-list-"+notification_id);
                            //alert(notification_comment_list.attr('data-action'));
                            $.ajax({
                                url: notification_comment_list.attr('data-action'),
                                success: function(data, textStatus, XMLHttpRequest) {
                                    $('#comment-add-form-container-'+notification_id).html(''); // remove form from page
                                    notification_comment_list.html(data);
                                }
                            });  
                        } else {
                            alert(data.form_errors);
                        } 
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown){
                        form.replaceWith(XMLHttpRequest.responseText);
                    },
                    complete: function(data, textStatus) {
                        form.find('input:image').prop('disabled', false).removeClass('disabled');
                    }
                });
            }
        }        
        
    };
    
    POST.flag_as_inappropriate = {
        tooltips: function() {
            $('.flag-as-inappropriate').qtip({
                content: 'Flag as inappropriate',
                position: wgQTipConfig.position,
                style: wgQTipConfig.style
            });
        }
    };
    
    
    
    $('#SubscrMenu').mouseover(function(){ showSubscr(); });
    $('#SubscrMenu').mouseout(function(){ hideSubscr(); });
    $('#nav').mouseover(function(){ showSubscr(); });
    $('#nav').mouseout(function(){ hideSubscr(); });
    
    
    jQuery('li a').click(function(){
        setDocsTabs(this);
    });
    
    $("#file").change(function() {
        setTimeout(function() {
            var text = $('span.customfile-feedback').html();
            if (text.length > 19) {
                var i = 0, ret = '';                
                while (i < text.length) {
                    if (i < 8 || i >= (text.length - 8)) {
                        ret = ret + text[i];
                    } else if (i == 8) {
                        ret = ret + '...';
                    }
                    i++;
                }
                text = ret;
            }
            $('span.customfile-feedback').html(text);
        }, 1000);        
    });
    
    $('#document_course_id').change(function(){
        var courseId = $(this).val(),
            objectName = 'li.course-id-' + courseId + ' a';
        $(objectName).click();
        setCookie('objectName', objectName);
    });
    setTimeout(function() {
        $(getCookie('objectName')).click();        
    }, 400);
    
    // doc-tabs
    $('#doc-tabs li a').click(function(){
        var id = '#' + $(this).parent().attr('id');
        setCookie('objectName', id);
    });
    
    if(fnGetMetka() != '') {
        $('#' + fnGetMetka()).click();
    }
    
    // check access course
    $("#course_add_course_id").live("change", function(event){
        var id = $("#course_add_course_id").val();
        jQuery.ajax({
            url: 'checkcourseaccess',
            type: 'POST',
            data: 'object=' + id,
            success: function(data, textStatus, XMLHttpRequest) {
                var object = JSON.parse(XMLHttpRequest.responseText);
                if(object.success == 1) {
                    $('#block-hide-0').css('display', 'inline-block');
                } else {
                    $('#block-hide-0').css('display', 'none');
                    $('#course_add_access').val('');
                }
            }
        });
    });
    
    // radio emails
    var enter_code = $('#sf_guard_user_profile_enter_code');
    var email_post = $('#sf_guard_user_profile_email_post');
    var email_reply= $('#sf_guard_user_profile_email_reply');
    var email_from = $('#sf_guard_user_profile_email_from');
    
    email_from.live("click", function (){
        if($(this).is(':checked')) {
            email_post.prop('checked', false);
            email_reply.prop('checked', false);
        }
    });
    
    email_post.live("click", function (){
        if($(this).is(':checked')) {
            email_from.prop('checked', false);
        }
    });
    
    email_reply.live("click", function (){
        if($(this).is(':checked')) {
            email_from.prop('checked', false);
        }
    });
    
})(jQuery);

function showSubscr() {
    $('#nav').css('display', 'block');
    $('.subcr-menu-block').css('display', 'block');
}

function hideSubscr() {
    $('#nav').css('display', 'none');
    $('.subcr-menu-block').css('display', 'inline');
}

function setDocsTabs(object) {
    var currentId = jQuery(object).attr('data-tag'),
            maxId     = jQuery('#max-tab-doc').attr('max'),
            min = 0,
            max = 0;
        currentId = parseInt(currentId);
        if (maxId && currentId) {
            if (currentId <= maxId) {
                // hide     
                for(var i = 0; i <= maxId; i++) {
                    min = currentId-1;
                    if (min < 0) min = 0;
                    max = min + 5;
                    
                    if (max > maxId) { max = maxId; min = max - 5; }
                    
                    if (i >= min && i <= max) {
                        jQuery('#doc-item-lists-'+i).css('display', 'inline');
                    } else {
                        jQuery('#doc-item-lists-'+i).css('display', 'none');
                        
                    }
                }                
            }
        }
}

///////////////////   BEGIN LIKE ////////////////////////////        
function setLike (id) {
    var current_count = parseInt(jQuery("#count_" + id).html());
    jQuery.ajax({
        url: 'userlike',
        type: 'POST',
        data: 'object=' + id,
        success: function(data, textStatus, XMLHttpRequest) {
            var object = JSON.parse(XMLHttpRequest.responseText);
            if (object.success == 0) {
                if (parseInt(current_count) < object.like) object.data_like = 1;
                current_count = object.like;
                jQuery("#count_" + id).html(current_count);
                //console.log(object.data_like);
                switch (parseInt(object.data_like)) {
                    case -1: {jQuery("#status_" + id).html('<span style="color: #ff0000;">dislike</span>');}break;
                    case 0:  {jQuery("#status_" + id).html('<span style="color: #333333;">unlike</span>');}break;
                    case 1:  {jQuery("#status_" + id).html('<span style="color: #0000ff;">like</span>');}break;
                    default: {jQuery("#status_" + id).html(object.message);}break;
                }
            } else {
                jQuery("#status_" + id).html('<span style="color: #ff0000;">'+ object.message + '</span>');
            }
        }
    });        
}
///////////////////   END LIKE   ////////////////////////////

function ResetImage() {
    var postCourseId = $('#post_course_id').val();
    $("#post_attachment_id").attr("value", "0");
    $("#post_attachment_url").attr("value", "");
    $('#class-upload').attr('title', 'Attach an image to a post');
    //$('#class-upload').css('background-image', 'url(../images/icon-upload.png)');                
    $('#hiddeForm').trigger('reset');
    $(".upload-status").html('');
    $('#post_course_id').val(postCourseId);
}

function ShowHideText (id) {
    if ($("#span_"+id).css('display') == 'none') {
        // show text
        $("#span_"+id).css('display', 'inline');
        $("#href_"+id).html('hide');
    } else {
        // hide text
        $("#span_"+id).css('display', 'none');
        $("#href_"+id).html('read more');
    }
}

function ShowCourse (id, tabId, tabAll) {

    if (id != 0) {
        $(".ui-state-default").each(function(){
            if ($(this).html() == $('.tab-menu-' + id).html()) {
                $(this).css('display', 'inline'); 
                $('.tab-menu-' + id + '-1').css('display', 'inline');
                $(this).attr('id', 'thisactivetab');
                $(this).attr('thisactiveid', id);
            } else {
                if ($(this).html() != $('.tab-menu-' + id + '-1').html()) {
                    $(this).css('display', 'none');
                    $(this).attr('id', '');
                    $(this).attr('thisactiveid', 0);
                }
            }
        });
    }
    var url = '/dashboard#ui-tabs-' + tabId;
    setCookie("current_url", url);

    window.location.href = url;
    
    
    if ($('#notification-tabs').html()) {
        $('#ui-tab-'+id).click();
    } else {
        window.location.href = '/dashboard#ui-tabs-' + tabId;
    }
}

function checkContent (id) {
    var form = $('#form-post-edit-'+id),
        content = form.find('#post_content');
    
    if (content.val() == '') {
        content.val('image');
    }    
    return true;
}

function getCookie(name) {
    
    var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
    return matches ? decodeURIComponent(matches[1]) : undefined
    
}

function setCookie(name, value, options) {
  
  options = options || {};
  var expires = options.expires;
  if (typeof expires == "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires*1000);
    expires = options.expires = d;
    }
      if (expires && expires.toUTCString) {
            options.expires = expires.toUTCString();
      }
      value = encodeURIComponent(value);
      var updatedCookie = name + "=" + value;
      for(var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];   
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }
    document.cookie = updatedCookie;
}

function setOverPost(object) {
    //$(object).html('');
    if ($(object).val() == 'image') {
        $(object).val('');
    }
}

function ShowBlock (object, idName, id, statusOn, statusOff) {
    var status = $('#' + idName + id).css('display');
    switch(status) {
        case 'block': {
            $('#' + idName + id).css('display', 'none');
            $(object).html(statusOn);    
        }break;
        default: {
            $('#' + idName + id).css('display', 'block');
            $(object).html(statusOff);
        }break;
    }
}


function fnGetMetka(){
    var link;
    link = ""+location.href;

    var begPos = link.indexOf("#");
     if (begPos >= 0) {
         var metka = "";
         begPos += 1;
         while(link[begPos])
         {
             metka += link[begPos];
             begPos++;
         }
         return metka;
     }
     return "";
}