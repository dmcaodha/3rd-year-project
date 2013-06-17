<?php

/* Daniel McKay & Ronan Reilly 2012 */

class Question_controller extends CI_Controller {

    function add_question() {
        // Get survey title and topic
        $this->load->model('surveys_model');
        $survey = $this->surveys_model->get_a_survey();

        $data = array(
            'title' => $survey->title,
            'topic' => $survey->topic,
            'main_content' => 'webUser_views/add_question_form'
        );
        // Get all the questions belonging the survey & save in $data
        // (Now a multi-dimensional array)
        $this->load->model('questions_model');
        $rows = $this->questions_model->get_questions_from_survey();
        $data['rows'] = $rows;

        $this->load->view('myTemplates/template', $data);
        $surveyId = $this->session->userdata('surveyId');
        //echo $surveyId;
    }

    function add_question_validate() {
        // Find out which submit button was pressed.
        $action = $this->input->get_post('submit');
        if ($action == 'Add Question') {
            // field name, error message, validation rules
            $this->form_validation->set_rules('question', 'Question', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('type', 'Question Type', 'callback_not_default_text');        // Call back function
            if ($this->form_validation->run()) {
                // Get question type
                $type = $this->input->post('type');
                // If a multi-choice, run validation on multi choice fields
                if ($type == "multi3" || $type == "multi5") {
                    $this->form_validation->set_rules('choice1', 'Choice 1', 'trim|required|min_length[1]');
                    $this->form_validation->set_rules('choice2', 'Choice 2', 'trim|required|min_length[1]');
                    $this->form_validation->set_rules('choice3', 'Choice 3', 'trim|required|min_length[1]');
                }
                if ($type == "multi5") {
                    $this->form_validation->set_rules('choice4', 'Choice 4', 'trim|required|min_length[1]');
                    $this->form_validation->set_rules('choice5', 'Choice 5', 'trim|required|min_length[1]');
                }
                if ($this->form_validation->run()) {
                    $this->load->model('questions_model');
                    $query = $this->questions_model->create_new_question();
                    if ($query) {
                        //$this->load->view('myTemplates/template', $data);
                        redirect('webUser_Controllers/question_controller/add_question');
                    }
                } else {
                    // return an error message
                    echo '<h1 class="error_head">Sorry, the question was not added, see errors & please try again!</h1>';
                    $this->add_question();
                }
            } else {
                // TODO return an error message
                echo '<h1 class="error_head">Sorry, the question was not added, see errors & please try again!</h1>';
                $this->add_question();
            }
        }
        if ($action == 'Save Survey') {
            $this->session->unset_userdata('surveyId');
            redirect('webUser_Controllers/survey_controller/all_user_surveys');
        }
    }

    // Callback function so that default text isn't entered by user on dropdown menu
    function not_default_text($text) {
        if ($text == 'null') {
            $this->form_validation->set_message('not_default_text', 'Please select a question type.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function sort_questions() {
        $this->load->model("questions_model");
        $this->questions_model->sort_insert();
    }

}