<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 

	if (!isset($_SESSION["company_registration_number"])) {
		header("Location:providerdashboard-ea.php");
	}

	if (isset($_GET["ad-no"]) && $_SESSION["company_registration_number"] == $_GET["crn"]) {
		
		$ad_number = mysqli_real_escape_string($connection , $_GET["ad-no"]);

		//delte add

		$query = "DELETE FROM job_ad WHERE ad_no='{$_GET["ad-no"]}' AND company_registration_number = '{$_SESSION["company_registration_number"] }'";

		$result=mysqli_query($connection,$query);

		if ($result) {
			header("Location:providerdashboard-ea.php?msg=ad_deleted");
		}
		else{
			header("Location:providerdashboard-ea.php?err");
		}
	}
	else{
		header("Location:providerdashboard-ea.php");
	}

 ?>