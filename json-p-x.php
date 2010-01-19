<?php

    $oldtime = microtime(true);

    $url = "http://query.yahooapis.com/v1/public/yql?q=use%20'http%3A%2F%2Fthinkphp.ro%2Fapps%2FYQL%2Fyql-rss-speed%2Frss.multi.list.xml'%20as%20rss%3B%20select%20*%20from%20rss%20where%20feeds%3D%22'http%3A%2F%2Fwww.yqlblog.net%2Fblog%2Ffeed%2F'%2C'http%3A%2F%2Fwww.quirksmode.org%2Fblog%2Findex.xml'%2C'http%3A%2F%2Ffeeds.developer.yahoo.net%2FYDNBlog'%2C'http%3A%2F%2Fwww.planet-php.org%2Frss%2F'%2C'http%3A%2F%2Fplanet.python.org%2Frss20.xml'%22%20and%20html%3D%22true%22%20and%20compact%3D%22true%22&format=xml&diagnostics=false";

    $result = get($url);

    $result = preg_replace('/.*<results><div/','<div',$result);

    $result = preg_replace('/div><\/results>.*/','div>',$result);

    $result = preg_replace("/<\?xml version=\"1\.0\" encoding=\"UTF-8\"\?>/",'',$result);

    $result = preg_replace("/<!--.*-->/",'',$result);
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>RSS Feeds PHP with multi.list.rss</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
   <style type="text/css">
   body{font-family:verdana,sans-serif;font-size:12px;}
   div.feed{float:left;width:20%;height:200px;overflow:auto;}
   p{clear:both;font-size:20px;margin:20px 0;color:#363;position:absolute;top:.5em;right:1em;}
   #nav {clear:both;margin:1em 0;list-style:none;padding:.5em;background: #CEFFB7;}
   #nav li{display:inline;padding-right:1em;}
   a{color:#000;}
   h1{background:#CEFFB7;padding:.5em;}
   #ft{text-align: right;color: #ccc;font-family: arial}
   #ft a{color: #ccc}
   #loading{font-size: 300%;font-weight:bold}
   #timespent{font-size: 200%;font-weight:bold;color: #ccc}
   </style>
</head>
<body>
<div id="doc2" class="yui-t7">
   <div id="hd" role="banner"><h1>RSS feeds with JSON-P-X PHP and rss.multi.list</h1></div>
   <div id="bd" role="main">
	<div class="yui-g" id="feeds">
	
             <?php echo$result;?>

	</div>
	</div>
    <?php echo '<div id="timespent">Time spent: <strong>' . (microtime(true)-$oldtime) .'</strong></div>'; ?>
   <div id="ft" role="contentinfo">created By Adrian Statescu</div>
</div>

</body>
</html>

<?php

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