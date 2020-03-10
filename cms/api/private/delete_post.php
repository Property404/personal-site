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

	$id = $_POST["id"];
	$status = DBAL::deletePost($pdo, $id);

	if(!$status)
		echo('{"ok":false}');
	else
		echo('{"ok":true}');
?>

	

