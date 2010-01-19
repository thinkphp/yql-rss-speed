<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title></title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
   <style type="text/css">
     iframe{width:100%;margin:1em;display:block;height:200px;}
   </style>
</head>
<body>
<div id="doc" class="yui-t7">
   <div id="hd" role="banner"><h1>Retrieving five RSS Feeds (speed comparison)</h1></div>
   <div id="bd" role="main">
	<div class="yui-g">

            <iframe src="simplecurl.php"></iframe>
            <iframe src="multicurl.php"></iframe>
            <iframe src="yqlcurl.php"></iframe>
            <iframe src="yqltable.php"></iframe>

	</div>

	</div>
   <div id="ft" role="contentinfo"><p>Written By Adrian Statescu using cURL, YQL and YUI</p></div>
</div>
</body>
</html>
