<?php
header('Content-Type: application/json');
include_once("../php_includes/check_login_status.php");

$uploaded = array();

if(!empty($_FILES['files']['name'][0])) {
  foreach ($_FILES['files']['name'] as $position => $name) {
    $kaboom = explode(".", $_FILES['files']['name'][$position]);
    $fileExt = end($kaboom);
    if($fileExt == 'pdf') {
      if(move_uploaded_file($_FILES['files']['tmp_name'][$position], '../documents/' . $name)) {
        $sql = "INSERT INTO documents(name, extention, date)
      			VALUES('$name','$fileExt',now())";
      	$query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));
      	$id = mysqli_insert_id($db_conx);

        $uploaded[] = array(
          'name' => $name,
          'file' => '../documents/' . $name
        );
      }
    } else if(preg_match("/.(gif|jpg|png|jpeg|tif|tiff)$/i", $_FILES['files']['name'][$position])) {
      if(move_uploaded_file($_FILES['files']['tmp_name'][$position], '../photos/' . $name)) {
        $sql = "INSERT INTO photos(name, extention, date)
      			VALUES('$name','$fileExt',now())";
      	$query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));
      	$id = mysqli_insert_id($db_conx);

        $uploaded[] = array(
          'name' => $name,
          'file' => '../photos/' . $name
        );
      }
    }
  }
}

echo json_encode($uploaded);
?>
