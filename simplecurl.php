<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Simple cURL test</title>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <style type="text/css">
  body{font-family:verdana,sans-serif;font-size:12px;}
  div{float:left;width:20%;height:200px;overflow:auto;}
  p{clear:both;font-size:20px;margin:20px 0;color:#363;position:absolute;top:.5em;right:1em;}
  #nav {clear:both;margin:1em 0;list-style:none;padding:.5em;background:#CEFFB7;}
  #nav li{display:inline;padding-right:1em;}
  h1{background:#CEFFB7;padding:.5em;}
  a{color:#000;}
  </style>
</head>
<body>
<h1>Simple cURL test</h1>
<?php

    $oldtime = microtime(true);

    $content = array();

    $url = 'http://www.yqlblog.net/blog/feed/';

    $content[] = get($url);

    $url = 'http://www.quirksmode.org/blog/index.xml';

    $content[] = get($url);

    $url = 'http://feeds.developer.yahoo.net/YDNBlog';

    $content[] = get($url);

    $url = 'http://www.planet-php.org/rss/';

    $content[] = get($url);

    $url = 'http://planet.python.org/rss20.xml';

    $content[] = get($url);

    display($content);
 
    echo'<p>Time spent: <strong>'.(microtime(true) - $oldtime).'</strong></p>';

function display($data) {

    foreach($data as $d) {

        $obj = simplexml_load_string($d);

        echo'<div><h2><a href="'.$obj->channel->link.'">'.$obj->channel->title.'</a></h2>';

        echo'<ul>';

             foreach($obj->channel->item as $i) {

                 echo'<li><a href="'.$i->link.'">'.$i->title.'</a></li>';   
             }

        echo'</ul></div>';
    } 

}

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
  <li><strong>Using simple cURL</strong></li>
  <li><a href="multicurl.php">Using multi cURL</a></li>
  <li><a href="yqlcurl.php">Using YQL</a></li>
  <li><a href="yqltable.php">Using YQL executable</a></li>
</ul>
</body>
</html>