<?php
	include('database.php');
	
	$user_email = strtolower($_GET['user_email']);
	$group_title = $_GET['group_title'];
	$message = $_GET['message'];
	
	if (empty($user_email) || empty($group_title)) {
		exit();
	}
	
	$db = new Database();
	$stmt = $db->prepare('SELECT * FROM users WHERE user_email=:email');
	$stmt->bindValue(':email', $user_email, SQLITE3_TEXT);
	$getData = $stmt->execute()->fetchArray();
	
	if ($getData == null) {
		exit();
	}
	
	$stmt = $db->prepare('SELECT group_id FROM groups WHERE group_title=:title');
	$stmt->bindValue(':title', $group_title, SQLITE3_TEXT);
	$getData = $stmt->execute()->fetchArray();
	$group_id = $getData['group_id'];
	
	$stmt = $db->prepare('SELECT user_id FROM users WHERE user_email=:user_email');
	$stmt->bindValue(':user_email', $user_email, SQLITE3_TEXT);
	$getData = $stmt->execute()->fetchArray();
	$user_id = $getData['user_id'];
	
	$date = date('Y-m-d h:i:sa');
	
	$stmt = $db->prepare('INSERT INTO group_relations VALUES (:user_id, :group_id, :date_created, :message, 0)');
	$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
	$stmt->bindValue(':group_id', $group_id, SQLITE3_INTEGER);
	$stmt->bindValue(':date_created', $date, SQLITE3_TEXT);
	$stmt->bindValue(':message', $message, SQLITE3_TEXT);
	$stmt->execute();
?>
