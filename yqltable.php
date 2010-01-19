<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>YQL Execute Open Data Table - test</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
  <style type="text/css">
   body{font-family:verdana,sans-serif;font-size:12px;}
   div.feed{float:left;width:20%;height:200px;overflow:auto;}
   p{clear:both;font-size:20px;margin:20px 0;color:#363;position:absolute;top:.5em;right:1em;}
   #nav {clear:both;margin:1em 0;list-style:none;padding:.5em;background: #CEFFB7;}
   #nav li{display:inline;padding-right:1em;}
   a{color:#000;}
   h1{background:#CEFFB7;padding:.5em;}
  </style>
</head>
<body>
<h1>YQL Execute - test</h1>
<?php

    $oldtime = microtime(true);

    $rss = array('http://www.yqlblog.net/blog/feed/',
                 'http://www.quirksmode.org/blog/index.xml',
                 'http://feeds.developer.yahoo.net/YDNBlog',
                 'http://www.planet-php.org/rss/',
                 'http://planet.python.org/rss20.xml');

    $endpoint = 'http://query.yahooapis.com/v1/public/yql?q=';

    $yql = "use 'http://isithackday.com/yqlspeed/rss.multi.list.xml' as m;select * from m where feeds=\"'".implode("','",$rss)."'\" and html='true' and compact='true'";

    $query = $endpoint. urlencode($yql). '&format=xml&diagnostics=false';

    $result = get($query);

    $result = preg_replace('/.*<results><div/','<results><div',$result);

    $result = preg_replace('/div><\/results>.*/','div>',$result);

    $result = preg_replace("/<\?xml version=\"1\.0\" encoding=\"UTF-8\"\?>/",'',$result);

    $result = preg_replace("/<!--.*-->/",'',$result);

    echo$result;

    echo'<p>Time spent: <strong>'.(microtime(true) - $oldtime).'</strong></p>';

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
  <li><a href="simplecurl.php">Using simple cURL</a></li>
  <li><a href="multicurl.php">Using multi cURL</a></li>
  <li><a href="yqlcurl.php">Using YQL</a></li>
  <li><strong>Using YQL executable</strong></li>
</ul>
</body>
</html>