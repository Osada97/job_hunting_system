<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 
	
	$company_name = $_SESSION["company_name"];

	if (!isset($_SESSION["company_registration_number"])) {
		header("location:index.php");
	}

 ?>
 <?php  
 		// Function for get profile Picture
 		function seeker_profile_picture($seeker_id,$connection){

 			$seeker_id = $seeker_id;
 			$con=$connection;

 			$query_profile_pic = "SELECT is_image FROM seeker WHERE seeker_id={$seeker_id} AND is_deleted=0";

 			$profile_pic = mysqli_query($con,$query_profile_pic);

 			if ($profile_pic) {
 				
 				$profile_result = mysqli_fetch_assoc($profile_pic);

 				if ($profile_result["is_image"]==1) {
 					return "<img src=\"imj/profile_pictures/seekers/" . $seeker_id . ".jpg\"  >";
 				}
 				else{
 					//return "<img src='imj/profile_pictures/default.jpg'  >";
 				}

 			}
 		}
 		/////////////////////////////////////////////////////////

 		
 		if (isset($_GET["ad-no"])) {
 		
			 	$ad_no=$_GET["ad-no"];

			 	$query="SELECT count(seeker_id ) as total_rows FROM job_apply WHERE provider_id='{$_SESSION["company_registration_number"]}' AND ad_no = '{$ad_no}' ";
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


			 	$query="SELECT seeker_id FROM job_apply WHERE provider_id='{$_SESSION["company_registration_number"]}' AND ad_no = '{$ad_no}' LIMIT $start, $rows_per_page";

			 	$result=mysqli_query($connection,$query);

			 		if ($result) {
						$cv_table ="";
						if(mysqli_num_rows($result)!=0){
							
							$cv_table = "<table>";
							$cv_table .= "<tr><th>No</th><th>Candidate Name</th><th>Status</th></tr>";
	
							$no=0;
	
							while ($ad=mysqli_fetch_assoc($result)) {
		
									$query="SELECT * FROM cv WHERE user_id='{$ad["seeker_id"]}' AND is_deleted = 0";
		
									$cv_result_set = mysqli_query($connection,$query);
		
										if ($cv_result_set) {
		
											if (mysqli_num_rows($cv_result_set)==1) {
		
												$seekers = mysqli_fetch_assoc($cv_result_set);
		
												$cv_table .="<tr><td>" . ($no+=1) . "</td><td><div class='pro-pic'>" . seeker_profile_picture($ad["seeker_id"],$connection) . "</div><div class='content'><h2>" . $seekers["first_name"] . " " . $seekers["last_name"] . "</h2><p><i class='fas fa-map-marker'></i>" . $seekers["address"] . "</p><p><i class='fas fa-envelope'></i>" . $seekers["email"] . "</p><p><i class='fas fa-phone'></i>" . $seekers["phone_number"] . "</p></div></td><td><a href=\"cvpreview.php?sid={$ad["seeker_id"]}&ad-no={$ad_no}\"><button><i class=\"far fa-eye\"></i></button></a></td></tr>";
											}
										}
										else{
											printf(mysqli_error($connection));
										}
		
							}
							$cv_table .= "</table>";
						}
						else{
							$cv_table .= "<div class ='empty' style='height:30vh;display:flex;justify-content:center;align-items:center'>";
								$cv_table .= "You have not received the application";
							$cv_table .= "</div>";
						}


			 		}
			 		else{
			 			header("location:providerdashboard-vcvl.php");
			 		}
			 		
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
	 	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Company DashBoard</title>
	<link rel="stylesheet" href="css/provider_dashboard.css">
	<link rel="stylesheet" href="css/seekerdashboard-vsvl2.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/providerDashboard-header-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/provider_dashboard-vcvl2.css"><!--media query-->
</head>
<body>
	
	
	<header>
		<div class="main">
			<div class="row">
				<div class="column">
					<div class="seeker-pic">
						<?php 

							if ($_SESSION["is_image_pro"]==1) {
								echo "<img src=\"imj/profile_pictures/providers/" . $_SESSION["company_registration_number"] . ".jpg\"> ";
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
			<div class="view-cv">
				<div class="row">
					<div class="table">
						<?php echo $cv_table; ?>
					</div>
				</div>

				<div class="row">
					<div class="next-link">
							<?php 
								if (mysqli_num_rows($result)!=0) {
									echo '<div class="next-content">';
									echo $page_nav;
									echo '</div>';
								}
							?>
					</div>
				</div>
			</div>
	</div><!--section-->


<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>

</body>
<?php mysqli_close($connection); ?>
</html>