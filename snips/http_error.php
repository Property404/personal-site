<?php 
	$docroot = $_SERVER["DOCUMENT_ROOT"];
	include($docroot."/headers/config.php");

	$code=$_GET["code"];

	$messages = Array(
		"400"=>"Bad Request",
		"401"=>"Unauthorized",
		"403"=>"Forbidden",
		"404"=>"Not Found",
		"405"=>"Method Not Allowed",
		"406"=>"Not Acceptable",
		"408"=>"Request Timeout",
		"409"=>"Conflict",
		"411"=>"Length Required",
		"412"=>"Precondition Failed",
		"413"=>"Request Entity Too Large",
		"414"=>"Request URI Too Large",
		"415"=>"Unsupported Media Type",
		"416"=>"Range Not Satisiable",
		"418"=>"I'm a Teapot",
		"423"=>"Locked",
		"425"=>"Too Early",
		"426"=>"Upgrade Required",
		"429"=>"Too Many Requests",
		"494"=>"Request Header Too Large",
		"495"=>"SSL Certificate Error",
		"497"=>"HTTP Request Sent to HTTPS Port",
		"499"=>"Client Closed Request",
		"500"=>"Internal Server Error",
		"501"=>"Not Implemented",
		"502"=>"Bad Gateway",
		"503"=>"Service Unavailable",
		"504"=>"Gateway Timeout",
		"505"=>"HTTP Version Not Supported",
		"507"=>"Insufficient Storage",
	);
	$submessages = Array(
		"403"=>"The police are on their way",
		"404"=>"I hope in the future you are able to find what you're looking for",
		"406"=>'<video height="315" src="/media/videos/406.mp4" controls></video>',
		"418"=>"This error should never come up, considering that this website runs on a rice cooker",
		"503"=>"Hopefully service will be back shortly",
		"507"=>"I couldn't eat another thing. I'm absolutely stuffed"
	);


	echo("<h1 id='http-error'>".intval($code));
	if (array_key_exists($code, $messages))
	{
		echo(" - ".$messages[$code]);
	}
	echo("</h1>");
	if (array_key_exists($code, $submessages))
	{
		echo($submessages[$code]);
	}
?>
