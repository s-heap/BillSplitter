<?php
	session_start();
	include('database.php');
	
	$user_id = $_POST['changeUserName_user_id'];
	$user_name = $_POST['new_user_name'];
	
	if (empty($user_id) || empty($user_name)) {
		header('Location: settings.php');
		exit();
	}
	
	$db = new Database();
	
	$stmt = $db->prepare('UPDATE users SET user_name=:user_name WHERE user_id=:user_id');
	$stmt->bindValue(':user_name', $user_name, SQLITE3_TEXT);
	$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
	$stmt->execute();
	
	$_SESSION['user_name'] = $user_name;
	header("Location: settings.php");
?>