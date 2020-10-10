<?php ob_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 

	$errors =array();
	$Firstname="";
	$Lastname="";
	$Username="";
	$email_address="";
	$phone_number="";

	//checking is filds are set

	if (isset($_POST["submit"])) {

		//Save enter Filds

		$Firstname	=$_POST["Firstname"];
		$Lastname	=$_POST["Lastname"];
		$Username	=$_POST["Username"];
		$email_address	=$_POST["email_address"];
		$phone_number	=$_POST["phone_number"];
		////////////////////////////////////////////////
		
		if (empty(trim($_POST["Firstname"]))) {
			$errors[]="Please Enter First Name";
		}
		if (empty(trim($_POST["Lastname"]))) {
			$errors[]="Please Enter Last Name";
		}
		if (empty(trim($_POST["Username"]))) {
			$errors[]="Please Enter Username";
		}
		if (empty(trim($_POST["email_address"]))) {
			$errors[]="Please Enter Email Address";
		}
		if (empty(trim($_POST["phone_number"]))) {
			$errors[]="Please Enter Phone Number";
		}
		if (empty(trim($_POST["Password"]))) {
			$errors[]="Please Enter Password";
		}
		if (empty(trim($_POST["con_password"]))) {
			$errors[]="Please Reenter Password";
		}
		//checking max width

		$max_len_filds =array("Firstname" =>50,"Lastname" =>50,"Username" =>30,"email_address" =>100,"phone_number" =>20,"Password" =>100,"con_password" =>100);

		foreach ($max_len_filds as $filds => $value) {
		
			if (strlen(trim($_POST[$filds]))>$value) {
				$errors[] = $filds . " must be less than " . $value . "characters";
			}
		}

		//Checkin Password is correct

		if (! ($_POST["Password"] == $_POST["con_password"])) {
			$errors[]="Password Invalid";
		}

		//Checking if email address is alredy Exsits

		$email = mysqli_real_escape_string($connection, $_POST["email_address"]);
		$query ="SELECT * FROM seeker WHERE email='{$email}' LIMIT 1";
		
		$result_set = mysqli_query($connection, $query);
		
		if ($result_set) {
			if (mysqli_num_rows($result_set)==1) {
			$errors[]="Email address is alredy exists";
			}
		}

		//Add Data to forms
		if (empty($errors)) {
			
			$Firstname = mysqli_real_escape_string($connection, $_POST["Firstname"]);
			$Lastname = mysqli_real_escape_string($connection, $_POST["Lastname"]);
			$Username = mysqli_real_escape_string($connection, $_POST["Username"]);
			$email_address = mysqli_real_escape_string($connection, $_POST["email_address"]);
			$phone_number = mysqli_real_escape_string($connection, $_POST["phone_number"]);

			$hashed_pasword =sha1($_POST["con_password"]);

			$query = "INSERT INTO seeker (first_name, last_name, username, email, phone_number, password,is_image, is_deleted) VALUES ('{$Firstname}','{$Lastname}','{$Username}','{$email_address}','{$phone_number}','{$hashed_pasword}',0,0)";

			$result = mysqli_query($connection ,$query);

			if($result){
				//use thi query for get seeker_id
				$query="SELECT seeker_id FROM seeker WHERE email='{$email}' LIMIT 1";

				$result=mysqli_query($connection, $query);
				$seeker_id=mysqli_fetch_assoc($result);

				//Query is Sucessfull
				
					header("location:cv.php?seeker_id=" . $seeker_id["seeker_id"] . "&add_user=true");
				
			}
			else{
				$errors[]="Faild add record";
				//printf(mysqli_error($connection));
			}
		}

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sign Up</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/signup.css">
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /><!--style sheet for scroll animation-->
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/index-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/seekersignupAndsignin-media.css"><!--media query-->

	
</head>
<body>

	<header>
	<?php require_once("inc/header.php"); ?>
	</header>

	<section>
		<div class="main">
			<div class="row1">
				<h2>Create Your Account</h2>
			</div>
			
			
			<?php 
				if (!empty($errors)) {
					echo "<div class='errmsg'>";
					foreach ($errors as $value) {
						echo "<p>" . $value . "</p>";
					}
					echo "</div>";
				}

			?>
			

			<div class="row2">
				<div class="signup_form">
					<form action="seekersignup.php" method="post">
						<p>
							<label for="">First Name</label>
							<input type="text" name="Firstname" id="" placeholder="Enter First Name" value="<?php echo $Firstname ?>">
						</p>
						<p>
							<label for="">Last Name</label>
							<input type="text" name="Lastname" id="" placeholder="Enter Last Name" value="<?php echo $Lastname ?>">
						</p>
						<p>
							<label for="">Username</label>
							<input type="text" name="Username" id="" placeholder="Enter Username" value="<?php echo $Username ?>">
						</p>
						<p>
							<label for="">Email Address</label>
							<input type="Email" name="email_address" id="" placeholder="Enter Email address" value="<?php echo $email_address ?>">
						</p>
						<p>
							<label for="">Phone number</label>
							<input type="text" name="phone_number" id="" placeholder="Enter Phone Number" value="<?php echo $phone_number ?>">
						</p>
						<p>
							<label for="">Password</label>
							<input type="password" name="Password" id="" placeholder="Enter Password">
						</p>
						<p>
							<label for="">Confirm Password</label>
							<input type="password" name="con_password" id="" placeholder="Reenter Password">
						</p>
						<p>
							<button type="submit" name="submit">Sign Up</button>
							<span>Already registered?<a href="userlogin.php">Log in Here</a></span>
						</p>
					</form>
				</div>
			</div>
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

<?php mysqli_close($connection); ?>
</html>