<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Photos extends CI_Controller
{
    private $original_path;
    private $thumbs_path;

    function __construct() {
        parent::__construct();
        $this->load->model('PhotosModel');
    }

    public function index() {

        if(!isset($this->session->userdata['user_id'])) {
            redirect("login");
        }

        $data = array();

        //Get all photos
        $photos = $this->PhotosModel->get_photos();

        $data["photos"] = $photos;
        $this->load->template('photos', $data);
    }

    public function photo_upload() {

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
            $data = array(
                'status' => "error",
                'msg' => $this->upload->display_errors('', '')
            );
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

            $return_array = $this->PhotosModel->add_photo($image_data['file_name']);
            $data = array(
                'status' => "success",
                'photo' => $return_array["photo"]
            );

        }
        @unlink($_FILES[$file_element_name]);
        echo json_encode($data);
    }

    public function delete_photo() {

        $return_array = $this->PhotosModel->delete_photo($this->input->post('photoId'), $this->input->post('photo'));
        $data = array(
            'status' => $return_array["status"]
        );
        echo json_encode($data);
    }

}