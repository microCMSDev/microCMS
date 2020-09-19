<div class="row">
<div class="col">
<h1>Updates</h1>
<?php
$this_version = mc_version();
$url = "https://control.microcms.org/version_check.php?id=1";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_NOBODY, FALSE); // remove body
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$content  = curl_exec($ch);
$remote_version = trim($content);
curl_close($ch);
echo '<h4>Core</h4>';
if($this_version !== $remote_version)
{
	echo '<p>Your Version '.$this_version.' is out of date, version '.$remote_version.' is available.</p>';
	echo '<p><a href="https://control.microcms.org/files/microCMS/microCMS-'.$remote_version.'.zip"><button class="btn btn-dark">Get microCMS-'.$remote_version.'</button></a>';
}
else
{
	echo '<p>This version - '.$this_version.' is up to date.</p>';
}
?>
<hr>
</div>
</div>