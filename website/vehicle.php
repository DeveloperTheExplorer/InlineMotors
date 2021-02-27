<?php
include_once("../php_includes/check_login_status.php");

if(!isset($_GET['id'])) {
  header('location: /');
}

$carID = $_GET['id'];

$carIDs = $carID;
$repeated = false;
if(isset($_COOKIE['viewedVehicles'])) {
  $carIDs = $_COOKIE['viewedVehicles'];
  if(strlen($carIDs) > 1) {
    $cookieCarIDs = explode(' ', $carIDs);
    $k = 0;
    do {
      if($cookieCarIDs[$k] != $carID) {
        $repeated = false;
      } else {
        $repeated = true;
        $carIDs = $_COOKIE['viewedVehicles'];
        $k = 1000;
      }
      $k = $k + 1;
    } while ( $k < count($cookieCarIDs));
  } else if($carIDs != $carID && strlen($carIDs) == 1) {
    $repeated = false;
  }
}

if(!$repeated) {
  if($carIDs != $carID) {
    $carIDs = $carIDs." ".$carID;
  }
  setcookie("viewedVehicles", $carIDs, time()+86400);
}

$viewedVehiclesList = "";
$viewedVehiclesListParent = "";
if(isset($_COOKIE['viewedVehicles'])) {
  $viewedVehiclesListParent = '<h2 class="no-mar-top slim-txt no-mar-bottom bg-black sm-pad txt-white">Recently Viewed Vehicles:</h2>
  <div class="border-2 border-black sm-pad-left sm-pad-top sm-pad-bottom sm-mar-bottom">';
  $l = 0;
  $cookieCarIDs = explode(' ', $carIDs);
  do {
    $theID = $cookieCarIDs[$l];
    $sql = "SELECT * FROM cars WHERE id=$theID LIMIT 7";
    $query = mysqli_query($db_conx, $sql);
    // Now make sure that user exists in the table
    $numrows = mysqli_num_rows($query);
    if($numrows > 0){
      while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $photos = $row['images'];
        $photos = explode(',', $photos);
        $photos = end($photos);
        $year = $row['year'];
        $make = $row['make'];
        $model = $row['model'];
        $price = $row['price'];
        $price = number_format($price, 0, '', ',');
        $mileage = $row['mileage'];
        $mileage = number_format($mileage, 0, '', ',');
        $viewedVehiclesList .= '<div class="sm-mar md-mar-bottom">
                                  <img src="'.$photos.'" alt="alt" class="sm-mar-left width-90">
                                  <h3 class="sm-mar-left">'.$year.' '.$make.' '.$model.'<br>'.$mileage.' Kilometers | $'.$price.'</h3><a href="vehicle.php?id='.$theID.'" target="_blank" class="sm-mar-left width-90 lg-btn btn-inverse-black center-txt blk sm-pad-top sm-pad-bottom">View Vehicle</a>
                                </div>
                                <hr class="width-80">';
      }
    }
    $l = $l + 1;
  } while ( $l < count($cookieCarIDs));
  $viewedVehiclesList .= "</div>";
}

