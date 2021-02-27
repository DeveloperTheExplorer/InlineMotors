<?php
	include_once("../php_includes/check_login_status.php");

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
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,width=device-width">
    <title>Is It fine?</title>
    <link rel="shortcut icon" type="image/png" href="../style/img/logo_icon.png">
    <link rel="stylesheet" href="../style/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../style/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,500" rel="stylesheet">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <script type="text/javascript" src="../js/jquery-2.1.4.js"></script>
    <script src="../style/bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php include_once("nav.php"); ?>
    <main>
      <div class="container">
        <div class="row bg-white">
          <h1 class="flex-between md-mar-top no-mar-bottom">Book A Service Appointment<span>Let us make your car as good as new.</span></h1>
          <hr class="md-mar-left md-mar-right">

          <div class="col-md-9">
            <?php echo $old_services; ?>
          </div>

          <div class="col-md-3">
            <h2 class="no-mar-top slim-txt no-mar-bottom bg-red sm-pad txt-white">Book An Appointment</h2>
            <div class="border-2 border-red sm-pad-left sm-pad-top sm-pad-bottom sm-mar-bottom">
              <input type="text" name="name" placeholder="Name" id="name" class="txt lg-input blk sm-mar width-90 required">
              <input type="text" name="email" placeholder="Email" id="email" class="txt lg-input blk sm-mar width-90 required">
              <input type="text" name="phone" placeholder="Phone" id="phone" class="txt lg-input blk sm-mar width-90">
              <h4 class="sm-mar-left no-mar-bottom">A little about your vehicle:</h4>
              <input type="text" name="year" placeholder="Year" id="year" class="txt lg-input blk sm-mar width-90 required">
              <input type="text" name="make" placeholder="Make" id="make" class="txt lg-input blk sm-mar width-90 required">
              <input type="text" name="model" placeholder="Model" id="model" class="txt lg-input blk sm-mar width-90 required">
              <textarea name="question" placeholder="Additional comments or questions..." id="question" class="txt lg-input blk sm-mar width-90 required"></textarea>
              <input type="submit" name="submit" value="Submit" id="submitContact" class="btn btn-inverse-red lg-btn lg-pad-left lg-pad-right sm-mar sm-pad-top sm-pad-bottom blk width-90">
            </div>
          </div>

        </div>
      </div>
    </main>
    <?php include_once("footer.php"); ?>


    <script type="text/javascript">
      $(function() {
        $('.required').on('focus', function() {
          if($(this).hasClass('inputError')) {
            $(this).removeClass('inputError');
            $('#status').text('');
          }
        })

        $('#submitContact').on('click', function() {
          var name = $('#name').val();
          var email = $('#email').val();
          var phone = $('#phone').val();
          var question = $('#question').val();
          var year = $('#year').val();
          var make = $('#make').val();
          var model = $('#model').val();
          var subject = "Service Appointment for a "+year+" "+make+" "+model;
          question = question + ' <br> Vehicle details:'+year+' '+make+' '+model;

          $('.required').each(function(i) {
            if($(this).val() == "") {
              $(this).addClass("inputError");
              $('#status').text('Please fill in all of the fields!');
            }
          })

          if(name == "" || email == "" || question == "" || year == "" || make == "" || model == "") {

          } else {
            $('.background-loader').fadeIn(300);
            $.post('contact.php', {
              name: name,
              email: email,
              phone: phone,
              question: question,
              subject: subject
            }, function(data) {
              $('.background-loader').fadeOut(300);
              if(data == "success") {
                $('.section').html('<h1 style="color: #1AB188;" class="center-txt"><i class="fa fa-check-circle-o fa-3x"></i></h1><h2 class="font-grey center-txt">Thank you for your time. We have sent you a confirmation email and we\'ll get back to you as soon as possible!</h2>');
              } else {
                console.log(data);
              }
            });
          }

        })
      });


    </script>

  </body>
</html>
