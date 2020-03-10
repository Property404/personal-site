<?php
	include($_SERVER["DOCUMENT_ROOT"]."/headers/session.php");
	Session::restrict();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta name="referrer" content="same-origin">

    <title>Dashboard</title>

    <link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/node_modules/codemirror/lib/codemirror.css">
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
  </head>

  <body>

        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="?panel=posts">
                  <span data-feather="file"></span>
                  Posts
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="?panel=blogs">
                  <span data-feather="briefcase" ></span>
                  Blogs
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="?panel=php_info">
                  <span data-feather="info"></span>
                  Server Info
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/cms/actions/logout.php">
                  <span data-feather="log-out"></span>
                  Sign out
                </a>
              </li>

            </ul>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

		<?php
include($_SERVER["DOCUMENT_ROOT"]."/headers/config.php");
$panels = Array(
"posts"=>"./panels/posts.html",
"blogs"=>"./panels/blogs.html",
"edit"=>"./panels/edit.php",
"php_info"=>"./panels/php_info.php"
);
if (key_exists("panel", $_GET))
	$panel = $_GET["panel"];
else
	$panel = "posts";

include($panels[$panel]);
		?>

        </main>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
  </body>
</html>
