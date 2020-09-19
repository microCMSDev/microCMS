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

function post_comment()
{
	include '../mc-config.php';
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];
	$display_name = mysqli_real_escape_string($conn, $_POST['display_name']);
	$comment = mysqli_real_escape_string($conn, $_POST['comment']);
	$query = "INSERT INTO mc_metadata (post_type, content, content_date, post_id, user_id, user_name) VALUES ('1', '$comment', NOW(), '$post_id', '$user_id', '$display_name')";
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
   case 'post_comment':
      post_comment();
      break;
}