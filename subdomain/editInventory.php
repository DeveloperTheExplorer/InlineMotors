<?php
	include_once("../php_includes/check_login_status.php");

  if (!isset($_COOKIE['email'])) {
    header('location: index.php');
  } else {
    setcookie("id", $log_id, time()+3600);
    setcookie("email", $log_email, time()+3600);
    setcookie("pass", $log_pass, time()+3600);
  }

	$page = 0;
	$next = '';
	$previous = '';

	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	}

	$offset = $page * 50;
	$nextPage = $page + 1;
	$previousPage = $page - 1;
	// Select the member from the users table
	$sql = "SELECT id FROM cars ORDER BY make ASC LIMIT 51 OFFSET $offset";
	$query = mysqli_query($db_conx, $sql);
	$statusnumrows = mysqli_num_rows($query);
	if($page == 0 && $statusnumrows > 50) {
		$next ='<h3 class="slim-txt center-txt no-mar-top">Pagination</h3>
						<hr>
						<a href="editInventory.php?page='.$nextPage.'" class="float-right btn btn-inverse-google-blue sm-btn md-pad-left md-pad-right">Next</a>';
		$previous = "";
	} else if($page > 0 && $statusnumrows > 50) {
		$next ='<h3 class="slim-txt center-txt no-mar-top">Pagination</h3>
						<hr>
						<a href="editInventory.php?page='.$nextPage.'" class="float-right btn btn-inverse-google-blue sm-btn md-pad-left md-pad-right">Next</a>';
		$previous = '<a href="editInventory.php?page='.$previousPage.'" class="float-left btn btn-dft sm-btn md-pad-left md-pad-right">Previous</a>';
	} else if ($page > 0 && $statusnumrows <= 50) {
		$next ='<h3 class="slim-txt center-txt no-mar-top">Pagination</h3>
						<hr>';
		$previous = '<a href="editInventory.php?page='.$previousPage.'" class="float-left btn btn-dft sm-btn md-pad-left md-pad-right">Previous</a>';
	}
?><?php
  // Select the member from the users table
  $sql = "SELECT * FROM cars ORDER BY make ASC LIMIT 50 OFFSET $offset";
  $query = mysqli_query($db_conx, $sql);
  $statusnumrows = mysqli_num_rows($query);
  $table = '';
	$print = '';
  $live = '';
  $sold = '';
  $soldLeave = '';
  $salePending = '';
  $comingSoon = '';
	$featured = '';
  if($statusnumrows > 0){
    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
      $id = $row['id'];
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
	    $price1 = $row['price'];
	    $price = $row['price'];
	    $price = number_format($price, 0, '', ',');
	    $offer = $row['offer'];
	    $mileage = $row['mileage'];
	    $mileage = number_format($mileage, 0, '', ',');
	    $title = $year." ".$make." ".$model;

			$sql1 = "SELECT carid FROM featured WHERE carid=$id LIMIT 1";
		  $query1 = mysqli_query($db_conx, $sql1);
		  $statusnumrows1 = mysqli_num_rows($query1);
		  if($statusnumrows1 > 0){
				$featured = '<a href="#" data-id='.$id.' class="btn btn-inverse-red sm-btn md-pad-left md-pad-right remove-featured">Remove</a>';
			} else {
				$featured = '<a href="#" data-id='.$id.' class="btn btn-inverse-google-blue sm-btn md-pad-left md-pad-right add-featured">Add</a>';
			}

      if($status == 'live') {
        $live = 'selected=""';
        $sold = '';
        $soldLeave = '';
        $salePending = '';
        $comingSoon = '';

      } else if($status == 'sold') {
        $sold = 'selected=""';
        $live = '';
        $soldLeave = '';
        $salePending = '';
        $comingSoon = '';

      } else if($status == 'soldLeave') {
        $soldLeave = 'selected=""';
        $live = '';
        $sold = '';
        $salePending = '';
        $comingSoon = '';

      } else if($status == 'salePending') {
        $salePending = 'selected=""';
        $live = '';
        $sold = '';
        $soldLeave = '';
        $comingSoon = '';

      } else if($status == 'comingSoon') {
        $comingSoon = 'selected=""';
        $live = '';
        $sold = '';
        $soldLeave = '';
        $salePending = '';

      }
			$print .= '<tr>
                  <td>'.$stock.'</td>
                  <td>'.$vin.'</td>
									<td>'.$year.'</td>
									<td>'.$make.'</td>
									<td>'.$model.'</td>
                  <td>'.$trim.'</td>
                  <td>'.$engine.'</td>
                  <td>'.$driveType.'</td>
                  <td>'.$transmission.'</td>
									<td>'.$mileage.' km</td>
                  <td>'.$exteriorColor.'</td>
                  <td>$'.$price.'</td>
                  <td>'.$offer.'</td>
                </tr>';

      $table .= '<tr>
                  <td class="sorting sorting-'.$id.'">'.$id.'</td>
                  <td class="xs-pad-top">
                    <a href="edit.php?id='.$id.'" class="btn btn-inverse-google-blue sm-btn md-pad-left md-pad-right">Edit</a>
                  </td>
                  <td>'.$year.'</td>
                  <td>'.$make.'</td>
                  <td>'.$model.'</td>
                  <td>$'.$price.'</td>
                  <td>'.$mileage.' km</td>
                  <td>#'.$stock.'</td>
                  <td>'.$featured.'</td>
                  <td>
                  <select name="status" class="statusOption" data-id="'.$id.'">
                    <option value="sold" '.$sold.'>Sold</option>
                    <option value="soldLeave" '.$soldLeave.'>Sold leave on website</option>
                    <option value="delete">Delete</option>
                    <option value="salePending" '.$salePending.'>Sale Pending</option>
                    <option value="live" '.$live.'>Live</option>
                    <option value="comingSoon" '.$comingSoon.'>Coming Soon</option>
                  </select>
                  </td>
                  <td>'.$offer.'</td>
                </tr>';
    }
  } else {
    // header('location: /');
  }
