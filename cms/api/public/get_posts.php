<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$docroot = $_SERVER["DOCUMENT_ROOT"];
	include($docroot."/headers/dbal.php");

	$pdo = DBAL::connectDB();

	function escape($string)
	{
		return str_replace("\r\n","\\n",addslashes($string));
	}

	$posts = DBAL::getPosts($pdo);

	echo('{"posts":[');
	$looped = false;
	foreach($posts as $post)
	{
		if($looped)
			echo(",");
		$looped = true;
		echo(json_encode(
			Array(
				"id"=>$post["id"],
				"title"=>$post["title"],
				"published"=>$post["published"],
				"blurb"=>$post["blurb"]
			)));
	}
	echo("]}");
?>


