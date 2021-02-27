<?php

  session_start();
  // Set Session data to an empty array
  $_SESSION = array();
  // Expire their cookie files
  if(isset($_COOKIE["id"]) && isset($_COOKIE["email"]) && isset($_COOKIE["pass"])) {
    setcookie("id", "", time()-3600);
    setcookie("email", "", time()-3600);
    setcookie("pass", "", time()-3600);
  }
  // Destroy the session variables
  session_destroy();

  if(isset($_SESSION['email'])){
  	header("location: message.php?msg=Error:_Logout_Failed");
  } else {
  	header("location: index.php");
  	exit();
  }
?>
