<?php
	session_start();
	include('database.php');
	
	$email = strtolower($_POST['email_input']);
	$user_id = $_POST['changeEmail_user_id'];
	
	if (empty($email)){
		header('Location: settings.php');
		exit();
	}
	
	$db = new Database();
	$emailQuery = 'SELECT user_email FROM users';
	$emails = $db->query($emailQuery);
	while(($emailCheck = $emails->fetchArray())) {
		if ($email == $emailCheck['user_email']) {
			header('Location: settings.php');
			exit();
		}
	}
	
	$stmt = $db->prepare('SELECT user_email, user_name FROM users WHERE user_id=:user_id');
	$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
	$userData = $stmt->execute()->fetchArray();
	
	$stmt = $db->prepare('UPDATE users SET user_email=:user_email WHERE user_id=:user_id');
	if ($userData['user_name'] === $userData['user_email']) {
		$stmt = $db->prepare('UPDATE users SET user_email=:user_email, user_name=:user_email WHERE user_id=:user_id');
		$_SESSION['user_name'] = $email;
	}
	$stmt->bindValue(':user_email', $email, SQLITE3_TEXT);
	$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
	$stmt->execute();
	
	$_SESSION['user_email'] = $email;
	header("Location: settings.php");
?>