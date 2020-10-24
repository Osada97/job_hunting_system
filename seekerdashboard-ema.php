<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 

	if (!isset($_SESSION["seeker_id"])) {
		header("location:index.php");
	}
	$seeker_id=$_SESSION["seeker_id"];
	$seeker_username=$_SESSION["username"];
?>

<?php 

	clearstatcache();

	if (isset($_SESSION["seeker_id"])) {
		
		$seeker_id=$_SESSION["seeker_id"];
		$seeker_username=$_SESSION["username"];

		$query1="SELECT * FROM seeker WHERE seeker_id='{$seeker_id}' LIMIT 1";
		$query2="SELECT linked_in,facebook,twitter,git_hub FROM sh_media WHERE user_id='{$seeker_id}' LIMIT 1";
		$query3="SELECT address,birth_day FROM cv WHERE user_id='{$seeker_id}' LIMIT 1";

		$result_set1 = mysqli_query($connection,$query1);
		$result_set2 = mysqli_query($connection,$query2);
		$result_set3 = mysqli_query($connection,$query3);

		if (mysqli_num_rows($result_set1)==1 || mysqli_num_rows($result_set2)==1) {
				$resultseeker=mysqli_fetch_assoc($result_set1);
				$resultsh=mysqli_fetch_assoc($result_set2);
				$resultcv = mysqli_fetch_assoc($result_set3);

				$first_name=$resultseeker["first_name"];
				$last_name=$resultseeker["last_name"];
				$user_name=$resultseeker["username"];
				$email=$resultseeker["email"];
				$phone_number=$resultseeker["phone_number"];
				$qua = $resultseeker['qualification'];

				$dob=$resultcv["birth_day"];
				$address=$resultcv["address"];

				$facebook=$resultsh["facebook"];
				$linked_in=$resultsh["linked_in"];
				$twitter=$resultsh["twitter"];
				$github=$resultsh["git_hub"];

				//cecking profile picture is updated

				if ($resultseeker["is_image"]==1) {
					$_SESSION["is_image"]=1;
				}
				else{
					$_SESSION["is_image"]=0;
				}
				//////////////////////////////////////
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
				$qualification=$_POST["qualifi"];

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

		//profile picture upload validation
		/*if ($_FILES["upload-pro-pic"]["name"]) {
			
			if ($_FILES["upload-pro-pic"]["error"] != 0) {
				$errors[]="Can not Upload This Image";

			}
			else{
				$file_name = $_FILES["upload-pro-pic"]["name"];
				$file_type = $_FILES["upload-pro-pic"]["type"];
				$file_size = $_FILES["upload-pro-pic"]["size"];
				$temp_name = $_FILES["upload-pro-pic"]["tmp_name"];

				$upload_to = "imj/profile_pictures/seekers/";

				$sep_name=explode(".",$file_name);//divided to two parts like befor . and after .

				$new_file_name = $seeker_id . "." . end($sep_name); //taking new name and conected file type

				//checking file type
				if ($file_type != "image/jpeg") {
						$errors[]="Image Msut Be jpg";
				}

				//checking file size
				if ($_FILES["upload-pro-pic"]["size"] > 1000000) {
					$errors[]="This Image Is Too Large";
				}

				if (empty($errors)) {

					clearstatcache();
					
					move_uploaded_file($temp_name, $upload_to . $new_file_name);//upload file
					$query = "UPDATE seeker SET is_image=1 WHERE seeker_id={$seeker_id}";
					$image=mysqli_query($connection,$query); 

					$_SESSION["is_image"] = 1;
				}
			}
		}*/

		if(isset($_POST['up_pic_nmae']) != null){


			if($_POST['up_pic_size'] != null){

				$fileSize = $_POST['up_pic_size']/1024;
				$upload_to = "imj/profile_pictures/seekers/";

				if($fileSize <= 500){


					$file_name = explode('.', $_POST['up_pic_nmae']);
					$lastString = array_pop($file_name);
					$newFilename =$seeker_id . "." . $lastString;
					
					$upload_image = explode(',', $_POST['up_pic']);

					$upload_ima = base64_decode($upload_image[1]);

					$is_upload = file_put_contents($upload_to . $newFilename, $upload_ima);

					if($is_upload){
						$query = "UPDATE seeker SET is_image=1 WHERE seeker_id={$seeker_id}";
						$image=mysqli_query($connection,$query); 

						$_SESSION["is_image"] = 1;
					}

				}
				else{
					$errors[] = "This Image Is Too Large";
				}

			}
		}




		if (empty($errors)) {
			
			$query1 = "UPDATE seeker SET first_name = '{$first_name}',last_name='{$last_name}',username='{$user_name}',qualification='{$qualification}',email='{$email}',phone_number='{$phone_number}' WHERE seeker_id = '{$seeker_id}'";

			$query2 = "UPDATE cv SET address='{$address}',birth_day='{$dob}' WHERE user_id = '{$seeker_id}'";

			$query3 = "UPDATE sh_media SET facebook='{$facebook}',twitter='{$twitter}',linked_in='{$linked_in}',git_hub='{$github}' WHERE user_id = {$seeker_id}";

			$result_set1 = mysqli_query($connection,$query1);

			$result_set2 = mysqli_query($connection,$query2);

			$result_set3 = mysqli_query($connection,$query3);

			if ($result_set1 && $result_set2 && $result_set3) {

				//set session again 
				$_SESSION["qualifi"] = $qualification;
				
				//cheking is have a cv

				$query="SELECT * FROM cv WHERE user_id = {$seeker_id}";

				$result = mysqli_query($connection,$query);

				//if it is not 
					if (mysqli_num_rows($result)==0) {

						//update cv

						$query="INSERT INTO cv (user_id,first_name,last_name,email,phone_number,address,birth_day,is_deleted) VALUES ('{$seeker_id}','{$first_name}','{$last_name}','{$email}','{$phone_number}','{$address}','{$dob}',0)";

						$result_set= mysqli_query($connection,$query);


						$query_sh = "INSERT INTO sh_media(user_id,linked_in,facebook,twitter,git_hub) VALUES ('{$seeker_id}','{$linked_in}','{$facebook}','{$twitter}','{$github}')";
						$result_set_sh = mysqli_query($connection,$query_sh);

					}

					//showing an alert
					echo "<script>";
						echo "alert('Profile Updated')";
					echo "</script>";
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

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.css"><!--croper style-->

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/seekerdashboard-ema-media.css"><!--media-queries>-->
	<link rel="stylesheet" href="css/media-queries/seekerdashboardheader.css"><!--media-queries>-->
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
				<li class="active"><i class="fas fa-caret-down"></i><a href="seekerdashboard-ema.php">Edi My Account</a></li>
				<li><i class="fas fa-caret-down"></i><a href="seekerdashboard-mycv.php">My CV</a></li>
				<li class="drop-down"><i class="fas fa-caret-down"></i>Account Settings
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

		<div class="account-settings-content">
			<div class="header">
				<h1>Edit My Account</h1>
			</div>
			<div class="first_set">
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
				<form action="seekerdashboard-ema.php" method="post" enctype="multipart/form-data">
	
				<div class="row2">
	
						<div class="upload-pro-pic">
							<input type="file" name="upload-pro-pic" id="upload-pro-pic">
							<label id="Uplod_pic" for="upload-pro-pic">Upload Profile Picture</label>
						</div>
	
						<div class="update_pic">
							
							<div class="imj-canvas" id="imj-canvas">
								<canvas id="canvas">
									
								</canvas>
								<button type="button" id="crop">Crop</button>
							</div>
							<div class="croped_pic">
								
							</div>
	
							<!-- getting file name and file -->
							<input type="hidden" name="up_pic_nmae" id="up_pic_nmae">
							<input type="hidden" name="up_pic" id="up_pic">
							<input type="hidden" name="up_pic_size" id="up_pic_size">
	
						</div><!-- update_pic -->
	
						<div class="incont">
							<p>
								<label for="">Your First Name</label>
								<input type="text" name="first_name" value="<?php echo $first_name; ?>" >
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
								<label for="">Date Of Birth</label>
								<input type="date" name="dob"value="<?php echo $dob; ?>" >
							</p>
							<div class="radi">
								<label for="">Qualification</label>
								<div class="rad_but">
									<label for="ol">O/L</label>
									<input type="radio" name="qualifi" id="ol" value="o/l" <?php if($qua=='o/l'){echo 'checked';} ?>>
									<label for="al">A/L</label>
									<input type="radio" name="qualifi" id="al" value="a/l" <?php if($qua=='a/l'){echo 'checked';} ?>>
									<label for="deg">Degree</label>
									<input type="radio" name="qualifi" id="deg" value="degree" <?php if($qua=='degree'){echo 'checked';} ?>>
									<label for="no">No Minimum Qualification</label>
									<input type="radio" name="qualifi" id="no" value="no minimum qualification" <?php if($qua=='no'){echo 'checked';} ?> >
								</div>	
							</div>
							<p>
								<label for="">Email</label>
								<input type="email" name="email"value="<?php echo $email; ?>" >
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
				</div>
			</div>
			<div class="second_set">
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
			</div>
				<div class="e-pro-but">
					<input type="submit" name="save" value="Save Settings">
				</div>
			</form>
		</div>
		
	</div><!--section-->

<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.js"></script>
	<!--<script src="js/dashboardcontent.js"></script>-->

	<script src="js/view_and_crop.js"></script>

</body>
<?php mysqli_close($connection); ?>
</html>