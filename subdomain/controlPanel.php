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
$sql = "SELECT * FROM socialmedia LIMIT 4";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
$facebook = '';
$twitter = '';
$instagram = '';
$youtube = '';
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $id = $row["id"];
		$socialMedia = $row["name"];
    $link = $row["link"];
		if($socialMedia == "facebook") {
			$facebook = $link;
		} else if($socialMedia == "twitter") {
			$twitter = $link;
		} else if($socialMedia == "instagram") {
			$instagram = $link;
		} else if($socialMedia == "youtube") {
			$youtube = $link;
		}
  }
}
?><?php
// Select the member from the users table
$sql = "SELECT * FROM tawk LIMIT 1";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
$tawkPass = '';
$tawkEmail = '';
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $tawkEmail = $row["email"];
		$tawkPass = $row["pass"];
  }
}
?><?php
// Select the member from the users table
$sql = "SELECT * FROM autoreply LIMIT 1";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
$old_autoreply = '';
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$old_autoreply = $row["data"];
		$old_autoreply = nl2br($old_autoreply);
		$old_autoreply = str_replace("&amp;","&",$old_autoreply);
		$old_autoreply = stripslashes($old_autoreply);
  }
}
?><?php
// Select the member from the users table
$PDF = '<h2 class="center-txt slim-txt txt-grey PDFplaceHolder">You have not uploaded any files.</h2>';
$sql = "SELECT * FROM documents ORDER BY date DESC";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
if($numrows > 0){
	$PDF = '';
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$file_name = $row["name"];
		$PDF .= '<a href="../documents/'.$file_name.'" data-name="'.$file_name.'" class="pdf link sm-mar-right sm-mar-top" target="_blank"><i class="absolute sm-pad closePop removePDF">x</i><span class="fa fa-file-pdf-o"></span><br>'.$file_name.'</a>';
  }
}
?><?php
// Select the member from the users table
$photos = '<h2 class="center-txt slim-txt txt-grey photosPlaceHolder">You have not uploaded any photos.</h2>';
$sql = "SELECT * FROM photos ORDER BY date DESC";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
if($numrows > 0){
	$photos = '';
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$file_name = $row["name"];
		$photos .= '<div class="relative inline-blk"><i class="absolute xs-pad closePop sm-right removePhoto pointer">x</i><img src="../photos/'.$file_name.'" data-name="'.$file_name.'" alt="" class="sm-pad sm-mar-bottom thumbnail sm-mar-right border-1 border-subtle" height="100px"></div>';
  }
}
?><?php
if(isset($_POST["facebook"])){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$db_facebook = $_POST['facebook'];
	$db_twitter = $_POST['twitter'];
	$db_instagram = $_POST['instagram'];
	$db_youtube = $_POST['youtube'];

	// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
	$sql = "UPDATE socialmedia SET link='$db_facebook', date=now() WHERE name='facebook' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);

	$sql = "UPDATE socialmedia SET link='$db_twitter', date=now() WHERE name='twitter' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);

	$sql = "UPDATE socialmedia SET link='$db_instagram', date=now() WHERE name='instagram' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);

	$sql = "UPDATE socialmedia SET link='$db_youtube', date=now() WHERE name='youtube' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	echo "success";
	exit();

}
?><?php
if(isset($_POST["autoreply"])){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$autoreply = $_POST['autoreply'];
	$autoreply = mysqli_real_escape_string($db_conx, $autoreply);

	// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
	$sql = "UPDATE autoreply SET data='$autoreply', date=now() WHERE id=1 LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	echo "success";
	exit();

}
?><?php
if(isset($_POST["type"]) && $_POST['type'] == 'remove PDF'){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$fileName = $_POST['name'];
	$directory = '../documents/'.$fileName;
	// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
	$sql = "DELETE FROM documents WHERE name='$fileName' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	if (file_exists($directory)) {
    unlink($directory);
  }
	echo "success";
	exit();

}
?><?php
if(isset($_POST["type"]) && $_POST['type'] == 'remove photo'){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$fileName = $_POST['name'];
	$directory = '../photos/'.$fileName;
	// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
	$sql = "DELETE FROM photos WHERE name='$fileName' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	if (file_exists($directory)) {
    unlink($directory);
  }
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
  <body class="controlPanel" data-pageName="control">

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

		<div class="fixed bg-pop">
		</div>

		<div class="fixed col-xs-6 center-center uploadPop bg-white md-pad" id="PDFPop">
			<a href="#" class="absolute sm-pad closePop" id="closePDF">x</a>
			<div class="uploadArea width-90 lg-txt" id="uploadPDF">
				Drag a File Inside This Box.
			</div>
		</div>


    <main class="mainPanel">
			<div class="row">

				<div class="column">
					<h3 class="no-mar-bottom">tawk.to LiveChat</h3>
					<div class="bg-white">
						<div class="section row">
							<div class="col-xs-2">
								<img src="https://www.tawk.to/wp-content/uploads/2015/04/tawky_big.png" alt="" class="width-80">
							</div>
							<div class="col-xs-8">
								<h4 class="slim-txt">Default Email: <strong><?php echo $tawkEmail; ?></strong></h4>
								<h4 class="slim-txt">Default Password: <strong><?php echo $tawkPass; ?></strong></h4>
							</div>
							<div class="col-xs-2 border-0 border-1-left center-txt">
								<a href="https://dashboard.tawk.to/login" target="_blank" class="link txt-grey sm-pad md-txt md-mar-top sm-mar-bottom blk">Sign In</a>
							</div>
						</div>
					</div>
				</div>
