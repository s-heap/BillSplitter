function setFormError(divID) {
	$(divID).css('border', '1px solid red');
}

function resetFormError(divID) {
	$(divID).css('border', '1px solid white');
}

function isEmailRegistered(email, trueExecute, falseExecute, async) {
	$.ajax({
		url: "checkEmail.php",
		contentType: "application/json; charset=utf-8",
		data: {
			'email': email,
		},
		async: async,
		success: function(response){
			if (response == '1') {
				trueExecute();
			} else if (response == '0') {
				falseExecute();
			} else {
				console.log('Testing: ' + response);
			}
		}
	});
}

function isGroupNameRegistered(groupName, trueExecute, falseExecute, async) {
	$.ajax({
		url: "checkGroupName.php",
		contentType: "application/json; charset=utf-8",
		data: {
			'groupName': groupName,
		},
		async: async,
		success: function(response){
			if (response == '1') {
				trueExecute();
			} else if (response == '0') {
				falseExecute();
			} else {
				console.log('Testing: ' + response);
			}
		}
	});
}

function checkIsMemberOfGroup(email, gname, trueExecute, falseExecute, async) {
	$.ajax({
		url: "checkIsMember.php",
		contentType: "application/json; charset=utf-8",
		data: {
			'email': email,
			'gname': gname,
		},
		async: async,
		success: function(response){
			if (response == '1') {
				trueExecute();
			} else if (response == '0') {
				falseExecute();
			}
		}
	});
}