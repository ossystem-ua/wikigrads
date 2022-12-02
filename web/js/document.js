/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


(function($) {
    
    if (!window.DOCUMENT) {
        DOCUMENT = {};
    }
    
    DOCUMENT.delete_document = {
        init: function() {
            if ($('#document-tabs').length) {
                
                $('#document-tabs a.document-delete').live('click', function() {
                    var dom_element = this;
                    
                    if(confirm('Are you sure?')) {
                        DOCUMENT.delete_document.events.delete_document.apply(dom_element);
                    }
                });
            }
        },
        
        events: {
            delete_document: function(event) {
                var element = $(this);
                
                $.ajax({
                    url: element.attr('data-url'),
                    success: function(data, textStatus, XMLHttpRequest) {
                        
                        $("#single-document-"+element.attr('data-id')).remove();
                        
                        //$('#course_list').trigger('refresh');
                    }
                });
            }
        }
    };        
    
   
    
    DOCUMENT.course_tabs = {
        init: function() {
            
            var documentTabs = $('#document-tabs');
            
            if (documentTabs.length) {
                
                documentTabs.tabs({
                    select: function(event, ui) {
                        $("#document-list").remove();
                    },
                    ajaxOptions: {
                        error: function( xhr, status, index, anchor ) {
				$( anchor.hash ).html(
                                    "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                                    "If this wouldn't be a demo." );
				}
			}
                });
                
            }
        }
    };    
    
    
    DOCUMENT.toggle_form = {
      init: function(){
  
        if($('#document-upload-button ').length) {
            $('#document-upload-button').click(function(){
                $('#form-document-add').slideToggle();
                 $('#document-upload-button').toggle();
                //$('#collapse-qui-detail').toggleClass('togarw-up-drk togarw-dn-drk');
            });
        }  
          
      }
      
      
    };
    
    DOCUMENT.list = {
        autopager: function() {
            if($('#document-list').length) {
                AutoPager.init('#document-list');    
            }
        }
    }
    
    
    
})(jQuery);