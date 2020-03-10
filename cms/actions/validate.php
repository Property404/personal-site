<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$docroot = $_SERVER["DOCUMENT_ROOT"];
	include($docroot."/headers/config.php");
	include($docroot."/headers/session.php");
	$username = $_POST["user"];
	$password = $_POST["password"];
	$success = Session::startAdminSession($username, $password);
	if($success)
		header("Location: /cms?success=true");
	else
		header("Location: /cms?fail=true");
?>

	

