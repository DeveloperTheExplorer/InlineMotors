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
$sql = "SELECT * FROM tawk LIMIT 1";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
$tawkEmail = '';
$tawkPass = '';
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
  	$tawkEmail = $row["email"];
    $tawkPass = $row["pass"];
  }
}
?><?php
$sql = "SELECT * FROM users ORDER BY id ASC";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
$accountList = '';
$accountList1 = '';
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$id = $row["id"];
  	$email = $row["email"];
		$unhashedPass = $row["unhashedPass"];
		if($id == $log_id) {
			$accountList1 = '<div class="col-xs-12 account" id="account'.$id.'">
			                  <span class="col-xs-5"><span class="fa fa-envelope-o"></span> Email: <strong>'.$email.'</strong></span>
			                  <span class="col-xs-4"><span class="fa fa-lock"></span> Password: <strong>'.$unhashedPass.'</strong></span>
			                </div>';
		} else {
			$accountList .= '<div class="col-xs-12 account" id="account'.$id.'" data-accountid="'.$id.'">
												<span class="col-xs-5"><span class="fa fa-envelope-o"></span> Email: <strong>'.$email.'</strong></span>
												<span class="col-xs-4"><span class="fa fa-lock"></span> Password: <strong>'.$unhashedPass.'</strong></span>
												<span class="col-xs-1 col-xs-push-2 txt-alert md-txt pointer removeAccount"><i class="fa fa-trash" aria-hidden="true"></i></span>
											</div>';
		}
  }
}
?><?php
$sql = "SELECT * FROM address WHERE id=1 LIMIT 1";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$companyName = $row['name'];
		$address1 = $row['address1'];
		$address2 = $row['address2'];
		$city = $row['city'];
		$province = $row['province'];
		$postalCode = $row['postalCode'];
		$phoneNumber = $row['phone'];
		$fax = $row['fax'];
		$companyEmail = $row['email'];
		$hideEmail = $row['hideEmail'];
		$license = $row['license'];
		$checked = '';
		if($hideEmail == 1) {
			$checked = 'checked';
		}

  }
}
?><?php
$sql = "SELECT * FROM users WHERE id=$log_id LIMIT 1";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
  	$email = $row["email"];
  }
}
?><?php
if(isset($_POST["tawkEmail"])){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$db_tawkEmail = $_POST['tawkEmail'];
	$db_tawkPass = $_POST['tawkPass'];

	// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
	$sql = "UPDATE tawk SET email='$db_tawkEmail', pass='$db_tawkPass', date=now() WHERE id=1 LIMIT 1";
	$query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));

	echo "success";
	exit();

}
?><?php
if(isset($_POST["loginEmail"])){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$db_loginEmail = $_POST['loginEmail'];
  $db_loginPass = md5($_POST['loginPass']);
  if($_POST['loginPass'] == "") {
    $db_loginPass = $log_pass;
  }

  // UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
	$sql = "UPDATE users SET email='$db_loginEmail', pass='$db_loginPass', lastUse=now() WHERE id=$log_id LIMIT 1";
	$query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));

  $_SESSION['userid'] = $log_id;
  $_SESSION['email'] = $db_loginEmail;
  $_SESSION['pass'] = $db_loginPass;
  setcookie("id", $log_id, time()+3600);
  setcookie("email", $db_loginEmail, time()+3600);
  setcookie("pass", $db_loginPass, time()+3600);

	echo "success";
	exit();

}
?><?php
if(isset($_POST["addEmail"])){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$db_addEmail = $_POST['addEmail'];
	$db_addPass = md5($_POST['addPass']);
	$db_unhashedPass = $_POST['addPass'];
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

	// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
	$sql = "INSERT INTO users(email, pass, unhashedPass, ip, lastUse, created)
			VALUES('$db_addEmail','$db_addPass','$db_unhashedPass','$ip',now(),now())";
	$query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));
	$id = mysqli_insert_id($db_conx);

	echo "success|".$id;
	exit();

}
?><?php
if(isset($_POST["remove"]) && $_POST['remove'] == 'account'){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$id = $_POST['id'];
	// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
	$sql = "DELETE FROM users WHERE id='$id' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	echo "success";
	exit();
}
?><?php
if(isset($_POST["address1"])){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$db_companyName = $_POST['companyName'];
	$db_address1 = $_POST['address1'];
	$db_address2 = $_POST['address2'];
	$db_city = $_POST['city'];
	$db_province = $_POST['province'];
	$db_postalCode = $_POST['postalCode'];
	$db_phoneNumber = $_POST['phoneNumber'];
	$db_fax = $_POST['fax'];
	$db_email = $_POST['email'];
	$db_emailCheck = $_POST['emailCheck'];
	$db_license = $_POST['license'];

	// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
	$sql = "UPDATE address SET name='$db_companyName', address1='$db_address1', address2='$db_address2', city='$db_city', province='$db_province', postalCode='$db_postalCode', phone='$db_phoneNumber', fax='$db_fax', email='$db_email', hideEmail='$db_emailCheck', license='$db_license', date=now() WHERE id=1 LIMIT 1";
	$query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));

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
  <body class="controlPanel" data-pageName="settings">

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
					<h3 class="no-mar-bottom">tawk.to LiveChat</h3>
					<div class="bg-white">
						<div class="section row">
              <div class="col-xs-12" id="tawk">
                <label class="blk sm-mar-left"><span class="fa fa-envelope-o"></span> Email:</label>
                <input type="text" name="email" id="tawkEmail" value="<?php echo $tawkEmail; ?>" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
                <label class="blk sm-mar-left"><span class="fa fa-lock"></span> Password:</label>
                <input type="text" name="pass" id="tawkPass" value="<?php echo $tawkPass; ?>" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-xs-3 col-xs-push-9 center-txt">
                <input type="submit" name="save" value="Save" id="saveTawk" class="btn btn-inverse-google-blue lg-btn lg-pad-left lg-pad-right sm-mar">
              </div>
						</div>
					</div>
				</div>


        <div class="column">
					<h3 class="no-mar-bottom">Change Your Login Information</h3>
					<div class="bg-white">
						<div class="section row">
              <div class="col-xs-12" id="login">
                <label class="blk sm-mar-left"><span class="fa fa-envelope-o"></span> Email:</label>
                <input type="text" name="email" id="loginEmail" value="<?php echo $email; ?>" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
                <label class="blk sm-mar-left"><span class="fa fa-lock"></span> Password:</label>
                <input type="text" name="email" id="loginPass" value="" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
                <label class="blk sm-mar-left">Leave this field blank unless you want to change the password.</label>
              </div>
              <div class="col-xs-3 col-xs-push-9 center-txt">
                <input type="submit" name="save" value="Save" id="saveLogin" class="btn btn-inverse-google-blue lg-btn lg-pad-left lg-pad-right sm-mar">
              </div>
						</div>
					</div>
				</div>

				<div class="column">
					<h3 class="no-mar-bottom">Add/Delete Login Accounts</h3>
					<div class="bg-white">
						<div class="section row">
              <div class="col-xs-12" id="addAccount">
                <label class="blk sm-mar-left"><span class="fa fa-envelope-o"></span> Email:</label>
                <input type="text" name="email" id="addEmail" value="" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
                <label class="blk sm-mar-left"><span class="fa fa-lock"></span> Password:</label>
                <input type="text" name="email" id="addPass" value="" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-xs-12 accountList row md-mar-top">
                <?php echo $accountList1; ?>
                <?php echo $accountList; ?>
              </div>
              <div class="col-xs-3 col-xs-push-9 center-txt md-mar-top">
                <input type="submit" name="save" value="Save" id="saveAdd" class="btn btn-inverse-google-blue lg-btn lg-pad-left lg-pad-right sm-mar">
              </div>
						</div>
					</div>
				</div>


				<div class="column">
					<h3 class="no-mar-bottom">Dealership Information</h3>
					<div class="bg-white">
						<div class="section row" id="address">
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Comapny Name</label>
                <input type="text" name="companyName" id="companyName" value="<?php echo $companyName ?>" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Address 1</label>
                <input type="text" name="address1" id="address1" value="<?php echo $address1 ?>" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Address 2</label>
                <input type="text" name="address2" id="address2" value="<?php echo $address2 ?>" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">City</label>
                <input type="text" name="city" id="city" value="<?php echo $city ?>" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Province</label>
                <input type="text" name="province" id="province" value="<?php echo $province ?>" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Postal Code</label>
                <input type="text" name="postalCode" id="postalCode" value="<?php echo $postalCode ?>" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Phone Number (format: 123-456-7890)</label>
                <input type="text" name="phoneNumber" id="phoneNumber" value="<?php echo $phoneNumber ?>" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Fax Number (format: 123-456-7890)</label>
                <input type="text" name="fax" id="fax" value="<?php echo $fax ?>" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Main E-Mail</label>
                <input type="text" name="email" id="email" value="<?php echo $companyEmail ?>" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">License #</label>
                <input type="text" name="license" id="license" value="<?php echo $license ?>" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-12">
                <label class="checkboxLabel sm-mar-left">
                  <input type="checkbox" id="emailCheck" <?php echo $checked ?> >
                  <div class="stylishCheckbox"></div><span>Do not show email address on website</span>
                </label>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left opacity-0"> a</label>
                <input type="submit" name="update" id="update" value="Update" class="btn btn-inverse-black lg-btn lg-pad-left lg-pad-right sm-mar-left sm-mar-bottom width-90">
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
									<li><u>Photos:</u> This is where you can upload any photos you'd like. If you'd like to get the link address of the image, simply right-click on the image, and choose "<strong>Copy image address</strong>".In order to <strong> delete</strong> any of them, simply click on the little "x" on the top right.</li>
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

			})();
		</script>

		<script type="text/javascript">
			(function() {


				$('#saveTawk').on('click', function() {
					var tawkEmail = $('#tawkEmail').val();
					var tawkPass = $('#tawkPass').val();
					$('#saveTawk').disabled = true;

					$.post('settings.php', {
						tawkEmail: tawkEmail,
						tawkPass: tawkPass

					}, function(data) {
						if(data == "") {
							$('#tawk').text('Sorry, something went wrong');

						} else if (data == "failed") {
							$('#tawk').text('Sorry, something went wrong');

						} else if (data == "success") {
							$('#tawk').html('<h1 style="color: #1AB188;" class="center-txt"><i class="fa fa-check-circle-o fa-3x"></i></h1><h2 class="font-grey center-txt">Tawk login information had been successfully updated.</h2>');
							$('#saveTawk').css('display', 'none');
						} else {
							alert(data);
						}
						$('#saveTawk').disabled = false;
					})
				})

        $('#saveLogin').on('click', function() {
          var loginEmail = $('#loginEmail').val();
          var loginPass = $('#loginPass').val();
          $('#saveLogin').disabled = true;


          $.post('settings.php', {
            loginEmail: loginEmail,
            loginPass: loginPass

          }, function(data) {
            if(data == "") {
              $('#login').text('Sorry, something went wrong');

            } else if (data == "failed") {
              $('#login').text('Sorry, something went wrong');

            } else if (data == "success") {
              $('#login').html('<h1 style="color: #1AB188;" class="center-txt"><i class="fa fa-check-circle-o fa-3x"></i></h1><h2 class="font-grey center-txt slim-txt">The login information for this account has been successfully changed. <strong>Please remember to next time login using your new login information.</strong></h2>');
              $('#saveLogin').css('display', 'none');
            } else {
              alert(data);
            }
            $('#saveLogin').disabled = false;
          })
        })

				$('#saveAdd').on('click', function() {
					var addEmail = $('#addEmail').val();
					var addPass = $('#addPass').val();
					$('#saveAdd').disabled = true;


					$.post('settings.php', {
						addEmail: addEmail,
						addPass: addPass

					}, function(data) {
						var response = data.split('|');
						var status = response[0];
						var id = response[1];
						if(data == "") {
							$('#addAccount').text('Sorry, something went wrong');

						} else if (data == "failed") {
							$('#addAccount').text('Sorry, something went wrong');

						} else if (status == "success") {
							$('#addEmail').val('');
							$('#addPass').val('');
							$('.accountList').append('<div class="col-xs-12 account" id="account'+id+'" data-accountid="'+id+'"><span class="col-xs-5"><span class="fa fa-envelope-o"></span> Email: <strong>'+addEmail+'</strong></span><span class="col-xs-4"><span class="fa fa-lock"></span> Password: <strong>'+addPass+'</strong></span><span class="col-xs-1 col-xs-push-2 txt-alert md-txt pointer removeAccount"><i class="fa fa-trash" aria-hidden="true"></i></span></div>');
						} else {
							alert(data);
						}
						$('#saveAdd').disabled = false;
					})
				})
				$('body').on('click', '.removeAccount', function() {
					var element = $(this);
					var parent = $(this).parent();
					var id = $(this).parent().attr('data-accountid');

					$.post('settings.php', {
						id: id,
						remove: 'account'

					}, function(data) {
						if(data == "") {
							alert('Sorry, something went wrong');

						} else if (data == "failed") {
							alert('Sorry, something went wrong');

						} else if (data == "success") {
							parent.css('display', 'none');
						} else {
							alert(data);
						}
					})
				})

				$('#update').on('click', function() {
					var companyName = $('#companyName').val();
					var address1 = $('#address1').val();
					var address2 = $('#address2').val();
					var city = $('#city').val();
					var province = $('#province').val();
					var postalCode = $('#postalCode').val();
					var phoneNumber = $('#phoneNumber').val();
					var fax = $('#fax').val();
					var email = $('#email').val();
					var license = $('#license').val();
					var emailCheck = 0;
					if($('#emailCheck').is(':checked')) {
						emailCheck = 1;
					}
					$('#update').disabled = true;

					$.post('settings.php', {
						companyName: companyName,
						address1: address1,
						address2: address2,
						city: city,
						province: province,
						postalCode: postalCode,
						phoneNumber: phoneNumber,
						fax: fax,
						email: email,
						license: license,
						emailCheck: emailCheck

					}, function(data) {
						if(data == "") {
							$('#address').text('Sorry, something went wrong');

						} else if (data == "failed") {
							$('#address').text('Sorry, something went wrong');

						} else if (data == "success") {
							$('#address').html('<h1 style="color: #1AB188;" class="center-txt"><i class="fa fa-check-circle-o fa-3x"></i></h1><h2 class="font-grey center-txt">Your dealership information has been successfully updated.</h2>');
              $('#update').css('display', 'none');
						} else {
							alert(data);
						}
						$('#update').disabled = false;
					})
				})


			})();


		</script>
  </body>
</html>
<!-- V3M4H5 -->
