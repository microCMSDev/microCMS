<?php
//Function operatives
if (isset($_GET['task']))
{
   $p = $_GET['task'];
} 
elseif (isset($_POST['task']))
{ // Forms
   $p = $_POST['task'];
}
else
{
   $p = NULL;
}

// NOT CURRENTLY WORKING
function update_user()
{
	include '../../mc-config.php';
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$user_id = $_POST['user_id'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$nick_name = $_POST['nick_name'];
	$display_name = $_POST['display_name'];
	$user_email = $_POST['user_email'];
	$user_url = $_POST['user_url'];
	$user_status = $_POST['user_status'];
	$query = "UPDATE mc_users SET user_firstname = '$first_name', user_lastname = '$last_name', user_nickname = '$nick_name', display_name = '$display_name', user_email = '$user_email', user_url = '$user_url', user_status = '$user_status' WHERE id = $user_id";
	$result = mysqli_query($conn,$query);
	return $result;
	mysqli_close($conn);
}

// NOT CURRENTLY WORKING
function add_user()
{
	// Get variables
	$user_login = $_POST['user_login'];
	$user_pass = $_POST['user_pass'];
	$display_name = $_POST['display_name'];
	$email_address = $_POST['email_address'];
	$user_status = $_POST['user_status'];
	$secure_pass = sha1($user_pass);
	include '../../mc-config.php';
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$query = "INSERT INTO mc_users (user_login, user_pass, user_nickname, display_name, user_email, user_status, reg_date) VALUES ('$user_login', '$secure_pass', '$display_name', $display_name', '$email_address', '$user_status', NOW())";
	$result = mysqli_query($conn,$query);
	return $result;
	mysqli_close($conn);
	
}

function update_settings()
{
	include '../../mc-config.php';
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$site_name = $_POST['site_name'];
	$site_url = $_POST['site_url'];
	$site_slug = $_POST['site_slug'];
	$admin_email = $_POST['admin_email'];
	$site_description = $_POST['site_description'];
	$site_keywords = $_POST['site_keywords'];
	$site_maintenance = $_POST['site_maintenance'];
	$query = "UPDATE mc_settings SET site_name = '$site_name', site_url = '$site_url', site_slug = '$site_slug', admin_email = '$admin_email', site_description = '$site_description', site_keywords = '$site_keywords'";
	$result = mysqli_query($conn,$query);
	return $result;
	mysqli_close($conn);
}

function update_mailserver()
{
	include '../../mc-config.php';
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$ms_url = $_POST['mailserver_url'];
	$ms_login = $_POST['mailserver_login'];
	$ms_pass = $_POST['mailserver_pass'];
	$ms_port = $_POST['mailserver_port'];
	$query = "UPDATE mc_settings SET mailserver_url = '$ms_url', mailserver_login = '$ms_login', mailserver_pass = '$ms_pass', mailserver_port = '$ms_port'";
	$result = mysqli_query($conn,$query);
	return $result;
	mysqli_close($conn);
}

function update_social()
{
	include '../../mc-config.php';
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$tw = $_POST['twitter'];
	$fb = $_POST['facebook'];
	$ig = $_POST['instagram'];
	$yt = $_POST['youtube'];
	$query = "UPDATE mc_settings SET facebook = '$fb', twitter = '$tw', instagram = '$ig', youtube = '$yt'";
	$result = mysqli_query($conn,$query);
	return $result;
	mysqli_close($conn);
}

function enable_maintenance()
{
	include '../../mc-config.php';
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$query = "UPDATE mc_settings SET maintenance=1";
	$result = mysqli_query($conn,$query);	   
	return $result;
	
}

function disable_maintenance()
{
	include '../../mc-config.php';
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$query = "UPDATE mc_settings SET maintenance=0";
	$result = mysqli_query($conn,$query);	   
	return $result;
	
}

function drop_user()
{
	$id = $_POST['id'];
	$query1 = "DELETE FROM mc_metadata WHERE user_id = $id";
	$result1 = mc_query($query);
	$query2 = "DELETE FROM mc_users WHERE id = $id";
	$result2 = mc_query($query);
	
}

// placed here to check after every function is added, remove when complete
function check()
{
	echo 'Yes';
}

/*
 * Switch
 * Allows function to be used
 * $p is derived from the Function operatives
*/
switch($p)
{
   case 'update_settings':
      update_settings();
      break;
   case 'update_mailserver':
      update_mailserver();
      break;
   case 'update_social':
      update_social();
      break;
   case 'enable_maintenance':
      enable_maintenance();
      break;
   case 'disable_maintenance':
      disable_maintenance();
      break;
   case 'add_user':
      add_user();
      break;
   case 'update_user':
      update_user();
      break;
   case 'check':
      check();
      break;
}