<?php ob_start(); ?>
<?php require_once("../inc/connection.php"); ?>

<?php  

	if (!isset($_GET["ad_no"]) || $_GET["ad_no"]=="" || !isset($_GET["p"]) || $_GET["p"]=="") {
		header("location:../index.php");
	}
	else{
		$page_number = $_GET["p"];

		$provider_delete_query ="UPDATE job_ad SET is_delete=1 WHERE ad_no ='{$_GET["ad_no"]}' LIMIT 1";

		$provider_delete_result = mysqli_query($connection,$provider_delete_query);

		if ($provider_delete_result) {
			header("location:index.php?p=" . $page_number);
		}
		else{
			header("location:../index.php?err=admin-query-error");
		}

	}


?>