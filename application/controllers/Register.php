<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Dragos
 * Date: 06/09/2018
 * Time: 14:08
 */
class Register extends CI_Controller
{

    private $original_path;
    private $thumbs_path;

    function __construct() {
        parent::__construct();

        $this->load->model("RegisterModel");
    }

    public function index()
    {
        $this->load->template('register');
    }

    /**
     *
     * add_user: insert a new user into the database after all input fields have met the requirements
     *
     *
     */

    public function add_user() {
        //Validate inputs
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|is_valid_username|is_db_cell_available[user.username]');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|is_valid_email|is_db_cell_available[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[9]|is_valid_password');
        $this->form_validation->set_rules('confirm_password', 'Password Confirm', 'trim|required|min_length[9]|matches[password]');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('register');
        }

        $image_name = "";
        if (!empty($_FILES['photo']['name'])) {
            //Start upload image
            $this->original_path = './assets/uploads/original';
            $this->thumbs_path   = './assets/uploads/thumbs';

            $this->load->library('image_lib');

            $file_element_name = 'photo';
            $config['upload_path'] = $this->original_path; //upload directory
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 1024 * 20; //20MB
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect('register');
            } else {
                $image_data = $this->upload->data();

                //your desired config for the resize() function
                $config['source_image'] = $image_data['full_path']; //path to the uploaded image
                $config['new_image'] = $this->thumbs_path."/thumb_".$image_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 280;
                $config['height'] = 280;
                $config['encrypt_name'] = TRUE;

                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $image_name =  $image_data['file_name'];

            }
            @unlink($_FILES[$file_element_name]);
        }

        if($return_array = $this->RegisterModel->add_user($this->input->post('username'), $this->input->post('email'), $this->input->post('password'),$image_name)) {
            // set session data
            $this->session->set_userdata($return_array);
            redirect('/');
        } else {
            $this->session->set_flashdata('error', 'Unable to register - please try again later.');
            redirect('register');
        }
    }

}