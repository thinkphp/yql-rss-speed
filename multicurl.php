<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>cURL test - multicurl</title>
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
<h1>cURL test - multicurl</h1>
<?php

    $oldtime = microtime(true);

    $rss = array('http://www.yqlblog.net/blog/feed/',
                 'http://www.quirksmode.org/blog/index.xml',
                 'http://feeds.developer.yahoo.net/YDNBlog',
                 'http://www.planet-php.org/rss/',
                 'http://planet.python.org/rss20.xml');

     $result = multiRequest($rss);

     display($result);
 
     echo'<p>Time spent: <strong>'.(microtime(true) - $oldtime).'</strong></p>';

     function multiRequest($data, $options = array()) {

         //array of curl handles
         $curly = array();

         //data to be returned
         $result = array();

         //multihandle
         $mh = curl_multi_init();

         //loop through $data and create curl handles
         //and add them to the multi-handle
         foreach($data as $id=>$d) {

              $curly[$id] = curl_init();

              $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;

              curl_setopt($curly[$id], CURLOPT_URL, $url); 

              curl_setopt($curly[$id], CURLOPT_HEADER, 0); 

              curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1); 

              //post?

              if(is_array($d)) {

                    if(!empty($d['post'])) {

                          curl_setopt($curly[$id], CURLOPT_POST, 1);  

                          curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);  

                    }//endif

              }//endif

             //extra options?
             if(!empty($options)){

                  curl_setopt_array($curly[$id],$options);
              }        

              curl_multi_add_handle($mh, $curly[$id]);

         }//end foreach



         //execute the handles
         $running = null;
         do{

            curl_multi_exec($mh, $running);

           } while($running > 0);

         foreach($curly as $id=>$c) {

             $result[$id] = curl_multi_getcontent($c);

             curl_multi_remove_handle($mh, $c);  
         }

         curl_multi_close($mh);

       return$result;  
                    
     }//end function

     function display($data) {

       foreach($data as $d) {

          $obj = simplexml_load_string($d);

          echo'<div><h2><a href="'.$obj->channel->link.'">'.$obj->channel->title.'</a></h2>';

          echo'<ul>';

             foreach($obj->channel->item as $i) {

                 echo'<li><a href="'.$i->link.'">'.$i->title.'</a></li>';   

             }//endforeach
     
          echo'</ul></div>';

        }//endforeach
                 
     }//end function

?>


<ul id="nav">
  <li><a href="simplecurl.php">Using simple cURL</a></li>
  <li><strong>Using multi cURL</strong></li>
  <li><a href="yqlcurl.php">Using YQL</a></li>
  <li><a href="yqltable.php">Using YQL executable</a></li>
</ul>
</body>
</html>