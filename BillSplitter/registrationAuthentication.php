<?php
	include('database.php');
	include('session.php');
	
	$email = $_POST['email_input'];
	$password = $_POST['password_input'];
	$vpassword = $_POST['vpassword_input'];
	
	if (empty($email) || empty($password) || empty($vpassword) || $password != $vpassword){
		header('Location: register.php');
		exit();
	}
	
	$db = new Database();
	$emailQuery = 'SELECT user_email FROM users';
	$emails = $db->query($emailQuery);
	while(($emailCheck = $emails->fetchArray())) {
		if (strtolower($email) == $emailCheck['user_email']) {
			header('Location: register.php');
			exit();
		}
	}
	
	$salt = uniqid(mt_rand(), true);
	$hashedPassword = sha1($password);
	$hashedSaltedPassword = sha1($hashedPassword.$salt);
	$time = date('Y-m-d h:i:sa');
	
	$stmt = $db->prepare('INSERT INTO users VALUES (NULL, :email, :password, :salt, :username, :lastLogin, :dateCreated)');
	$stmt->bindValue(':email', strtolower($email), SQLITE3_TEXT);
	$stmt->bindValue(':password', $hashedSaltedPassword, SQLITE3_TEXT);
	$stmt->bindValue(':salt', $salt, SQLITE3_TEXT);
	$stmt->bindValue(':username', strtolower($email), SQLITE3_TEXT);
	$stmt->bindValue(':lastLogin', $time, SQLITE3_TEXT);
	$stmt->bindValue(':dateCreated', $time, SQLITE3_TEXT);
	$stmt->execute();
	
	$stmt = $db->prepare('SELECT user_id FROM users WHERE user_email=:email');
	$stmt->bindValue(':email', $email, SQLITE3_TEXT);
	$getData = $stmt->execute()->fetchArray();
	
	startSession($getData['user_id']);
?>