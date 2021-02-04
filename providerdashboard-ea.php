<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 
	
	$company_name = $_SESSION["company_name"];
	$company_registration_number =$_SESSION["company_registration_number"];

	if (!isset($_SESSION["company_registration_number"])) {
		header("location:index.php");
	}

 ?>

 <?php 

 	$query = "SELECT count(ad_no) as total_rows FROM job_ad WHERE is_delete != 1 AND company_registration_number = '{$company_registration_number}'";

 	$result_set=mysqli_query($connection,$query);

 	$result=mysqli_fetch_assoc($result_set);

 	$total_rows = $result["total_rows"];

 	$rows_per_page=6;

 	if (isset($_GET['p'])) {
 		$page_number=$_GET['p'];
 	}
 	else{
 		$page_number=1;
 	}

 	$start=($page_number-1) * $rows_per_page;

 	$query="SELECT * FROM job_ad WHERE company_registration_number= '{$company_registration_number}' AND is_delete=0 ORDER BY ad_no DESC LIMIT {$start},{$rows_per_page}";
 	$result_set=mysqli_query($connection,$query);

 	/*while ($add = mysqli_fetch_assoc($result_set)) {
 		echo $add["ad_no"] . " " . $add["job_title"] . "<br>";
 	}*/

 	//first page number
 	$first="<a href=\"providerdashboard-ea.php?p=1\">FIRST </a>";

 	//last page number
 	$last_page_no=ceil($total_rows / $rows_per_page);
 	$last="<a href=\"providerdashboard-ea.php?p={$last_page_no}\">last</a>";

 	//next page number
 	if ($page_number >= $last_page_no) {
 		$next="<a>Next</a>";
 		$last="<a>Last</a>";
 	}
 	else{
 		$next_page_number=$page_number+1;
 		$next="<a href=\"providerdashboard-ea.php?p={$next_page_number}\">Next</a>";
 	}

 	//last page number
 	if ($page_number == 1) {
 		$previous="<a>previous</a>";
 		$first="<a>first</a>";
 	}
 	else{
 		$previous_page_number=$page_number-1;
 		$previous="<a href=\"providerdashboard-ea.php?p={$previous_page_number}\">Previous</a>";
 	}

 	//asign page number to list

 		$page_nav = "<ul>";
	 	$page_nav .= "<li>" . $first . "</li>";
	 	$page_nav .= "<li>" . $previous . "</li>";
	 	$page_nav .="<li>" . $page_number . " Of " . $last_page_no . "</li>";
	 	$page_nav .= "<li>" . $next . "</li>";
	 	$page_nav .= "<li>" . $last . "</li>";
	 	$page_nav .= "</ul>";

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

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Company DashBoard</title>
	<link rel="shortcut icon" type="image/jpg" href="imj/icon/fav.png"/>
	<link rel="stylesheet" href="css/provider_dashboard.css">
	<link rel="stylesheet" href="css/provider_dashboard-ea.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/providerDashboard-header-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/providerDashboard-main-media.css"><!-- media query -->