<!--
				<div class="column">
					<h3 class="no-mar-bottom">Imgur (Store Online Photos)</h3>
					<div class="bg-white">
						<div class="section row">
							<div class="col-xs-2">
								<img src="https://s.imgur.com/images/imgur-logo.svg?1" alt="" class="width-80 md-mar-top">
							</div>
							<div class="col-xs-8">
								<h4 class="slim-txt">Default Email: <strong>ahmad@inlinemotors.ca</strong></h4>
								<h4 class="slim-txt">Default Password: <strong>inlinemotors123</strong></h4>
							</div>
							<div class="col-xs-2 border-0 border-1-left center-txt">
								<a href="https://imgur.com/signin?redirect=https%3A%2F%2Fimgur.com%2F" class="link txt-grey sm-pad md-txt md-mar-top sm-mar-bottom blk">Sign In</a>
							</div>
						</div>
					</div>
				</div> -->


				<div class="column">
					<h3 class="no-mar-bottom">Social Media Links</h3>
					<div class="bg-white">
						<div class="section row">
							<div class="col-xs-12" id="socialMedia">
								<label class="blk sm-mar-left"><span class="fa fa-facebook txt-facebook"></span> Facebook:</label>
								<input type="text" name="email" id="facebook" placeholder="e.g. https://example.com" value="<?php echo $facebook; ?>" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
								<label class="blk sm-mar-left"><span class="fa fa-twitter txt-twitter"></span> Twitter:</label>
								<input type="text" name="email" id="twitter" placeholder="e.g. https://example.com" value="<?php echo $twitter; ?>" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
								<label class="blk sm-mar-left"><span class="fa fa-instagram"></span> Instagram:</label>
								<input type="text" name="email" id="instagram" placeholder="e.g. https://example.com" value="<?php echo $instagram; ?>" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
								<label class="blk sm-mar-left"><span class="fa fa-youtube-play txt-alert"></span> YouTube:</label>
								<input type="text" name="email" id="youtube" placeholder="e.g. https://example.com" value="<?php echo $youtube; ?>" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
							</div>
							<div class="col-xs-3 col-xs-push-9 center-txt">
	              <input type="submit" name="save" value="Save" id="saveMedia" class="btn btn-inverse-google-blue lg-btn lg-pad-left lg-pad-right sm-mar">
							</div>
						</div>
					</div>
				</div>

				<div class="column">
					<h3 class="no-mar-bottom">Email AutoReply Message</h3>
					<div class="bg-white">
						<div class="section row">
							<div class="col-xs-12" id="autoreplyMessage">
								<label class="blk sm-mar-top sm-mar-bottom"> This will be sent as an automated message when someone contacts your website:</label>
								<textarea name="Large Description" id="autoreply"><?php echo $old_autoreply; ?></textarea>
							</div>
							<div class="col-xs-3 col-xs-push-9 center-txt">
								<input type="submit" name="save" value="Save" id="saveMessage" class="btn btn-inverse-google-blue lg-btn lg-pad-left lg-pad-right sm-mar">
							</div>
						</div>
					</div>
				</div>

				<!-- <div class="column">
					<h3 class="no-mar-bottom">Photos</h3>
					<div class="bg-white">
						<div class="section row">
							<div class="col-xs-12 photos border-2 border-subtle md-pad">
								<?php
								//  echo $photos;
								 ?>
							</div>
							<div class="col-xs-3 col-xs-push-8 center-txt">
								<input type="submit" name="save" value="Upload a Photo" class="btn btn-inverse-google-blue lg-btn lg-pad-left lg-pad-right sm-mar OpenFileUploader">
							</div>
						</div>
					</div>
				</div> -->

				<div class="column">
					<h3 class="no-mar-bottom">Documents</h3>
					<div class="bg-white">
						<div class="section row">
							<div class="col-xs-12 pdfFiles border-2 border-subtle md-pad">
								<?php echo $PDF ?>
							</div>
							<div class="col-xs-3 col-xs-push-8 center-txt">
								<input type="submit" name="save" value="Upload a PDF" class="btn btn-inverse-google-blue lg-btn lg-pad-left lg-pad-right sm-mar OpenFileUploader">
							</div>
						</div>
					</div>
				</div>

				<div class="column lg-mar-bottom">
					<h3 class="no-mar-bottom">Help</h3>
					<div class="bg-white">
						<div class="section row">
							<div class="col-xs-12">
								<h2>Control Panel</h2>
								<ul class="ul-md">
									<li><u>Link to tawk.to (LiveChat).</u><strong> NOTE: If you have changed the email or password from default, they will not update on this website.</strong></li>
									<li><u>Social medai links:</u> You can update or change your social media links for your website. If you do not have an account in one of the specified social media websites, simply leave them <strong>blank</strong>.</li>
									<li><u>Email AutoReply Message:</u> You can type out a message the same way you would on a Word Document. When you save, the message that you typed inside the box will be stored on the database and will be sent to a customer as an automated message whenever they contact you.</li>
									<!-- <li><u>Photos:</u> This is where you can upload any photos you'd like. If you'd like to get the link address of the image, simply right-click on the image, and choose "<strong>Copy image address</strong>".In order to <strong> delete</strong> any of them, simply click on the little "x" on the top right.</li> -->
									<li><u>Documents:</u> This is where you can upload any PDF documents. In order to <strong> delete</strong> any of them, simply click on the little "x" on the top right.</li>
								</ul>
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

				$('.OpenFileUploader').on('click', function() {
					$('#PDFPop').fadeIn(300);
					$('.bg-pop').fadeIn(300);
				})

				$('#closePDF').on('click', function() {
					$('#PDFPop').fadeOut(300);
					$('.bg-pop').fadeOut(300);
				})

				$('.removePDF').on('click', function() {
					var element = $(this).parent();
					var name = $(this).parent().attr('data-name');
					element.attr('target', '');
					element.attr('href', '#');
					$.post('controlPanel.php', {
						name: name,
						type: 'remove PDF'

					}, function(data) {
						if(data == "") {
							$('.pdfFiles').text('Sorry, something went wrong');

						} else if (data == "failed") {
							$('.pdfFiles').text('Sorry, something went wrong');

						} else if (data == "success") {
							element.css('display', 'none');
						} else {
							alert(data);
						}
					})
				})

				$('.removePhoto').on('click', function() {
					var thisElement = $(this);
					var element = $(this).next();
					var name = element.attr('data-name');
					$.post('controlPanel.php', {
						name: name,
						type: 'remove photo'

					}, function(data) {
						if(data == "") {
							$('.photos').text('Sorry, something went wrong');

						} else if (data == "failed") {
							$('.photos').text('Sorry, something went wrong');

						} else if (data == "success") {
							thisElement.parent().css('display', 'none');
						} else {
							alert(data);
						}
					})
				})

				var uploadPDF = document.getElementById('uploadPDF');
				var displayUploads = function(data) {
					console.log(data);
					var result = JSON.parse(data);
					for (var i = 0; i < result.length; i++) {
						var fileArray = result[i].file.split('.');
						var fileExt = fileArray[fileArray.length -1];
						fileExt = fileExt.toUpperCase();
						if (fileExt == "PDF") {
							$('.pdfFiles').append('<a href="'+result[i].file+'" class="pdf link" target="_blank"><span class="fa fa-file-pdf-o"></span><br>'+result[i].name+'</a>');
							if($('.PDFplaceHolder')) {
								$('.PDFplaceHolder').css('display', 'none');
							}
						} else if (fileExt == "GIF" || fileExt == "JPG" || fileExt == "JPEG" || fileExt == "TIF" || fileExt == "TIFF" || fileExt == "PNG") {
							$('.photos').append('<img src="'+result[i].file+'" alt="" class="sm-pad sm-mar-bottom thumbnail sm-mar-right border-1 border-subtle" height="100px">');
							if($('.photosPlaceHolder')) {
								$('.photosPlaceHolder').css('display', 'none');
							}
						}

					}
					$('.background-loader').fadeOut(300);
					$('#PDFPop').fadeOut(300);
					$('.bg-pop').fadeOut(300);
				};

				var uploadFiles = function(files) {
					var formData = new FormData(),
							xhr = new XMLHttpRequest(),
							x;

					for(x = 0; x < files.length; x++) {
						formData.append('files[]', files[x]);
					}

					xhr.onload = function() {
						var data = this.responseText;
						displayUploads(data);
					}

					xhr.open('post', 'upload.php');
					xhr.send(formData);
				};

				uploadPDF.ondrop = function(e) {
					$('.background-loader').fadeIn(300);
					e.preventDefault();
					$('#uploadPDF').removeClass('dragover');
					uploadFiles(e.dataTransfer.files);
				};

				uploadPDF.ondragover = function() {
					$('#uploadPDF').addClass('dragover');
					return false;
				};

				uploadPDF.ondragleave = function() {
					$('#uploadPDF').removeClass('dragover');
					return false;
				};
			})();
		</script>

		<script type="text/javascript">
			(function() {


				$('#saveMedia').on('click', function() {
					var facebook = $('#facebook').val();
					var twitter = $('#twitter').val();
					var instagram = $('#instagram').val();
					var youtube = $('#youtube').val();
					$('#saveMedia').disabled = true;

					$.post('controlPanel.php', {
						facebook: facebook,
						twitter: twitter,
						instagram: instagram,
						youtube: youtube

					}, function(data) {
						if(data == "") {
							$('#socialMedia').text('Sorry, something went wrong');

						} else if (data == "failed") {
							$('#socialMedia').text('Sorry, something went wrong');

						} else if (data == "success") {
							$('#socialMedia').html('<h1 style="color: #1AB188;" class="center-txt"><i class="fa fa-check-circle-o fa-3x"></i></h1><h2 class="font-grey center-txt">Social media links have been successfully updated.</h2>');
							$('#saveMedia').css('display', 'none');
						} else {
							alert(data);
						}
						$('#saveMedia').disabled = false;
					})
				})

				$('#saveMessage').on('click', function() {
					var autoreply = tinyMCE.get('autoreply').getContent();
					$('#saveMessage').disabled = true;

					$.post('controlPanel.php', {
						autoreply: autoreply

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
