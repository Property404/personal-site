<?php
	/*
		This is a static class containing
		functions related to the admin
		session.
	*/

class Session
{
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
		{
			header("Location: /cms/login/", true, 302);
			die("Access denied");
		}
	}

	public static function stopAdminSession()
	{
		Session::initiateSession();
		$_SESSION['admin_session'] = false;
		session_unset();
	}
}
?>
