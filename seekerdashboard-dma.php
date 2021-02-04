<?php ob_start(); ?>
<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 

	if (!isset($_SESSION["seeker_id"])) {
		header("location:index.php");
	}

	$seeker_username = $_SESSION["username"];
	$seeker_id = $_SESSION["seeker_id"];

?>
<?php  
		$error=array();
		
	if (isset($_POST["delete"])) {

		if (empty(trim($_POST["password"]))) {
			$error[]="Please Enter Password";
		}

		if (empty($error)) {
			
			$password=mysqli_real_escape_string($connection,$_POST["password"]);

			$hased_password = sha1($password);

			$query = "SELECT * FROM seeker WHERE seeker_id='{$seeker_id}' AND password='{$hased_password}'";

			$result = mysqli_query($connection,$query);

			if (mysqli_num_rows($result)==1) {
				
				$query = "DELETE FROM seeker WHERE seeker_id='{$seeker_id}' AND password='{$hased_password}' ";

				if (mysqli_query($connection,$query)) {
					$querydel = "DELETE FROM cv WHERE user_id = '{$seeker_id}'";
					$resultdel = mysqli_query($connection,$querydel);

					if($resultdel){
						header("location:index.php?seeker_account_deleted=true");
					}
				}
			}
			else{
				printf(mysqli_error($connection));
				$error[]="Password Is Invalied";
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Seeker DashBoard</title>
	<link rel="shortcut icon" type="image/jpg" href="imj/icon/fav.png"/>
	<link rel="stylesheet" href="css/seekerdashboard.css">
	<link rel="stylesheet" href="css/seekerdashboard-dma.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/seekerdashboardheader.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/seekerdashboard-dma-media.css"><!--media query-->

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
		<div class="delete-content">
			<div class="row1">
				<h1>Delete My Account</h1>
			</div>
			<div class="error">
				<?php  
					foreach ($error as $value) {
						echo "<p>" . $value . "</p>";
					}
				?>
			</div>
			<div class="fields">
				<form action="seekerdashboard-dma.php" method="post">
					<div class="row2">
						<p>
							If you want to delete <span>JOBBER</span> account, Please Input Password and click "Delete My Account" Button. 
						</p>
						<p>
							<label for="">Password</label>
							<input type="Password" name="password">
						</p>
					</div>
					<div class="row3">
							<input type="submit" name="delete" value="Delete My Account" onclick="return confirm('Are You Sure')">
					</div>
				</form>
			</div>
		</div>
		
	</div><!--section-->

<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>

</body>
<?php mysqli_close($connection); ?>
</html>