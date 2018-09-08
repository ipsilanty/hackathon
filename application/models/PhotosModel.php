<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PhotosModel extends CI_Model
{
    private $original_path;
    private $thumbs_path;

    public function __construct() {
        parent::__construct();
    }

    public function get_photos($limit = null) {

        $this->db->select("*");
        $this->db->from('photos');
        $this->db->order_by('id DESC');
        if($limit) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function add_photo($photo) {
        $data = array(
            'photo' => $photo
        );

        $this->db->trans_start();
        $this->db->insert('photos', $data);
        $this->db->trans_complete();

        if (!$this->db->trans_status() === false)
        {
            return array('photo' => $photo);
        }

        return false;
    }

    public function delete_photo($id, $photo) {

        $this->original_path = './assets/uploads/original/'.$photo;
        $this->thumbs_path   = './assets/uploads/thumbs/thumb_'.$photo;

        if(file_exists($this->original_path)) {
            //Delete photo from directory
            unlink($this->original_path);
            unlink($this->thumbs_path);

            //Delete photo from database
            $this->db->trans_start();
            $this->db->where('id', $id)->delete('photos');
            $this->db->trans_complete();

            if (!$this->db->trans_status() === false) {
                return array('status' => 'success');
            } else {
                return array('status' => 'error');
            }
        } else {
            return array('status' => 'error');
        }
    }
}