<?php
	function getGroupTableRow($gname) {
		$db = new Database();
		
		$stmt = $db->prepare('SELECT * FROM groups WHERE group_title=:groupName');
		$stmt->bindValue(':groupName', $gname, SQLITE3_TEXT);
		$currentGroupData = $stmt->execute()->fetchArray();
		
		$groupDescription = printSafe($currentGroupData['group_description']);
		$groupCreationDate = date_parse($currentGroupData['group_dateCreated']);
		$groupCreationDateString = $groupCreationDate['day'].'/'.$groupCreationDate['month'].'/'.$groupCreationDate['year'];
		$group_id = $currentGroupData['group_id'];
		$groupAcceptedMemberList = '';
		$groupPendingMemberList = '';
		
		$stmt = $db->prepare('SELECT * FROM group_relations WHERE relation_group_id=:group_id');
		$stmt->bindValue(':group_id', $group_id, SQLITE3_INTEGER);
		$getData = $stmt->execute();
		
		while ($currentRelation = $getData->fetchArray()) {
			$stmt = $db->prepare('SELECT * FROM users WHERE user_id=:user_id');
			$stmt->bindValue(':user_id', $currentRelation['relation_user_id'], SQLITE3_TEXT);
			$currentUser = $stmt->execute()->fetchArray();
			$name = printSafe($currentUser['user_email']);
			if ($currentUser['user_name'] !== $name) {
				$name = printSafe($currentUser['user_name'].' ('.$currentUser['user_email'].')');
			}
			if ($currentRelation['relation_status'] == 1) {
				$groupAcceptedMemberList = $groupAcceptedMemberList.$name.'<br>';
			} else {
				$groupPendingMemberList = $groupPendingMemberList.$name.'<br>';
			}
		}
		if ($groupPendingMemberList != '') {
			$groupPendingMemberList = '<b>Pending Members:</b><br>'.$groupPendingMemberList;
		}
		$groupAcceptedMemberList = '<b>Current Members:</b><br>'.$groupAcceptedMemberList;
		
		$outputString = '
			<div class="groupElementWrapper">
				<div class="rowElement">
					<div class="descriptionBlock">
						<b><div class="group_title_div" gname="'.$gname.'">'.printSafe($gname).'</div></b>
					</div>
					<div class="characterButtonBlock">
						<div class="dropDownButton" visible="true">
							<div class="navButton">
								<a href="#">&#x25BC</a>
							</div>
						</div>
					</div>
					<div class="wordButtonBlock">
						<div class="addUsersButton">
							<div class="navButton">
								<a href="#">Add New User</a>
							</div>
						</div>
					</div>
					<div class="wordButtonBlock">
						<div class="createBillButton">
							<div class="navButton">
								<a href="#">Create Bill</a>
							</div>
						</div>
					</div>					
				</div>
				<div class="dropDownElement">
					<div class="descriptionBlock">
						<div class="group_accepted_members">'.$groupAcceptedMemberList.'</div>
						<div class="group_pending_members">'.$groupPendingMemberList.'</div>
					</div>
					<div class="descriptionBlock">
						<b>Description:</b><br><div class="group_description_div">'.$groupDescription.'</div><br><br>
						<b>Date Created:</b> '.$groupCreationDateString.'
					</div>
				</div>
			</div>
		';
		
		return $outputString;
	}
?>