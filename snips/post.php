<?php
	$docroot = $_SERVER["DOCUMENT_ROOT"];
	include($docroot."/headers/dbal.php");
	include($docroot."/headers/config.php");
	$pdo = DBAL::connectDB();
	$post = DBAL::getPost($pdo, $_GET["id"]);
	$title = $post["title"];
	$body = $post["body"];
?>
<h2 id="post-title" ><?php echo( $title); ?></h2>
<article class="post" id="post-content" role="article">
<?php echo($body); ?>
</article>
