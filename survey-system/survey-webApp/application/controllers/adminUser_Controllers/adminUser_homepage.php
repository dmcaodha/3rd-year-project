<?php

/* Daniel McKay & Ronan Reilly 2012 */

class AdminUser_homepage extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->session->userdata('accountType') != 'admin_user') {
            redirect('login/logout');
        }
    }

    function index() {
        $altView['main_content'] = 'adminUser_views/admin_dashboard';
        $this->load->view('myTemplates/template', $altView);
    }

    /* ADMIN MANAGE WEB ACCOUNTS */

    function load_manage_web_users() {
        $this->load->model('users_model');
        // giving our array a key 'rows' and then calling the gat all method
        // from the model whic fetches all rows from the database
        $data['rows'] = $this->users_model->get_all_web_user_records();
        $this->load->view('adminUser_views/manage_all_web_users', $data);
    }

    function delete_web_account() {
        $this->load->model('users_model');
        $this->users_model->admin_delete_account();
        $this->users_model->admin_delete_associated_mobile_accounts();
        $this->load->model('surveys_model');
        $this->surveys_model->admin_delete_associated_surveys();
        redirect('adminUser_Controllers/adminUser_homepage/load_manage_web_users');
    }

    function load_edit_web_account_form() {

        $data = array(
            'currentWebAccount' => $this->uri->segment(4)
        );
        $this->session->set_userdata($data);
        //echo $this->session->userdata('currentMobAccount');
        $data['main_content'] = 'adminUser_views/admin_edit_user_form';
        $this->load->view('myTemplates/template', $data);
    }

    function admin_edit_this_web_user() {
        $this->form_validation->set_rules('firstName', 'First Name', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('email', 'Email Address, must be valid --> "joe@bloggs.com"', 'trim|required|valid_email');
        $this->form_validation->set_rules('userName', 'Username', 'trim|required|min_length[4]|check_web_userName[site_users.userName]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|strong_pass[3]');
        $this->form_validation->set_rules('passwordConfirm', 'Passwords do not match!', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load_edit_web_account_form();
            echo '<h1 class="error_head">Sorry, but there was a problem creating this account, please try again!</h1>';
        } else {
            //echo "<h1>You have successfully added an account!</h1>";
            $this->load->model('users_model');
            if ($query = $this->users_model->admin_update_account()) {
                $this->session->unset_userdata('currentWebAccount');
                redirect('adminUser_Controllers/adminUser_homepage/load_manage_web_users');
                //$name = $this->input->post('firstName');
                //$email = $this->input->post('email');
            } else {
                echo '<h1 class="error_head">Sorry, but there was a problem creating this account, please try again!</h1>';
                $this->load_edit_web_account_form();
            }
        }
    }

    function load_create_web_user_form() {
        $data['main_content'] = 'adminUser_views/admin_create_web_user_form';
        $this->load->view('myTemplates/template', $data);
    }

    function create_new_web_user() {
        $this->form_validation->set_rules('firstName', 'First Name', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('email', 'Email Address, must be valid --> "joe@bloggs.com"', 'trim|required|valid_email');
        $this->form_validation->set_rules('userName', 'Username', 'trim|required|min_length[4]|check_web_userName[site_users.userName]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|strong_pass[3]');
        $this->form_validation->set_rules('passwordConfirm', 'Passwords do not match!', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load_create_web_user_form();
            echo '<h1 class="error_head">Sorry, but there was a problem creating this account, please try again!</h1>';
        } else {
            //echo "<h1>You have successfully added an account!</h1>";
            $this->load->model('users_model');
            if ($query = $this->users_model->admin_create_new_user()) {
                redirect('adminUser_Controllers/adminUser_homepage/load_manage_web_users');
                //$name = $this->input->post('firstName');
                //$email = $this->input->post('email');
            } else {
                echo '<h1 class="error_head">Sorry, but there was a problem creating this account, please try again!</h1>';
                $this->load_create_web_user_form();
            }
        }
    }

    /* ADMIN MANAGE MOBILE ACCOUNTS */

    function load_manage_mobile_users() {
        $this->load->model('users_model');
        // giving our array a key 'rows' and then calling the gat all method
        // from the model whic fetches all rows from the database
        $data['rows'] = $this->users_model->get_all_mobile_user_records();
        $this->load->view('adminUser_views/manage_all_mobile_users', $data);
    }

    function load_create_mobile_user_form() {
        $data['main_content'] = 'adminUser_views/admin_create_mobile_user_form';
        $this->load->view('myTemplates/template', $data);
    }

    function create_mobile_account() {

        $this->form_validation->set_rules('userName', 'Username', 'trim|required|min_length[4]|max_length[25]|check_mobile_userName[mobile_users.userName]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|strong_pass[3]');
        $this->form_validation->set_rules('passwordConfirm', 'Confirm Password', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            echo '<h1 class="error_head">Sorry! There was a problem adding this mobile account, please try again!</h1>';
            $this->load_create_mobile_user_form();
        } else {
            $this->load->model('users_model');
            if ($query = $this->users_model->create_this_mobile_user()) {
                //echo "<h1>Mobile account successfully added!</h1>";
                redirect('adminUser_Controllers/adminUser_homepage/load_manage_mobile_users');
            } else {
                echo '<h1 class="error_head">Sorry! There was a problem adding the mobile account, please try again!</h1>';
                $this->load_create_mobile_user_form();
            }
        }
    }

    function delete_mobile_account() {
        $this->load->model('users_model');
        $this->users_model->delete_this_mobile_account();
        $this->load->model('assignments_model');
        $this->users_model->delete_user_assignments();
        //echo "<h1 class='mob_view'>Account Deleted Succesfully!</h1>";
        redirect('adminUser_Controllers/adminUser_homepage/load_manage_mobile_users');
    }

    function load_edit_mobile_account_form() {
        $data = array(
            'currentMobAccount' => $this->uri->segment(4)
        );
        $this->session->set_userdata($data);
        $data['main_content'] = 'adminUser_views/admin_edit_mobile_user_form';
        $this->load->view('myTemplates/template', $data);
    }

    function edit_mobile_account() {
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|strong_pass[3]');
        $this->form_validation->set_rules('passwordConfirm', 'Confirm Password', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            echo '<h1 class="error_head">Sorry! There was a problem editing the password, please try again!</h1>';
            $this->load_manage_mobile_users();
        } else {
            $this->load->model('users_model');
            if ($query = $this->users_model->edit_this_mobile_account()) {
                $this->session->unset_userdata('currentMobAccount');
                //echo "<h1>Mobile account password, successfully changed!</h1>";
                redirect('adminUser_Controllers/adminUser_homepage/load_manage_mobile_users');
            } else {
                echo '<h1 class="error_head">Sorry! There was a problem editing the password, please try again!</h1>';
                $this->load_manage_mobile_users();
            }
        }
    }

    /* ADMIN MANAGE SURVEYS */

    function load_manage_surveys() {
        $this->load->model('surveys_model');
        // giving our array a key 'rows' and then calling the gat all method
        // from the model whic fetches all rows from the database
        $data['rows'] = $this->surveys_model->get_all_surveys_on_system();
        $this->load->view('adminUser_views/admin_manage_all_surveys', $data);
    }

    function delete_this_survey() {
        $this->load->model('surveys_model');
        $this->surveys_model->delete_single_survey();
        $this->load->model('questions_model');
        $this->questions_model->delete_questions_answers();
        $this->load->model('assignments_model');
        $this->assignments_model->delete_associated_assignments();
        $this->assignments_model->delete_associated_responses();
        $this->session->unset_userdata('currentSurvey');
        $this->load_manage_surveys();
    }

    function load_manage_assignments() {
        $this->load->model('assignments_model');
        $data['rows'] = $this->assignments_model->get_all_assignments_on_system();
        $this->load->view('adminUser_views/admin_manage_assignments', $data);
    }

    function delete_this_assignment() {
        $this->load->model('assignments_model');
        $this->assignments_model->admin_delete_this_assignment();
        $this->load->model('assignments_model');
        $this->assignments_model->admin_delete_associated_user_assignments();
        redirect('adminUser_Controllers/adminUser_homepage/load_manage_assignments');
    }

}
