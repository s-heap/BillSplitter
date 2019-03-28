<!DOCTYPE html>
<html>
	<head>
		<title>Register</title>
		<?php 
			include 'formatting.php';
			loadJS(__FILE__);
		?>
	</head>
	<body>
		<div id='centerBox'>
			<form action='registrationAuthentication.php' method='post' id='registerForm'>
				Email Address:
				<input class='text' type='email' name='email_input' id='email_input' required><br>
				<div id='emailError'></div>
				Password:
				<input class='text' type='password' name='password_input' id='password_input' required><br>
				Confirm Password:
				<input class='text' type='password' name='vpassword_input' id='vpassword_input' required><br>
				<div id='passwordError'></div>
				<input class='button' type='submit' value='Submit' id='registerRequest'><br>
			</form>
			<form action='index.php'>
				<input class='button' type='submit' value='Already have an account' id='toLoginButton'>
			</form>
		</div>
	</body>
</html>