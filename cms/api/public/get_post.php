<?php
	$docroot = $_SERVER["DOCUMENT_ROOT"];
	include($docroot."/headers/config.php");
	include($docroot."/headers/dbal.php");

	$pdo = DBAL::connectDB();

	$id = null;
	if(array_key_exists("id",$_GET)){
		$id=$_GET["id"];
	} elseif(array_key_exists("id",$_POST)){
		$id=$_POST["id"];
	} else{
		die('{"error":"No id given"}');
	}


	$post = DBAL::getPost($pdo, $id);

	echo(json_encode(
		Array(
			"id"=>$post["id"],
			"title"=>$post["title"],
			"time_created"=>$post["time_created"],
			"time_published"=>$post["time_published"],
			"time_modified"=>$post["time_modified"],
			"blurb"=>$post["blurb"],
			"body"=>$post["body"],
			"published"=>$post["published"]
		)));
?>


