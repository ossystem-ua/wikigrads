<?php

class mainComponents extends sfComponents
{
    public function executeMenu()
    {
        $menu = array(
            'Home' => '@homepage',
            'Academic Terms' => '@academic_term',
            'Subject' => '@subject',
            'Courses' => '@course',
            'Course Importer' => '@course_import',
            'Department' => '@department',
            'Document' => '@document',
            'Events' => '@event',
            'Schools' => '@school',
            // disabled school_email and allow all .edu emails
            //'School Emails' => '@school_email',            
            'Instructor' => '@instructorcourse',
            'Users' => '@sf_guard_user',
            //'UsersProfile' => '@sfGuardUserProfile', // sfGuardUserProfile
            'UserSchool' => '@user_school',
            'LMS Domain Key and Secrets' => '@LMSDomainKeySecret',
            /*'UserGroup' => '@sf_guard_user_group',*/ // DELETED FUNCTION SAVE
            //'Logout' => '@sf_guard_signout',
        );
        
        $this->menu = $menu;
    }
    
    public function executeWikiHeader(){
        if (!$this->getUser()->isAuthenticated()) {
            
        }
        $menu = array(
            //'Home' => '@homepage',
            'Academic Terms' => '@academic_term',
            //'Subject' => '@subject',
            'Courses' => '@course',
            'Course Importer' => '@course_import',
            'Department' => '@department',
            //'Document' => '@document',
            //'Events' => '@event',
            'Schools' => '@school',
            // disabled school_email and allow all .edu emails
            //'School Emails' => '@school_email',            
            'Instructor' => '@instructorcourse',
            'Users' => '@sf_guard_user',
            //'UsersProfile' => '@sfGuardUserProfile', // sfGuardUserProfile
            'UserSchool' => '@user_school',
            'LMS Domain Key and Secrets' => '@LMSDomainKeySecret',
            /*'UserGroup' => '@sf_guard_user_group',*/ // DELETED FUNCTION SAVE
            //'Logout' => '@sf_guard_signout',
        );
        
        $this->menu = $menu;
        $this->user = $this->getUser();
        $this->profile = $this->getUser()->getProfile();        
    }
}