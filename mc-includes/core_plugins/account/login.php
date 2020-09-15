<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	echo '<div class="container">';
	echo '<div class="row">';
	echo '<div class="login">';
	if(isset($_POST['login']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$secure_pass = sha1($password);
		
		$user_count = mc_login($username, $secure_pass);
		if($user_count != 1)
		{
		   echo '<div class="col-lg">';
		   echo '<div class="error_box">';
		   echo '<h3>ERROR!</h3>';
		   echo '<p>Wrong Username or Password.</p>';
		   echo '<p><a href="/login" hreflang="en"><strong>Return</strong></a></p>';
		   echo '</div>';
		   echo '</div>';
		}
		else
		{
			$user = mc_getUser($username);
		}
	}
	else
	{
	   // The Login Form
	   echo '<div class="col">';
	   echo '<section>';
	   echo '<table border="0" cellpadding="3" cellspacing="3" align="center">';
	   echo '<tr>';
	   echo '<td>';
	   echo '<form action="/login" method="post">';
	   echo '<fieldset>';
	   echo '<legend><strong>Log In</strong></legend>';
	   echo '<table border="0" cellpadding="3" cellspacing="3" width="100%" align="center">';
	   echo '<tr>';
	   echo '<td><label for="username">Username:</label></td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><input id="username" type="text" name="username" required>';
	   echo '</tr>';
	   echo '<tr>';
	   echo '<td><label for="password">Password:</label></td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><input id="password" type="password" name="password" required>';
	   echo '</tr>';
	   echo '<tr>';
	   echo '<td>&nbsp;</td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><br><input type="submit" name="login" value="Log In">';
	   echo '</tr>';
	   echo '</table>';
	   echo '</fieldset>';
	   echo '</form>';
	   echo '</td>';
	   echo '</tr>';
	   echo '</table>';
	   echo '<div align="center"><a href="/signup">Don\'t have an account?</a>  <a href="/reset-password">Forgot Password?</a></div>';
	   echo '</section>';
	   echo '</div>';
	}
	echo '</div>';
	echo '</div>';
	echo '</div>';
}
?>
