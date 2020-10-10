<?php require_once("inc/connection.php"); ?>
<?php session_start(); ?>
<?php ob_start(); ?>
<?php 

	if (!isset($_SESSION["seeker_id"])) {
		header("location:index.php");
	}

	$seeker_username = $_SESSION["username"];

	if (!isset($_GET["p"]) || $_GET["p"]=="") {
		header("location:seekerdashboard.php?err=error");
	}

	if (!isset($_GET["ad-no"]) || $_GET["ad-no"]=="") {
		header("location:seekerdashboard.php?err=error");
	}
	else{
		$ad_no =$_GET["ad-no"];
		$page_number=$_GET["p"];

		$job_query="SELECT * FROM job_ad WHERE ad_no='{$ad_no}' AND is_delete = 0 LIMIT 1";

		$result = mysqli_query($connection,$job_query);

		if ($result) {
			if (mysqli_num_rows($result)==1) {
				
				$ad_details = mysqli_fetch_assoc($result);

				$job_title=$ad_details["job_title"];
				$company_name=$ad_details["company_name"];
				$job_type=$ad_details["job_type"];
				$location=$ad_details["location"];
				$job_category=$ad_details["job_category"];
				$monthly_salary=$ad_details["monthly_salary"];
				$company_url=$ad_details["company_url"];
				$email=$ad_details["email"];
				$phone_number=$ad_details["phone_number"];
				$gender=$ad_details["gender"];
				$maximum_age=$ad_details["maximum_age"];
				$minimum_age=$ad_details["minimum_age"];
				$qulification_level=$ad_details["qulification_level"];
				$experience=$ad_details["minimum_qualification"];
				$description=$ad_details["description"];


				$company_query ="SELECT description,facebook,twitter,linked_in FROM provider WHERE company_registration_number ='{$ad_details["company_registration_number"]}' AND is_deleted=0 LIMIT 1" ;

				$result=mysqli_query($connection,$company_query);

				if ($result) {
					
					$result=mysqli_fetch_assoc($result); 

					$caompany_description = $result["description"];
					$facebook = $result["facebook"];
					$twitter = $result["twitter"];
					$linked_in = $result["linked_in"];
				}
				else{
					printf(mysqli_error($connection));
					header("location:seekerdashboard.php?err=query-error");
				}
				
			}
		}
		else{
			printf(mysqli_error($connection));
			header("location:seekerdashboard.php?err=query-error");
		}
	}

	//time ago function
	 	date_default_timezone_set('Asia/colombo'); 
	 	 function facebook_time_ago($timestamp){  
      $time_ago = strtotime($timestamp);
      $current_time = time();  
      $time_difference = $current_time - $time_ago;  
      $seconds = $time_difference;  
      $minutes      = round($seconds / 60 );           // value 60 is seconds  
      $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
      $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
      $weeks          = round($seconds / 604800);          // 7*24*60*60;  
      $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
      $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
      if($seconds <= 60)  
      {  
     return "Just Now";  
   }  
      else if($minutes <=60)  
      {  
     if($minutes==1)  
           {  
       return "one minute ago";  
     }  
     else  
           {  
       return "$minutes minutes ago";  
     }  
   }  
      else if($hours <=24)  
      {  
     if($hours==1)  
           {  
       return "an hour ago";  
     }  
           else  
           {  
       return "$hours hrs ago";  
     }  
   }  
      else if($days <= 7)  
      {  
     if($days==1)  
           {  
       return "yesterday";  
     }  
           else  
           {  
       return "$days days ago";  
     }  
   }  
      else if($weeks <= 4.3) //4.3 == 52/12  
      {  
     if($weeks==1)  
           {  
       return "a week ago";  
     }  
           else  
           {  
       return "$weeks weeks ago";  
     }  
   }  
       else if($months <=12)  
      {  
     if($months==1)  
           {  
       return "a month ago";  
     }  
           else  
           {  
       return "$months months ago";  
     }  
   }  
      else  
      {  
     if($years==1)  
           {  
       return "one year ago";  
     }  
           else  
           {  
       return "$years years ago";  
     }  
   }
  } 


  //function for get provider profile pic

 function provider_profile_picture($crm,$connection){
 	
 	$company_registration_number=$crm;
 	$con=$connection;

 	$query_for_get_pp = "SELECT is_image FROM provider WHERE company_registration_number='{$company_registration_number}'";

 	$pp_result = mysqli_query($con,$query_for_get_pp);

 	if ($pp_result) {
 		
 		$is_image_pp=mysqli_fetch_assoc($pp_result);

 		if ($is_image_pp["is_image"]==1) {
 			return "<img src=\"imj/profile_pictures/providers/" . $company_registration_number . ".jpg\"> ";
 		}
 		else{
 			return "<img src=\"imj/profile_pictures/default.jpg\">";
 		}
 	}
 	else{
 		echo "string";
 	}
 } 
//function for appliy and cancel button

 	function apply_cancel_button($con,$seeker_id,$ad_no,$company_registration_number,$page_number){

		$connection = $con;

		$button_query = "SELECT * FROM job_apply WHERE seeker_id = '{$seeker_id}' AND ad_no='{$ad_no}' LIMIT 1";

		$button_result = mysqli_query($connection,$button_query);

		if ($button_result) {
			if (mysqli_num_rows($button_result)==1) {
				echo "<form action=\"seekerdashboard-vjob.php?ad-no=$ad_no&p=$page_number\" method=\"POST\" >";
				echo "<input type=\"text\" name=\"ad_no\" value=\"{$ad_no}\" hidden>";
				echo  "<a><button id='button' class=\"cancel\" name=\"cancel\">Cancel</button></a>";
				echo "</form>";
			}
			else{

				echo  "<a href=\"seekerdashboard-apply-ad.php?ad-no={$ad_no}&crn={$company_registration_number}&p={$page_number}\" ><button id='button'>apply</button></a>";
			}
		}
		else{
			printf(mysqli_error($connection));
		}
 	}
