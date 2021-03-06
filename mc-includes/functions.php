<?php
/*
 * redirect()
 * front-end for core->redirect_to()
 * usage redirect('/');
*/
function redirect($location)
{
   $core = new site\core;
   $core->redirect_to($location);
}

function do_header()
{
	$settings = new site\settings;
	echo '<title>'.$settings->site_name.'</title>';
    echo '<meta charset="utf-8">';
	echo '<base href="'.$settings->site_url.'">';
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
	if(file_exists('mc-content/themes/'.$settings->site_theme.'/img/assets/favicon.ico'))
	{
       echo '<link rel="shortcut icon" type="image/x-icon" href="mc-content/themes/'.$settings->site_theme.'/img/assets/favicon.ico">';
	}
	if(file_exists('mc-content/themes/'.$settings->site_theme.'/img/favicon.ico'))
	{
		echo '<link rel="shortcut icon" type="image/x-icon" href="mc-content/themes/'.$settings->site_theme.'/img/favicon.ico">';
	}
    echo '<meta name="no-email-collection" content="http://www.unspam.com/noemailcollection/">';
    echo '<meta name="description" content="'.$settings->site_description.'">';
    echo '<meta name="keywords" content="'.$settings->site_keywords.'">';
    echo '<link rel="dns-prefetch" href="'.$settings->site_url.'">';
	echo '<link rel="stylesheet" href="mc-content/themes/'.$settings->site_theme.'/css/style.css">';
	echo '<link rel="stylesheet" href="mc-includes/css/core.css">';
	echo '<link rel="alternate" type="application/rss+xml" title="RSS Feed" href="/rss.php" />';
}

function mc_login_url()
{
	$login_url = '/login';
	return $login_url;
}

function mc_logout_url()
{
	$logout_url = '/logout';
	return $logout_url;
}

function mc_register_url()
{
	$register_url = '/signup';
	return $register_url;
}



function mc_debug($string)
{
	$core = new site\core;
	$core->check_errors($string);
}

function mc_login($user,$pass)
{
	$mcdb = new database\db;
	$query = "SELECT * FROM mc_users WHERE user_login = '$user' && user_pass = '$pass'";
	$result = $mcdb->query($query);
	$user_count = $mcdb->rows($result);
	return $user_count;
}

function mc_getUser($username)
{
	$mcdb = new database\db;
	$query = "SELECT * FROM mc_users WHERE user_login = '$username'";
	$result = $mcdb->query($query);
	$user = $mcdb->fetch_array($result);
	if(!$user)
	{
		redirect("/");
	}
	else
	{
		$_SESSION['timestamp'] = time();
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['admin'] = $user['user_status'];
		$_SESSION['display_name'] = $user['display_name'];
		$uid = $user['id'];
		$query = "UPDATE mc_users SET last_login = NOW() WHERE id = '$uid'";
		$result = mc_query($query);
		$is_a_admin = $user['user_status'];
		if($is_a_admin == 1)
		{
			redirect("/mc-admin");
		}
		else
		{
			redirect("/");
		}
	}
}

/*
 * logged_time()
 * On Login, timestamp session is created
 * if after idletime, logout and redirect
 * default is 30 minutes
 * @timestamp
 * @idletime
*/
function logged_time()
{
   $idletime = 1800;
   if(isset($_SESSION['timestamp']))
   {
	   if (time() - $_SESSION['timestamp'] > $idletime)
	   {
		   //$_SESSION = array();
		   //setcookie(session_name(), false, time()-3600);
		   session_destroy(); 
	   }
	   else
	   {
		   $_SESSION['timestamp'] = time();
	   }
   }
}

function mc_slugify($string)
{
	$core = new site\core;
	$the_slug = $core->slugify($string);
	return $the_slug;
}

function mc_verifyEmail($email)
{
	$core = new site\core;
	$data = $core->verifyEmail($email);
	return $data;
}

function mc_prepData($string)
{
	$mcdb = new database\db;
	$data = $mcdb->prep_data($string);
	return $data;
}

/*
 * mc_query($string)
 * front method for $db-query in mc-core/database/db.php
 * usage mc_query($string);
*/
function mc_query($string)
{
  $mcdb = new database\db;
  $result = $mcdb->query($string);
  return $result;  
}

/*
 * mc_fetchAssoc
 * takes one argument
 * $ $string is the result of the query
*/ 
function mc_fetchAssoc($string)
{
	$mcdb = new database\db;
	$data = $mcdb->fetch_assoc($string);
	return $data;
}

