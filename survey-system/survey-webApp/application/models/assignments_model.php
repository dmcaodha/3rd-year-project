<?php

/* Daniel McKay & Ronan Reilly 2012 */

class Assignments_model extends CI_Model {

    function assign_to_table($data) {
        $now = date("Y-m-d H:i:s");
        $insert = array(
            'dateAssigned' => $now,
            'managerNotes' => $data['managerNotes'],
            'surveyId' => $data['surveyId']
        );
        $this->db->insert('assignments', $insert);
        return;
    }

    function assign_to_users($data) {
        $assign = $data['assign'];
        // Loop through array of selected checkboxes
        for ($i = 0; $i < count($assign); $i++) {
            $insert = array(
                'mobId' => $assign[$i],
                'assignId' => $data['assignId'],
            );
            $this->db->insert('user_assignments', $insert);
        }
        return;
    }

    function get_assignments_from_survey() {
        $id = $this->session->userdata('surveyId');
        if (empty($id)) {
            $id = $this->uri->segment(4);
        }
        $this->db->where('surveyId', $id);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('assignments');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        else
            return null;
    }

    function delete_single_assignment($data) {
        $id = $data['assignmentId'];
        $this->db->where('id', $id);
        $q = $this->db->get('assignments');
        if ($q->num_rows > 0) {
            //Get the surveyId to pass back to the controller
            $row = $q->row();
            $surveyId = $row->surveyId;
            //Delete assignments
            $this->db->where('id', $id);
            $this->db->delete('assignments');
            // Delete user assignments if any
            $this->db->where('assignId', $id);
            $this->db->delete('user_assignments');
            // Return the surveyId to controller for redirect
            return $surveyId;
        }
        else
            return null;
    }

    function delete_associated_assignments() {
        // Get all the assignments belonging to a survey
        $this->db->where('surveyId', $this->uri->segment(4));
        $query = $this->db->get('assignments');
        if ($query->num_rows > 0) {
            // delete user assignments for each assignment, then delete the assignment
            foreach ($query->result() as $row) {
                $this->db->where('assignId', $row->id);
                $this->db->delete('user_assignments');
                $this->db->where('id', $row->id);
                $this->db->delete('assignments');
            }
            return;
        }
        else
            return null;
    }

    function delete_associated_responses() {
        $surveyId = $this->uri->segment(4);
        $this->db->query('DELETE FROM responses WHERE surveyId = ' . $surveyId);
    }

    function delete_associated_user_assignments() {
        // $id = $this->uri->segment(4);
        // $this->db->query('DELETE FROM assignments WHERE surveyId = '. $id);
    }

    /** When Deleting Mobile User * */
    /** When Deleting Mobile User * */

    /** When Deleting Mobile User * */
    function get_assign_id() {
        $id = $this->uri->segment(4);
        $this->db->query('SELECT assignId FROM user_assignments WHERE mobId = ' . $id);
    }

    function delete_user_assignments() {
        $id = $this->uri->segment(4);
        $this->db->query('DELETE FROM user_assignments WHERE mobId = ' . $id);
    }

    /** Viewing Whos Assiged * */
    /** Viewing Whos Assiged * */

    /** Viewing Whos Assiged * */
    function get_date_of_assignment() {
        $assignmentID = $this->uri->segment(4);

        $this->db->where('id', $assignmentID);
        $query = $this->db->get('assignments');

        if ($query->num_rows == 1) {
            return $query->row();
        }
        else
            return null;
    }

    function get_no_of_assigned_users() {
        $this->db->like('assignID', $this->uri->segment(4));
        $this->db->from('user_assignments');
        $temp = $this->db->count_all_results();

        return $temp;
    }

    function get_assigned_users() {
        $assignmentID = $this->uri->segment(4);
        $sql = ('SELECT m.userName as userName, m.id as id FROM mobile_users m
                  JOIN user_assignments u ON m.id = u.mobId
                  WHERE u.assignId = ?');
        $q = $this->db->query($sql, $assignmentID);

        if ($q->num_rows > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }

            return $data;
        }
        else
            return null;
    }

    function delete_this_mob_user_from_assignment() {
        $id = $this->uri->segment(4);
        $this->db->query('DELETE FROM user_assignments WHERE mobId = ' . $id);
    }

    /* ADMIN GET ALL ASSIGNMENTS */

    function get_all_assignments_on_system() {
        $q = $this->db->query('SELECT * FROM assignments');
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

    function admin_delete_this_assignment() {
        $id = $this->uri->segment(4);
        $this->db->query('DELETE FROM assignments WHERE id = ' . $id);
    }

    function admin_delete_associated_user_assignments() {
        $id = $this->uri->segment(4);
        $this->db->query('DELETE FROM user_assignments WHERE assignId = ' . $id);
    }

}
