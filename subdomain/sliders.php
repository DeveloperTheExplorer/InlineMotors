<?php
	include_once("../php_includes/check_login_status.php");

  if(isset($_POST['photos'])) {
    $photos = $_POST['photos'];

    $sql = "UPDATE slider SET images='$photos', date=now() WHERE id=1 LIMIT 1";
    $query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));

    echo "success";
    exit();
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
    $images .= '<div class="relative inline-blk"><i class="absolute xs-pad closePop sm-right removePhoto pointer">x</i><img src="'.$photos[$i].'" alt="" class="sm-pad sm-mar-bottom thumbnail sm-mar-right border-1 border-subtle" height="100px"></div>';
    $i = $i - 1;
  } while ( $i >= 0);
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
  </head>
  <body class="controlPanel" data-pageName="frontSliders">

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
					selector: "#autoreply"
				});
			});
		</script>

    <?php include_once('nav.php'); ?>
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


    <main class="mainPanel">
			<div class="row">

				<div class="column">
					<h3 class="no-mar-bottom">Add/Delete Images To Front Page Slider</h3>
					<div class="bg-white">
						<div class="section row" id="images">
              <div class="col-sm-12 md-mar-bottom">
                <h3 class="no-mar-bottom width-90 center-blk">Photos</h3>
                <div class="width-90 photos border-2 border-subtle md-pad center-blk">
                  <?php echo $images; ?>
                </div>
              </div>

                <div class="col-sm-12 md-mar-bottom">
                  <div class="uploadArea width-90 lg-txt sm-mar-bottom" id="uploadPDF">
                    Drag Photos In Proper Order Inside This Box.
                  </div>
                </div>

                <div class="col-sm-6">
                  <label class="blk sm-mar-left opacity-0"> a</label>
                  <input type="submit" name="vinDecoder" id="saveImages" value="Save Images" class="btn btn-inverse-google-blue lg-btn lg-pad-left lg-pad-right sm-mar-left sm-mar-bottom width-90">
                </div>
						</div>
					</div>
				</div>


				<div class="column lg-mar-bottom">
					<h3 class="no-mar-bottom">Help</h3>
					<div class="bg-white">
						<div class="section row">
							<div class="col-xs-12">
								<h2>Control Panel</h2>
								<ul class="ul-md">
									<li><u>Link to tawk.to (LiveChat).</u><strong> NOTE: If you have changed the email or password from default, they will not update on this website.</strong></li>
									<li><u>Social medai links:</u> You can update or change your social media links for your website. If you do not have an account in one of the specified social media websites, simply leave them <strong>blank</strong>.</li>
									<li><u>Email AutoReply Message:</u> You can type out a message the same way you would on a Word Document. When you save, the message that you typed inside the box will be stored on the database and will be sent to a customer as an automated message whenever they contact you.</li>
									<li><u>Photos:</u> This is where you can upload any photos you'd like. If you'd like to get the link address of the image, simply right-click on the image, and choose "<strong>Copy image address</strong>".In order to <strong> delete</strong> any of them, simply click on the little "x" on the top right.</li>
									<li><u>Documents:</u> This is where you can upload any PDF documents. In order to <strong> delete</strong> any of them, simply click on the little "x" on the top right.</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

			</div>
    </main>

		<script type="text/javascript">
			(function() {
				var pageName = $('body').attr('data-pageName');
		    $('.'+pageName).addClass('active');

				$('a').on('click', function() {
					if($(this).attr('href') == "#") {
						return false;
					}
				})

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
              thisElement.parent().remove();
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

        data = '';
        $('#saveImages').on('click', function() {
          photos = " ";
          $('.thumbnail').each(function(i) {
            photos += $('.thumbnail').eq(i).attr('src') + ",";
          });
          photos = photos.substring(0, photos.length - 1);

          $.post('sliders.php', {
            photos: photos
          }, function(data) {
            if(data == "success") {
              $('#images').html('<h1 style="color: #1AB188;" class="center-txt"><i class="fa fa-check-circle-o fa-3x"></i></h1><h2 class="font-grey center-txt">Your dealership information has been successfully updated.</h2>');
            } else {
              console.log(data);
              alert("Sorry something went wrong, please contact your developer!");
            }
          })
        })

			})();
		</script>
  </body>
</html>
