<?php

/* Daniel McKay & Ronan Reilly 2012 */

class Login extends CI_Controller {

    function index() {

        $data['main_content'] = 'login_form';
        $this->load->view('myTemplates/template', $data);
    }

    function validate_credentials() {
        $this->load->model('users_model');
        $user = $this->users_model->validate();

        if ($user != null) { // if such user exists
            $data = array(
                'username' => $this->input->post('username'),
                'accountType' => $user->accountType,
                'userID' => $user->id,
                'is_logged_in' => true
            );
            $this->session->set_userdata($data);
            if ($user->accountType == 'web_user') {
                redirect('webUser_Controllers/webUser_homepage/index');
            } else {
                redirect('adminUser_Controllers/adminUser_homepage/index');
            }
            //redirect('user_dashboard_decider/webUser_or_admin');
        } else {
            echo '<h1 class="error_head">There was a problem with the details you entered, please try again...</h1>';
            $this->index();
        }
    }

    function signup() {
        $data['main_content'] = 'signUp_form';
        $this->load->view('myTemplates/template', $data);
    }

    function create_webUser() {
        // field name, error message, validation rules
        $this->form_validation->set_rules('firstName', 'First Name', 'trim|required|min_length[4]|max_length[20]');
        $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required|min_length[4]|max_length[20]');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email ');
        $this->form_validation->set_rules('userName', 'Username', 'trim|required|min_length[4]|alpha_numeric|check_web_userName[site_users.userName]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|strong_pass[3]');
        $this->form_validation->set_rules('passwordConfirm', 'Confirm Password', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            echo '<h1 class="error_head">Sorry, but there was a problem with the details you entered, please try again!</h1>';
            $this->signup();
        } else {
            $this->load->model('users_model');
            if ($query = $this->users_model->create_user()) {
                $data['main_content'] = 'signUp_successful';
                $this->load->view('myTemplates/template', $data);

                $name = $this->input->post('firstName');
                $email = $this->input->post('email');

                //$this->load->library($config);
                $this->email->set_newline("\r\n");

                $this->email->from('ourfinalprojectyear3@gmail.com', 'Ronan Reilly & Daniel McKay');
                $this->email->to($email);
                $this->email->subject('Survey Sign Up Successful!');
                $this->email->message('You Have Successfully signed up to use our survey app..');

                // Email does not actually send, beacause mostle when testing false emails will be
                // entered when creating accounts, but this does work.
                /* if($this->email->send()) {
                  echo 'A Confirmation Email Has Been Sent To The Email Address You Provided ';
                  }
                  else {
                  show_error($this->email->print_debugger());
                  } */
            } else {
                echo '<h1 class="error_head">Sorry, but there was a problem with the details you entered, please, try again!</h1>';
                $data['main_content'] = 'signUp_form';
                $this->load->view('myTemplates/template', $data);
            }
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('login/index');
    }

}

?>
