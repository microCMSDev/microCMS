<?php
echo '<div class="row">';
echo '<div class="col">';
//Function operatives
if (isset($_GET['page']))
{
   $p = $_GET['page'];
} 
elseif (isset($_POST['page']))
{ // Forms
   $p = $_POST['page'];
}
else
{
   $p = NULL;
}
echo '<h2>Settings</h2>';

function main()
{
	// Breadcrumb
   echo '<p><small><strong>Main</strong> >> <a href="/mc-admin/settings?page=mail">Mail Server</a> >> <a href="/mc-admin/settings?page=social">Social Media</a> >> <a href="/mc-admin/settings?page=maintenance">Maintenance</a></small></p>';
   $query = "SELECT site_name, site_url, site_slug, site_description, site_keywords, admin_email FROM mc_settings";
   $result = mc_query($query);
   $data = mc_fetchAssoc($result);
   $site_name = $data['site_name'];
   $site_url = $data['site_url'];
   $site_slug = $data['site_slug'];
   $admin_email = $data['admin_email'];
   $site_description = $data['site_description'];
   $site_keywords = $data['site_keywords'];
   
   // Update via AJAX
   ?>
   <script type="text/javascript">
   function update_settings() {
      var site_name = $("#site_name").val();
	  var site_url = $("#site_url").val();
	  var site_slug = $("#site_slug").val();
	  var admin_email = $("#admin_email").val();
	  var site_description = $("#site_description").val();
	  var site_keywords = $("#site_keywords").val();
         $.ajax({
			 type: 'POST',
             url: "includes/ajax.php?task=update_settings", //the page containing php script
			 //dataType: 'json',
			 data: '&site_name='+site_name+'&site_url='+site_url+'&site_slug='+site_slug+'&admin_email='+admin_email+'&site_description='+site_description+'&site_keywords='+site_keywords,
			 error: function(html) {
				$('#response').css("color" , "red");
                $('#response').html("<strong>Error</strong>");
             },
             success: function(html) {
				$('#response').css("color" , "green");
                $('#response').html("<strong>Success</strong>");
             }
        });
       }
	  
	  </script>
   <?php
   echo '<div id="response" name="repsonse"></div>';
   // Site Name
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Site Name</h4>';
   echo '<p><small>The name of your site</small></p>';
   echo '<input type="text" id="site_name" name="site_name" value="'.$site_name.'" size="30">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Site URL
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Site URL</h4>';
   echo '<p><small>Your site\'s URL</small></p>';
   echo '<input type="text" id="site_url" name="site_url" value="'.$site_url.'" size="50">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Site Slug
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Short Description</h4>';
   echo '<p><small>Your site\'s Short Description</small></p>';
   echo '<input type="text" id="site_slug" name="site_slug" value="'.$site_slug.'" size="50">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Admin Email
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Admin Email</h4>';
   echo '<p><small>Your site\'s Admin Email Address</small></p>';
   echo '<input type="text" id="admin_email" name="admin_email" value="'.$admin_email.'" size="50">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Site Long Description
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Long Description</h4>';
   echo '<p><small>Your site\'s Long Description</small></p>';
   echo '<textarea id="site_description" name="site_description" rows="3" cols="50">'.$site_description.'</textarea>';
   echo '</div>';
   echo '</div>';
   // Site Keywords
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Site Keywords</h4>';
   echo '<p><small>Comma Seperated Keywords about your site</small></p>';
   echo '<textarea id="site_keywords" name="site_keywords" rows="3" cols="50">'.$site_keywords.'</textarea>';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Button
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<button type="button" class="btn btn-dark" name-"update" "id="update" onclick="update_settings()">Update</button>';
   echo '</div>';
   echo '</div>';
}

