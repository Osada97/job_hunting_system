<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 
	
	$company_name = $_SESSION["company_name"];
	$company_registration_number=$_SESSION["company_registration_number"];

	if (!isset($_SESSION["company_registration_number"])) {
		header("location:index.php");
	}
 ?>

 <?php  

 	$company="";
 	$date_of_founded="";
 	$address="";
 	$phone_number="";
 	$company_website="";
 	$description="";

 	$email="";
 	$facebook="";
 	$twitter="";
 	$linked_in="";

 	$query="SELECT * FROM provider WHERE company_registration_number='{$company_registration_number}' AND is_deleted=0 LIMIT 1";

 	$result_set = mysqli_query($connection,$query);

 	if (mysqli_num_rows($result_set)==1) {
 		
 		$info = mysqli_fetch_assoc($result_set);

 			$company=$info["company_name"];
	 		$company_registration_number=$info["company_registration_number"];
	 		$date_of_founded=$info["date_of_founded"];
	 		$address=$info["address"];
	 		$phone_number=$info["company_phone_number"];
	 		$company_website=$info["company_website"];
	 		$description=$info["description"];
 			$email=$info["company_email"];
 			$facebook=$info["facebook"];
 			$twitter=$info["twitter"];
 			$linked_in=$info["linked_in"];
 	}
 	else{
 		printf(mysqli_error($connection));
 	}

 ?>

 <?php  

 		$errors=array();

 	if (isset($_POST["save"])) {
 		
 		if (empty(trim($_POST["company"]))) {
 				$errors[]="Company Name Is Required";
 		}
 		if (empty(trim($_POST["company_registration_number"]))) {
 				$errors[]="Company Registraion Number Is Required";
 		}
 		if (empty(trim($_POST["date_of_founded"]))) {
 				$errors[]="Date Of Founded Is Required";
 		}
 		if (empty(trim($_POST["address"]))) {
 				$errors[]="Company Address Is Required";
 		}
 		if (empty(trim($_POST["phone_number"]))) {
 				$errors[]="Company Phone Number Is Required";
 		}
 		if (empty(trim($_POST["email"]))) {
 				$errors[]="Company Email Is Required";
 		}


 		$max_len_fields=array("company" =>50,"company_registration_number" =>50,"date_of_founded" =>50,"address" =>200,"email" =>50,"phone_number" =>20,"date_of_founded" =>50,"description" =>1000,"company_website" =>500,"facebook" =>100,"twitter" =>100,"linked_in"=>100);

 			foreach ($max_len_fields as $fields => $value) {
 				if (strlen(trim($_POST[$fields])) > $value) {
 					$errors[] = $fields . " Must be less than " . $value;
 				}
 			}

 		$company= mysqli_real_escape_string($connection,$_POST["company"]);
 		$company_registration_number= mysqli_real_escape_string($connection,$_POST["company_registration_number"]);
 		$date_of_founded= mysqli_real_escape_string($connection,$_POST["date_of_founded"]);
 		$address= mysqli_real_escape_string($connection,$_POST["address"]);
 		$phone_number= mysqli_real_escape_string($connection,$_POST["phone_number"]);
 		$company_website= mysqli_real_escape_string($connection,$_POST["company_website"]);
 		$description= mysqli_real_escape_string($connection,$_POST["description"]);
 		$email= mysqli_real_escape_string($connection,$_POST["email"]);
 		$facebook= mysqli_real_escape_string($connection,$_POST["facebook"]);
 		$twitter= mysqli_real_escape_string($connection,$_POST["twitter"]);
 		$linked_in= mysqli_real_escape_string($connection,$_POST["facebook"]);

 		$query = "SELECT company_name,company_email FROM provider WHERE company_registration_number!='{$company_registration_number}'AND is_deleted=0 ";

 		$result_set=mysqli_query($connection,$query);
 		
 		if (mysqli_num_rows($result_set)>=1) {
 			
 			while ($presult=mysqli_fetch_assoc($result_set)){

	 			if (strtoupper($company) == strtoupper($presult["company_name"])) {
	 				$errors[]="Company Name Is Already Exsits";
	 			}
	 			if (strtoupper($email) == strtoupper($presult["company_email"])) {
	 				$errors[]="Company Email Is Already Exsits";
	 			}
 			}
 		}

 		//uploading file 
 		/*if ($_FILES["upload-provider-pic"]["name"]) {
 			if ($_FILES["upload-provider-pic"]["error"]==0) {
 				
 				$file_name = $_FILES["upload-provider-pic"]["name"];
 				$file_type = $_FILES["upload-provider-pic"]["type"];
 				$file_size = $_FILES["upload-provider-pic"]["size"];
 				$temp_name = $_FILES["upload-provider-pic"]["tmp_name"];

 				$upload_to = "imj/profile_pictures/providers/";

 				$sp_file_name = explode(".", $file_name);

 				$new_file = $company_registration_number . "." . end($sp_file_name);

 				if ($file_type!="image/jpeg") {
 					$errors[]="Image Must Be jpeg";
 				}

 				//checking file size
				if ($_FILES["upload-pro-pic"]["size"] > 1000000) {
					$errors[]="This Image Is Too Large";
				}


 				if (empty($errors)) {
 					move_uploaded_file($temp_name, $upload_to . $new_file);

 					$provider_pic = "UPDATE provider SET is_image=1 WHERE company_registration_number='{$company_registration_number}'";

 					$result_provider_pic=mysqli_query($connection,$provider_pic);

 					$_SESSION["is_image_pro"]=1;

 					clearstatcache();//use for clear cash its because when sometimes browser provide privous result cause of storing cash(eg:file upload)
 				}
 				else{
 					$errors[]="Canot Upload This Image";
 				}

 			}
 			else{
 				$errors[]="Canot Upload This Image";
 			}
 		}*/

 		if(isset($_POST['up_file_name'])!= null){

 			if ($_POST['up_file_size'] != null) {
 				
 				$file_size = $_POST['up_file_size']/1024;
 				$upload_to = "imj/profile_pictures/providers/";

 				if($file_size <= 500){

 					$file_name = explode('.', $_POST['up_file_name']);
 					$new_file_name = $company_registration_number . "." . array_pop($file_name);

 					$upload_image = explode(',', $_POST['up_pic']);
 					$upload_ima = base64_decode($upload_image[1]);

 					$is_image = file_put_contents($upload_to . $new_file_name, $upload_ima);

 					if($is_image){
 						$provider_pic = "UPDATE provider SET is_image=1 WHERE company_registration_number='{$company_registration_number}'";

	 					$result_provider_pic=mysqli_query($connection,$provider_pic);

	 					$_SESSION["is_image_pro"]=1;
 					}
 				}
 				else{
 					$errors[] = "File Is Too Large";
 				}

 			}
 		}


 		
 		if (empty($errors)) {
 			
 			$query = "UPDATE provider SET company_name='{$company}',date_of_founded='{$date_of_founded}',address='{$address}',company_phone_number='{$phone_number}',company_website='{$company_website}',description='{$description}',company_email='{$email}',facebook='{$facebook}',twitter='{$twitter}',facebook='{$facebook}' WHERE company_registration_number='{$company_registration_number}' ";

 			$result_set = mysqli_query($connection,$query);

 			if ($result_set) {
 				
 			}
 			else{
 				$errors[]="Query Failed";
 				printf(mysqli_error($connection));
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
	<link rel="stylesheet" href="css/provider_dashboard_ema.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>
	<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.css"><!--croper style-->

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/providerDashboard-header-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/providerDashboard-ema-media.css"><!--media query-->
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
		<div class="ed-account">
			<div class="row1">
				<h1>Edit My Account</h1>
			</div>
			<div class="errors">
				<p>
					<?php 
						foreach ($errors as $value) {
							echo $value . "<br>";
						}
					 ?>
				</p>
			</div>
			<form action="providerdashboard-ema.php" method="post" enctype="multipart/form-data">
				<div class="row2">
					<h2>Basic Information</h2>

					<div class="upload-pic" id="upload-pic">
						<input type="file" name="upload-provider-pic" id="upload-provider-pic">
						<label for="upload-provider-pic">Upload Profile Picture</label>
					</div>
	
					<div class="pro_img_cropper">
						
						<div class="imj-canvas" id="imj-canvas">
							<canvas id="canvas">
								
							</canvas>
							<button type="button" id="crop">Crop</button>
						</div>
						
						<!-- class for preview croped image -->
						<div class="preview">
							
						</div>

						<!-- input for get value -->
						<input type="hidden" name="up_file_name" id="up_file_name">
						<input type="hidden" name="up_file_size" id="up_file_size">
						<input type="hidden" name="up_pic" id="up_pic">

					</div><!-- pro_img_cropper -->
					
					<div class="sect">
						<p>
							<label for="">Company Name</label>
							<input type="text" name="company" value="<?php echo $company ?>">
						</p>
						<p>
							<label for="">Company Registraion Number</label>
							<input type="text" name="company_registration_number" value="<?php echo $company_registration_number ?>" readonly>
						</p>
					</div>
					<div class="sect">
						<p>
							<label for="">Date Of Founded</label>
							<input type="date" name="date_of_founded" value="<?php echo $date_of_founded ?>">
						</p>
	
						<p>
							<label for="">Address</label>
							<input type="text" name="address" value="<?php echo $address ?>">
						</p>
					</div>
					<div class="sect">
						<p>
							<label for="">Phone Number</label>
							<input type="text" name="phone_number" value="<?php echo $phone_number ?>">
						</p>
						<p>
							<label for="">Company Website Url</label>
							<input type="text" name="company_website" value="<?php echo $company_website ?>">
						</p>
					</div>
					<p><label for="">Description</label>
						<textarea name="description" id="" cols="121" rows="10"><?php echo $description; ?></textarea>
					</p>
				</div>
				<div class="row3">
					<h2>Social Links</h2>
					
					<div class="sect">
						<p>
							<label for="">Email</label>
							<input type="email" name="email" value="<?php echo $email ?>">
						</p>
						<p>
							<label for="">Facebook</label>
							<input type="text" name="facebook" value="<?php echo $facebook ?>">
						</p>
					</div>
					<div class="sect">
						<p>
							<label for="">Twitter</label>
							<input type="text" name="twitter" value="<?php echo $twitter ?>">
						</p>
						<p>
							<label for="">Lined In</label>
							<input type="text" name="linked_in" value="<?php echo $linked_in ?>">
						</p>
					</div>
				</div>
				<div class="row4">
					<div class="s-but">
						<input type="submit" name="save" value="Save Settings">
					</div>
				</div>
			</form>
		</div>
	</div><!--section-->

<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>

	<script>
		CKEDITOR.replace('description' ,{width:'100%', contentsCss : 'body{background:#fff;}'});
	</script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.js"></script>
	<script src="js/provider_view_and_crop.js"></script>

</body>
<?php mysqli_close($connection); ?>
</html>