/*
 * mc_fetchArray
 * takes one argument
 * $ $string is the result of the query
*/ 
function mc_fetchArray($string)
{
	$mcdb = new database\db;
	$data = $mcdb->fetch_array($string);
	return $data;
}

function mc_fetchRows($string)
{
	$mcdb = new database\db;
	$rows = $mcdb->rows($string);
	return $rows;
}

function get_siteTheme()
{
   $mcdb = new database\db;
   $query = "SELECT * FROM mc_settings";
   $result = $mcdb->query($query);
   $data = $mcdb->fetch_assoc($result);
   $option = $mcdb->prep_data($data['site_theme']);
   return $option;
}

function check_maintenance()
{
  $mcdb = new database\db;
  $query = "SELECT * FROM mc_settings";
  $result = $mcdb->query($query);
  $data = $mcdb->fetch_assoc($result);
  $maint = $mcdb->prep_data($data['maintenance']);
  return $maint;
}

/*
 * Add Visitor to site visit count
 * mc_countVisitor()
*/
function mc_countVisitor()
{
   $query = "UPDATE mc_sitevisits SET count = count+1";
   mc_query($query);   
}

/*
 * get_blogs()
 * Used in core post plugin
 * USage: get_blogs();
*/
function mc_getblogs()
{
  $mcdb = new database\db;
  $query = "SELECT * FROM mc_posts ORDER BY post_date DESC";
  $result = $mcdb->query($query);
  return $result;
}
function mc_countComments($id)
{
   $mcdb = new database\db;
   $query = "SELECT count(*) as total from mc_metadata WHERE post_id = '$id'";
   $result = $mcdb->query($query);
   $data = $mcdb->fetch_assoc($result);
   $count = $data['total'];
   return $count;
}
function count_comments()
{
   $mcdb = new database\db;
   $query = "SELECT count(*) as total from mc_metadata";
   $result = $mcdb->query($query);
   $data = $mcdb->fetch_assoc($result);
   $count = $data['total'];
   return $count;
}

function mc_getBlogbySlug($slug)
{
	$mcdb = new database\db;
	$query = "SELECT * FROM mc_post WHERE post_slug = $slug";
	$result = $mcdb->query($query);
	$data = $mcdb->fetch_array($result);
    return $data;
}

/*
 * Get the last posted blog
 * For the fron page
*/
function mc_getLastPost()
{
   $mcdb = new database\db;
   $query = "SELECT * FROM mc_posts ORDER BY post_date DESC LIMIT 1";
   $result = mc_query($query);
   return $result;
}


// Functions for the admin Dashboard
function mc_countUsers()
{
	$mcdb = new database\db;
   $query = "SELECT count(*) as total from mc_users";
   $result = $mcdb->query($query);
   $data = $mcdb->fetch_assoc($result);
   $count = $data['total'];
   return $count;
}

function mc_countPosts()
{
	$mcdb = new database\db;
   $query = "SELECT count(*) as total from mc_posts";
   $result = $mcdb->query($query);
   $data = $mcdb->fetch_assoc($result);
   $count = $data['total'];
   return $count;
}

function mc_version()
{
	$mcdb = new database\db;
	$query = "SELECT * FROM mc_version";
	$result = $mcdb->query($query);
	$version = $mcdb->fetch_assoc($result);
	$major = $version['major'];
	$minor = $version['minor'];
	$increment = $version['increment'];
	$current_version = "$major.$minor.$increment";
	return $current_version;
}

function mc_currentTheme()
{
   $mcdb = new database\db;
   $query = "SELECT site_theme FROM mc_settings";
   $result = mc_query($query);
   $current_theme = mc_fetchAssoc($result);
   $theme = $current_theme['site_theme'];
   
   return $theme;
}

function mc_lastPosts()
{
   $mcdb = new database\db;
   $query = "SELECT * FROM mc_posts ORDER BY post_date DESC LIMIT 5";
   $result = mc_query($query);
   return $result;
}

