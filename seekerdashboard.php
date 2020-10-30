<?php ob_start() ?>
<?php require_once("inc/connection.php"); ?>
<?php session_start(); ?>
<?php 

	if (!isset($_SESSION["seeker_id"])) {
		header("location:index.php");
	}

	$seeker_username = $_SESSION["username"];
	$seeker_qualification =$_SESSION["qualifi"];

?>

<?php  

	$query = "SELECT count(ad_no) AS total_number_of_rows FROM job_ad WHERE is_delete != 1 AND active !=0 AND qulification_level ='{$seeker_qualification}'  AND is_expire =0";

	$result_Set = mysqli_query($connection,$query);

	$res= mysqli_fetch_assoc($result_Set);

	$total_number_of_rows = $res["total_number_of_rows"];

	$rows_per_page = 6;

	if (isset($_GET["p"])) {
		$page_number = $_GET["p"];
	}
	else{
		$page_number = 1;
	}

	$start = ($page_number-1)*$rows_per_page;

	$query = "SELECT * FROM job_ad WHERE is_delete != 1 AND active!=0 AND is_expire =0 AND qulification_level ='{$seeker_qualification}' ORDER BY ad_no DESC LIMIT {$start},{$rows_per_page} ";

	$result_Set = mysqli_query($connection,$query);

		/*if ($result_Set) {
			while ($ad=mysqli_fetch_assoc($result_Set)) {
			echo $ad["ad_no"];
			}
		}
		else{
			printf(mysqli_error($connection));
		}*/
		//link for first page
		$first ="<a href = 'seekerdashboard.php?p=1'>First</a>";

		//link for last page
		$last_page = ceil($total_number_of_rows/$rows_per_page);
		$last ="<a href ='seekerdashboard.php?p={$last_page}'>Last</a>";

		//link for next page
		if ($page_number>=$last_page) {
			$last="<a>Last</a>";
			$next="<a>Next</a>";
		}
		else{
			$next_page = $page_number+1;
			$next="<a href = 'seekerdashboard.php?p={$next_page}'>Next</a>";
		}
		//link for previous
		if ($page_number==1) {
			$first="<a>First</a>";
			$previous="<a>Previous</a>";
		}
		else{
			$previous_page = $page_number-1;
			$previous="<a href = 'seekerdashboard.php?p={$previous_page}'>Previous</a>";
		}

	//asign page number to list

 		$page_nav = "<ul>";
	 	$page_nav .= "<li>" . $first . "</li>";
	 	$page_nav .= "<li>" . $previous . "</li>";
	 	$page_nav .="<li>" . $page_number . " Of " . $last_page . "</li>";
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
 		return "<img src=\"imj/profile_pictures/default.jpg\">";
 	}
 }
