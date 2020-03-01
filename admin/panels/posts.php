<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	<h1 class="h2">Posts</h1>
</div>
<div class="my-3 p-3 rounded shadow-sm">
<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include_once($docroot."/headers/config.php");
include_once($docroot."/headers/dbal.php");
include_once($docroot."/headers/session.php");
Session::restrict();
$pdo = DBAL::connectDB();
$posts = DBAL::getPosts($pdo);

	foreach($posts as $post)
	{
		echo("
		<div id='row-template' class='row'>
			<h3 class='col-2'>
				<span id='title'>
".
					$post["title"]
					."
				</span>
			</h3>
			<div class='col-1'>
                  <span id='edit' data-feather='edit'></span>
			</div>
			<div class='col-1'>
                  <span id='info' data-feather='info'></span>
			</div>
			<div class='col-8'>
			</div>
		</div>");
	}
	
	
;?>
</div>
