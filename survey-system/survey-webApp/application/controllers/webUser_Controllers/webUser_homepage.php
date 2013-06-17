<?php

/* Daniel McKay & Ronan Reilly 2012 */

class WebUser_homepage extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->session->userdata('accountType') != 'web_user') {
            redirect('login/logout');
        }
    }

    function index() {
        // do not remove
        $this->session->unset_userdata('currentSurvey');
        $this->session->unset_userdata('surveyId');

        $data['main_content'] = 'webUser_views/web_user_homepage';
        $this->load->view('myTemplates/template', $data);
    }

}

?>
