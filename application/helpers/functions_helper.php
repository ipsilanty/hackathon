<?php

function getFreshContent() {
    $html = "";
    $newsSource = array(
        array(
            "title" => "BBC",
            "url" => "http://feeds.bbci.co.uk/news/rss.xml"
        )
    );
    function getFeed($url) {
        $html = "";
        $rss = simplexml_load_file($url);
        $count = 0;
        $html .= '<ul>';
        foreach($rss->channel->item as $item) {
            $count++;
            if($count > 1){
                break;
            }
            $html .= '<li><a href="'.htmlspecialchars($item->link).'">'.htmlspecialchars($item->title).'</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
    foreach($newsSource as $source) {
        $html .= '<h2>'.$source["title"].'</h2>';
        $html .= getFeed($source["url"]);
    }
    return $html;
}


function getFeed2($url) {
    $rss = simplexml_load_file($url);
    $count = 0;
    $plm = array();
    foreach($rss->channel->item as $item) {
        $count++;
        if($count > 1){
            break;
        }
        array_push($plm, $item);
    }
    return $plm;
}