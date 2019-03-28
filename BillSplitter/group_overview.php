<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Groups</title>
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
			include 'printGroupFunction.php';
			loggedIn();
		?>
		<div class='heading'>Current Groups:</div>
		<?php
			$db = new Database();
			$stmt = $db->prepare('SELECT relation_group_id FROM group_relations WHERE (relation_user_id=:user_id AND relation_status=1)');
			$stmt->bindValue(':user_id', $_SESSION['user_id'], SQLITE3_INTEGER);
			$getGroupIDs = $stmt->execute();
			
			echo '
				<b>
					<div class="rowElement">
						<div class="titleBlock">Group Name:</div>
					</div>
				</b>
			';
			
			
			echo '<div id="currentGroups">';
			while(($row = $getGroupIDs->fetchArray())) {
				$stmt = $db->prepare('SELECT * FROM groups WHERE group_id=:group_id');
				$stmt->bindValue(':group_id', $row['relation_group_id'], SQLITE3_INTEGER);
				$currentGroupData = $stmt->execute()->fetchArray();
				echo getGroupTableRow($currentGroupData['group_title']);
			}
			echo '</div>';
			
			
			
			echo '
				<div id="centerBox">
					<form action="createGroup.php" method="get" id="createGroupForm">
						<div class="heading">
							Create New Group:
						</div>
						Group Name:
						<input class="text" type="text" name="gname_input" id="gname_input" required><br>
						<div id="groupNameError"></div>
						Group Description:
						<input class="text" type="text" name="gdesc_input" id="gdesc_input"><br>
						<div id="error"></div>
						<input type="hidden" value="'.$_SESSION['user_id'].'" name ="user_id" id="user_id">
						<input type="hidden" value="0" id="isJS" name="isJS">
						<input class="button" type="submit" value="Create"><br>
					</form>
				</div>
			';
			
			
			
			
			$stmt = $db->prepare('SELECT * FROM group_relations WHERE (relation_user_id=:user_id AND relation_status=0)');
			$stmt->bindValue(':user_id', $_SESSION['user_id'], SQLITE3_INTEGER);
			$getGroupRequestsIDs = $stmt->execute();
			$RequestsCheck = $stmt->execute()->fetchArray();
			
			if ($RequestsCheck != null) {
				echo '<div class="heading">Group Join Requests:</div>';
				
				echo '
					<b>
						<div class="rowElement">
							<div class="titleBlock">Group Name:</div>
							<div class="titleBlock">Message:</div>
							<div class="titleBlock">Date Invited:</div>
						</div>
					</b>
				';
				
				echo '<div id="currentGroupRequests">';
				while(($row = $getGroupRequestsIDs->fetchArray())) {
					$stmt = $db->prepare('SELECT * FROM groups WHERE group_id=:group_id');
					$stmt->bindValue(':group_id', $row['relation_group_id'], SQLITE3_INTEGER);
					$currentGroupData = $stmt->execute()->fetchArray();
					$date = date_parse($row['relation_dateCreated']);
					echo '
						<div class="rowElement">
							<div class="titleBlock">
								<div class="request_group_title_div" gname="'.$currentGroupData['group_title'].'">'.printSafe($currentGroupData['group_title']).'</div>
							</div>
							<div class="titleBlock">'.printSafe($row['relation_message']).'</div>
							<div class="wordButtonBlock">
								<div class="acceptRequestButton" groupID="'.$row['relation_group_id'].'" userID="'.$row['relation_user_id'].'" groupDescription="'.$currentGroupData['group_description'].'">
									<div class="navButton">
										<a href="#">Accept</a>
									</div>
								</div>
							</div>
							<div class="titleBlock">
								'.$date['day'].'/'.$date['month'].'/'.$date['year'].'
							</div>
						</div>					
					';
					
				}
				echo '</div>';
			}
			
		?>
		
	</body>
	
	<div class='modalBackground' id='addUserModal'>
		<div class='modalContent'>
			<div  class='bigText' class='rowElement'>
				<div class='allButCloseBlock' id='addUserModalTitle'>
					Invite a new user to:
				</div>
				<div  class="modalClose" id='addUserModalClose'>
					&times;
				</div>
			</div>
			<div class='centerAlign'>
				<form id='addUserForm' gname=''>
					Email Address:
					<input class='text' type='email' name='email' id='email_input' required><br>
					<div id='emailError'></div>
					Send an invitation message:
					<input class='text' type='text' name='message' id='message_input'><br>
					<input class='button' type='submit' value='Add User'><br>
				</form>
			</div>
		</div>
	</div>
	
	<div class='modalBackground' id='createBillModal'>
		<div class='modalContent'>
			<div  class='bigText' class='rowElement'>
				<div class='allButCloseBlock' id='createBillModalTitle'>
					Create a new bill:
				</div>
				<div  class="modalClose" id='createBillModalClose'>
					&times;
				</div>
			</div>
			<div class='centerAlign'>
				<form id='createBillForm' gname=''>
					Bill Description:
					<input class='text' type='text' name='billDescription' id='billDescription' required><br>
					Amount:
					<input class='text' type='number' step='0.01' min='1.00' name='billAmount' id='billAmount' required><br>
					<input class='button' type='submit' value='Create Bill'><br>
				</form>
			</div>
		</div>
	</div>
</html>