function mail_server()
{
   // Breadcrumb
   echo '<p><small><a href="/mc-admin/settings">Main</a> >> <strong>Mail Server</strong>> >> <a href="/mc-admin/settings?page=social">Social Media</a> >> <a href="/mc-admin/settings?page=maintenance">Maintenance</a></small></p>';
   
   $query = "SELECT mailserver_url, mailserver_login, mailserver_pass, mailserver_port FROM mc_settings";
   $result = mc_query($query);
   $data = mc_fetchAssoc($result);
   $ms_url = $data['mailserver_url'];
   if($ms_url == '' || $ms_url == 'NULL')
   {
	   $error_msg = 'You mail server is not set up correctly, meaning this site will never be able to send email.<br>Please log into you hosting provider and get you mail server settings';
   }
   $ms_login = $data['mailserver_login'];
   $ms_pass = $data['mailserver_pass'];
   $ms_port = $data['mailserver_port'];
   ?>
    <script type="text/javascript">
   function update_mailserver() {
      var ms_url = $("#mailserver_url").val();
	  var ms_login = $("#mailserver_login").val();
	  var ms_pass = $("#mailserver_pass").val();
	  var ms_port = $("#mailserver_port").val();
         $.ajax({
			 type: 'POST',
             url: "includes/ajax.php?task=update_mailserver", //the page containing php script
			 data: '&mailserver_url='+ms_url+'&mailserver_login='+ms_login+'&mailserver_pass='+ms_pass+'&mailserver_port='+ms_port,
			 error: function(data) {
				$('#response').css("color" , "red");
                $('#response').html("<strong>Error</strong>");
             },
             success: function(data) {
				$('#response').css("color" , "green");
                $('#response').html("<strong>Success</strong>");
             }
        });
       }
	  
	  </script>
	  <?php
   // Response Div
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<div id="response"></div>';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Mail server URL
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Mail Server URL</h4>';
   echo '<p><small>The URL of your Mail Server (smtp.somewhere.com)</small></p>';
   echo '<input type="text" id="mailserver_url" name="mailserver_url" value="'.$ms_url.'" size="30">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Mail server Login
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Mail Server Login</h4>';
   echo '<p><small>The login account for your Mail Server (you@somewhere.com)</small></p>';
   echo '<input type="text" id="mailserver_login" name="mailserver_login" value="'.$ms_login.'" size="30">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Mail server Pass
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Mail Server Password</h4>';
   echo '<p><small>The login password for your Mail Server</small></p>';
   echo '<input type="text" id="mailserver_pass" name="mailserver_pass" value="'.$ms_pass.'" size="30">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Mail server Port
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Mail Server Post</h4>';
   echo '<p><small>The Mail Server Port (Normally 465 or 587 for SSL/TLS)</small></p>';
   echo '<input type="text" id="mailserver_port" name="mailserver_port" value="'.$ms_port.'" size="30">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
    // Button
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<button type="button" class="btn btn-dark" name-"update" "id="update" onclick="update_mailserver()">Update</button>';
   echo '</div>';
   echo '</div>';
}

