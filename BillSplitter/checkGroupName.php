<?php
	include('database.php');
	
	$groupName = $_GET['groupName'];
	
	if (empty($groupName)) {
		exit();
	}
	
	$db = new Database();
	$groupQuery = 'SELECT group_title FROM groups';
	$groups = $db->query($groupQuery);
	while(($groupCheck = $groups->fetchArray())) {
		if (strtolower($groupName) == strtolower($groupCheck['group_title'])) {
			echo '1';
			exit();
		}
	}
	echo '0';
?>