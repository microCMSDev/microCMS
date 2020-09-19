<h1>Themes</h1>
<div class="container">
<div class="row">
<?php
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

function themes_main()
{
   echo get_themes();
}

function activate_theme()
{
	$name = $_GET['theme'];
	$query = "UPDATE mc_settings SET site_theme = '$name'";
    $result = mc_query($query);
    if($result)
    {
	   redirect("/mc-admin/themes");
    }
}

/*
 * Switch
 * Allows function to be used
 * $p is derived from the Function operatives
*/
switch($p)
{
   case 'activate':
      activate_theme();
      break;
	  
   default:
      themes_main();
      break;
}
?>
</div>
</div>