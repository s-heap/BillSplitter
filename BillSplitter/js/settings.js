$(document).ready( function() { 
	console.log('Javascript loaded my friend');
	
	$('#email_input').change(function() {
		$('#emailError').empty();
		resetFormError('#email_input')
		isEmailRegistered($('#email_input').val(), function() {
			$('#emailError').html('Please enter an unregistered email address.<br>');
			setFormError('#email_input');
		}, function() {}, true);
	});
	
	$('#changeEmailForm').submit(function() {
		if ($('#emailError').html() !== '') {
			return false;
		}
		
		isEmailRegistered($('#email_input').val(), function() {
			$('#emailError').html('Please enter an unregistered email address.<br>');
			setFormError('#email_input');
		}, function() {}, false);
		
		if ($('#emailError').html() !== '') {
			return false;
		}
	});
	
	$('#changePasswordForm').submit(function() {
		$('#passwordError').empty();
		resetFormError('#new_password_input');
		resetFormError('#confirm_new_password_input');
		
		if ($('#new_password_input').val() !== $('#confirm_new_password_input').val()) {
			setFormError('#new_password_input');
			setFormError('#confirm_new_password_input');
			$('#passwordError').html('Your password and confirm password must be the same.<br>');
			return false;
		}
		
		$.ajax({
			url: "checkPassword.php",
			contentType: "application/json; charset=utf-8",
			data: {
				'password': $('#new_password_input').val(),
				'user_id': $('#changePassword_user_id').val(),
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
	});
});