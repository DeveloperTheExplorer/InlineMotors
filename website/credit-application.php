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
  $sql = "SELECT * FROM cars ORDER BY year";
  $query = mysqli_query($db_conx, $sql);
  $statusnumrows = mysqli_num_rows($query);
  $options = '';
  if($statusnumrows > 0){
    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
      $id = $row['id'];
	    $year = $row['year'];
	    $make = $row['make'];
	    $model = $row['model'];
	    $price = $row['price'];
	    $price = number_format($price, 0, '', ',');
	    $offer = $row['offer'];
	    $mileage = $row['mileage'];
	    $mileage = number_format($mileage, 0, '', ',');
	    $title = $year." ".$make." ".$model." ".$mileage."km $".$price;
      $options.= '<option value ="'.$id.'">'.$title.'</option>';
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
  <body style="background-color: #eee; "><?php include_once("nav.php"); ?>
    <main>
      <div class="container">
        <div class="row bg-white">
          <h1 class="flex-between md-mar-top no-mar-bottom">Secure Online Credit Application<span>Get approved from home!</span></h1>
          <hr class="md-mar-left md-mar-right">
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-lg-push-9 col-md-push-9 col-sm-push-0 col-xs-push-0 md-mar-bottom">
            <h1 class="slim-txt">Need Help?</h1>
            <hr>
            <h3 class="slim-txt">We are here to help you from start to finish! Feel free to chat with us online or:</h3>
            <a href="contact.php" class="btn btn-inverse-black lg-btn center-blk">Contact Us</a>
            <br>
            <br>

            <h3 class="slim-txt no-mar-bottom">You can also fill in the credit application form and email it to us at credit@inlinemotors.ca</h3>
            <a href="../documents/AFIE Credit Application.pdf" class="pdf link sm-mar-right sm-mar-top" target="_blank"><span class="fa fa-file-pdf-o"></span><br>Credit Application Form</a>
          </div>
          <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 col-lg-pull-3 col-md-pull-3 col-sm-pull-0 col-xs-pull-0 md-mar-bottom">
            <h1 class="slim-txt">Credit Application</h1>
            <hr>
            <h3 class="slim-txt">Please fill out the secure credit application below.</h3>
            <div class="row">
              <h3 class="col-sm-12 sm-mar-left">Personal Information</h3>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Salutation (required)</label>
                <select name="galutation" id="salutation" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="Dr.">Dr.</option>
                  <option value="Miss">Miss</option>
                  <option value="Mr.">Mr.</option>
                  <option value="Mrs.">Mrs.</option>
                  <option value="Ms.">Ms.</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Gender (required)</label>
                <select name="gender" id="gender" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="Female">Female</option>
                  <option value="Male">Male</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">First Name (required)</label>
                <input type="text" name="firstName" id="firstName" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Last Name (required)</label>
                <input type="text" name="lastName" id="lastName" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Phone (required)</label>
                <input type="text" name="phone" id="phone" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Email (required)</label>
                <input type="text" name="email" id="email" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Martial Status (required)</label>
                <select name="martialStatus" id="martialStatus" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="Single">Single</option>
                  <option value="Divorced">Divorced</option>
                  <option value="Married">Married</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Birth Date (required) Format (yyyy-mm-dd)</label>
                <input type="date" name="birth" id="birth" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Social Insurance Number (required) </label>
                <input type="text" name="sin" id="sin" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <h3 class="col-sm-12 sm-mar-left lg-mar-top">Current Address</h3>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Address (required) </label>
                <input type="text" name="address" id="address" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">City (required) </label>
                <input type="text" name="city" id="city" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Province (required)</label>
                <select name="province" id="province" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="Alberta">Alberta</option>
                  <option value="British Columbia">British Columbia</option>
                  <option value="Manitoba">Manitoba</option>
                  <option value="New Brunswick">New Brunswick</option>
                  <option value="Newfoundland">Newfoundland</option>
                  <option value="Northwest Territories">Northwest Territories</option>
                  <option value="Nova Scotia">Nova Scotia</option>
                  <option value="Nunavut">Nunavut</option>
                  <option value="Ontario">Ontario</option>
                  <option value="Prince Edward Island">Prince Edward Island</option>
                  <option value="Quebec">Quebec</option>
                  <option value="Saskatchewan">Saskatchewan</option>
                  <option value="Yukon">Yukon</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Postal Code (required) </label>
                <input type="text" name="postalCode" id="postalCode" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Years at Address (required) </label>
                <input type="text" name="addressYears" id="addressYears" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Months at Address (required) </label>
                <input type="text" name="addressMonths" id="addressMonths" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <h3 class="col-sm-12 sm-mar-left lg-mar-top">Home Rent/Mortgage Information</h3>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Home Status (required)</label>
                <select name="homeStatus" id="homeStatus" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="Rent">Rent</option>
                  <option value="Own With Mortgage">Own With Mortgage</option>
                  <option value="With Parents">With Parents</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Monthly Payment (required) </label>
                <input type="text" name="monthlyPayment" id="monthlyPayment" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <h3 class="col-sm-12 sm-mar-left lg-mar-top">Current Employment</h3>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Type (required)</label>
                <select name="workStatus" id="workStatus" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="Full Time">Full Time</option>
                  <option value="Part Time">Part Time</option>
                  <option value="Contract">Contract</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Employer Full Name (required) </label>
                <input type="text" name="workName" id="workName" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Ocupation (required) </label>
                <input type="text" name="work" id="work" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Employment Address (required) </label>
                <input type="text" name="workAddress" id="workAddress" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Province (required)</label>
                <select name="workProvince" id="workProvince" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="Alberta">Alberta</option>
                  <option value="British Columbia">British Columbia</option>
                  <option value="Manitoba">Manitoba</option>
                  <option value="New Brunswick">New Brunswick</option>
                  <option value="Newfoundland">Newfoundland</option>
                  <option value="Northwest Territories">Northwest Territories</option>
                  <option value="Nova Scotia">Nova Scotia</option>
                  <option value="Nunavut">Nunavut</option>
                  <option value="Ontario">Ontario</option>
                  <option value="Prince Edward Island">Prince Edward Island</option>
                  <option value="Quebec">Quebec</option>
                  <option value="Saskatchewan">Saskatchewan</option>
                  <option value="Yukon">Yukon</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">City (required) </label>
                <input type="text" name="workCity" id="workCity" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Postal Code (required) </label>
                <input type="text" name="workPostalCode" id="workPostalCode" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Phone (required)</label>
                <input type="text" name="workPhone" id="workPhone" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Gross Income (required)</label>
                <input type="text" name="income" id="income" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Years at Work (required) </label>
                <input type="text" name="workYearsEmployment" id="workYearsEmployment" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Months at Work (required) </label>
                <input type="text" name="workMonthsEmployment" id="workMonthsEmployment" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <h3 class="col-sm-12 sm-mar-left lg-mar-top">Previous Employment (optional)</h3>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Previous Employer Full Name </label>
                <input type="text" name="previousName" id="previousName" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Phone</label>
                <input type="text" name="previousPhone" id="previousPhone" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Years at Work </label>
                <input type="text" name="previousYearsEmployment" id="previousYearsEmployment" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Months at Work </label>
                <input type="text" name="previousMonthsEmployment" id="previousMonthsEmployment" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <h3 class="col-sm-12 sm-mar-left lg-mar-top">Other Information</h3>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Previous Bankruptsy (required) </label>
                <select name="bankruptsy" id="bankruptsy" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Previous Repossession (required) </label>
                <select name="repossession" id="repossession" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Is Cosigner Available? (required) </label>
                <select name="cosigner" id="cosigner" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Please Rate Your Credit (required) </label>
                <select name="credit" id="credit" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="Good Credit">Good Credit</option>
                  <option value="Average">Average</option>
                  <option value="Bad Credit">Bad Credit</option>
                  <option value="No Credit">No Credit</option>
                </select>
              </div>
              <h3 class="col-sm-12 sm-mar-left lg-mar-top">Desired Vehicle (optional)</h3>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Vehicle: </label>
                <select name="desired-vehicle" id="desired-vehicle" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="none">Vehicle List</option>
                  <?php echo $options ?>
                </select>
              </div>

              <h3 class="col-sm-12 sm-mar-left lg-mar-top">Trade In (optional)</h3>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Trade-In Make </label>
                <input type="text" name="make" id="make" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Trade-In Model</label>
                <input type="text" name="model" id="model" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Trade-In Year</label>
                <input type="text" name="year" id="year" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Trade-In Mileage</label>
                <input type="text" name="mileage" id="mileage" class="width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-12">
                <label class="blk sm-mar-left">Questions or Comments (optional)</label>
                <textarea name="questions" id="questions" placeholder="How can we help you?" class="full-width txt lg-input sm-mar-left sm-mar-bottom"></textarea>
              </div>
              <div class="col-sm-12">
                <h3 class="slim-font sm-mar lg-mar-top">To ensure that you are human and not an automated bot, please answer this question:</h3>
                <label id="robotQuestion" class="sm-mar" data-num1="<?php echo $num1; ?>" data-num2="<?php echo $num2; ?>" data-operation="<?php echo $randomOperation; ?>">What is the <?php echo $randomOperation.' of '.$num1.' and '.$num2; ?>?</label>
                <input type="text" name="robotCheck" placeholder="Answer" class="txt lg-input blk sm-mar">
                <p class="sm-mar-left">By clicking "Submit", I, the undersigned, (a) for the purpose of securing credit, certify the below representations to be correct; (b) authorize financial institutions, as they consider necessary and appropriate, to obtain consumer credit reports on me periodically and to gather employment history, and (c) understand that we, or any financial institution to whom this application is submitted, will retain this application whether or not it is approved, and that it is the applicant's responsibility to notify the creditor of any change of name, address, or employment. We and any financial institution to whom this application is submitted, may share certain non-public personal information about you with your authorization or as provided by law.</p>
                <span class="sm-mar txt-alert bold md-txt" id="status"></span>
                <br>
                <input type="submit" name="submit" value="Submit" id="submit" class="btn btn-inverse-black lg-btn lg-pad-left lg-pad-right sm-mar">
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php include_once("footer.php"); ?>

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
            $('#status').text('Please fill in all of the required fields!');
          }
        })

        $('.required').each(function(i) {
          if($(this).val() == "") {
            return false;
          }
        })

        if ($('#robotCheck').val() != answer && $('#robotCheck').val() != "") {
          $('#robotCheck').addClass('inputError');
          $('#status').text('Please check your math.');
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
