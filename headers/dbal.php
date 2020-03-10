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
		CREATE TABLE IF NOT EXISTS Blogs (
			id INT AUTO_INCREMENT,
			name CHAR(16) NOT NULL,
			PRIMARY KEY(id));
	";

	const _POSTS_TABLE_DEFINITION="CREATE TABLE IF NOT EXISTS Posts (
		id INT AUTO_INCREMENT,
		blog_id INT NOT NULL,
		time_created TIMESTAMP NOT NULL,
		time_modified TIMESTAMP NOT NULL,
		title TEXT NOT NULL,
		body TEXT NOT NULL,
		published BOOL DEFAULT false NOT NULL,
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
		if(!($res))
			return false;
		
		$prep = $pdo->prepare("SELECT * FROM Blogs WHERE name = :name;");

		$res = $prep->execute(Array(":name"=>$blog_name));
		$res = $prep->fetchAll();
		return $res;
		
	}

	public static function addPost($pdo, $blog_name, $title, $body, $published)
	{
		try{
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$prep = $pdo->prepare("
				INSERT INTO Posts (
						blog_id,
						time_created,
						time_modified,
						title,
						body,
						published
					)
				VALUES(
						(SELECT id FROM Blogs WHERE name=:blog_name),
						NOW(),
						NOW(),
						:title,
						:body,
						:published
				);");
						
			$res = $prep->execute(Array(
				":blog_name"=>$blog_name,
				":title"=>$title,
				":published"=>$published,
				":body"=>$body
			));
			if($res)
				return true;
		}catch(Exception $e){
			echo("Caught!!!!");
			var_dump($e->getMessage());
		}
		return false;
	}

	public static function editPost($pdo, $id, $blog_name, $title, $body, $published)
	{
		$prep = $pdo->prepare("
			UPDATE Posts 
			SET 
				blog_id = (SELECT id FROM Blogs WHERE name=:blog_name),
				time_modified = NOW(),
				published = :published,
				title = :title,
				body = :body
			WHERE
				id = :id;
			");
					
		$res = $prep->execute(Array(
			":blog_name"=>$blog_name,
			":title"=>$title,
			":body"=>$body,
			":published"=>$published,
			":id"=>$id
		));
		if($res)
			return true;
		return false;
	}

	public static function getBlogs($pdo)
	{
		$res = $pdo->query("SELECT * FROM Blogs;")->fetchAll();
		return $res;
	}

	public static function getPosts($pdo)
	{
		$res = $pdo->query("SELECT * FROM Posts;")->fetchAll();
		return $res;
	}

	public static function getBlog($pdo, $id)
	{
		$prep = $pdo->prepare("SELECT * FROM Blogs WHERE id = :id;");
		$prep->execute(Array(
			":id" => $id));
		return $prep->fetchAll()[0];
	}

	public static function getLastPost($pdo)
	{
		$prep = $pdo->query("SELECT * FROM Posts;");
		$rows = $prep->fetchAll();
		return $rows[count($rows)-1];
	}

	public static function getPost($pdo, $id)
	{
		$prep = $pdo->prepare("SELECT * FROM Posts WHERE id = :id;");
		$prep->execute(Array(
			":id" => $id));
		return $prep->fetchAll()[0];
	}

	public static function deletePost($pdo, $id)
	{
		$prep = $pdo->prepare("DELETE FROM Posts WHERE id = :id;");
		return $prep->execute(Array(
			":id" => $id));
	}

	public static function deleteBlog($pdo, $id)
	{
		$prep = $pdo->prepare("DELETE FROM Blogs WHERE id = :id;");
		return $prep->execute(Array(
			":id" => $id));
	}
}

?>
