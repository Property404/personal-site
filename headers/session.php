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

	public static function startAdminSession($username, $password)
	{
		Session::redirectToHTTPS();

		// Verify username/password
		$pdo = DBAL::connectDB();
		if(!DBAL::verifyUser($pdo, $username, $password))
			return false;

		// Now we can start a session
		if(!isset($_SESSION))
		{
			// Workaround for not having permissions
			// to access whatever the default tmp directory is
			session_save_path("/tmp");

			session_start();
		}

		// Grant admin privileges
		$_SESSION['admin_session'] = true;

		return true;
	}

	public static function isAdminSession()
	{
		session::redirectToHTTPS();

		if(isset($_SESSION) && array_key_exists('admin_session',$_SESSION)){
			return true;
		}
		return false;
	}

	public static function stopAdminSession()
	{
		Session::redirectToHTTPS();
		if(isset($_SESSION))
		{
			session_unset();
		}
	}
}
?>
