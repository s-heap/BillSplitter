$(document).ready( function() { 
	console.log('Javascript loaded my friend');
	$('#email_input').change(function() {
		$('#emailError').empty();
		resetFormError('#email_input');
		isEmailRegistered($('#email_input').val(), function() {}, function(){
			$('#emailError').html('Please enter a registered email address.<br>');
			setFormError('#email_input')
		}, true);
	});
	
	$('#loginForm').submit(function() {
		
		if ($('#emailError').html() !== '') {
			return false;
		}
		
		isEmailRegistered($('#email_input').val(), function() {}, function(){
			$('#emailError').html('Please enter a registered email address.<br>');
			setFormError('#email_input')
		}, false);
		
		if ($('#emailError').html() !== '') {
			return false;
		}
	});
});