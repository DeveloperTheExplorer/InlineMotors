<?php
	include_once("../php_includes/check_login_status.php");

	$sort_1 = "none";

	$title = "All Vehicles:";


	$page = 0;
	$next = '';
	$previous = '';

	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	}

	$offset = $page * 12;
	$nextPage = $page + 1;
	$previousPage = $page - 1;
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$link = "";
	if(strrpos($actual_link, 'page') == false) {
		$link = $actual_link."&page=";

	} else if (strrpos($actual_link, 'page') == true) {
		$link = substr($actual_link, 0, stripos($actual_link, 'page')).'page=';
	}

	if(strrpos($actual_link, '?') == false) {
		$link = $actual_link."?page=";
	}


	// Select the member from the users table
	$sql = "SELECT id FROM cars ORDER BY make ASC LIMIT 19 OFFSET $offset";
	$query = mysqli_query($db_conx, $sql);
	$statusnumrows = mysqli_num_rows($query);
	if($page == 0 && $statusnumrows > 18) {
		$next ='<h3 class="slim-txt center-txt md-mar-top">Pagination</h3>
						<hr>
						<a href="'.$link.$nextPage.'" class="float-right btn btn-inverse-black sm-btn md-pad-left md-pad-right">Next</a>';
		$previous = "";
	} else if($page > 0 && $statusnumrows > 18) {
		$next ='<h3 class="slim-txt center-txt md-mar-top">Pagination</h3>
						<hr>
						<a href="'.$link.$nextPage.'" class="float-right btn btn-inverse-black sm-btn md-pad-left md-pad-right">Next</a>';
		$previous = '<a href="'.$link.$previousPage.'" class="float-left btn btn-dft sm-btn md-pad-left md-pad-right">Previous</a>';
	} else if ($page > 0 && $statusnumrows <= 18) {
		$next ='<h3 class="slim-txt center-txt md-mar-top">Pagination</h3>
						<hr>';
		$previous = '<a href="'.$link.$previousPage.'" class="float-left btn btn-dft sm-btn md-pad-left md-pad-right">Previous</a>';
	}


	$order = "ORDER BY date DESC LIMIT 18 OFFSET $offset";
	if(isset($_GET['sort'])) {
		$sort = $_GET['sort'];
		$sort_1 = $_GET['sort'];
		$sort= explode('-', $sort);
		$sort0 = $sort[0];
		$sort1 = $sort[1];
		$sort1 = strtoupper($sort1);

		$order = "ORDER BY ".$sort0." ".$sort1." LIMIT 18 OFFSET $offset";
	}


	$sql = "SELECT * FROM cars WHERE status!='sold' ".$order;
  if(isset($_GET['make']) && !isset($_GET['model'])) {
    $make = $_GET['make'];
		$title = "All ".$make.'s';
    $sql = "SELECT * FROM cars WHERE make='$make' ".$order;
  } else if(isset($_GET['make']) && isset($_GET['model'])) {
    $make = $_GET['make'];
    $model = $_GET['model'];
		$title = "All ".$make.' '.$model.'s';
    $sql = "SELECT * FROM cars WHERE make='$make' AND model='$model' ".$order;
  } else if(isset($_GET['coming']) && $_GET['coming'] == 'soon') {
		$title = "Vehicles Coming Up For Sale Soon";
    $sql = "SELECT * FROM cars WHERE status='comingSoon' ".$order;
  } else if(isset($_GET['bodyStyle'])) {
    $bodyStyle = $_GET['bodyStyle'];
		$title = "All ".$bodyStyle.'s';
    $sql = "SELECT * FROM cars WHERE bodyStyle='$bodyStyle' ".$order;
  } else if(isset($_GET['price'])) {
    $price = $_GET['price'];
    if($price == 5) {
      $sql = "SELECT * FROM cars WHERE price < 5000 ".$order;
    } else if($price == 10) {
      $sql = "SELECT * FROM cars WHERE price <= 10000 AND price > 5000 ".$order;
    } else if($price == 25) {
      $sql = "SELECT * FROM cars WHERE price <= 25000 AND price > 10000 ".$order;
    } else if($price == 50) {
      $sql = "SELECT * FROM cars WHERE price <= 50000 AND price > 25000 ".$order;
    } else if($price == 100) {
      $sql = "SELECT * FROM cars WHERE price <= 100000 AND price > 50000 ".$order;
    } else if($price == 101) {
      $sql = "SELECT * FROM cars WHERE price > 100000 ".$order;
    }
  } else if(isset($_GET['mileage'])) {
    $mileage = $_GET['mileage'];
    if($mileage == 25) {
      $sql = "SELECT * FROM cars WHERE mileage < 25000 ".$order;
    } else if($mileage == 50) {
      $sql = "SELECT * FROM cars WHERE mileage <= 50000 ".$order;
    } else if($mileage == 100) {
      $sql = "SELECT * FROM cars WHERE mileage <= 100000  ".$order;
    } else if($mileage == 150) {
      $sql = "SELECT * FROM cars WHERE mileage <= 150000  ".$order;
    } else if($mileage == 200) {
      $sql = "SELECT * FROM cars WHERE mileage <= 200000 ".$order;
    } else if($mileage == 201) {
      $sql = "SELECT * FROM cars WHERE mileage > 200000 ".$order;
    }
  }

  $query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));
  $numrows = mysqli_num_rows($query);
  $featuredCarList = '';
  if($numrows > 0){
    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
      $featuredID = $row['id'];
      $year = $row['year'];
      $make = $row['make'];
      $model = $row['model'];
      $trim = $row['trim'];
      $photos = $row['images'];
      $photos = explode(',', $photos);
      $photos = $photos[0];
      $price1 = $row['price'];
      $price = $row['price'];
      $price = '$'.number_format($price, 0, '', ',');
      $mileage = $row['mileage'];
      $mileage = number_format($mileage, 0, '', ',');
      $transmission = $row['transmission'];
      $status = $row['status'];
      $fuelType = $row['fuelType'];

			if($status == 'soldLeave') {
				$price = '<span class="txt-alert"> Sold </span>';
			}

      if($photos == "") {
        $photos = '../photos/imagePlaceHolder123.png';
      }

      $featuredCarList .= '<div class="col-xs-12 col-sm-6 col-md-4 relative md-pad-bottom sm-pad-top border-0 border-1-bottom border-subtle car">
                            <div style="min-height: 250px">
                              <img src="'.$photos.'" alt="" width="100%" height="auto">
                            </div>
                            <h2 class="border-0 sm-pad-left border-4-left border-red line-1.5">'.$year.' '.$make.' '.$model.'</h2>
                            <hr class="sm-mar-top">
                            <div class="flex-between">
                              <div class="width-40">
                                <div class="flex-between">
                                  <span>Price </span>
                                  <strong> '.$price.'</strong>
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
  } else {
    $featuredCarList = '<h1 class="slim-txt center-txt">Sorry, no vehicles were found.</h1>';
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
    <title>Is It fine?</title>
    <link rel="shortcut icon" type="image/png" href="../style/img/logo_icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,500" rel="stylesheet">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <script type="text/javascript" src="../js/jquery-2.1.4.js"></script>
    <script src="../style/bootstrap/js/bootstrap.min.js"></script>
    <style media="screen">
      h1, h2, h3, h4, h5, h6 {
        line-height: normal;
      }
      a:hover {
        text-decoration: none;
      }
    </style>
  </head>
  <body data-sorting="<?php echo $sort_1; ?>">
		<?php include_once("nav.php"); ?>
    <main>
      <div id="myCarousel" data-ride="carousel" class="carousel slide">
        <!-- Wrapper for slides-->
        <div class="carousel-inner">
					<?php echo $images; ?>
        </div>
        <!-- Left and right controls--><a href="#myCarousel" data-slide="prev" class="left carousel-control"><span class="glyphicon glyphicon-chevron-left fa fa-angle-left uniqueControl"></span><span class="sr-only">Previous</span></a><a href="#myCarousel" data-slide="next" class="right carousel-control"><span class="glyphicon glyphicon-chevron-right fa fa-angle-right uniqueControl"></span><span class="sr-only">Next</span></a>
      </div>





      <div class="container">
        <div class="row no-mar">
          <div class="input-group col-sm-5 col-md-4 sm-mar-bottom" style="float: left; position: relative; z-index: -1;">
            <input type="text" id="filter" class="form-control" placeholder="Search By Make, Model or Year" aria-label="Search for a vehicle">
            <span class="input-group-addon"><span aria-hidden="true" class="fa fa-search"></span></span>
          </div>
          <div class="col-sm-4 col-md-3 col-sm-push-3 col-md-push-5">
            <select name="sort" id="sort" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              <option id="none" value="">Sort Vehicles</option>
              <option id="price-desc" value="price-desc">Price: High to Low</option>
              <option id="price-asc" value="price-asc">Price: Low to High</option>
              <option id="mileage-desc" value="mileage-desc">Mileage: High to Low</option>
              <option id="mileage-asc" value="mileage-asc">Mileage: Low to High</option>
							<option id="year-desc" value="year-desc">Year: New to Old</option>
							<option id="year-asc" value="year-asc">Year: Old to New</option>
              <option id="make-asc" value="make-asc">Make Name: A to Z</option>
              <option id="make-desc" value="make-desc">Make Name: Z to A</option>
            </select>
          </div>
          <hr class="sm-mar-top width-80">
					<h2 class="center-txt slim-txt"><?php echo $title; ?></h2>
					<div class="" id="theCarList">
						<?php echo $featuredCarList; ?>
					</div>
        </div>
				<?php echo $next;
				echo $previous; ?>
      </div>

    </main>

    <?php include_once("footer.php"); ?>

  </body>

  <script type="text/javascript">
    (function() {
			var theSort = $('body').attr('data-sorting');
			$('#'+theSort).attr('selected', 'selected');
      var sc = 0;
      function scroll() {
        sc = $(window).scrollTop();
        // console.log(sc);
        if(sc < 1000) {
          // $('.background-img').css('background-position', 'center ' + -(sc/2 + 125) + 'px');
        }
      }

      $(window).scroll(function() {
        scroll();
      });

      scroll();

      var link = "";
      $('#sort').change(function() {
        var sorting = $('#sort').val();
        var currentLink = window.location.href;

        if(sorting == 'price-desc' || sorting == 'price-asc' || sorting == 'mileage-desc' || sorting == 'mileage-asc' || sorting == 'make-desc' || sorting == 'make-asc' || sorting == 'year-desc' || sorting == 'year-asc') {
          if(currentLink.indexOf('?') > -1) {

            currentLink = currentLink+'&sort='+sorting;
            if(currentLink.indexOf('sort=') > -1) {
              currentLink = currentLink.substring(0, currentLink.indexOf('sort='))+'sort='+sorting;
            } else if(currentLink.indexOf('&sort=') > -1) {
              currentLink = currentLink.substring(0, currentLink.indexOf('sort='))+'&sort='+sorting;
            }
            window.location.href = currentLink;


          } else {
            window.location.href = 'vehicles.php?sort='+sorting;
          }

        }
      })


			$('#filter').keyup(function() {
				var input, filter, theCarList, div, h2, i;
		    input = document.getElementById("filter");
		    filter = input.value.toUpperCase();
		    theCarList = document.getElementById("theCarList");
		    div = theCarList.getElementsByClassName("car");
		    for (i = 0; i < div.length; i++) {
		        h2 = div[i].getElementsByTagName("h2")[0];
		        if (h2.innerHTML.toUpperCase().indexOf(filter) > -1) {
		            div[i].style.display = "";
		        } else {
		            div[i].style.display = "none";

		        }
		    }
			})

    })();
  </script>
</html>
