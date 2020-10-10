<?php require_once("inc/connection.php"); ?>

<?php  

	$errors =array();
	$company_name="";
	$company_registration_number="";
	$company_phone_number="";
	$company_email="";

	if (isset($_POST["submit"])) {

		$company_name=$_POST["company_name"];
		$company_registration_number=$_POST["company_registration_number"];
		$company_phone_number=$_POST["company_phone_number"];
		$company_email=$_POST["company_email"];


		if (empty(trim($_POST["company_name"]))) {
			$errors[]="Company Name is Required";
		}
		if (empty(trim($_POST["company_registration_number"]))) {
			$errors[]="Company Registraion Number is Required";
		}
		if (empty(trim($_POST["company_phone_number"]))) {
			$errors[]="Company Phone Number is Required";
		}
		if (empty(trim($_POST["company_email"]))) {
			$errors[]="Company Email is Required";
		}
		if (empty(trim($_POST["password"]))) {
			$errors[]="Password is Required";
		}
		if (empty(trim($_POST["c_passwrd"]))) {
			$errors[]="Please Enter Confirm Password";
		}

		//checkin maxmium filds

		$max_len_fields=array("company_name"=>50,"company_registration_number"=>50,"company_phone_number"=>20,"company_email"=>50,"password"=>10,"c_passwrd"=>10);

		foreach ($max_len_fields as $max => $value) {
			
			if (strlen(trim($_POST[$max])) > $value) {
				$errors[]=$max . " Must Be Less Than " . $value . "Characters";	
			}
		}
		//check password is correct
		if ($_POST["password"] != $_POST["c_passwrd"]) {
			$errors[]="Password Does Not Match";
		}

		//checking Email address and Company registration Number is already Exists

		$query="SELECT company_registration_number,company_email,company_name FROM provider WHERE company_registration_number='{$company_registration_number}' OR company_email='{$company_email}' OR company_name='{$company_name}'";

		$result = mysqli_query($connection,$query);

		if($result){
			$qe=mysqli_fetch_assoc($result);

				if ($company_registration_number==$qe["company_registration_number"]) {
					$errors[]= $company_registration_number . " Is Already Exsits";
				}
				if ($company_name==$qe["company_name"]) {
					$errors[]= $company_name . " Is Already Exsits";
				}
				if ($company_email==$qe["company_email"]) {
					$errors[]= $company_email . " Is Already Exsits";
				}
		}

		//update query
		if (empty($errors)) {
			
			$company_name=mysqli_real_escape_string($connection,$_POST["company_name"]);
			$company_registration_number=mysqli_real_escape_string($connection,$_POST["company_registration_number"]);
			$company_phone_number=mysqli_real_escape_string($connection,$_POST["company_phone_number"]);
			$company_email=mysqli_real_escape_string($connection,$_POST["company_email"]);
			$password=$_POST["password"];

			$hased_password=sha1($password);

			echo $company_name;
			echo $company_registration_number;
			echo $company_phone_number;
			echo $company_email;
			echo $password;

			$query="INSERT INTO provider (company_name,company_registration_number,company_email,company_phone_number,password,is_deleted,is_image) VALUES ('{$company_name}','{$company_registration_number}','{$company_email}','{$company_phone_number}','{$hased_password}',0,0)";

			$result = mysqli_query($connection ,$query);

			if ($result) {
				header("location:providersignin.php");
			}
			else{
				$errors[]= "Query false";
				//to check what is query error
				printf("error: %s\n", mysqli_error($connection));
			}
		}

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Provider Sign Up</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/providersignup.css">
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
				<h1>Make Your Account</h1>
			</div>
			<form action="providersignup.php" method="post">
			<div class="row2">
				
					<?php 

						if (!empty($errors)) {
							echo "<div class='errmsg'>";
							foreach ($errors as $value) {
								echo "<p>" . $value . "</p>";
							}
							echo "</div>";
						}

					 ?>

				<p>
					<label for="">Company Name</label>
					<input type="text" name="company_name" value="<?php echo $company_name ?>">
				</p>
				<p>
					<label for="">Company Registraion Number</label>
					<input type="text" name="company_registration_number" value="<?php echo $company_registration_number ?>">
				</p>
				<p>
					<label for="">Company Phone Number</label>
					<input type="text" name="company_phone_number" value="<?php echo $company_phone_number ?>">
				</p>
				<p>
					<label for="">Company Email</label>
					<input type="Email" name="company_email" value="<?php echo $company_email ?>">
				</p>
				<p>
					<label for="">Password</label>
					<input type="password" name="password">
				</p>
				<p>
					<label for="">Confirm Password</label>
					<input type="password" name="c_passwrd">
				</p>
			</div>
			<div class="row3">
				<div class="c_but">
					<input type="submit" name="submit" value="Sign Up">
				</div>
				<p>
					Already Have An Account?
					<a href="providersignin.php">Sign In Here</a>
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