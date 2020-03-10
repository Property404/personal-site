<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include($docroot."/headers/config.php");
include($docroot."/headers/session.php");
Session::stopAdminSession();
if(Session::isAdminSession())
{
	die("Failed to logout");
}
else
{
	header("Location: /cms");
}
?>
