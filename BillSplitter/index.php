<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<?php 
			include 'formatting.php';
			loadJS(__FILE__);
		?>
	</head>
	<body>
		<div id='centerBox'>
			<form action='loginAuthentication.php' method='post' id='loginForm'>
				Email Address:
				<input class='text' type='email' name='email' id='email_input' required><br>
				<div id='emailError'></div>
				Password:
				<input class='text' type='password' name='password' id='password_input' required>
				<input class='button' type='submit' value='Log In'><br>
			</form>
			<form action='register.php'>
				<input class='button' type='submit' value='Create an account' id='toRegisterButton'>
			</form>
		</div>
	</body>
</html>