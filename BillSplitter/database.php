<?php
	class Database {
			
		private $database;
		
		function __construct() {
			$this->database = $this->getConnection();
		}
		
		function __destruct() {
			$this->database->close();
		}
		
		function exec($query) {
			$this->database->exec($query);
		}
		
		function query($query) {
			$result = $this->database->query($query);
			return $result;
		}
		
		function querySingle($query) {
			$result = $this->database->querySingle($query,true);
			return $result;
		}
		
		function prepare($query) {
			return $this->database->prepare($query);
		}
		
		function escapeString($string) {
			return $this->database->escapeString($string);
		}
		
		private function getConnection() {
			$conn = new SQLite3('BillSplitter.db');
			return $conn;
		}
	}
	
	function printSafe($string) {
		return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
	}
?>