
wgQTipConfig={style:{tip:'bottomRight',background:'#666',border:{width:1,radius:3},'font-size':12,'font-family':'Georgia,serif','font-style':'italic',width:{min:20,max:600},name:'dark'},position:{corner:{target:'topMiddle',tooltip:'bottomRight'}}}
AutoPager={init:function(list_container){var ajax_loading=$("<div class='loading'><img src='../../images/ajax-loader.gif' /></div>");var autopager=$('#autopager');var opts={offset:'100%'};autopager.waypoint(function(event,direction){autopager.waypoint('remove');var href=autopager.children('a').attr('href');if(!href){return;}
autopager.html(ajax_loading);$.ajax({url:href,dataType:"html",data:{pager:true},success:function(data,textStatus,XMLHttpRequest){autopager.remove();var ele=$(data).filter(list_container).get(0);var html=$(ele).html();$(list_container).append(html);AutoPager.init(list_container);AutoPager.execCallbacks();}});},opts);},callbacks:[],addCallback:function(f){AutoPager.callbacks.push(f);},execCallbacks:function(){for(i=0;i<AutoPager.callbacks.length;i++){if(typeof AutoPager.callbacks[i]=='string'){eval(AutoPager.callbacks[i]);}else{AutoPager.callbacks[i].call();}}}}
var checkboxHeight="25";var radioHeight="25";var selectWidth="260";document.write('<style type="text/css">input.styled { display: none; } select.styled { position: relative; width: '+selectWidth+'px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>');var Custom={init:function(){var inputs=document.getElementsByTagName("input"),span=Array(),textnode,option,active;for(a=0;a<inputs.length;a++){if((inputs[a].type=="checkbox"||inputs[a].type=="radio")&&inputs[a].className=="styled"){span[a]=document.createElement("span");span[a].className=inputs[a].type;if(inputs[a].checked==true){if(inputs[a].type=="checkbox"){position="0 -"+(checkboxHeight*2)+"px";span[a].style.backgroundPosition=position;}else{position="0 -"+(radioHeight*2)+"px";span[a].style.backgroundPosition=position;}}
inputs[a].parentNode.insertBefore(span[a],inputs[a]);inputs[a].onchange=Custom.clear;if(!inputs[a].getAttribute("disabled")){span[a].onmousedown=Custom.pushed;span[a].onmouseup=Custom.check;}else{span[a].className=span[a].className+=" disabled";}}}
inputs=document.getElementsByTagName("select");for(a=0;a<inputs.length;a++){if(inputs[a].className=="styled"){option=inputs[a].getElementsByTagName("option");active=option[0].childNodes[0].nodeValue;textnode=document.createTextNode(active);for(b=0;b<option.length;b++){if(option[b].selected==true){textnode=document.createTextNode(option[b].childNodes[0].nodeValue);}}
span[a]=document.createElement("span");span[a].className="select";span[a].id="select"+inputs[a].name;span[a].appendChild(textnode);inputs[a].parentNode.insertBefore(span[a],inputs[a]);if(!inputs[a].getAttribute("disabled")){inputs[a].onchange=Custom.choose;}else{inputs[a].previousSibling.className=inputs[a].previousSibling.className+=" disabled";}}}
document.onmouseup=Custom.clear;},pushed:function(){element=this.nextSibling;if(element.checked==true&&element.type=="checkbox"){this.style.backgroundPosition="0 -"+checkboxHeight*3+"px";}else if(element.checked==true&&element.type=="radio"){this.style.backgroundPosition="0 -"+radioHeight*3+"px";}else if(element.checked!=true&&element.type=="checkbox"){this.style.backgroundPosition="0 -"+checkboxHeight+"px";}else{this.style.backgroundPosition="0 -"+radioHeight+"px";}},check:function(){element=this.nextSibling;if(element.checked==true&&element.type=="checkbox"){this.style.backgroundPosition="0 0";element.checked=false;}else{if(element.type=="checkbox"){this.style.backgroundPosition="0 -"+checkboxHeight*2+"px";}else{this.style.backgroundPosition="0 -"+radioHeight*2+"px";group=this.nextSibling.name;inputs=document.getElementsByTagName("input");for(a=0;a<inputs.length;a++){if(inputs[a].name==group&&inputs[a]!=this.nextSibling){inputs[a].previousSibling.style.backgroundPosition="0 0";}}}
element.checked=true;}},clear:function(){inputs=document.getElementsByTagName("input");for(var b=0;b<inputs.length;b++){if(inputs[b].type=="checkbox"&&inputs[b].checked==true&&inputs[b].className=="styled"){inputs[b].previousSibling.style.backgroundPosition="0 -"+checkboxHeight*2+"px";}else if(inputs[b].type=="checkbox"&&inputs[b].className=="styled"){inputs[b].previousSibling.style.backgroundPosition="0 0";}else if(inputs[b].type=="radio"&&inputs[b].checked==true&&inputs[b].className=="styled"){inputs[b].previousSibling.style.backgroundPosition="0 -"+radioHeight*2+"px";}else if(inputs[b].type=="radio"&&inputs[b].className=="styled"){inputs[b].previousSibling.style.backgroundPosition="0 0";}}},choose:function(){option=this.getElementsByTagName("option");for(d=0;d<option.length;d++){if(option[d].selected==true){document.getElementById("select"+this.name).childNodes[0].nodeValue=option[d].childNodes[0].nodeValue;}}}}
window.onload=Custom.init;
$.fn.customFileInput=function(){var fileInput=$(this).addClass('customfile-input').mouseover(function(){upload.addClass('customfile-hover');}).mouseout(function(){upload.removeClass('customfile-hover');}).focus(function(){upload.addClass('customfile-focus');fileInput.data('val',fileInput.val());}).blur(function(){upload.removeClass('customfile-focus');$(this).trigger('checkChange');}).bind('disable',function(){fileInput.attr('disabled',true);upload.addClass('customfile-disabled');}).bind('enable',function(){fileInput.removeAttr('disabled');upload.removeClass('customfile-disabled');}).bind('checkChange',function(){if(fileInput.val()&&fileInput.val()!=fileInput.data('val')){fileInput.trigger('change');}}).bind('change',function(){var fileName=$(this).val().split(/\\/).pop();var fileExt='customfile-ext-'+fileName.split('.').pop().toLowerCase();uploadFeedback.text(fileName).removeClass(uploadFeedback.data('fileExt')||'').addClass(fileExt).data('fileExt',fileExt).addClass('customfile-feedback-populated');uploadButton.text('Change');}).click(function(){fileInput.data('val',fileInput.val());setTimeout(function(){fileInput.trigger('checkChange');},100);});var upload=$('<div class="customfile"></div>');var uploadButton=$('<span class="customfile-button" aria-hidden="true">Browse</span>').appendTo(upload);var uploadFeedbackText=fileInput.attr('data-upload-feedback');if(uploadFeedbackText){var uploadFeedback=$('<span class="customfile-feedback" aria-hidden="true">'+uploadFeedbackText+'</span>').appendTo(upload);}
if(fileInput.is('[disabled]')){fileInput.trigger('disable');}
upload.mousemove(function(e){fileInput.css({'left':e.pageX-upload.offset().left-fileInput.outerWidth()+20,'top':e.pageY-upload.offset().top-$(window).scrollTop()-3});}).insertAfter(fileInput);fileInput.appendTo(upload);return $(this);};
(function($){if(!window.COURSE){COURSE={};}
COURSE.add_course={init:function(){$('#course_add_department_id').live('change',COURSE.add_course.events.update_course_dropdown);},events:{update_course_dropdown:function(event){var element=$(this);var form=element.closest('form');$.ajax({url:form.attr('action'),type:'GET',data:form.serialize(),success:function(data,textStatus,XMLHttpRequest){form.replaceWith(data);$('#form-course-add select').uniform();}});}}};COURSE.delete_course={init:function(){if($('#course-list').length||$('#courses-quick-list').length){$('a.course-delete').live('click',function(){var dom_element=this;if(confirm('Are you sure?')){COURSE.delete_course.events.delete_course.apply(dom_element);}});}},events:{delete_course:function(event){var element=$(this);$.ajax({url:element.attr('data-url'),success:function(data,textStatus,XMLHttpRequest){window.location.reload();}});}}};})(jQuery);
(function($){if(!window.DASHBOARD){DASHBOARD={};}
DASHBOARD.notification_tabs={init:function(){var notificationTabs=$('#notification-tabs');var courseId=$('#thisactivetab').attr('thisactiveid');$('#tmp_course_id').val(courseId);if(notificationTabs.length){notificationTabs.tabs({select:function(event,ui){$("#notification-list").remove();var data_id=$(ui.tab).attr('data-id');if(!data_id){data_id='';$('#post-form-widget').removeClass('mode-cls').addClass('mode-ev1');}else{$('#post-form-widget').removeClass('mode-ev1').addClass('mode-cls');}
$('#tmp_course_id').val(data_id);$('#post_course_id').val(data_id);},load:function(event,ui){DASHBOARD.post_comment.setModeDescription();USER.fsicon.tooltips();},ajaxOptions:{error:function(xhr,status,index,anchor){$(anchor.hash).html("Couldn't load this tab. We'll try to fix this as soon as possible.");}}});}}};DASHBOARD.post_comment={init:function(){DASHBOARD.post_comment.init_selectors();$('#post_content').val(DASHBOARD.post_comment.mode_description.classmates);$('#post_content').focus(function(){for(var k in DASHBOARD.post_comment.mode_description){if(this.value==DASHBOARD.post_comment.mode_description[k]){this.value='';$('#post_content').css('height','36px');break;}}});$('#post_content').blur(function(){if(this.value==''){DASHBOARD.post_comment.setModeDescription({force:true});$('#post_content').css('height','36px');}});$('#post_content').autosize({append:"\n"});},init_selectors:function(){var classSel=$('#post-form-widget #class-selector');var classSelA=classSel.children('a');var groupsSel=$('#post-form-widget #groups-selector');var groupsSelA=groupsSel.children('a');classSel.click(function(){classSelA.addClass('on');groupsSelA.removeClass('on');$('#post_type_Classmate').attr('checked','checked');DASHBOARD.post_comment.setModeDescription();return false;});classSel.qtip({content:'Ask a question or post a comment to all classmates',position:wgQTipConfig.position,style:wgQTipConfig.style});groupsSel.click(function(){groupsSelA.addClass('on');classSelA.removeClass('on');$('#post_type_Friend').attr('checked','checked');DASHBOARD.post_comment.setModeDescription();return false;});groupsSel.qtip({content:'Ask, Discuss, Blog',position:wgQTipConfig.position,style:wgQTipConfig.style});},mode_description:{'classmates':'Ask, Discuss, Blog','groups':'Ask, Discuss, Blog','everyone':'Ask, Discuss, Blog'},setModeDescription:function(options){var options=options||{force:false};if(!options.force){var value=$('#post_content').val();var cancelOp=false;if(value!=''){var isModeDescription=false;for(var k in DASHBOARD.post_comment.mode_description){if(value==DASHBOARD.post_comment.mode_description[k]){isModeDescription=true;break;}}
cancelOp=(!isModeDescription);}
if(cancelOp){return;}}
var data_id=$('.ui-tabs-selected').find('a').attr('data-id');if(data_id!=0){$(".ui-state-default").each(function(){if($(this).html()==$('.tab-menu-'+data_id).html()){$(this).css('display','inline');$('.tab-menu-'+data_id+'-1').css('display','inline');$(this).attr('id','thisactivetab');$(this).attr('thisactiveid',data_id);}else{if($(this).html()!=$('.tab-menu-'+data_id+'-1').html()){$(this).css('display','none');$(this).attr('id','');$(this).attr('thisactiveid',0);}}});}
if(!data_id){$('#post_content').val(DASHBOARD.post_comment.mode_description.everyone);}else if($('#post_type_Classmate').attr('checked')=='checked'){$('#post_content').val(DASHBOARD.post_comment.mode_description.classmates);}else{$('#post_content').val(DASHBOARD.post_comment.mode_description.groups);}},}
DASHBOARD.post_comment.init();function update_counters(){$.ajax({type:"POST",dataType:"JSON",url:"/update_counters",async:false,success:function(data){$.each(data,function(key,value){$.each(value,function(k,v){if(v!=0&&v){$("."+k+".id"+key).css('display','inline');$("."+k+".id"+key).html(v);}else{$("."+k+".id"+key).css('display','none');}});});}}).complete(function(){setTimeout(function(){update_counters();},60000);});}
update_counters();$("#notification-tabs ul li a").click(function(){var course_id=$(this).data("id");$.ajax({type:"POST",dataType:"JSON",url:"/reset_counter/"+course_id,success:function(data){if(data.success){$("#tab-id-list-"+course_id).html("");$("#tab-id-list-"+course_id).css('display','none');$(".classmate"+".id"+course_id).html("");$(".classmate"+".id"+course_id).css('display','none');}}})})})(jQuery);
(function($){if(!window.DOCUMENT){DOCUMENT={};}
DOCUMENT.delete_document={init:function(){if($('#document-tabs').length){$('#document-tabs a.document-delete').live('click',function(){var dom_element=this;if(confirm('Are you sure?')){DOCUMENT.delete_document.events.delete_document.apply(dom_element);}});}},events:{delete_document:function(event){var element=$(this);$.ajax({url:element.attr('data-url'),success:function(data,textStatus,XMLHttpRequest){$("#single-document-"+element.attr('data-id')).remove();}});}}};DOCUMENT.course_tabs={init:function(){var documentTabs=$('#document-tabs');if(documentTabs.length){documentTabs.tabs({select:function(event,ui){$("#document-list").remove();},ajaxOptions:{error:function(xhr,status,index,anchor){$(anchor.hash).html("Couldn't load this tab. We'll try to fix this as soon as possible. "+"If this wouldn't be a demo.");}}});}}};DOCUMENT.toggle_form={init:function(){if($('#document-upload-button ').length){$('#document-upload-button').click(function(){$('#form-document-add').slideToggle();$('#document-upload-button').toggle();});}}};DOCUMENT.list={autopager:function(){if($('#document-list').length){AutoPager.init('#document-list');}}}})(jQuery);
(function($){$(document).ready(function(){setDocsTabs();$("#course_add_course_id").change(function(){});$("#post_content").keypress(function(key){switch(key.keyCode){}});$("#post_attachment_id").attr("value","0");$("#post_attachment_url").attr("value","");$("#class-upload").click(function(){if($("#post_attachment_id").attr("value")=='0'){$("#files").trigger("click");}else{ResetImage();}});$('#class-upload-doc').click(function(){console.log('click document');});$("#files").change(function(){var formData=new FormData($('#hiddeForm')[0]);$.ajax({url:'/useruploads',type:'POST',data:formData,cache:false,contentType:false,processData:false,success:function(a,b,c){var result=JSON.parse(c.responseText),object=result[0];if(object.error==0){if(object.id>0){$("#post_attachment_id").val(object.id);$("#post_attachment_url").val(object.url);$('#class-upload').attr('title','Click to remove the attached image');$(".upload-status").html('<div style="display: inline-block; padding: 0px; margin: 0px;"><a href="'+object.url+'" class="zoom"><img src="'+object.url+'" style="height:20px;"></a>&nbsp;<a id="clearImage" OnClick="ResetImage();" style="vertical-align: top;">X</a></div>');}}else{$(".upload-status").html(object.message);}},xhr:function(){var myXhr=$.ajaxSettings.xhr();return myXhr;}});});});if(!window.POST){POST={};}
POST.add_post={init:function(){if($('#dashboard-post-form').length){$('#dashboard-post-form').live('submit',POST.add_post.events.dashboard_post_submit);}},events:{dashboard_post_submit:function(event){event.preventDefault();var form=$(this);var contentVal=form.find('textarea').val();if((contentVal=='Ask, Discuss, Blog'||contentVal=='')&&$("#post_attachment_id").val()>0){var area=form.find('textarea');area.val('image');area.html('image');contentVal=form.find('textarea').val();}
if($('#tmp_course_id').val())$('#post_course_id').val($('#tmp_course_id').val());if(contentVal==''){DASHBOARD.post_comment.setModeDescription({force:true});return false;}
if(contentVal==''){return false;}
var postCourseId=$('#post_course_id').val(),courseId=$('#thisactivetab').attr('thisactiveid');if(postCourseId!=courseId){if(courseId){form.find('select#post_course_id').val(courseId);form.find('input#post_everyone').prop('checked',false);}else{form.find('input#post_everyone').prop('checked',false);}}else{form.find('input#post_everyone').prop('checked',false);}
for(var x in DASHBOARD.post_comment.mode_description){if(contentVal==DASHBOARD.post_comment.mode_description[x]){return;}}
form.find('input:image').prop('disabled',true).addClass('disabled');$.ajax({url:form.attr('action'),type:"POST",data:form.serialize(),dataType:'json',success:function(data,textStatus,XMLHttpRequest){if(data.is_success){var tab_id=$('#notification-tabs').tabs().tabs('option','selected');$('#notification-tabs').tabs('load',tab_id);DASHBOARD.post_comment.setModeDescription({force:true});$('#post_content').blur().css('height','36px');if(contentVal!=''){$("#post_attachment_id").attr("value","0");$("#post_attachment_url").attr("value","");$('#class-upload').attr('title','Attach an image to a post');$('#class-upload').css('background-image','url(../images/icon-upload.png)');$('#hiddeForm').trigger('reset');$('#post_course_id').val(postCourseId);$(".upload-status").html('');$('#post_content').css('height','36px');}else{$('#post_course_id').val(0);}}},complete:function(data,textStatus){form.find('input:image').prop('disabled',false).removeClass('disabled');}});}}};POST.edit_comment_link={init:function(){$('.comment-edit-link').live('click',POST.edit_comment_link.events.show_edit_comment_form);},events:{show_edit_comment_form:function(event){event.preventDefault();var link=$(this);var post_id=link.attr('data-id');console.dir(link.attr('href'));$.ajax({url:link.attr('href'),type:"GET",success:function(data,textStatus,XMLHttpRequest){$('#comment-edit-form-container-'+post_id).html(data);}});}}}
POST.edit_post_link={init:function(){$('.post-edit-link').live('click',POST.edit_post_link.events.show_edit_post_form);},events:{show_edit_post_form:function(event){event.preventDefault();var link=$(this);var notification_id=link.attr('data-id');console.dir(link.attr('href'));$.ajax({url:link.attr('href'),type:"GET",success:function(data,textStatus,XMLHttpRequest){$('#notification-edit-post-container-'+notification_id).html(data);}});}}}
POST.mode_description={'comment_add':'post a comment'}
POST.add_comment_link={init:function(){$('.comment-add-link').live('click',POST.add_comment_link.events.show_comment_form);$('.comment-add-form input:text').live('focus',function(){if(this.value==POST.mode_description.comment_add){this.value='';}}).live('blur',function(){if(this.value==''){this.value=POST.mode_description.comment_add;}});},events:{show_comment_form:function(event){event.preventDefault();var link=$(this);var notification_id=link.attr('data-id');$.ajax({url:link.attr('href'),type:"GET",success:function(data,textStatus,XMLHttpRequest){$('#comment-add-form-container-'+notification_id).html(data);}});}}};POST.submit_comment_form={init:function(){$('.comment-add-form').live('submit',POST.submit_comment_form.events.submit_comment_form);},events:{submit_comment_form:function(event){event.preventDefault();var form=$(this);var contentVal=form.find('input:text').val();if(contentVal==POST.mode_description.comment_add||contentVal==''){form.find('input:text').val(POST.mode_description.comment_add);return;}
var notification_id=form.attr('data-id');form.find('input:image').prop('disabled',true).addClass('disabled');$.ajax({url:form.attr('action'),type:"POST",data:form.serialize(),dataType:'json',success:function(data,textStatus,XMLHttpRequest){if(data.is_success){var notification_comment_list=$("#notification-comment-list-"+notification_id);$.ajax({url:notification_comment_list.attr('data-action'),success:function(data,textStatus,XMLHttpRequest){$('#comment-add-form-container-'+notification_id).html('');notification_comment_list.html(data);}});}else{alert(data.form_errors);}},error:function(XMLHttpRequest,textStatus,errorThrown){form.replaceWith(XMLHttpRequest.responseText);},complete:function(data,textStatus){form.find('input:image').prop('disabled',false).removeClass('disabled');}});}}};POST.flag_as_inappropriate={tooltips:function(){$('.flag-as-inappropriate').qtip({content:'Flag as inappropriate',position:wgQTipConfig.position,style:wgQTipConfig.style});}};$('#SubscrMenu').mouseover(function(){showSubscr();});$('#SubscrMenu').mouseout(function(){hideSubscr();});$('#nav').mouseover(function(){showSubscr();});$('#nav').mouseout(function(){hideSubscr();});jQuery('li a').click(function(){setDocsTabs(this);});$("#file").change(function(){setTimeout(function(){var text=$('span.customfile-feedback').html();if(text.length>19){var i=0,ret='';while(i<text.length){if(i<8||i>=(text.length-8)){ret=ret+text[i];}else if(i==8){ret=ret+'...';}
i++;}
text=ret;}
$('span.customfile-feedback').html(text);},1000);});$('#document_course_id').change(function(){var courseId=$(this).val(),objectName='li.course-id-'+courseId+' a';$(objectName).click();setCookie('objectName',objectName);});setTimeout(function(){$(getCookie('objectName')).click();},400);$('#doc-tabs li a').click(function(){var id='#'+$(this).parent().attr('id');setCookie('objectName',id);});if(fnGetMetka()!=''){$('#'+fnGetMetka()).click();}
$("#course_add_course_id").live("change",function(event){var id=$("#course_add_course_id").val();jQuery.ajax({url:'checkcourseaccess',type:'POST',data:'object='+id,success:function(data,textStatus,XMLHttpRequest){var object=JSON.parse(XMLHttpRequest.responseText);if(object.success==1){$('#block-hide-0').css('display','inline-block');}else{$('#block-hide-0').css('display','none');$('#course_add_access').val('');}}});});var enter_code=$('#sf_guard_user_profile_enter_code');var email_post=$('#sf_guard_user_profile_email_post');var email_reply=$('#sf_guard_user_profile_email_reply');var email_from=$('#sf_guard_user_profile_email_from');email_from.live("click",function(){if($(this).is(':checked')){email_post.prop('checked',false);email_reply.prop('checked',false);}});email_post.live("click",function(){if($(this).is(':checked')){email_from.prop('checked',false);}});email_reply.live("click",function(){if($(this).is(':checked')){email_from.prop('checked',false);}});})(jQuery);function showSubscr(){$('#nav').css('display','block');$('.subcr-menu-block').css('display','block');}
function hideSubscr(){$('#nav').css('display','none');$('.subcr-menu-block').css('display','inline');}
function setDocsTabs(object){var currentId=jQuery(object).attr('data-tag'),maxId=jQuery('#max-tab-doc').attr('max'),min=0,max=0;currentId=parseInt(currentId);if(maxId&&currentId){if(currentId<=maxId){for(var i=0;i<=maxId;i++){min=currentId-1;if(min<0)min=0;max=min+5;if(max>maxId){max=maxId;min=max-5;}
if(i>=min&&i<=max){jQuery('#doc-item-lists-'+i).css('display','inline');}else{jQuery('#doc-item-lists-'+i).css('display','none');}}}}}
function setLike(id){var current_count=parseInt(jQuery("#count_"+id).html());jQuery.ajax({url:'userlike',type:'POST',data:'object='+id,success:function(data,textStatus,XMLHttpRequest){var object=JSON.parse(XMLHttpRequest.responseText);if(object.success==0){if(parseInt(current_count)<object.like)object.data_like=1;current_count=object.like;jQuery("#count_"+id).html(current_count);switch(parseInt(object.data_like)){case-1:{jQuery("#status_"+id).html('<span style="color: #ff0000;">dislike</span>');}break;case 0:{jQuery("#status_"+id).html('<span style="color: #333333;">unlike</span>');}break;case 1:{jQuery("#status_"+id).html('<span style="color: #0000ff;">like</span>');}break;default:{jQuery("#status_"+id).html(object.message);}break;}}else{jQuery("#status_"+id).html('<span style="color: #ff0000;">'+object.message+'</span>');}}});}
function ResetImage(){var postCourseId=$('#post_course_id').val();$("#post_attachment_id").attr("value","0");$("#post_attachment_url").attr("value","");$('#class-upload').attr('title','Attach an image to a post');$('#hiddeForm').trigger('reset');$(".upload-status").html('');$('#post_course_id').val(postCourseId);}
function ShowHideText(id){if($("#span_"+id).css('display')=='none'){$("#span_"+id).css('display','inline');$("#href_"+id).html('hide');}else{$("#span_"+id).css('display','none');$("#href_"+id).html('read more');}}
function ShowCourse(id,tabId,tabAll){if(id!=0){$(".ui-state-default").each(function(){if($(this).html()==$('.tab-menu-'+id).html()){$(this).css('display','inline');$('.tab-menu-'+id+'-1').css('display','inline');$(this).attr('id','thisactivetab');$(this).attr('thisactiveid',id);}else{if($(this).html()!=$('.tab-menu-'+id+'-1').html()){$(this).css('display','none');$(this).attr('id','');$(this).attr('thisactiveid',0);}}});}
var url='/dashboard#ui-tabs-'+tabId;setCookie("current_url",url);window.location.href=url;if($('#notification-tabs').html()){$('#ui-tab-'+id).click();}else{window.location.href='/dashboard#ui-tabs-'+tabId;}}
function checkContent(id){var form=$('#form-post-edit-'+id),content=form.find('#post_content');if(content.val()==''){content.val('image');}
return true;}
function getCookie(name){var matches=document.cookie.match(new RegExp("(?:^|; )"+name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g,'\\$1')+"=([^;]*)"));return matches?decodeURIComponent(matches[1]):undefined}
function setCookie(name,value,options){options=options||{};var expires=options.expires;if(typeof expires=="number"&&expires){var d=new Date();d.setTime(d.getTime()+expires*1000);expires=options.expires=d;}
if(expires&&expires.toUTCString){options.expires=expires.toUTCString();}
value=encodeURIComponent(value);var updatedCookie=name+"="+value;for(var propName in options){updatedCookie+="; "+propName;var propValue=options[propName];if(propValue!==true){updatedCookie+="="+propValue;}}
document.cookie=updatedCookie;}
function setOverPost(object){if($(object).val()=='image'){$(object).val('');}}
function ShowBlock(object,idName,id,statusOn,statusOff){var status=$('#'+idName+id).css('display');switch(status){case'block':{$('#'+idName+id).css('display','none');$(object).html(statusOn);}break;default:{$('#'+idName+id).css('display','block');$(object).html(statusOff);}break;}}
function fnGetMetka(){var link;link=""+location.href;var begPos=link.indexOf("#");if(begPos>=0){var metka="";begPos+=1;while(link[begPos])
{metka+=link[begPos];begPos++;}
return metka;}
return"";}
(function($){if(!window.USER){USER={};}
USER.register={init:function(){if($('#sfApplyApply_school_id').length){$("#sfApplyApply_is_staff").click(USER.register.events.toggle_graduation_info);}},events:{toggle_graduation_info:function(){$("#apply-graduation-info").toggle();},update_department_dropdown:function(event){var element=$(this);$.ajax({url:element.attr('data-action')+'?id='+element.val(),type:'GET',success:function(data,textStatus,XMLHttpRequest){$('#applymajor').html(data);$('select#sfApplyApply_primary_department_id').uniform();}});}}};USER.add_friend={init:function(){if($('#sfguarduser_index').length||$('#document-tabs').length||$("#my-profile").length){$('.friend-action').live('click',USER.add_friend.events.add_friend);}
$('.fsicon-pend').qtip({content:'You sent a WikiMate request to this user',position:wgQTipConfig.position,style:wgQTipConfig.style});},events:{add_friend:function(event){var element=$(this);$.ajax({url:element.attr('data-url'),success:function(data,textStatus,XMLHttpRequest){dataId=element.attr('data-id');if(dataId){$('.friend-request-actions-'+dataId).html(data);}
else{$('.friend-request-actions').html(data);}}});},fsicon_add_friend:function(ele){var do_outline=($('#notification-tabs').length>0)?1:0;var af_options={friend_pending_outline:do_outline};var jqo=$(ele);$('.qtip-active').remove();var url=jqo.attr('data-url');$.ajax({url:url,dataType:'html',data:af_options,success:function(data,textStatus,XMLHttpRequest){data_id=jqo.attr('data-id');if(data_id){$('.fsicon-user-'+data_id).replaceWith(data);USER.fsicon.tooltips();}},error:function(jqXHR,textStatus,errorThrown){}});}}};USER.fsicon={tooltips:function(){$('.fsicon-conf').qtip({content:'You are WikiMates with this user',position:wgQTipConfig.position,style:wgQTipConfig.style});$('.fsicon-pend').qtip({content:'You have a pending WikiMate request with this user',position:wgQTipConfig.position,style:wgQTipConfig.style});$('.fsicon-non-friend').qtip({content:'Click this icon to send a WikiMate request to this user',position:wgQTipConfig.position,style:wgQTipConfig.style});}}
USER.new_member={autopager:function(){if($('#new-member-list').length){AutoPager.addCallback('USER.fsicon.tooltips()');AutoPager.init('#new-member-list');}}}})(jQuery);
Profile={initMyProfile:function(){$('#collapse-summary').click(function(){$('#profile-summary').slideToggle();$('#collapse-summary').toggleClass('togarw-up-lgt togarw-dn-lgt');});},initQuickUserProfile:function(){if($('#quick-user-info').length){$('#collapse-qui-detail').click(function(){$('#qui-detail').slideToggle();$('#collapse-qui-detail').toggleClass('togarw-up-drk togarw-dn-drk');});}}};$(document).ready(function(){if($('#my-profile').length){Profile.initMyProfile();}});
Main={setToggleVisibilityArea:function(toggle_ele,toggle_btn,btn_type){$(toggle_btn).click(function(){$(toggle_ele).slideToggle();$(toggle_btn).toggleClass('togarw-up-'+btn_type+' togarw-dn-'+btn_type);});},rollover:{init:function(){$(".rollover").hover(function(){src_off=$(this).attr('src');src_on=$(this).attr('rel');$(this).attr('src',src_on);$(this).attr('rel',src_off);},function(){src_on=$(this).attr('src');src_off=$(this).attr('rel');$(this).attr('src',src_off);$(this).attr('rel',src_on);});var cache=new Array();$(".rollover").each(function(){var cacheImage=document.createElement('img');cacheImage.src=$(this).attr('rel');cache.push(cacheImage);});}}}
$(document).ready(function(){$('.top-settings').mouseover(function(){$('.top-setting-menu').css('display','block');$('.top-settings').css('background-color','#222222');});$('.top-settings').mouseout(function(){$('.top-setting-menu').css('display','none');$('.top-settings').css('background-color','');});$('.top-setting-menu').mouseover(function(){$('.top-setting-menu').css('display','block');$('.top-settings').css('background-color','#222222');});$('.top-setting-menu').mouseout(function(){$('.top-setting-menu').css('display','none');$('.top-settings').css('background-color','');});COURSE.add_course.init();COURSE.delete_course.init();DASHBOARD.notification_tabs.init();DOCUMENT.course_tabs.init();DOCUMENT.delete_document.init();DOCUMENT.toggle_form.init();DOCUMENT.list.autopager();POST.add_post.init();POST.edit_post_link.init();POST.add_comment_link.init();POST.edit_comment_link.init();POST.submit_comment_form.init();POST.flag_as_inappropriate.tooltips();USER.add_friend.init();USER.register.init();USER.fsicon.tooltips();USER.new_member.autopager();Profile.initQuickUserProfile();Main.rollover.init();$("select").uniform();$('#file').customFileInput();$('.default-value').each(function(){var default_value=this.value;$(this).focus(function(){if(this.value==default_value){this.value='';}});$(this).blur(function(){if(this.value==''){this.value=default_value;}});});});function formFieldFocus(inputElement,defaultVal,isPasswd){if(inputElement.value==defaultVal){inputElement.value="";if(isPasswd)changeInputType(inputElement,"password");}}
function formFieldBlur(inputElement,defaultVal,isPasswd){if(inputElement.value==""){inputElement.value=defaultVal;if(isPasswd)changeInputType(inputElement,"text");}}
function changeInputType(obj,otype){obj.setAttribute('type',otype);}
(function($){$("a.zoom").live("click",function(event){event.preventDefault();var winZoom=$('#idZoomWindow');if(winZoom){var screenWidth=$(window).width();var screenHeight=$(window).height()-60;var url=$(this).attr('href');if(winZoom.css('display')=='block'){winZoom.css('display','none');winZoom.html('');}else{var img=new Image();img.src=url;img.onload=function(){var winWidth=img.width,winHeight=img.height;if(winWidth>screenWidth)
winWidth=screenWidth;if(winHeight>(screenHeight-10))
winHeight=(screenHeight-10);winZoom.html('<a id="zoomImage" class="href-cursor"><img src="'+url+'" style="height:'+winHeight+'px;" /></a>');winZoom.css('display','block');var top=-(winHeight/2)-4;var left=-(winWidth/2);left=-((screenWidth-winWidth)/2);};}}});$('a#zoomImage img').live("click",function(event){var winZoom=$('#idZoomWindow');if(winZoom){winZoom.css('display','none');winZoom.html('');}});})(jQuery);