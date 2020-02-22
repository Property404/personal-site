<?php
// DataBase Abstraction Layer
class DBAL
{
	//Private Constants
	const _DB_NAME="DagansDotDev";
	const _DB_USERNAME="root";
	const _DB_PASSWORD="";

	const _USERS_TABLE_DEFINITION="CREATE TABLE IF NOT EXISTS Users (
		id INT AUTO_INCREMENT,
		username VARCHAR(128) NOT NULL,
		hash CHAR(255) NOT NULL,
		PRIMARY KEY(id)
						);";

	const _BLOGS_TABLE_DEFINITION="
		CREATE TABLE IF NOT EXISTS Blogs (id INT, name CHAR(16), PRIMARY KEY(id));
	";

	const _POSTS_TABLE_DEFINITION="CREATE TABLE IF NOT EXISTS Posts (
		id INT,
		blog_id INT,
		time_created TIMESTAMP,
		time_modified TIMESTAMP,
		title TEXT,
		body TEXT,
		PRIMARY KEY (id),
		FOREIGN KEY (blog_id) REFERENCES Blogs(id)
	);";



	// Initialize admin table with (admin, DEFAULT_PASSWORD)
	// (only if uninitialized)
	private static function setInitialAdminTable($pdo){
		include_once("security.php");
		$res = $pdo->query("SELECT * from Users");
		if (!sizeof($res->fetchAll()))
		{
			$pdo->query("INSERT INTO Users (hash,username) VALUES('".Security::makeSaltedHash(Security::DEFAULT_PASSWORD) . "','admin');");
		}
	}

	public static function connectDB()
	{
		$pdo = new PDO('mysql:host=localhost;dbname='.self::_DB_NAME.';charset=utf8;', self::_DB_USERNAME, self::_DB_PASSWORD);
		if(!$pdo)
		{
			die("<div class='error'>Can't connect to database</div>" );
		}

		if (!$pdo->query(self::_USERS_TABLE_DEFINITION))
			print_r($pdo->errorInfo());
		if (!$pdo->query(self::_BLOGS_TABLE_DEFINITION))
			print_r($pdo->errorInfo());
		if (!$pdo->query(self::_POSTS_TABLE_DEFINITION))
			print_r($pdo->errorInfo());
		self::setInitialAdminTable($pdo);

		return $pdo;
	}

	public static function verifyUser($pdo, $username, $password)
	{
		$prep = $pdo->prepare("SELECT hash FROM Users WHERE username = :username;");
		$prep->execute(array(':username'=>$username));
		$res = $prep->fetch();

		if($res)
		{
			$stored_hash = $res[0];
			return Security::verifyHash($password, $stored_hash);
		}
		return false;
	}

	public static function addBlog($pdo, $blog_name)
	{
		$prep = $pdo->prepare("INSERT INTO Blogs (name) VALUES (:name);");
		$res = $prep->execute(Array(":name"=>$blog_name));
		if($res)
			return true;
		return false;
	}

	public static function addPost($pdo, $blog_name, $title, $body)
	{
		$prep = $pdo->prepare("
			INSERT INTO Posts (
					blog_id,
					time_created,
					time_modified,
					title,
					body)
			VALUES(
					(SELECT id FROM Blogs WHERE name=:blog_name),
					NOW(),
					NOW(),
					:title,
					:body
			);");
					
		$res = $prep->execute(Array(
			":blog_name"=>$blog_name,
			":title"=>$title,
			":body"=>$body
		));
		if($res)
			return true;
		return false;
	}
}

?>
