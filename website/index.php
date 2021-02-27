<?php
	include_once("../php_includes/check_login_status.php");


  $sql = "SELECT * FROM featured ORDER BY date DESC";
  $query = mysqli_query($db_conx, $sql);
  $numrows = mysqli_num_rows($query);
  $featuredCarList = '';
  if($numrows > 0){
    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
      $featuredID = $row['carid'];

      $sql2 = "SELECT * FROM cars WHERE id=$featuredID LIMIT 1";
      $query2 = mysqli_query($db_conx, $sql2);
      $numrows2 = mysqli_num_rows($query2);
      if($numrows2 > 0){
        while ($row2 = mysqli_fetch_array($query2, MYSQLI_ASSOC)) {
          $year = $row2['year'];
          $make = $row2['make'];
          $model = $row2['model'];
          $trim = $row2['trim'];
          $photos = $row2['images'];
          $photos = explode(',', $photos);
          $photos = $photos[0];
          $price1 = $row2['price'];
          $price = $row2['price'];
          $price = number_format($price, 0, '', ',');
          $mileage = $row2['mileage'];
          $mileage = number_format($mileage, 0, '', ',');
          $transmission = $row2['transmission'];
          $fuelType = $row2['fuelType'];

					if($photos == "") {
		        $photos = '../photos/imagePlaceHolder123.png';
		      }

          $featuredCarList .= '<div class="col-xs-12 col-sm-6 col-md-4 relative md-pad-bottom sm-pad-top border-0 border-1-bottom border-subtle">
                                <div style="min-height: 250px">
                                  <img src="'.$photos.'" alt="" width="100%" height="auto">
                                </div>
                                <h2 class="border-0 sm-pad-left border-4-left border-red line-1.5">'.$year.' '.$make.' '.$model.'</h2>
                                <hr class="sm-mar-top">
                                <div class="flex-between">
                                  <div class="width-40">
                                    <div class="flex-between">
                                      <span>Price </span>
                                      <strong> $'.$price.'</strong>
                                    </div>
                                    <div class="flex-between">
                                      <span>Mileage </span>
                                      <strong> '.$mileage.' km</strong>
                                    </div>
                                    <div class="flex-between">
                                      <span>Trim </span>
                                      <strong> '.$trim.'</strong>
                                    </div>
                                  </div>
                                  <div class="width-50">
                                    <div class="flex-between">
                                      <span>Fuel Type </span>
                                      <strong> '.$fuelType.'</strong>
                                    </div>
                                    <div class="flex-between">
                                      <span>Transmission </span>
                                      <strong> '.$transmission.'</strong>
                                    </div>
                                  </div>
                                </div>
                                <a href="vehicle.php?id='.$featuredID.'" target="_blank" class="btn btn-inverse-theme-red sm-pad-top sm-pad-bottom md-mar-top blk full-width">View Vehicle</a>
                              </div>';
        }
      }
    }
  }

