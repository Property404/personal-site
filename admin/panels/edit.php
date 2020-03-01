<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include_once($docroot."/headers/config.php");
include_once($docroot."/headers/dbal.php");
include_once($docroot."/headers/session.php");
Session:restrict();
$pdo = DBAL::connectDB();

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

?>

<!-- Heading -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
<h1 class="h2"><?php echo($mode==MODE_CREATE?"Create":"Edit")?> Post</h1>
</div>

<form action="/admin/actions/create_or_update_post.php" method="POST">


<!-- Title text -->
<input placeholder="Title" name="title" id="title" type="text" class="form-control" ></input>

<!-- Blog select -->
<select name="blog_name" id="blog" class="">
<?php
	foreach($blogs as $blog)
	{
		$blog_name = $blog["name"];
		echo("<option value='".$blog_name."'>".$blog_name."</option>");
	}
?>
</select>

<!-- Body text -->
<textarea placeholder="Body" name="body" id="body-textarea" type="text" class="form-control"></textarea>
<button class="btn btn-lg btn-primary btn-block" type="submit" id='button'>
	<?php echo($mode==MODE_CREATE?"Post":"Update") ?>
</button>
</form>


<!-- CodeMirror shit -->
<link rel="stylesheet" href="/css/monokai.css">
<script src="/node_modules/codemirror/lib/codemirror.js"></script>
<script src="/node_modules/codemirror/mode/xml/xml.js"></script>
<script src="/node_modules/codemirror/keymap/vim.js"></script>
<script>
let textarea = document.querySelector("#body-textarea")
let cm=CodeMirror(
	function(elt) {
  textarea.parentNode.replaceChild(elt, textarea);
	}, {value: textarea.value,
	mode: "xml",
	keyMap: "vim"
  });

if(window.matchMedia('(prefers-color-scheme:dark)').matches)
{
	cm.setOption("theme", "molokai");
}
document.querySelector("textarea").setAttribute("name", "body");
</script>
