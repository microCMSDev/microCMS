<?php
include 'functions.php';
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// Like Post
if(isset($_GET['like_id']))
{
  include '../mc-config.php';
  $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
  $post_id = $_GET['like_id'];
  $query = "UPDATE mc_posts SET post_likes = post_likes +1 WHERE id = $post_id";
  $result = mysqli_query($conn,$query);
  mysqli_close($conn);
}

if(isset($_GET['comment_id']))
{
	
}