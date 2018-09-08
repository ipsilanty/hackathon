<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Dragos
 * Date: 07/09/2018
 * Time: 18:31
 */
class Tasks extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('TasksModel');
    }

    public function index() {

        if(!isset($this->session->userdata['user_id'])) {
            redirect("login");
        }

        $data = array();

        //Get full list of tasks
        $tasks = $this->TasksModel->get_tasks();

        $data["tasks"] = $tasks;

        $this->load->template('tasks', $data);
    }

    public function add_task() {

        //Validate inputs
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('task', 'task', 'trim|required');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('tasks');
        }

        if($return_array = $this->TasksModel->add_task($this->input->post('task'))) {
            $this->session->set_flashdata('success', 'New task has been assigned');
            redirect('tasks');
        } else {
            $this->session->set_flashdata('error', 'Unable to assign this task.');
            redirect('tasks');
        }
    }

    public function update_task_status() {
        $data = array(
            'checked' => $this->input->post('status')
        );

        $return_array = $this->TasksModel->update_task($this->input->post('taskId'), $data);

        echo json_encode($return_array);
    }

    public function update_task() {
        $data = array(
            'task' => $this->input->post('task')
        );

        $return_array = $this->TasksModel->update_task($this->input->post('taskId'), $data);

        echo json_encode($return_array);
    }
}