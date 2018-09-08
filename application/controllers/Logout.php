<?php

/**
 * Created by PhpStorm.
 * User: Dragos
 * Date: 06/09/2018
 * Time: 22:33
 */
class Logout extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('session');
        unset_session_data();
        redirect('login');
    }

    public function index() {}

}