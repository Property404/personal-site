<?php
	/*
		This is a static class containing
		functions related to the admin
		session. It deals with non-
		cryptographic security and the
		initial creation of the 
		database.
	*/
	
	class Session{
		//Private Constants
		const _DB_NAME="dagans_dot_dev";
		const _DB_USERNAME="root";
		const _DB_PASSWORD="";
		
		const _USERS_TABLE_DEFINITION="CREATE TABLE IF NOT EXISTS Users (
								id INT AUTO_INCREMENT,
								hash CHAR(512) NOT NULL,
								username VARCHAR(128) NOT NULL,
								PRIMARY KEY(id)
								);";

		const _POSTS_TABLE_DEFINITION="CREATE TABLE IF NOT EXISTS Posts (
                id INT PRIMARY KEY,
                time_created TEXT,
                time_modified TEXT,
                title TEXT,
                body TEXT,
                blog_id INT,
                FOREIGN KEY(blog_id) REFERENCES Blog(id)
            );"

		const _BLOGS_TABLE_DEFINITION="
            CREATE TABLE IF NOT EXISTS Blogs (id INT, name CHAR(16), PRIMARY KEY(id));
		"

										
		//Private methods
		private static function setInitialAdminTable($link){
			include_once("/headers/security.php");
			$pdo->query("INSERT INTO ADMIN (HASH,USERNAME) VALUES('".Security::makeSaltedHash(Security::DEFAULT_PASSWORD) . "','admin');");
		}

		public static function connectDB()
		{
			$pdo = new PDO('dblib:host=localhost;dbname='.self::_DB_NAME.';charset=UTF-8', self::_DB_USERNAME, self::_DB_PASSWORD);
			if(!$pdo)
			{
				die("<div class='error'>Can't connect to database</div>" );
			}

			$pdo->query(self::_USERS_TABLE_DEFINITION);
			$pdo->query(self::_BLOGS_TABLE_DEFINITION);
			$pdo->query(self::_POSTS_TABLE_DEFINITION);
			self::setInitialAdminTable($pdo);
		}
		
		//Create database/table if they don't exist
		public static function forceConnectDB(){
			$db_name=self::_DB_NAME;
			
			//Connect with SQL
			$link=mysqli_connect("localhost",self::_DB_USERNAME, self::_DB_PASSWORD);
			if(!$link){
			}else{
			}
			
			//Try to connect to database
			$database=mysqli_select_db($link,"$db_name");
			
			//Create database if it doesn't exist
			if(!$database){
				mysqli_query($link,"CREATE DATABASE $db_name;");
				$database=mysqli_select_db($link,"$db_name");
				if(!$database)
					echo("<div class='alert'>Error: database creation failed</div><br>");
				
			}
			
			//Attempt to create table if it doesn't exist
			if(empty(mysqli_query($link, "SELECT ID FROM ADMIN"))){
				echo("Creating table\n");
				mysqli_query($link,self::_ANSWERKEY_TABLE_DEFINITION);
				mysqli_query($link,self::_ADMIN_TABLE_DEFINITION);
				self::setInitialAdminTable($link);
				mysqli_query($link,self::_PROBLEM_TABLE_DEFINITION);
			}
			return $link;
		}
		
		
		//If not in session, redirect to login page
		public static function checkAdminSession(){
			if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
				header("Location: https://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
			}
			
			//Check session
			session_start();
			if(!array_key_exists('admin_session',$_SESSION)){
				header("Location: /login.php");
			}
			
		}
	}
?>
