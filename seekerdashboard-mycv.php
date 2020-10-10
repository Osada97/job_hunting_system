<?php ob_start() ?>
<?php require_once("inc/connection.php"); ?>
<?php session_start(); ?>
<?php 

	if (!isset($_SESSION["seeker_id"])) {
		header("location:index.php");
	}

	$seeker_username = $_SESSION["username"];

?>

<?php  
	
	$seeker_id = $_SESSION["seeker_id"];;
	
	$query = "SELECT * FROM cv WHERE user_id = '{$seeker_id}' LIMIT 1";

	$result_set = mysqli_query($connection, $query);

	if(mysqli_num_rows($result_set)==1){ //check how many result query has? 

		$pcv=mysqli_fetch_assoc($result_set); //fetch the data

		$is_deleted=$pcv["is_deleted"];

		$sk_prece = '';
		$awpr ='';
		$edpr ='';
		$wdpr = '';

		$first_name="";
		$last_name="";
		$title="";
		$des="";
		$email="";
		$phone="";
		$address="";
		$dob="";
		$in="";
		$fa="";
		$twitter="";
		$git="";
		$eyear="";
		$einstitute="";
		$etitle="";
		$edes="";
		$wyear="";
		$wtitle="";
		$winstitute="";
		$wdes="";
		$stitle="";
		$presentage="";
		$stitle2="";
		$presentage2="";
		$stitle3="";
		$presentage3="";
		$ayear="";
		$atitle="";
		$ainstitute="";
		$ades="";

		//check is cv is deleted?

		if ($is_deleted==0) {

		$first_name = $pcv["first_name"];
		$last_name = $pcv["last_name"];
		$title = $pcv["title"];
		$des=$pcv["description"];
		$email=$pcv["email"];
		$phone=$pcv["phone_number"];
		$address=$pcv["address"];
		$dob=$pcv["birth_day"];

		//fetching data from sh_media
		$sh_query = "SELECT * FROM sh_media WHERE user_id = {$pcv['user_id']}";
		$sh_result = mysqli_query($connection,$sh_query);

		if(mysqli_num_rows($sh_result)>0){

			while($proRs=mysqli_fetch_assoc($sh_result)){

				$in=$proRs["linked_in"];
				$fa=$proRs["facebook"];
				$twitter=$proRs["twitter"];
				$git=$proRs["git_hub"];
				
			}
		}


		//fetching data from cv tables
		//fetching data to awads fields
		$award_query = "SELECT * FROM awards WHERE user_id = {$pcv['user_id']}";
		$award_result = mysqli_query($connection,$award_query);

		if(mysqli_num_rows($award_result)>0){

			while($awaRs=mysqli_fetch_assoc($award_result)){

				$awpr .= '<div class="content">';
				$awpr .='<h5>'.$awaRs['aw_year'].'</h5>';
				$awpr .= '<h2>'.$awaRs['aw_title'].'</h2>';
				$awpr .= '<h3>'.$awaRs['aw_institute'].'</h3>';
				$awpr .= '<h4>'.$awaRs['aw_description'].'</h4>';
				$awpr .= '</div>';
			}

		}
		//fetching data from education
		$education_query = "SELECT * FROM education WHERE user_id = {$pcv['user_id']}";
		$education_result = mysqli_query($connection,$education_query);

		if(mysqli_num_rows($education_result)>0){

			while ($eduRs=mysqli_fetch_assoc($education_result)) {
				
				$eyear=$eduRs["edu_year"];
				$einstitute=$eduRs["edu_institute"];
				$etitle=$eduRs["edu_title"];
				$edes=$eduRs["edu_description"];

				$edpr .= '<div class="content">';
				$edpr .='<h5>'.$eyear.'</h5>';
				$edpr .= '<h2>'.$etitle.'</h2>';
				$edpr .= '<h3>'.$einstitute.'</h3>';
				$edpr .= '<h4>'.$edes.'</h4>';
				$edpr .= '</div>';
			}
		}
		//fetching data from professional skills
		$professional_query = "SELECT * FROM professional_skills WHERE user_id = {$pcv['user_id']}";
		$professional_result = mysqli_query($connection,$professional_query);

		if(mysqli_num_rows($professional_result)>0){

			while($proRs=mysqli_fetch_assoc($professional_result)){

				$stitle=$proRs["title"];
				$presentage=$proRs["percentage"];

				$sk_prece .= '<div class="content">';
				$sk_prece .= '<h3>'.$stitle.'</h3>';
				$sk_prece .= '<h4><span>'.$presentage.'%</span></h4>';
				$sk_prece .='<div class="presentagebar">';
				$sk_prece .='<div class="bar" style="width:'.$presentage.'%">';
				$sk_prece .='</div>';
				$sk_prece .= '</div>';					
				$sk_prece .= '</div>';					
									
			}
		}
		//fetching data from work experience
		$wk_query = "SELECT * FROM work_experience WHERE user_id = {$pcv['user_id']}";
		$wk_media = mysqli_query($connection,$wk_query);

		if(mysqli_num_rows($wk_media)>0){

			while($wkRs=mysqli_fetch_assoc($wk_media)){
				
				$wyear=$wkRs["wk_years"];
				$wtitle=$wkRs["wk_title"];
				$winstitute=$wkRs["wk_company"];
				$wdes=$wkRs["wk_description"];

				$wdpr .= '<div class="content">';
				$wdpr .='<h5>'.$wyear.'</h5>';
				$wdpr .= '<h2>'.$wtitle.'</h2>';
				$wdpr .= '<h3>'.$winstitute.'</h3>';
				$wdpr .= '<h4>'.$wdes.'</h4>';
				$wdpr .= '</div>';	

			}
		}

		}
	}
	else{
		$first_name="";
		$last_name="";
		$title="";
		$des="";
		$email="";
		$phone="";
		$address="";
		$dob="";
		$in="";
		$fa="";
		$twitter="";
		$git="";
		$eyear="";
		$einstitute="";
		$etitle="";
		$edes="";
		$wyear="";
		$wtitle="";
		$winstitute="";
		$wdes="";
		$stitle="";
		$presentage="";
		$stitle2="";
		$presentage2="";
		$stitle3="";
		$presentage3="";
		$ayear="";
		$atitle="";
		$ainstitute="";
		$ades="";

		header('Refresh: 3; URL=seekerdashboard-ecv.php');//make delay
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Seeker DashBoard</title>
	<link rel="stylesheet" href="css/seekerdashboard.css">
	<link rel="stylesheet" href="css/seekerdashboard-mycv.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/seekerdashboard-mycv-media.css"><!--media-queries>-->
	<link rel="stylesheet" href="css/media-queries/seekerdashboardheader.css"><!--media-queries>-->
	
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
				<li><i class="fas fa-caret-down"></i><a href="seekerdashboard.php">Dashboard</a></li>
				<li><i class="fas fa-caret-down"></i><a href="seekerdashboard-ema.php">Edit My Account</a></li>
				<li  class="active"><i class="fas fa-caret-down"></i><a href="seekerdashboard-mycv.php">My CV</a></li>
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

	<div class="section">
			<div class="cv-main">
				<div class="cv_col">
					<div class="row">
						<div class="cv-pic">
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

					<div class="row">
						<div class="content">
							<h3>Name:</h3>
							<h4><span><?php echo $first_name;echo " " . $last_name; ?></span></h4>
						</div>
						<div class="content">
							<h3>Title:</h3>
							<h4><span><?php echo $title; ?></span></h4>
						</div>
						<div class="content">
							<h3>Description:</h3>
							<h4><span><?php echo $des; ?></span></h4>
						</div>
					</div>

					<div class="row">

						<?php 
							if(!empty($email)) {echo '<h5><i class="fas fa-envelope"></i>'.$email.'</h5>';} 
							if(!empty($phone)){echo '<h5><i class="fas fa-phone"></i> '.$phone.'</h5>';}
							if(!empty($address)){echo '<h5><i class="fas fa-map-marker"></i >'.$address.'</h5>';}
							if(!empty($dob)){echo '<h5><i class="far fa-calendar-alt"></i >'.$dob.'</h5>';}
							if(!empty($in)){echo '<h5><i class="fab fa-linkedin"></i> '.$in.'</h5>';}
							if(!empty($fa)){echo '<h5><i class="fab fa-facebook"></i> '.$fa.'</h5>';}
							if(!empty($$twitter)){echo '<h5><i class="fab fa-twitter"></i> '.$twitter.'</h5>';}
							if(!empty($git)){echo '<h5><i class="fab fa-github"></i> '.$git.'</h5>';}

						?>
						
					</div>
				</div>
				<div class="cv_col">
					
						<div class="row">
							<div class="ro">
								<h1>Education:</h1>
									<div class="rowco">
										<?php if(!empty($edpr)){echo $edpr;} ?>
									</div>	
							</div>
						</div>
						<div class="row">
							<div class="ro">
								<h1>Work Experiencs:</h1>
									<div class="rowco">
										<?php if(!empty($wdpr)){echo $wdpr;} ?>
									</div>	
							</div>
						</div>
						<div class="row">
							<div class="ro">
								<h1>Skills:</h1>
									<div class="rowco">
											<?php if(!empty($sk_prece)){echo $sk_prece;} ?>		
									</div>	
							</div>
						</div>
						<div class="row">
							<div class="ro">
								<h1>Award:</h1>
									<div class="rowco">
										<?php if(!empty($awpr)){echo $awpr;} ?>
									</div>	
							</div>
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