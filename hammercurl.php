<?php

header('content-type:text/javascript');

echo'datain({';

$oldtime = microtime(true);

$url = 'http://code.flickr.com/blog/feed/rss/';

$content[] = get($url);

$url = 'http://feeds.delicious.com/v2/rss/codepo8?count=15';

$content[] = get($url);

$url = 'http://www.stevesouders.com/blog/feed/rss';

$content[] = get($url);

$url = 'http://www.yqlblog.net/blog/feed/';

$content[] = get($url);

$url = 'http://www.quirksmode.org/blog/index.xml';

$content[] = get($url);

$newtime = microtime(true) - $oldtime; 

echo'"single":"'.$newtime.'",';

   $rss = array('http://www.yqlblog.net/blog/feed/',
                 'http://www.quirksmode.org/blog/index.xml',
                 'http://feeds.developer.yahoo.net/YDNBlog',
                 'http://www.planet-php.org/rss/',
                 'http://planet.python.org/rss20.xml');

    $endpoint = 'http://query.yahooapis.com/v1/public/yql?q=';

    $query = 'select channel.title,channel.link,channel.item.title,channel.item.link from xml where url in ("'.join('","',$rss).'")';

    $url = $endpoint. urlencode($query). '&format=xml';

    $result = get($url);

$newtime = microtime(true) - $oldtime; 

echo'"yql":"'.$newtime.'",';

$r = multiRequest($rss);

$newtime = microtime(true) - $oldtime; 

echo'"multi":"'.$newtime.'"';    

echo'});';

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


?>