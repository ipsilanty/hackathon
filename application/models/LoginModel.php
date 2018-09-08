<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Dragos
 * Date: 06/09/2018
 * Time: 21:25
 */
class LoginModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * validate_login: check login data against database information
     *
     * @param string $identification the username to be validated
     * @param string $password the password to be validated
     * @return mixed
     *
     */

    public function validate_login($username = null, $password = null)
    {

        // first check for null values
        if (is_null($username) || is_null($password)) {
            return false;
        }

    // select hash from username
        $a = array('u.user_id', 'u.email', 'u.password', 'u.username', 'u.photo');

        $this->db->select($a);
        $this->db->from('user u');
        $this->db->where('username', $username);
        $q = $this->db->get();
        $this->db->limit(1);

        if($q->num_rows() == 1) {
            // we got some feedback from the database: user is found
            $row = $q->row();

            // check password against hash
            if (password_verify($password, $row->password)) {
                // Login successful.

                $this->db->trans_start();
                if (password_needs_rehash($row->password, PASSWORD_DEFAULT)) {
                    // Recalculate a new password_hash() and overwrite the one we stored previously
                    $hash = password_hash($row->password, PASSWORD_DEFAULT);
                    $this->db->where('user_id', $row->user_id)->update('user', array('password' => $hash));
                }
                $this->db->trans_complete();

                if ($this->db->trans_status() !== FALSE)
                {
                    // update last login datetime
                    $this->_update_last_login($row->user_id);
                    return $row;
                }

            }

        }

        return false;

    }

    /**
     *
     * _update_last_login: update the last time the member logged in
     *
     * @param int $user_id
     * @return boolean
     *
     */

    private function _update_last_login($user_id) {
        $this->db->set('last_login', 'NOW()', FALSE);
        $this->db->where('user_id', $user_id);
        return $this->db->affected_rows();
    }
}