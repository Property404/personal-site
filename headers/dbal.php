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
		time_modified TIMESTAMP NOT NULL,
		time_published TIMESTAMP NULL, # NOT a typo!
		time_created TIMESTAMP NOT NULL,
		title TEXT NOT NULL,
		blurb TEXT,
		body TEXT NOT NULL,
		published BOOL DEFAULT false NOT NULL,
		PRIMARY KEY (id),
		FOREIGN KEY (blog_id) REFERENCES Blogs(id)
	);";


	// First-time setup
	public static function setUpDatabase($pdo)
	{
		$pdo = self::connectDB();
		$success = true;
		$queries = Array(
			self::_USERS_TABLE_DEFINITION,
			self::_BLOGS_TABLE_DEFINITION,
			self::_POSTS_TABLE_DEFINITION);
		
		foreach($queries as $query)
		{
			if (!$pdo->query($query))
			{
				print_r($pdo->errorInfo());
				$success = false;
			}
		}

		return $success;
	}

	public static function connectDB()
	{
		$pdo = new PDO('mysql:host=localhost;dbname='.self::_DB_NAME.';charset=utf8;', self::_DB_USERNAME, self::_DB_PASSWORD);
		if(!$pdo)
		{
			die("<div class='error'>Can't connect to database</div>" );
		}

		return $pdo;
	}

	public static function userTableIsEmpty($pdo)
	{
		$res = $pdo->query("SELECT * from Users;");
		return !count($res->fetchAll());
	}

	public static function addUser($pdo, $username, $password)
	{
		include_once("security.php");
		$hash = Security::makeSaltedHash($password);
		$password = null;

		$prep = $pdo->prepare("INSERT INTO Users (username, hash) VALUES (:username, :hash);");
		$res = $prep->execute(array(':username'=>$username, ':hash'=>$hash));

		if(! $res)
		{
			return false;
		}
		return true;
	}

	public static function verifyUser($pdo, $username, $password)
	{
		include_once("security.php");
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

	public static function addPost($pdo, $blog_name, $title, $blurb, $body, $published)
	{
		try{
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$prep = $pdo->prepare("
				INSERT INTO Posts (
						blog_id,
						time_created,
						time_modified,
						time_published,
						title,
						body,
						published
					)
				VALUES(
						(SELECT id FROM Blogs WHERE name=:blog_name),
						NOW(),
						NOW(),
						if(:write_published_time,  NOW(), null),
						:title,
						:body,
						:published
				);");
						
			$res = $prep->execute(Array(
				":blog_name"=>$blog_name,
				":title"=>$title,
				":published"=>$published,
				":write_published_time"=>$published,
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
		try{
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$prep = $pdo->prepare("
			UPDATE Posts 
			SET 
				blog_id = (SELECT id FROM Blogs WHERE name=:blog_name),
				time_modified = NOW(),
				time_published = IF((SELECT time_published FROM Posts WHERE id=:id) IS null,
				".($published?"NOW()":"null").",(SELECT time_published FROM Posts WHERE id=:id2)),
				published = :published,
				title = :title,
				body = :body
			WHERE
				id = :id3;
			");

			// Logic flow
			// if time_published is null:
			// 		if published:
			//	 		time_published = NOW()
			//

			$res = $prep->execute(Array(
				":blog_name"=>$blog_name,
				":title"=>$title,
				":body"=>$body,
				":published"=>$published,
				":id"=>$id,
				":id2"=>$id,
				":id3"=>$id
			));
		}
		catch(Exception $e)
		{
			echo("Caught!!");
			var_dump($e->getMessage());
		}
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
