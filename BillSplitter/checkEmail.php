<?php
	include('database.php');
	
	$email = $_GET['email'];
	
	if (empty($email)) {
		exit();
	}
	
	$db = new Database();
	$stmt = $db->prepare('SELECT * FROM users WHERE user_email=:email');
	$stmt->bindValue(':email', strtolower($email), SQLITE3_TEXT);
	$getData = $stmt->execute()->fetchArray();
	
	if ($getData == null) {
		echo '0';
		exit();
	}
	echo '1';
?>