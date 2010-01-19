<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>YQL cURL test</title>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <style type="text/css">
  body{font-family:verdana,sans-serif;font-size:12px;}
  div{float:left;width:20%;height:200px;overflow:auto;}
  p{clear:both;font-size:20px;margin:20px 0;color:#363;position:absolute;top:.5em;right:1em;}
  #nav {clear:both;margin:1em 0;list-style:none;padding:.5em;background:#ccc;}
  #nav li{display:inline;padding-right:1em;}
  h1{background:#ccc;padding:.5em;}
  a{color:#000;}
  </style>
</head>
<body>
<h1>YQL cURL test</h1>
<?php

    $oldtime = microtime(true);

    $rss = array('http://www.yqlblog.net/blog/feed/',
                 'http://www.quirksmode.org/blog/index.xml',
                 'http://feeds.developer.yahoo.net/YDNBlog',
                 'http://www.planet-php.org/rss/',
                 'http://planet.python.org/rss20.xml');

    $endpoint = 'http://query.yahooapis.com/v1/public/yql?q=';

    $query = 'select channel.title,channel.link,channel.item.title,channel.item.link from xml where url in ("'.join('","',$rss).'")';

    $url = $endpoint. urlencode($query). '&format=xml';

    $result = get($url);

    display($result); 

    echo'<p>Time spent: <strong>'.(microtime(true) - $oldtime).'</strong></p>';

    function display($data) {
 
          $data = simplexml_load_string($data);

          $sets = $data->results->rss;

          $all = sizeof($sets);

               for($i=0;$i<$all;$i++) {

                    $r = $sets[$i];

                    $title = $r->channel->title.'';

                    if($title != $oldtitle) {
  
                          echo'<div><h2><a href="'.($r->channel->link).'">'.($r->channel->title).'</a></h2><ul>'; 
                    }

                    echo'<li><a href="'.($r->channel->item->link).'">'.($r->channel->item->title).'</a></li>'; 

                    if($title != $sets[$i+1]->channel->title.'') {

                          echo'</ul></div>'; 
                    }

                   $oldtitle = $r->channel->title; 

               }//end for

    }//end function

    function get($url) {

        $ch = curl_init(); 

        curl_setopt($ch,CURLOPT_URL,$url); 

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);

        $data = curl_exec($ch);

        curl_close($ch);

        if(empty($data)) {

          return'An error has occured. Please Try Again.'; 
  
        } else {

          return$data; 
        }

     }//end function

?>


<ul id="nav">
  <li><a href="simplecurl.php">Using simple cURL</strong></li>
  <li><a href="multicurl.php">Using multi cURL</a></li>
  <li><strong>Using YQL</strong></li>
  <li><a href="yqltable.php">Using YQL executable</a></li>
</ul>
</body>
</html>