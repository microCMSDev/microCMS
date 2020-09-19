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
echo '<h2>Users</h2>';
echo '<p><a href="/mc-admin/users?page=add"><button type="button" class="btn btn-dark" id="edit">Add User</button></a></p>';
echo '<hr>';
function users()
{
	// Breadcrumb
   //echo '<p><small><strong>Main</strong> >> <a href="/mc-admin/settings?page=mail">Mail Server</a> >> <a href="/mc-admin/settings?page=social">Social Media</a> >> <a href="/mc-admin/settings?page=maintenance">Maintenance</a></small></p>';
   $query = "SELECT id, user_login, user_nickname, display_name, user_email, reg_date FROM mc_users";
   $result = mc_query($query);
   echo '<div id="response" name="repsonse"></div>';
   echo '<table border="0" cellpadding="3" cellspacing="3" width="100%">';
   echo '<tr>';
   echo '<td><strong>User Name</strong></td>';
   echo '<td><strong>Nick Name</strong></td>';
   echo '<td><strong>Display Name</strong></td>';
   echo '<td><strong>Email Address</strong></td>';
   echo '<td><strong>Registration Date</strong></td>';
   echo '<td><strong>Status</strong></td>';
   echo '<td><strong>Options</strong></td>';
   echo '</tr>';
   while($data = mc_fetchAssoc($result))
   {
	   $user_id = $data['id'];
   $user_name = $data['user_login'];
   $user_nickname = $data['user_nickname'];
   $display_name = $data['display_name'];
   $user_status = $data['user_status'];
   if($user_status != 0)
   {
	   $status = 'Admin';
   }
   else
   {
	   $status = 'User';
   }
   $user_email = $data['user_email'];
   $reg_date = date("l, F j, Y",strtotime($data['reg_date']));
      echo '<tr>';
      echo '<td>'.$user_name.'</td>';
	  echo '<td>'.$user_nickname.'</td>';
	  echo '<td>'.$display_name.'</td>';
	  echo '<td>'.$user_email.'</td>';
	  echo '<td>'.$reg_date.'</td>';
	  echo '<td>'.$status.'</td>';
	  echo '<td><a href="/mc-admin/users?page=edit&user_id='.$user_id.'"><button type="button" class="btn btn-dark" id="edit">Edit</button></a> <a href="/mc-admin/users?page=drop&user_id='.$user_id.'"><button type="button" class="btn btn-dark" id="delete">Delete</button></a></td>';
	  echo '</tr>';	  
   }
   echo '</table>';
}

function drop_user()
{
   $user_id = $_GET['user_id'];	
   $query = "DELETE FROM mc_metadata WHERE user_id = $user_id";
   $result = mc_query($query);
   if($result)
   {
      $query = "DELETE FROM mc_users WHERE id = $user_id";
      $result = mc_query($query);
	  if($result)
	  {
		  redirect("/mc-admin/users");
	  }
   }
}