?>
<?php //for cancel button 

	if (isset($_POST["cancel"])) {
		
		$ad_no =$_POST["ad_no"];

		$cancel_query = "DELETE FROM job_apply WHERE seeker_id = '{$_SESSION["seeker_id"]}' AND ad_no = {$ad_no} ";

		$cancel_result =mysqli_query($connection,$cancel_query);


	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Seeker DashBoard</title>
	<link rel="stylesheet" href="css/seekerdashboard.css">
	<link rel="stylesheet" href="css/seekerdashboard-vjob.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/seekerdashboardheader.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/seekerdashboard-vjob-media.css"><!--media query-->

</head>
<body>
	
	<header>
		<div class="main">
			<div class="row">
				<div class="column">
					<div class="seeker-pic">
						<?php 

							if ($_SESSION["is_image"]==0) {
								echo "<img src=\"imj/profile_pictures/default.jpg\">";
							}
							else{
								echo "<img src=\"imj/profile_pictures/seekers/" . $_SESSION["seeker_id"] . ".jpg\">";
							}

						 ?>
					</div>
				</div>
				<div class="column">
					<div class="seeker-name">
						<h2><?php echo $seeker_username; ?></h2>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section>
		<div class="navi">
			<ul>
				<li><i class="fas fa-caret-down"></i><a href="seekerdashboard.php">Dashboard</a></li>
				<li><i class="fas fa-caret-down"></i><a href="seekerdashboard-ema.php">Edit My Account</a></li>
				<li><i class="fas fa-caret-down"></i><a href="seekerdashboard-mycv.php">My CV</a></li>
				<li class="drop-down"><i class="fas fa-caret-down"></i>Account Settings
						<div class="drop-down-content">
										<a href="seekerdashboard-cp.php">Change Password</a>
										<a href="seekerdashboard-ecv.php">Edit My CV</a>
										<a href="seekerdashboard-dma.php">Delete My Account</a>
							</div>
				</li>			
				<li><i class="fas fa-power-off"></i><a href="logout.php">Log Out</a></li>
			</ul>
		</div>
	</section>

	<div class="job-content">

		<div class="main-details">
			<div class="job-main-details">
				<div class="j-title">
					<h1><?php echo $job_title; ?></h1>
				</div>
				<div class="j-details">
					<h3><i class="fas fa-home"></i><?php echo $company_name; ?></h3>
					<h3><i class="fas fa-briefcase"></i><?php echo $job_type; ?></h3>
					<h3><i class="fas fa-map-marker-alt"></i><?php echo $location; ?></h3>
					<h3><i class="fas fa-tag"></i><?php echo $job_category; ?></h3>
					<h3><i class="far fa-clock"></i><?php echo facebook_time_ago($ad_details["ad_time"]); ?></h3>
				</div>
			</div>
		</div>

		<div class="ad-details">
			<div class="row1">
				<div class="column">
					<div class="company-logo">
						<div class="pic">
							<?php echo provider_profile_picture($ad_details["company_registration_number"],$connection); ?>
						</div>
					</div>
				</div>
				<div class="column">
					<div class="row">
						<h2><i class="fas fa-tag"></i>catogery</h2>
						<h3><?php echo $job_category; ?></h3>
					</div>
					<div class="row">
						<h2><i class="fas fa-coins"></i>salary</h2>
						<h3>RS: <?php echo $monthly_salary; ?></h3>
					</div>
				</div>
				<div class="column">
					<div class="row">
						<h2>company Details</h2>
						<h3><a href="http://<?php echo $company_url; ?>" target="_blanck"><?php echo $company_name; ?></a></h3>
						<h3><a><?php echo $email; ?></a></h3>
						<a href="http://www.facebook.com/<?php echo $facebook; ?>" target="_blanck"><i class="fab fa-facebook"></i></a>
						<a href="http://www.twitter.com/<?php echo $twitter; ?>" target="_blanck"><i class="fab fa-twitter"></i></a>
						<a href="http://www.linkedin.com/<?php echo $linked_in; ?>" target="_blanck"><i class="fab fa-linkedin"></i></a>
					</div>
					<hr class="hr">
					<div class="row">
						<?php apply_cancel_button($connection,$_SESSION["seeker_id"],$ad_no,$ad_details["company_registration_number"],$page_number); ?>
					</div>
				</div>
			</div>
			<div class="row2">
					<div class="job-overview">
						<h2>overview</h2>
						<p><?php echo $description; ?></p>
					</div>
			</div>
			<div class="row3">
					<div class="other-details">
						<div class="column">
							<h2>gender:</h2>
							<h2>age:</h2>
							<h2>minimum qualification:</h2>
							<h2>minimum years of experiencs:</h2>
						</div>
						<div class="column">
							<h2><?php echo $gender; ?></h2>
							<h2><?php echo $minimum_age . " > " . $maximum_age; ?></h2>
							<h2>Need <?php echo $qulification_level; ?></h2>
							<h2><?php echo $experience; ?></h2>
						</div>
					</div>
			</div>
			<div class="row4">
				<div class="about-company">
					<h2>about company</h2>

					<p><?php echo $caompany_description; ?></p>

				</div>
			</div>
		</div><!--add-list-->
	</div>

<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>
</body>
<?php mysqli_close($connection); ?>
</html>