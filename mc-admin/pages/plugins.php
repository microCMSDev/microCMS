<?php
echo '<div class="row">';
echo '<div class="col">';
echo '<h1>Plugins</h1>';
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

function plugins_main()
{
	/* 
	 * Loop through the existing Plugins
	 * gather their data
	 * display it here
	 * offer to deactivate and delete once deactivated
	*/
	?>
	
	<?php
	echo '<table border="0" width="100%">';
	echo '<tr>';
	echo '<td><strong>Plugin</strong></td>';
	echo '<td><strong>Version</strong></td>';
	echo '<td><strong>Description</strong></td>';
	echo '<td><strong>Status</strong></td>';
	echo '<td></td>';
	echo '</tr>';
	$query = "SELECT * FROM mc_plugins";
	$result = mc_query($query);
	while($data = mc_fetchAssoc($result))
	{
	   $id = $data['id'];
	   $plugin_name = $data['plugin_name'];
	   $plugin_version = $data['plugin_version'];
	   $plugin_text = $data['plugin_text'];
	   $plugin_slug = $data['plugin_slug'];
	   $plugin_status = $data['plugin_status'];
	   if($plugin_status == 1)
	   {
		   $status = 'Active';
		   $button = '<a href="/mc-admin/plugins?page=deactivate&id='.$id.'" class="btn btn-dark">De Activate</a>';
	   }
	   else
	   {
		   $status = 'Not Active';
		   $button = '<a href="/mc-admin/plugins?page=activate&id='.$id.'" class="btn btn-dark">Activate</a> <a href="/mc-admin/plugins?page=delete&id='.$id.'" class="btn btn-dark">Delete</a>';
	   }
	   echo '<tr>';
	   echo '<td>'.$plugin_name.'</td>';
	   echo '<td>'.$plugin_version.'</td>';
	   echo '<td>'.$plugin_text.'</td>';
	   echo '<td>'.$status.'</td>';
	   echo '<td>'.$button.'</td>';
	   echo '</tr>';
	}
	echo '</table>';
	echo '<h4>Add New Plugin</h4>';
	echo '<form action="/mc-admin/plugins?page=add" method="post">';
	echo '<select name="plugins" id="plugins">';
	echo '<option>--Choose--</option>';
	
	/*
	 * Get non active plugins
	 * include the plugins init.php
	 * get variables from init
	 * offer to activate or delete
	*/
	$dir = "../mc-content/plugins";
	$handle = opendir($dir);
	while($name = readdir($handle))
	{
	   if(is_dir("$dir/$name"))
	   {
	      if($name != '.' && $name != '..')
		  {
			  echo '<option value="'.$name.'">'.$name.'</option>';
		  }
		}
	}
	closedir($handle);
	echo '</select>';
	echo ' <button class="btn btn-dark" name="submit" id="submit">Add Plugin</button>';
	echo '</form>';
}

function add_plugin()
{
	if(isset($_POST['submit']))
	{
	   $the_plugin = $_POST['plugins'];
	   include '../mc-content/plugins/'.$the_plugin.'/init.php';
	   if(file_exists('../mc_content/plugins/'.$the_plugin.'/admin/'.$the_plugin.'-admin.php'))
	   {
		   $admin = 1;
	   }
	   else
	   {
		   $admin = 0;
	   }
	   $plugin_slug = mc_slugify($the_plugin);
	   $query = "INSERT INTO mc_plugins (plugin_name, plugin_slug, plugin_type, plugin_status, plugin_text, plugin_version) 
	   VALUES ('$plugin', '$plugin_slug', '$admin', '1', '$description', '$version')";
	   $result = mc_query($query);
	   if($result)
	   {
		   redirect("/mc-admin/plugins");
	   }
	}
	
}
function activate_plugin()
{
	$id = $_GET['id'];
	$query = "UPDATE mc_plugins SET plugin_status = 1 WHERE id = $id";
	$result = mc_query($query);
	if($result)
	{
		redirect("/mc-admin/plugins");
	}
}

function deactivate_plugin()
{
	$id = $_GET['id'];
	echo $id;
	$query = "UPDATE mc_plugins SET plugin_status = 0 WHERE id = $id";
	$result = mc_query($query);
	if($result)
	{
		redirect("/mc-admin/plugins");
	}
}

function delete_plugin()
{
	$id = $_GET['id'];
	$query = "SELECT plugin_slug from mc_plugins WHERE id = $id";
    $result = mc_query($query);
    $data = mc_fetchAssoc($result);
    $plugin_slug = $data['plugin_slug'];
	
	$query = "DELETE from mc_plugins WHERE id = $id";
	$result = mc_query($query);
	if($result)
	{
		$dir = '../mc-content/plugins/'.$plugin_slug.'';
		removeDirectory($dir);
		redirect("/mc-admin/plugins");
	}
}

function removeDirectory($path) {
    $files = glob($path . '/*');
    foreach ($files as $file) {
        is_dir($file) ? removeDirectory($file) : unlink($file);
    }
    rmdir($path);
    return;
}

/*
 * Switch
 * Allows function to be used
 * $p is derived from the Function operatives
*/
switch($p)
{
   case 'activate':
      activate_plugin();
      break;
   case 'deactivate':
      deactivate_plugin();
      break;
   case 'delete':
      delete_plugin();
      break;
   case 'add':
      add_plugin();
      break;
	  
   default:
      plugins_main();
      break;
}