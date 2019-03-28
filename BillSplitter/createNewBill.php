<?php
	include('database.php');
	
	$amount = $_GET['amount'];
	$gname = $_GET['gname'];
	$description = $_GET['description'];
	$user_id = $_GET['user_id'];
	
	if (empty($amount) || empty($gname) || empty($description) || empty($user_id)) {
		exit();
	}
	
	$db = new Database();
	
	$stmt = $db->prepare('SELECT group_id FROM groups WHERE group_title=:group_title');
	$stmt->bindValue(':group_title', $gname, SQLITE3_TEXT);
	$getData = $stmt->execute()->fetchArray();
	$group_id = $getData['group_id'];
	
	$stmt = $db->prepare('SELECT COUNT(*) as count FROM group_relations WHERE (relation_group_id=:relation_group_id AND relation_status=1)');
	$stmt->bindValue(':relation_group_id', $group_id, SQLITE3_INTEGER);
	$getData = $stmt->execute()->fetchArray();
	$count = $getData['count'];
	
	$cost = $amount / $count;
	
	$stmt = $db->prepare('SELECT * FROM group_relations WHERE (relation_group_id=:relation_group_id AND relation_status=1)');
	$stmt->bindValue(':relation_group_id', $group_id, SQLITE3_INTEGER);
	$getData = $stmt->execute();
	
	$date = date('Y-m-d h:i:sa');
	
	while(($row = $getData->fetchArray())) {
		if ($row['relation_user_id'] != $user_id) {
			$stmt = $db->prepare('INSERT INTO debts VALUES (NULL, :debt_holder_id, :debt_reciever_id, :debt_group_id, :debt_amount, :debt_description, 0, :debt_dateCreated, :debt_dateSettled)');
			$stmt->bindValue(':debt_holder_id', $row['relation_user_id'], SQLITE3_INTEGER);
			$stmt->bindValue(':debt_reciever_id', $user_id, SQLITE3_INTEGER);
			$stmt->bindValue(':debt_group_id', $group_id, SQLITE3_INTEGER);
			$stmt->bindValue(':debt_amount', (float) $cost, SQLITE3_FLOAT);
			$stmt->bindValue(':debt_description', $description, SQLITE3_TEXT);
			$stmt->bindValue(':debt_dateCreated', $date, SQLITE3_TEXT);
			$stmt->bindValue(':debt_dateSettled', NULL, SQLITE3_TEXT);
			$stmt->execute();
		}
	}
	echo $cost;
?>