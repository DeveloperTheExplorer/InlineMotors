<?php
	include_once("../php_includes/check_login_status.php");

  if (!isset($_COOKIE['email'])) {
    header('location: index.php');
  } else {
    setcookie("id", $log_id, time()+3600);
    setcookie("email", $log_email, time()+3600);
    setcookie("pass", $log_pass, time()+3600);
  }
?><?php
if(isset($_POST['vinNum'])) {
  $apiPrefix = "https://api.vindecoder.eu/2.0";
  $apikey = "db6989dd28dd";   // Your API key
  $secretkey = "29bc36251d";  // Your secret key
  $vin = $_POST['vinNum']; // Requested VIN
  $id = $vin;


  $controlsum = substr(sha1("{$id}|{$apikey}|{$secretkey}"), 0, 10);

  $data = file_get_contents("{$apiPrefix}/{$apikey}/{$controlsum}/decode/{$vin}.json", false);
  $result = json_decode($data);

  echo json_encode($result);
  exit();
}

if(isset($_POST['vin'])) {
  $vin = $_POST['vin'];
  $year = $_POST['year'];
  $make = $_POST['make'];
  $model = $_POST['model'];
  $trim = $_POST['trim'];
  $bodyStyle = $_POST['bodyStyle'];
  $engine = $_POST['engine'];
  $transmission = $_POST['transmission'];
  $driveType = $_POST['driveType'];
  $fuelType = $_POST['fuelType'];
  $fuelCity = $_POST['fuelCity'];
  $fuelHighway = $_POST['fuelHighway'];
  $doors = $_POST['doors'];
  $exteriorColor = $_POST['exteriorColor'];
  $interiorColor = $_POST['interiorColor'];
  $details = $_POST['details'];
  $stock = $_POST['stock'];
  $status = $_POST['status'];
  $photos = $_POST['photos'];
  $price = $_POST['price'];
  $offer = $_POST['offer'];
  $mileage = $_POST['mileage'];

  $sql = "INSERT INTO cars(vin, year, make, model, price, offerm mileage, trim, bodyStyle, exteriorColor, interiorColor, engine, transmission, driveType, fuelType, fuelCity, fuelHighway, doors, comment, stock, status, images, date)
      VALUES('$vin','$year','$make','$model','$price','$offer','$mileage','$trim','$bodyStyle','$exteriorColor','$interiorColor','$engine','$transmission','$driveType','$fuelType','$fuelCity','$fuelHighway','$doors','$details','$stock'
      ,'$status','$photos',now())";
  $query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));
  $id = mysqli_insert_id($db_conx);

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
    <script type="text/javascript">

			$(function() {
				tinymce.init({
					plugins: [
			        "advlist autolink lists link image charmap print preview anchor",
			        "searchreplace visualblocks fullscreen textcolor colorpicker",
			        "insertdatetime media table contextmenu paste imagetools hr"
			    ],
			    toolbar: "insertfile undo redo | styleselect fontselect fontsizeselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
					selector: "#details"
				});
			});
		</script>
  </head>
  <body class="controlPanel" data-pageName="addVehicle">
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


    <main class="mainPanel">
      <div class="row">

        <div class="column">
          <h3 class="no-mar-bottom">Add a new car</h3>
          <div class="bg-white lg-mar-bottom">
            <div class="section row">
              <div class="col-sm-8">
                <label class="blk sm-mar-left">VIN #</label>
                <input type="text" name="vin" id="vinNum" class="required full-width txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-4">
                <label class="blk sm-mar-left opacity-0"> a</label>
                <input type="submit" name="vinDecoder" id="vinDecoder" value="Vin Decoder" class="btn btn-inverse-black lg-btn lg-pad-left lg-pad-right sm-mar-left sm-mar-bottom width-90">
              </div>
              <div class="col-sm-12">
                <h3 class="center-txt">Please double check the data after entering the VIN number as they can be inaccurate at times.</h3>
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Year</label>
                <input type="number" name="year" id="year" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Make</label>
                <input type="text" name="make" id="make" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Model</label>
                <input type="text" name="model" id="model" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Price</label>
                <input type="number" name="price" id="price" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Mileage</label>
                <input type="number" name="mileage" id="mileage" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Trim</label>
                <input type="text" name="trim" id="trim" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Body Style</label>
                <input type="text" name="bodyStyle" id="bodyStyle" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Exterior Color</label>
                <input type="text" name="exteriorColor" id="exteriorColor" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Interior Color</label>
                <input type="text" name="interiorColor" id="interiorColor" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Engine</label>
                <input type="text" name="engine" id="engine" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Transmission</label>
                <input type="text" name="transmission" id="transmission" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Drive Type</label>
                <input type="text" name="driveType" id="driveType" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Fuel Type</label>
                <input type="text" name="fuelType" id="fuelType" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">L/100km City</label>
                <input type="text" name="fuelCity" id="fuelCity" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">L/100km Highway</label>
                <input type="text" name="fuelHighway" id="fuelHighway" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Doors</label>
                <input type="text" name="doors" id="doors" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Stock #</label>
                <input type="text" name="stock" id="stock" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
              </div>
              <div class="col-xs-12 md-mar-bottom" id="detailsArea">
								<label class="blk sm-mar-top sm-mar-bottom"> Any additional comments:</label>
								<textarea name="Large Description" id="details"></textarea>
							</div>
              <!-- <div class="col-sm-12">
                <label class="blk sm-mar-left">Video Plugin: (Youtube only)</label>
                <input type="text" name="video" id="video" placeholder="i.e. https://www.youtube.com/watch?v=s2N6kZW8SDc" class="required width-95 txt lg-input sm-mar-left sm-mar-bottom">
              </div> -->
              <div class="col-sm-6">
                <label class="blk sm-mar-left">Status</label>
                <select name="workStatus" id="workStatus" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
                  <option value="live">Live</option>
                  <option value="sold">Sold</option>
                  <option value="soldLeave">Sold leave on website</option>
                  <option value="salePending">Sale pending</option>
                  <option value="comingSoon">Coming Soon</option>
                </select>
              </div>
							<div class="col-sm-6">
                <label class="blk sm-mar-left">Special Offer (reduced price/support/sale)</label>
                <input type="text" name="offer" id="offer" class="required width-90 txt lg-input sm-mar-left sm-mar-bottom">
								<h3 class="blk sm-mar-left">Leave offer empty if you do not have any Special Offers, sales, or promotions.</h3>
              </div>
              <!-- <form>
                <div class="col-sm-8">
                  <label class="blk sm-mar-left">Add Vehicle Features</label>
                  <input type="text" name="features" id="features" class="required full-width txt lg-input sm-mar-left sm-mar-bottom">
                </div>
                <div class="col-sm-4">
                  <label class="blk sm-mar-left opacity-0"> a</label>
                  <input type="submit" name="featuresSubmit" id="featuresSubmit" value="Add" class="btn btn-inverse-black lg-btn lg-pad-left lg-pad-right sm-mar-left sm-mar-bottom width-90">
                </div>
                <div class="col-sm-12" id="featuresList">
                </div>
              </form> -->

              <!-- <form>
                <div class="col-sm-8">
                  <label class="blk sm-mar-left">Add Vehicle Tags</label>
                  <input type="text" name="tags" id="tags" class="required full-width txt lg-input sm-mar-left sm-mar-bottom">
                </div>
                <div class="col-sm-4">
                  <label class="blk sm-mar-left opacity-0"> a</label>
                  <input type="submit" name="tagsSubmit" id="tagsSubmit" value="Add" class="btn btn-inverse-black lg-btn lg-pad-left lg-pad-right sm-mar-left sm-mar-bottom width-90">
                </div>
                <div class="col-sm-12" id="tagsList">
                </div>
              </form> -->

              <div class="col-sm-12 md-mar-bottom">
                <h3 class="no-mar-bottom width-90 center-blk">Photos</h3>
  							<div class="width-90 photos border-2 border-subtle md-pad center-blk">
                </div>
							</div>

                <div class="col-sm-12 md-mar-bottom">
                  <div class="uploadArea width-90 lg-txt sm-mar-bottom" id="uploadPDF">
            				Drag Photos In Proper Order Inside This Box.
            			</div>
                </div>

              <div class="col-sm-6">
                <label class="blk sm-mar-left opacity-0"> a</label>
                <input type="submit" name="vinDecoder" id="submitCar" value="Submit Car" class="btn btn-inverse-black lg-btn lg-pad-left lg-pad-right sm-mar-left sm-mar-bottom width-90">
              </div>


            </div>
          </div>
        </div>

      </div>
    </div>




    <script type="text/javascript">
			(function() {
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

        // var featureNum = 1;
        // $('#featuresSubmit').on('click', function() {
        //   var feature = $('#features').val();
        //   $('#featuresList').append('<div id="feature'+featureNum+'" class="featureParent sm-mar"><span class="feature">'+feature+'</span><span href="#" data-remove="'+featureNum+'" class="removeFeature pointer">x</a></div>');
        //   $('#features').val('');
        //   featureNum++;
        // })
        // $('body').on('click', '.removeFeature', function() {
        //   var featureID = $(this).attr("data-remove");
        //   $('#feature'+featureID).remove();
				// })
        //
        // var tagNum = 1;
        // $('#tagsSubmit').on('click', function() {
        //   var tag = $('#tags').val();
        //   $('#tagsList').append('<div id="tag'+tagNum+'" class="featureParent sm-mar"><span class="feature">'+tag+'</span><span href="#" data-remove="'+tagNum+'" class="removeTag pointer">x</a></div>');
        //   $('#tags').val('');
        //   tagNum++;
        // })
        // $('body').on('click', '.removeTag', function() {
        //   var tagID = $(this).attr("data-remove");
        //   $('#tag'+tagID).remove();
        // })

        $('body').on('click', '.removePhoto', function() {
					var thisElement = $(this);
					var element = $(this).next();
					var name = element.attr('data-name');
					$.post('controlPanel.php', {
						name: name,
						type: 'remove photo'

					}, function(data) {
						if(data == "") {
							$('.photos').text('Sorry, something went wrong');

						} else if (data == "failed") {
							$('.photos').text('Sorry, something went wrong');

						} else if (data = "success") {
							thisElement.parent().css('display', 'none');
						} else {
							alert(data);
						}
					})
				})

        var result;
        var uploadPDF = document.getElementById('uploadPDF');
        var displayUploads = function(data) {
          console.log(data);
          result = JSON.parse(data);
          for (var i = 0; i < result.length; i++) {
            var fileArray = result[i].file.split('.');
            var fileExt = fileArray[fileArray.length -1];
            fileExt = fileExt.toUpperCase();
            if (fileExt == "GIF" || fileExt == "JPG" || fileExt == "JPEG" || fileExt == "TIF" || fileExt == "TIFF" || fileExt == "PNG") {
              $('.photos').append('<div class="relative inline-blk"><i class="absolute xs-pad closePop sm-right removePhoto pointer">x</i><img src="../photos/'+result[i].name+'" data-name="'+result[i].name+'" alt="" class="sm-pad sm-mar-bottom thumbnail sm-mar-right border-1 border-subtle" height="100px"></div>');
              if($('.photosPlaceHolder')) {
                $('.photosPlaceHolder').css('display', 'none');
              }
            }

          }
          $('.background-loader').fadeOut(300);
          $('#PDFPop').fadeOut(300);
          $('.bg-pop').fadeOut(300);
        };

        var uploadFiles = function(files) {
          var formData = new FormData(),
              xhr = new XMLHttpRequest(),
              x;

          for(x = 0; x < files.length; x++) {
            formData.append('files[]', files[x]);
          }

          xhr.onload = function() {
            var data = this.responseText;
            displayUploads(data);
          }

          xhr.open('post', 'upload.php');
          xhr.send(formData);
        };

        uploadPDF.ondrop = function(e) {
          $('.background-loader').fadeIn(300);
          e.preventDefault();
          $('#uploadPDF').removeClass('dragover');
          uploadFiles(e.dataTransfer.files);
        };

        uploadPDF.ondragover = function() {
          $('#uploadPDF').addClass('dragover');
          return false;
        };

        uploadPDF.ondragleave = function() {
          $('#uploadPDF').removeClass('dragover');
          return false;
        };

				window.onload = function() {
					$('.background-loader').fadeOut(300);
				}

        $('#vinDecoder').on('click', function() {
          var vinNum = $('#vinNum').val();
					var stock = vinNum.slice(-4);
					$('#stock').val(stock);
          $('.background-loader').fadeIn(300);
          $.post('addVehicle.php', {
            vinNum: vinNum

          }, function(data) {
  					$('.background-loader').fadeOut(300);
            data = JSON.parse(data);
            // console.log(data);
            // console.log(data.decode[0].value);
            console.log(data);

            var transmission = '';
            var gears = '';
            for(var i = 0; i < data.decode.length; i++) {
              if(data.decode[i].label == "Make") {
                $('#make').val(data.decode[i].value);

              } else if(data.decode[i].label == "Model Year") {
                $('#year').val(data.decode[i].value);

              } else if(data.decode[i].label == "Model") {
                $('#model').val(data.decode[i].value);

              } else if(data.decode[i].label == "Trim") {
                $('#trim').val(data.decode[i].value);

              } else if(data.decode[i].label == "Body") {
                $('#bodyStyle').val(data.decode[i].value);

              } else if(data.decode[i].label == "Drive") {
                $('#driveType').val(data.decode[i].value);

              } else if(data.decode[i].label == "Number of Doors") {
                $('#doors').val(data.decode[i].value + " Doors");

              } else if(data.decode[i].label == "Engine (full)") {
                $('#engine').val(data.decode[i].value);

              } else if(data.decode[i].label == "Fuel Type - Primary") {
                $('#fuelType').val(data.decode[i].value);

              } else if(data.decode[i].label == "Transmission") {
                transmission = data.decode[i].value;

              } else if(data.decode[i].label == "Number of Gears") {
                gears = data.decode[i].value;

              } else if(data.decode[i].label == "Fuel Consumption l/100km (Urban)") {
                $('#fuelCity').val(data.decode[i].value);

              } else if(data.decode[i].label == "Fuel Consumption l/100km (Extra Urban)") {
                $('#fuelHighway').val(data.decode[i].value);
              }
            }

            // $('#make').val(data.decode[label['Make']].value);
            $('#transmission').val(gears + " speed " + transmission);


          });
        })

        function sleep(miliseconds) {
           var currentTime = new Date().getTime();

           while (currentTime + miliseconds >= new Date().getTime()) {
           }
        }

        var submitted = false;
        $('#submitCar').on('click', function() {
          var vin = $('#vinNum').val();
          var make = $('#make').val();
          var year = $('#year').val();
          var model = $('#model').val();
          var trim = $('#trim').val();
          var bodyStyle = $('#bodyStyle').val();
          var engine = $('#engine').val();
          var transmission = $('#transmission').val();
          var driveType = $('#driveType').val();
          var fuelType = $('#fuelType').val();
          var fuelCity = $('#fuelCity').val();
          var fuelHighway = $('#fuelHighway').val();
          var doors = $('#doors').val();
          var exteriorColor = $('#exteriorColor').val();
          var interiorColor = $('#interiorColor').val();
          var price = $('#price').val();
          var offer = $('#offer').val();
          var mileage = $('#mileage').val();
          var details = tinyMCE.get('details').getContent();;
          var stock = $('#stock').val();
          var status = $('#workStatus').val();
          var photos = "";
          $('.thumbnail').each(function(i) {
            photos += $('.thumbnail').eq(i).attr('src') + ",";
          });
					if(offer == "") {
						offer = price;
					}
          photos = photos.substring(0, photos.length - 1);

          $.post('addVehicle.php', {
            vin: vin,
            make: make,
            model: model,
            trim: trim,
            year: year,
            bodyStyle: bodyStyle,
            engine: engine,
            transmission: transmission,
            driveType: driveType,
            fuelType: fuelType,
            fuelCity: fuelCity,
            fuelHighway: fuelHighway,
            doors: doors,
            exteriorColor: exteriorColor,
            interiorColor: interiorColor,
            details: details,
            stock: stock,
            status: status,
            price: price,
            offer: offer,
            mileage: mileage,
            photos: photos

          }, function(data) {
            if(data == "success") {
              submitted = true;
              $('.section').html('<h1 style="color: #1AB188;" class="center-txt"><i class="fa fa-check-circle-o fa-3x"></i></h1><h2 class="font-grey center-txt">Car has been successfully added to the inventory. You can view the car by going to the<a href="editInventory.php" style="color: #21a1e1; font-weight: 300;"> Car Inventory</a>!</h2>');
            }
          })

        })

      })();
    </script>
  </body>
</html>
