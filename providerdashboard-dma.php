<?php ob_start(); ?>
<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 
	
	$company_name = $_SESSION["company_name"];

	if (!isset($_SESSION["company_registration_number"])) {
		header("location:index.php");
	}

 ?>
 <?php  
		$error=array();
		$company_registration_number=$_SESSION["company_registration_number"];
		
	if (isset($_POST["delete"])) {

		if (empty(trim($_POST["password"]))) {
			$error[]="Please Enter Password";
		}

		if (empty($error)) {
			
			$password=mysqli_real_escape_string($connection,$_POST["password"]);

			$hased_password = sha1($password);

			$query = "SELECT * FROM provider WHERE company_registration_number='{$company_registration_number}' AND password='{$hased_password}'";

			$result = mysqli_query($connection,$query);

			if (mysqli_num_rows($result)==1) {
				
				$query_for_delete="DELETE FROM provider WHERE company_registration_number='{$company_registration_number}' AND password ='{$hased_password}' LImiT 1";

				$result=mysqli_query($connection,$query);

				if ($result) {
					header("location:index.php?provider_account_delete=true");
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
	<title>Company DashBoard</title>
	<link rel="stylesheet" href="css/provider_dashboard.css">
	<link rel="stylesheet" href="css/seekerdashboard-dma.css">
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
				<form action="providerdashboard-dma.php" method="post">
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
							<input type="submit" name="delete" value="Delete My Account" onclick="return confirm('Are You Sure?')">
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