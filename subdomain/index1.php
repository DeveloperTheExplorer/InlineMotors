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
          }
        })
      })();
    </script>
  </body>
</html>