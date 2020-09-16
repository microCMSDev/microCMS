<?php
include 'mc-config.php';
include 'mc-core/loader.php';
$settings = new site\settings;
$db = new database\db;
$query = "SELECT post_title, post_slug, post_exerpt, post_date FROM mc_posts";
$result = $db->query($query);
$build_date = date("r");
header("Content-Type: application/rss+xml; charset=UTF-8");
 
 echo "<?xml version='1.0' encoding='UTF-8'?>
  <rss version='2.0' xmlns:atom='http://www.w3.org/2005/Atom'>
 <channel>
 <title>$settings->site_name | RSS</title>
 <link>$settings->site_url</link>
 <description>$settings->site_description</description>";
 echo '<source:account service="twitter">'.$settings->twitter.'</source:account>';
 echo '<source:account service="facebook">'.$settings->facebook.'</source:account>';
 echo "
 <language>en-us</language>
 <lastBuildDate>$build_date</lastBuildDate>
 ";
 while($posts = $db->fetch_assoc($result))
 {
	 $post_title = $posts['post_title'];
     $post_slug = $posts['post_slug'];
	 $post_intro = $posts['post_exerpt'];
	 //$post_dt = $posts['post_date'];
	 $post_date = date("r",strtotime($posts['post_date']));
	 echo '<item>';
     echo '<title>'.$post_title.'</title>';
     echo '<description>'.$post_intro.'</description>';
     echo '<link>'.$settings->site_url.'/posts/'.$post_slug.'</link>';
	 echo '<guid>'.$settings->site_url.'/posts/'.$post_slug.'</guid>';
     echo '<pubDate>'.$post_date.'</pubDate>';
     echo '</item>';
  }
  echo '<atom:link href="'.$settings->site_url.'/rss.php" rel="self" type="application/rss+xml" />';
  echo "
  </channel>
 </rss>";