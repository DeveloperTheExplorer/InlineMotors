<?php
include_once("../php_includes/check_login_status.php");
$makes = array();
$bodyStyles = array();
$modelList = '';
// Select the member from the users table
$sql = "SELECT * FROM cars ORDER BY make ASC";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    array_push($makes, $row["make"]);
    array_push($bodyStyles, $row["bodyStyle"]);
  }
}


$makes = array_unique($makes);
$bodyStyles = array_unique($bodyStyles);
sort($bodyStyles);
$bodyStyleList = '';

foreach($bodyStyles as $pos => $bodyStyle) {
  $sql = "SELECT bodyStyle FROM cars WHERE bodyStyle='$bodyStyle'";
  $query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));
  $numrows = mysqli_num_rows($query);
  $bodyStyle1 = $bodyStyle . ' ('.$numrows.')';

  $bodyStyleList .= '<li><a href="vehicles.php?bodyStyle='.$bodyStyle.'" class="">'.$bodyStyle1.'</a></li>';

}


$lessThan5K = '';
// Select the member from the users table
$sql = "SELECT price FROM cars WHERE price <= 5000 ORDER BY price ASC";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
if($numrows > 0){
  $lessThan5K = '<li><a href="vehicles.php?price=5" class="">Less than $5K ('.$numrows.')</a></li>';
}
$lessThan10K = '';
// Select the member from the users table
$sql = "SELECT price FROM cars WHERE price <= 10000 AND price > 5000 ORDER BY price ASC";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
if($numrows > 0){
  $lessThan10K = '<li><a href="vehicles.php?price=10" class="">$10k to $5K ('.$numrows.')</a></li>';
}
$lessThan25K = '';
// Select the member from the users table
$sql = "SELECT price FROM cars WHERE price <= 25000 AND price > 10000 ORDER BY price ASC";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
if($numrows > 0){
  $lessThan25K = '<li><a href="vehicles.php?price=25" class="">$25k to $10K ('.$numrows.')</a></li>';
}
$lessThan50K = '';
// Select the member from the users table
$sql = "SELECT price FROM cars WHERE price <= 50000 AND price > 25000 ORDER BY price ASC";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
if($numrows > 0){
  $lessThan50K = '<li><a href="vehicles.php?price=50" class="">$50k to $25K ('.$numrows.')</a></li>';
}
$lessThan100K = '';
// Select the member from the users table
$sql = "SELECT price FROM cars WHERE price <= 100000 AND price > 50000 ORDER BY price ASC";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
if($numrows > 0){
  $lessThan100K = '<li><a href="vehicles.php?price=100" class="">$100k to $50K ('.$numrows.')</a></li>';
}
$moreThan100K = '';
// Select the member from the users table
$sql = "SELECT price FROM cars WHERE price > 100000 ORDER BY price ASC";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
if($numrows > 0){
  $moreThan100K = '<li><a href="vehicles.php?price=101" class="">More Than $100K ('.$numrows.')</a></li>';
}




foreach ($makes as $key => $make) {
  $sql = "SELECT make FROM cars WHERE make='$make'";
  $query = mysqli_query($db_conx, $sql);
  $numrows = mysqli_num_rows($query);
  $makes[$key] = $makes[$key] . ' ('.$numrows.')';
}

