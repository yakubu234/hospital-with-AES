<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
include('AEScrypto.php');
check_login();
if(isset($_POST['submit']))
  {
    
    $vid=$_GET['viewid'];
    $bp=$_POST['bp'];
    $bs=$_POST['bs'];
    $weight=$_POST['weight'];
    $temp=$_POST['temp'];
   $pres=$_POST['pres'];
   
 
      $query.=mysqli_query($con, "insert   tblmedicalhistory(PatientID,BloodPressure,BloodSugar,Weight,Temperature,MedicalPres)value('$vid','$bp','$bs','$weight','$temp','$pres')");
    if ($query) {
    echo '<script>alert("Medicle history has been added.")</script>';
    echo "<script>window.location.href ='manage-patient.php'</script>";
  }
  else
    {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Users | Medical History</title>
		
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
		<style>
			
				#modalOverlay {
						position: absolute;
						top: 0;
						left: 0;
						background: rgba(0, 0, 0, 0.1);
						z-index: 99999;
						height: 100%;
						width: 100%;
				}
				.modalPopup {
						position: absolute;
						top: 50%;
						left: 50%;
						transform: translate(-50%, -50%);
						background: #fff;
						width: 50%;
						padding: 0 0 30px;
						-webkit-box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
						-moz-box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
						box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
				}
				.modalContent {padding: 0 2em;}

				.modalContent h1 {
				  margin-bottom: .2em;
				  font-size: 26px;
				  text-transform: capitalize;
				}
				.modalContent p {margin: .75em 0 1.5em;}

		</style>
	</head>
	<body>
		<div id="app">		
<?php include('include/sidebar.php');?>
<div class="app-content">
<?php include('include/header.php');?>
<div class="main-content" >
	<!-- this is the modal -->

	<!-- this is the modal end -->
<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
<div class="col-sm-8">
<h1 class="mainTitle">Users | Medical History</h1>
</div>
<ol class="breadcrumb">
<li>
<span>Users</span>
</li>
<li class="active">
<span>Medical History</span>
</li>
</ol>
</div>
</section>
<div class="container-fluid container-fullw bg-white">
<div class="row">
<div class="col-md-12">
<h5 class="over-title margin-bottom-15">Users <span class="text-bold">Medical History</span></h5>
<?php
                               $vid=$_SESSION['pid'];
                               $ret=mysqli_query($con,"select * from tblpatient where ID='$vid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {
echo $usertab = '<table border="1" class="table table-bordered">
 <tr align="center">
<td colspan="4" style="font-size:20px;color:blue">
 Patient Details</td></tr>

    <tr>
    <th scope>Patient Name</th>
    <td>'. $row["PatientName"].'</td>
    <th scope>Patient Email</th>
    <td>'. $row["PatientEmail"].'</td>
  </tr>
  <tr>
    <th scope>Patient Mobile Number</th>
    <td>'.$row["PatientContno"].'</td>
    <th>Patient Address</th>
    <td>'.$row["PatientAdd"].'</td>
  </tr>
    <tr>
    <th>Patient Gender</th>
    <td>'. $row["PatientGender"].'</td>
    <th>Patient Age</th>
    <td>'. $row["PatientAge"].'</td>
  </tr>
  <tr>
    
    <th>Patient Medical History(if any)</th>
    <td>'.$row["PatientMedhis"].'</td>
     <th>Patient Reg Date</th>
    <td>'. $row["CreationDate"].'</td>
  </tr>';
  }?>
</table>
<?php  

$ret=mysqli_query($con,"select * from tblmedicalhistory  where PatientID='$vid'");



 ?>
<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
  <tr align="center">
   <th colspan="8" >Medical History</th> 
  </tr>
  <tr>
    <th>#</th>
<th>Blood Pressure</th>
<th>Weight</th>
<th>Blood Sugar</th>
<th>Body Temprature</th>
<th>Medical Prescription</th>
<th>Visit Date</th>
</tr>
<?php  
while ($row=mysqli_fetch_array($ret)) {
echo $usertab2 = "<tr>
  <td>".$cnt."</td>
  <td>".$row['BloodPressure']."</td>
  <td>".$row['Weight']."</td>
  <td>".$row['BloodSugar']."</td> 
  <td>".$row['Temperature']."</td>
  <td>".$row['MedicalPres']."</td>
  <td>".$row['CreationDate']."</td> 
</tr>";
$cnt=$cnt+1;} ?>
</table>
                          
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
			<!-- start: FOOTER -->
	<?php include('include/footer.php');?>
			<!-- end: FOOTER -->
		
			<!-- start: SETTINGS -->
	<?php include('include/setting.php');?>
			
			<!-- end: SETTINGS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
