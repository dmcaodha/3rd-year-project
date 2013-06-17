<?php

/* Daniel McKay & Ronan Reilly 2012 */

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Mobile_user_model extends CI_Model {

    function validate() {
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('password', md5($this->input->post('password')));
        $query = $this->db->get('mobile_users');
        if ($query->num_rows == 1) {
            return $query->row();
        }
        else
            return null;
    }

    function get_user_assignments($data) {
        $id = $data['id'];
        $sql = "SELECT
                a.id as assignId,
                a.dateAssigned as dateAssigned,
                a.managerNotes as managerNotes,
                a.surveyId as surveyId
            FROM assignments a JOIN user_assignments u ON a.id = u.assignId
            WHERE u.mobId = ?
            ORDER BY a.dateAssigned ASC, a.id ASC";
        $q = $this->db->query($sql, $id);
        if ($q->num_rows > 0) {
            // Return data as an array, so that more variables can be added to it (instead of an object)
            $data = $q->result_array();
            return $data;
        }
        else
            return null;
    }

    // This function gets the parsed data from the Android XML
    // and saves it to the database
    function save_response($data) {
        $insert = array(
            'mobId' => $data['mobId'],
            'surveyId' => $data['surveyId']
        );
        $q = $this->db->insert('responses', $insert);
        return $q;
    }

    // This function saves the data from android surveys to the actual_answers table
    function save_actual_answers($data) {
        $insert = array(
            'answerText' => (string) $data['answerText'], // Needed to say it was a string because the single quotes weren't being appended
            'responseId' => $data['responseId'],
            'questionId' => $data['questionId']
        );
        $q = $this->db->insert('actual_answers', $insert);
        return $q;
    }

}
