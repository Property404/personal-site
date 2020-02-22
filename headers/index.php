<!DOCTYPE html>
<link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/main.css" rel="stylesheet">
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("session.php");
include("dbal.php");

$pdo = DBAL::connectDB();

if (DBAL::verifyUser($pdo, "admin", "hunter2"))
{
	echo("Verified");
}
else
{
	echo("Not verified");
}


?>
