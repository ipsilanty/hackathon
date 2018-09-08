<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: Dragos
 * Date: 07/09/2018
 * Time: 18:37
 */
class TasksModel extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    public function get_tasks($limit = null) {

        $this->db->select("*");
        $this->db->from('tasks');
        $this->db->order_by('id ASC');
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

    public function add_task($task) {
        $data = array(
            'task' => $task
        );

        $this->db->trans_start();
        $this->db->insert('tasks', $data);
        $last_id = $this->db->insert_id();
        $this->db->trans_complete();

        if (!$this->db->trans_status() === false)
        {
            return array('taskId' => $last_id);
        }

        return false;
    }

    public function update_task($taskId, $data) {
        if($data) {
            foreach($data as $key => $val ) {
                $this->db->set("`$key`", "'$val'", FALSE);
            }
            $this->db->where('id', $taskId);
            $this->db->update('tasks');
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

}