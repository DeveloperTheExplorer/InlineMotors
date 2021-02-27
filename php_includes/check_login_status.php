<?php
if (isset($_SESSION['email'])) {
	session_start();
}
include_once("db_conx.php");
// Files that inculde this file at the very top would NOT require
// connection to database or session_start(), be careful.
// Initialize some vars
$user_ok = false;
$log_id = "";
$log_email = "";
$log_pass = "";
// User Verify function
function evalLoggedUser($conx,$id,$e,$p){
	$sql = "SELECT ip FROM users WHERE id='$id' AND email='$e' AND pass='$p' LIMIT 1";
  $query = mysqli_query($conx, $sql);
  $numrows = mysqli_num_rows($query);
	if($numrows > 0){
		return true;
	}
}
if(isset($_SESSION["userid"]) && isset($_SESSION["email"]) && isset($_SESSION["pass"])) {
	$log_id = preg_replace('#[^0-9]#', '', $_SESSION['userid']);
	$log_email = preg_replace('#[^a-z0-9]#i', '', $_SESSION['email']);
	$log_pass = preg_replace('#[^a-z0-9]#i', '', $_SESSION['pass']);
	// Verify the user
	$user_ok = evalLoggedUser($db_conx,$log_id,$log_email,$log_pass);
} else if(isset($_COOKIE["id"]) && isset($_COOKIE["email"]) && isset($_COOKIE["pass"])){
	$_SESSION['userid'] = preg_replace('#[^0-9]#', '', $_COOKIE['id']);
  $_SESSION['email'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['email']);
  $_SESSION['pass'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['pass']);
	$log_id = $_SESSION['userid'];
	$log_email = $_SESSION['email'];
	$log_pass = $_SESSION['pass'];
	// Verify the user
	$user_ok = evalLoggedUser($db_conx,$log_id,$log_email,$log_pass);
	if($user_ok == true){
		// Update their lastlogin datetime field
		$sql = "UPDATE users SET lastlogin=now() WHERE id='$log_id' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
	}
}
?>
