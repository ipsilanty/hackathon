<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * is_valid_email: verify validity of e-mail addresses - is also used for AJAX calls
     *
     * @param string $email the e-mail address to be validated
     * @return boolean
     *
     */

    public function is_valid_email($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            $domain = explode("@", $email);
            if(checkdnsrr(array_pop($domain), "MX") != false) {
                return true;
            }
        }
        return false;
    }

    /**
     *
     * is_valid_password: verify whether password is strict enough
     *
     * @param string $password the password to be validated
     * @return boolean
     *
     */

    public function is_valid_password($password) {
        if (preg_match("/[\.\@\#\$\%\^\|\?\*\!\:\-\;\&\+\=\{\}\[\]]/", $password) && (strcspn($password, '0123456789') != strlen($password))) {
            return true;
        }
        return false;
    }

    /**
     *
     * is_valid_username: verify validity of username against regular expression: a-z, A-Z, 0-9, .,  _, - are allowed
     *
     * @param string $username the username to be validated
     * @return boolean
     *
     */

    public function is_valid_username($username) {
        if (preg_match("/^[a-zA-Z0-9._-]+$/", $username)) {
            return true;
        }
        return false;
    }

    /**
     *
     * is_db_cell_available: check for the existence of a unique field within a database table column
     *
     * @param string $value
     * @param string $info a string
     * @return boolean
     *
     */

    public function is_db_cell_available($value, $info) {

        list($table, $column) = explode('.', $info, 2);

        $this->CI->db->select($column);
        $this->CI->db->from($table);
        $this->CI->db->where($column, $value);
        $this->CI->db->limit(1);

        $query = $this->CI->db->get();

        if($query->num_rows() == 0) {
            return true;
        }
        return false;
    }
}