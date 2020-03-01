<?php
	/*
		This is a static class containing
		functions related to the admin
		session.
	*/

class Session
{
	private static function redirectToHTTPS()
	{
		if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
			header("Location: https://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
		}
	}

	private static function initiateSession()
	{
			// Workaround for not having permissions
			// to access whatever the default tmp directory is
			session_save_path("/tmp");

			session_start();
	}

	public static function startAdminSession($username, $password)
	{
		include_once("dbal.php");
		Session::redirectToHTTPS();

		// Verify username/password
		$pdo = DBAL::connectDB();
		if(!DBAL::verifyUser($pdo, $username, $password))
			return false;

		// Now we can start a session
		if(!isset($_SESSION))
		{
			Session::initiateSession();
		}

		// Grant admin privileges
		$_SESSION['admin_session'] = true;

		return true;
	}

	public static function isAdminSession()
	{
		session::redirectToHTTPS();

		if(!isset($_SESSION))
			Session::initiateSession();


		if(isset($_SESSION) && array_key_exists('admin_session',$_SESSION)){
			return true;
		}
		return false;
	}

	public static function restrict()
	{
		if(!Session::isAdminSession())
			die("Access denied");
	}

	public static function stopAdminSession()
	{
		Session::redirectToHTTPS();
		Session::initiateSession();
		$_SESSION['admin_session'] = false;
		session_unset();
	}
}
?>
