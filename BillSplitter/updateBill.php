<?php
	include('database.php');
	
	$debt_id = $_GET['debt_id'];
	$status = $_GET['status'];
	
	$db = new Database();
	
	$stmt = $db->prepare('UPDATE debts SET debt_status=:debt_status WHERE debt_id=:debt_id');
	if ($status == 3) {
		$stmt = $db->prepare('UPDATE debts SET debt_status=:debt_status, debt_dateSettled=:debt_dateSettled WHERE debt_id=:debt_id');
		$stmt->bindValue(':debt_dateSettled', date('Y-m-d h:i:sa'), SQLITE3_TEXT);
	}
	$stmt->bindValue(':debt_status', $status, SQLITE3_INTEGER);
	$stmt->bindValue(':debt_id', $debt_id, SQLITE3_INTEGER);
	$stmt->execute();
?>