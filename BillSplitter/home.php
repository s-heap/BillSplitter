<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Bills</title>
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
				<div class="heading">Current Debts:</div>
				<b>
					<div class="rowElement">
						<div class="twentyPercentBlock">Debt To:</div>
						<div class="twentyPercentBlock">Group Name:</div>
						<div class="twentyPercentBlock">Description:</div>
						<div class="tenPercentBlock">Amount:</div>
					</div>
				</b>
				<div id="currentDebts">
			';
			
			$stmt = $db->prepare('SELECT * FROM debts WHERE (debt_holder_id=:debt_holder_id AND debt_status=0)');
			$stmt->bindValue(':debt_holder_id', $_SESSION['user_id'], SQLITE3_INTEGER);
			$debts = $stmt->execute();
				while ($currentDebt = $debts->fetchArray()) {
				$stmt = $db->prepare('SELECT * FROM users WHERE user_id=:debt_reciever_id');
				$stmt->bindValue(':debt_reciever_id', $currentDebt['debt_reciever_id'], SQLITE3_INTEGER);
				$currentUser = $stmt->execute()->fetchArray();
				
				$stmt = $db->prepare('SELECT * FROM groups WHERE group_id=:group_id');
				$stmt->bindValue(':group_id', $currentDebt['debt_group_id'], SQLITE3_INTEGER);
				$currentGroup = $stmt->execute()->fetchArray();
				
				$name = $currentUser['user_email'];
				if ($currentUser['user_name'] !== $name) {
					$name = $currentUser['user_name'].' ('.$currentUser['user_email'].')';
				}
				
				echo '
					<div class="rowElement">
						<div class="twentyPercentBlock">'.printSafe($name).'</div>
						<div class="twentyPercentBlock">'.printSafe($currentGroup['group_title']).'&nbsp</div>
						<div class="twentyPercentBlock">'.printSafe($currentDebt['debt_description']).'&nbsp</div>
						<div class="tenPercentBlock">£'.money_format('%.2n', $currentDebt['debt_amount']).'</div>
						<div class="wordButtonBlock">
							<div class="declineDebtButton" debt_id="'.$currentDebt['debt_id'].'">
								<div class="navButton">
									<a href="#">Decline Debt</a>
								</div>
							</div>
						</div>	
						<div class="wordButtonBlock">
							<div class="acceptDebtButton" debt_id="'.$currentDebt['debt_id'].'">
								<div class="navButton">
									<a href="#">Accept Debt</a>
								</div>
							</div>
						</div>		
					</div>
				';
			}
			$stmt = $db->prepare('SELECT * FROM debts WHERE (debt_holder_id=:debt_holder_id AND debt_status=1)');
			$stmt->bindValue(':debt_holder_id', $_SESSION['user_id'], SQLITE3_INTEGER);
			$debts = $stmt->execute();
			
			while ($currentDebt = $debts->fetchArray()) {
				$stmt = $db->prepare('SELECT * FROM users WHERE user_id=:debt_reciever_id');
				$stmt->bindValue(':debt_reciever_id', $currentDebt['debt_reciever_id'], SQLITE3_INTEGER);
				$currentUser = $stmt->execute()->fetchArray();
				
				$stmt = $db->prepare('SELECT * FROM groups WHERE group_id=:group_id');
				$stmt->bindValue(':group_id', $currentDebt['debt_group_id'], SQLITE3_INTEGER);
				$currentGroup = $stmt->execute()->fetchArray();
				
				$name = $currentUser['user_email'];
				if ($currentUser['user_name'] !== $name) {
					$name = $currentUser['user_name'].' ('.$currentUser['user_email'].')';
				}
				
				echo '
					<div class="rowElement">
					<div class="twentyPercentBlock">'.printSafe($name).'</div>
						<div class="twentyPercentBlock">'.printSafe($currentGroup['group_title']).'&nbsp</div>
						<div class="twentyPercentBlock">'.printSafe($currentDebt['debt_description']).'&nbsp</div>
						<div class="tenPercentBlock">£'.money_format('%.2n', $currentDebt['debt_amount']).'</div>
						<div class="wordButtonBlock">
							<div class="payDebtButton" debt_id="'.$currentDebt['debt_id'].'">
								<div class="navButton">
									<a href="#">Pay Debt</a>
								</div>
							</div>
						</div>		
					</div>
				';
			}
			echo '</div>';
			
			
			
			
			
			
			echo '
				<div class="heading">Monies Owed:</div>
				<b>
					<div class="rowElement">
						<div class="twentyPercentBlock">Debt From:</div>
						<div class="twentyPercentBlock">Group Name:</div>
						<div class="twentyPercentBlock">Description:</div>
						<div class="tenPercentBlock">Amount:</div>
						<div class="wordButtonBlock">Bill Status:</div>
					</div>
				</b><div id="currentLoans">
			';
			
			$stmt = $db->prepare('SELECT * FROM debts WHERE (debt_reciever_id=:debt_reciever_id AND debt_status=0)');
			$stmt->bindValue(':debt_reciever_id', $_SESSION['user_id'], SQLITE3_INTEGER);
			$debts = $stmt->execute();
			
			while ($currentDebt = $debts->fetchArray()) {
				$stmt = $db->prepare('SELECT * FROM users WHERE user_id=:debt_holder_id');
				$stmt->bindValue(':debt_holder_id', $currentDebt['debt_holder_id'], SQLITE3_INTEGER);
				$currentUser = $stmt->execute()->fetchArray();
				
				$stmt = $db->prepare('SELECT * FROM groups WHERE group_id=:group_id');
				$stmt->bindValue(':group_id', $currentDebt['debt_group_id'], SQLITE3_INTEGER);
				$currentGroup = $stmt->execute()->fetchArray();
				
				$name = $currentUser['user_email'];
				if ($currentUser['user_name'] !== $name) {
					$name = $currentUser['user_name'].' ('.$currentUser['user_email'].')';
				}
				
				echo '
					<div class="rowElement">
						<div class="twentyPercentBlock">'.printSafe($name).'</div>
						<div class="twentyPercentBlock">'.printSafe($currentGroup['group_title']).'&nbsp</div>
						<div class="twentyPercentBlock">'.printSafe($currentDebt['debt_description']).'&nbsp</div>
						<div class="tenPercentBlock">£'.money_format('%.2n', $currentDebt['debt_amount']).'</div>	
						<div class></div>
						<div class="wordButtonBlock">Awaiting Acceptance</div>
					</div>
				';
			}
			$stmt = $db->prepare('SELECT * FROM debts WHERE (debt_reciever_id=:debt_reciever_id AND debt_status=1)');
			$stmt->bindValue(':debt_reciever_id', $_SESSION['user_id'], SQLITE3_INTEGER);
			$debts = $stmt->execute();
			
			while ($currentDebt = $debts->fetchArray()) {
				$stmt = $db->prepare('SELECT * FROM users WHERE user_id=:debt_holder_id');
				$stmt->bindValue(':debt_holder_id', $currentDebt['debt_holder_id'], SQLITE3_INTEGER);
				$currentUser = $stmt->execute()->fetchArray();
				
				$stmt = $db->prepare('SELECT * FROM groups WHERE group_id=:group_id');
				$stmt->bindValue(':group_id', $currentDebt['debt_group_id'], SQLITE3_INTEGER);
				$currentGroup = $stmt->execute()->fetchArray();
				
				$name = $currentUser['user_email'];
				if ($currentUser['user_name'] !== $name) {
					$name = $currentUser['user_name'].' ('.$currentUser['user_email'].')';
				}
				
				echo '
					<div class="rowElement">
						<div class="twentyPercentBlock">'.printSafe($name).'</div>
						<div class="twentyPercentBlock">'.printSafe($currentGroup['group_title']).'&nbsp</div>
						<div class="twentyPercentBlock">'.printSafe($currentDebt['debt_description']).'&nbsp</div>
						<div class="tenPercentBlock">£'.money_format('%.2n', $currentDebt['debt_amount']).'</div>	
						<div class></div>
						<div class="wordButtonBlock">Awaiting Payment</div>
					</div>
				';
			}
			$stmt = $db->prepare('SELECT * FROM debts WHERE (debt_reciever_id=:debt_reciever_id AND debt_status=4)');
			$stmt->bindValue(':debt_reciever_id', $_SESSION['user_id'], SQLITE3_INTEGER);
			$debts = $stmt->execute();
			
			while ($currentDebt = $debts->fetchArray()) {
				$stmt = $db->prepare('SELECT * FROM users WHERE user_id=:debt_holder_id');
				$stmt->bindValue(':debt_holder_id', $currentDebt['debt_holder_id'], SQLITE3_INTEGER);
				$currentUser = $stmt->execute()->fetchArray();
				
				$stmt = $db->prepare('SELECT * FROM groups WHERE group_id=:group_id');
				$stmt->bindValue(':group_id', $currentDebt['debt_group_id'], SQLITE3_INTEGER);
				$currentGroup = $stmt->execute()->fetchArray();
				
				$name = $currentUser['user_email'];
				if ($currentUser['user_name'] !== $name) {
					$name = $currentUser['user_name'].' ('.$currentUser['user_email'].')';
				}
				
				echo '
					<div class="rowElement">
						<div class="twentyPercentBlock">'.printSafe($name).'</div>
						<div class="twentyPercentBlock">'.printSafe($currentGroup['group_title']).'&nbsp</div>
						<div class="twentyPercentBlock">'.printSafe($currentDebt['debt_description']).'&nbsp</div>
						<div class="tenPercentBlock">£'.money_format('%.2n', $currentDebt['debt_amount']).'</div>	
						<div class></div>
						<div class="wordButtonBlock">
							User Declined:<br>
							
							<div class="wordButtonBlock">
								<div class="resendBillButton" debt_id="'.$currentDebt['debt_id'].'">
									<div class="navButton">
										<a href="#">Resend</a>
									</div>
								</div>
							</div>
							<div class="wordButtonBlock">
								<div class="deleteBillButton" debt_id="'.$currentDebt['debt_id'].'">
									<div class="navButton">
										<a href="#">Delete</a>
									</div>
								</div>
							</div>	
						</div>
						
					</div>
				';
			}
			echo '</div>';
			
			
			
			
			
			
			
			echo '
				<div class="heading">Payments Pending Confirmation:</div>
				<b>
					<div class="rowElement">
						<div class="twentyPercentBlock">Debt From:</div>
						<div class="twentyPercentBlock">Group Name:</div>
						<div class="twentyPercentBlock">Description:</div>
						<div class="tenPercentBlock">Amount:</div>
					</div>
				</b>
				<div id="currentConfirmations">
			';
			
			$stmt = $db->prepare('SELECT * FROM debts WHERE (debt_reciever_id=:debt_reciever_id AND debt_status=2)');
			$stmt->bindValue(':debt_reciever_id', $_SESSION['user_id'], SQLITE3_INTEGER);
			$debts = $stmt->execute();
			
			while ($currentDebt = $debts->fetchArray()) {
				$stmt = $db->prepare('SELECT * FROM users WHERE user_id=:debt_holder_id');
				$stmt->bindValue(':debt_holder_id', $currentDebt['debt_holder_id'], SQLITE3_INTEGER);
				$currentUser = $stmt->execute()->fetchArray();
				
				$stmt = $db->prepare('SELECT * FROM groups WHERE group_id=:group_id');
				$stmt->bindValue(':group_id', $currentDebt['debt_group_id'], SQLITE3_INTEGER);
				$currentGroup = $stmt->execute()->fetchArray();
				
				$name = $currentUser['user_email'];
				if ($currentUser['user_name'] !== $name) {
					$name = $currentUser['user_name'].' ('.$currentUser['user_email'].')';
				}
				
				echo '
					<div class="rowElement">
						<div class="twentyPercentBlock">'.printSafe($name).'</div>
						<div class="twentyPercentBlock">'.printSafe($currentGroup['group_title']).'&nbsp</div>
						<div class="twentyPercentBlock">'.printSafe($currentDebt['debt_description']).'&nbsp</div>
						<div class="tenPercentBlock">£'.money_format('%.2n', $currentDebt['debt_amount']).'</div>
						<div class="wordButtonBlock">
							<div class="wordButtonBlock">
								<div class="acceptPaymentButton" debt_id="'.$currentDebt['debt_id'].'">
									<div class="navButton">
										<a href="#">Accept Payment</a>
									</div>
								</div>
							</div><br>
							<div class="wordButtonBlock">
								<div class="declinePaymentButton" debt_id="'.$currentDebt['debt_id'].'">
									<div class="navButton">
										<a href="#">Decline Payment</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				';
			}
			echo '</div>';
		?>
	</body>
</html>
