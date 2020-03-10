<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$docroot = $_SERVER["DOCUMENT_ROOT"];
	include($docroot."/headers/config.php");
	include($docroot."/headers/session.php");
	include($docroot."/headers/dbal.php");

	Session::restrict();
	$pdo = DBAL::connectDB();

	$blog_name = $_POST["blog_name"];

	$status = DBAL::addBlog($pdo, $blog_name);

	if(!$status)
	{
		http_response_code(500);
	}
	echo('{"name":"'.$blog_name.'","id":"'.$status[0]["id"].'"}');
?>

