<?php

/* Daniel McKay & Ronan Reilly 2012 */

/**
 * This is the database code for the survey table
 */
class Questions_model extends CI_Model {

    function create_new_question() {
        // Get type of question
        $type = $this->input->post('type');
        $data = array(
            'question' => $this->input->post('question'),
            'type' => $type,
            'position' => $this->input->post('position'),
            'surveyId' => $this->input->post('surveyId')
        );
        // Insert question to db
        $insert = $this->db->insert('questions', $data);
        // Get question id
        $id = $this->db->insert_id();
        // This code adds the multi choice options for 3 choices
        if ($type == 'multi3') {
            $choices = array(
                'choice1' => $this->input->post('choice1'),
                'choice2' => $this->input->post('choice2'),
                'choice3' => $this->input->post('choice3'),
                'questionId' => $id
            );
            $insertChoices = $this->db->insert('poss_answers', $choices);
            if (!$insertChoices) {
                echo 'failed to insert multi 3 choices';
            }
        }
        // This code adds the multi choice options for 5 choices
        if ($type == 'multi5') {
            $choices = array(
                'choice1' => $this->input->post('choice1'),
                'choice2' => $this->input->post('choice2'),
                'choice3' => $this->input->post('choice3'),
                'choice4' => $this->input->post('choice4'),
                'choice5' => $this->input->post('choice5'),
                'questionId' => $id
            );
            $insertChoices = $this->db->insert('poss_answers', $choices);
            if (!$insertChoices) {
                echo 'failed to insert multi 5 choices';
            }
        }
        if ($type == 'rating') {
            $choices = array(
                'choice1' => "1",
                'choice2' => "2",
                'choice3' => "3",
                'choice4' => "4",
                'choice5' => "5",
                'questionId' => $id
            );
            $insertChoices = $this->db->insert('poss_answers', $choices);
            if (!$insertChoices) {
                echo 'failed to insert multi 5 choices';
            }
        }
        return $insert;
    }

    function get_questions_from_survey() {
        $id = $this->session->userdata('surveyId');
        if (empty($id)) {
            $id = $this->uri->segment(4);
        }
        $this->db->where('surveyId', $id);
        $this->db->order_by('position', 'asc');
        $query = $this->db->get('questions');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        else
            return null;
    }

    //This function deletes all the questions from a survey and also
    // any possible answers the question may have
    function delete_questions_answers() {
        // Get all the questions belonging to a survey
        $this->db->where('surveyId', $this->uri->segment(4));
        $query = $this->db->get('questions');
        if ($query->num_rows > 0) {
            // delete possible answers and actual answers for each question and then delete the question
            foreach ($query->result() as $row) {
                $this->db->where('questionId', $row->id);
                $this->db->delete('poss_answers');
                $this->db->where('questionId', $row->id);
                $this->db->delete('actual_answers');
                $this->db->where('id', $row->id);
                $this->db->delete('questions');
            }
            return;
        }
        else
            return null;
    }

    function sort_insert() {
        foreach ($this->input->post("sort") as $pos => $id) {
            $this->db->query(" UPDATE questions SET position = " . $pos . " WHERE id = " . $id . " ");
        }
    }

    function delete_associated_responses() {
        
    }

    function delete_associated_actual_answers() {
        
    }

    /** Data Visualisation * */
    /** Data Visualisation * */

    /** Data Visualisation * */
    function check_question_type() {
        $questionID = $this->uri->segment(4);
        $this->db->where('id', $questionID);
        $query = $this->db->get('questions');

        if ($query->num_rows == 1) {
            return $query->row();
        }
        else
            return null;
    }

    // This function gets the text for the
    // question whose responses are being viewed

    function get_question_text() {
        $id = $this->uri->segment(4);
        $this->db->where('id', $id);
        $query = $this->db->get('questions');
        if ($query->num_rows == 1) {
            return $query->row();
        }
        else
            return null;
    }

    function get_text_questions_answers() {
        $tempQuestionId = $this->uri->segment(4);

        $sql = "SELECT * FROM actual_answers WHERE questionId = ?";

        $q = $this->db->query($sql, $tempQuestionId);

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    function get_multi_choice_possible_answers() {
        $questionId = $this->uri->segment(4);

        $this->db->where('questionId', $questionId);
        $query = $this->db->get('poss_answers');

        if ($query->num_rows == 1) {
            return $query->row();
        }
        else
            return null;
    }

    function get_choice_one_answer_count() {
        $questionId = $this->uri->segment(4);
        $sql = "SELECT count( answerText ) as total
                FROM actual_answers a
                JOIN poss_answers p
                ON a.questionId = p.questionId
                WHERE a.answerText = p.choice1
                AND a.questionId = ?";
        $q = $this->db->query($sql, $questionId);

        if ($q->num_rows > 0) {
            return $q->row();
            //return $data;
        }
        else
            return null;
    }

    function get_choice_two_answer_count() {
        $questionId = $this->uri->segment(4);
        $sql = "SELECT count( a.answerText ) as total
                FROM actual_answers a
                JOIN poss_answers p
                ON a.questionId = p.questionId
                WHERE a.answerText = p.choice2
                AND a.questionId = ?";
        $q = $this->db->query($sql, $questionId);

        if ($q->num_rows > 0) {
            return $q->row();
            //return $data;
        }
        else
            return null;
    }

    function get_choice_three_answer_count() {
        $questionId = $this->uri->segment(4);
        $sql = "SELECT count( answerText ) as total
                FROM actual_answers a
                JOIN poss_answers p
                ON a.questionId = p.questionId
                WHERE a.answerText = p.choice3
                AND a.questionId = ?";
        $q = $this->db->query($sql, $questionId);

        if ($q->num_rows > 0) {
            return $q->row();
            //return $data;
        }
        else
            return null;
    }

    function get_choice_four_answer_count() {
        $questionId = $this->uri->segment(4);
        $sql = "SELECT count( answerText ) as total
                FROM actual_answers a
                JOIN poss_answers p
                ON a.questionId = p.questionId
                WHERE a.answerText = p.choice4
                AND a.questionId = ?";
        $q = $this->db->query($sql, $questionId);

        if ($q->num_rows > 0) {
            return $q->row();
            //return $data;
        }
        else
            return null;
    }

    function get_choice_five_answer_count() {
        $questionId = $this->uri->segment(4);
        $sql = "SELECT count( answerText ) as total
                FROM actual_answers a
                JOIN poss_answers p
                ON a.questionId = p.questionId
                WHERE a.answerText = p.choice5
                AND a.questionId = ?";
        $q = $this->db->query($sql, $questionId);

        if ($q->num_rows > 0) {
            return $q->row();
            //return $data;
        }
        else
            return null;
    }

    // Used for the Android xml data
    function get_questions_as_array() {
        $id = $this->uri->segment(4);
        $this->db->where('surveyId', $id);
        $this->db->order_by('position', 'asc');
        $query = $this->db->get('questions');
        if ($query->num_rows > 0) {
            $data = $query->result_array();
            return $data;
        }
        else
            return null;
    }

    function get_poss_answers($data) {
        $id = $data['questId'];
        $this->db->where('questionId', $id);
        $query = $this->db->get('poss_answers');
        if ($query->num_rows == 1) {
            $data = $query->row();
            return $data;
        }
        else
            return null;
    }

}