$(document).ready( function() { 
	console.log('Javascript loaded my friend');
	$('#addUserModal').hide();
	$('#createBillModal').hide();
	
	
	$('.dropDownButton').each(function() {
		$(this).find('a').html('&#x25C4');
		$(this).parent().parent().parent().find('.dropDownElement').hide();
		$(this).attr('visible', 'false') 
	});
	
	$('#currentGroups').on('click', '.dropDownButton', function() {
		if ($(this).attr('visible') == 'true') {
			$(this).find('a').html('&#x25C4');
			$(this).parent().parent().parent().find('.dropDownElement').slideUp();
			$(this).attr('visible', 'false') 
		} else {
			$(this).find('a').html('&#x25BC');
			$(this).parent().parent().parent().find('.dropDownElement').slideDown();
			$(this).attr('visible', 'true') 
		}
	});
	
	$('#currentGroups').on('click', '.addUsersButton', function() {
		$('#addUserModal').fadeIn();
		gname = $(this).parent().parent().find('.group_title_div').attr('gname');
		$('#addUserForm').attr('gname', gname);
		$('#addUserModalTitle').html('Invite a new user to: <br>' + gname);
		
	});
	
	$('#currentGroupRequests').on('click', '.acceptRequestButton', function() {
		acceptRequest($(this).attr('userID'), $(this).attr('groupID'), 1);
		appendNewGroupElement($(this).parent().parent().find('.request_group_title_div').attr('gname'))
		$(this).parent().parent().fadeOut(1000);

	});
	
	$('#currentGroups').on('click', '.createBillButton', function() {
		$('#createBillModal').fadeIn();
		gname = $(this).parent().parent().find('.group_title_div').attr('gname');
		$('#createBillForm').attr('gname', gname);
		$('#createBillModalTitle').html('Create a new bill for: <br>' + gname);
	});
	
	$('#email_input').change(function() {
		$('#emailError').empty();
		resetFormError('#email_input');
		isEmailRegistered($('#email_input').val(), function() {
			checkIsMemberOfGroup($('#email_input').val(), $('#addUserForm').attr('gname'), function() {
				$('#emailError').html('That user is already a member of the group.<br>');
				setFormError('#email_input')
			}, function() {});
		}, function(){
			$('#emailError').html('Please enter a registered email address.<br>');
			setFormError('#email_input')
		}, true);
		
	});
	
	$('#addUserForm').submit(function() {
		
		if ($('#emailError').html() !== '') {
			return false;
		}
		
		isEmailRegistered($('#email_input').val(), function() {
			checkIsMemberOfGroup($('#email_input').val(), $('#addUserForm').attr('gname'), function() {
				$('#emailError').html('That user is already a member of the group.<br>');
				setFormError('#email_input')
			}, function() {}, false);
		}, function(){
			$('#emailError').html('Please enter a registered email address.<br>');
			setFormError('#email_input')
		}, false);
		
		if ($('#emailError').html() !== '') {
			return false;
		}
		
		addUserToGroup($('#email_input').val(), $('#addUserForm').attr('gname'), $('#message_input').val());
		$('.group_title_div').each(function() {
			if ($(this).attr('gname') == $('#addUserForm').attr('gname')) {
				pendingMembers = $(this).parent().parent().parent().parent().find('.group_pending_members');
				if (pendingMembers.html() == '') {
					pendingMembers.html('<b>Pending Members:</b><br>' + $('#email_input').val().toLowerCase() + '<br>');
				} else {
					pendingMembers.append($('#email_input').val().toLowerCase() + '<br>');
				}
			}
		});
		$('#addUserModal').fadeOut(1000);
		$('#email_input').val('');
		$('#message_input').val('');
			
		return false;
	});
	
	$('#createBillForm').submit(function() {	
		createNewBill($('#billAmount').val(), $('#createBillForm').attr('gname'), $('#billDescription').val() , $('#user_id').val());
		
		$('#createBillModal').fadeOut(1000);
		$('#billDescription').val('');
		$('#billAmount').val('');
		
		return false;
	});
	
	$('#createBillModalClose').click(function() {
		$('#createBillModal').fadeOut();
	});
	
	$('#addUserModalClose').click(function() {
		$('#addUserModal').fadeOut();
	});
	
	$('#gname_input').change(function() {
		$('#groupNameError').empty();
		resetFormError('#gname_input')
		isGroupNameRegistered($('#gname_input').val(), function() {
			$('#groupNameError').html('Please enter an unregistered group name.<br>');
			setFormError('#gname_input')
		}, function() {}, true);
	});
	
	$('#createGroupForm').submit(function() {
		
		if ($('#groupNameError').html() !== '') {
			return false;
		}
		
		isGroupNameRegistered($('#gname_input').val(), function() {
			$('#groupNameError').html('Please enter an unregistered group name.<br>');
			setFormError('#gname_input')
		}, function() {}, false);
		
		if ($('#groupNameError').html() !== '') {
			return false;
		}
		
		addGroup($('#gname_input').val(), $('#gdesc_input').val(), $('#user_id').val());
		return false;
	});
	
});

function addGroup(groupName, groupDescription, user_id) {
	$.ajax({
		url: "createGroup.php",
		contentType: "application/json; charset=utf-8",
		data: {
			'gname_input': groupName,
			'gdesc_input': groupDescription,
			'user_id': user_id,
			'isJS': 1,
		},
		success: function(){
			appendNewGroupElement(groupName);
		}
	});
}

function appendNewGroupElement(gname) {
	$.ajax({
		url: "getGroupPrintable.php",
		contentType: "application/json; charset=utf-8",
		data: {
			'gname': gname,
		},
		success: function(response){
			$('#currentGroups').append(response);
		}
	});
}

function addUserToGroup(user_email, group_title, message) {
	$.ajax({
		url: "addMember.php",
		contentType: "application/json; charset=utf-8",
		data: {
			'user_email': user_email,
			'group_title': group_title,
			'message': message,
		}
	});
}

function acceptRequest(relation_user_id, relation_group_id) {
	$.ajax({
		url: "acceptRequest.php",
		contentType: "applicheckGroupNameInputcation/json; charset=utf-8",
		data: {
			'relation_user_id': relation_user_id,
			'relation_group_id': relation_group_id,
		}
	});
}

function createNewBill(amount, gname, description, user_id) {
	console.log(amount + gname + description + user_id);
	$.ajax({
		url: "createNewBill.php",
		contentType: "application/json; charset=utf-8",
		data: {
			'amount': amount,
			'gname': gname,
			'description': description,
			'user_id': user_id,
		},
	});
}