</head>
<body>
	
	<header>
		<div class="main">
			<div class="row">
				<div class="column">
					<div class="seeker-pic">
						<?php 

							if ($_SESSION["is_image_pro"]==1) {
								echo "<img src=\"imj/profile_pictures/providers/" . $company_registration_number . ".jpg\"> ";
							}
							else{
								echo "<img src=\"imj/profile_pictures/default.jpg\">";
							}

						 ?>
					</div>
					<div class="upload-pro-pic">
						<a href="providerdashboard-ema.php"><button><i class="fas fa-pencil-alt"></i></button></a>
					</div>
				</div>
				<div class="column">
					<div class="seeker-name">
						<h2><?php echo $company_name; ?></h2>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section>
		<div class="navi">
			<ul>
				<li class="active"><i class="fas fa-caret-down"></i><a href="providerdashboard-ea.php">My Advertisement</a></li>
				<li><i class="fas fa-caret-down"></i><a href="providerdashboard-aad.php">Add Advertisement</a></li>
				<li><i class="fas fa-caret-down"></i><a href="providerdashboard-vcvl.php">View CV list</a></li>
				<li class="drop-down"><i class="fas fa-caret-down"></i>Account Settings
						<div class="drop-down-content">
										<a href="providerdashboard-ema.php">Edit My Account</a>
										<a href="providerdashboard-cmp.php">Change Password</a>
										<a href="providerdashboard-dma.php">Delete My Account</a>
							</div>
				</li>			
				<li><i class="fas fa-power-off"></i><a href="logout.php">Log Out</a></li>
			</ul>
		</div>
	</section>

	<div class="section">
				<?php
					if(mysqli_num_rows($result_set) > 0){
						echo "<div class='view-add'>";
							echo "<div class='row2'>";

							while ($add = mysqli_fetch_assoc($result_set)) {

									 echo "<div class='column'>";
											echo "<div class='active'>";
												if($add['active']==0){
													$color ='red';
													$title='Inactive Add';
												}
												else{
													$color = '#16c516';
													$title='Active Add';
												}
												echo "<div class='act-op' style='background-color:".$color."' title='".$title."'>";
												echo "</div>";
											echo "</div>";
		 									echo "<div class='option'>";
		 										echo "<div class='dropdown'>";
		 											echo "<button class='dropbtn'><i class='fas fa-ellipsis-v'></i></button>";
		 												echo "<div class='dropdown-content'>";
		 													echo "<a href=\"providerdashboard-ad-edit.php?crn={$company_registration_number}&ad-no={$add['ad_no']}&p={$page_number}\">Edit ad</a>";
		 													echo "<a href=\"providerdashboard-ad-delete.php?crn={$company_registration_number}&ad-no={$add['ad_no']}&p={$page_number}\" onclick=\"return confirm('Are You Sure?');\">Delete ad</a>";
		 												echo "</div>";
		 										echo "</div>";
		 									echo "</div>";
										 //echo "<a href=\"index.php\">";
										 	echo "<div class='img-column'>";
		 										echo "<div class='img-set'>";
		 											echo provider_profile_picture($company_registration_number,$connection);
		 										echo "</div>";
		 									echo "</div>";
		 									echo "<div class='ad-content'>";
		 										echo "<div class='ad-title'>";
		 											echo "<h4>" . $add["job_title"] ."</h4>";
		 										echo "</div>";
		 										echo "<div class='ad-company'>";
		 											echo "<h4><i class='fas fa-home'></i>" . $company_name ."</h4>";
		 										echo "</div>";
		 										echo "<div class='ad-salary'>";
		 											echo "<h4><i class='fas fa-coins'></i>RS: " . $add["monthly_salary"] ."</h4>";
		 										echo "</div>";
		 										echo "<div class='ad-location'>";
		 											echo "<h4><i class='fas fa-map-marker-alt'></i>" . $add["location"] ."</h4>";
		 										echo "</div>";
		 										echo "<div class='ad-catogery'>";
		 											echo "<h4><i class='far fa-building'></i>" . $add["job_category"]. "</h4>";
		 										echo "</div>";
		 										echo "<div class='ad-type'>";
		 											echo "<h4><i class='fas fa-briefcase'></i>" . $add["job_type"] . "</h4>";
		 										echo "</div>";
												 echo "</div>";
		 										echo "<div class='ad-time'>";
												 	echo "<h4 class='expire' title='expiry time'>00:00:00</h4>";
													 echo "<h4 title='Ad Posted Date'><i class='far fa-clock'></i>" . facebook_time_ago($add["ad_time"]) ."</h4>";
												 echo "</div>";
												 
												 //getting expire date and time of ad
												 echo "<input type='hidden' class='date' name='datetime' value='".$add['expire_time']." '> ";
		 								//echo "</a>";
		 							echo "</div>";
		 						
		 					}
		 				echo "</div>";
		 			echo "</div>";
					}
				?>
		<div class="row">
			<div class="next-link">
				<div class="next-content">
					<?php 
						if (mysqli_num_rows($result_set)!=0) {
							echo $page_nav;
						}
						else{
							echo "<div class='next-em'>";
							echo "<div class ='empty'>";
							echo "You have not posted any ads yet";
							echo "</div>";
							echo "</div>";
						} 
					?>
				</div>
			</div>
		</div>
		
	</div><!--section-->

<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>
<script>

	let addate = document.querySelectorAll('.date');
	let expiresection = document.querySelectorAll('.expire');
	
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
				expiresection[i].innerHTML = "<i class='fas fa-history'></i>"+days+" Days And "+hours+":"+minutes+":"+seconds;
			}
			else{
				expiresection[i].innerHTML ="Ad Expired";
			}


			/*console.log(days+" Days And "+hours+":"+minutes+":"+seconds);
			console.log("\n");*/
		}
	}

	
	setInterval(() => {
		caldate();
	}, 1000);

</script>

</body>
<?php mysqli_close($connection); ?>
</html>