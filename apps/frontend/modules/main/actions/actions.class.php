<?php

class mainActions extends myActions {

    public function executeAutotextcomplite(sfWebRequest $request) {
        $table = $request->getParameter('table', null);
        $value = $request->getParameter('value', null);
        $field = $request->getParameter('field', null);
        $andWhereField = $request->getParameter('andWhereField',null);
        $andWhereValue = $request->getParameter('andWhereValue', null);

        $params = array();
        $params[':value'] = "%".$value."%";
        $t = Doctrine::getTable($table);
        if(in_array($field, $t->getColumnNames())) {
            $result = $t
                    ->createQuery('t')
                    ->where("LOWER(t.$field) LIKE :value",$params)
                    ->orderBy("t.$field", 'ASC');
                    $result = $result->execute();
        } else {
            $result = array();
        }

        $source = array();
        $source['table'] = $table;
        $source['field'] = $field;
        $source['value'] = $value;
        $source['total'] = count($result);

        $records = array();
        $success = 1;
        if ($source['total'] <= 0) {
            $success = 0;
        } else {
            foreach($result as $record) {
                $records[] = $record[$field];
            }
        }

        return $this->renderPartial('main/result_field', array('records' => $records, 'source' => $source, 'success' => $success));
    }
    /**
     * Updates all forums counters for current user
     * @param sfGuardUser $GU
     */
    public function updateCounters(sfGuardUser $GU) {
            $courses = $GU->getCourseList();
            $c_ids = array();
    }

    public function executeIndex(sfWebRequest $request) {
        $user = $this->getUser();

        if ($user) {
            if ($user->getGuardUser()){
                if ($user->getGuardUser()->getCourseList())
                    if (count($user->getGuardUser()->getCourseList()) <= 0) {
                        $this->redirect('/my-profile');
                    }
            }
        }

        if (!$user) {

        } elseif ($user->isAuthenticated()) {
            $this->updateCounters($user->getGuardUser());
            if ($user->getGuardUser()->getIsLms() === '0') {
                $this->redirect('@dashboard');
            } else {
                $this->session_course_id = new sfSessionStorage();
                $this->sessionCourseId = $this->session_course_id->read('cId');
                
                $this->redirect('@notification_course_list?type=course&slug='.$this->sessionCourseId);
            }
        }

        $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');

        $this->form = new $class();

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('signin'));


            // SUCCESSFUL LOGIN
            if ($this->form->isValid()) {
                $values = $this->form->getValues();
                $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);

                //Needed since this request gets the last redirect
                $user->getReferer($request->getReferer());

                $signinUrl = $user->getReferer($request->getReferer());

                $redirectUrl = '' != $signinUrl ? $signinUrl : '@homepage';

                return $this->redirect($redirectUrl);
            // FAILED LOGIN
            } else {
                $formStatus = Utils::getFormStatus($this->form);
                sfContext::getInstance()->getUser()->setFlash('login_error', $formStatus['form_errors']['username']);
                $failureSigninUrl = sfConfig::get('app_sf_guard_plugin_failure_signin_url', $user->getReferer($request->getReferer()));
                return $this->redirect($failureSigninUrl != '' ? $failureSigninUrl : '@homepage');
            }

        // if they made it here, then this is a page load after their session has timed out. this page is not directly linked to.
        } else {
            if ($request->isXmlHttpRequest()) {
                $this->getResponse()->setHeaderOnly(true);
                return sfView::NONE;
            }

            // if we have been forwarded, then the referer is the current URL
            // if not, this is the referer of the current request
            $user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

            $module = sfConfig::get('sf_login_module');

            if ($this->getModuleName() != $module)
            {
                return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
            }

        }

        $this->schools = Doctrine::getTable('School')->createQuery('s')
                    ->where('s.deleted_at is null')
                    ->fetchArray();

        $this->getResponse()->setTitle("Academic Network");

    }


    public function executeAbout(sfWebRequest $request){
        $this->getResponse()->setTitle("About Wikigrads");

    }

    public function executeContact(sfWebRequest $request){
         $this->getResponse()->setTitle("Contact Us");

    }

    public function executeFaq(sfWebRequest $request){


    }

    public function executeKeepInTouch(sfWebRequest $request){
        $this->getResponse()->setTitle("Keep In Touch");

    }

    public function executeRegister(sfWebRequest $request) {
        $this->registerForm = new RegisterForm();
    }


    public function executeStudentEngagement(sfWebRequest $request){


    }

    public function executeTerms(sfWebRequest $request){
        $this->getResponse()->setTitle('Terms and Conditions');
    }

    public function executePrivacy(sfWebRequest $request){
        $this->getResponse()->setTitle('Protect privacy');
    }

    public function executeWhyWikigrads(sfWebRequest $request){
        $this->getResponse()->setTitle('Why WikiGrads?');
    }

    public function executeTour(sfWebRequest $request){
        $this->getResponse()->setTitle("Take a tour");
    }
    public function executeTour2(sfWebRequest $request){
        $this->getResponse()->setTitle("Take a tour");
    }
    public function executeTour3(sfWebRequest $request){
        $this->getResponse()->setTitle("Take a tour");
    }

    public function executeDev(sfWebRequest $request) {

    }

    public function executeInfiniteAjaxLoadTest(sfWebRequest $request) {
        $this->setContentTitleSource('my_courses');

        #$page = $this->getPage($request);
        $page = $request->getParameter('page', 1);
        #$page = 1;
        #$this->setPage($page);

        $dq = PostTable::getInstance()->createQuery()->where('user_id = ?', 6);

        $this->pager = $this->getPager('Post', $dq, $page, 5);
    }
    
    public function executeError404()
    {
    }

}