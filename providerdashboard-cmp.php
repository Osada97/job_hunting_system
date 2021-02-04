<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 
	
	$company_name = $_SESSION["company_name"];

	if (!isset($_SESSION["company_registration_number"])) {
		header("location:index.php");
	}

 ?>
 <?php  
	
	$errors=array();

	if(isset($_POST["save"])){

		if (empty(trim($_POST["c-password"]))) {
			$errors[]="Please Enter Current Password";
		}
		if (empty(trim($_POST["n-password"]))) {
			$errors[]="Please Enter New Password";
		}
		if (empty(trim($_POST["co-password"]))) {
			$errors[]="Please Enter Confirm Password";
		}

		if (!empty($_POST["n-password"] && $_POST["co-password"] && $_POST["c-password"])) {
			if ($_POST["n-password"]!=$_POST["co-password"]) {
				$errors[]="Password Is Wrong Please Re Enter Password";
			}
		}

		if (empty($errors)) {
			
			$currentpw=mysqli_real_escape_string($connection,$_POST["c-password"]);
			$newpw=mysqli_real_escape_string($connection,$_POST["n-password"]);
			$confirmpw=mysqli_real_escape_string($connection,$_POST["co-password"]);

			$hased_password=sha1($currentpw);
			$hased_new_password=sha1($newpw);

			$query="SELECT * FROM provider WHERE company_registration_number='{$_SESSION['company_registration_number']}' AND password='{$hased_password}'";

			$result=mysqli_query($connection,$query);

			if (mysqli_num_rows($result)==1) {
				
				$query="UPDATE provider SET password='{$hased_new_password}' WHERE company_registration_number='{$_SESSION['company_registration_number']}'";

				$result=mysqli_query($connection,$query);

				if ($result) {
					echo "<script>";
					echo "alert('Password Has Sucessfully Changed')";
					echo "</script>";
				}
				else{
					$errors[]="Query Problem";
				}
			}
			else{
				// Query Error Checking
				//printf("error: %s\n", mysqli_error($connection));
				$errors[]="Invalied Current Password";
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
	<link rel="stylesheet" href="css/seekerdashboard-cp.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/providerDashboard-header-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/providerDashboard-main-media.css"><!--media query-->
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
				<li><i class="fas fa-caret-down"></i><a href="providerdashboard-vcl.php">View CV list</a></li>
				<li class="drop-down active"><i class="fas fa-caret-down"></i>Account Settings
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

		<div class="change-pw">
				<div class="row1">
					<h1>Change Password</h1>
				</div>
				<div class="errors">
					<?php 

						foreach ($errors as $value) {
							echo "<p>" . $value . "</p>";
						}
					 ?>
				</div>
				<div class="row2">
					<div class="content">
						<form action="providerdashboard-cmp.php" method="post">
							<p>
								<label for="">Currnet Password</label>
								<input type="Password" name="c-password" placeholder="Enter Currnet Password">
							</p>
							<p>
								<label for="">New Password</label>
								<input type="Password" name="n-password" placeholder="Enter Currnet Password">
							</p>
							<p>
								<label for="">Confirm Password</label>
								<input type="Password" name="co-password" placeholder="Enter Currnet Password">
							</p>
							
							<div class="but">
								<button name="save">Change Password</button>
							</div>

						</form>
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