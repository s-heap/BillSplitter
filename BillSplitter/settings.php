<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Settings</title>
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
		<div id='centerBox'>
			<form action='changeEmail.php' method='post' id='changeEmailForm'>
				New Email Address:
				<input class='text' type='email' name='email_input' id='email_input' required><br>
				<div id='emailError'></div>
				<?php
					echo '<input type="hidden" value="'.$_SESSION['user_id'].'" name ="changeEmail_user_id" id="changeEmail_user_id">';
				?>
				<input class='button' type='submit' value='Change Email'><br>
			</form>
		</div>
		<div id='centerBox'>
			<form action='changePassword.php' method='post' id='changePasswordForm'>
				Current Password:
				<input class='text' type='password' name='current_password_input' id='current_password_input' required><br>
				<div id='currentPasswordError'></div>
				New Password:
				<input class='text' type='password' name='new_password_input' id='new_password_input' required><br>
				Confirm New Password:
				<input class='text' type='password' name='confirm_new_password_input' id='confirm_new_password_input' required><br>
				<div id='passwordError'></div>
				<?php
					echo '<input type="hidden" value="'.$_SESSION['user_id'].'" name ="changePassword_user_id" id="changePassword_user_id">';
				?>
				<input class='button' type='submit' value='Change Password'><br>
			</form>
		</div>
		<div id='centerBox'>
			<form action='changeUsername.php' method='post' id='changeUsernameForm'>
				New Username:
				<input class='text' type='text' name='new_user_name' id='new_user_name' required><br>
				<?php
					echo '<input type="hidden" value="'.$_SESSION['user_id'].'" name ="changeUserName_user_id" id="changeUserName_user_id">';
				?>
				<input class='button' type='submit' value='Change Username'><br>
			</form>
		</div>
	</body>
</html>