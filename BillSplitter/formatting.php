<?php
	echo '
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="billSplitter_style.css">
		<div id="header">Bill Splitter</div>
		<div id="footer">&nbsp</div>
	';
	
	function makeNavBar($name) {
		echo '
			<div id="navigation">
				<div class="navButton"><a href="home.php">Bill Overview</a></div>
				<div class="navButton"><a href="group_overview.php">Groups</a></div>
				<div class="navButton"><a href="bill_history.php">History</a></div>
				<div class="navButton" id="right"><a href="logout.php">Logout '.$name.'</a></div>
				<div class="navButton" id="right"><a href="settings.php">Settings</a></div>
			</div>
		';
	}
	
	function loadJS($filename) {
		echo '
			<script src="js/jquery-3.3.1.js"></script>
			<script src="js/functions.js"></script>
			<script src="js/'.basename($filename, '.php').'.js"></script>
		';
	}
?>