function edit_user()
{
	echo '<h4>Edit User</h4>';
	$user_id = $_GET['user_id'];
	$query = "SELECT * FROM mc_users WHERE id = $user_id";
	$result = mc_query($query);
	$data = mc_fetchAssoc($result);
	$user_login = $data['user_login'];
	$user_nickname = $data['user_nickname'];
	$display_name = $data['display_name'];
	$user_email = $data['user_email'];
	$user_firstname = $data['user_firstname'];
	$user_lastname = $data['user_lastname'];
	$user_url = $data['user_url'];
	$user_status = $data['user_status'];  // 1 = admin, 0 = common user
	if($user_status == 1)
	{
		$status = 'Site Admin';
	}
	if($user_status == 0)
	{
		$status = 'Common User';
	}
	?>
	<div id="response"></div>
    <p>Editing User <strong>#<?php echo $user_id;?></strong> ~ <strong><?php echo $display_name;?></strong> who is a <?php echo $status;?></p>
    <script type="text/javascript">
   function update_user() {
	   var user_id = $("#user_id").val();
      var first_name = $("#first_name").val();
	  var last_name = $("#last_name").val();
	  var display_name = $("#display_name").val();
	  var email_address = $("#email_address").val();
	  var user_url = $("#user_url").val();
	  var user_status = $("#user_status").val();
         $.ajax({
			 type: 'POST',
             url: "includes/ajax.php?task=update_user", //the page containing php script
			 data: '&user_id='+user_id+'&first_name='+first_name+'&last_name='+last_name+'&display_name='+display_name+'&user_email='+email_address+'&user_url='+user_url+'&user_status='+user_status,
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
   <div class="row">
     <div class="col">
       <h4>User Login</h4>
       <p><small>Cannot be edited</small></p>
       <input type="text" id="user_login" name="user_login" value="<?php echo $user_login;?>" size="30" disabled>
	   <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>">
     </div>
  </div>
  <p></p>
   <div class="row">
     <div class="col">
       <h4>First Name</h4>
       <p><small>Can be left empty</small></p>
       <input type="text" id="first_name" name="first_name" value="<?php echo $user_firstname;?>" size="30">
     </div>
  </div>
  <p></p>
  <div class="row">
     <div class="col">
       <h4>Last Name</h4>
       <p><small>Can be left empty</small></p>
       <input type="text" id="last_name" name="last_name" value="<?php echo $user_lastname;?>" size="30">
     </div>
  </div>
  <p></p>
  <div class="row">
     <div class="col">
       <h4>Nick Name</h4>
       <p><small>Users Nick Name</small></p>
       <input type="text" id="nick_name" name="nick_name" value="<?php echo $user_nickname;?>" size="30">
     </div>
  </div>
  <p></p>
  <div class="row">
     <div class="col">
       <h4>Display Name</h4>
       <p><small>Users Display Name</small></p>
       <input type="text" id="display_name" name="display_name" value="<?php echo $display_name;?>" size="30">
     </div>
  </div>
  <p></p>
  <div class="row">
     <div class="col">
       <h4>Email Address</h4>
       <p><small>Not to be spammed :)</small></p>
       <input type="text" id="email_address" name="email_address" value="<?php echo $user_email;?>" size="30">
     </div>
  </div>
  <p></p>
  <div class="row">
     <div class="col">
       <h4>User URL</h4>
	   <p><small>Can be left empty</small></p>
       <input type="text" id="user_url" name="user_url" value="<?php echo $user_url;?>" size="30">
     </div>
  </div>
  <p></p>
  <div class="row">
     <div class="col">
       <h4>User Status</h4>
	   <p><small>Admin? User?</small></p>
	   <select name="user_status" id="user_status">
	   <?php
	   if($user_status == 1)
	   {
	      echo '<option value="1">Admin</option>';
		  echo '<option value="0")>User</option>';
	   }
	   if($user_status == 0)
	   {
		  echo '<option value="0">User</option>';
		  echo '<option value="1")>Admin</option>';
	   }
	   ?>
	   </select>
     </div>
  </div>
  <p></p>
  <div class="row">
    <div class="col">
      <button type="button" class="btn btn-dark" name="update" id="update" onclick="update_user()">Update</button>
    </div>
  </div>
	<?php
}

function add_user()
{
   echo '<h4>Add User</h4>';
   ?>
   <div id="add_response"></div>
   <script type="text/javascript">
   function add_user() {
	   var user_login = $("#user_login").val();
	   var user_pass = $("#user_pass").val();
	   var display_name = $("#display_name").val();
	   var email_address = $("#email_address").val();
	   var user_status = $("#user_status").val();
         $.ajax({
			 type: 'POST',
             url: "includes/ajax.php?task=add_user", //the page containing php script
			 data: '&user_login='+user_login+'&user_pass='+user_pass+'&display_name='+display_name+'&user_email='+email_address+'&user_status='+user_status,
			 error: function(data) {
				$('#add_response').css("color" , "red");
                $('#add_response').html("<strong>Error</strong>");
             },
             success: function(data) {
				$('#add_response').css("color" , "green");
                $('#add_response').html("<strong>Success</strong>");
             }
        });
       }
	  
	  </script>
   <div class="row">
     <div class="col">
       <h4>User Login</h4>
       <p><small>User Name</small></p>
       <input type="text" id="user_login" name="user_login" size="30">
     </div>
  </div>
  <p></p>
  <div class="row">
     <div class="col">
       <h4>User Password</h4>
       <p><small>Will be hashed vi SHA1</small></p>
       <input type="text" id="user_pass" name="user_pass" size="30">
     </div>
  </div>
  <p></p>
  <div class="row">
     <div class="col">
       <h4>User Email Address</h4>
       <input type="text" id="email_address" name="email_address" size="30">
     </div>
  </div>
  <p></p>
  <div class="row">
     <div class="col">
       <h4>User Display Name</h4>
       <p><small>Nick Name is Display Name</small></p>
       <input type="text" id="display_name" name="display_name" size="30">
     </div>
  </div>
  <p></p>
  <div class="row">
     <div class="col">
       <h4>User Status</h4>
       <p><small>Admin? Common User?</small></p>
       <select id="user_status" name="user_status">
	   <option value="1">Admin</option>
	   <option value="0">User</option>
	   </select>
     </div>
  </div>
  <p></p>
  <div class="row">
    <div class="col">
      <button type="button" class="btn btn-dark" name="add" id="add" onclick="add_user()">Add User</button>
    </div>
  </div>
   <?php
}


/*
 * Switch
 * Allows function to be used
 * $p is derived from the Function operatives
*/
switch($p)
{
   case 'drop':
      drop_user();
      break;
   case 'edit':
      edit_user();
      break;
   case 'add':
      add_user();
      break;
   
   default:
      users();
      break;
}
echo '</div>';
echo '</div>';