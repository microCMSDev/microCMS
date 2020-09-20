<!-- First Row -->
<div class="row">
  <div class="col">
    <div class="card-columns d-flex justify-content-center">

    <!-- At a Glance -->
       <div class="card">
         <div class="card-header">
           <strong>At a Glance</strong>
         </div>
         <div class="card-body">
           <p class="card-text">
		   <i class="fa fa-tag" aria-hidden="true"></i> <a href="/mc-admin/posts"><strong><?php echo mc_countPosts()?></strong></a> Post
           <br>
           <?php
           $comment_count = count_comments();
           if($comment_count == 1)
           {
              $comment_tense = 'Comment';
           }
           else
           {
              $comment_tense = 'Comments';
           }
           ?>
           <i class="fas fa-comment-dots"></i>  <strong><?php echo $comment_count?></strong> <?php echo $comment_tense;?>
           <br>
           <!--Site Status (Pending)<br>-->
           <?php
           $visits_count = mc_countVisits();
           if($visits_count == 1)
           {
              $visits_tense = 'Site Visit';
           }
           else
           {
              $visits_tense = 'Site Visits';
           }
           ?>
		   <i class="fa fa-map-pin" aria-hidden="true"></i>  <strong><?php echo $visits_count;?></strong> <?php echo $visits_tense;?><br>
	   <?php
           $users_count = mc_countUsers();
           if($users_count == 1)
           {
              $users_tense = 'User';
           }
           else
           {
              $users_tense = 'Users';
           }
           ?>
           <i class="fa fa-user" aria-hidden="true"></i> <a href="/mc-admin/users"><strong><?php echo $users_count;?></strong></a> <?php echo $users_tense;?><br>
           <small>microCMS <i><?php echo mc_version()?></i> Running the <i><?php echo mc_currentTheme()?></i> theme.</small>
          </p>
         </div>
       </div>
       <!-- End At a Glance -->
       
       <!-- Activity -->
       <div class="card">
         <div class="card-header">
           <strong>Activity</strong>
         </div>
         <div class="card-body">
           <p class="card-text">
           <strong>Recently Published</strong><br>
            <?php
			
           $last_posts = mc_lastPosts();
           while($rows = mc_fetchAssoc($last_posts))
           {
             $post_title = $rows['post_title'];
             $post_date = date("M d, Y g:i A",strtotime($rows['post_date']));
             echo '<small><i class="fa fa-tag" aria-hidden="true"></i> '.$post_date.'  <a href="/mc-admin/posts">'.$post_title.'</a></small><br>';
           }
           ?>
           </p>
         </div>
       </div>
       <!-- End Activity -->
       
    </div>
  </div>
 </div>
 <!-- End First Row -->
 
 <!-- Second Row -->
 
<div class="row">
  <div class="col">
    <div class="card-columns d-flex justify-content-center">

      <!-- Sentry -->
      <div class="card">
        <div class="card-header">
          <strong>Sentry</strong>
        </div>
        <div class="card-body">
          <p class="card-text">
          <i class="fa fa-bullseye" aria-hidden="true"></i> <a href="/mc-admin/sentry?page=banned"><strong><?php echo mc_countBadguys()?></strong></a> Bad IP's<hr>
          <p>
          <ul>
          <?php
          $query = "SELECT * FROM mc_bannedip ORDER BY bann_date DESC LIMIT 3";
          $result = mc_query($query);
          while($data = mc_fetchAssoc($result))
          {
             $ip_address = $data['ip'];
             $ip_country = $data['country'];
             echo '<li><img src="/mc-admin/img/country/'.$ip_country.'.svg" height="20" width="20">  '.$ip_address.'</li>';
             
          }
          ?>
          </ul>
          </p>
          <small><a href="/mc-admin/sentry">PHP Sentry</a> Version <?php echo mc_getSentryVersion()?></small>
          </p>
        </div>
      </div>
      <!-- Sentry-->
       
      <!-- News -->
      <div class="card">
        <div class="card-header">
          <strong>News from microCMS dot Org</strong>
        </div>
        <div class="card-body">
          <p class="card-text">
          <?php
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL, "https://www.microcms.org/news.php");
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		  $headers = array();
		  $headers[] = "Accept: application/json";
		  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		  $result = curl_exec($ch);
		  if (curl_errno($ch)) {
			  echo 'Error:' . curl_error($ch);
		  }
		  curl_close ($ch);
		  $data = json_decode($result, true);
		  foreach ($data as $news) {
			  echo '<small><i class="fa fa-info" aria-hidden="true"></i>  <a href="'.$news['url'].'" target="_blank">'.$news['title'].'</a><br/>'.$news['intro'].'</small>';
			  echo '<hr>';
		  }
		  ?>
          </p>
        </div>
      </div>
      <!-- End News -->
    <div>
  </div>
</div>
<!-- End Second Row -->      
