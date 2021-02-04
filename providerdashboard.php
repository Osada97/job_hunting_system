<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 
	
	$company_name = $_SESSION["company_name"];

	if (!isset($_SESSION["company_registration_number"])) {
		header("location:index.php");
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Company DashBoard</title>
	<link rel="shortcut icon" type="image/jpg" href="imj/icon/fav.png"/>
	<link rel="stylesheet" href="css/provider_dashboard.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>
</head>
<body>
	
	<header>
		<div class="main">
			<div class="row">
				<div class="column">
					<div class="seeker-pic">
						<img src="imj/logo1.png" alt="sad">
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
				<li><i class="fas fa-caret-down"></i><a href="providerdashboard-aad.php">MY Advertisement</a></li>
				<li><i class="fas fa-caret-down"></i><a href="providerdashboard-ea.php">Edit Advertisement</a></li>
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
		
	</div><!--section-->

</body>
<?php mysqli_close($connection); ?>
</html>