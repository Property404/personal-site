<?php
	$docroot = $_SERVER["DOCUMENT_ROOT"];
	include($docroot."/headers/config.php");
	include($docroot."/headers/session.php");

	const UPLOADS_LOCAL_DIR = "/uploads/";
	$uploads_abs_path = $docroot.UPLOADS_LOCAL_DIR;
	Session::restrict();

	if(!array_key_exists("file_to_upload", $_FILES))
		die('{"error":"file_to_upload field doesn\'t exist"}');
	if(!array_key_exists("name", $_FILES["file_to_upload"]))
		die('{"error":"name field doesn\'t exist"}');

	$file_local_path = UPLOADS_LOCAL_DIR . basename($_FILES["file_to_upload"]["name"]);
	$file_abs_path = $uploads_abs_path . basename($_FILES["file_to_upload"]["name"]);

	$success = move_uploaded_file($_FILES["file_to_upload"]["tmp_name"], $file_abs_path);

	if($success)
	{
		echo('{"ok":true,"message":"Upload successful!", "path":"'.addslashes($file_local_path).'"}');
	}
	else
	{
		echo('{"ok":false, "message": "Upload failed"}');
	}
?>

