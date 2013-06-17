<?php

/* Daniel McKay & Ronan Reilly 2012 */

/**
 * This is the database code for the survey table
 */
class Surveys_model extends CI_Model {
    /* WEB USER FUNCTIONS */

    function create_new_survey() {
        $now = date("Y-m-d H:i:s");
        $data = array(
            'title' => $this->input->post('title'),
            'topic' => $this->input->post('topic'),
            'dateCreated' => $now,
            'userId' => $this->session->userdata('userID')
        );

        $insert = $this->db->insert('surveys', $data);
        return $insert;
    }

    function get_a_survey() {
        $id = $this->session->userdata('surveyId');
        if (empty($id)) {
            $id = $this->uri->segment(4);
        }
        $this->db->where('id', $id);
        $query = $this->db->get('surveys');

        if ($query->num_rows == 1) {
            return $query->row();
        }
        else
            return null;
    }

    function get_all_surveys() {
        $this->db->where('userId', $this->session->userdata('userID'));
        $query = $this->db->get('surveys');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        else
            return null;
    }

    function delete_single_survey() {
        $surveyId = $this->uri->segment(4);
        $this->db->where('id', $surveyId);
        $this->db->delete('surveys');
    }

    function update_single_survey($data) {
        $id = $data['id'];
        $this->db->where('id', $id);
        $this->db->update('surveys', $data);
        return;
    }

    function get_survey($data) {
        $id = $data['surveyId'];
        $this->db->where('id', $id);
        $query = $this->db->get('surveys');

        if ($query->num_rows == 1) {
            return $query->row();
        }
        else
            return null;
    }

    /* ADMINISTRATION FUNCTIONS */

    function get_all_surveys_on_system() {
        $q = $this->db->query('SELECT * FROM surveys');
        // if something is returned as in the data base is not empty
        if ($q->num_rows > 0) {
            foreach ($q->result() as $row) {
                // store results in the data array
                $data[] = $row;
            }
            // data is returned
            return $data;
        }
    }

    function admin_delete_associated_surveys() {
        $this->db->where('userId', $this->uri->segment(4));
        $query = $this->db->get('surveys');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $row) {
                $this->db->where('surveyId', $row->id);
                $q = $this->db->get('questions');
                foreach ($q->result() as $r) {
                    $this->db->where('questionId', $r->id);
                    $this->db->delete('poss_answers');
                    $this->db->where('questionId', $r->id);
                    $this->db->delete('actual_answers');
                    $this->db->where('id', $r->id);
                    $this->db->delete('questions');
                }
                $this->db->where('surveyId', $row->id);
                $this->db->delete('assignments');
                $this->db->where('id', $row->id);
                $this->db->delete('surveys');
            }
            return;
        }
        else
            return null;
    }

}