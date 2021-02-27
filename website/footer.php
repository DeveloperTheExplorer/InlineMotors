<?php
// Select the member from the users table
$sql = "SELECT * FROM socialmedia LIMIT 4";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
$facebook = '';
$twitter = '';
$instagram = '';
$youtube = '';
$link = '';
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $id = $row["id"];
		$socialMedia = $row["name"];
    $link = $row["link"];
		if($socialMedia == "facebook" && $link != "") {
			$facebook = $link;
      $facebook = '<a href="'.$facebook.'" target="_blank" class="facebook md-transition"><span class="fa fa-facebook"></span></a>';

    } else if($socialMedia == "twitter" && $link != "") {
			$twitter = $link;
      $twitter = '<a href="'.$twitter.'" target="_blank" class="twitter md-transition"><span class="fa fa-twitter"></span></a>';

		} else if($socialMedia == "instagram" && $link != "") {
			$instagram = $link;
      $instagram = '<a href="'.$instagram.'" target="_blank" class="instagram md-transition"><span class="fa fa-instagram"></span></a>';

		} else if($socialMedia == "youtube" && $link != "") {
			$youtube = $link;
		}
  }

}
?>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
        <h3>Inline Motors</h3>
        <hr/>
        <h4 class="slim-txt"><?php echo $address1 ?><br/><?php echo $city ?>, <?php echo $province ?> <?php echo $postalCode ?><br/>Phone: <?php echo $phone ?><br/>Fax: <?php echo $fax ?><br/>Dealer License Number: <?php echo $license ?></h4>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
        <h3>Hours Of Operation</h3>
        <hr/>
        <h4 class="slim-txt">Monday to Saturday : 10:00am to 7:00pm<br/><br/>Sunday/ Holidays : 11:00am to 5:00pm</h4>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <h3>Website</h3>
        <hr/>
        <ul class="no-mar no-pad">
          <li><a href="vehicles.php?coming=soon" class="ic-fb"><span class="fa fa-external-link"></span> Coming Soon</a></li>
          <li><a href="contact.php" class="ic-tw"><span class="fa fa-external-link"></span> Contact Us / Map</a></li>
          <li><a href="credit-application.php" class="ic-tw"><span class="fa fa-external-link"></span> Credit Application</a></li>
          <li><a href="privacy-policy.php" class="ic-tw"><span class="fa fa-external-link"></span> Privacy Policy</a></li>
          <li><a href="terms-of-use.php" class="ic-tw"><span class="fa fa-external-link"></span> Terms of Use</a></li>
          <li><a href="sitemap.php" class="ic-tw"><span class="fa fa-external-link"></span> Sitemap</a></li>
        </ul>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3 class="social-container">Social Media: <?php echo $facebook.$twitter.$instagram.$youtube; ?></h3>
        <hr/>
        <h2 class="center-txt font-black">Copyright &copy; Inline Motors</h2>
      </div>
    </div>
  </div>
</footer>

<!-- Start of Tawk.to Script-->
<script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/59e3f8be4854b82732ff5b91/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
  })();
</script>
<!-- End of Tawk.to Script-->
