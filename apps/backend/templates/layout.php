<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <title>WikiGrads | <?php echo $sf_response->getTitle() ?></title>
    <link rel="shortcut icon" href="<?php echo image_path('favicon.ico')?>" />
    <?php include_stylesheets(); ?>
<!--    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
    <?php include_javascripts(); ?>

</head>
<body>

    <?php if ($sf_user->isAuthenticated()): ?>
    <div id="wiki-block-main">

        <?php include_component('main', 'wikiHeader') ?>

        <div class="wiki-float-row"></div>
        <div class="wiki-block-center">
            <?php echo $sf_content ?>
        </div>

    </div>
    <?php else: ?>
    <div class="wiki-center">
        <div class="wiki-block-login">
            <?php echo $sf_content ?>
        </div>
    </div>
    <?php endif; ?>
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">-->
<script type="text/javascript">
jQuery(document).ready(function(){
    var department = jQuery('#autocomplete_course_filters_department_id');
    var department1 = jQuery('#autocomplete_course_department_id');
    var department2 = jQuery('#autocomplete_user_school_primary_department_id');
    var department3 = jQuery('#autocomplete_user_school_secondary_department_id');
    var school = jQuery('#autocomplete_user_school_filters_school_id');
    var school1 = jQuery('#autocomplete_department_filters_school_id');
    var school2 = jQuery('#autocomplete_user_school_school_id');
    var school3 = jQuery('#autocomplete_department_school_id');
    var school4 = jQuery('#autocomplete_course_filters_school_id');
    var user = jQuery('#autocomplete_user_school_filters_user_id');
    var course = jQuery('#autocomplete_instructor_course_filters_course_id');
    var course2 = jQuery('#autocomplete_instructor_course_course_id');
    var user1 = jQuery('#autocomplete_instructor_course_filters_user_id');
    var user2 = jQuery('#autocomplete_instructor_course_user_id');
    var user3 = jQuery('#autocomplete_user_school_user_id');
    var user4 = jQuery('#autocomplete_user_school_filters_user_id');
    var user5 = jQuery('#autocomplete_user_school_school_id');

    if (department && parseInt(department.val()) > 0) {
        checkObjectId (department, department.val(), 'Department');
    }

    if (department1 && parseInt(department1.val()) > 0) {
        checkObjectId (department1, department1.val(), 'Department');
    }

    if (department2 && parseInt(department2.val()) > 0) {
        checkObjectId (department2, department2.val(), 'Department');
    }

    if (department3 && parseInt(department3.val()) > 0) {
        checkObjectId (department3, department3.val(), 'Department');
    }

    if (school && parseInt(school.val()) > 0) {
         checkObjectId (school, school.val(), 'School');
    }

    if (school1 && parseInt(school1.val()) > 0) {
         checkObjectId (school1, school1.val(), 'School');
    }

    if (school2 && parseInt(school2.val()) > 0) {
         checkObjectId (school2, school2.val(), 'School');
    }

    if (school3 && parseInt(school3.val()) > 0) {
         checkObjectId (school3, school3.val(), 'School');
    }
    
    if (school4 && parseInt(school4.val()) > 0) {
         checkObjectId (school4, school4.val(), 'School');
    }

    if (user && parseInt(user.val()) > 0) {
        checkObjectId (user, user.val(), 'sfGuardUser');
    }

    if (user1 && parseInt(user1.val()) > 0) {
        checkObjectId (user1, user1.val(), 'sfGuardUser');
    }

    if (user2 && parseInt(user2.val()) > 0) {
        checkObjectId (user2, user2.val(), 'sfGuardUser');
    }

    if (user3 && parseInt(user3.val()) > 0) {
        checkObjectId (user3, user3.val(), 'sfGuardUser');
    }

    if (user4 && parseInt(user3.val()) > 0) {
        checkObjectId (user3, user3.val(), 'sfGuardUser');
    }

    if (user5 && parseInt(user3.val()) > 0) {
        checkObjectId (user3, user3.val(), 'School');
    }

    if (course && parseInt(course.val()) > 0) {
        checkObjectId (course, course.val(), 'Course');
    }

    if (course2 && parseInt(course2.val()) > 0) {
        checkObjectId (course2, course2.val(), 'Course');
    }
    setAutocomplete ('lms_domain_key_secret_filters_domain', 'LMSDomainKeySecret', 'domain');
    setAutocomplete ('lms_domain_key_secret_filters_secret', 'LMSDomainKeySecret', 'secret');
    setAutocomplete ('lms_domain_key_secret_filters_key_s', 'LMSDomainKeySecret', 'key_s');
    //setAutocomplete ('autocomplete_course_filters_department_id', 'Department', 'name');
    setAutocomplete ('course_filters_name', 'Course', 'name');
    setAutocomplete ('school_filters_name', 'School', 'name');
    //setAutocomplete ('autocomplete_course_filters_school_id', 'School', 'name');
    setAutocomplete ('sf_guard_user_filters_first_name', 'sfGuardUser', 'first_name');
    setAutocomplete ('sf_guard_user_filters_last_name', 'sfGuardUser', 'last_name');
    setAutocomplete ('sf_guard_user_filters_email_address', 'sfGuardUser', 'email_address');
    setAutocomplete ('department_filters_name', 'Department', 'name');
    setAutocomplete ('user_school_filters_major', 'UserSchool', 'major');
    setAutocomplete ('autocomplete_user_school_filters_user_id', 'sfGuardUserProfile', 'fullname');
    setAutocomplete ('autocomplete_user_school_filters_school_id', 'School', 'name');
 });

function checkObjectId (object, value, type) {
    
//    console.log(value, type);
    jQuery.ajax({
        url: '/backend.php/checkobject',
        data: {
            type: type,
            value: value
        },
        success: function (result,success,e) {
            result = JSON.parse(result);
            var name = '';
            if (result) {
                if (result.name) name = result.name;
            }
            object.val(name);
        }
    });
}

function setAutocomplete(objectId, table, field, changeCallback) {
    
    var object = jQuery('input#' + objectId);
    if (!object) return false;
    if (!object.attr('name')) return false;

    object.autocomplete2({
        minLength: 2,
        source: function(request, response){
            jQuery.ajax({
                url: "/backend.php/autotextcomplite/"+table,
                data:{
                    table: table,
                    field: field,
                    value: request.term
                },
                success: function(data){
                    data = JSON.parse(data);
                    response(data.data);
                }
            });
        }
    });
}


</script>
<style type="text/css">
    #ui-id-1 {
        width: 280px !important;
    }
</style>
</body>
</html>
