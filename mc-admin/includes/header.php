<?php

$settings = new site\settings;
$site_url = $settings->site_url;
$site_name = $settings->site_name;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta content="Default page" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="/mc-content/themes/<?php echo $settings->site_theme;?>/img/assets/favicon.ico">
	<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
</head>

<body>
<nav class="header header-inverse">
  <div class="container-fluid">
    <div class="header">
      <a href="https://www.microcms.org/" rel="nofollow"><img src="img/assets/microcms.png" height="40" width="40" alt=""></a>
      <a href="<?php echo $site_url;?>" rel="nofollow"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $site_name; ?></a>
    </div>
	<!--
    <div class="collapse navbar-collapse" id="myNavbar">
        <a href="#">User</a>  
    </div>
	-->
  </div>
 </div>
</nav>
