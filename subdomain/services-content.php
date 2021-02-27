<?php
	include_once("../php_includes/check_login_status.php");

  if (!isset($_COOKIE['email'])) {
    header('location: index.php');
  } else {
    setcookie("id", $log_id, time()+3600);
    setcookie("email", $log_email, time()+3600);
    setcookie("pass", $log_pass, time()+3600);
  }
?><?php
// Select the member from the users table
$sql = "SELECT * FROM services LIMIT 1";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
$old_services = '';
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$old_services = $row["data"];
		$old_services = nl2br($old_services);
		$old_services = str_replace("&amp;","&",$old_services);
		$old_services = stripslashes($old_services);
  }
}
?><?php
if(isset($_POST["services"])){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$services = $_POST['services'];
	$services = mysqli_real_escape_string($db_conx, $services);

	// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
	$sql = "UPDATE services SET data='$services', date=now() WHERE id=1 LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	echo "success";
	exit();

}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags-->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Inline Motors</title>
    <link rel="shortcut icon" type="image/png" href="../style/img/logo_icon.png">
    <link rel="stylesheet" href="../style/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../style/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,500" rel="stylesheet">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <script type="text/javascript" src="../js/jquery-2.1.4.js"></script>
    <script src="../style/bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="controlPanel" data-pageName="services">

		<script type="text/javascript" src="../tinymce/tinymce.min.js"></script>
		<script type="text/javascript">

			$(function() {
				tinymce.init({
					plugins: [
			        "advlist autolink lists link image charmap print preview anchor",
			        "searchreplace visualblocks fullscreen textcolor colorpicker",
			        "insertdatetime media table contextmenu paste imagetools hr"
			    ],
			    toolbar: "insertfile undo redo | styleselect fontselect fontsizeselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
					selector: "#autoreply"
				});
			});
		</script>

    <?php include_once('nav.php'); ?>
		<!-- Loading stuff -->
		<div class="background-loader">
		  <div class="loader">
		    <span class="spinner spinner1"></span>
		    <span class="spinner spinner2"></span>
		    <span class="spinner spinner3"></span>
		    <br>
		    <span class="loader-text">LOADING...</span>
		  </div>
		</div>


    <main class="mainPanel">
			<div class="row">

				<div class="column">
					<h3 class="no-mar-bottom">Services Content Page</h3>
					<div class="bg-white">
						<div class="section row">
							<div class="col-xs-12" id="autoreplyMessage">
								<label class="blk sm-mar-top sm-mar-bottom"> This will be shown as the content on the "Services" page:</label>
								<textarea name="Large Description" id="autoreply"><?php echo $old_services; ?></textarea>
							</div>
							<div class="col-xs-3 col-xs-push-9 center-txt">
								<input type="submit" name="save" value="Save" id="saveMessage" class="btn btn-inverse-google-blue lg-btn lg-pad-left lg-pad-right sm-mar">
							</div>
						</div>
					</div>
				</div>

			</div>
    </main>

		<script type="text/javascript">
			(function() {
				var pageName = $('body').attr('data-pageName');
		    $('.'+pageName).addClass('active');

				$('a').on('click', function() {
					if($(this).attr('href') == "#") {
						return false;
					}
				})

				window.onload = function() {
					$('.background-loader').fadeOut(300);
				}

			})();
		</script>

		<script type="text/javascript">
			(function() {

				$('#saveMessage').on('click', function() {
					var autoreply = tinyMCE.get('autoreply').getContent();
					$('#saveMessage').disabled = true;

					$.post('services-content.php', {
						services: autoreply

					}, function(data) {
						if(data == "") {
							$('#autoreplyMessage').text('Sorry, something went wrong');

						} else if (data == "failed") {
							$('#autoreplyMessage').text('Sorry, something went wrong');

						} else if (data == "success") {
							$('#autoreplyMessage').html('<h1 style="color: #1AB188;" class="center-txt"><i class="fa fa-check-circle-o fa-3x"></i></h1><h2 class="font-grey center-txt">Your email autoreply message have been successfully updated.</h2>');
							$('#saveMessage').css('display', 'none');
						} else {
							alert(data);
						}
						$('#saveMessage').disabled = false;
					})
				})

			})();


		</script>
  </body>
</html>
<!-- V3M4H5 -->
