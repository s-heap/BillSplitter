<?php
	function startSession($user_id) {
		$db = new Database();
		
		$stmt = $db->prepare('UPDATE users SET user_lastLogin=:lastLogin WHERE user_id=:id');
		$stmt->bindValue(':lastLogin', date('Y-m-d h:i:sa'), SQLITE3_TEXT);
		$stmt->bindValue(':id', $user_id, SQLITE3_INTEGER);
		$stmt->execute();
		
		$stmt = $db->prepare('SELECT * FROM users WHERE user_id=:id');
		$stmt->bindValue(':id', $user_id, SQLITE3_TEXT);
		$getData = $stmt->execute();
		while(($row = $getData->fetchArray())) {$getData = $row; break;}
		
		session_start();
		
		$_SESSION['user_id'] = $user_id;
		$_SESSION['user_email'] = $getData['user_email'];
		$_SESSION['user_name'] = $getData['user_name'];
		$_SESSION['user_lastLogin'] = $getData['user_lastLogin'];
		$_SESSION['user_dateCreated'] = $getData['user_dateCreated'];
		
		header("Location: home.php");
		exit();
	}
	
	function loggedIn() {
		if (!isset($_SESSION['user_id'])) {
			header("Location: logout.php");
			exit();
		}
	}
?>