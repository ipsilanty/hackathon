<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Dragos
 * Date: 06/09/2018
 * Time: 14:10
 */
class RegisterModel extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    /**
     *
     * add_user
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $photo
     * @return mixed
     *
     */

    public function add_user($username, $email, $password, $photo) {

        $data = array(
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email,
            'photo' => $photo
        );

        $this->db->trans_start();

        $this->db->set('date_registered', 'NOW()', FALSE);
        $this->db->set('last_login', 'NOW()', FALSE);
        $this->db->insert('user', $data);

        $last_id = $this->db->insert_id();

        $this->db->trans_complete();

        if (!$this->db->trans_status() === false)
        {
            return array('user_id' => $last_id, 'email' => $email, 'username' => $username, 'photo' => $photo);
        }

        return false;
    }
}