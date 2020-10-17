<?php require_once("inc/connection.php"); ?>
<?php session_start(); ?>
<?php  

	$seeker_username = $_SESSION["username"];
	$seeker_id =$_SESSION["seeker_id"];

	if (!isset($seeker_id)) {
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

			$query="SELECT * FROM seeker WHERE seeker_id='{$seeker_id}' AND password='{$hased_password}'";

			$result=mysqli_query($connection,$query);

			if (mysqli_num_rows($result)==1) {
				
				$query="UPDATE seeker SET password='{$hased_new_password}' WHERE seeker_id='{$seeker_id}'";

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
	<title>Seeker DashBoard</title>
	<link rel="stylesheet" href="css/seekerdashboard.css">
	<link rel="stylesheet" href="css/seekerdashboard-cp.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/seekerdashboardheader.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/seekerdashboard-ema-media.css"><!--media query-->
	
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
				<li><i class="fas fa-caret-down"></i><a href="seekerdashboard-mycv.php">My CV</a></li>
				<li class="drop-down active"><i class="fas fa-caret-down"></i>Account Settings
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
						<form action="seekerdashboard-cp.php" method="post">
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