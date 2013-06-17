<?php

/* Daniel McKay & Ronan Reilly 2012 */

class Assignment_controller extends CI_Controller {

    function load_assign_survey_page() {
        $id = $this->input->post('surveyId');
        if (empty($id)) {
            $data['surveyId'] = $this->uri->segment(4);
        } else {
            $data['surveyId'] = $id;
        }
        $this->load->model('users_model');
        $data['rows'] = $this->users_model->get_relevant_mobile_accounts();
        $data['main_content'] = 'webUser_views/assign_survey_form';
        $this->load->view('myTemplates/template', $data);
    }

    function assign_survey_validate() {
        $id = $this->uri->segment(4);
        $this->form_validation->set_rules('managerNotes', 'Manager Notes', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('assign', 'Mobile Users', 'required');
        if ($this->form_validation->run()) {
            $this->assign_survey();
        } else {
            echo '<h1 class="error_head">Sorry, the survey was not assigned, see errors & please try again!</h1>';
            $this->load_assign_survey_page();
        }
    }

    function assign_survey() {
        $data['managerNotes'] = $this->input->post('managerNotes');
        $data['surveyId'] = $this->input->post('surveyId');
        $this->load->model('assignments_model');
        $this->assignments_model->assign_to_table($data);
        $data['assign'] = $this->input->post('assign');
        $data['assignId'] = $this->db->insert_id();
        $this->load->model('assignments_model');
        $this->assignments_model->assign_to_users($data);
        redirect('webUser_Controllers/survey_controller/view_survey_details/' . $data['surveyId']);
    }

    function delete_assignment() {
        $data['assignmentId'] = $this->uri->segment(4);
        $this->load->model('assignments_model');
        // This method returns the surveyId. Save as $q to append to redirect.
        $q = $this->assignments_model->delete_single_assignment($data);
        redirect('webUser_Controllers/survey_controller/view_survey_details/' . $q);
    }

    function view_whos_assigned() {

        $this->load->model('assignments_model');
        $data['names'] = $this->assignments_model->get_assigned_users();
        //print_r($count);

        $data['main_content'] = 'webUser_views/view_mobile_user_assignments';
        $this->load->view('myTemplates/template', $data);
    }

    function delete_mob_user_from_assignment() {
        $this->load->model('assignments_model');
        $this->assignments_model->delete_this_mob_user_from_assignment();
        $this->view_whos_assigned();
    }

}

