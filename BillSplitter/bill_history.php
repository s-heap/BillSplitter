<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>History</title>
		<?php 
			include 'formatting.php';
			loadJS(__FILE__);
		?>
	</head>
	<body>
		<?php
			makeNavBar($_SESSION['user_name']);
			include('database.php');
			include('session.php');
			loggedIn();
		?>
		<?php
			$db = new Database();
			
			echo '
				<div class="heading">Loans Paid Off:</div>
				<b>
					<div class="rowElement">
						<div class="twentyPercentBlock">Debt To:</div>
						<div class="twentyPercentBlock">Description:</div>
						<div class="twentyPercentBlock">Amount:</div>
						<div class="twentyPercentBlock">Date Created:</div>
						<div class="twentyPercentBlock">Date Settled:</div>
					</div>
				</b>
			';
			
			$stmt = $db->prepare('SELECT * FROM debts WHERE (debt_holder_id=:debt_holder_id AND debt_status=3)');
			$stmt->bindValue(':debt_holder_id', $_SESSION['user_id'], SQLITE3_INTEGER);
			$debts = $stmt->execute();
			
			while ($currentDebt = $debts->fetchArray()) {
				$stmt = $db->prepare('SELECT * FROM users WHERE user_id=:debt_reciever_id');
				$stmt->bindValue(':debt_reciever_id', $currentDebt['debt_reciever_id'], SQLITE3_INTEGER);
				$currentUser = $stmt->execute()->fetchArray();
				$name = $currentUser['user_email'];
				if ($currentUser['user_name'] !== $name) {
					$name = $currentUser['user_name'].' ('.$currentUser['user_email'].')';
				}
				$dateCreated = date_parse($currentDebt['debt_dateCreated']);
				$dateCreatedString = $dateCreated['day'].'/'.$dateCreated['month'].'/'.$dateCreated['year'];
				
				$dateSettled = date_parse($currentDebt['debt_dateSettled']);
				$dateSettledString = $dateSettled['day'].'/'.$dateSettled['month'].'/'.$dateSettled['year'];
				echo '
					<div class="rowElement">
						<div class="twentyPercentBlock">'.printSafe($name).'</div>
						<div class="twentyPercentBlock">'.printSafe($currentDebt['debt_description']).'</div>
						<div class="twentyPercentBlock">£'.money_format('%.2n', $currentDebt['debt_amount']).'</div>
						<div class="twentyPercentBlock">'.$dateCreatedString.'</div>
						<div class="twentyPercentBlock">'.$dateSettledString.'</div>
					</div>
				';
			}
			
			echo '
				<div class="heading">Loans Collected:</div>
				<b>
					<div class="rowElement">
						<div class="twentyPercentBlock">Debt From:</div>
						<div class="twentyPercentBlock">Description:</div>
						<div class="twentyPercentBlock">Amount:</div>
						<div class="twentyPercentBlock">Date Created:</div>
						<div class="twentyPercentBlock">Date Settled:</div>
					</div>
				</b>
			';
			
			$stmt = $db->prepare('SELECT * FROM debts WHERE (debt_reciever_id=:debt_reciever_id AND debt_status=3)');
			$stmt->bindValue(':debt_reciever_id', $_SESSION['user_id'], SQLITE3_INTEGER);
			$debts = $stmt->execute();
			
			while ($currentDebt = $debts->fetchArray()) {
				$stmt = $db->prepare('SELECT * FROM users WHERE user_id=:debt_holder_id');
				$stmt->bindValue(':debt_holder_id', $currentDebt['debt_holder_id'], SQLITE3_INTEGER);
				$currentUser = $stmt->execute()->fetchArray();
				$name = $currentUser['user_email'];
				if ($currentUser['user_name'] !== $name) {
					$name = $currentUser['user_name'].' ('.$currentUser['user_email'].')';
				}
				$dateCreated = date_parse($currentDebt['debt_dateCreated']);
				$dateCreatedString = $dateCreated['day'].'/'.$dateCreated['month'].'/'.$dateCreated['year'];
				
				$dateSettled = date_parse($currentDebt['debt_dateSettled']);
				$dateSettledString = $dateSettled['day'].'/'.$dateSettled['month'].'/'.$dateSettled['year'];
				echo '
					<div class="rowElement">
						<div class="twentyPercentBlock">'.printSafe($name).'</div>
						<div class="twentyPercentBlock">&nbsp;'.printSafe($currentDebt['debt_description']).'</div>
						<div class="twentyPercentBlock">£'.money_format('%.2n', $currentDebt['debt_amount']).'</div>
						<div class="twentyPercentBlock">'.$dateCreatedString.'</div>
						<div class="twentyPercentBlock">'.$dateSettledString.'</div>
					</div>
				';
			}
		?>
	</body>
</html>