$alphaSwitch = 0;
$A_H = 'abcdefgh';
$I_M = 'ijklm';
$N_Z = 'nopqrstuvwxyz';
$carsA_H = "";
$carsI_M = "";
$carsN_Z = "";
foreach ($makes as $position => $make) {
  for($i = 0; $i < strlen($A_H); $i++) {
    if(strtolower($make[0]) == $A_H[$i]) {
      $models = array();
      $theMake = substr($make, 0, -4);
      $sql = "SELECT model FROM cars WHERE make='$theMake' ORDER BY model ASC";
      $query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));
      $numrows = mysqli_num_rows($query);
      if($numrows > 0){
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
          array_push($models, $row["model"]);
        }
      }

      $models = array_unique($models);
      $modelList = '';
      echo $modelList;

      foreach ($models as $key => $model) {
        $sql = "SELECT model FROM cars WHERE make='$theMake' AND model='$model'";
        $query = mysqli_query($db_conx, $sql);
        $numrows = mysqli_num_rows($query);
        $models[$key] = $models[$key] . ' ('.$numrows.')';
        $modelList .= '<li><a href="vehicles.php?make='.$theMake.'&model='.$model.'" class="">'.$models[$key].'</a></li>';
      }

      $carsA_H .= '<li><a href="vehicles.php?make='.$theMake.'" class="">'.$make.'<span aria-hidden="true" class="fa fa-caret-right"></span></a>
                    <ul class="dropside2">
                      '.$modelList.'
                    </ul>
                  </li>';
    }
  }

  for($i = 0; $i < strlen($I_M); $i++) {
    if(strtolower($make[0]) == $I_M[$i]) {
      $models = array();
      $theMake = substr($make, 0, -4);
      $sql = "SELECT model FROM cars WHERE make='$theMake' ORDER BY model ASC";
      $query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));
      $numrows = mysqli_num_rows($query);
      if($numrows > 0){
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
          array_push($models, $row["model"]);
        }
      }

      $models = array_unique($models);
      $modelList = '';
      echo $modelList;

      foreach ($models as $key => $model) {
        $sql = "SELECT model FROM cars WHERE make='$theMake' AND model='$model'";
        $query = mysqli_query($db_conx, $sql);
        $numrows = mysqli_num_rows($query);
        $models[$key] = $models[$key] . ' ('.$numrows.')';
        $modelList .= '<li><a href="vehicles.php?make='.$theMake.'&model='.$model.'" class="">'.$models[$key].'</a></li>';
      }

      $carsI_M .= '<li><a href="vehicles.php?make='.$theMake.'" class="">'.$make.'<span aria-hidden="true" class="fa fa-caret-right"></span></a>
                    <ul class="dropside2">
                      '.$modelList.'
                    </ul>
                  </li>';
    }
  }

  for($i = 0; $i < strlen($N_Z); $i++) {
    if(strtolower($make[0]) == $N_Z[$i]) {
      $models = array();
      $theMake = substr($make, 0, -4);
      $sql = "SELECT model FROM cars WHERE make='$theMake' ORDER BY model ASC";
      $query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));
      $numrows = mysqli_num_rows($query);
      if($numrows > 0){
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
          array_push($models, $row["model"]);
        }
      }

      $models = array_unique($models);
      $modelList = '';
      echo $modelList;

      foreach ($models as $key => $model) {
        $sql = "SELECT model FROM cars WHERE make='$theMake' AND model='$model'";
        $query = mysqli_query($db_conx, $sql);
        $numrows = mysqli_num_rows($query);
        $models[$key] = $models[$key] . ' ('.$numrows.')';
        $modelList .= '<li><a href="vehicles.php?make='.$theMake.'&model='.$model.'" class="">'.$models[$key].'</a></li>';
      }

      $carsN_Z .= '<li><a href="vehicles.php?make='.$theMake.'" class="">'.$make.'<span aria-hidden="true" class="fa fa-caret-right"></span></a>
                    <ul class="dropside2">
                      '.$modelList.'
                    </ul>
                  </li>';
    }
  }
}

$sql = "SELECT id FROM cars WHERE mileage <= 25000";
$query = mysqli_query($db_conx, $sql);
$numrowsMile1 = mysqli_num_rows($query);

$sql = "SELECT id FROM cars WHERE mileage <= 50000";
$query = mysqli_query($db_conx, $sql);
$numrowsMile2 = mysqli_num_rows($query);

$sql = "SELECT id FROM cars WHERE mileage <= 100000";
$query = mysqli_query($db_conx, $sql);
$numrowsMile3 = mysqli_num_rows($query);

$sql = "SELECT id FROM cars WHERE mileage <= 150000";
$query = mysqli_query($db_conx, $sql);
$numrowsMile4 = mysqli_num_rows($query);

$sql = "SELECT id FROM cars WHERE mileage <= 200000";
$query = mysqli_query($db_conx, $sql);
$numrowsMile5 = mysqli_num_rows($query);

$sql = "SELECT id FROM cars WHERE mileage > 200000";
$query = mysqli_query($db_conx, $sql);
$numrowsMile6 = mysqli_num_rows($query);
?><?php
// Select the member from the users table
$sql = "SELECT * FROM address WHERE id=1 LIMIT 1";
$query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($query);
$navAddress = "";
if($numrows > 0){
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $companyName = $row['name'];
    $address1 = $row['address1'];
    $address2 = $row['address2'];
    $city = $row['city'];
    $province = $row['province'];
    $postalCode = $row['postalCode'];
    $phone = $row['phone'];
    $fax = $row['fax'];
    $email = $row['email'];
    $hideEmail = $row['hideEmail'];
    $license = $row['license'];

    if($hideEmail == 1) {
      $email = "";
    }
    $navAddress = $address1.' '.$address2.' '.$city.' '.$province.' '.$postalCode;
  }
}
?>
<script type="text/javascript">
  $(function() {
    window.onload = function() {
      $('.background-loader').fadeOut(300);
    }

    function resizedWindow() {
        winWidth = $(window).width();

        if(winWidth <= 900) {

              $('.dropdown').parent().on('click', function () {
                $(this).children(".dropdown").slideToggle();
              });

              $('.dropside').parent().on('click', function () {
                $(this).children(".dropside").slideToggle();
                $(this).parent(".dropdown").slideToggle();
              });

              $('.dropside2').parent().on('click', function () {
                $(this).children(".dropside2").slideToggle();
                $(this).parent(".dropside").slideToggle();
                $(this).parent(".dropside").parent(".dropdown").slideToggle();
              });
        } else {

        }
    }

    $('.menu-bars').on('click', function() {
      $('.nav-ul').slideToggle();
    })

    $(window).resize(function() {
      resizedWindow();
    })
    resizedWindow();


  });
