<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	  ini_set('display_errors', '1');
      ini_set('display_startup_errors', '1');
      error_reporting(E_ALL);
	  $blogs = new site\blogs;
	  $mcdb = new database\db;
      $post = $blogs->get_blogbySlug($slug);
	  $content = $mcdb->fetch_assoc($post);
      $post_title = $content['post_title'];
      $post_exerpt = $content['post_exerpt'];
      $post_content = $content['post_contents'];
      $post_date = date("l, F j, Y",strtotime($content['post_date']));
      $post_author = $content['post_author'];
      $post_id = $content['id'];
      $allow_comments = $content['allow_comments'];
	  $timestamp = date("Y-m-d H:i:s", strtotime($content['post_date']));
	  $uts = strtotime($timestamp);
	  $ago = ago($uts);
      
      // Schema Specific Information
      $schema_date = date("Y-m-d",strtotime($content['post_date']));
      $schema_slug = $content['post_slug'];
   ?>
   <!-- This file should include mostly HTML with a little PHP to produce any results -->
   <div class="container show_post">

    <div class="row">
      <div class="col">
        <article>
        <h1><?php echo $post_title;?></h1>
      </div>
      <div class="col-xs">
        <hr>
      </div>
    </div>
  
    <div class="row">
      <div class="col">
        <p><?php echo $post_exerpt;?></p>
        <?php echo $post_content;?>
        <p><?php echo $ago;?> by <strong><?php echo $post_author;?></strong> on <?php echo $post_date;?></p>
        <div class="social">
          <div id="facebook" class="facebook"><button class="social_button" data-js="facebook-share"><i class="fa fa-facebook" aria-hidden="true"></i></button></div>
          <div id="twitter" class="twitter"><button class="social_button" data-js="twitter-share"><i class="fa fa-twitter" aria-hidden="true"></i></button></div>
          <div id="likePost"><button class="social_button" onclick="postLike();"><i class="fa fa-heart" aria-hidden="true"></i></button></div>
          <div id="response"></div>
        </div>
        </article>
		<hr>
      </div>
    </div>
	
	<?php
	// Get the comments for this post
	$query = "SELECT * FROM mc_metadata WHERE post_id = $post_id";
	$result = mc_query($query);
	while($data = mc_fetchAssoc($result))
	{
		$user_name = $data['user_name'];
		$comment_date = date("l, F j, Y",strtotime($data['content_date']));
		$comment = $data['content'];
		$timestamp = date("Y-m-d H:i:s", strtotime($data['content_date']));
		$uts = strtotime($timestamp);
		$comment_ago = ago($uts);
		echo '<div class="row">';
		echo '<div class="col">';
		echo '<p>'.$comment_ago.' by <strong>'.$user_name.'</strong> on <strong>'.$comment_date.'</strong><br>'.$comment.'</p>';
		echo '<hr>';
		echo '</div>';
		echo '</div>';
	}
	echo '<div class="row">';
    echo '<div class="col">';
	if($allow_comments != 0)
	{
       if(isset($_SESSION['user_id']))
       {
		  $user_id = $_SESSION['user_id'];
		  $user = $_SESSION['display_name'];
		  echo '<div id="response"></div>';
		  echo '<textarea id="comment" name="comment" cols="50" rows="10"></textarea>';
		  echo '<input type="hidden" name="user" id="user" value="'.$user.'">';
		  echo '<input type="hidden" name="user_id" id="user_id" value="'.$user_id.'">';
		  echo '<input type="hidden" name="post_id" id="post_id" value="'.$post_id.'">';
		  echo '<br><button class="btn btn-dark" name="submit" id="submit" onclick="send_comment()">Comment</button>';
		  echo '<hr>';
       }
	   else
	   {
		   echo '<p><a href="'.mc_login_url().'"><button class="btn btn-dark">Login to Comment</button></a></p>';
	   }
	}
	else
	{
		echo '<p><strong>This Post has been locked</strong>, no comments are allowed</p>';
	}
	echo '</div>';
	echo '</div>';
  ?>
	
  </div>
    <script type="text/javascript">
      function postLike() {
		  var like_id = '<?php echo $post_id;?>';
         $.ajax({
			type: 'post',
            url: 'mc-includes/ajax.php?task=like_post', //the page containing php script
			data: '&like_id='+like_id,
			error: function(data) {
				$('#add_response').css("color" , "red");
                $('#add_response').html("<strong>Error</strong>");
             },
            success: function(data) {
				$('#response').css("color" , "green");
                $('#response').html("Thanks for that like ;)");
            }
         });
       }
	   function send_comment() {
		  var post_id = $('#post_id').val();
		  var user_id = $('#user_id').val();
		  var display_name = $('#user').val();
		  var comment = $('#comment').val();
         $.ajax({
			type: 'post',
            url: 'mc-includes/ajax.php?task=post_comment', //the page containing php script
			data: '&post_id='+post_id+'&user_id='+user_id+'&display_name='+display_name+'&comment='+comment,
			error: function(data) {
				$('#add_response').css("color" , "red");
                $('#add_response').html("<strong>Error :(</strong>");
             },
            success: function(data) {
				$('#response').css("color" , "green");
                $('#response').html("Success :)");
				$('#comment').val('');
            }
         });
       }
	   
	   
	   
       var facebookShare = document.querySelector('[data-js="facebook-share"]');
       facebookShare.onclick = function(e) {
  e.preventDefault();
  var facebookWindow = window.open('https://www.facebook.com/sharer/sharer.php?u=' + document.URL, 'facebook-popup', 'height=350,width=600');
  if(facebookWindow.focus) { facebookWindow.focus(); }
    return false;
}

var twitterShare = document.querySelector('[data-js="twitter-share"]');

twitterShare.onclick = function(e) {
  e.preventDefault();
  var twitterWindow = window.open('https://twitter.com/share?url=' + document.URL, 'twitter-popup', 'height=350,width=600');
  if(twitterWindow.focus) { twitterWindow.focus(); }
    return false;
  }
  </script>
	  
  <script type=”application/ld+json”>
{
“@context”: “http://schema.org”,
“@type”: “BlogPosting”,
“mainEntityOfPage”:{
“@type”:”WebPage”,
“@id”:”<?php echo $_SERVER['REQUEST_SCHEME'];?>'://'<?php echo $_SERVER['SERVER_NAME'];?>/posts/<?php echo $schema_slug;?>”
},
“headline”: “<?php echo $post_title;?>”,
“datePublished”: “<?php echo $schema_date;?>”,
“author”: {
“@type”: “Person”,
“name”: “<?php echo $post_author;?>”
},
“description”: “<?php echo $post_exerpt;?>”,
“articleBody”: “<?php echo $post_content;?>”
}
</script>
<?php 
}
