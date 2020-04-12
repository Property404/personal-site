<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include($docroot."/headers/config.php");
include($docroot."/headers/session.php");
if(Session::isAdminSession())
{
	header("Location: /cms");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="How many Dagans? Just the one, until the cloner works">
    <meta name="author" content="Dagan Martinez">

    <title>Login</title>

    <link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
  </head>
	<body class="text-center">
		<form id="form" class="form-signin" action="/cms/actions/validate.php" method="post">
			<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
			<div id="error" class="alert alert-danger" hidden>
				<strong>Invalid credentials</strong>
			</div>
			<label for="user" class="sr-only">Username</label>
			<input type="text" name="user" id="user" class="form-control" placeholder="Username" required autofocus>
			<label for="inputPassword" class="sr-only">Password</label>
			<input name="password" type="password" id="password" class="form-control" placeholder="Password" required/>
			<button class="btn btn-lg btn-primary btn-block" type="submit" id='button'>Sign in</button>
		</form>

		<script type="module">
			import {parseUrlParameters} from '/js/common.mjs'
			const url_params = parseUrlParameters();

			if (url_params["fail"])
			{
				document.getElementById("error").removeAttribute("hidden");
			}

			if(url_params["url"])
			{
				let form = document.querySelector("#form");
				form.setAttribute("action", form.getAttribute("action")+"?url="+url_params["url"]);
			}
		</script>
	</body>
</html>