function social_media()
{
   // Breadcrumb
   echo '<p><small><a href="/mc-admin/settings">Main</a> >> <a href="/mc-admin/settings?page=mail">Mail Server</a> >> <strong>Social Media</strong> >> <a href="/mc-admin/settings?page=maintenance">Maintenance</a></small></p>';
   $query = "SELECT facebook, twitter, instagram, youtube FROM mc_settings";
   $result = mc_query($query);
   $data = mc_fetchAssoc($result);
   $facebook = $data['facebook'];
   $twitter = $data['twitter'];
   $instagram = $data['instagram'];
   $youtube = $data['youtube'];
   ?>
   <script type="text/javascript">
   function update_social() {
      var facebook = $("#facebook").val();
	  var twitter = $("#twitter").val();
	  var instagram = $("#instagram").val();
	  var youtube = $("#youtube").val();
         $.ajax({
			 type: 'POST',
             url: "includes/ajax.php?task=update_social", //the page containing php script
			 data: '&facebook='+facebook+'&twitter='+twitter+'&instagram='+instagram+'&youtube='+youtube,
			 error: function(data) {
				$('#response').css("color" , "red");
                $('#response').html("<strong>Error</strong>");
             },
             success: function(data) {
				$('#response').css("color" , "green");
                $('#response').html("<strong>Success</strong>");
             }
        });
       }
	  
	  </script>
	  <?php
   // Response Div
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<div id="response"></div>';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Facebook
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Facebook <i class="fa fa-facebook" aria-hidden="true"></i></h4>';
   echo '<p><small>Your Facebook User ID</small></p>';
   echo '<input type="text" id="facebook" name="facebook" value="'.$facebook.'" size="30">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Twitter
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Twitter <i class="fa fa-twitter" aria-hidden="true"></i></h4>';
   echo '<p><small>Your Twitter User ID (@your_name)</small></p>';
   echo '<input type="text" id="twitter" name="twitter" value="'.$twitter.'" size="30">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Instagram
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Instagram <i class="fa fa-instagram" aria-hidden="true"></i></h4>';
   echo '<p><small>Your Instagram User ID</small></p>';
   echo '<input type="text" id="instagram" name="instagram" value="'.$instagram.'" size="30">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Youtube
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Youtube <i class="fa fa-youtube" aria-hidden="true"></i></h4>';
   echo '<p><small>Your Youtube Channel</small></p>';
   echo '<input type="text" id="youtube" name="youtube" value="'.$youtube.'" size="30">';
   echo '</div>';
   echo '</div>';
   echo '<p></p>';
   // Button
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<button type="button" class="btn btn-dark" name="update" "id="update" onclick="update_social()">Update</button>';
   echo '</div>';
   echo '</div>';
}

function maintenance()
{
	// Breadcrumb
   echo '<p><small><a href="/mc-admin/settings">Main</a> >> <a href="/mc-admin/settings?page=mail">Mail Server</a> >> <a href="/mc-admin/settings?page=social">Social Media</a> >> <strong>Maintenance</strong></small></p>';
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<h4>Maintenance</h4>';
   echo '<div id="response"></div>';
   $query = "SELECT maintenance FROM mc_settings";
   $result = mc_query($query);
   $data = mc_fetchAssoc($result);
   $maintenance = $data['maintenance'];
   if($maintenance == 0)
   {
   ?>
	  <script type="text/javascript">
		function enable_maintenance() {
         $.ajax({
			 type: 'POST',
             url: "includes/ajax.php?task=enable_maintenance", //the page containing php script
			 error: function(data) {
				$('#response').css("color" , "red");
                $('#response').html("<strong>Error</strong>");
             },
             success: function(data) {
				$('#response').css("color" , "green");
                $('#response').html("<strong>Success</strong>");
             }
        });
       }
	   </script>
	   <?php
	   echo '<p>This site is not currently in maintenance mode, if at any time you require it, just click the button below. This will not effect your Admin Dashboard, just the main site.</p>';
	   echo '<p><button type="button" class="btn btn-dark" name="do_maint" "id="do_maint" onclick="enable_maintenance()">Enable Maintenance</button></p>';
   }
   else
   {
	   ?>
	   <script type="text/javascript">
	   function disable_maintenance() {
         $.ajax({
			 type: 'POST',
             url: "includes/ajax.php?task=disable_maintenance", //the page containing php script
			 error: function(data) {
				$('#response').css("color" , "red");
                $('#response').html("<strong>Error</strong>");
             },
             success: function(data) {
				$('#response').css("color" , "green");
                $('#response').html("<strong>Success</strong>");
             }
        });
       }
	   </script>
	   <?php
	   echo '<p>This site is currently in maintenance mode, meaning your front page is displaying a maintenance page. To shut this off, click the button below. This will not effect your Admin Dashboard, just the main site.</p>';
	   echo '<p><button type="button" class="btn btn-dark" name="no_maint" "id="no_maint" onclick="disable_maintenance()">Disable Maintenance</button></p>';
   }
   echo '</div>';
   echo '</div>';
}

/*
 * Switch
 * Allows function to be used
 * $p is derived from the Function operatives
*/
switch($p)
{
   case 'mail':
      mail_server();
      break;
   case 'social':
      social_media();
      break;
   case 'maintenance':
      maintenance();
      break;
   default:
      main();
      break;
}
echo '</div>';
echo '</div>';