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

	$blogs = DBAL::getPosts($pdo);

	echo('{"posts":[');
	$looped = false;
	foreach($blogs as $blog)
	{
		if($looped)
			echo(",");
		$looped = true;
		echo('{"id":"'.$blog["id"].'","title":"'.$blog["title"].'"}');
	}
	echo("]}");
?>


