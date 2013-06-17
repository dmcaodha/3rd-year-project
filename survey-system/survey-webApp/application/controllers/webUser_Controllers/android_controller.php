<?php

/* Daniel McKay & Ronan Reilly 2012 */

class Android_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //$this->output->enable_profiler(TRUE);
    }

    function load_assignment_xml() {
        $data['userName'] = $this->input->post('username');
        $data['password'] = $this->input->post('password');
        $this->load->model('mobile_user_model');
        $user = $this->mobile_user_model->validate($data);
        if ($user != null) { // if such user exists
            $data['id'] = $user->id;
            $query = $this->mobile_user_model->get_user_assignments($data);
            // data from above query will be in an array (see Model fn.)
            if ($query != null) {
                $this->load->model('surveys_model');
                foreach ($query as $assignment) {
                    $data['surveyId'] = $assignment['surveyId'];
                    // Get topic & title of survey
                    $q = $this->surveys_model->get_survey($data);
                    // Add the variables to get_user_assignments query array
                    $assignment['title'] = $q->title;
                    $assignment['topic'] = $q->topic;
                    // Save the assignment details in a multidimensional array to pass to the view.
                    $data['assignments'][] = $assignment;
                }
                $this->load->view('android_views/assignment_xml', $data);
            } else {
                $data['error'] = "error doing query";
                $this->load->view('android_views/error_xml', $data);
            }
        } else {
            $data['error'] = "validation error";
            $this->load->view('android_views/error_xml', $data);
        }
    }

    // This function gets the questions from the survey as an array. It then
    // gets the question's possible answers (if it has any) and creates a 2d
    // array from this data.

    function load_questions_xml() {
        $this->load->model('questions_model');
        $query = $this->questions_model->get_questions_as_array();
        if ($query != null) {
            // Save a ref to the surveyId for the view
            $data['surveyId'] = $query[0]['surveyId'];
            // Loop through each question
            foreach ($query as $question) {
                // If the question is multi-choice do query & add the first three choices
                if ($question['type'] == "multi3" || $question['type'] == "multi5") {
                    $data['questId'] = $question['id'];
                    $q = $this->questions_model->get_poss_answers($data);
                    $question['choice1'] = $q->choice1;
                    $question['choice2'] = $q->choice2;
                    $question['choice3'] = $q->choice3;
                }
                // If it is 5 option multi choice, add the final 2 choices
                if ($question['type'] == "multi5") {
                    $question['choice4'] = $q->choice4;
                    $question['choice5'] = $q->choice5;
                }
                // Save data as 2d array
                $data['questions'][] = $question;
            }
            $this->load->view('android_views/questions_xml', $data);
        } else {
            $data['error'] = "error doing query";
            $this->load->view('android_views/error_xml', $data);
        }
    }

    // This function parses the survey results xml string from the Andoid app

    function save_survey_xml() {

        $xmlstr = file_get_contents('php://input');
        $xml = new SimpleXMLElement($xmlstr);
        $data['mobId'] = $xml['id'];
        $data['surveyId'] = $xml->survey['id'];
        $this->load->model('mobile_user_model');
        $query = $this->mobile_user_model->save_response($data);
        if ($query) {
            $data['responseId'] = $this->db->insert_id();
            foreach ($xml->survey->questions->question as $question) {
                //$data['questions'][] = $question;
                $data['questionId'] = $question['id'];
                $data['answerText'] = $question->answer;
                $q = $this->mobile_user_model->save_actual_answers($data);
                if (!$q) {
                    $data['error'] = "Error Inserting Answer";
                    $this->load->view('android_views/error_xml', $data);
                }
            }
            $this->load->view('android_views/ok_xml', $data);
        } else {
            $data['error'] = "Error Inserting Response";
            $this->load->view('android_views/error_xml', $data);
        }
    }

}