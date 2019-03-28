<?php
	include 'printGroupFunction.php';
	include 'database.php';
	$gname = $_GET['gname'];
	echo getGroupTableRow($gname);
?>