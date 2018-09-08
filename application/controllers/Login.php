<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Dragos
 * Date: 05/09/2018
 * Time: 22:38
 */
class Login extends  CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('LoginModel');
    }


    public function index()
    {
        if(isset($this->session->userdata['user_id'])) {
            redirect("/");
        }

        $this->load->template('login');
    }

    /**
     *
     * validate: validate login after input fields have met requirements
     *
     *
     */

    public function validate() {

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('username', "Username", 'trim|required|max_length[255]|is_valid_username');
        $this->form_validation->set_rules('password', "Password", 'trim|required|min_length[9]|max_length[255]|strip_tags');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('login');
        }

        $userData = $this->LoginModel->validate_login($this->input->post('username'), $this->input->post('password'));
        if (is_object($userData)) {
            // set session data
            $this->load->helper('session');
            session_init($userData);

            redirect('/');
        } else {
            $this->session->set_flashdata('error', 'Login incorrect.');
            redirect('login');
        }
    }

}