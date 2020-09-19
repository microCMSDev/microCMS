<div class="container-fluid">
  <div class="row">
    <div>
     <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="/mc-admin"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/mc-admin/posts"><i class="fa fa-blog" aria-hidden="true"></i> Posts</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/mc-admin/plugins"><i class="fa fa-plug" aria-hidden="true"></i> Plugins</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="/mc-admin/sentry"><i class="fa fa-shield" aria-hidden="true"></i> Sentry</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/mc-admin/settings"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/mc-admin/themes"><i class="fa fa-camera" aria-hidden="true"></i> Themes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/mc-admin/updates"><i class="fa fa-refresh" aria-hidden="true"></i> Updates</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/mc-admin/users"><i class="fa fa-users" aria-hidden="true"></i> Users</a>
      </li>
      <?php
	// Menu
	$query = "SELECT * FROM mc_plugins WHERE plugin_type = 1 && plugin_status = 1";
	$result = mc_query($query);
        while($plugins = mc_fetchAssoc($result))
        {
           $plugin = $plugins['plugin_slug'];
           $plugin_name = $plugins['plugin_name'];
              echo '<li class="nav-item">';
              echo '<a class="nav-link" href="/mc-admin/'.$plugin.'"><i class="fa fa-cog" aria-hidden="true"></i> '.$plugin_name.'</a>';
              echo '</li>';
        }
        ?>
    </ul>
  </div>
