<?php session_start() ?>
<?php require_once("inc/connection.php"); ?>
<?php  

	$errors=array();

	if (isset($_POST["subm"])) {
		
		if (empty(trim($_POST["company_email"]))) {
			$errors[]="Company Name Or Company Email Required";
		}
		if (empty(trim($_POST["password"]))) {
			$errors[]="Password Required";
		}
		if (empty($errors)) {
			
			$company_email=mysqli_real_escape_string($connection,$_POST["company_email"]);
			$password=mysqli_real_escape_string($connection,$_POST["password"]);

			$hashed_password = sha1($password);

			$query = "SELECT * FROM provider WHERE company_email = '{$company_email}' AND password='{$hashed_password}' AND is_deleted=0 LIMIT 1";

			$result = mysqli_query($connection , $query);

			if ($result) {
				if (mysqli_num_rows($result)==1) {

					$pro=mysqli_fetch_assoc($result);

					$_SESSION["company_registration_number"]=$pro["company_registration_number"];
					$_SESSION["company_name"]=$pro["company_name"];
					$_SESSION["is_image_pro"]=$pro["is_image"];

					header("location:providerdashboard-ea.php?crn=" . $pro["company_registration_number"]);
				}
				else{
					$errors[]="Company Email Or Password Invalied";
				}
			}
			else{
				$errors[]="query error";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Provider Sign In</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/providersignin.css">
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /><!--style sheet for scroll animation-->
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/index-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/providersignupAndsignin-media.css"><!--media query-->

</head>
<body>
	<section>
		<?php require_once("inc/header.php"); ?>
	</section>
	<section>
		<div class="main">
			<div class="row1">
				<h1>Login to Your Account</h1>
			</div>
			<form action="providersignin.php" method="post">
				<div class="row2">
					
					<?php 

						if (!empty($errors)) {
							echo "<div class='err'>";
								foreach ($errors as $value) {
									echo "<p>" . $value . "</p>";
								}
							echo "</div>";
						}
					 ?>

					<p>
					<label for="">Email Address</label>
					<input type="text" name="company_email" placeholder="Enter Email">
					</p>
					<p>
					<label for="">Password</label>
					<input type="Password" name="password" placeholder="Enter Password">
					</p>
				</div>
				<div class="s_but">
					<input type="submit" name="subm" value="Sign In">
					<p>Don't You Have An Account?
					<a href="providersignup.php">Sign Up Here</a>
					</p>
				</div>
			</form>
		</div>
	</section>
	
	<footer>
		<?php require_once("inc/footer.php"); ?>
	</footer>

	<script src="https://unpkg.com/aos@next/dist/aos.js"></script><!--scroll animation-->
	<script>
			//for scroll animation
	    AOS.init({
	    	offset:250,
	    	duration:700,
	    });
	</script>

</body>
<?php mysqli_close($connection); ?>
</html>