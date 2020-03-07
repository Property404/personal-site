<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="add_delete_modalLabel">Delete blog?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span id='delete' data-feather='x'>sdfads</span>
				</button>
			</div>
			<form>
				<div class="modal-body">
					All posts related to this blog will be deleted
				</div>
				<div class="modal-footer">
					<button id="confirm_delete_button" type="button" class="btn btn-secondary" data-dismiss="modal">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="add_add_modalLabel">Add Blog</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span id='add' data-feather='x'>sdfads</span>
				</button>
			</div>
			<form>
				<div class="modal-body">
					<input placeholder="Blog name" type="text" id="new_blog_name" class="form-control"></input>
				</div>
				<div class="modal-footer">
					<button id="confirm_add_button" type="button" class="btn btn-primary" data-dismiss="modal">Add</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	<h1 class="h2">Blogs</h1>
</div>
<div class="my-3 p-3 rounded shadow-sm">
<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include_once($docroot."/headers/config.php");
include_once($docroot."/headers/dbal.php");
include_once($docroot."/headers/session.php");
Session::restrict();
$pdo = DBAL::connectDB();
$blogs = DBAL::getBlogs($pdo);

	foreach($blogs as $blog)
	{
		echo("
		<div id='row-template' class='row'>
			<h3 class='col-sm-8'>
				<span id='name'>
".
					$blog["name"]
					."
				</span>
			</h3>
			<div class='col-sm-4' style='text-align:right;'>
                  <a href='#".$blog["id"]."'><span id='delete' data-feather='trash' data-toggle='modal' data-target='#delete_modal'></span></a>
			</div>
		</div>");
	}
;?>
	<div id='row-template' class='row'>
		<div class='col-lg-10'> </div>
		<div class='col-lg-2'>
			<button class="btn btn-lg btn-primary btn-block" data-toggle='modal' data-target='#add_modal'>
				New Blog
			</button>
		</div>
	</div>
</div>

<script src="/js/jquery.slim.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/js/dashboard/blogs.js" type="module">console.log("!");</script>

