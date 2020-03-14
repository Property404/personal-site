<?php 
	$docroot = $_SERVER["DOCUMENT_ROOT"];
	include($docroot."/headers/dbal.php");
	include($docroot."/headers/config.php");
	$pdo = DBAL::connectDB();
	$posts = DBAL::getPosts($pdo);
	foreach($posts as $post)
	{
		// Only show published posts
		if(!($post["published"]))continue;

		echo("<h2><a id='title' href='?page=post&id=".$post["id"]."'>".$post["title"]."</a></h2>\n");
		echo("<div id='blurb'>\n");
		echo($post["blurb"]);
		echo("</div><p><p>\n");

	}
?>
