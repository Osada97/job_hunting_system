<?php require_once("connection.php"); ?>
<?php session_start(); ?>

<?php  
	
	$seeker_id = $_SESSION["seeker_id"];

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
	
	$query = "SELECT * FROM cv WHERE user_id = '{$seeker_id}' LIMIT 1";

	$result_set = mysqli_query($connection, $query);

	if(mysqli_num_rows($result_set)==1){ //check how many result query has? 

		$pcv=mysqli_fetch_assoc($result_set); //fetch the data

		$is_deleted=$pcv["is_deleted"];

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
		$in=$pcv["linked_in"];
		$fa=$pcv["facebook"];
		$twitter=$pcv["twitter"];
		$git=$pcv["github"];

		$eyear=$pcv["education_year"];
		$einstitute=$pcv["education_institute"];
		$etitle=$pcv["education_title"];
		$edes=$pcv["education_description"];

		$wyear=$pcv["work_year"];
		$wtitle=$pcv["work_title"];
		$winstitute=$pcv["work_name"];
		$wdes=$pcv["work_description"];

		$stitle=$pcv["professional_title1"];
		$presentage=$pcv["professional_percentage1"];
		$stitle2=$pcv["professional_title2"];
		$presentage2=$pcv["professional_percentage2"];
		$stitle3=$pcv["professional_title3"];
		$presentage3=$pcv["professional_percentage3"];


		$ayear=$pcv["awards_year"];
		$atitle=$pcv["award_title"];
		$ainstitute=$pcv["award_institute"];
		$ades=$pcv["award_description"];

		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/dashboardcv.css">
</head>
<body>

<section>
		<div class="smain">
			<div class="pcv">
				<div class="row1">
					<div class="column">
						<div class="content">
							<h3>Name:</h3>
							<h3><span><?php echo $first_name;echo " " . $last_name; ?></span></h3>
						</div>
						<div class="content">
							<h3>Title:</h3>
							<h3><span><?php echo $title; ?></span></h3>
						</div>
						<div class="content">
							<h3>Description:</h3>
							<h3><span><?php echo $des; ?></span></h3>
						</div>
					</div>
					<div class="column">
						<h1>osada</h1>
						<img src="" alt="pic">
					</div>
					<div class="column">
					<p>
					<h3><?php echo $email; ?></h3><i class="fas fa-envelope"></i>
					</p>
					<p>
					<h3><?php echo $phone; ?></h3><i class="fas fa-phone"></i>
					</p>
					<p>
					<h3><?php echo $address; ?></h3><i class="fas fa-map-marker"></i>
					</p>
					<p>
					<h3><?php echo $dob; ?></h3><i class="far fa-calendar-alt"></i>
					</p>
					<p>
					<h3><?php echo $in; ?></h3><i class="fab fa-linkedin"></i>
					</p>
					<p>
					<h3><?php echo $fa; ?></h3><i class="fab fa-facebook"></i>
					</p>
					<p>
					<h3><?php echo $twitter; ?></h3><i class="fab fa-twitter"></i>
					</p>
					<p>
					<h3><?php echo $git; ?></h3><i class="fab fa-github"></i>
					</p>
					</div>
				</div>
				<hr class="hr">
				<div class="row2">
					<div class="column">
					<h1>Education:</h1>
						<div class="content">
							<h5><?php echo $eyear; ?></h5>
							<h2><?php echo $einstitute; ?></h2>
							<h3><?php echo $etitle; ?></h3>
							<h4><?php echo $edes; ?></h4>
						</div>
					</div>
					<div class="column">
					<h1>Work Experiencs:</h1>
						<div class="content">
							<h5><?php echo $wyear; ?></h5>
							<h2><?php echo $wtitle; ?></h2>
							<h3><?php echo $winstitute; ?></h3>
							<h4><?php echo $wdes; ?></h4>
						</div>
					</div>
				</div>
				<div class="row3">
					<div class="column">
					<h1>Skills:</h1>
						<div class="content">
							<h3><?php echo $stitle; ?></h3>
							<h4><span><?php echo $presentage; ?>%</span></h4>
							<div class="presentagebar">
								<div class="bar" style="width: <?php echo $presentage; ?>%">
								</div>
							</div>
							<h3><?php echo $stitle2; ?></h3>
							<h4><span><?php echo $presentage2; ?>%</span></h4>
							<div class="presentagebar">
								<div class="bar" style="width: <?php echo $presentage2; ?>%">
								</div>
							</div>
							<h3><?php echo $stitle3; ?></h3>
							<h4><span><?php echo $presentage3; ?>%</span></h4>
							<div class="presentagebar">
								<div class="bar" style="width: <?php echo $presentage3; ?>%">
								</div>
							</div>
						</div>
					</div>
					<div class="column">
					<h1>Award:</h1>
						<div class="content">
							<h5><?php echo $ayear; ?></h5>
							<h2><?php echo $atitle; ?></h2>
							<h3><?php echo $ainstitute; ?></h3>
							<h4><?php echo $ades; ?></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


</body>
<?php mysqli_close($connection); ?>
</html>