?><?php
if(isset($_POST['status']) && $_POST['status'] != 'delete') {
  $status = $_POST['status'];
  $postID = $_POST['id'];

  $sql = "UPDATE cars SET status='$status' WHERE id=$postID LIMIT 1";
	$query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));

  echo 'success';
  exit();

}
if(isset($_POST['status']) && $_POST['status'] == 'delete') {
  $postID = $_POST['id'];

  $sql = "DELETE FROM cars WHERE id=$postID LIMIT 1";
	$query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));

  echo 'success';
  exit();

}
?><?php
if(isset($_POST['featuredStatus']) && $_POST['featuredStatus'] == 'add') {
  $featuredID = $_POST['featuredID'];

  $sql = "INSERT INTO featured(carid, date) VALUES('$featuredID',now())";
	$query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));

  echo 'success';
  exit();

}
if(isset($_POST['featuredStatus']) && $_POST['featuredStatus'] == 'remove') {
  $featuredID = $_POST['featuredID'];

  $sql = "DELETE FROM featured WHERE carid=$featuredID LIMIT 1";
	$query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));

  echo 'success';
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
    <script type="text/javascript" src="../tinymce/tinymce.min.js"></script>
  </head>
  <body class="controlPanel" data-pageName="editInventory">
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

    <?php include_once('nav.php'); ?>

		<main class="mainPanel no-mar-top" style="margin-left: 15px; display:none;" id="printInventory">
      <div class="row no-mar">
        <div class="column lg-mar-bottom" style="width: 100%; left: 0; margin-left: 0;">
          <div class="bg-white sm-mar-bottom">
            <div class="section row no-mar">
              <div class="xs-col-12">
                <table class="table table-striped xs-txt">
                  <thead>
                    <tr>
                      <th>Stock #</th>
                      <th>VIN #</th>
                      <th>Year</th>
                      <th>Make</th>
                      <th>Model</th>
											<th>Trim</th>
											<th>Engine Size</th>
											<th>Drive</th>
											<th>Transmission</th>
											<th>Km</th>
                      <th>Color</th>
                      <th>Advertised $$</th>
                      <th>Special Offers</th>
                    </tr>
                  </thead>
                  <tbody class="printTD">
                    <?php echo $print; ?>
                  </tbody>
                </table>

              </div>
            </div>

          </div>
        </div>
      </div>
    </main>

    <main class="mainPanel">
      <div class="row">
        <div class="column lg-mar-bottom" style="width: 1100px; margin-left: -550px;">
          <h3 class="no-mar-bottom">Edit Vehicle Inventory</h3>
          <div class="bg-white sm-mar-bottom">
            <div class="section row">

              <input type="text" id="myInput" class="txt lg-input blk sm-mar xs-col-12" onkeyup="myFunction()" placeholder="Search Car Makes..." title="Type in a name">
              <div class="xs-col-12">
                <table class="table table-striped sm-txt" id="myTable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Edit</th>
                      <th>Year</th>
                      <th>Make</th>
                      <th>Model</th>
                      <th>Price</th>
                      <th>Mileage</th>
                      <th>Stock No</th>
                      <th>Featured</th>
                      <th>Status</th>
											<th>Special Offers</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php echo $table; ?>
                  </tbody>
                </table>

              </div>
            </div>

          </div>
					<?php echo $next;
					echo $previous; ?>
        </div>
				<button id="printPage" type="button" name="button" class="lg-btn btn-inverse-black center-txt center-blk blk"><span class="sm-mar-right fa fa-print"></span>Print Inventory</button>
      </div>
    </main>

    <script type="text/javascript">

      function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[3];
          if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }
        }
      }

      (function() {
        window.onload = function() {
					$('.background-loader').fadeOut(300);
				}

        var pageName = $('body').attr('data-pageName');
        $('.'+pageName).addClass('active');

        $('a').on('click', function() {
          if($(this).attr('href') == "#") {
            return false;
          }
        })

        $('form').submit(function(e) {
          return false;
        })

				$('#printPage').on('click', function() {
					var bodyHTML = $('body').html();
					var print = $('#printInventory').html();

					$('#printInventory').css('display', 'block');
					$('body').html(print);
					$('body').css('background-color', '#fff');
					window.print();
					$('body').html(bodyHTML);
					$('body').css('background-color', '#f1f1f1');
				})

        $('.statusOption').change(function() {
          var element = $(this);
          var status = $(this).val();
          var id = $(this).attr('data-id');

          if(status == "delete") {
            var r = confirm("Are you sure you want to delete this post?");
            if (r == true) {
              $.post('editInventory.php', {
                status: status,
                id: id

              }, function(data) {
                if(data != 'success') {
                  alert('There is something wrong. Please contact us right away!');
                  console.log(data);
                }
                element.parent().parent().css('display', 'none');
              })
            } else {
              element.val('');
            }
          } else {
            $.post('editInventory.php', {
              status: status,
              id: id

            }, function(data) {
              if(data != 'success') {
                alert('There is something wrong. Please contact us right away!');
                console.log(data);
              }
              console.log(data);
            })
          }
        })
      })();


			$('.remove-featured').on('click', function() {
				var element = $(this);
			  var featuredID = $(this).attr("data-id");

				$.post('editInventory.php', {
					featuredID: featuredID,
					featuredStatus: 'remove'
				}, function(data) {
					if(data == 'success') {
						element.parent().html('<a href="#" data-id='+featuredID+' class="btn btn-inverse-google-blue sm-btn md-pad-left md-pad-right add-featured">Add</a>');
					} else {
						console.log(data);
						alert("Sorry, there seems to be a problem, please contact your developer!");
					}
				})
			})

			$('body').on('click', '.remove-featured', function() {
				var element = $(this);
			  var featuredID = $(this).attr("data-id");

				$.post('editInventory.php', {
					featuredID: featuredID,
					featuredStatus: 'remove'
				}, function(data) {
					if(data == 'success') {
						element.parent().html('<a href="#" data-id='+featuredID+' class="btn btn-inverse-google-blue sm-btn md-pad-left md-pad-right add-featured">Add</a>');
					} else {
						console.log(data);
						alert("Sorry, there seems to be a problem, please contact your developer!");
					}
				})
			})
			$('.add-featured').on('click', function() {
				var element = $(this);
			  var featuredID = $(this).attr("data-id");

				$.post('editInventory.php', {
					featuredID: featuredID,
					featuredStatus: 'add'
				}, function(data) {
					if(data == 'success') {
						element.parent().html('<a href="#" data-id='+featuredID+' class="btn btn-inverse-red sm-btn md-pad-left md-pad-right remove-featured">Remove</a>');
					} else {
						console.log(data);
						alert("Sorry, there seems to be a problem, please contact your developer!");
					}
				})
			})
			$('body').on('click', '.add-featured',function() {
				var element = $(this);
			  var featuredID = $(this).attr("data-id");

				$.post('editInventory.php', {
					featuredID: featuredID,
					featuredStatus: 'add'
				}, function(data) {
					if(data == 'success') {
						element.parent().html('<a href="#" data-id='+featuredID+' class="btn btn-inverse-red sm-btn md-pad-left md-pad-right remove-featured">Remove</a>');
					} else {
						console.log(data);
						alert("Sorry, there seems to be a problem, please contact your developer!");
					}
				})
			})
    </script>
  </body>
</html>
