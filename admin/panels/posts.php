<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="add_delete_modalLabel">Delete post?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span id='delete' data-feather='x'>sdfads</span>
				</button>
			</div>
			<form>
				<div class="modal-body">
					This cannot be undone
				</div>
				<div class="modal-footer">
					<button id="confirm_delete_button" type="button" class="btn btn-secondary" data-dismiss="modal">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>

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
			<h3 class='col-sm-8'>
				<span id='title'>
".
					$post["title"]
					."
				</span>
			</h3>
			<div class='col-sm-4' style='text-align:right;'>
                  <a href='?panel=edit&id=".$post["id"]."'><span id='edit' data-feather='edit'></span></a>
					&nbsp;
                  <a href='#".$post["id"]."'><span id='delete' data-feather='trash' data-toggle='modal' data-target='#delete_modal'></span></a>
			</div>
		</div>");
	}
;?>
	<div id='row-template' class='row'>
		<div class='col-lg-10'> </div>
		<div class='col-lg-2'>
<a href="?panel=edit">
			<button class="btn btn-lg btn-primary btn-block">
				New Post
			</button>
</a>
		</div>
	</div>
</div>

<script src="/js/jquery.slim.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/js/dashboard/posts.js" type="module">console.log("!");</script>

