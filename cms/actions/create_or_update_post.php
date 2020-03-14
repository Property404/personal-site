<link rel="stylesheet" href="/css/main.css">
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

	var_dump($_POST);

	$title = $_POST["title"];
	$body = $_POST["body"];
	$blog_name = $_POST["blog_name"];
	$publish = array_key_exists("publish",$_POST)?1:0;
	$blurb = substr($body, 0, strpos($body, "\n"));
	$id = NULL;
	if(array_key_exists("id", $_GET))
	{
		$id = $_GET["id"];
	}


	echo("Title: <pre>".$title."</pre>");
	echo("Body: <pre>".$body."</pre>");
	echo("Blurb: <pre>".$blurb."</pre>");
	echo("Blog Name: <pre>".$blog_name."</pre>");
	echo("Publish: <pre>".$publish."</pre>");

	$status = NULL;
	if($id === NULL)
	{
		$status = DBAL::addPost($pdo, $blog_name, $title, $blurb, $body, $publish);
		$id = DBAL::getLastPost($pdo)["id"];
	}
	else
	{
		$status = DBAL::editPost($pdo, $id, $blog_name, $title, $body, $publish);
	}

	if(!$status)
		die("Failed");
	else
	{
		echo("<script>
		window.location = '/cms?panel=edit&id=".$id."';".
		"</script>"
		);
	}
?>

	

