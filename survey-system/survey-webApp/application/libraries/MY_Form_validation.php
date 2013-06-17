<?php

/* Daniel McKay & Ronan Reilly 2012 */

class MY_Form_validation extends CI_Form_validation {

    function strong_pass($value, $params) {
        $this->CI->form_validation->set_message('strong_pass', 'The %s is not strong enough!, must contain characters from A-z and at least one number from  0-9.');

        $score = 0;

        if (preg_match('!\d!', $value)) {
            $score++;
        }
        if (preg_match('![A-z]!', $value)) {
            $score++;
            $score++;
        }
        /* if(preg_match('![\W]!', $value)){
          $score ++;
          } */
        if (strlen($value) >= 8) {
            $score++;
        }

        if ($score < $params) {
            return false;
        }
        return true;
    }

    function check_web_userName($str, $field) {
        $CI = & get_instance();
        list($table, $column) = explode('.', $field, 2);

        $CI->form_validation->set_message('check_web_userName', 'The %s that you requested is already in use, please try another.');

        $query = $CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $column = '$str'");
        $row = $query->row();
        return ($row->dupe > 0) ? FALSE : TRUE;
    }

    function check_mobile_userName($str, $field) {
        $CI = & get_instance();
        list($table, $column) = explode('.', $field, 2);

        $CI->form_validation->set_message('check_mobile_userName', 'The %s that you requested is already in use, please try another.');

        $query = $CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $column = '$str'");
        $row = $query->row();
        return ($row->dupe > 0) ? FALSE : TRUE;
    }

}
