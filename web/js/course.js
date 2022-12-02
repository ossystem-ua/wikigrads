(function($) {
    
    if (!window.COURSE) {
        COURSE = {};
    }
    
    COURSE.add_course = {
        init: function() {
            //if ($('[id^="sfguarduser"]').length) {
                $('#course_add_department_id').live('change', COURSE.add_course.events.update_course_dropdown);
           // }
        },
        
        events: {
           
            update_course_dropdown: function(event) {
                var element = $(this);
                var form = element.closest('form');
                //alert("here");
                
                $.ajax({
                    url: form.attr('action'),
                    type: 'GET',
                    data: form.serialize(),
                    success: function(data, textStatus, XMLHttpRequest) {
                        form.replaceWith(data);
                        $('#form-course-add select').uniform();
                    }
                });
            }
        }
    };
    
    COURSE.delete_course = {
        init: function() {
            if ($('#course-list').length || $('#courses-quick-list').length) {
                
                $('a.course-delete').live('click', function() {
                    var dom_element = this;
                    
                    if(confirm('Are you sure?')) {
                         COURSE.delete_course.events.delete_course.apply(dom_element);
                    }
                });
            }
        },
        
        events: {
            delete_course: function(event) {
                var element = $(this);
                
                $.ajax({
                    url: element.attr('data-url'),
                    success: function(data, textStatus, XMLHttpRequest) {
                        window.location.reload();
                        //$('#course_list').trigger('refresh');
                    }
                });
            }
        }
    };    
    

    
})(jQuery);