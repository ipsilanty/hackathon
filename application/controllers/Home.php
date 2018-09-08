<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Dragos
 * Date: 05/09/2018
 * Time: 20:31
 */
class Home extends CI_Controller
{

    function __construct() {
        parent::__construct();
    }

    public function index() {

        if(!isset($this->session->userdata['user_id'])) {
            redirect("login");
        }


        $data = array();

        //Default Weather
        $request = 'http://api.openweathermap.org/data/2.5/weather?APPID=d0a10211ea3d36b0a6423a104782130e&q=London&units=metric';
        $response  = file_get_contents($request);
        $json  = json_decode($response);

        //News RSS Feed
        $newsoutput = new SimpleXMLElement('http://feeds.bbci.co.uk/news/rss.xml', LIBXML_NOCDATA, true);
        $newsoutput = json_decode(json_encode($newsoutput), TRUE);

        $news = array();
        $count = 0;
        foreach ($newsoutput['channel']['item'] as $item) {
            $count++;
            if($count > 1){
                break;
            }
            $news["title"] =  $item["title"];
            $news["description"] =  $item["description"];

        }

        //Get sports
        $this->load->model('SportModel');
        $team = $this->SportModel->get_home_v();

        //Get photos
        $this->load->model('PhotosModel');
        $photos = $this->PhotosModel->get_photos(4);

        //Get tasks
        $this->load->model('TasksModel');
        $tasks = $this->TasksModel->get_tasks(3);

        //Get clothes
        $this->load->model('ClothesModel');
        $clothes = $this->ClothesModel->get_count();
        $item = array();
        foreach($clothes as $cl) {
            array_push($item, $cl->clothe);
        }
        $values = array_count_values($item);

        $data["weather"] = $json;
        $data["news"] = $news;
        $data["team"] = $team;
        $data["photos"] = $photos;
        $data["tasks"] = $tasks;
        $data["values"] = $values;

        $this->load->template('home', $data);

    }

    public function get_location() {

        $request = 'http://api.openweathermap.org/data/2.5/weather?APPID=d0a10211ea3d36b0a6423a104782130e&units=metric&lat='.$this->input->post('lat').'&lon='.$this->input->post('long');
        $response  = file_get_contents($request);
        echo $response;
    }

}