<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Dragos
 * Date: 07/09/2018
 * Time: 23:25
 */
class Sports extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('SportModel');
    }

    public function index() {

        if(!isset($this->session->userdata['user_id'])) {
            redirect("login");
        }

        $data = array();

        $this->load->template('sports', $data);
    }

    public function get_teams() {

        $return_array = $this->SportModel->get_teams($this->input->post('team'));

        echo json_encode($return_array);
    }
}