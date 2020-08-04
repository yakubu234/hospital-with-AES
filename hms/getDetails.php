<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
include('AEScrypto.php');
if (isset($_POST['decrypt'])) {
	# code...
	echo $id = $_POST['id'];
	echo $emailb = $_POST['email'];
	echo $keyb = $_POST['key'];
	$sql = "SELECT * FROM deckey ORDER BY id DESC LIMIT 1";
	$result = mysqli_query($con, $sql);

	if (mysqli_num_rows($result) > 0) {
	  // output data of each row
	  while($row = mysqli_fetch_assoc($result)) {
	   $deckey =  $row["deckey"];
	   $email =  $row["email"];
	  }
	  if ($email == $emailb && $keyb == $deckey) {
	  	$_SESSION['pid'] = $id;
	  	header("Location: view-medics-history.php");	  }
	 else {
	  echo "0 results";
	}
	}else{
		echo "error";
	}
}
?>