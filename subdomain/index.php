<?php
	include_once("../php_includes/check_login_status.php");
  if (isset($_COOKIE['email'])) {
    header('location: controlPanel.php');
  }
?>
<?php
  if(isset($_POST["email"])){
  	// CONNECT TO THE DATABASE
  	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
  	$e = mysqli_real_escape_string($db_conx, $_POST['email']);
  	$p = md5($_POST['pass']);
  	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
  	// FORM DATA ERROR HANDLING
  	if($e == "" || $p == ""){
  		echo "login failed";
          exit();
  	} else {
  	// END FORM DATA ERROR HANDLING
  		sleep(0.5);
  		$sql = "SELECT id, email, pass FROM users WHERE email='$e' LIMIT 1";
      $query = mysqli_query($db_conx, $sql);
      $row = mysqli_fetch_row($query);
  		$db_id = $row[0];
  		$db_email = $row[1];
      $db_pass_str = $row[2];

  		if($p != $db_pass_str) {
  			echo "login_failed";
  	    exit();

  		} elseif ($db_email == "") {
  			echo "login_failed";
  			exit();

  		} else {
  			// CREATE THEIR SESSIONS AND COOKIES
  			$_SESSION['userid'] = $db_id;
  			$_SESSION['email'] = $db_email;
  			$_SESSION['pass'] = $db_pass_str;
  			setcookie("id", $db_id, time()+3600);
  			setcookie("email", $db_email, time()+3600);
    		setcookie("pass", $db_pass_str, time()+3600);
  			// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
  			$sql = "UPDATE users SET ip='$ip', lastUse=now() WHERE email='$db_email' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
  			echo "success";
  		  exit();
  		}
  	}
  	exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
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
  <body class="red-black-gradient">
    <div class="center-center fixed bg-white lg-pad-left md-pad-top lg-pad-right md-pad-bottom">
      <h1 class="center-txt slim-txt">Please log in</h1>
      <hr>
      <input type="text" name="email" placeholder="email" id="email" class="required txt lg-input blk sm-mar">
      <input type="password" name="password" placeholder="Password" id="pass" class="required txt lg-input blk sm-mar">
      <input type="submit" name="submit" value="Log In" id="submit" class="btn btn-inverse-black lg-btn lg-pad-left lg-pad-right sm-mar lg-input"><br><span class="sm-mar bold txt-alert"></span>
    </div>
    <script type="text/javascript">
      (function() {
        $('.required').keyup(function() {
          $('.txt-alert').text(" ");
        });

        $('#submit').on('click', function() {
          var email = $('#email').val();
          var pass = $('#pass').val();
          if(email == "" || pass == "") {
            $('.txt-alert').text("Please fill in all fields!");
          } else {
            $.post('index.php', {
    					email: email,
    					pass: pass
    				}, function(data) {
    					if(data == "") {
    						$('.txt-alert').text('Sorry, something went wrong');

    					} else if (data == "login failed") {
    						$('.txt-alert').text('Sorry, your email and password do not match!');

    					} else if (data = "success") {
    						window.location = "controlPanel.php";
    					} else {
                alert(data);
              }
            })
          }
        })
      })();


    </script>
  </body>
</html>
