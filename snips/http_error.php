<?php 
	$docroot = $_SERVER["DOCUMENT_ROOT"];
	include($docroot."/headers/config.php");

	$code=$_GET["code"];

	$messages = Array(
		"400"=>"Bad Request",
		"401"=>"Unauthorized",
		"403"=>"Forbidden",
		"404"=>"Not Found",
		"406"=>"Not Acceptable",
		"494"=>"Request Header Too Large",
		"495"=>"SSL Certificate Error",
		"500"=>"Internal Server Error",
		"501"=>"Not Implemented",
		"502"=>"Bad Gateway",
		"503"=>"Service Unavailable",
		"504"=>"Gateway Timeout",
		"505"=>"HTTP Version Not Supported",
		"507"=>"Insufficient Storage",
	);
	$submessages = Array(
		"403"=>"Username is not in the sudoers file. This incident will be reported",
		"406"=>'<video width="560" height="315" src="/uploads/videos/406.mp4" controls></video>',
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
