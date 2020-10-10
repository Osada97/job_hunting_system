<?php ob_start(); ?>
<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 
	
	$errors =array();

	if (isset($_POST["submit"])) {
		
		if (empty(trim($_POST["username_email"]))) {
			$errors[]="Enter User Name Or Email";
		}
		if (empty(trim($_POST["password"]))) {
			$errors[]="Enter Your Password";		
		}
		if (empty($errors)) {
			$username_email=mysqli_real_escape_string($connection,$_POST["username_email"]);
			$password=mysqli_real_escape_string($connection,$_POST["password"]);
			$hased_password=sha1($password);

			$query="SELECT * FROM seeker WHERE username='{$username_email}' OR email='{$username_email}' AND password='{$hased_password}' AND is_deleted=0 LIMIT 1";

			$result=mysqli_query($connection,$query);

			if ($result) {
				
				if (mysqli_num_rows($result) == 1) {

					$seeker=mysqli_fetch_assoc($result);
					$_SESSION["seeker_id"]=$seeker["seeker_id"];
					$_SESSION["username"]=$seeker["username"];
					$_SESSION["is_image"]=$seeker["is_image"];

					header("Location:seekerdashboard.php");
				}
				else{
					$errors[]="Invalid Username/Email Or Password Invalied";
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Seeker LogIn</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/seekersignin.css">
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /><!--style sheet for scroll animation-->
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/index-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/seekersignupAndsignin-media.css"><!--media query-->


</head>
<body>
	
	<header>
		<?php require_once("inc/header.php") ?>
	</header>
	
	<section>
		<div class="main">
				<div class="row1">
					<h1>Login to Your Account</h1>
				</div>
				<div class="row2">

					<div class="errors">

						<p>
							<?php  
								if (!empty($errors)) {
									foreach ($errors as $value) {
										echo $value . "<br>";
									}
								}
							?>
						</p>

					</div>
					<form action="userlogin.php" method="post">
						<p>
							<label for="">Username/Email</label>
							<input type="text" name="username_email" placeholder="Enter Username/Email">
						</p>
						<p>
							<label for="">Password</label>
							<input type="password" name="password" placeholder="Enter Password">
						</p>
				</div>		
				<div class="row3">
						<p>
							<input type="submit" name="submit">
						</p>
						<p>
							Don't You Have A Account? <a href="seekersignup.php">Sign Up Here</a>
						</p>
				</div>
					</form>
		</div>
	</section>

<footer>
	<?php require_once("inc/footer.php"); ?>
</footer>


	<script src="https://unpkg.com/aos@next/dist/aos.js"></script><!--scroll animation-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script><!--jQuery CDN-->
 <script>
  	//for mobile navigation
  	$(document).ready(function(){
  		$('.mob-nav h3').click(function(){
  			$('.mob-nav ul').toggle(400);
  		});

  	});
  </script>
	<script>
			//for scroll animation
	    AOS.init({
	    	offset:250,
	    	duration:700,
	    });
	</script>

</body>
<?php mysqli_close($connection) ?>
</html>