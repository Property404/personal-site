<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$docroot = $_SERVER["DOCUMENT_ROOT"];
	include_once($docroot."/headers/config.php");
	include_once($docroot."/headers/session.php");
	include_once($docroot."/headers/dbal.php");

	$pdo = DBAL::connectDB();
	$username = $_POST["user"];
	$password = $_POST["password"];

	// First time setup:
	DBAL::setUpDatabase($pdo);

	// 	Add new user if none exist
	if (DBAL::userTableIsEmpty($pdo))
	{
		// Only allow via localhost
		// (e.g. a SOCKS5 proxy)
		$whitelist = array(
		'127.0.0.1',
		'::1');

		if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
			DBAL::addUser($pdo, $username, $password);
		}
	}

	$success = Session::startAdminSession($username, $password);
	if($success)
		header("Location: /cms?success=true");
	else
		header("Location: /cms?fail=true");
?>

	

