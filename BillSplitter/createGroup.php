<?php
	include('database.php');
	include('session.php');
	
	$gname = $_GET['gname_input'];
	$gdesc = $_GET['gdesc_input'];
	$user_id = $_GET['user_id'];
	$isJS = $_GET['isJS'];
	
	if ((empty($gname) || empty($user_id))){
		if ($isJS == '1') {
			header('Location: group_overview.php');
		}
		exit();
	}
	
	$db = new Database();
	$groupTitleQuery = 'SELECT group_title FROM groups';
	$groupTitles = $db->query($groupTitleQuery);
	while(($titlesCheck = $groupTitles->fetchArray())) {
		if (strtolower($gname) === strtolower($titlesCheck['group_title'])) {
			if ($isJS == '1') {
				header('Location: group_overview.php');
			}
			exit();
		}
	}
	
	$date = date('Y-m-d h:i:sa');
	
	$stmt = $db->prepare('INSERT INTO groups VALUES (NULL, :title, :description, :dateCreated)');
	$stmt->bindValue(':title', $gname, SQLITE3_TEXT);
	$stmt->bindValue(':description', $gdesc, SQLITE3_TEXT);
	$stmt->bindValue(':dateCreated', $date, SQLITE3_TEXT);
	$stmt->execute();
	
	$stmt = $db->prepare('SELECT group_id FROM groups WHERE group_title=:title');
	$stmt->bindValue(':title', $gname, SQLITE3_TEXT);
	$getData = $stmt->execute()->fetchArray();
	
	$stmt = $db->prepare('INSERT INTO group_relations VALUES (:user_id, :group_id, :dateCreated, "", 1)');
	$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
	$stmt->bindValue(':group_id', $getData['group_id'], SQLITE3_INTEGER);
	$stmt->bindValue(':dateCreated', $date, SQLITE3_TEXT);
	$stmt->execute();

	if ($isJS == '0') {
		header("Location: group_overview.php");
		exit();
	}
?>