<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
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
	$query = "UPDATE mc_settings SET site_name = '$site_name', site_url = '$site_url', site_slug = '$site_slug', admin_email = '$admin_email', site_description = '$site_description', site_keywords = '$site_keywords', maintenance = '$site_maintenance'";
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
}