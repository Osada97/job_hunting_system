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

 	$rows_per_page=10;

 	if (isset($_GET['p'])) {
 		$page_number=$_GET['p'];
 	}
 	else{
 		$page_number=1;
 	}

 	$start=($page_number-1) * $rows_per_page;

 	$query="SELECT * FROM job_ad WHERE company_registration_number= '{$company_registration_number}' AND is_delete=0 ORDER BY ad_no DESC LIMIt $start,$rows_per_page ";
 	$result_set=mysqli_query($connection,$query);

 	/*while ($add = mysqli_fetch_assoc($result_set)) {
 		echo $add["ad_no"] . " " . $add["job_title"] . "<br>";
 	}*/

 	//first page number
 	$first="<a href=\"providerdashboard-vcvl.php?p=1\">FIRST </a>";

 	//last page number
 	$last_page_no=ceil($total_rows / $rows_per_page);
 	$last="<a href=\"providerdashboard-vcvl.php?p={$last_page_no}\">last</a>";

 	//next page number
 	if ($page_number >= $last_page_no) {
 		$next="<a>Next</a>";
 		$last="<a>Last</a>";
 	}
 	else{
 		$next_page_number=$page_number+1;
 		$next="<a href=\"providerdashboard-vcvl.php?p={$next_page_number}\">Next</a>";
 	}

 	//last page number
 	if ($page_number == 1) {
 		$previous="<a>previous</a>";
 		$first="<a>first</a>";
 	}
 	else{
 		$previous_page_number=$page_number-1;
 		$previous="<a href=\"providerdashboard-vcvl.php?p={$previous_page_number}\">Previous</a>";
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


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Company DashBoard</title>
	<link rel="shortcut icon" type="image/jpg" href="imj/icon/fav.png"/>
	<link rel="stylesheet" href="css/provider_dashboard.css">
	<link rel="stylesheet" href="css/provider_dashboard-vcvl.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/providerDashboard-header-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/providerDashboard-vcvl-media.css"><!--media query-->
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
				<li><i class="fas fa-caret-down"></i><a href="providerdashboard-ea.php">My Advertisement</a></li>
				<li><i class="fas fa-caret-down"></i><a href="providerdashboard-aad.php">Add Advertisement</a></li>
				<li  class="active"><i class="fas fa-caret-down"></i><a href="providerdashboard-vcvl.php">View CV list</a></li>
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
		<div class="view-add">
	<?php 
		if(mysqli_num_rows($result_set)!=0){?>
			<div class="row1">
				<h3>Select Advertiestment To View CV List</h3>
			</div>
			<div class="row2">
				
				<div class="tabel">

						<table>
							<tr><th>Ad Id</th><th>Job Title</th><th>Upload Time</th><th>CV</th><th>Status</th></tr>
						<?php

							while ($add = mysqli_fetch_assoc($result_set)) {
	
								$query="SELECT count(apply_no) as count FROM job_apply WHERE provider_id='{$company_registration_number}' AND ad_no='{$add["ad_no"]}'";
								$result=mysqli_query($connection,$query);
	
								$count=mysqli_fetch_assoc($result);
	
								$count_cv=$count["count"];
	
								echo "<tr><td>" . $add["ad_no"] . "</td><td><p>" . $add["job_title"] . "</p><p>" . $add["company_name"] . "</p><p>" . $add["email"] . "</p></td><td>" . facebook_time_ago($add["ad_time"]) . "<td class='count'>" . $count_cv . "</td></td><td><a href=\"providerdashboard-vcvl2.php?ad-no={$add["ad_no"]}\".><button><i class=\"far fa-eye\"></i></button></a></tr>";
							
							}?>
							</table>
				</div>
			</div>
	<?php
		}
		else{
			echo "<div class ='empty'>";
				echo "You have not Posted Any Ads Yet";
			echo "</div>";
		} 
	?>
		</div>
		<div class="row">
			<div class="next-link">
				<?php 
						if (mysqli_num_rows($result_set)!=0) {
							echo '<div class="next-content">';
							echo $page_nav;
							echo '</div>';
						}
					?>
			</div>
		</div>
		
	</div><!--section-->

<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>
</body>
<?php mysqli_close($connection); ?>
</html>