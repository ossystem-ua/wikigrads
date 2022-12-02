var bMenuShow = true;

jQuery(document).ready(function() {
    jQuery('.wiki-menu ul li a').each(function() {
        var location = window.location.href;
        var link = this.href;
        if (location == link) {
            var sDocText = "/documents/course/";
            var sCourseText = "/notification/course/";
            var doc = searchText(location, sDocText);
            var course = searchText(location, sCourseText);
            if (doc) {
                jQuery(".documents a").addClass('active-main-menu');
                jQuery(this).parent("li").addClass('active-context-menu');
            } else if (course) {
                jQuery(".courses a").addClass('active-main-menu');
                if (jQuery(this).attr('class') === 'active-main-menu') {
                    jQuery(this).parent("li").addClass('active-context-menu');
                }
            } else {
//                jQuery(this).addClass('active-main-menu');
//                jQuery(this).parent("li").addClass('active-context-menu');
            }
        } else {
            var sText = "/document";
            var doc = searchText(location, sText);
            if (doc) {
                jQuery(".documents a").addClass('active-main-menu');
            }
        }
    });

    function searchText(string, needle) {
        return !!(string.search(needle) + 1);
    }

    var currentMousePos = {x: -1, y: -1};
    var textAreaPost = 'Ask, discuss, blog...';

    jQuery('#post_content').val(textAreaPost);

    jQuery(document).mousemove(function(event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });

    var bResize = false;
    jQuery(window).resize(function() {
        var object = jQuery('.wiki-arrow-right input');


        if (jQuery(window).width() <= 690) {
            object.attr('src', '/images/new_design/wiki-signin.png');
        } else {
            object.attr('src', '/images/new_design/lg-btn.png');
        }

        // create main menu
        onCreateMainMenu();
        bResize = true;
        // resize window
        onWindowResize(jQuery(window).width(), jQuery(window).height());
    });

    // create main menu
    if (!bResize) {
        onCreateMainMenu();
    }

    jQuery('input').focusin(function() {
        onSetFocus(this);
    });

    jQuery('select').focusin(function() {
        onSetFocus(this);
    });

    jQuery('input').focusout(function() {
        onOutFocus(this)
    });

    jQuery('select').focusout(function() {
        onOutFocus(this)
    });

    jQuery('#wiki-doc-inp').live('focusin', function() {
        formFieldFocus(this, jQuery(this).attr('def-value'), 1);
    });

    jQuery('#wiki-doc-inp').live('focusout', function() {
        formFieldBlur(this, jQuery(this).attr('def-value'), 1);
    });

    jQuery('#wiki-doc-txt').live('focusin', function() {
        formFieldFocus(this, jQuery(this).attr('def-value'), 1);
    });

    jQuery('#wiki-doc-txt').live('focusout', function() {
        formFieldBlur(this, jQuery(this).attr('def-value'), 1);
    });

    jQuery('#createaccount').mouseover(function() {
        jQuery(this).css('class', 'wiki-over');
    });

    jQuery('#createaccount').mouseout(function() {
        jQuery(this).css('class', 'wiki-out');
    });

    jQuery('#wiki-nav-main-id').live('mouseover', function() {
        onMenuMoreShow();
    });

    jQuery('#wiki-nav-main-id').live('mouseout', function() {
        onMenuMoreHide();
    });

    jQuery('#wiki-more-a').live('click', function() {
        if (jQuery('#wiki-nav-main-id').css('display') == 'block') {
            onMenuMoreHide();
        } else {
            onMenuMoreShow(currentMousePos);
        }
    });

    jQuery('#wiki-more-a').live('mouseover', function() {
        onMenuMoreShow(currentMousePos);
    });

    jQuery('#wiki-more-a').live('mouseout', function() {
        onMenuMoreHide();
    });

    jQuery('.wg-post-block').live('mouseover', function() {
        var cls = jQuery(this).attr('class');
        if (cls.indexOf('wg-block-pin-post') < 0)
            jQuery(this).css('background-color', '#eeeeee');
    });

    jQuery('.wg-post-block').live('mouseout', function() {
        var cls = jQuery(this).attr('class');
        if (cls.indexOf('wg-block-pin-post') < 0)
            jQuery(this).css('background-color', '#ffffff');
    });

    jQuery('.wg-area-post textarea').focus(function() {
        if (jQuery('#post_content').val() == textAreaPost)
            jQuery('#post_content').val('');
//        jQuery(this).animate({height: 83 + 'px'}, 500);
    });

    jQuery('.wg-area-post textarea').blur(function() {
        if (jQuery('#post_content').val() == '')
            jQuery('#post_content').val(textAreaPost);
        jQuery(this).animate({height: 32 + 'px'}, 500);
    });

    jQuery('.wg-area-post textarea').focus(function() {
        var text = document.getElementById('post_content');
        function resize() {
            text.style.height = 'auto';
            text.style.height = text.scrollHeight + 'px';
            
        }
        /* 0-timeout to get the already changed text */
        function delayedResize() {
            window.setTimeout(resize, 500);
        }
        observe(text, 'change', resize);
        observe(text, 'cut', delayedResize);
        observe(text, 'paste', delayedResize);
        observe(text, 'drop', delayedResize);
        observe(text, 'keydown', delayedResize);
        text.focus();
        text.select();
        resize();
    });

    jQuery('.wg-textarea-no-border').live('focus', function () {
        var text = this;
        function resize() {
            text.style.height = 'auto';
            text.style.height = text.scrollHeight + 'px';
            if (text.scrollHeight > 40) {
                jQuery(text).parent().next().css('height', text.scrollHeight+'px');
                jQuery(text).parent().next().next().css('height', text.scrollHeight+'px');
                jQuery(text).parent().next().next().next().css('height', text.scrollHeight+'px');
            } else {
                jQuery(text).parent().next().css('height', '40px');
                jQuery(text).parent().next().next().css('height', '40px');
                jQuery(text).parent().next().next().next().css('height', '40px');
            }
        }
        /* 0-timeout to get the already changed text */
        function delayedResize() {
            window.setTimeout(resize, 0);
        }
        observe(text, 'change', resize);
        observe(text, 'cut', delayedResize);
        observe(text, 'paste', delayedResize);
        observe(text, 'drop', delayedResize);
        observe(text, 'keydown', delayedResize);
//        text.focus();
//        text.select();
        resize();
    });

    var observe;
    if (window.attachEvent) {
        observe = function(element, event, handler) {
            if (element)
                element.attachEvent('on' + event, handler);
        };
    } else {
        observe = function(element, event, handler) {
            if (element)
                element.addEventListener(event, handler, false);
        };
    }

    jQuery('.wg-none-href').live('click', function(e) {
        e.preventDefault();
    });

    jQuery('#wiki-select-menu').live('change', function() {
        var url = jQuery(this).val();
        if (url) {
            window.location.href = url;
        }
    })

    jQuery('#wg-post-button').click(function() {
        var post = jQuery('#post_content').val(),
            link = jQuery('#post_LinkData_url').val(),
            linkTitle = jQuery('#post_LinkData_title').val(),
//            equation = jQuery('#wg-equation-text').html(),
            doc = jQuery('#result-doc-id').val(),
            img = jQuery('#post_attachment_id').val();
        post = post.trim();
        jQuery('#wg-equation-text').html('');
        jQuery('#wg-show-equation-post').html('');
        
        if ((post != textAreaPost && post !== '') ||
            (doc && doc !== "0") || 
            (img && img !== "0") ||
            (linkTitle && link)/* ||
            (equation !== '' && equation !== undefined)*/) {

            if (post === '' || post === textAreaPost) {
                jQuery('#post_content').val(' ');
            }
            
//            if (equation !== '') {
//                jQuery('#wg-show-equation-post').hide();
//                jQuery('#equation-field').hide();
//            }
            
//            if (equation !== '' && (post === '' || post === ' ' || post === textAreaPost)) {
//                jQuery('#post_content').val(equation);
//            } else if (equation !== '' && (post !== '' && post !== ' ')) {
//                jQuery('#post_content').val(post+equation);
//            }
            
            var form = jQuery('#dashboard-post-form');
            form.find('input#tmp_course_id').val(jQuery('#post_course_id').val());

            //jQuery('#wg-loading-post').css('display', 'block');
            var template = jQuery('#wg-loading-post').clone();
            var tmpId = jQuery('#wg-loading-post').attr('data-id');
            var insertName = '#wg-load-insert';

            // set text
//            template.find('#ps-content-' + tmpId).html(htmlParserTag(jQuery('#post_content').val()));

            // set pin post
            if (jQuery('#post_is_pinned').is(':checked')) {
                var tempClass = template.find('#pinned-post-' + tmpId).attr('class');
                tempClass += ' wg-block-pin-post';
                template.find('#pinned-post-' + tmpId).attr('class', tempClass);
                insertName = '#wg-load-insert-pin';
            }

            var template_new_id = 'template-post-' + jQuery.now();
            template.find('#wiki-post-block-' + tmpId).attr('id', template_new_id);

            // set in insert block
            var insert = jQuery(insertName).html();
            jQuery(insertName).html(template.html() + insert);
            jQuery.ajax({
                url: form.attr('action'),
                type: "POST",
                data: form.serialize(),
                dataType: 'json',
                success: function(a, b, c) {
                    var result = JSON.parse(c.responseText),
                            c1 = 0,
                            c2 = 0;
                    jQuery('#hiddeFormLoadImage').trigger('reset');
                    jQuery('#hiddeFormLoadDoc').trigger('reset');
                    if (result.is_success) {
                        jQuery('#post_content').val(textAreaPost);
                        jQuery('#post_content').animate({height: 32 + 'px'}, 500);
                        jQuery("#wg-block-attach-doc span").html('');
                        jQuery("#wg-block-attach-img span").html('');
                        jQuery('#result-doc-id').val(0);
                        jQuery('#post_attachment_id').val(0);
                        jQuery('#post_attachment_url').val('');
                        jQuery('#wg-block-attach-img').css('display', 'none');
                        jQuery('#wg-block-attach-doc').css('display', 'none');
                        jQuery('#link-data').val("");
                        jQuery('.add-link').slideUp();
                        jQuery(".wiki-upload-image").hide();
                        jQuery(".wiki-upload-document").hide();
                        jQuery.ajax({
                            url: result.post_url,
                            isAutoLoad: 0,
                            method: 'GET'
                        }).done(function(data) {
                            jQuery(data).each(function(index, element) {
                                if (jQuery(element).attr('id') == 'wiki-notification-list' && c1 == 0) {

                                    jQuery('#wiki-notification-list').html(jQuery(element).html());
                                    c1++;
                                }
                                if (jQuery(element).attr('id') == 'autopager' && c2 == 0) {
                                    jQuery('#autopager').html(jQuery(element).html());
                                    c2++;
                                }
                            });
                            jQuery('#' + template_new_id).remove();
                        });
                    }
                },
                xhr: function() {
                    var myXhr = jQuery.ajaxSettings.xhr();
                    return myXhr;
                }
            });
            jQuery('#wg-dash-form').html('');
            cleanLinkDataFields();
        } else {
            if (jQuery('#result-doc-id').val() > 0 || jQuery('#post_attachment_id').val() > 0) {
                jQuery('#post_content').val(' ');
                jQuery('#wg-post-button').click();
            } else {
                jQuery('#wg-dash-form').html('Required. Please, type a post.');
            }
        }
    });

    // SCROLL
    var inProgress = false;


    jQuery('#autopager').on('click', 'a', function() {
        return false;
    });
    jQuery(window).scroll(function() {
        if ((jQuery(window).scrollTop() + jQuery(window).height()) >= (jQuery(document).height() - 200) && !inProgress) {
            jQuery("#autopager.autopager-container a").addClass('progressBar');

            var link = '';
            jQuery('#autopager').find('a').each(function() {
                link = jQuery(this).attr('href');
                jQuery.ajax({
                    url: link,
                    method: 'POST',
                    data: {"isAutoLoad": 1},
                    beforeSend: function() {
                        inProgress = true;
                    },
                    success: function() {
                        inProgress = false;
                    },
                    failure: function() {
                        inProgress = false;
                    }

                }).done(function(data) {

                    // get current html
                    var appendedHtml;

                    // get new content html
                    var newAutopage = '', c1 = 0, c2 = 0, t;
                    jQuery(data).each(function(index, element) {
                        if (jQuery(element).attr('id') === 'wiki-notification-list' && c1 === 0) {
                            t = jQuery(element).html();
                            if (t.length > 100) {
                                appendedHtml = t;
                            } else {
                                c2++;
                            }
                            c1++;
                        }
                        if (jQuery(element).attr('id') === 'autopager' && c2 === 0) {
                            newAutopage = jQuery(element).html();
                            jQuery('#autopager').html('The end');
                            c2++;
                        }
                    });
                    var tempEditText = jQuery('.wg-edit-area').val();
                    jQuery('#wiki-notification-list').append(appendedHtml);

                    jQuery('.wg-edit-area').val(tempEditText);
                    jQuery('#autopager').html(newAutopage);
//                    jQuery('.wg-edit-area').attr('value', 'Add to the conversation');

                    jQuery('.wg-edit-area').live('focus', function() {
                        if (jQuery(this).val() === 'Add to the conversation' || jQuery('.wg-edit-area').val() === ' ') {
                            jQuery(this).val('');
                            jQuery(this).html('');
                        }
                    });

                    jQuery('.wg-edit-area').live('blur', function() {
                        if (jQuery(this).val() === '' || jQuery('.wg-edit-area').val() === ' ') {
                            jQuery(this).val('Add to the conversation');
                            jQuery(this).html('');
                        }
                    });

                    inProgress = false;
                });
                return;
            });
        }
    });

    // create main menu
    if (!bResize) {
        onCreateMainMenu();
    }

    // run notifications counter
    update_counters();

    var at = "right-100 top-5";

    jQuery(".tooltip").tooltip({
        position: {
            my: "left bottom",
            at: at,
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });
    
    jQuery(".tooltip2").tooltip({
        position: {
            my: "left bottom",
            at: "right-25 top-20",
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });
    
    jQuery(".tooltip3").tooltip({
        position: {
            my: "left bottom",
            at: "center-10 top-10",
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });
    
    jQuery(".tooltip4").tooltip({
        position: {
            my: "left bottom",
            at: "center-25 top-10",
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });
    
    jQuery(".tooltip5").tooltip({
        position: {
            my: "left bottom",
            at: "center-25 top-30",
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });
    
    jQuery(".tooltip6").tooltip({
        position: {
            my: "left bottom",
            at: "center-50 top-15",
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });
    
//    jQuery(".wg-post-link").on("mouseenter", "" , actionTooltip);
    
    //upload user avatar
    jQuery('#my-profile').on('click', '.avatar-overlay', function() {});

    jQuery('#wg-profile-ava').live('click', function() {
        jQuery('#file-ava').click();
    });
    
    jQuery('.user-about-editor textarea').focus(function() {
        var defText = 'Add a brief description about yourself';
        if (jQuery(this).val() === defText) {
            jQuery(this).val('');
        }
    });
    jQuery('.user-about-editor textarea').blur(function() {
        var defText = 'Add a brief description about yourself';
        if (jQuery(this).val() === '') {
            jQuery(this).val(defText);
        }
    });
    jQuery('.user-interests-editor textarea').focus(function() {
        var defText = 'Add a few of your interests.';
        if (jQuery(this).val() === defText) {
            jQuery(this).val('');
        }
    });
    jQuery('.user-interests-editor textarea').blur(function() {
        var defText = 'Add a few of your interests.';
        if (jQuery(this).val() === '') {
            jQuery(this).val(defText);
        }
    });
    
    jQuery('#my-profile').on('click', '#edit-graduate-info', function(e) {
        e.preventDefault();
        jQuery('.user-graduate, .user-major').slideUp({'done': function() {
                jQuery(this).closest('.user-info').next('.user-graduate-editor').slideDown();
            }
        });
    });
    jQuery('#my-profile').on('click', '#edit-about-info', function(e) {
        e.preventDefault();
        var bd = jQuery(this).closest('.user-about').children('.brief-description');
        if (bd.length) {
            bd.hide({'done': function() {
                    jQuery('.user-about-editor').slideDown();
                }
            });
        } else {
            jQuery('.user-about-editor').slideDown();
        }
    });
    jQuery('#my-profile').on('click', '#edit-interests-info', function(e) {
        e.preventDefault();
        var bd = jQuery(this).closest('.user-interests').children('.brief-description');
        if (bd.length) {
            bd.hide({'done': function() {
                    jQuery('.user-interests-editor').slideDown();
                }
            });
        } else {
            jQuery('.user-interests-editor').slideDown();
        }
    });
    jQuery('#my-profile').on('click', '#join-course', function(e) {
        e.preventDefault();
        var bd = jQuery(this).closest('.user-courses').children('.brief-description');
        if (bd.length) {
            bd.hide({'done': function() {
                    jQuery('.join-course-box').slideDown();
                }
            });
        } else {
            jQuery('.join-course-box').slideDown();
        }
    });
    jQuery('#my-profile').on('click', '#create-course', function(e) {
        e.preventDefault();
        var bd = jQuery(this).closest('.user-courses').children('.brief-description');
        if (bd.length) {
            bd.hide({'done': function() {
                    jQuery('.create-course-box').slideDown();
                }
            });
        } else {
            jQuery('.create-course-box').slideDown();
        }
    });
    jQuery('#my-profile').on('click', '#join-community', function(e) {
        e.preventDefault();
        var bd = jQuery(this).closest('.user-communities').children('.brief-description');
        if (bd.length) {
            bd.hide({'done': function() {
                    jQuery('.join-community-box').slideDown();
                }
            });
        } else {
            jQuery('.join-community-box').slideDown();
        }
    });
    jQuery('#my-profile').on('click', '.cansel-graduate-editor', function(e) {
        e.preventDefault();
        jQuery(this).closest('.user-graduate-editor').slideUp({'done': function() {
                jQuery('.user-graduate, .user-major').slideDown();
            }
        });
    });
    jQuery('#my-profile').on('click', '.cancel-button', function(e) {
        e.preventDefault();
        jQuery(this).closest('.editbox').slideUp({'done': function() {
                jQuery('.brief-description').slideDown();
            }
        });
    });
    jQuery('#my-profile').on('click', '#remove-course', function(e) {
        var object = jQuery(this);
        e.preventDefault();
        jConfirm('Remove course?', 'Delete course', function(result) {
            //remove course
            if (result) {
                jQuery.ajax({url: object.attr('href')}).done(function() {
                    window.location.href = window.location.href;
                });
                object.remove();

            }
        });
    });
    jQuery('#my-profile').on('click', '#leave-community', function(e) {
        var object = jQuery(this);
        e.preventDefault();
        jConfirm('Are you sure to leave community?', 'Delete community', function(result) {
            //leave community
            if (result) {
                jQuery.ajax({url: object.attr('href')}).done(function() {
                    window.location.href = window.location.href;
                });
                object.remove();
            }
        });
    });

    jQuery('#wiki-button-load-image').live('click', function() {
        var input = jQuery('#files'),
            form = jQuery('#hiddeFormLoadImage');
        input.click();
    });

    jQuery('#files').live('change', function() {

        var fileUrl = jQuery('#hiddeFormLoadImage input[name]').val();
        jQuery('#hiddeFormLoadImage input[name]').val();
        var ex = fileExt(fileUrl, "img");
        if (ex == 0) {
            jQuery('#showWinLoad').css('display', 'block');
            jQuery('body').css('overflow', 'hidden');
            jQuery('#hiddeFormLoadImage input[name]').val('');
            jQuery('#wg-dash-form').html('Error file type. Allowed types: ".jpg", ".jpeg", ".png", ".gif"');
            showWinLoad(false);
            onCloseWin();
        } else {
            jQuery('#wg-dash-form').html('');
        }

        var formData = new FormData(jQuery('#hiddeFormLoadImage')[0]);
        showWinLoad(true);
        jQuery.ajax({
            url: '/useruploads', //Server script to process data
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(a, b, c) {
                var result = JSON.parse(c.responseText),
                        object = result[0];

                if (object.error == 0) {
                    if (object.id > 0) {
                        jQuery("#post_attachment_id").val(object.id);
                        jQuery("#post_attachment_url").val(object.url);
                        OnSetAttach('wg-block-attach-img', object.id);
                        jQuery('#wiki-button-load-image').html('<img src="' + object.url + '" style="width: 100%;" />');
                        jQuery('.wiki-center .loader').show();
                        // #post_content
                    }
                }
                showWinLoad(false);

                setTimeout(function() {
                    onCloseWin();
                }, 3500);
            },
            failure: function() {
                showWinLoad(false);
            }
        });
    });

    jQuery('#wiki-button-load-doc').live('click', function() {
        jQuery('#docs').click();
        jQuery('#doc-course-id').val(jQuery('#post_course_id').val());
    });

    jQuery('#docs').live('change', function() {
        var fileName = jQuery('#hiddeFormLoadDoc input[name]').val();
        var fileUrl = fileName,
                      parts,
                      ext = (parts = fileUrl.split("/").pop().split(".")).length > 1 ? parts.pop() : "";
        switch(ext) {
            case "doc":
            case "docx":
            case "rtf":
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-doc.png" style="width: 100%;" />');
                break;
            case "xls":
            case "xlsx":
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-xls.png" style="width: 100%;" />');
                break;
            case "ppt":
            case "pptx":
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-ppt.png" style="width: 100%;" />');
                break;
            case "odt":
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-odt.png" style="width: 100%;" />');
                break;
            case "ods":
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-ods.png" style="width: 100%;" />');
                break;
            case "odp":
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-odp.png" style="width: 100%;" />');
                break;
            case "pdf":
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-pdf.png" style="width: 100%;" />');
                break;
            case "jpg":
            case "jpeg":
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-jpg.png" style="width: 100%;" />');
                break;
            case "png":
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-png.png" style="width: 100%;" />');
                break;
            case "gif": 
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-gif.png" style="width: 100%;" />');
                break;
            case "txt":
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-txt.png" style="width: 100%;" />');
                break;
            case "djvu":
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document-djvu.png" style="width: 100%;" />');
                break;
            case "":
                jQuery('#wiki-button-load-doc').html('Preview');
                break;
            default:
                jQuery('#wiki-button-load-doc').html('<img src="/../images/new_design/wg-document.png" style="width: 100%;" />');
                break;
        }
    });



    jQuery('.wiki-form-submit-profile').click(function() {

        var object = this,
                form = jQuery('#form_user_edit'),
                btn_close = jQuery(object).attr('data-close'),
                about = jQuery('textarea[name="sf_guard_user_profile[about]"]').val(),
                interests = jQuery('textarea[name="sf_guard_user_profile[activity]"]').val(),
                major = jQuery('.user-graduate-editor input').val(),
                class_year = jQuery('.user-graduate-editor .class-year-select select').val();
                
        if (btn_close == 'wg-close-button-1') {
            jQuery('textarea[name="sf_guard_user_profile[activity]"]').val(jQuery.trim(jQuery('#interests').text()));
            jQuery('input[name="sf_guard_user_profile[test_school][major]"]').val(jQuery.trim(jQuery('.user-major').text()).substring(12, 1000));
            jQuery('select[name="sf_guard_user_profile[test_school][class_year]"]').val(jQuery.trim(jQuery('.user-graduate').text()).substring(9, 13));
        } else if (btn_close == 'wg-close-button-2') {
            jQuery('textarea[name="sf_guard_user_profile[about]"]').val(jQuery.trim(jQuery('#about').text()));
            jQuery('input[name="sf_guard_user_profile[test_school][major]"]').val(jQuery.trim(jQuery('.user-major').text()).substring(12, 1000));
            jQuery('select[name="sf_guard_user_profile[test_school][class_year]"]').val(jQuery.trim(jQuery('.user-graduate').text()).substring(9, 13));
        } else if (btn_close == 'wg-close-button-3') {
            jQuery('textarea[name="sf_guard_user_profile[about]"]').val(jQuery.trim(jQuery('#about').text()));
            jQuery('textarea[name="sf_guard_user_profile[activity]"]').val(jQuery.trim(jQuery('#interests').text()));
        }

        jQuery.ajax({
            url: form.attr('action'),
            method: 'GET',
            type: 'post',
            data: form.serialize(),
            success: function(data, textStatus, XMLHttpRequest) {
                var strip = function(html) {
                    var tmp = document.createElement("DIV");
                    tmp.innerHTML = html;
                    return tmp.textContent || tmp.innerText || "";
                }

                if (about === '' || about === 'Add a brief description about yourself') {
                    jQuery('#about').html('Add a brief description about yourself');
                    jQuery('textarea[name="sf_guard_user_profile[about]"]').val('Add a brief description about yourself');
                } else if (about === jQuery('textarea[name="sf_guard_user_profile[about]"]').val()) {
                    jQuery('#about').html(jQuery('textarea[name="sf_guard_user_profile[about]"]').val());
                } else {
                    jQuery('#about').html(jQuery('textarea[name="sf_guard_user_profile[about]"]').val());
                    jQuery('textarea[name="sf_guard_user_profile[about]"]').val(about);
                }
                
                if (interests === '' || interests === 'Add a few of your interests.') {
                    jQuery('#interests').html('Add a few of your interests.');
                    jQuery('textarea[name="sf_guard_user_profile[activity]"]').val('Add a few of your interests.');
                } else if (interests === jQuery('textarea[name="sf_guard_user_profile[activity]"]').val()) {
                     jQuery('#interests').html(jQuery('textarea[name="sf_guard_user_profile[activity]"]').val());
                } else {
                    jQuery('#interests').html(jQuery('textarea[name="sf_guard_user_profile[activity]"]').val());
                    jQuery('textarea[name="sf_guard_user_profile[activity]"]').val(interests);
                }

                if (major === '' || major == 'Major') {
                    jQuery('.user-major').html('');
                } else {
                    jQuery('.user-major').html("Majoring in " + strip(major));
                }
                
                if (class_year === '') { 
                    jQuery('.user-graduate').html('');
                } else {
                    jQuery('.user-graduate').html("Class of " + strip(class_year));
                }

                if (btn_close) {
                    jQuery('#' + btn_close).click();
                }
            }
        }, this);
    });

    jQuery('#wiki-sel-dep').live('change', function() {
        var object = this,
                departId = jQuery(object).val(),
                url = jQuery(object).attr('data-url');
        jQuery.ajax({
            url: url,
            method: 'post',
            data: {department_id: departId},
            success: function(data, textStatus) {
                jQuery('#wg-edit-course-box').html(data);
            }
        });
    });

    jQuery('.wg-form-add-course').live('click', function() {
        var object = this;
        jQuery('#' + jQuery(object).attr('data-con')).click();

        onAccessAddCourse('/add-one-course', jQuery('#wiki-sel-dep').val(), jQuery('#wiki-sel-course').val(), jQuery('#wiki-sel-cat').val());

    });

    jQuery('.wg-form-add-instructor-course').live('click', function() {
        var object = this;
        jQuery('#' + jQuery(object).attr('data-con')).click();

        onAccessAddInstructorCourse(
                '/add-one-instructor-course',
                jQuery('#department_name').val(),
                jQuery('#department_alias').val(),
                jQuery('#course_code').val(),
                jQuery('#course_name').val(),
                jQuery('#school_id').val()
                );
    });

    // radio emails
    var email_post = jQuery('#sf_guard_user_profile_email_post');
    var email_reply = jQuery('#sf_guard_user_profile_email_reply');
    var email_from = jQuery('#sf_guard_user_profile_email_from');
    var email_private = jQuery('#sf_guard_user_profile_email_private');

    email_from.on("click", function() {
        if (jQuery(this).is(':checked')) {
            email_post.prop('checked', false);
            email_reply.prop('checked', false);
            email_private.prop('checked', false);
        }
        
        if (!email_post.is(":checked") && 
            !email_reply.is(":checked") && 
            !email_private.is(":checked")) {
                email_from.prop('checked', true);
        }
    });

    email_post.on("click", function() {
        if (jQuery(this).is(':checked')) {
            email_from.prop('checked', false);
            email_reply.prop('checked', false);
            email_private.prop('checked', false);
        }
        
        if (!email_post.is(":checked") && 
            !email_reply.is(":checked") && 
            !email_private.is(":checked")) {
                email_from.prop('checked', true);
        }
    });

    email_reply.on("click", function() {
        if (jQuery(this).is(':checked')) {
            email_from.prop('checked', false);
            email_post.prop('checked', false);
            email_private.prop('checked', false);
            
        }
        
        if (!email_post.is(":checked") && 
            !email_reply.is(":checked") && 
            !email_private.is(":checked")) {
                email_from.prop('checked', true);
        }
    });
    
    email_private.on("click", function() {
        if (jQuery(this).is(':checked')) {
            email_post.prop('checked', false);
            email_reply.prop('checked', false);
            email_from.prop('checked', false);
        }
        
        if (!email_post.is(":checked") && 
            !email_reply.is(":checked") && 
            !email_private.is(":checked")) {
                email_from.prop('checked', true);
        }
    });
    
    if (!jQuery("input:radio[name='sf_guard_user_profile[enter_code]']:checked").val()) {
        jQuery('#wg-radion-def').click();
    }

    jQuery('#wg-save-all-changes').live('click', function(e) {
        e.preventDefault();
        var form = jQuery('#form_user_edit');

        var enter_code = 0, email_post = 0, email_reply = 0, email_from = 0, email_private = 0;
        form.find('input').each(function(index, object) {
            switch (jQuery(object).attr('id')) {
                case 'sf_guard_user_profile_enter_code':
                    {
                        if (jQuery(object).is(':checked')) {
                            enter_code = jQuery(object).val();
                        }
                    }
                    break;
                case 'sf_guard_user_profile_email_post':
                    {
                        if (jQuery(object).is(':checked'))
                            email_post = 1;
                    }
                    break;
                case 'sf_guard_user_profile_email_reply':
                    {
                        if (jQuery(object).is(':checked'))
                            email_reply = 1;
                    }
                    break;
                case 'sf_guard_user_profile_email_from':
                    {
                        if (jQuery(object).is(':checked'))
                            email_from = 1;
                    }
                    break;
                case 'sf_guard_user_profile_email_private':
                    {
                        if (jQuery(object).is(':checked'))
                            email_private = 1;
                    }
                    break;
            }
        });

        jQuery.ajax({
            url: '/editemails',
            method: 'post',
            type: 'post',
            data: {
                enter_code: enter_code,
                email_post: email_post,
                email_reply: email_reply,
                email_from: email_from,
                email_private: email_private
            },
            success: function(data, textStatus, XMLHttpRequest) { 
                // save change
                window.location.href = window.location.href;
            }
        });

    });

    jQuery('#file-ava').live('change', function() {
        var form = jQuery('#form_user_edit');
        jQuery.ajax({
            url: form.attr('action'),
            method: 'POST',
            type: 'post',
            data: new FormData(form[0]),
            cache: false,
            contentType: false,
            processData: false,
            success: function(data, textStatus, XMLHttpRequest) {
                // save change
                window.location.href = window.location.href;
            }
        });
    });

    jQuery('#wg-update-email').live('click', function() {
        var value = jQuery('#wg-new-email').val();

        if (!isValidEmailAddress(value) || value.length <= 0) {
            jQuery('#wg-email-status').html('Required - example format (xxx@xxx.xx)');
            jQuery('#status-email').html('');
        } else {
            jQuery.ajax({
                url: '/editemail',
                data: {
                    email: value
                },
                success: function(data) {
                    var object = JSON.parse(data);
                    jQuery('#status-email').html(object.msg);
                    jQuery('#wg-email-status').html('');
                    jQuery('#wg-new-email').val('');
                }
            });
        }
    });

    jQuery('#wg-update-pass').live('click', function() {
        var currentPass = jQuery('#wg-pass-current').val();
        var newPass1 = jQuery('#wg-pass-new-1').val();
        var newPass2 = jQuery('#wg-pass-new-2').val();

        jQuery.ajax({
            url: '/editpass',
            data: {
                currentPass: currentPass,
                newPass1: newPass1,
                newPass2: newPass2
            },
            success: function(data) {
                var object = JSON.parse(data);
                jQuery('#status-pass').html(object.msg);
            }
        });
    });

    jQuery('#wg-set-course-button').live('click', function(e) {
        e.preventDefault();
        var access = jQuery('#wg-code-edit').val();
        var course = jQuery('#wg-course-edit').val();
        var cName  = jQuery('#wg-course-edit option[value="'+course+'"]').html();
        jQuery.ajax({
            url: '/editaccess',
            data: {
                access: access,
                course: course
            },
            success: function(data) {
                var object = JSON.parse(data);
                jQuery('#status-access-' + course).html(object.access);
                if (jQuery('#course-instructor-'+course).length <= 0) {
                    var tRow  = '<tr id="course-instructor-'+course+'">';
                        tRow += '<td class="code-course">'+cName+'</td>';
                        tRow += '   <td class="code value">';
                        tRow += '       <div class="code-value-inner">';
                        tRow += '           <span id="status-access-'+course+'">'+object.access+'</span>';
                        tRow += '           <div class="remove-icon">';
                        tRow += '               <a class="wg-course-delete" data-id="'+course+'" href="/ajax/delete-course/'+course+'" class="tooltip4 leave-community" title="Delete code">';
                        tRow += '                   <img src="/images/new_design/wiki-close.png" width="14px" height="14px"';
                        tRow += '               </a>';
                        tRow += '           </div>';
                        tRow += '       </div>';
                        tRow += '   </td>';
                        tRow += '</tr>';
                    jQuery('.code-list tbody').append(tRow);
                }
            }
        });
    });

    jQuery(".wg-delete-coure-code").on('click', function(e) {
        e.preventDefault();
        var id = jQuery(this).attr('data-id');
        if (id) {
            jQuery.ajax({
                url: '/deleteAccess',
                data: {
                    dataId: id
                },
                success: function(data) {
                    jQuery('#course-instructor-' + id).remove();
                }
            });
        }
    });

    jQuery('.wg-course-delete').live('click', function(e) {
        e.preventDefault();
        var id = jQuery(this).attr('data-id');
        if (id) {
            jQuery.ajax({
                url: '/delaccess',
                data: {
                    dataId: id
                },
                success: function(data) {
                    var newPost = parseInt(jQuery('#post-not-' + id).html(), 10),
                        newPrivate = parseInt(jQuery('#private-not-' + id).html(), 10),
                        sumNewPost = parseInt(jQuery('#post-not-sum').html(), 10),
                        sumNewPrivate = parseInt(jQuery('#post-private-sum').html(), 10);
                    if (isNaN(newPost) && newPost !== 0 && isNaN(sumNewPost) && sumNewPost !== 0) {
                        sumNewPost = sumNewPost - newPost;
                        if (sumNewPost === 0) {
                            jQuery('#post-not-sum').hide();
                        } else {
                            jQuery('#post-not-sum').html(sumNewPost);
                        }
                    }
                    if (isNaN(newPrivate) && newPrivate !== 0 && isNaN(sumNewPrivate) && sumNewPrivate !== 0) {
                        sumNewPrivate = sumNewPrivate - newPrivate;
                        if (sumNewPrivate === 0) {
                            jQuery('#post-private-sum').hide();
                        } else {
                            jQuery('#post-private-sum').html(sumNewPrivate);
                        }
                    }
                    jQuery('#course-instructor-' + id).remove();
                    jQuery('#course-' + id).remove();
                    jQuery('.main-line-id-' + id).prev().remove();
                    jQuery('.main-line-id-' + id).prev().remove();
                    jQuery('.main-line-id-' + id).remove();
                    jQuery('.left-line-id-' + id).remove();
                    jQuery('#post-not-' + id).parent().remove();
                    jQuery('#private-not-' + id).parent().remove();
                    jQuery('a[href="/my-students/' + id +'"]').parent().remove();
                }
            });
        }
    });

    jQuery('.img-upl').live('click', function(e) {
        var id = jQuery(this).attr('data-id'), i = 0;
        jQuery('#hiddeFormLoadImageComment-' + id).trigger('reset');

        jQuery('.files-comment-' + id).live('change', function() {
            if (i > 0) {
                return;
            }
            i++;
            var id = jQuery(this).attr('data-id');
            var fileUrl = jQuery('#hiddeFormLoadImageComment-' + id + ' input[name]').val();
            var ex = fileExt(fileUrl, "img");
            if (ex == 0) {
                jQuery('#wg-status-comm-' + id + ' .wg-required').empty();
                if (jQuery('#wg-status-comm-' + id + ' .wg-required').text() != 'File type error')
                    jQuery('#wg-status-comm-' + id).prepend('<span class="wg-required" style="margin-left: 10px;">Error file type. Allowed types: ".jpg", ".jpeg", ".png", ".gif"</span>');
                jQuery('#hiddeFormLoadImageComment-' + id).trigger('reset');
                return false;
            } else {
                jQuery('#wg-status-comm-' + id + ' .wg-required').empty();
            }

            var formData = new FormData(jQuery('#hiddeFormLoadImageComment-' + id)[0]);
            showWinLoad(true);
            jQuery.ajax({
                url: '/useruploads', //Server script to process data
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(a, b, c) {
                    var result = JSON.parse(c.responseText),
                            object = result[0];

                    if (object.error == 0) {
                        if (object.id > 0) {
                            jQuery("#com-att-id-" + id).val(object.id);
                            jQuery("#com-att-url-" + id).val(object.url);

                            // set status
                            jQuery('#wiki-comm-attach-img-' + id + ' span').html(object.original_name);
                            jQuery('#wiki-comm-attach-img-' + id).attr('style', '');
                        }
                    }
                    showWinLoad(false);
                },
                failure: function() {
                    showWinLoad(false);
                }
            });
        });
        jQuery('.files-comment-' + id).click();
    });

    jQuery('.doc-upl').live('click', function(e) {
        var id = jQuery(this).attr('data-id'), i = 0;
        jQuery('#hiddeFormLoadDocComment-' + id).trigger('reset');
        jQuery('.docs-comment-' + id).live('change', function() {
            var id = jQuery(this).attr('data-id');
            if (i > 0) {
                return;
            }
            i++;

            var fileUrl = jQuery('#hiddeFormLoadDocComment-' + id + ' input[name]').val();
            var ex = fileExt(fileUrl, "doc");

            if (ex == 0) {
                jQuery('#wg-status-comm-' + id + ' .wg-required').empty();
                if (jQuery('#wg-status-comm-' + id + ' .wg-required').text() !== 'File type error')
                    jQuery('#wg-status-comm-' + id).prepend('<span class="wg-required" style="margin-left: 10px;">Error file type. Allowed types: ".docx", ".xlsx", ".pptx", ".doc", ".xls", ".ppt", ".txt", ".rtf", ".jpg", ".jpeg", ".gif", ".png", ".pdf", ".djvu"</span>');
                jQuery('#hiddeFormLoadDocComment-' + id).trigger('reset');
                return false;
            } else {
                jQuery('#wg-status-comm-' + id + ' .wg-required').empty();
            }

            var form = jQuery('#hiddeFormLoadDocComment-' + id);
            var formData = new FormData(form[0]);
            showWinLoad(true);
            jQuery.ajax({
                url: form.attr('action'),
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(a, b, c) {
                    var result = JSON.parse(c.responseText);
                    jQuery('#com-doc-id-' + id).val(parseInt(result.id));
                    // set status
                    jQuery('#wiki-comm-attach-doc-' + id + ' span').html(result.name);
                    jQuery('#wiki-comm-attach-doc-' + id).attr('style', '');
                    jQuery('#hiddeFormLoadDocComment-' + id).trigger('reset');
                    showWinLoad(false);
                },
                failure: function() {
                    showWinLoad(false);
                }
            });
        });
        jQuery('.docs-comment-' + id).click();
    });

    jQuery('#wiki-nav-main-id').mouseover(function() {
        jQuery('#wiki-nav-main-id').css('display', 'block');
    });

    if (jQuery('div.login-error').length) {
        alert(jQuery('div.login-error').html());
    }
    ;

    jQuery('.vm-holder a').live('click', function(e) {
        e.preventDefault();
        var id = jQuery(this).attr('data-id');
        jQuery(this).hide();
        jQuery('div[data-id="' + id + '"]').show();
    });

    // Run check
    if (jQuery('#post_content')) {
        //CKEDITOR.replace('post_content');

        setTimeout(function() {
        }, 1000);

    }

    jQuery('.cke_wysiwyg_frame').focusin(function() {
        //jQuery('#cke_1_contents').animate({height: 150 + 'px'}, 500);
    });

    jQuery('#tb-button-add').live('click', function() {
        var object, value;

        // element 1
        object = jQuery('#tb-require-select-1');
        if (object) {
            value = jQuery('#tb-require-select-1').val();
            if (value <= 0) {
                jQuery('#status-require-1').html('Require');
            }
        }

        // element 2
        object = jQuery('#tb-require-select-2');
        if (object) {
            value = jQuery('#tb-require-select-2').val();
            if (value <= 0) {
                jQuery('#status-require-2').html('Require');
            }
        }
    });

    jQuery('.input-access').live('change', function() {
        var dataId = jQuery(this).attr('data-id'),
                value = jQuery(this).val();
        if (dataId) {
            jQuery.ajax({
                url: '/editaccess',
                data: {
                    access: value,
                    course: 0,
                    recordId: dataId
                },
                success: function(data) {
                    var object = JSON.parse(data);
                }
            });
        }
    });

    jQuery('.remove-instructor-course').live('click', function(e) {
        e.preventDefault();
        var me = this;
        jConfirm('Delete instructor from course?', 'Delete', function(result) {
            if (result) {
                var url = jQuery(me).attr('href');
                var dataId = jQuery(me).attr('data-id');
                if (!dataId)
                    return false;

                jQuery.ajax({
                    url: url,
                    data: {
                        id: dataId
                    },
                    success: function(data) {
                        var object = JSON.parse(data);
                        if (object.status == 1) {
                            jQuery('#block-course-' + dataId).remove();
                        }
                    }
                });
            }
        });
    });

    jQuery('.wg-tb-tr').live('mouseover', function() {
        var dataId = jQuery(this).attr('data-id');
        jQuery('.tb-a-sys-' + dataId).css('opacity', '1');
    });

    jQuery('.wg-tb-tr').live('mouseout', function() {
        var dataId = jQuery(this).attr('data-id');
        jQuery('.tb-a-sys-' + dataId).css('opacity', '0');
    });

    jQuery('.wg-join-course').live('click', function(e) {
        e.preventDefault();
        var dataId = jQuery(this).attr('data-id');
        var url = jQuery(this).attr('href');

        jConfirm('Are you sure to join to the course?', 'Join to course', function(result) {
            if (result) {
                jQuery.ajax({
                    url: url,
                    data: {
                        courseId: dataId
                    },
                    success: function(data) {
                        var object = JSON.parse(data);
                        if (object.status == 1) {
                            window.location.href = window.location.href;
                        }
                    }
                });
            }
        });
    });

    jQuery('.document-menu').mouseover(function() {
        jQuery('#wiki-main-menu-document-list').removeClass('wiki-hide');
        jQuery('#wiki-main-menu-document-list ul').addClass('document-menu-list');
        jQuery('.documents a').addClass('documents-hover');
    });
    jQuery('.document-menu').mouseout(function() {
        jQuery('#wiki-main-menu-document-list').addClass('wiki-hide');
        jQuery('.documents a').removeClass('documents-hover');
    });

    jQuery('.course-menu').mouseover(function() {
        jQuery('#wiki-main-menu-course-list').removeClass('wiki-hide');
        jQuery('#wiki-main-menu-course-list ul').addClass('course-menu-list');
        jQuery('.courses a').addClass('courses-hover');
    });
    jQuery('.course-menu').mouseout(function() {
        jQuery('#wiki-main-menu-course-list').addClass('wiki-hide');
        jQuery('.courses a').removeClass('courses-hover');
    });

    /*
     *
     * main menu
     * 19.06.2014
     *
     */
    jQuery('ul#wiki-main-menu ul').each(function(index) {
        jQuery(this).prev().addClass('collapsible').click(function() {
            if (jQuery(this).next().css('display') == 'none') {
                jQuery(this).next().slideDown(200, function() {
                    jQuery(this).prev().removeClass('collapsed').addClass('expanded');
                });
            } else {
                jQuery(this).next().slideUp(200, function() {
                    jQuery(this).prev().removeClass('expanded').addClass('collapsed');
                    jQuery(this).find('ul').each(function() {
                        jQuery(this).hide().prev().removeClass('expanded').addClass('collapsed');
                    });
                });
            }
            return false;
        });
    });

    jQuery('ul#wiki-main-menu-course ul').each(function(index) {
        jQuery(this).prev('a').addClass('collapsible').click(function() {
            if (jQuery(this).next().css('display') == 'none') {
                jQuery(this).next().slideDown(200, function() {
                    jQuery(this).prev().addClass('active-main-menu');
                    jQuery(this).prev().removeClass('collapsed').addClass('expanded');
                });
            } else {
                jQuery(this).next().slideUp(200, function() {
                    jQuery(this).prev().removeClass('expanded').addClass('collapsed');
                    jQuery(this).prev().removeClass('active-main-menu');
                    jQuery(this).find('ul').each(function() {
                        jQuery(this).hide().prev().removeClass('expanded').addClass('collapsed');
                    });
                });
            }
            return false;
        });
    });


    /*
     *
     * filter menu on "Course Feed" and "Private Feed"
     * 19.06.2014
     *
     */
    jQuery('span#post-filter').click(function() {
        if (jQuery(this).next().css('display') == 'none') {
            jQuery(this).addClass('open-filter');
            jQuery(this).removeClass('close-filter');
            jQuery(this).next().slideDown(200);
        } else {
            jQuery(this).removeClass('open-filter');
            jQuery(this).addClass('close-filter');
            jQuery(this).next().slideUp(200);
        }
    });

    jQuery('.filter-item').click(function() {
       jQuery(this).parent().each(function(index) {
          jQuery('li.active').removeClass('active');
       });
       jQuery(this).addClass('active');
       jQuery(this).parent().prev().html('View: '+jQuery(this).html());

       var url = window.location.href,
           filter = jQuery(this).html(),
           filterNumber = 0;
           
       if (filter === 'Instructor content') {
           filter = 'instructorContent';
       }
       
       switch (filter) {
           case 'All': filterNumber = 0; break;
           case 'Documents': filterNumber = 2; break;
           case 'Images': filterNumber = 3; break;
           case 'Links': filterNumber = 4; break;
           case 'Insructor content': filterNumber = 1; break;
           default: filterNumber = 0;
       }

       jQuery.ajax({
           url: url,
           data: {
               filter: filter
           },
           success: function(html) {
               window.location.href = window.location.href;
           }
       });
    });

    jQuery("#wiki-doc-txt").maxlength();
    
    jQuery('#link-data').keyup(function(eventObject) {
        var curLength = jQuery('#link-data').val().length;
        var symbol = eventObject.which; //32
        if (symbol === 32) {
            data = jQuery('#link-data').val();
            url = jQuery('#scrape_url_address').val();
            data = checkUrlExistence(data);
            scrapeUrl( url, data );
        }
    });

    jQuery(".wiki-button-instructor").click(function(){
        jQuery(".signin-buttons").slideToggle();
    });

    jQuery('#link-data').keypress(function (event) {
        if (event.which == '13') {
            event.preventDefault();
        }
    });
    
    jQuery('#wiki-doc-inp').keypress(function (event) {
        if (event.which == '13') {
            event.preventDefault();
        }
    });
    
    jQuery(".wg-apply-input").on("click", function() {
        jQuery(this).hide();
        jQuery(this).next().focus();
    });
    
    jQuery(".global-form-style input").each(function() {
        if (jQuery(this).hasClass("create-account")) {
            return false;
        }
        
        if (jQuery(this).val() !== "") {
            jQuery(this).prev().text("");
            jQuery(this).prev().hide();
        }
    });
    
    jQuery();
}); 

function flaggedPost(object) {
    if (confirm('Are you sure to flag this post as inappropriate?')) {
        var datId = jQuery(object).attr('data-id');
        if (datId) {
//            jQuery.ajax({
//                url: jQuery(object).attr('href')
//            });

            jQuery.ajax({
                url: '/flaggetpost',
                data: {
                    dataId: datId,
                    dataHref: jQuery(object).attr('href'),
                    dataClass: jQuery(object).attr('class')
                },
                success: function(data) {
                    var result = JSON.parse(data);
                    jQuery(object).attr('class', result.class);
                    jQuery(object).attr('title', result.title);
                }
            });
        }
    }
}

function formFieldFocus(object, defValue, type) {
    if (jQuery(object).val() == defValue && jQuery(object).attr('type') != 'password') {
        jQuery(object).val('');
        jQuery(object).css('color', '#5b696a');
        jQuery(object).css('border', '1px solid #5b696a');
    }
}
function formFieldBlur(object, defValue, type) {
    if (jQuery(object).val() == '' && jQuery(object).attr('type') != 'password') {
        jQuery(object).val(defValue);
        jQuery(object).css('color', '#a6b5b6');
        jQuery(object).css('border', '1px solid #a6b5b6');
    }
}

/* schools rotator */
if (jQuery('#mycarousel').length) {
    jQuery('#mycarousel').jcarousel({
        scroll: 1,
        vertical: true,
        auto: 3,
        wrap: "circular",
        animation: 500
    });
}
;
/* END schools rotator */

function onSetFocus(object) {
    jQuery(object).css('border', '1px solid #5b696a');
    jQuery(object).css('color', '#5b696a');
}

function onOutFocus(object) {
    jQuery(object).css('border', '1px solid #a6b5b6');
    jQuery(object).css('color', '#a6b5b6');
}

function formApplyFieldFocus (object) {
    jQuery(object).prev().text("");
}

function formApplyFieldBlur (object, defValue) {
    if (jQuery(object).val() === "") {
        jQuery(object).prev().text(defValue);
        jQuery(object).prev().show();
    }
}

function onSubmitForm(objectId) {
    jQuery(objectId).click();
}

function onCreateMainMenu() {
    var object = jQuery('#wiki-main-menu-resource');
    if (!object)
        return false;

    var a,
        wBlock = jQuery('#wiki-content-main').width(),
        wContainer = jQuery('#wiki-nav-content').width(),
        wLeft = 140, //jQuery('#wiki-nav-left').width(),
        wRight = 80, //jQuery('#wiki-nav-right').width(),
        width = wBlock - wLeft - wRight - 40,
        recCount = ((wContainer) / 150) | 0,
        html = '',
        otherHtml = '',
        text = '',
        i = 0,
        link = '',
        winWidth = jQuery(window).width();

    if (winWidth < 420) {
        object.find('a').each(function() {
            a = this;
            text = text + '<option value="' + jQuery(a).attr('href') + '">' + jQuery(a).html() + '</option>';
        });
        jQuery('#wiki-nav-content').html('<select>' + text + '</select>');
    } else {
        jQuery("#wiki-nav-content").css('width', '' + width + 'px');

        object.find('a').each(function() {
            a = this;

            var classCurrent = '';
            var classDrop = '';

            var notification = '<span class="wiki-notification-block" id="post-not-' + jQuery(a).attr('data-id') + '"></span>';

            if (jQuery(a).attr('href') == jQuery(a).attr('current-url')) {
                classCurrent = 'wiki-menu-current';
            }

            if (i >= recCount) {
                notification = '<span class="wg-eq-hide">(</span><span id="post-not-' + jQuery(a).attr('data-id') + '"></span><span class="wg-eq-hide">)</span>';
                classDrop = 'class="wg-drop-link"';
                classCurrent += ' wg-background-0';
            }

            classCurrent = 'class="' + classCurrent + '"';

            link = '<li class="wiki-main-menu-auth menu-course"><a href="' + jQuery(a).attr('href') + '" ' + classCurrent + '><span ' + classDrop + '>' + jQuery(a).html() + notification + '</span></a></li>';

            if (i < (recCount - 1)) {
                html = html + link;
            } else {
                otherHtml = otherHtml + link;
            }
            i++;
        });

        if (html.length > 0 || recCount > 0) {
            text = html;
            if (otherHtml.length > 0) {
                text = text + '<li><a id="wiki-more-a"></a><ul id="wiki-nav-main-id" class="wiki-nav-drop wiki-notification-small">' + otherHtml + '</ul></li>';
            }

            jQuery('#wiki-nav-content').html('<ul class="wiki-nav-main">' + text + '</ul>');
        }
    }
}

function onMenuMoreShow(currentMousePos) {
    bMenuShow = true;
    jQuery('#wiki-nav-main-id').css('display', 'block');
    if (currentMousePos) {

        var more = jQuery('#wiki-more-a').offset(),
                height = more.top + 50;

        jQuery('#wiki-nav-main-id').css('top', '' + height + 'px');
        jQuery('#wiki-nav-main-id').css('left', '' + more.left + 'px');
    }
}

function onMenuMoreHide() {
    bMenuShow = false;
    setTimeout(function() {
        if (!bMenuShow)
            jQuery('#wiki-nav-main-id').css('display', 'none');
    }, 1000);
}

function onWindowResize(width, height) {

    if (width < 420) {
        jQuery('#wiki-nav-left').attr('class', 'wiki-menu-block');
        jQuery('#wiki-nav-container').attr('class', 'wiki-menu-block');
        jQuery('#wiki-nav-content').attr('class', 'wiki-menu-block');
        jQuery('#wiki-nav-right').attr('class', 'wiki-menu-block');
    } else {
        jQuery('#wiki-nav-left').attr('class', 'wiki-nav-col-1');
        jQuery('#wiki-nav-container').attr('class', 'wiki-main-nav');
        jQuery('#wiki-nav-content').attr('class', 'wiki-nav-col-2');
        jQuery('#wiki-nav-right').attr('class', 'wiki-nav-col-3');
    }
}

function ShowBlock(link, idName, id, statusOn, statusOff) {
    var object = jQuery("#" + idName + id);
    if (!object)
        return;

    var display = object.css('display');

    if (display == 'none') {
        object.css('display', 'block');
        jQuery(link).html(statusOff);
        onShowCommentForm(link, 1);
    } else {
        object.css('display', 'none');
        jQuery(link).html(statusOn);
    }
}

function setLike(id, tutor) {
    var current_count = parseInt(jQuery("#count_" + id).html());

    jQuery.ajax({
        url: '/userlike',
        type: 'POST',
        data: 'object=' + id,
        success: function(data, textStatus, XMLHttpRequest) {
            var object = JSON.parse(XMLHttpRequest.responseText);
            if (object.success === 0) {
                if (parseInt(current_count) < object.like)
                    object.data_like = 1;
                current_count = object.like;
                if (object.data_like != 2 || object.data_like == 2)
                    jQuery("#count_" + id).html(current_count);

                var tutorClass = 'image-like tooltip tooltip4';
                if (object.ustaff == 1) {
                    tutorClass = 'image-like tooltip tutor tooltip4';
                }
                if (object.data_like != 2)
                    jQuery(tutor).attr('class', tutorClass);
                switch (parseInt(object.data_like)) {
                    case -1:
                        {
                            jQuery("#status_" + id).fadeIn().html('<span style="color: #F07D18;">disendorsed</span>');
                        }
                        break;
                    case 0:
                        {
                            jQuery("#status_" + id).fadeIn().html('<span style="color: #F07D18;">unendorsed</span>');
                        }
                        break;
                    case 1:
                        {
                            jQuery("#status_" + id).fadeIn().html('<span style="color: #62cbcc;">endorsed</span>');
                        }
                        break;
                    default:
                        {
                            jQuery("#status_" + id).fadeIn().html('<span style="color: #F07D18;">'+object.message+'</span>');
                        }
                        break;
                }
                setTimeout(function(){
                    jQuery("#status_" + id).fadeOut()
                }, 3000);
                
            } else {
                jQuery("#status_" + id).html('<span style="color: #ff0000;">'+object.message+'</span>');
            }
        }
    });
}
///////////////////   END LIKE   ////////////////////////////

function getEditForm(object) {
    jQuery.ajax({
        url: jQuery(object).attr('href'),
        method: 'POST'
    }).done(function(data) {
        jQuery(data).each(function(index, element) {
            if (jQuery(element).attr('id')) {
                var dataId = jQuery(element).attr('data-id');
                if (dataId) {

                    var commentDoc = jQuery('#wiki-post-content-' + dataId + ' table'),
                        commentImg = jQuery('#wiki-post-content-' + dataId + ' div[style]').addClass('imgPost'),
                        commentLnk = jQuery('#wiki-post-content-' + dataId + ' .wiki-post-link-data').addClass('lnkPost');
                    if (commentDoc.length > 0 && commentImg.length > 0 && commentLnk.length > 0) {
                        jQuery('#wiki-post-content-' + dataId).html(element);
                        jQuery('#wiki-post-content-' + dataId).append(commentImg);
                        jQuery('#wiki-post-content-' + dataId).append(commentDoc);
                        jQuery('#wiki-post-content-' + dataId).append(commentLnk);
                        jQuery('#wiki-post-content-' + dataId + ' table').css('display', 'none');
                        jQuery('#wiki-post-content-' + dataId + ' div[style]').css('display', 'none');
                        jQuery('#wiki-post-content-' + dataId + ' .wiki-post-link-data').css('display', 'none');
                    } else if (commentDoc.length > 0 && commentImg.length > 0) {
                        jQuery('#wiki-post-content-' + dataId).html(element);
                        jQuery('#wiki-post-content-' + dataId).append(commentDoc);
                        jQuery('#wiki-post-content-' + dataId).append(commentImg);
                        jQuery('#wiki-post-content-' + dataId + ' table').css('display', 'none');
                        jQuery('#wiki-post-content-' + dataId + ' div[style]').css('display', 'none');
                    } else if (commentDoc.length > 0 && commentLnk.length > 0) {
                        jQuery('#wiki-post-content-' + dataId).html(element);
                        jQuery('#wiki-post-content-' + dataId).append(commentDoc);
                        jQuery('#wiki-post-content-' + dataId).append(commentLnk);
                        jQuery('#wiki-post-content-' + dataId + ' table').css('display', 'none');
                        jQuery('#wiki-post-content-' + dataId + ' .wiki-post-link-data').css('display', 'none');
                    } else if (commentImg.length > 0 && commentLnk.length > 0) {
                        jQuery('#wiki-post-content-' + dataId).html(element);
                        jQuery('#wiki-post-content-' + dataId).append(commentImg);
                        jQuery('#wiki-post-content-' + dataId).append(commentLnk);
                        jQuery('#wiki-post-content-' + dataId + ' div[style]').css('display', 'none');
                        jQuery('#wiki-post-content-' + dataId + ' .wiki-post-link-data').css('display', 'none');
                    } else if (commentDoc.length > 0) {
                        jQuery('#wiki-post-content-' + dataId).html(element);
                        jQuery('#wiki-post-content-' + dataId).append(commentDoc);
                        jQuery('#wiki-post-content-' + dataId + ' table').css('display', 'none');
                    } else if (commentImg.length > 0) {
                        jQuery('#wiki-post-content-' + dataId).html(element);
                        jQuery('#wiki-post-content-' + dataId).append(commentImg);
                        jQuery('#wiki-post-content-' + dataId + ' div[style]').css('display', 'none');
                    } else if (commentLnk.length > 0) {
                        jQuery('#wiki-post-content-' + dataId).html(element);
                        jQuery('#wiki-post-content-' + dataId).append(commentLnk);
                        jQuery('#wiki-post-content-' + dataId + ' .wiki-post-link-data').css('display', 'none');
                    } else {
                        jQuery('#wiki-post-content-' + dataId).html(element);
                    }
                    
                    if (jQuery('.wg-edit-area').val() === '' || jQuery('.wg-edit-area').val() === ' ') {
                        jQuery('.wg-edit-area').val('Add to the conversation');
                        jQuery('.wg-edit-area').html('');
                    }
                    
                    jQuery('.wg-edit-area').focus(function() {
                        if (jQuery(this).val() === 'Add to the conversation' || jQuery('.wg-edit-area').val() === ' ') {
                            jQuery(this).val('');
                            jQuery(this).html('');
                        }
                    });
                    jQuery('.wg-edit-area').blur(function() {
                        if (jQuery(this).val() === '' || jQuery('.wg-edit-area').val() === ' ') {
                            jQuery(this).val('Add to the conversation');
                            jQuery(this).html('');
                        }
                    });
                    
                    jQuery('#wiki-post-block-8475' + dataId).hide();
                }
            }
        });
    });
    return false;
}

function checkContent(id) {
    var form = jQuery('#form-post-edit-' + id),
            content = form.find('#post_content');

    if (content.val() == '') {
        content.val('image');
    }
    return true;
}

function onSendEditForm(object, id, type, comment) {
    var dataId = jQuery(object).attr('data-id'),
        post = '#wiki-post-content-' + dataId,
        defText = 'Add to the conversation',
        text = jQuery('#' + id + dataId + ' textarea[name="post[content]"]').val(),
//        equation = jQuery('#wg-comment-equation-text-' + dataId).html(),
        link = jQuery('.lnkPost').html();
    text = text.trim();
//    if ((text === '' || text === defText) && (equation !== '' || equation !== undefined)) {
//        text = equation;
//    } else if (equation !== '' && equation !== undefined) {
//        text = text + equation;
//    }

    if (text === defText) {
        jQuery('#' + id + dataId + ' textarea[name="post[content]"]').val(' ');
    }

    if (id === 'form-comment-edit-' || id === 'form-post-edit-') {
        var img = jQuery(post + ' div.imgPost'),
            doc = jQuery(post + ' table');

        if (!(img.html())) { img = 0; }
        if (!(doc.html())) { doc = 0; }

        if ((text == '' || text == defText || text == ' ' || text === undefined) && img == 0 && doc == 0 && link === undefined) {
            if (id === 'form-comment-edit-' && jQuery(post + ' .wg-required').text() !== 'Required') {
                jQuery('#' + id + dataId).before('<span class="wg-required" style="margin-left: 10px;">Required</span>');
            }
            if (id === 'form-post-edit-'  && jQuery(post + ' .wg-required').text() !== 'Required') {
                jQuery('#' + id + dataId).before('<span class="wg-required" style="margin-left: 10px;">Required</span>');
            }
            return false;
        }

    } else if (id === 'form-comment-add-') {

        var img = jQuery('#' + id + dataId + ' input[name="post[attachment_id]"]').val(),
            doc = jQuery('#' + id + dataId + ' input[name="post[document_id]"]').val();

        if (!(img)) { img = 0; }
        if (!(doc)) { doc = 0; }

        if ((text == '' || text == defText || text == ' ' || text === undefined) && img == 0 && doc == 0) {
            jQuery('#wg-status-comm-' + dataId).text('Required');
            return false;
        }
    }
    
    var instOrStud = jQuery('.wg-submit-block').attr('data-id');
    if (dataId) {
        var form = jQuery('#' + id + dataId);
        
        jQuery('#' + id + dataId + ' textarea[name="post[content]"]').val(text);
        jQuery.ajax({
            url: form.attr('action'),
            method: 'GET',
            type: 'post',
            data: form.serialize(),
//            dataType: 'json',
            success: function(data, textStatus, XMLHttpRequest) {
                if (type == 2) {
                    var currentBody = jQuery('#wg-add-comment-' + dataId).html();
                    jQuery('#vm-holder-' + dataId).before(jQuery('#wg-add-comment-' + dataId).html('<a class="instrOrStud" title=' + instOrStud + '></a>' + currentBody + data));
                }

                jQuery('#hiddeFormLoadImageComment-' + dataId).trigger('reset');
                jQuery('#hiddeFormLoadDocComment-' + dataId).trigger('reset');
            }
        });

        switch (type) {
            case 1:
            case 2:
                {
                    var commentDoc = jQuery('#wiki-post-content-' + dataId + ' table'),
                        commentImg = jQuery('#wiki-post-content-' + dataId + ' div.imgPost'),
                        commentLnk = jQuery('#wiki-post-content-' + dataId + ' div.lnkPost'),
                        content = form.find('#post_content').val(),
                        element = '#wiki-post-content-' + dataId;
                        content = getFx(content);
//                        content = content.replace(/<br>/g, "\n");
                    if (content === 'Add to the conversation') {
                        content = '';
                    }

                    if (!comment) {
                        var doc = commentDoc.html(),
                            img = commentImg.html(),
                            lnk = commentLnk.html();
                        if (commentDoc.length > 0 && commentImg.length > 0 && commentLnk.length > 0) {
                            jQuery(element).html(content);
                            jQuery(element).append('<div class="wiki-float-row-2"></div><div class="wiki-doc-block"><table>' + doc + '</table></div><div class="wiki-float-row"></div>');
                            jQuery(element).append('<div style="display: block;">' + img + '</div>');
                            jQuery(element).append('<div class="wiki-post-link-data">' + lnk + '<div style="clear: both;"></div></div><div class="wiki-float-row"></div>');
                        } else if (commentDoc.length > 0 && commentImg.length > 0) {
                            jQuery(element).html(content);
                            jQuery(element).append('<div class="wiki-float-row-2"></div><div class="wiki-doc-block"><table>' + doc + '</table></div><div class="wiki-float-row"></div>');
                            jQuery(element).append('<div style="display: block;">' + img + '</div>');
                        } else if (commentDoc.length > 0 && commentLnk.length > 0) {
                            jQuery(element).html(content);
                            jQuery(element).append('<div class="wiki-float-row-2"></div><div class="wiki-doc-block"><table>' + doc + '</table></div><div class="wiki-float-row"></div>');
                            jQuery(element).append('<div class="wiki-post-link-data">' + lnk + '<div style="clear: both;"></div></div><div class="wiki-float-row"></div>');
                        } else if (commentImg.length > 0 && commentLnk.length > 0) {
                            jQuery(element).html(content);
                            jQuery(element).append('<div style="display: block;">' + img + '</div><div class="wiki-float-row"></div>');
                            jQuery(element).append('<div class="wiki-post-link-data">' + lnk + '<div style="clear: both;"></div></div><div class="wiki-float-row"></div>');
                        } else if (commentDoc.length > 0) {
                            jQuery(element).html(content);
                            jQuery(element).append('<div class="wiki-float-row-2"></div><div class="wiki-doc-block"><table>' + doc + '</table></div>');
                        } else if (commentImg.length > 0) {
                            jQuery(element).html(content);
                            jQuery(element).append('<div style="display: block;">' + img + '</div>');
                        } else if (commentLnk.length > 0) {
                            jQuery(element).html(content);
                            jQuery(element).append('<div class="wiki-post-link-data">' + lnk + '<div style="clear: both;"></div></div><div class="wiki-float-row"></div>');
                        } else {
                            content = getFx(content);
                            jQuery(element).html(content);
                        }
                    }
                    
                    jQuery('#wg-form-add-comment-' + dataId).html('');
                }
                break;
            case 3:
                {
                    jQuery('#wg-form-add-comment-' + dataId).html('');
                }
                break;
        }
    }
}

function getFx(content) {
//    var fx_start_pos = content.indexOf('<fx>');
//    if (fx_start_pos !== -1 || fx_start_pos === 0) {
//        var fx_end_pos = content.indexOf('</fx>', fx_start_pos + 4);
//        if (!fx_end_pos) {
//            return content;
//        }
//        var fx_length = fx_end_pos - fx_start_pos + 3;
//        var fx_replace = content.substr(fx_start_pos, fx_length + 2);
//        var fx = content.substr(fx_start_pos + 4, fx_length - 7);
//        fx = '<div class="wg-fx-field"><img src="http://latex.codecogs.com/svg.latex?'+fx+'" alt="'+fx+'" border="0" class="latex" align="left" /></div>';
//            if (fx_start_pos !== 0) { fx = '<br/><br/>'+fx; }
//        content = content.replace(fx_replace, fx);
//        return getFx(content);
//    } else {
//        return content;
//    }
//    return false;
    
    var fx_start_pos = content.indexOf('$$');
    if (fx_start_pos !== -1 || fx_start_pos === 0) {
        var fx_end_pos = content.indexOf('$$', fx_start_pos + 2);
        if (!fx_end_pos) {
            return content;
        }
        var fx_length = fx_end_pos - fx_start_pos;
        var fx_replace = content.substr(fx_start_pos, fx_length + 2);
        var fx = content.substr(fx_start_pos + 2, fx_length - 2);
        fx = '<div class="wg-fx-field"><img src="http://latex.codecogs.com/svg.latex?'+fx+'" alt="'+fx+'" border="0" class="latex" align="left" /></div>';
            if (fx_start_pos !== 0) { fx = '<br/>'+fx; }
        content = content.replace(fx_replace, fx);
        return getFx(content);
    } else {
        return content;
    }
    return false;
}

function htmlParserTag(text) {
    if (!text)
        return text;
    text = text.replace(/((https?\:\/\/|ftp\:\/\/)|(www\.))(\S+)(\w{2,4})(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/gi, function(url) {
        var nice = url;
        if (url.match('^https?:\/\/')) {
            nice = nice.replace(/^https?:\/\//i, '')
        } else {
            url = 'http://' + url;
        }
        return '<a target="_blank" rel="nofollow" href="' + url + '">' + url + '</a>';
    });
    var max = 100, i = 0, t = '';
    while (i < max) {
        t = text.replace('\n', function(a) {
            return a.replace('\n', '<br/>');
        });
        if (text == t)
            break;
        else
            text = t;
        i++;
    }

    return text;
}

function onShowCommentForm(object, type) {
    var dataId = jQuery(object).attr('data-id');
    if (dataId) {
        var link = jQuery(object).attr('href'),
                showId = '#wg-form-add-comment-2' + dataId;
        jQuery('#wg-form-add-comment-' + dataId).css('display', 'none');
        jQuery('#wg-form-add-comment-2' + dataId).css('display', 'block');
        if (type == 1) {
            jQuery('#wg-form-add-comment-' + dataId).css('display', 'block');
            jQuery('#wg-form-add-comment-2' + dataId).css('display', 'none');
            showId = '#wg-form-add-comment-' + dataId;
        }

        jQuery.ajax({
            url: link,
        }).done(function(data) {
            jQuery('#wiki-comment-list-' + dataId).css('display', 'block');
            jQuery(showId).html(data);
        });
    }
    return false;
}

function onDeleteComment(object) {
    var dataId = jQuery(object).attr('data-id');
    if (dataId) {
        var msgyesno = jQuery(object).attr('msgyesno');
        if (msgyesno) {
            jConfirm(msgyesno, 'Delete comment', function(result) {
                if (result) {
                    var link = jQuery(object).attr('href');
                    jQuery.ajax({
                        url: link
                    }).done(function(data) {
                        jQuery('#wiki-comment-block-' + dataId).remove();
                    });
                }
            });
        }
    }
}

function onDeletePost(object) {
    var dataId = jQuery(object).attr('data-id');
    if (dataId) {
        var msgyesno = jQuery(object).attr('msgyesno');
        if (msgyesno) {
            jConfirm(msgyesno, 'Delete post', function(result) {
                if (result) {
                    var link = jQuery(object).attr('href');
                    jQuery.ajax({
                        url: link
                    });
                    jQuery('#wiki-post-block-' + dataId).remove();
                }
            });
        }
    }
}

function onClickObject(objectId) {
    jQuery('#' + objectId).click();
}

function update_counters() {
    var sumNotif = 0,
        sumPrivate = 0;

    jQuery.ajax({
        type: "POST",
        dataType: "JSON",
        url: "/update_counters",
        async: false,
        success: function(data) {
            if(data != null) {
                jQuery.each(data, function(key, value) {
                    jQuery.each(value, function(k, v) {
                        if (parseInt(v) != 0 && v) {
                            if (k == 'post') {
                                jQuery('#post-not-' + key).css('display', 'inline');
                                jQuery('#post-not-' + key).html(v);
//                            jQuery('#post-no-' + key).css('display', 'inline');
//                            jQuery('#post-no-' + key).html(v);
                                sumNotif += v;
                            }
                        if (k == 'private_post') {
                            jQuery('#private-not-' + key).css('display', 'inline');
                            jQuery('#private-not-' + key).html(v);
                            sumPrivate += v;
                            }
                        } else {
                            if (k == 'post') {
                                jQuery('#post-no-' + key).css('display', 'none');
                                jQuery('#post-not-' + key).css('display', 'none');
                            }
                        if (k == 'private_post') {
                            jQuery('#private-not-' + key).css('display', 'none');
                            }
                        }

                        if (sumNotif > 0) {
                            jQuery('#post-not-sum').css('display', 'inline');
                            jQuery('#post-not-sum').html(sumNotif);
                        } else {
                            jQuery('#post-not-sum').css('display', 'none');
                        }

                    if (sumPrivate > 0) {
                        jQuery('#post-private-sum').css('display', 'inline');
                        jQuery('#post-private-sum').html(sumPrivate);
                        } else {
                        jQuery('#post-private-sum').css('display', 'none');
                        }
                    });
                });
            }
        }
    }).complete(function() {
        setTimeout(function() {
            update_counters();
        }, 50 * 1000);
    });
}

function onCloseWin() {
    var win = jQuery('#wiki-win');
    // hide
    win.css('display', 'none');
    // and clear
    win.html('');
}

function onShowWin(text, step) {
    var win = jQuery('#wiki-win'),
            width = win.width(),
            height = win.height();
    var left = (jQuery(window).width() - width) / 2;
    var top = (jQuery(window).height() - height) / 4;

    win.css('display', 'block');
    win.css('left', left + 'px');
    win.css('top', top + 'px');

    win.html(text);
    switch (step) {
        case 1:
            {
                jQuery('#wiki-button-load-image').click();
            }
            break;
        case 2:
            {
                jQuery('#docs').click();
            }
            break;
    }
}

jQuery.fn.maxlength = function() {
    var settings = jQuery.extend({
        maxChars: 300
    }); 
    return this.each(function() {
        var me = jQuery(this);
        var l = settings.maxChars;
        me.bind('keydown keypress keyup textchange focus blur',function(e) {
            if(me.val().length > settings.maxChars) me.val(me.val().substr(0, settings.maxChars));
            l = settings.maxChars - me.val().length;
        });
    });
};

jQuery.fn.maxEquationLength = function() {
    var settings = jQuery.extend({
        maxChars: 700
    });
    return this.each(function() {
        var me = jQuery(this);
        var l = settings.maxChars;
        me.bind('keydown keypress keyup',function(e) {
            if(me.val().length > settings.maxChars) me.val(me.val().substr(0, settings.maxChars));
            l = settings.maxChars - me.val().length;
        });
    });
};

function onSwitchWin(type) {
    if (!type)
        type = 0;
    onCloseWin();

    if (type === 3) {
        type = 0;
    }

    onShowWinUpload(this, type);
}
function showUploadImage() {
    OnClearAttach("wg-block-attach-img");
    var input = jQuery('#hiddeFormLoadImage input[name="files"]');
    input.click();
    jQuery(".wiki-upload-image").slideDown();
    setTimeout(showLoader, 5000);
}
function showUploadDocument() {
    OnClearAttach("wg-block-attach-doc");
    var input = jQuery('#hiddeFormLoadDoc input[name="file"]');
    input.click();
    jQuery(".wiki-upload-document").slideDown();
    input.on('change', function() {
        if (input.val() !== '') {
            fileName = jQuery(this).val().replace(/.+[\\\/]/, "");
//            jQuery('#wiki-button-load-doc').html('Upload')
            jQuery('#doc-name').val(jQuery('#wiki-doc-inp').val());
            jQuery('#doc-course-id').val(jQuery('#post_course_id').val());
            jQuery('#wiki-doc-inp').val(fileName);
            var fileUrl = jQuery('#hiddeFormLoadDoc input[name]').val();
            var ex = fileExt(fileUrl, "doc");

            if (ex === 0) {
                jQuery('#hiddeFormLoadDoc input[name]').val('');
                jQuery('#wg-dash-form').html('Error file type. Allowed types: ".docx", ".xlsx", ".pptx", ".doc", ".xls", ".ppt", ".txt", ".rtf", ".jpg", ".jpeg", ".gif", ".png", ".pdf", ".djvu"');
                OnClearAttach('wg-block-attach-doc');
                jQuery('#wiki-doc-inp').val('Document name');
                jQuery('#result-doc-id').val(0);
                return false;
            } else {
                jQuery('#wg-dash-form').html('');
            }
//            onUploadDoc();
        } else {
            OnClearAttach("wg-block-attach-doc");
        }
    });
}
function showLoader() {
    jQuery(".wiki-center").hide();
}
function deleteImage() {
    jQuery(".wiki-upload-image").slideUp(500);
    OnClearAttach('wg-block-attach-img');
}
function deleteDocument() {
    jQuery(".wiki-upload-document").slideUp(500);
    OnClearAttach('wg-block-attach-doc');
}

function onUploadImage(object) {
    jQuery('#wiki-button-text-image').html('Upload');
    onSwitchWin(0);
    onCloseWin();
}

function onCancelImage(object) {
    jQuery('#attachment_id').val(0);
    jQuery('#attachment_url').val('');
    onSwitchWin(0);
}

function onUploadDoc() {
    var fileName = jQuery('#wiki-doc-inp').val(),
        fileDesc = jQuery('#wiki-doc-txt').val();

    if (fileName.trim() !== "") {
        jQuery('#doc-name').val(jQuery('#wiki-doc-inp').val());
    } else {
        jQuery('#showWinLoad').css('display', 'block');
        jQuery('body').css('overflow', 'hidden');
        jQuery('#hiddeFormLoadDoc input[name]').val('');
        jQuery('#wg-dash-form').html("Error file name. Please, load file again");
        OnClearAttach('wg-block-attach-doc');
        jQuery('#result-doc-id').val(0);
        showWinLoad(false);
        onCloseWin();
        return false;
    }
    if (fileDesc.trim() !== "") {
        jQuery('#doc-desciption').val(jQuery('#wiki-doc-txt').val());
    }
    
    jQuery('#doc-course-id').val(jQuery('#post_course_id').val());
    
    var fileUrl = jQuery('#hiddeFormLoadDoc input[name]').val();
    var ex = fileExt(fileUrl, "doc");

    if (ex == 0) {
        jQuery('#showWinLoad').css('display', 'block');
        jQuery('body').css('overflow', 'hidden');
        jQuery('#hiddeFormLoadDoc input[name]').val('');
        jQuery('#wg-dash-form').html('Error file type. Allowed types: ".docx", ".xlsx", ".pptx", ".doc", ".xls", ".ppt", ".txt", ".rtf", ".jpg", ".jpeg", ".gif", ".png", ".pdf", ".djvu"');
        OnClearAttach('wg-block-attach-doc');
        jQuery('#result-doc-id').val(0);
        showWinLoad(false);
        onCloseWin();
        return false;
    } else {
        jQuery('#wg-dash-form').html('');
    }
    var form = jQuery('#hiddeFormLoadDoc');
    var formData = new FormData(form[0]);
    showWinLoad(true);
    jQuery.ajax({
        url: form.attr('action'),
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(a, b, c) {
            var result = JSON.parse(c.responseText);
            jQuery('#result-doc-id').val(parseInt(result.id));
            OnSetAttach('wg-block-attach-doc', parseInt(result.id));
            onCloseWin();
            showWinLoad(false);
        },
        failure: function() {
            showWinLoad(false);
        }
    });
    
}

function OnClearAttach(objectId) {
    // clear form
    switch (objectId) {
        case 'wg-block-attach-doc':
        {
            var docId = jQuery('#result-doc-id').val();
            if (docId > 0) {
                OnDeleteAttach(objectId, 'document', docId);
            }
            var input = jQuery('#hiddeFormLoadDoc #hiddeFormClearDoc');
            input.click();
            
            jQuery('#wiki-button-load-doc').html('Preview');
            jQuery('#result-doc-id').val(0);
            jQuery('#wg-block-attach-doc').css('display', 'none');
            jQuery('#wiki-doc-txt').val('Brief description');
            jQuery('#wiki-doc-inp').val('Document name');
        }
        break;
        case 'wg-block-attach-img':
        {
            var imgId = jQuery('#post_attachment_id').val();
            if (imgId > 0) {
                OnDeleteAttach(objectId, 'image', imgId);
            }
            var input = jQuery('#hiddeFormLoadImage #hiddeFormClearImage');
            input.click();
            
            jQuery("#wiki-button-load-image").html("Preview");
            jQuery('#post_attachment_id').val(0);
            jQuery('#post_attachment_url').val('');
            jQuery('#wg-block-attach-img').css('display', 'none');
        }
        break;
    }
}

function OnDeleteAttach(objectId, type, attachId) {
    jQuery.ajax({
        url: '/delattachment',
        data: {
            type: type,
            attachId: attachId
        },
        success: function(data) {
            switch (type) {
                case 'document':
                    {
                        jQuery('#result-doc-id').val(0);
                    }
                    break;
                case 'image':
                    {
                        jQuery('#attachment_id').val(0);
                        jQuery('#attachment_url').val('');
                    }
                    break;
            }
            var object = jQuery('#' + objectId);
            object.css('display', 'none');
            jQuery('#' + objectId + ' span').html('');
        }
    });
}

function OnSetAttach(objectId, attachId) {
    var bStatus = true,
            type = '';

    attachId = parseInt(attachId);
    if (!attachId)
        bStatus = false;
    if (attachId <= 0)
        attachId = false;

    switch (objectId) {
        case 'wg-block-attach-doc':
            {
                type = 'document';
            }
            break;
        case 'wg-block-attach-img':
            {
                type = 'image';
            }
            break;
        default:
            {
                bStatus = false;
            }
            break;
    }
    if (!bStatus)
        return false;

    jQuery.ajax({
        url: '/getattachment',
        data: {
            type: type,
            attachId: attachId
        },
        success: function(data, b, c) {
            var result = JSON.parse(data);
            if (result.status == 0) {
                jQuery('#' + objectId + ' span').html(result.name);
                jQuery('#' + objectId).css('display', 'inline-block');
            }
        }
    });
    return bStatus;
}

function confirmDelete(msg) {
    if (typeof (msg) === 'undefined') {
        msg = 'Are you sure to delete?';
    }

    if (confirm(msg)) {
        return true;
    } else {
        return false;
    }
}

function ShowHideText(id) {
    var el = jQuery('#span_' + id);
    var meElem = jQuery('#href_' + id);
    if (el.css('display') == 'none') {
        el.css('display', 'inline');
        meElem.html('hide');
    } else {
        el.hide();
        meElem.html('see more');
    }
    return false;
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

function onAccessAddCourse(url, departamentId, courseId, categoryId, access) {
    jQuery.ajax({
        url: url,
        type: "POST",
        data: {
            departamentId: departamentId,
            courseId: courseId,
            categoryId: categoryId,
            access: access
        },
        success: function(data, textStatus, XMLHttpRequest) {
            var object = JSON.parse(XMLHttpRequest.responseText);
            switch (object.status) {
                case 0:
                    {
                        window.location.href = window.location.href;
                    }
                    break;
                case 2:
                    {
                        if (access === undefined) {
                            access = prompt("Specify the code for the chosen course", "");
                            onAccessAddCourse(url, departamentId, courseId, categoryId, access);
                        } else if (access === null) {
                            break;
                        } else {
                            access = prompt("Invalid code. Please, re-enter the code for the chosen course", "");
                            onAccessAddCourse(url, departamentId, courseId, categoryId, access);
                        }
                    }
                    break;
            }
        }
    });
}
function onAccessAddInstructorCourse(url, departmentName, departmentAlias, courseCode, courseName, schoolId, access) {

    if (!access)
        access = "";
    jQuery.ajax({
        url: url,
        type: "POST",
        data: {
            schoolId: schoolId,
            departmentName: departmentName,
            departmentAlias: departmentAlias,
            courseCode: courseCode,
            courseName: courseName,
            access: access
        },
        success: function(data, textStatus, XMLHttpRequest) {
            var object = JSON.parse(XMLHttpRequest.responseText);
            switch (object.status) {
                case 0:
                    {
                        window.location.href = window.location.href;
                    }
                    break;
                case 2:
                    {
                        access = prompt("", "");
                        if (access && access.length > 0)
                            onAccessAddCourse(url, departmentName, departmentAlias, courseCode, courseName, schoolId, access);
                    }
            }
        }
    });
}

function showWinLoad(status) {
    if (!status) {
        jQuery('#showWinLoad').css('display', 'none');
        jQuery('#showWinLoad img').css('display', 'none');
        jQuery('body').css('overflow', 'visible');
    } else {
        jQuery('#showWinLoad img').css('display', 'inline-block');
        jQuery('#showWinLoad').css('display', 'block');
        jQuery('body').css('overflow', 'hidden');
//        jQuery('#showWinLoad').css('height', jQuery(document).height());
    }
}
function fileExt(fileName, postType) {
    var fileUrl = fileName,
            parts, ext = (parts = fileUrl.split("/").pop().split(".")).length > 1 ? parts.pop() : "";
    if (postType == 'doc') {
        extensions = new Array('docx', 'xlsx', 'pptx', 'doc', 'xls', 'ppt', 'txt', 'rtf', 'jpg', 'jpeg', 'gif', 'png', 'pdf', 'djvu', 'odt', 'ods', 'odp', 'pages', 'csv');
    } else if (postType == 'img') {
        extensions = new Array('jpg', 'jpeg', 'gif', 'png');
    }
    count = extensions.length;
    var i = 0, ex = 0;
    while (i < count) {
        if (ext == extensions[i]) {
            ++ex;
        }
        ++i;
    }
    return ex;
}

/*
 *
 * math_editor
 * create 16.07.14
 *
 */
function fx(id) {
    var value = jQuery('#wiki-math-editor-textarea').val();
    if(value !== undefined && value !== ""){
        if (id !== 0 && id !== undefined) {
            if (jQuery('.wg-form-comm-'+id).val() === 'Add to the conversation') {
                jQuery('.wg-form-comm-'+id).val('$$'+value+'$$');
//                jQuery('.wg-form-comm-'+id).val(LatexIT.latex('$$'+value+'$$'));
//                jQuery('#wg-show-comment-equation-'+id).show();
//                jQuery('#equation-field-'+id).show();
//                jQuery('#wg-show-comment-equation-'+id).html(LatexIT.latex('<fx>'+value+'</fx>'));
//                jQuery('#wg-comment-equation-text-'+id  ).html('<fx>'+value+'</fx>');
            } else {
                var text = jQuery('.wg-form-comm-'+id).val();
                jQuery('.wg-form-comm-'+id).val(text + '$$'+value+'$$');
//                jQuery('.wg-form-comm-'+id).val(text + LatexIT.latex('$$'+value+'$$'));
//                jQuery('#wg-show-comment-equation-'+id).show();
//                jQuery('#equation-field-'+id).show();
//                jQuery('#wg-show-comment-equation-'+id).html(LatexIT.latex('<fx>'+value+'</fx>'));
//                jQuery('#wg-comment-equation-text-'+id).html('<fx>'+value+'</fx>');

            }
        } else {
            if (jQuery('#post_content').val() === 'Ask, discuss, blog...') {
                jQuery('#post_content').val('$$'+value+'$$');
//                jQuery('#post_content').val(LatexIT.latex('$$'+value+'$$'));
//                jQuery('#wg-show-equation-post').show();
//                jQuery('#equation-field').show();
//                jQuery('#wg-show-equation-post').html(LatexIT.latex('<fx>'+value+'</fx>'));
//                jQuery('#wg-equation-text').html('<fx>'+value+'</fx>');
            } else {
                var text = jQuery('#post_content').val();
                jQuery('#post_content').val(text+'$$'+value+'$$');
//                jQuery('#post_content').val(text+LatexIT.latex('$$'+value+'$$'));
//                jQuery('#wg-show-equation-post').show();
//                jQuery('#equation-field').show();
//                jQuery('#wg-show-equation-post').html(LatexIT.latex('<fx>'+value+'</fx>'));
//                jQuery('#wg-equation-text').html('<fx>'+value+'</fx>');
            }
        }
    }
    onCloseMathEditor();
}

function getCaret(MathTextArea) {
    if (MathTextArea.selectionStart) {
        return MathTextArea.selectionStart;
    } else if (document.selection) {
        MathTextArea.focus();

        var r = document.selection.createRange();
        if (r == null) {
            return 0;
        }

        var re = MathTextArea.createTextRange(),
            rc = re.duplicate();
        re.moveToBookmark(r.getBookmark());
        rc.setEndPoint('EndToStart', re);

        return rc.text.length;
    }
    return 0;
}


function OpenLatexEditor(id)
{
    var posTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
    jQuery("#wg-equation").show();
    var win = jQuery('#wiki-math-editor'),
        width = win.width(),
        height = win.height();
    var left = (jQuery(window).width() - width) / 2;
    var top = posTop+150;

    win.css('display', 'block');
    win.css('left', left + 'px');
    win.css('top', top + 'px');

    win.load('../../editor', {id: id});
}

function onCloseMathEditor() {
    jQuery("#wg-equation").hide();
    var win = jQuery('#wiki-math-editor');
    win.css('display', 'none');
    win.html('');
    jQuery('#math-editor-script').remove();
}

function deleteEquation (fieldId) {
    if (fieldId === 0) {
        jQuery('#equation-field').slideUp(400);
        jQuery('#wg-show-equation-post').hide();
        jQuery('#wg-show-equation-post').empty();
        jQuery('#wg-equation-text').empty();
    } else {
        jQuery('#equation-field-'+fieldId).slideUp(400);
        jQuery('#wg-show-comment-equation-'+fieldId).hide();
        jQuery('#wg-show-comment-equation-'+fieldId).empty();
        jQuery('#wg-comment-equation-text-'+fieldId).empty();
    }
}

/*
 *
 * new math_editor
 * create 26.07.14
 *
 */
//function OpenLatexEditor(id)
//{
//    var posTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
//
//    var win = jQuery('#wiki-math-editor'),
//        width = win.width(),
//        height = win.height();
//    var left = (jQuery(window).width() - width) / 2;
//    var top = posTop+150;
//
//    win.css('display', 'block');
//    win.css('left', left + 'px');
//    win.css('top', top + 'px');
//
//    win.load('../../editor', {id: id});
//}
//
//function onCloseMathEditor() {
//    var win = jQuery('#wiki-math-editor');
//    win.css('display', 'none');
//    win.html('');
//    jQuery('#math-editor-script').remove();
//}

///////////SKYBIRD. WORK WITH MATH EDITOR BEGIN/////////////
//function fx(id) {
//    var value = jQuery('#wiki-math-editor-textarea').val();
//    if(value !== undefined && value !== ""){
//        if (id !== 0 && id !== undefined) {
//            if (jQuery('.wg-form-comm-'+id).val() === 'Add to the conversation') {
//                jQuery('.wg-form-comm-'+id).val( LatexIT.latex('$'+value+'$') );
//            } else {
//                var p1 = jQuery('.wg-form-comm-'+id).val().substring(0, getCaret(document.getElementsByClassName('wg-form-comm-'+id))),
//                    p2 = jQuery('.wg-form-comm-'+id).val().substring(getCaret(document.getElementsByClassName('wg-form-comm-'+id)));
//                jQuery('.wg-form-comm-'+id).val(jQuery('.wg-form-comm-'+id).val()+LatexIT.latex('$'+value+'$'));
//            }
//        } else {
//            if (jQuery('#post_content').val() === 'Ask, discuss, blog...') {
////                jQuery('#post_content').val( LatexIT.latex('$'+value+'$') );
//                jQuery('#wg-show-equation-post').show();
//                jQuery('#wg-show-equation-post').html(LatexIT.latex('$'+value+'$'));
//            } else {
//                var p1 = jQuery('#post_content').val().substring(0, getCaret(document.getElementById('post_content'))),
//                    p2 = jQuery('#post_content').val().substring(getCaret(document.getElementById('post_content')));
////                jQuery('#post_content').val(p1+LatexIT.latex('$'+value+'$')+p2);
//                jQuery('#wg-show-equation-post').show();
//                jQuery('#wg-show-equation-post').html(LatexIT.latex('$'+value+'$'));
////                jQuery('#wg-show-equation-post').html(p1+LatexIT.latex('$'+value+'$')+p2);
//            }
//        }
//    }
//
//    onCloseMathEditor();
//}
//
//function getCaret(MathTextArea) {
//    if (MathTextArea.selectionStart) {
//        return MathTextArea.selectionStart;
//    } else if (document.selection) {
//        MathTextArea.focus();
//
//        var r = document.selection.createRange();
//        if (r == null) {
//            return 0;
//        }
//
//        var re = MathTextArea.createTextRange(),
//            rc = re.duplicate();
//        re.moveToBookmark(r.getBookmark());
//        rc.setEndPoint('EndToStart', re);
//
//        return rc.text.length;
//    }
//    return 0;
//}

///////////SKYBIRD. WORK WITH MATH EDITOR END/////////////

///////////SKYBIRD. WORK WITH PASTE OF THE DATA TO THE POST.(LINKDATA) BEGIN/////////////
jQuery('#link-data').on('paste', function(e) {
    var data;
    var url;
    setTimeout(
        function(){
            data = jQuery('#link-data').val();
            url = jQuery('#scrape_url_address').val();
            data = checkUrlExistence(data);
            
//            var post = jQuery('#post_content').val();
//                post = post.replace(data, ' ');
//                jQuery('#post_content').val(post);
            scrapeUrl( url, data );
        },
        100 );
});

function checkUrlExistence(data) {
    var word = -1;
    var idx = -1;

    var regEx = "https?://[a-z0-9]";
    word = checkRegExExistence(data, regEx); //check existence of the url in the data like http://youtube.com/
    if( word !== -1) {
        return word;
    }

    regEx = "www[\.]{1,1}[a-z0-9]";
    word = checkRegExExistence(data, regEx); //check existence of the url in the data like www.somesite.com
    if( word !== -1 ){
        return word;
    }

    regEx = "[a-z0-9][\.]{1,1}[a-z]{2,4}/";
    var idx = data.search( regEx );
    if( idx !== -1) { //check existence of the url in the data like youtube.com/
        var firstSpace = data.lastIndexOf(' ', idx);
        if(firstSpace === -1) {
            firstSpace = 0;
        } else {
            firstSpace = firstSpace + 1;
        }
        var lastSpace = data.indexOf(' ', idx);
        if(lastSpace === -1) {
            word = data.slice(firstSpace);
        } else {
            word = data.slice(firstSpace, lastSpace);
        }
    }

    return word;
}

function checkRegExExistence(data, regEx){
    var idx = data.search( regEx );
    var word = -1;
    if( idx !== -1 ){ //check existence of the url in the data
        var lastSpace = data.indexOf(' ', idx);
        if(lastSpace === -1) {
            word = data.slice(idx);
        } else {
            word = data.slice(idx, lastSpace);
        }
    }
    return word;
}

function scrapeUrl( url ,word ) {
    jQuery.ajax({
        type: "POST",
        dataType: "JSON",
        url: url,
        data: {
            'experimentalUrl' : word
        },
        success: function(data) {
            if( data['error'] !== undefined ) {
                cleanLinkDataFields();
            } else if(data != null) {
                if( data['url'] !== undefined ) {
                    jQuery('#post_LinkData_url').val(data['url']);
                } else {
                    jQuery('#post_LinkData_url').val('');
                }

                if( data['image'] !== undefined) {
                    jQuery('#si-images').html('');
                    jQuery('#si-images').append("<img id='si-image-"+ 0 +"' class='si-image-n active' src='"+ data['image'] +"' />");
                    jQuery('#si-images').attr('imgcount', 1);
                    jQuery('#post_LinkData_img').val(data['image']);
                    jQuery('#si-image-rotator').hide();
                    jQuery('#si-images').show();
                } else {
                    jQuery('#si-images').html('');
                    jQuery('#post_LinkData_img').val('');
                    jQuery('#si-images').hide();
                }

                if( data['title'] !== undefined ){
                    jQuery('#si-title').html(data['title']);
                    jQuery('#post_LinkData_title').val( data['title'] );
                } else {
                    jQuery('#si-title').html("");
                    jQuery('#post_LinkData_title').val( '' );
                }

                if( data['description'] !== undefined ) {
                    jQuery('#si-description').html(data['description']);
                    jQuery('#post_LinkData_description').val(data['description']);
                } else {
                    jQuery('#si-description').html("");
                    jQuery('#post_LinkData_description').val('');
                }

                if( data['host'] !== undefined ) {
                    jQuery('#si-link a').html(data['host']);
                    jQuery('#si-link a').attr("href", data['scheme']+"://"+data['host']);
                    jQuery('#post_LinkData_host').val( data['host'] );
                } else {
                    jQuery('#si-link a').html("");
                }

                if( data['images'] !== undefined) {
                    jQuery('#si-images').html('');
                    var i = 0;
                    for( var key in data['images']){
                        var image = data['images'][key];
                        var newImg = new Image();
                        newImg.src = image;

                        newImg.onload = function(){
                            var height = this.height;
                            var width = this.width;
                            if( height >= 200 && width >= 200) {
                                jQuery('#si-images').append("<img id='si-image-"+ i +"' class='si-image-n' src='"+ this.src +"' />");
                                if(i !== 0) {
                                    jQuery('#si-image-'+i).hide();
                                } else {
                                    jQuery('#si-image-'+i).addClass('active');
                                    jQuery('#post_LinkData_img').val( this.src );
                                }
                                i++;

                                jQuery('#si-images').attr('imgcount', i);
                                if( i > 0 ){
                                    jQuery('#si-image-rotator').attr('currentImage', 0);
                                }
                            }

                            if( 1 >= i && 0 !== i ){
                                jQuery('#si-image-rotator').hide();
                                jQuery('#si-images').show();
                            } else {
                                jQuery('#si-image-rotator').show();
                                jQuery('#si-images').show();
                                SetRotatorArrowDisabled(0, i);
                            }
                        };

                    }
                } else {
                    if( data['image'] === undefined) {
                        jQuery('#si-image-rotator').hide();
                        jQuery('#si-images').hide();
                        jQuery('#site-information .chkbox').hide();
                    }
                }

                jQuery('#site-information').show();
            }
        },
                error: function(){
                }
    }).complete(function() {
    });
}

//function sets empty value to the input tags for LinkData and hides div block with this data
function showLinkRow() {
    jQuery(".add-link").slideToggle();
}
function cleanLinkDataFields(){
    var fields = new Array ( "url", "img", "title", "description", "host" );
    for (var key in fields) {
        var value = fields[key];
        jQuery('#post_LinkData_'+value).removeAttr("value");
    }
    
    if (jQuery('#link-data').val() === ' ') {
        jQuery('#link-data').val('');
    }
    jQuery('#site-information').slideUp(500);
    jQuery('#site-information').slideUp(500);
}

jQuery('#wiki-notification-list').on("click", '.link-data-href-play', function(){
    var link = jQuery(this).attr("href");
    var a = jQuery('<a>', { href:link } )[0];
    var hostname = a.hostname;
    var search = a.search;
    var path = a.pathname;

    if( hostname !== undefined && search !== undefined ) {
        if( (hostname.indexOf("youtube") !== -1 && search.indexOf("?v=") !== -1) || (hostname.indexOf("youtu.be") !== -1) ){
            var additionalSearch = '';
            var code = '';
            if( hostname.indexOf("youtu.be") !== -1 ) {
                code = path.substring(1);
                if(code === ''){
                    return false;
                }
            } else {
                if( -1 === search.indexOf('&') ){
                    code = search.substring(3);
                } else {
                    code = search.substring(3, search.indexOf('&'));
                }
            }

            var frameData = '<iframe width="470" height="264" src="//www.youtube.com/embed/' + code + '?autoplay=1' + additionalSearch + '" frameborder="0" allowfullscreen></iframe>'; //"&start=70"
            var videoFrame = jQuery(this).find('.video-frame');
            videoFrame.show();
            videoFrame.html( frameData );
            jQuery(this).find('.si-image').hide();
            jQuery(this).find('.play-button').hide();

            return false;
        }
    }

});

jQuery('#si-image-rotator .next').click(function(){
    var currentImage = jQuery('#si-image-rotator').attr("currentImage");
    var nextImage = Number(currentImage) + 1;
    var imgCount = Number(jQuery('#si-images').attr('imgcount'));
    if( currentImage >= imgCount -1 ){
        return false;
    } else {
        SetRotatorArrowDisabled(nextImage, imgCount);
        jQuery('#si-image-' + currentImage).removeClass('active');
        jQuery('#si-image-' + currentImage).hide();
        jQuery('#si-image-' + nextImage).addClass('active');
        jQuery('#si-image-' + nextImage).show();
        jQuery('#si-image-rotator').attr('currentImage', nextImage);
        jQuery('#post_LinkData_img').val( jQuery('#si-image-' + nextImage).attr('src') );
    }
});

jQuery('#si-image-rotator .prev').click(function(){
    var currentImage = jQuery('#si-image-rotator').attr("currentImage");
    var prevImage = Number(currentImage) - 1;
    var imgCount = Number(jQuery('#si-images').attr('imgcount'));
    if( currentImage <= 0 ){
        return false;
    } else {
        SetRotatorArrowDisabled(prevImage, imgCount);
        jQuery('#si-image-' + currentImage).removeClass('active');
        jQuery('#si-image-' + currentImage).hide();
        jQuery('#si-image-' + prevImage).addClass('active');
        jQuery('#si-image-' + prevImage).show();
        jQuery('#si-image-rotator').attr('currentImage', prevImage);
        jQuery('#post_LinkData_img').val( jQuery('#si-image-' + prevImage).attr('src') );
    }
});

function SetRotatorArrowDisabled(nextPrevImg, imgCount){
        if( nextPrevImg <= 0) {
            jQuery('#si-image-rotator .prev').addClass('disabled');
            jQuery('#si-image-rotator .next').removeClass('disabled');
        }else if( nextPrevImg >= imgCount - 1 ){
            jQuery('#si-image-rotator .prev').removeClass('disabled');
            jQuery('#si-image-rotator .next').addClass('disabled');
        } else {
            jQuery('#si-image-rotator .prev').removeClass('disabled');
            jQuery('#si-image-rotator .next').removeClass('disabled');
        }

        jQuery('#si-image-rotator .info').html((nextPrevImg+1) + " from " + (imgCount));
}

jQuery('#site-information #disable-image').click( function(){
    var imgCount = Number(jQuery('#si-images').attr('imgcount'));
    if( jQuery('#disable-image').prop('checked') ){
        jQuery('#si-images').hide();
        jQuery('#si-image-rotator').hide();
        jQuery('#post_LinkData_img').val('');
    } else {
        var imgSrc = jQuery('#si-images img.active').attr('src');
        jQuery('#si-images').show();
        if( 1 < imgCount ){
            jQuery('#si-image-rotator').show();
        }
        jQuery('#post_LinkData_img').val(imgSrc);
    }
});

jQuery('#close-link-data').click(function(){
    jQuery('#site-information').hide();
    jQuery('#disable-image').prop('checked', false);
    jQuery("#link-data").val("");
    showLinkRow();
    cleanLinkDataFields();
});

////////////SKYBIRD. WORK WITH PASTE OF THE DATA TO THE POST. (LINKDATA) END//////////////
jQuery(".tooltip4").on("mouseenter mouseover mouseleave", function () {
    var at = "right-100 top-5";
    jQuery(".tooltip").tooltip({
        position: {
            my: "left bottom",
            at: at,
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });

    jQuery(".tooltip2").tooltip({
        position: {
            my: "left bottom",
            at: "right-25 top-20",
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });

    jQuery(".tooltip3").tooltip({
        position: {
            my: "left bottom",
            at: "center-10 top-10",
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });

    jQuery(".tooltip4").tooltip({
        position: {
            my: "left bottom",
            at: "center-25 top-10",
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });

    jQuery(".tooltip5").tooltip({
        position: {
            my: "left bottom",
            at: "center-25 top-30",
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });

    jQuery(".tooltip6").tooltip({
        position: {
            my: "left bottom",
            at: "center-25 top-10",
            using: function(position, feedback) {
                jQuery(this).css(position);
                jQuery("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
            }
        }
    });
});