?><?php
$sql = "SELECT * FROM slider WHERE id=1 LIMIT 1";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
$images = "";
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $photos = $row['images'];
    if($photos != ""){
      $photos = explode(',', $photos);
    }
  }
}
if($photos != "") {
  $i = count($photos)-1;
  if($photos != "") {
    $images = '';
    $thumbnail = '';
  }
  do {
		if($i == count($photos)-1) {
			$images = '<div class="item active">
				<div style="background-image: url(\''.$photos[$i].'\')" class="background-img"></div>
			</div>';
		} else {
			$images .= '<div class="item">
				<div style="background-image: url(\''.$photos[$i].'\')" class="background-img"></div>
			</div>';
		}
    $i = $i - 1;
  } while ( $i >= 0);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,width=device-width">
    <title>Inline Motors</title>
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
      <div id="myCarousel" data-ride="carousel" class="carousel slide">
        <!-- Wrapper for slides-->
        <div class="carousel-inner">
					<?php echo $images; ?>
        </div>
        <!-- Left and right controls--><a href="#myCarousel" data-slide="prev" class="left carousel-control"><span class="glyphicon glyphicon-chevron-left fa fa-angle-left uniqueControl"></span><span class="sr-only">Previous</span></a><a href="#myCarousel" data-slide="next" class="right carousel-control"><span class="glyphicon glyphicon-chevron-right fa fa-angle-right uniqueControl"></span><span class="sr-only">Next</span></a>
      </div>

      <!-- <div class="row no-mar">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 no-pad no-mar thumbnail-links relative"><span style="background-color: #c12e2e"></span><a href="#"><img src="../style/img/image_170280_11.jpg" alt="alt" width="100%" height="auto" class="img-responsive">
            <h2 class="center-txt">Mazda</h2></a></div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 no-pad no-mar thumbnail-links relative"><span style="background-color: #000"></span><a href="#"><img src="../style/img/image_169689_dsc_0700.jpg" alt="alt" width="100%" height="auto" class="img-responsive">
            <h2 class="center-txt">Hatchbacks</h2></a></div>
        <div class="col-lg-3 col-md-3 col-md-push-3 col-sm-6 col-xs-12 no-pad no-mar thumbnail-links relative"><span style="background-color: #000"></span><a href="#"><img src="../style/img/image_170189_1.jpg" alt="alt" width="100%" height="auto" class="img-responsive">
            <h2 class="center-txt">Less than 25k kilometers</h2></a></div>
        <div class="col-lg-3 col-md-3 col-md-pull-3 col-sm-6 col-xs-12 no-pad no-mar thumbnail-links relative"><span style="background-color: #c12e2e"></span><a href="#"><img src="../style/img/image_170306_1.jpg" alt="alt" width="100%" height="auto" class="img-responsive">
            <h2 class="center-txt">Less than $5k</h2></a></div>
      </div> -->
      <div class="container">
        <div class="row no-mar">
          <h1 class="center-txt slim-txt">Featured Vehicles:</h1>
          <hr class="no-mar-top width-80">

          <?php echo $featuredCarList; ?>

        </div>
      </div>

      <div class="perks">
        <div class="container">
          <div class="row no-pad">
            <h1 class="lg-txt center-txt no-mar-top md-mar-bottom">Did You Know?</h1>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-mar-bottom">
              <h1 class="xxl-txt center-txt no-mar"> <span aria-hidden="true" class="did-you-know fa fa-thumbs-o-up"></span></h1>
              <h2 class="center-txt">We have over 20 years of experience</h2>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-mar-bottom">
              <h1 class="xxl-txt center-txt no-mar"><span aria-hidden="true" class="did-you-know fa fa-search"></span></h1>
              <h2 class="center-txt">All cars are safely inspected</h1>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-mar-bottom">
              <h1 class="xxl-txt center-txt no-mar"><span aria-hidden="true" class="did-you-know fa fa-bar-chart"></span></h1>
              <h2 class="center-txt">Free vehicle history reports are available</h2>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-mar-bottom ">
              <h1 class="xxl-txt center-txt no-mar"><span aria-hidden="true" class="did-you-know fa fa-university"></span></h1>
              <h2 class="center-txt">Financing available</h2>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-mar-bottom">
              <h1 class="xxl-txt center-txt no-mar"><span aria-hidden="true" class="did-you-know fa fa-headphones"></span></h1>
              <h2 class="center-txt">Friendly and helpful customer service</h2>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-mar-bottom">
              <h1 class="xxl-txt center-txt no-mar"><span aria-hidden="true" class="did-you-know fa fa-refresh"></span></h1>
              <h2 class="center-txt">Trade-ins are welcome</h2>
            </div>
          </div>
        </div>
      </div>
      <!-- <div style="background-color: #eee;" class="perks center-txt">
        <h1 class="xl-txt">Home of Unbeatable Prices and Service</h1><a href="contact.php" class="btn btn-inverse-black xl-btn center-blk">Contact Us Today</a>
      </div> -->
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2606.7886719506223!2d-122.92859158411845!3d49.204568384222874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5485d879904861cb%3A0x37fa6ed8f3cf9fa1!2sInLine+Motors!5e0!3m2!1sen!2sus!4v1508339507543" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen=""></iframe>
    </main><?php include_once("footer.php"); ?>
  </body>
  <script type="text/javascript">
    (function() {
      var sc = 0;
      function scroll() {
        sc = $(window).scrollTop();
        console.log(sc);
        if(sc < 1000) {
          // $('.background-img').css('background-position', 'center ' + -(sc/2 + 125) + 'px');
        }
      }

      $(window).scroll(function() {
        scroll();
      });

      scroll();
    })();
  </script>
</html>
