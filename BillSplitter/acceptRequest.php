<?php
	include('database.php');
	
	$user_id = $_GET['relation_user_id'];
	$group_id = $_GET['relation_group_id'];
	
	$db = new Database();
	$stmt = $db->prepare("UPDATE group_relations SET relation_status=1 WHERE (relation_user_id=:relation_user_id AND relation_group_id=:relation_group_id)");
	$stmt->bindValue(':relation_user_id', $user_id, SQLITE3_INTEGER);
	$stmt->bindValue(':relation_group_id', $group_id, SQLITE3_INTEGER);
	$stmt->execute();
?>