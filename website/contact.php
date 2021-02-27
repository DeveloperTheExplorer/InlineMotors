<?php
	include_once("../php_includes/check_login_status.php");

  $randomOperation = rand(1,2);
  if($randomOperation == 1) {
    $randomOperation = "product";
  } else if($randomOperation == 2) {
    $randomOperation = "sum";
  }
  $num1 = rand(1, 10);
  $num2 = rand(1, 10);

?><?php
  if (isset($_POST['question'])) {
    $subject = "Customer Contact";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $question = $_POST['question'];
    if(isset($_POST['subject'])) {
      $subject = $_POST['subject'];
    }
    $autoReplyEmail = 'autoreply@inlinemotors.ca';
    $companyEmail = 'contact@inlinemotors.ca';

    $sql = "SELECT data FROM autoreply WHERE id=1 LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows > 0) {
      while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $autoreply = $row['data'];
      }
    }

    if($autoreply != "" && $autoreply != '<p style="text-align: center;"><span style="font-size: 18pt;">Let your customers know that you have received their Email!</span></p>') {
      // The message
      $message = $autoreply;

      // The headers
      $headers = "From: $autoReplyEmail\n";
          $headers .= "MIME-Version: 1.0\n";
          $headers .= "Content-type: text/html; charset=iso-8859-1\n";

      // Send
      mail($email, 'Contact Email Confirmation', $message, $headers);
    }

    $message = '<h2>Subject: '.$subject.'</h2>
								<h2>Name: '.$name.'</h2>
                <h2>Email: '.$email.'</h2>
								<h2>Phone: '.$phone.'</h2>
                <h2>Question: </h2>
                <p>'.$question.'</p>';

    // The headers
    $headers = "From: $email\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";

    // Send
    mail('arvinmetal6814@gmail.com', 'Contact Email Confirmation', $message, $headers);

    echo 'success';
    exit();

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
  <body><?php include_once("nav.php"); ?>
    <main>
      <div class="container">
        <div class="row bg-white">
          <h1 class="flex-between md-mar-top no-mar-bottom">Contact<span>Please feel free to call us or email us.</span></h1>
          <hr class="md-mar-left md-mar-right">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2606.7886719506223!2d-122.92859158411845!3d49.204568384222874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5485d879904861cb%3A0x37fa6ed8f3cf9fa1!2sInLine+Motors!5e0!3m2!1sen!2sus!4v1508339507543" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen=""></iframe>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 md-mar-bottom contact-form">
            <h1 class="slim-txt">Contact Form</h1>
            <hr>
            <input type="text" name="name" id="name" placeholder="Name" class="txt lg-input blk sm-mar required">
            <input type="text" name="email" id="email" placeholder="Email" class="txt lg-input blk sm-mar required">
            <input type="text" name="phone" id="phone" placeholder="Phone" class="txt lg-input blk sm-mar required">
            <textarea name="question" id="question" placeholder="How can we help you?" class="txt lg-input blk sm-mar required"></textarea>
            <h3 class="slim-font sm-mar lg-mar-top">To ensure that you are human and not an automated bot, please answer this question:</h3>
            <label id="robotQuestion" class="sm-mar" data-num1="<?php echo $num1; ?>" data-num2="<?php echo $num2; ?>" data-operation="<?php echo $randomOperation; ?>">What is the <?php echo $randomOperation.' of '.$num1.' and '.$num2; ?>?</label>
            <input type="text" name="robotCheck" id="robotCheck" placeholder="Answer" class="txt lg-input blk sm-mar required">
            <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-inverse-black lg-btn lg-pad-left lg-pad-right sm-mar">
            <br>
            <span class="sm-mar txt-alert bold md-txt" id="status"></span>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 md-mar-bottom">
            <h1 class="slim-txt">Contact Us</h1>
            <hr>
            <h3>Inline Motors</h3>
            <p>333 12th Street<br>New Westminster, BC V3M 4H5 <br>Phone: 604-549-8222. <br>Fax: 604-549-8221<br>Hours of operation:<br>Monday to Saturday : 10:00am to 7:00pm<br><br>Sunday/ Holidays : 11:00am to 5:00pm</p>
          </div>
        </div>
      </div>
    </main><?php include_once("footer.php"); ?>

    <script type="text/javascript">
      $(function() {
        $('#submit').on('click', function() {
          var num1 = $('#robotQuestion').attr('data-num1');
          var num2 = $('#robotQuestion').attr('data-num2');
          var operation = $('#robotQuestion').attr('data-operation');
          var name = $('#name').val();
          var email = $('#email').val();
          var phone = $('#phone').val();
          var question = $('#question').val();
          var answer = 0;

          if(operation == "sum") {
            answer = parseInt(num1) + parseInt(num2);
          } else if(operation == "product") {
            answer = parseInt(num1) * parseInt(num2);
          }

          $('.required').each(function(i) {
            if($(this).val() == "") {
              $(this).addClass("inputError");
              $('#status').text('Please fill in all of the fields!');
            }
          })

          if(name == "" || email == "" || phone == "" || question == "") {

          } else if ($('#robotCheck').val() != answer && $('#robotCheck').val() != "") {
            $('#robotCheck').addClass('inputError');
            $('#status').text('Please check your math.');
            alert(answer);
          } else {
						$('.background-loader').fadeIn(300);
            $.post('contact.php', {
              name: name,
              email: email,
              phone: phone,
              question: question
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

        $('.required').on('focus', function() {
          if($(this).hasClass('inputError')) {
            $(this).removeClass('inputError');
            $('#status').text('');
          }
        })
      });
    </script>
  </body>
</html>
