<?php
/* Daniel McKay & Ronan Reilly 2012 */

class Users_model extends CI_Model {
    /* LOGIN */

    function validate() {
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('password', md5($this->input->post('password')));
        $query = $this->db->get('site_users');

        if ($query->num_rows == 1) {
            return $query->row();
        }
        else
            return null;
    }

    function create_user() {
        $new_user_insert_data = array(
            'firstName' => $this->input->post('firstName'),
            'lastName' => $this->input->post('lastName'),
            'email' => $this->input->post('email'),
            'userName' => $this->input->post('userName'),
            'accountType' => ('web_user'),
            'password' => md5($this->input->post('password'))
        );

        $insert = $this->db->insert('site_users', $new_user_insert_data);
        return $insert;
    }

    function check_user_type() {
        $query = $this->db->query('SELECT accountType FROM site_users LIMIT 1');
        $row = $query->row();
        echo $row->accountType;
    }

    /* WEB USER FUNCTIONS */

    /* ADD A MOBILE USER ACCOUNT */

    function create_this_mobile_user() {
        $new_user_insert_data = array(
            'userName' => $this->input->post('userName'),
            'password' => md5($this->input->post('password')),
            'manager_id' => $this->session->userdata('userID')
        );

        $insert = $this->db->insert('mobile_users', $new_user_insert_data);
        return $insert;
    }

    /* FETCH ALL RELEVANT MOBILE USER ACCOUNT */

    function get_relevant_mobile_accounts() {
        // selecting where the id is given through a form usually, and the author is also
        // given....
        $sql = "SELECT id, userName, password FROM mobile_users WHERE manager_id = ?";
        // Simulates an id number given from a form for eaxmple
        // except it is hardcoded in here and called on the database.
        $q = $this->db->query($sql, array($this->session->userdata('userID')));

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    /* EDIT SPECIFIC MOBILE USER ACCOUNT */

    function edit_this_mobile_account() {
        $update_account_data = array(
            'password' => md5($this->input->post('password'))
        );

        $this->db->where('id', $this->session->userdata('currentMobAccount'));
        $insert = $this->db->update('mobile_users', $update_account_data);

        return $insert;
    }

    /* DELETE SPECIFIC MOBILE USER ACCOUNT */

    function delete_this_mobile_account() {
        $this->db->where('id', $this->uri->segment(4));
        $this->db->delete('mobile_users');
    }

    /* ADMINISTRATION FUNCTIONS */

    /* FETCH ALL USER ACCOUNTS */

    function get_all_web_user_records() {
        $q = $this->db->query('SELECT * FROM site_users');
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

    /* CREATE WEB USER */

    function admin_create_new_user() {
        $new_user_insert_data = array(
            'firstName' => $this->input->post('firstName'),
            'lastName' => $this->input->post('lastName'),
            'email' => $this->input->post('email'),
            'userName' => $this->input->post('userName'),
            'accountType' => ('web_user'),
            'password' => md5($this->input->post('password'))
        );

        $insert = $this->db->insert('site_users', $new_user_insert_data);
        return $insert;
    }

    /* UPDATE ACCOUNT */

    function admin_update_account() {
        $update_account_data = array(
            'firstName' => $this->input->post('firstName'),
            'lastName' => $this->input->post('lastName'),
            'email' => $this->input->post('email'),
            'userName' => $this->input->post('userName'),
            'accountType' => ('web_user'),
            'password' => md5($this->input->post('password'))
        );

        $this->db->where('id', $this->session->userdata('currentWebAccount'));
        $insert = $this->db->update('site_users', $update_account_data);
        return $insert;
    }

    /* DELETE WEB ACCOUNT */

    function admin_delete_account() {
        $this->db->where('id', $this->uri->segment(4));
        $this->db->delete('site_users');
    }

    function admin_delete_associated_mobile_accounts() {
        $this->db->where('manager_id', $this->uri->segment(4));
        $query = $this->db->get('mobile_users');
        if ($query->num_rows > 0) {
            // rows from mob users
            foreach ($query->result() as $row) {
                $this->db->where('id', $row->id);
                $q = $this->db->get('user_assignments');
                foreach ($q->result() as $r) {
                    $this->db->where('id', $r->assignId);
                    $this->db->delete('assignments');
                    $this->db->where('id', $r->id);
                    $this->db->delete('user_assignments');
                }
                $this->db->where('id', $row->id);
                $this->db->delete('mobile_users');
            }
            return;
        }
        else
            return null;

        $this->db->delete('mobile_users');
    }

    /* FETCH ALL MOBILE USER ACCOUNTS */

    function get_all_mobile_user_records() {
        $q = $this->db->query('SELECT * FROM mobile_users');
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

}

