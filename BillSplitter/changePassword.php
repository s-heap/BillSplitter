<?php
	include('database.php');
	
	$user_id = $_POST['changePassword_user_id'];
	$oldPassword = $_POST['current_password_input'];
	$newPassword = $_POST['new_password_input'];
	$vNewPassword = $_POST['confirm_new_password_input'];
	
	if (empty($user_id) || empty($oldPassword) || empty($newPassword) || empty($vNewPassword) || $vNewPassword !== $vNewPassword) {
		header('Location: settings.php');
		exit();
	}
	
	$db = new Database();
	$stmt = $db->prepare('SELECT * FROM users WHERE user_id=:user_id');
	$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
	$userData = $stmt->execute()->fetchArray();
	
	$salt = $userData['user_salt'];
	echo $salt;
	$hashedPassword = sha1($oldPassword);
	$hashedSaltedPassword = sha1($hashedPassword.$salt);
	if ($hashedSaltedPassword !== $userData['user_password']) {
		header("Location: settings.php");
		exit();
	}
	
	$newHashedPassword = sha1($newPassword);
	$newHashedSaltedPassword = sha1($newHashedPassword.$salt);
	
	$stmt = $db->prepare('UPDATE users SET user_password=:user_password WHERE user_id=:user_id');
	$stmt->bindValue(':user_password', $newHashedSaltedPassword, SQLITE3_TEXT);
	$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
	$stmt->execute();
	
	header("Location: settings.php");
?>