</script>
<div class="background-loader">
  <div class="loader">
    <span class="spinner spinner1"></span>
    <span class="spinner spinner2"></span>
    <span class="spinner spinner3"></span>
    <br>
    <span class="loader-text">LOADING...</span>
  </div>
</div>
<nav><span class="nav-address"><a target="_blank" href="https://www.google.ca/maps/place/InLine+Motors/@49.2045684,-122.9285916,17z/data=!3m1!4b1!4m5!3m4!1s0x5485d879904861cb:0x37fa6ed8f3cf9fa1!8m2!3d49.2045649!4d-122.9264029" class=""><span aria-hidden="true" class="fa fa-map-marker"></span> <?php echo $navAddress; ?> </a> |<a href="tel:<?php echo $phone ?>" class="" style="width: 100px;display: inline-block;"><span aria-hidden="true" class="fa fa-phone"></span> <?php echo $phone ?></a></span>
  <div class="nav-black">
    <div class="content"><a href="/" class="logo"><img src="../style/img/logo.png" alt="logo" width="100%" height="auto"/></a>
    <div class="float-right md-mar-right menu-bars"><a href="#" class="a lg-txt"><i class="fa fa-bars" aria-hidden="true"></i></a></div>
      <ul class="nav-ul">
        <li class="nav-li"><a href="index.php" class="">Home</a></li>
        <li class="nav-li"><a href="#" class="">Search All Vehicles <span aria-hidden="true" class="fa fa-caret-down"></span></a>
          <ul class="dropdown">
            <li><a href="vehicles.php" class="">All Vehicles</a></li>
            <li><a href="vehicles.php?coming=soon" class="">Coming Soon</a></li>
            <li><a href="#" class="">By Make (A-H)<span aria-hidden="true" class="fa fa-caret-right"></span></a>
              <ul class="dropside">
                <?php echo $carsA_H; ?>
              </ul>
            </li>
              <li><a href="#" class="">By Make (I-M) <span aria-hidden="true" class="fa fa-caret-right"></span></a>
                <ul class="dropside">
                  <?php echo $carsI_M; ?>
                </ul>
              </li>
              <li><a href="#" class="">By Make (N-Z) <span aria-hidden="true" class="fa fa-caret-right"></span></a>
                <ul class="dropside">
                  <?php echo $carsN_Z; ?>
                </ul>
              </li>
              <li><a href="#" class="">By Body Style <span aria-hidden="true" class="fa fa-caret-right"></span></a>
                <ul class="dropside">
                  <?php echo $bodyStyleList; ?>
                </ul>
              </li>
              <li><a href="#" class="">By Price <span aria-hidden="true" class="fa fa-caret-right"></span></a>
                <ul class="dropside">
                  <?php
                    echo $lessThan5K;
                    echo $lessThan10K;
                    echo $lessThan25K;
                    echo $lessThan50K;
                    echo $lessThan100K;
                    echo $moreThan100K;
                  ?>
                </ul>
              </li>
              <li><a href="#" class="">By Mileage <span aria-hidden="true" class="fa fa-caret-right"></span></a>
                <ul class="dropside">
                    <li><a href="vehicles.php?mileage=25" class="">Less than 25K km (<?php echo $numrowsMile1; ?>)</a></li>
                    <li><a href="vehicles.php?mileage=50" class="">Less than 50K km (<?php echo $numrowsMile2; ?>)</a></li>
                    <li><a href="vehicles.php?mileage=100" class="">Less than 100K km (<?php echo $numrowsMile3; ?>)</a></li>
                    <li><a href="vehicles.php?mileage=150" class="">Less than 150K km (<?php echo $numrowsMile4; ?>)</a></li>
                    <li><a href="vehicles.php?mileage=200" class="">Less than 200K km (<?php echo $numrowsMile5; ?>)</a></li>
                    <li><a href="vehicles.php?mileage=201" class="">More than 200K km (<?php echo $numrowsMile6; ?>)</a></li>
                </ul>
              </li>
            </li>
          </ul>
        </li>
        <li class="nav-li"><a href="credit-application.php" class="">Credit Application</a></li>
        <li class="nav-li"><a href="#" class="">Requests <span aria-hidden="true" class="fa fa-caret-down"></a>
          <ul class="dropdown dropdown2">
            <li><a href="vehicle-request.php" class="">Request Vehicle</a></li>
            <li><a href="sell-vehicle.php" class="">Sell Your Vehicle</a></li>
          </ul>
        </li>
        <li class="nav-li"><a href="services.php" class="">Services</a></li>
        <li class="nav-li"><a href="contact.php" class="">Contact / Map</a></li>
      </ul>
    </div>
  </div>
  <div class="nav-red">
  <!-- <div class="content">
    <ul class="nav-ul">
    </ul>
  </div> -->
</div>
</nav>
