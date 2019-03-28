$(document).ready(function() { 
	console.log('Javascript loaded my friend');
	
	$('#email_input').change(function() {
		$('#emailError').empty();
		resetFormError('#email_input')
		isEmailRegistered($('#email_input').val(), function() {
			$('#emailError').html('Please enter an unregistered email address.<br>');
			setFormError('#email_input');
		}, function() {}, true);
	});
	
	$('#registerForm').submit(function() {
		
		$('#passwordError').empty();
		resetFormError('#password_input');
		resetFormError('#vpassword_input');
		
		if ($('#password_input').val() !== $('#vpassword_input').val()) {
			setFormError('#password_input');
			setFormError('#vpassword_input');
			$('#passwordError').html('Your password and confirm password must be the same.<br>');
			return false;
		}
		
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
});