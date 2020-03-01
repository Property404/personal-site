<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="How many Dagans? Just the one, until the cloner works">
    <meta name="author" content="Dagan Martinez">

    <title>Dagan Martinez - Firmware Developer</title>

    <link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/frontpage.css" rel="stylesheet">
  </head>

  <body class="text-center">

    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link" id="link-default" href="?page=cover">Home</a>
            <a class="nav-link" id="link-skills" href="?page=skills">Skills</a>
            <a class="nav-link" id="link-experience" href="?page=experience">Experience</a>
          </nav>
        </div>
      </header>

      <main id="content" role="main" class="inner cover">
			<?php
				// PHP fallback
				$page="cover";
				$pages=Array(
					"cover"=>"cover.html",
					"experience"=>"experience.html",
					"skills"=>"skills.html"
				);

				if(isset($_GET) &&array_key_exists("page", $_GET))
				{
					$page = $_GET["page"];
					if(!array_key_exists($page, $pages))
						$page="cover";
				}
				include($_SERVER["DOCUMENT_ROOT"]."/snips/".$pages[$page])

			?>
      </main>

      <footer class="mastfoot mt-auto">
        <div class="inner">
			<p>Copyright &copy; <time datetime="2020">2020</time> Dagan Martinez under the <a href="https://www.gnu.org/licenses/agpl-3.0.en.html">AGPL 3.0</a> license</p>
        </div>
      </footer>
    </div>

	<script src="js/frontpage.js" type="module"></script>
  </body>
</html>
