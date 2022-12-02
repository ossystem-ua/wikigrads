jQuery(document).ready(function(){

    // set filters
    jQuery('#instructor_course_user_id').change(function(){
        var userId = jQuery('#instructor_course_user_id').val();
        jQuery('#instructor_course_course_id').css('display', 'none');
        jQuery.ajax({
            url: '/backend.php/coursefilter',
            data: {
                userId: userId,
                courseId: 0,
                queryType: 1
            },
            success: function(data) {
                jQuery('#instructor_course_course_id').html(data);
                jQuery('#instructor_course_course_id').css('display', 'block');
            }
        });
    });

    // set filters
    jQuery('#instructor_course_course_id').change(function(){
        var userId = jQuery('#instructor_course_user_id').val();
        var courseId = jQuery('#instructor_course_course_id').val();
        jQuery.ajax({
            url: '/backend.php/coursefilter',
            data: {
                userId: userId,
                courseId: courseId,
                queryType: 2
            },
            success: function(data) {
                //jQuery('#instructor_course_user_id').html(data);
            }
        });
    });
});
