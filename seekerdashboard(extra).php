<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 


//extra one

	if (!isset($_SESSION["seeker_id"])) {
		header("location:index.php");
	}
	$seeker_id=$_SESSION["seeker_id"];
	$seeker_username=$_SESSION["username"];
?>

<?php 

	if (isset($_SESSION["seeker_id"])) {
		
		$seeker_id=$_SESSION["seeker_id"];
		$seeker_username=$_SESSION["username"];

		$query1="SELECT * FROM seeker WHERE seeker_id='{$seeker_id}' LIMIT 1";
		$query2="SELECT address,birth_day,linked_in,facebook,twitter,github FROM cv WHERE user_id='{$seeker_id}' LIMIT 1";

		$result_set1 = mysqli_query($connection,$query1);
		$result_set2 = mysqli_query($connection,$query2);

		if (mysqli_num_rows($result_set1)==1 || mysqli_num_rows($result_set2)==1) {
				$resultseeker=mysqli_fetch_assoc($result_set1);
				$resultcv=mysqli_fetch_assoc($result_set2);

				$first_name=$resultseeker["first_name"];
				$last_name=$resultseeker["last_name"];
				$user_name=$resultseeker["username"];
				$email=$resultseeker["email"];
				$phone_number=$resultseeker["phone_number"];

				$dob=$resultcv["birth_day"];
				$address=$resultcv["address"];
				$facebook=$resultcv["facebook"];
				$linked_in=$resultcv["linked_in"];
				$twitter=$resultcv["twitter"];
				$github=$resultcv["github"];
		}

	}
	$errors =array();

	if (isset($_POST["save"])) {

		/*$first_name="";
	$last_name="";
	$user_name="";
	$email="";
	$phone_number="";
	$dob="";
	$address="";
	$facebook="";
	$linked_in="";
	$twitter="";
	$github="";*/

				$first_name=$_POST["first_name"];
				$last_name=$_POST["last_name"];
				$user_name=$_POST["username"];
				$email=$_POST["email"];
				$phone_number=$_POST["phone_number"];

				$dob=$_POST["dob"];
				$address=$_POST["address"];
				$facebook=$_POST["facebook"];
				$linked_in=$_POST["linked_in"];
				$twitter=$_POST["twitter"];
				$github=$_POST["github"];

				$_SESSION["username"]=$user_name;
				$seeker_username=$_SESSION["username"];


		
		if (empty(trim($_POST["first_name"]))) {
			$errors[]="First Name Is Required";		
		}
		if (empty(trim($_POST["last_name"]))) {
			$errors[]="Last Name Is Required";		
		}
		if (empty(trim($_POST["username"]))) {
			$errors[]="User nameIs Required";		
		}
		if (empty(trim($_POST["address"]))) {
			$errors[]="Address Is Required";		
		}
		if (empty(trim($_POST["email"]))) {
			$errors[]="Email Is Required";		
		}
		if (empty(trim($_POST["phone_number"]))) {
			$errors[]="Phone Number Is Required";		
		}
		if (empty(trim($_POST["dob"]))) {
			$errors[]="Birth Day Is Required";		
		}
		//checking max filds
		
		$max_fild_set = array("first_name"=>50,"last_name"=>50,"username"=>30,"address"=>200,"email"=>200,"phone_number"=>20,"dob"=>50);

		foreach ($max_fild_set as $key => $value) {
			if (strlen(trim($_POST[$key]))>$value) {
				$errors[]= $key . " Must be less than " . $value . " Characters";
			}
		}

		//checking Email is already exsits

		$query = "SELECT * FROM seeker WHERE seeker_id !='{$seeker_id}' AND email = '{$_POST['email']}'";

		$result_set = mysqli_query($connection,$query);

		if ($result_set) {
			if (mysqli_num_rows($result_set)==1) {
				$errors[]="Email Is Already exsits";
			}
		}

		if (empty($errors)) {
			
			$query1 = "UPDATE seeker SET first_name = '{$first_name}',last_name='{$last_name}',username='{$user_name}',email='{$email}',phone_number='{$phone_number}' WHERE seeker_id = '{$seeker_id}'";

			$query2 = "UPDATE cv SET address='{$address}',birth_day='{$dob}',facebook='{$facebook}',twitter='{$twitter}',linked_in='{$linked_in}',github='{$github}' WHERE user_id = '{$seeker_id}'";

			$result_set1 = mysqli_query($connection,$query1);

			$result_set2 = mysqli_query($connection,$query2);

			if ($result_set1 && $result_set2) {
				
				//cheking is have a cv

				$query="SELECT * FROM cv WHERE user_id = {$seeker_id}";

				$result = mysqli_query($connection,$query);

				//if it is not 
					if (mysqli_num_rows($result)==0) {

						//update cv

						$query="INSERT INTO cv (user_id,first_name,last_name,email,phone_number,address,birth_day,facebook,twitter,linked_in,github,is_deleted) VALUES ('{$seeker_id}','{$first_name}','{$last_name}','{$email}','{$phone_number}','{$address}','{$dob}','{$facebook}','{$twitter}','{$linked_in}','{$github}',0)";

						$result_set= mysqli_query($connection,$query);
					}
					else{
						//need confirm button
							$query="UPDATE cv SET  first_name = '{$first_name}',last_name='{$last_name}',email='{$email}',phone_number='{$phone_number}',address='{$address}',birth_day='{$dob}',facebook='{$facebook}',twitter='{$twitter}',linked_in='{$linked_in}',github='{$github}' WHERE user_id = '{$seeker_id}'";

							$result_set= mysqli_query($connection,$query);
					}
			}
			else{
				// Query Error Checking
				printf("error: %s\n", mysqli_error($connection));
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
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="css/seekerdashboardprofilesettings.css">
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
						<h2><?php echo $seeker_username; ?></h2>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section>
		<div class="navi">
			<ul>
				<li class="active"><i class="fas fa-caret-down"></i>Dashboard</li>
				<li><i class="fas fa-caret-down"></i>My Account</li>
				<li><i class="fas fa-caret-down"></i>My CV</li>
				<li class="drop-down"><i class="fas fa-caret-down"></i>Account Settings
						<div class="drop-down-content">
										<a href="#">Edit My Account</a>
										<a href="#">Change Password</a>
										<a href="#">Edit My CV</a>
										<a href="#">Delete My Account</a>
							</div>
				</li>			
				<li><i class="fas fa-power-off"></i>Log Out</li>
			</ul>
		</div>
	</section>

	<div class="section">

		<div class="account-settings-content">
			<div class="error">
				<?php 
					foreach ($errors as $value) {
						echo "<p>" . $value . "</p>";
					}
				 ?>
			</div>
			<div class="row1">
				<h2>Basic Information</h2>
			</div>
			<form action="seekerdashboard.php" method="post">
			<div class="row2">
				
					<p>
						<label for="">Your First Name</label>
						<input type="text" name="first_name" value="<?php echo $first_name; ?>">
					</p>
					<p>
						<label for="">Your Last Name</label>
						<input type="text" name="last_name"value="<?php echo $last_name; ?>" >
					</p>
					<p>
						<label for="">Your User Name</label>
						<input type="text" name="username"value="<?php echo $seeker_username; ?>">
					</p>
					<p>
						<label for="">Email</label>
						<input type="email" name="email"value="<?php echo $email; ?>" >
					</p>
					<p>
						<label for="">Date Of Birth</label>
						<input type="text" name="dob"value="<?php echo $dob; ?>" >
					</p>
					<p>
						<label for="">Phone Number</label>
						<input type="text" name="phone_number"value="<?php echo $phone_number; ?>">
					</p>
					<p>
						<label for="">Address</label>
						<input type="text" name="address"value="<?php echo $address; ?>" >
					</p>
			</div>
				<div class="row3">
					<div class="header">
						<h2>Social Links</h2>
					</div>
					<div class="second">
						<p>
							<label for="">Facebook</label>
							<input type="text" name="facebook" value="<?php echo $facebook; ?>">
						</p>
						<p>
							<label for="">LinkedIn</label>
							<input type="text" name="linked_in" value="<?php echo $linked_in; ?>">
						</p>
						<p>
							<label for="">Twitter</label>
							<input type="text" name="twitter" value="<?php echo $twitter; ?>">
						</p>
						<p>
							<label for="">GitHub</label>
							<input type="text" name="github" value="<?php echo $github; ?>">
						</p>
					</div>
				</div>
				<div class="e-pro-but">
					<input type="submit" name="save" value="Save Settings">
				</div>
			</form>
		</div>
		
	</div><!--section-->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!--<script src="js/dashboardcontent.js"></script>-->

</body>
<?php mysqli_close($connection); ?>
</html>