//function for appliy and cancel button

 	function buttonColor($con,$seeker_id,$ad_no,$company_registration_number,$page_number){

		$connection = $con;

		$button_query = "SELECT * FROM job_apply WHERE seeker_id = '{$seeker_id}' AND ad_no='{$ad_no}' LIMIT 1";

		$button_result = mysqli_query($connection,$button_query);

		if ($button_result) {
			if (mysqli_num_rows($button_result)==1) {
				echo  "<a href=\"seekerdashboard-vjob.php?ad-no={$ad_no}&p={$page_number}\" ><button id='button' style='border-color:#15b715;color:#15b715' class='al' title='Applied Add'>View Ad</button></a>";
			}
			else{

				echo  "<a href=\"seekerdashboard-vjob.php?ad-no={$ad_no}&p={$page_number}\" ><button id='button' title='Not Applied Add'>View Ad</button></a>";
			}
		}
		else{
			printf(mysqli_error($connection));
		}
 	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Seeker DashBoard</title>
	<link rel="stylesheet" href="css/seekerdashboard.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="css/seekerdashboard-main.css">

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/seekerdashboardheader.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/seeker-media.css"><!--media query-->
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
					<div class="upload-pro-pic">
						<a href="seekerdashboard-ema.php"><button><i class="fas fa-pencil-alt"></i></button></a>
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
				<li class="active"><i class="fas fa-caret-down"></i><a href="seekerdashboard.php">Dashboard</a></li>
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

	<div class="search-bar">
		<div class="content-pic">
			<!--<picture>
				<source media="(max-width:525px)" srcset="imj/search_mobile.jpg">
				<img src="imj/search.jpg" alt="">
			</picture>-->
		</div>
		<div class="search-content">
			<form action="seekerdashboard-search.php" method="GET">
				<p>
					<i class="fas fa-search"></i><input type="text" placeholder="What?" name="what-search">
				</p>
				<p>
					<i class="fas fa-search"></i><input type="text" placeholder="Where?" name="where-search">
				</p>
				<p>
					<i class="fas fa-search"></i><input type="text" placeholder="Company?" name="company-name">
				</p>
				<p><input type="submit" name="find" value="Find Job">
				</p>
			</form>
		</div>

	</div>

	<div class="add-list">
		<div class="sort_row">
			<div class="sort_column">
				<?php if(mysqli_num_rows($result_Set)!=0){
					echo '<h3>Showing '.++$start .'-'.mysqli_num_rows($result_Set).' Of <span> '.$total_number_of_rows.' Jobs</span></h3>';
				} ?>
			</div>
		</div>
		<div class="all-ads">

			<?php  
					if (mysqli_num_rows($result_Set)!=0) {
						while ($ad=mysqli_fetch_assoc($result_Set)) {

							echo '<div class="row">';
									echo "<a href=\"seekerdashboard-vjob.php?ad-no={$ad["ad_no"]}&p={$page_number}\">";
										echo '<div class="column1">';
											echo '<div class="image">';
												echo provider_profile_picture($ad["company_registration_number"],$connection);
											echo  '</div>';
										echo '</div>';
										echo '<div class="column2">';
											echo '<div class="row1">';
												echo '<h1>' . $ad["job_title"] . '</h1>';
											echo '</div>';
											echo '<div class="row2">';
												echo '<h2><i class="fas fa-home"></i>' . $ad["company_name"]  . '</h2>';
												echo '<h2><i class="fas fa-map-marker-alt"></i>' . $ad["location"] . '</h2>';
												echo '<h2><i class="far fa-building" aria-hidden="true"></i>' . $ad["job_category"] . '</h2>';
												echo '<h2><i class="fas fa-coins"></i>RS:'. $ad["monthly_salary"] . '</h2>';
											echo  '</div>';
										echo '</div>';
										echo '<div class="column3">';
											echo '<div class="row1">';
												 buttonColor($connection,$_SESSION["seeker_id"],$ad["ad_no"],$ad["company_registration_number"],$page_number);
											echo '</div>';
											echo '<div class="row2">';
												echo '<h2><i class="fas fa-briefcase"></i>' . $ad["job_type"] . '</h2>';
												echo '<h2><i class="far fa-clock"></i>' . facebook_time_ago($ad["ad_time"]) . '</h2>';
											echo '</div>';
										echo '</div>';
									echo '</a>';		
							echo '</div>';

						}
					}
					else{
							echo "<div class ='empty'>";
								echo "<h1>no any suitable ads for you</h1>";
								echo "<div class ='svg'>";
									require_once('imj/svg/noads.svg');
								echo "</div>";
							echo "</div>";
					}
			?>

		</div>
		<div class="row">
			<div class="next-link">
				<?php 
						if (mysqli_num_rows($result_Set)!=0) { ?>
							<div class="next-content">
								<?php 
									echo $page_nav;
								?>
							</div>
						<?php
						}
				?>
			</div>
		</div>
	</div><!--add-list-->

<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
</body>
<?php mysqli_close($connection); ?>
</html>