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
				$expire_time=$ad_details["expire_time"];
				$is_expire=$ad_details["is_expire"];
				$description=$ad_details["description"];
				
				
				$company_query ="SELECT company_phone_number,description,facebook,twitter,linked_in,address,company_website FROM provider WHERE company_registration_number ='{$ad_details["company_registration_number"]}' AND is_deleted=0 LIMIT 1" ;
				
				$result=mysqli_query($connection,$company_query);
				
				if ($result) {
					
					$result=mysqli_fetch_assoc($result); 
					
					$address = $result["address"];
					$caompany_description = $result["description"];
					$facebook = $result["facebook"];
					$twitter = $result["twitter"];
					$linked_in = $result["linked_in"];
					$curl = $result["company_website"];
					$phone_number = $result["company_phone_number"];
				}
				else{
					printf(mysqli_error($connection));
					header("location:seekerdashboard.php?err=query-error");
				}
				
			}
			else{
				header("location:seekerdashboard.php?err=add deleted");
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
				echo  "<a><button id='button' class=\"cancel\" name='cancel' onclick=\"return confirm('Remove Job Application?')\"><i class='far fa-meh'></i>Cancel</button></a>";
				echo "</form>";
			}
			else{

				echo  "<a href=\"seekerdashboard-apply-ad.php?ad-no={$ad_no}&crn={$company_registration_number}&p={$page_number}\" ><button id='button' onclick=\"return confirm('Apply For A Job?')\"><i class='far fa-paper-plane'></i>Apply</button></a>";
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
	<link rel="shortcut icon" type="image/jpg" href="imj/icon/fav.png"/>
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
		<div class="job_row">
			<div class="job_column">
				<div class="job_pic">
					<?php echo provider_profile_picture($ad_details["company_registration_number"],$connection); ?>
				</div>
			</div>
			<div class="job_column">
				<div class="jobc_row">
					<h2><?php echo $job_title; ?></h2>
				</div>
				<div class="jobc_row">
					<h3><i class="fas fa-map-marker-alt"></i><?php echo $location; ?></h3>
					<h3><i class="fas fa-phone-alt"></i><?php echo $phone_number ?></h3>	
					<h3><i class="fas fa-briefcase"></i><?php echo $job_type; ?></h3>	
				</div>
			</div>
			<div class="job_column">
				<div class="apply_but">
				<?php apply_cancel_button($connection,$_SESSION["seeker_id"],$ad_no,$ad_details["company_registration_number"],$page_number); ?>
					<p><i class="fas fa-history"></i><?php echo facebook_time_ago($ad_details["ad_time"]); ?></p>
				</div>
			</div>
		</div>
		<div class="job_main_content">
			<div class="job_details">
				<div class="q_job_details">
					<div class="sect">
						<i class="fas fa-list-ul"></i>
						<div class="sect_con">
							<h3>category</h3>
							<h4><?php echo $job_category; ?></h4>
						</div>
					</div>
					<div class="sect">
						<i class="fas fa-coins"></i>
						<div class="sect_con">
							<h3>Salary</h3>
							<h4>RS: <?php echo $monthly_salary; ?></h4>
						</div>
					</div>
					<div class="sect">
						<i class="fas fa-venus-mars"></i>
						<div class="sect_con">
							<h3>Gender</h3>
							<h4><?php echo $gender; ?></h4>
						</div>	
					</div>
					<div class="sect">
						<i class="fas fa-male"></i>
						<div class="sect_con">
							<h3>Age</h3>
							<h4><?php echo $minimum_age . " > " . $maximum_age; ?></h4>
						</div>
					</div>
					<div class="sect">
						<i class="fas fa-graduation-cap"></i>
						<div class="sect_con">
							<h3>Minimum Years Of Experiencs:</h3>
							<h4><?php echo $experience; ?></h4>
						</div>
					</div>
					<div class="sect">
						<i class="fas fa-graduation-cap"></i>
						<div class="sect_con">
							<h3>Qualification</h3>
							<h4><?php echo $qulification_level; ?></h4>
						</div>
					</div>
				</div>
				<div class="overview">
					<?php if(!empty($description)){
						echo '<h3>Job Description</h3>';
						echo '<p>'.$description.'</p>';
					} ?>
				</div>
				<div class="comdis">
					<?php if(!empty($caompany_description)){
						echo '<h3>About Company</h3>';
						echo '<p>'.$caompany_description.'</p>';
					} ?>
				</div>
			</div>
			<div class="company_details">
				<div class="extime">
					<i class="far fa-clock"></i>
					<h3 id="replace">33 Days</h3>
					<input type="hidden" id="date" value="<?php echo $expire_time ?>">
					<input type="hidden" id="is_expire" value="<?php echo $is_expire ?>">
				</div>
				<div class="company_conte">
					<div class="csect"><h3><i class="fas fa-signature"></i><?php echo $company_name; ?></h3></div>
					<div class="csect"><h3><i class="far fa-envelope"></i><?php echo $email; ?></h3></div>
					<?php
						//checking address field is empty
						if(!empty($address)){
							echo '<div class="csect"><h3><i class="fas fa-map-pin"></i>'.$address.'</h3></div>';
						}
					?>
					<div class="csect">
						<!--checking social links are empty or not -->
						<?php
							if(!empty($curl)){
								echo '<a href="http://'.$curl.' title="Company URL"><i class="fas fa-link"></i></a>';
							}
						?>
						<?php
							if(!empty($facebook)){
								echo '<a href="http://www.facebook.com/'.$facebook.'" title="Company Facebook Page"><i class="fab fa-facebook-f"></i></a>';
							}
						?>
						<?php
							if(!empty($twitter)){
								echo '<a href="http://www.twitter.com/'.$twitter.'" title="Company Twitter Account"><i class="fab fa-twitter"></i></a>';
							}
						?>
						<?php
							if(!empty($linked_in)){
								echo '<a href="http://www.linkedin.com/'.$linked_in.'" title="Company LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>';
							}
						?>
					</div>
				</div>
				
			</div>
		</div>
	
	</div>

<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script	script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5f86a661f4413dde"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
	let addate = document.querySelectorAll('#date');
	let expiresection = document.querySelector('#replace');
	
	function caldate(){
		
		let currentdate = Math.abs((new Date().getTime()/1000).toFixed(0));
		for(let i =0;i<addate.length;i++){
			
			let date = addate[i].value;
			let futurevalue = Math.abs((new Date(date).getTime()/1000).toFixed(0));

			let diifdate = futurevalue - currentdate;

			let days = Math.floor(diifdate/86400);
			let hours = Math.floor(diifdate/3600)%24;
			let minutes = Math.floor(diifdate/60)%60;
			let seconds = diifdate%60;

			if(hours<10){
				hours = "0"+hours;
			}
			if(minutes<10){
				minutes = "0"+minutes;
			}
			if(seconds<10){
				seconds = "0"+seconds;
			}

			if(diifdate>0){
				expiresection.innerHTML = days+" Days And "+hours+":"+minutes+":"+seconds;
			}
			else{
				expiresection.innerHTML ="Ad Expired";
				let is_expire = document.querySelector('#is_expire').value;
				
				if(is_expire==0){
					let ad_no = <?php echo $ad_no ?>;
					$.post('ajax/expire_ad.php',{
						ad_no: ad_no
					});
				}

				//redirecting to seeker dashboard
				window.location.href = "seekerdashboard.php?ad=expired";
			}
		}
	}

	
	setInterval(() => {
		caldate();
	}, 1000);

</script>

</body>
<?php mysqli_close($connection); ?>
</html>