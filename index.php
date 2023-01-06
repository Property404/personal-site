<!doctype html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="How many Dagans? Just the one, until the cloner works">
	<meta name="author" content="Dagan Martinez">
	<link rel="icon" type="image/png" sizes="32x32" href="/media/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/media/favicon/favicon-16x16.png">
	<meta name="referrer" content="same-origin">

	<title>Dagan Martinez - Software Engineer</title>

	<link href="/css/main.css" rel="stylesheet">
	<script src="/js/frontpage.js" type="module"></script>
  </head>

  <body>
	  <header class="main-header">
		  <nav>
			<a class="nav-link" id="link-cover" href="/?page=cover">Home</a>
			<a class="nav-link" id="link-skills" href="/?page=skills">Skills</a>
			<a class="nav-link" id="link-experience" href="/?page=experience">Experience</a>
			<a class="nav-link" id="link-projects" href="/?page=projects">Projects</a>
		  </nav>
	  </header>

	  <main id="content" role="main">
<?php
	$pages=Array(
		"cover"=>"cover.html",
		"experience"=>"experience.html",
		"skills"=>"skills.html",
		"projects"=>"projects.html",
		"http_error"=>"http_error.php",
	);

	if(isset($_GET) &&array_key_exists("page", $_GET))
		$page = $_GET["page"];
	else
		$page = "cover";
	include($_SERVER["DOCUMENT_ROOT"]."/snips/".$pages[$page]);

?>
	  </main>

	  <footer class="main-footer">
			<p><a href="https://github.com/Property404">GitHub</a> | <a href="https://www.linkedin.com/in/dagan-martinez-57769711a">LinkedIn</a><br>
	  </footer>

  </body>
</html>
