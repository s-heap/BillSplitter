<?php
	include('database.php');
	
	$email = strtolower($_GET['email']);
	$gname = $_GET['gname'];
	
	if (empty($email) || empty($gname)) {
		exit();
	}
	
	$db = new Database();
	
	$stmt = $db->prepare('SELECT group_id FROM groups WHERE group_title=:group_title');
	$stmt->bindValue(':group_title', $gname, SQLITE3_TEXT);
	$getData = $stmt->execute()->fetchArray();
	$group_id = $getData['group_id'];
	
	$stmt = $db->prepare('SELECT user_id FROM users WHERE user_email=:email');
	$stmt->bindValue(':email', $email, SQLITE3_TEXT);
	$getData = $stmt->execute()->fetchArray();
	$user_id = $getData['user_id'];
	
	$stmt = $db->prepare('SELECT * FROM group_relations WHERE (relation_user_id=:user_id AND relation_group_id=:group_id)');
	$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
	$stmt->bindValue(':group_id', $group_id, SQLITE3_INTEGER);
	$getData = $stmt->execute()->fetchArray();
	
	if ($getData == null) {
		echo '0';
		exit();
	}
	echo '1';
?>