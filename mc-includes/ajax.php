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

function like_post()
{
	// Like Post
	  include '../mc-config.php';
	  $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	  $post_id = $_POST['like_id'];
	  $query = "UPDATE mc_posts SET post_likes = post_likes +1 WHERE id = $post_id";
	  $result = mysqli_query($conn,$query);
	  mysqli_close($conn);
}

/*
 * Switch
 * Allows function to be used
 * $p is derived from the Function operatives
*/
switch($p)
{
   case 'like_post':
      like_post();
      break;
}