function mc_countBadguys()
{
	$mcdb = new database\db;
   $query = "SELECT count(*) as total FROM mc_bannedip";
   $result = $mcdb->query($query);
   $data = $mcdb->fetch_assoc($result);
   $count = $data['total'];
   return $count;
}
/*
 * Bad Actor IP Popularity
 * used in Admin->Sentry
 * Get a total Count from mc_bannedips
 * Seperate the count by country
 * evaluate the countries
 * display the most popular country
*/
function popular_badGuys()
{
   $mcdb = new database\db;
   $query = "SELECT country FROM mc_bannedip";
   $result = $mcdb->query($query);
   $rst = $mcdb->rows($result);
   if($rst == 0)
   {
	   $response = '<strong>None</strong>';
   }
   else
   {
   
	   // Loop through each record
	   while($data = $mcdb->fetch_array($result))
	   {
		   // Assign just the data that we need
		   $country = $data['country'];
	   }
	   $popular = max(array($country));
	   if($popular == 'CN')
	   {
		   $response = '<img src="/mc-admin/img/country/CN.svg" height="30" width="30"> <strong>China</strong>';
	   }
	   if($popular == 'RU')
	   {
		   $response = '<img src="/mc-admin/img/country/RU.svg" height="30" width="30"> <strong>Russia</strong>';
	   }
	   if($popular == 'US')
	   {
		   $response = '<img src="/mc-admin/img/country/US.svg" height="30" width="30"> <strong>The United States</strong>';
	   }
	   if($popular == 'IR')
	   {
		   $response = '<img src="/mc-admin/img/country/IR.svg" height="30" width="30"> <strong>Iraq</strong>';
	   }
   }
   return $response;
}

function mc_getSentryVersion()
{
	$mcdb = new database\db;
   $query = "SELECT plugin_version FROM mc_plugins WHERE plugin_slug = 'php-sentry'";
   $result = mc_query($query);
   $current_version = mc_fetchAssoc($result);
   $version = $current_version['plugin_version'];
   return $version;
}

function mc_countVisits()
{
   $mcdb = new database\db;
   $query = "SELECT count from mc_sitevisits";
   $result = $mcdb->query($query);
   $data = $mcdb->fetch_assoc($result);
   $count = $data['count'];
   return $count;
}

function mc_adminSwitch()
{
	$mcdb = new database\db;
	$query = "SELECT plugin_slug FROM mc_plugins WHERE plugin_type = 1 AND plugin_status = 1";
	$result = $mcdb->query($query);
	return $result;
}

function get_themes()
{
	$dir = "../mc-content/themes";
	$handle = opendir($dir);
	while($name = readdir($handle))
	{
	   if(is_dir("$dir/$name"))
	   {
	      if($name != '.' && $name != '..')
		  {
			  $mcdb = new database\db;
			  $query = "SELECT site_theme FROM mc_settings";
			  $result = $mcdb->query($query);
			  $theme = $mcdb->fetch_assoc($result);
			  $current_theme = $theme['site_theme'];
			  if($name == $current_theme)
			  {
				  $status = 'Active';
				  $button = '<button type="button" class="btn btn-dark" disabled>Currently Active</button>';
			  }
			  else
			  {
				  $status = 'Not active';
				  $button = '<a href="/mc-admin/themes?page=activate&theme='.$name.'" class="btn btn-dark">Activate</a>';
			  }
			  
		     //echo '<option value="'.$name.'">'.$name.'</option>';
			 if(file_exists("$dir/$name/img/screenshot.png"))
			 {
				 echo '
				  <div class="col-sm-4">
					<div class="card">
						<div class="card-body">
						  <h5 class="card-title">'.$name.'</h5>
							<img src="/mc-content/themes/'.$name.'/img/screenshot.png" height="300" width="300">
							  <p class="card-text"><strong>Status:</strong> <i>'.$status.'</i></p>
							  <p>'.$button.'</p>
						</div>
					</div>
				</div>
				';
			 }
			 else
			 {
				 echo '
				  <div class="col-sm-4">
					<div class="card">
						<div class="card-body">
						  <h5 class="card-title">'.$name.'</h5>
							<img src="/mc-admin/img/assets/microcms.png" height="300" width="300">
							<p class="card-text"><strong>Status:</strong> <i>'.$status.'</i><br><i>This themes base image does not exist</i></p>
							  <p>'.$button.'</p>
						</div>
					</div>
				</div>
				';
			 }
			
		  }
	   }

	}
	closedir($handle);
}

function ago($time)
{
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference $periods[$j] $tense ";
}

function check_coreUpdate()
{
   $url = "https://control.microcms.org/version_check.php?id=1";
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_HEADER, FALSE);
   curl_setopt($ch, CURLOPT_NOBODY, FALSE); // remove body
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
   $content  = curl_exec($ch);
   $remote_version = trim($content);
   curl_close($ch);
   return $remote_version;
}
