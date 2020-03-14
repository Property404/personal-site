<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include_once($docroot."/headers/config.php");
include_once($docroot."/headers/dbal.php");
include_once($docroot."/headers/session.php");
$pdo = DBAL::connectDB();
Session::restrict();

// Are we making a new post or editing an old one?
const MODE_CREATE=1;
const MODE_EDIT=2;
$mode = MODE_CREATE;
$id = NULL;
$details = NULL;
$blogs = DBAL::getBlogs($pdo);
if(array_key_exists("id", $_GET))
{
	$mode = MODE_EDIT;
	$id = $_GET["id"];
	$details = DBAL::getPost($pdo, $id);
}
function escape($string)
{
	return str_replace("\r\n","\\n",addslashes($string));
}

$title = $mode==MODE_CREATE?"":addslashes($details["title"]);
$blog_name = $mode==MODE_CREATE?"":addslashes(DBAL::getBlog($pdo, $details["blog_id"])["name"]);
$body = $mode==MODE_CREATE?"":escape($details["body"]);

?>


<!-- Heading -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
<h1 class="h2"><?php echo($mode==MODE_CREATE?"Create":"Edit")?> Post</h1>
</div>

<form action="/cms/actions/create_or_update_post.php<?php if($mode==MODE_EDIT)echo("?id=".$id)?>" method="POST">
<div class="modal fade" id="blurb-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="add_add_modalLabel">Edit Blurb</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span data-feather='x'>X</span>
				</button>
			</div>
				<div class="modal-body">
					<textarea placeholder="Blurb goes here" type="text" name="blurb" id="blurb" class="form-control" ></textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
				</div>
		</div>
	</div>
</div>


<!-- Title text -->
<input placeholder="Title" name="title" id="title" type="text" class="form-control" style="font-weight:bold;" >

<!-- Blog select -->
<select name="blog_name" id="blog" class="form-control" >
<?php
foreach($blogs as $blog)
{
	echo("<option value='".$blog["name"]."'".($blog_name!=$blog["name"]?"":" selected").">");
	echo($blog["name"]);
	echo("</option>");
}
?>
</select>

<!-- Body text -->
<textarea id="body-textarea" name="body"></textarea>



		<div id='row-template' class='row'>
			<div class='col-lg-7'> </div>
<!-- Publish check -->
			<div class='col-lg-1 form-check'>
			<input <?php echo(($mode==MODE_CREATE || !$details["published"])?"":"checked");?> name='publish' type='checkbox' class='form-control form-check-input'>
			</div>
			<div class='col-lg-2'>
				<button type="button" class="btn btn-lg btn-primary btn-block" data-toggle='modal' data-target='#blurb-modal'>Edit Blurb</button>
			</div>
			<div class='col-lg-2'>
<!-- Submit -->
<button class="btn btn-lg btn-primary btn-block" type="submit" id='button'>
	<?php echo($mode==MODE_CREATE?"Post":"Update") ?>
</button>
			</div>
		</div>
</form>


<!-- CodeMirror shit -->
<link rel="stylesheet" href="/css/monokai.css">
<script src="/node_modules/codemirror/lib/codemirror.js"></script>
<script src="/node_modules/codemirror/mode/xml/xml.js"></script>
<script src="/node_modules/codemirror/keymap/vim.js"></script>
<script src="/js/jquery.slim.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/js/dashboard/edit.js" type="module"></script>
<script>

let editor = CodeMirror.fromTextArea(
	document.getElementById( "body-textarea"),
	{
		mode: "xml",
		keyMap:"vim"
	}
);
editor.setValue("<?php echo($body);?>")

if(window.matchMedia('(prefers-color-scheme:dark)').matches)
{
	editor.setOption("theme", "molokai");
}
//document.querySelector("#bodytextarea").setAttribute("name", "body");
</script>
