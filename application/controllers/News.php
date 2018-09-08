<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Dragos
 * Date: 07/09/2018
 * Time: 11:19
 */
class News extends CI_Controller
{
    function __construct() {
        parent::__construct();
    }

    public function index() {

        if(!isset($this->session->userdata['user_id'])) {
            redirect("login");
        }

        $data = array();

        //News RSS Feed
        $news = array();
        $count = 0;
        $xml = simplexml_load_file('http://feeds.bbci.co.uk/news/rss.xml');
        foreach($xml->channel->item as $item) {
            //Get first record
            $count++;
            if($count > 1){
                break;
            }

            $title = $item->title;
            $description = $item->description;
            $link = $item->link;

            $news["title"] =  $title;
            $news["description"] =  $description;
            $news["link"] =  $link;
            $media = $item->children('media', 'http://search.yahoo.com/mrss/');
            $count2 = 0;
            foreach($media->thumbnail as $thumb) {
                //Get first record
                $count2++;
                if($count2 > 1){
                    break;
                }
                $news["image"] =  $thumb->attributes()->url;
            }
        }

        $data["news"] = $news;
        $this->load->template('news', $data);
    }
}