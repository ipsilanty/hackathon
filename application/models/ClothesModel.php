<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Dragos
 * Date: 07/09/2018
 * Time: 22:57
 */
class ClothesModel extends CI_Model
{
        public function __construct() {
        parent::__construct();
    }

    public function get_count() {

        $this->db->select("clothe");
        $this->db->from('clothes');
        //$this->db->where('clothe', $clothe);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}