<?php

/* Daniel McKay & Ronan Reilly 2012 */

class Manage_mobile_users extends CI_Controller {

    function index() {
        $this->load->model('users_model');
        // giving our array a key 'rows' and then calling the gat all method
        // from the model whic fetches all rows from the database
        $data['rows'] = $this->users_model->get_relevant_mobile_accounts();

        $data['main_content'] = 'webUser_views/manage_mobile_accounts';
        $this->load->view('myTemplates/template', $data);
    }

    function delete_mobile_account() {
        $this->load->model('users_model');
        $this->users_model->delete_this_mobile_account();
        $this->load->model('assignments_model');
        $this->assignments_model->delete_user_assignments();
        redirect('webUser_Controllers/manage_mobile_users/index');
    }

    function load_edit_mobile_account_form() {
        $data = array(
            'currentMobAccount' => $this->uri->segment(4)
        );
        $this->session->set_userdata($data);
        $data['main_content'] = 'webUser_views/edit_mobile_user_form';
        $this->load->view('myTemplates/template', $data);
    }

    function load_edit_mobile_account_form_failed_validation() {
        //echo $this->session->userdata('currentMobAccount');
        $data['main_content'] = 'webUser_views/edit_mobile_user_form';
        $this->load->view('myTemplates/template', $data);
    }

    function edit_mobile_account() {
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]|strong_pass[3]');
        $this->form_validation->set_rules('passwordConfirm', 'Confirm Password', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            echo "<h1 class='error_head'>Sorry! There was a problem editing the password, please try again!</h1>";
            $this->load_edit_mobile_account_form_failed_validation();
        } else {
            $this->load->model('users_model');
            if ($query = $this->users_model->edit_this_mobile_account()) {
                $this->session->unset_userdata('currentMobAccount');
                //echo "<h1>Mobile account password, successfully changed!</h1>";
                redirect('webUser_Controllers/manage_mobile_users/index');
            } else {
                echo "<h1 class='error_head'>Sorry! There was a problem editing the password, please try again!</h1>";
                $this->load_edit_mobile_account_form_failed_validation();
            }
        }
    }

    function load_create_mobile_user_form() {
        $data['main_content'] = 'webUser_views/create_mobile_user_form';
        $this->load->view('myTemplates/template', $data);
    }

    function create_mobile_account() {

        $this->form_validation->set_rules('userName', 'Username', 'trim|required|min_length[4]|max_length[40]|check_mobile_userName[mobile_users.userName]');
        $this->form_validation->set_rules('Password', 'trim|required|min_length[6]|max_length[32]|strong_pass[3]');
        $this->form_validation->set_rules('passwordConfirm', 'Confirm Password', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            echo "<h1 class='error_head'>Sorry! There was a problem adding this mobile account, please try again!</h1>";
            $this->load_create_mobile_user_form();
        } else {
            $this->load->model('users_model');
            if ($query = $this->users_model->create_this_mobile_user()) {
                //echo "<h1>Mobile account successfully added!</h1>";
                redirect('webUser_Controllers/manage_mobile_users/index');
            } else {
                echo "<h1 class='error_head'>Sorry! There was a problem adding the mobile account, please try again!</h1>";
                $this->load_create_mobile_user_form();
            }
        }
    }

}