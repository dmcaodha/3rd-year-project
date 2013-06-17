<?php

/* Daniel McKay & Ronan Reilly 2012 */

class Survey_controller extends CI_Controller {

    function new_survey() {

        $data['main_content'] = 'webUser_views/new_survey_form';
        $this->load->view('myTemplates/template', $data);
    }

    function create_survey() {
        // field name, error message, validation rules
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('topic', 'Topic', 'trim|required|min_length[4]');

        if ($this->form_validation->run()) {

            $this->load->model('surveys_model');
            $query = $this->surveys_model->create_new_survey();
            // Get the data array to pass to the view
            //$data = $this->input->post();
            // Get the surveyId and save it to the session data
            $data['surveyId'] = $this->db->insert_id();
            $this->session->set_userdata($data);
            if ($query) {
                redirect('webUser_Controllers/survey_controller/get_survey_details');
            } else {
                // TODO return an error message
                echo '<h1 class="error_head">Failed to create survey, see errors below!</h1>';
                $this->new_survey();
            }
        } else {
            // TODO return an error message
            echo '<h1 class="error_head">Failed to create survey, see errors below!</h1>';
            $this->new_survey();
        }
    }

    function get_survey_details() {
        $this->load->model('surveys_model');
        $survey = $this->surveys_model->get_a_survey();

        if ($survey != null) { // if such user exists
            $data = array(
                'title' => $survey->title,
                'topic' => $survey->topic,
                'main_content' => 'webUser_views/add_question_form'
            );
            $this->load->view('myTemplates/template', $data);
        } else {
            echo 'Failed to get survey details';
        }
    }

    function all_user_surveys() {
        // do not remove
        $this->session->unset_userdata('currentSurvey');
        $this->load->model('surveys_model');
        $data['rows'] = $this->surveys_model->get_all_surveys();
        $data['main_content'] = 'webUser_views/view_all_surveys';
        $this->load->view('myTemplates/template', $data);
    }

    function view_survey_details() {
        // sets this for back to survey link in toolbar
        // this is unset when user goes back to dashboard
        // and when they go back to all surveys
        // do not remove
        $data = array(
            'currentSurvey' => $this->uri->segment(4)
        );
        $this->session->set_userdata($data);
        $data = array();
        $data['id'] = $this->uri->segment(4);
        $this->load->model('surveys_model');
        $q = $this->surveys_model->get_a_survey();
        if ($q) {
            $data['survey'] = $q;
        } else {
            echo '<h1 class="error_head">Failed to retrieve survey<h1>';
            $this->all_user_surveys();
        }
        $this->load->model('questions_model');
        $query = $this->questions_model->get_questions_from_survey();
        // run this query and if something is returned
        if ($query) {
            $data['questions'] = $query;
        } else {
            //echo "Failed on Questions";
        }
        $this->load->model('assignments_model');
        $next = $this->assignments_model->get_assignments_from_survey();
        if ($query) {
            $data['assignments'] = $next;
        } else {
            //echo "Failed on Questions";
        }
        $data['main_content'] = 'webUser_views/view_survey';
        $this->load->view('myTemplates/template', $data);
    }

    function delete_survey() {
        $this->load->model('surveys_model');
        $this->surveys_model->delete_single_survey();
        $this->load->model('questions_model');
        $this->questions_model->delete_questions_answers();
        $this->load->model('assignments_model');
        $this->assignments_model->delete_associated_assignments();
        $this->assignments_model->delete_associated_responses();
        $this->session->unset_userdata('currentSurvey');
        $this->all_user_surveys();
    }

    function edit_survey() {
        $data['id'] = $this->uri->segment(4);
        $this->load->model('surveys_model');
        $q = $this->surveys_model->get_a_survey();
        if ($q) {
            $data['survey'] = $q;
        } else {
            echo "Failed on Survey";
        }
        $this->load->model('questions_model');
        $query = $this->questions_model->get_questions_from_survey();
        // run this query and if something is returned
        if ($query) {
            $data['questions'] = $query;
        } else {
            //echo "Failed on Questions";
        }
        $data['main_content'] = 'webUser_views/edit_survey_form';
        $this->load->view('myTemplates/template', $data);
    }

    function update_survey() {
        $id = $this->input->post('id');
        $data = array(
            'id' => $id,
            'title' => $this->input->post('title'),
            'topic' => $this->input->post('topic')
        );
        $this->load->model('surveys_model');
        $this->surveys_model->update_single_survey($data);
        redirect('webUser_Controllers/survey_controller/view_survey_details/' . $id);
    }

    // This function goes back to the current survey being viewed
    function back_to_survey() {
        redirect('webUser_Controllers/survey_controller/view_survey_details/' . $this->session->userdata('currentSurvey'));
    }

    /** VIEW RESPONSES * */
    /** VIEW RESPONSES * */

    /** VIEW RESPONSES * */
    function check_question_type() {
        $this->load->model('questions_model');
        $question = $this->questions_model->check_question_type();

        if ($question != null) {

            if ($question->type == 'text') {
                $this->view_text_responses();
            } else if ($question->type == 'multi3') {
                $this->view_multi3_responses();
            } else if ($question->type == 'multi5' || $question->type == 'rating') {
                $this->view_multi5_responses();
            }
        } else {
            echo "There is no question of that type!";
        }
    }

    function view_text_responses() {
        $this->load->model('questions_model');
        $data['question'] = $this->questions_model->get_question_text();
        $data['rows'] = $this->questions_model->get_text_questions_answers();
        $this->load->view('webUser_views/view_text_responses', $data);
    }

    function view_multi3_responses() {
        $this->load->model('questions_model');
        $data['question'] = $this->questions_model->get_question_text();
        $data['choices'] = $this->questions_model->get_multi_choice_possible_answers();
        $data['choice_one_ans'] = $this->questions_model->get_choice_one_answer_count();
        $data['choice_two_ans'] = $this->questions_model->get_choice_two_answer_count();
        $data['choice_three_ans'] = $this->questions_model->get_choice_three_answer_count();
        //print_r($data['choice_one_ans']);
        $this->load->view('webUser_views/view_multi3_responses', $data);
    }

    function view_multi5_responses() {
        $this->load->model('questions_model');
        $data['question'] = $this->questions_model->get_question_text();
        $data['choices'] = $this->questions_model->get_multi_choice_possible_answers();
        $data['choice_one_ans'] = $this->questions_model->get_choice_one_answer_count();
        $data['choice_two_ans'] = $this->questions_model->get_choice_two_answer_count();
        $data['choice_three_ans'] = $this->questions_model->get_choice_three_answer_count();
        $data['choice_four_ans'] = $this->questions_model->get_choice_four_answer_count();
        $data['choice_five_ans'] = $this->questions_model->get_choice_five_answer_count();
        $this->load->view('webUser_views/view_multi5_responses', $data);
    }

}