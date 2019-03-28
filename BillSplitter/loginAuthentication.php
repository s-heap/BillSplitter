<?php
	include('database.php');
	include('session.php');
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if (empty($email) || empty($password)) {
		header("Location: index.php");
		exit();
	}
	
	$db = new Database();
	$stmt = $db->prepare('SELECT * FROM users WHERE user_email=:email');
	$stmt->bindValue(':email', strtolower($email), SQLITE3_TEXT);
	$getData = $stmt->execute()->fetchArray();
	
	if ($getData == null) {
		header("Location: index.php");
		exit();
	}
	
	$real_password = $getData['user_password'];
	$hashedInput = sha1($password);
	$hashedSaltedInput = sha1($hashedInput.$getData['user_salt']);
	if ($real_password === $hashedSaltedInput) {
		startSession($getData['user_id']);
	} else {
		header("Location: index.php");
		exit();
	}
?>