// Select the member from the users table
$sql = "SELECT * FROM cars WHERE id=$carID LIMIT 1";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
$images = '<div class="item active"><img src="../photos/PlaceHolder123.png" alt=""></div>';
$thumbnail = '<li data-target="#myCarousel" data-slide-to="0" class="active"><a href="#x" class="thumbnail"><img src="../photos/PlaceHolder123.png" alt="Image" style="max-width:100%;"></a></li>';
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $vin = $row['vin'];
    $year = $row['year'];
    $make = $row['make'];
    $model = $row['model'];
    $trim = $row['trim'];
    $bodyStyle = $row['bodyStyle'];
    $engine = $row['engine'];
    $transmission = $row['transmission'];
    $driveType = $row['driveType'];
    $fuelType = $row['fuelType'];
    $fuelCity = $row['fuelCity'];
    $fuelHighway = $row['fuelHighway'];
    $doors = $row['doors'];
    $exteriorColor = $row['exteriorColor'];
    $interiorColor = $row['interiorColor'];
    $details = $row['comment'];
		$details = nl2br($details);
		$details = str_replace("&amp;","&",$details);
		$details = stripslashes($details);
    $stock = $row['stock'];
    $status = $row['status'];
    $photos = $row['images'];
    $photos = explode(',', $photos);
    $price1 = $row['price'];
    $price = $row['price'];
    $price = '$'.number_format($price, 0, '', ',');
    $mileage = $row['mileage'];
    $mileage = number_format($mileage, 0, '', ',');
    $title = $year." ".$make." ".$model;

    if($status == 'soldLeave') {
      $price = '<span class="txt-alert bold"> Sold </span>';
    }
  }
} else {
  header('location: /');
}
$i = count($photos)-1;
if($photos != "") {
  $images = '';
  $thumbnail = '';
}
$p = 0;
do {

  if($i == count($photos) - 1) {
    $images = '<div class="item active" data-slide-num="'.$i.'"><img src="'.$photos[$i].'" alt=""></div>';
    $thumbnail = '<li data-target="#myCarousel" data-slide-to="'.$p.'" class="active indicator indicator-num-'.$i.'"><a href="#x" class="thumbnail"><img src="'.$photos[$i].'" alt="Image" style="max-width:100%;"></a></li>';
  } else if ($i == 0) {
    $images .= '<div class="item" data-slide-num="'.$i.'"><img src="'.$photos[$i].'" alt=""></div>';
    $thumbnail .= '<li data-target="#myCarousel" data-slide-to="'.$p.'" class="xs-mar-left indicator indicator-num-'.$i.'"><a href="#x" class="thumbnail"><img src="'.$photos[$i].'" alt="Image" style="max-width:100%;"></a></li>';
  } else {
    $images .= '<div class="item" data-slide-num="'.$i.'"><img src="'.$photos[$i].'" alt=""></div>';
    $thumbnail .= '<li data-target="#myCarousel" data-slide-to="'.$p.'" class="xs-mar-left indicator indicator-num-'.$i.'"><a href="#x" class="thumbnail"><img src="'.$photos[$i].'" alt="Image" style="max-width:100%;"></a></li>';
  }
  $i = $i - 1;
  $p++;
} while ( $i >= 0);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $title;?></title>
    <link rel="shortcut icon" type="image/png" href="../style/img/logo_icon.png">
    <link rel="stylesheet" href="../style/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../style/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,500" rel="stylesheet">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <script type="text/javascript" src="../js/jquery-2.1.4.js"></script>
    <script src="../style/bootstrap/js/bootstrap.min.js"></script>
    <style media="screen">
      .fb_reset {
        line-height: normal !important;
      }
    </style>
  </head>
  <body id="fb-root">
    <script>
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=1539645899621222';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));


    </script><?php include_once("nav.php"); ?>
    <main>
      <div class="container">
        <div class="row bg-white">
          <h1 class="flex-between md-mar-top no-mar-bottom"><?php echo $title; ?><span class="txt-alert"><?php echo $price; ?></span></h1>
          <hr class="md-mar-left md-mar-right">
          <div class="col-md-9">
            <div id="myCarousel" data-ride="carousel" class="carousel carousel2 slide">
              <!-- Wrapper for slides-->
              <div class="carousel-inner">
                <?php echo $images; ?>
              </div>
              <!-- Left and right controls--><a href="#myCarousel" data-slide="prev" class="left carousel-control"><span aria-hidden="true" class="fa fa-angle-left"></span><span class="sr-only">Previous</span></a><a href="#myCarousel" data-slide="next" class="right carousel-control"><span aria-hidden="true" class="fa fa-angle-right"></span><span class="sr-only">Next</span></a>
            </div>
            <!-- Indicators-->
            <div class="thumbnail-indicators xs-mar-top">
              <!-- <li data-target="#myCarousel" data-slide-to="0" class="active"><a href="#x" class="thumbnail"><img src="http://dealers.motorcarmarkdown.com/images/vehicles/large/image_169479_1.jpg" alt="Image" style="max-width:100%;"></a></li>
              <li data-target="#myCarousel" data-slide-to="1"><a href="#x" class="thumbnail"><img src="http://dealers.motorcarmarkdown.com/images/vehicles/large/image_169479_dsc_0098.jpg" alt="Image" style="max-width:100%;"></a></li>
              <li data-target="#myCarousel" data-slide-to="2"><a href="#x" class="thumbnail"><img src="http://dealers.motorcarmarkdown.com/images/vehicles/large/image_169479_3.jpg" alt="Image" style="max-width:100%;"></a></li> -->
              <?php echo $thumbnail; ?>
            </div>
            <div class="bg-red txt-white sm-mar-top sm-pad">
              <h2 class="no-mar slim-txt">Car Specifications</h2>
            </div>
            <div class="border-1 border-red flex-between md-pad-bottom md-pad-left">
              <div style="width: 40%; min-width: 300px;">
                <div class="">
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Year:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $year; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-building" aria-hidden="true"></i> Make:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $make; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-car" aria-hidden="true"></i> Model:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $model; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-file-text-o" aria-hidden="true"></i> Trim:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $trim; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-car" aria-hidden="true"></i> Body Style:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $bodyStyle; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-money" aria-hidden="true"></i> Price:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $price; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-tachometer" aria-hidden="true"></i> kilometers:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $mileage; ?> km</h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-paint-brush" aria-hidden="true"></i> Exterior Colour:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $exteriorColor; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-paint-brush" aria-hidden="true"></i> Interior Colour:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $interiorColor; ?></h3>
                  </div>
                </div>
              </div>
              <div style="width: 50%; min-width: 300px;">
                <div class="">
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-bolt" aria-hidden="true"></i> Engine:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $engine; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-cogs" aria-hidden="true"></i> Transmission:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $transmission; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-circle-o" aria-hidden="true"></i> Drive Type:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $driveType; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-tint" aria-hidden="true"></i> Fuel Type:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $fuelType; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-tint" aria-hidden="true"></i> L/100km City:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $fuelCity; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-tint" aria-hidden="true"></i> L/100km Highway:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $fuelHighway; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-file-text-o" aria-hidden="true"></i> Doors:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $doors; ?></h3>
                  </div>
                  <div class="md-mar-top details-txt">
                    <h3 class="no-mar no-mar-bottom md-mar-left slim-txt"><i class="fa fa-list" aria-hidden="true"></i> Stock Number:</h3>
                    <h3 class="no-mar no-mar-bottom md-mar-left"><?php echo $stock; ?></h3>
                  </div>
                </div>
              </div>
            </div>
            <h2 class="slim-txt lg-mar-top">
              <?php echo $details; ?>
                </h2>
              </div>
            </h2>
          <div class="col-md-3">
            <h2 class="no-mar-top slim-txt no-mar-bottom bg-black sm-pad txt-white">Contact Inline Motors</h2>
            <div class="border-2 border-black sm-pad-left sm-pad-top sm-pad-bottom md-mar-bottom">
              <h3 class="no-mar-top slim-txt sm-mar-left">333 12th Street<br>New Westminster, BC V3M 4H5</h3><a href="tel:604-549-8222" target="_blank" class="sm-mar-top width-90 lg-btn btn-inverse-black center-txt sm-mar-left blk sm-pad-top sm-pad-bottom"><span class="sm-mar-right fa fa-mobile"></span>Phone: 604-549-8222</a><a href="contact.php" target="_blank" class="width-90 lg-btn btn-inverse-black center-txt sm-mar-left blk sm-pad-top sm-pad-bottom sm-mar-top">Contact Us</a>
            </div>

            <h2 class="no-mar-top slim-txt no-mar-bottom bg-green sm-pad txt-white">Loan Calculator</h2>
            <form action="#" method="method" class="border-2 border-green sm-pad-left sm-pad-top sm-pad-bottom md-mar-bottom">
              <label class="blk sm-mar-left">Loan Amount: &#36;</label>
              <input type="number" name="amount" id="amount" value="<?php echo $price1 ?>" class="loan width-90 txt lg-input sm-mar-left sm-mar-bottom">
              <label class="blk sm-mar-left">Interest Rate: &#37;</label>
              <input type="number" name="rate" id="rate" value="5" class="loan width-90 txt lg-input sm-mar-left sm-mar-bottom">
              <label class="blk sm-mar-left">Months:</label>
              <input type="number" name="months" id="months" value="60" class="loan width-90 txt lg-input sm-mar-left">
              <h3 class="sm-mar-left slim-txt">Monthly Payment = <span class="loan-result"></span></h3>
            </form>

            <h2 class="no-mar-top slim-txt no-mar-bottom bg-blue sm-pad txt-white">Get More Info:</h2>
            <div class="border-2 border-blue sm-pad-left sm-pad-top sm-pad-bottom sm-mar-bottom">
              <input type="text" name="name" placeholder="Name" id="name" class="txt lg-input blk sm-mar width-90">
              <input type="text" name="email" placeholder="Email" id="email" class="txt lg-input blk sm-mar width-90">
              <input type="text" name="phone" placeholder="Phone" id="phone" class="txt lg-input blk sm-mar width-90">
              <textarea name="question" placeholder="What would you like to know?" id="question" class="txt lg-input blk sm-mar width-90"></textarea>
              <input type="submit" name="submit" value="Submit" id="submitContact" class="btn btn-inverse-blue lg-btn lg-pad-left lg-pad-right sm-mar sm-pad-top sm-pad-bottom blk width-90">
            </div>

            <!-- <h2 class="no-mar-top slim-txt no-mar-bottom bg-black sm-pad txt-white">Recently Viewed Vehicles:</h2>
            <div class="border-2 border-black sm-pad-left sm-pad-top sm-pad-bottom sm-mar-bottom">

              <div class="sm-mar md-mar-bottom">
                <img src="http://dealers.motorcarmarkdown.com/images/vehicles/large/image_170188_dsc_0627.jpg" alt="alt" class="sm-mar-left width-90">
                <h3 class="sm-mar-left">2017 Honda Civic<br>2,100 Kilometers | $18,990</h3><a href="contact.php" target="_blank" class="sm-mar-left width-90 lg-btn btn-inverse-black center-txt blk sm-pad-top sm-pad-bottom">View Vehicle</a>
              </div>
              <hr class="width-80">

            </div> -->

            <?php echo $viewedVehiclesListParent; ?>
            <?php echo $viewedVehiclesList; ?>

            <h2 class="no-mar-top slim-txt no-mar-bottom bg-black sm-pad txt-white">Share:</h2>
            <div class="border-2 border-black sm-pad-left sm-pad-top sm-pad-bottom sm-mar-bottom"><a href="https://twitter.com/share" data-size="large" class="float-right twitter-share-button">Tweet</a>
              <div data-href="" data-layout="button_count" data-size="large" data-mobile-iframe="true" class="fb-share-button sm-mar-left"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Facebook</a></div>
            </div>


            <div class="sm-pad-left sm-pad-top sm-pad-bottom md-mar-bottom"><a href="javascript:window.print()" class="width-90 lg-btn btn-inverse-black center-txt sm-mar-left blk sm-pad-top sm-pad-bottom"><span class="sm-mar-right fa fa-print"></span>Print Listing</a></div>

          </div>
        </div>
      </div>
    </main><?php include_once("footer.php"); ?>
    <script>
      !function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
            p = /^http:/.test(d.location) ? 'http' : 'https';
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = p + '://platform.twitter.com/widgets.js';
            fjs.parentNode.insertBefore(js, fjs);
        }
      }(document, 'script', 'twitter-wjs');

    </script>
    <script type="text/javascript">
      (function(){
        $('#submitContact').on('click', function() {
          $('.background-loader').fadeIn(300);
          var name = $('#name').val();
          var email = $('#email').val();
          var phone = $('#phone').val();
          var question = $('#question').val();
          var subject = "<?php echo $year.' '.$make.' '.$model; ?>";
          question = question + ' <br> Link to the vehicle: <a href="http://inlinemotors.ca/vehicle.php?id=<?php echo $carID; ?>">'+subject+'</a>';

          $('.required').each(function(i) {
            if($(this).val() == "") {
              $(this).addClass("inputError");
              $('#status').text('Please fill in all of the fields!');
            }
          })

          if(name == "" || email == "" || phone == "" || question == "") {

          } else {
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

        $('.required').on('focus', function() {
          if($(this).hasClass('inputError')) {
            $(this).removeClass('inputError');
            $('#status').text('');
          }
        })

        function loan() {
          var a = $('#amount').val();
          var r = $('#rate').val() / 1200;
          var m = $('#months').val();

          var answer = a * r / (1 - (Math.pow(1/(1 + r), m)));
          answer = Math.round(answer * 100) / 100;
          if(isFinite(answer)) {
          	answer = answer.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('.loan-result').text('$' + answer);
          }
        }
        $('.loan').keyup(loan);
        loan();

        var slide = 0;
        setInterval(function(){
          slide = $('.item.active').attr('data-slide-num');
          $('.indicator').css('opacity', '0.5');
          $('.indicator-num-'+slide).css('opacity', '1');
        }, 100);
      })();
    </script>
  </body>
</html>
