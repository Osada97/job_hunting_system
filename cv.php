<?php ob_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php

	/*if ((!isset($_GET["seeker_id"])) || ($_GET["add_user"]!=true)) {
		header("location:index.php");
	}*/

	if (isset($_GET["seeker_id"])) {
		$seeker_id=$_GET["seeker_id"];
	}
	else{
		header("location:index.php");
	}


	$query="SELECT * FROM seeker WHERE seeker_id={$seeker_id} LIMIT 1";

	$result=mysqli_query($connection ,$query);

	if ($result) {
		if (mysqli_num_rows($result)==1) {
			$details = mysqli_fetch_assoc($result);

			$first_name=$details["first_name"];
			$last_name=$details["last_name"];
			$email=$details["email"];
			$phone_number=$details["phone_number"];
			$is_image=$details["is_image"];
		}
		else{
			header("location:index.php");
		}
	}
	else{

			header("location:index.php");	
	}

	$errors=array();

	$title1="";
	$summery="";	
	$address="";
	$birtthday="";
	$LinkedIN="";
	$Facebook="";
	$twitter="";
	$git="";
	$education_title="";
	$education_year="";
	$education_institute="";
	$education_description="";
	$work_title="";
	$work_name="";
	$work_year="";
	$description="";
	$professional_title1="";
	$professional_precenage1="";
	$professional_title2="";
	$professional_precenage2="";
	$professional_title3="";
	$professional_precenage3="";
	$award_title="";
	$award_institute="";
	$awards_year="";
	$award_description="";

	if(isset($_POST["submit"])){


		$first_name=$_POST["firstname"];
		$last_name=$_POST["lastname"];
		$title1=$_POST["title1"];
		$summery=$_POST["summery"];
		$email=$_POST["email"];
		$phonenumber=$_POST["phonenumber"];
		$address=$_POST["address"];
		$birtthday=$_POST["birtthday"];
		$LinkedIN=$_POST["LinkedIN"];
		$Facebook=$_POST["Facebook"];
		$twitter=$_POST["twitter"];
		$git=$_POST["git"];
		$education_title=$_POST["education_title"];
		$education_year=$_POST["education_year"];
		$education_institute=$_POST["education_institute"];
		$education_description=$_POST["education_description"];
		$work_title=$_POST["work_title"];
		$work_name=$_POST["work_name"];
		$work_year=$_POST["work_year"];
		$description=$_POST["description"];
		$professional_title1=$_POST["professional_title1"];
		$professional_precenage1=$_POST["professional_precenage1"];
		$award_title=$_POST["award_title"];
		$award_institute=$_POST["award_institute"];
		$awards_year=$_POST["awards_year"];
		$award_description=$_POST["award_description"];

		if(isset($_POST["heading"])){
			$additional_heading=$_POST["heading"];
		}
		if(isset($_POST["title"])){
			$additional_title=$_POST["title"];
		}
		if(isset($_POST["date"])){
			$$additional_date=$_POST["date"];
		}
		if(isset($_POST["association"])){
			$additional_associ=$_POST["association"];
		}
		$additional_discription=$_POST["description"];


		foreach ($professional_precenage1 as $key => $value) {
			if ($value>0) {
				if(empty($professional_title1[$key])){
					$errors[] = "Please Enter Skill Name " . ++$key;
				}		
			}
		}

		if (empty(trim($first_name))) {
			$errors[]="Please Enter First Name";
		}
		if (empty(trim($last_name))) {
			$errors[]="Please Enter Last Name";
		}
		if (empty(trim($title1))) {
			$errors[]="Please Enter Professional Title";
		}
		if (empty(trim($email))) {
			$errors[]="Please Enter Email";
		}
		if (empty(trim($address))) {
			$errors[]="Please Enter Address";
		}
		if (empty(trim($phonenumber))) {
			$errors[]="Please Enter Phone Number";
		}
		if (empty(trim($birtthday))) {
			$errors[]="Please Enter Your Birth Day";
		}

		//uploading profile picture

		if(isset($_POST['cv_pic_name'])!= null){

			if($_POST['cv_pic_size'] != null){

				$size = $_POST['cv_pic_size']/1024;
				$upload_to = "imj/profile_pictures/seekers/";

				if($size <= 500){
					$file_name = explode('.',$_POST['cv_pic_name']);
					$new_file_name = $seeker_id ."." . array_pop($file_name);

					$pro_pic = explode(',',$_POST['cv_pic']);
					$new_pro_pic = base64_decode($pro_pic[1]);

					$is_upload = file_put_contents($upload_to . $new_file_name, $new_pro_pic);

					if($is_upload){
						
						$query_to_is_image="UPDATE seeker SET is_image=1 WHERE seeker_id = {$seeker_id}";

						$result_is_image = mysqli_query($connection,$query_to_is_image);

					}
				}
				else{
					$errors[] = "Picture Is Too Large";
				}

			}

		}

		
		if (empty($errors)) {

			$first_name=mysqli_real_escape_string($connection,$_POST["firstname"]);
			$last_name=mysqli_real_escape_string($connection,$_POST["lastname"]);
			$title1=mysqli_real_escape_string($connection,$_POST["title1"]);
			$summery=mysqli_real_escape_string($connection,$_POST["summery"]);
			$email=mysqli_real_escape_string($connection,$_POST["email"]);
			$phonenumber=mysqli_real_escape_string($connection,$_POST["phonenumber"]);
			$address=mysqli_real_escape_string($connection,$_POST["address"]);
			$birtthday=mysqli_real_escape_string($connection,$_POST["birtthday"]);

			$LinkedIN=mysqli_real_escape_string($connection,$_POST["LinkedIN"]);
			$Facebook=mysqli_real_escape_string($connection,$_POST["Facebook"]);
			$twitter=mysqli_real_escape_string($connection,$_POST["twitter"]);
			$git=mysqli_real_escape_string($connection,$_POST["git"]);


			
			$query_ins_ma ="INSERT INTO CV(user_id,first_name,last_name,title,description,email,phone_number,address,birth_day) VALUES ({$seeker_id},'{$first_name}','{$last_name}','{$title1}','{$summery}','{$email}','{$phone_number}','{$address}','{$birtthday}')";
			$result_ins_ma = mysqli_query($connection,$query_ins_ma);

			if($result_ins_ma){
				//uploading sh media
				$querY_sh = "INSERT INTO sh_media(user_id,linked_in,facebook,twitter,git_hub) VALUES({$seeker_id},'{$LinkedIN}','{$Facebook}','{$twitter}','{$git}')";
				$result_sh = mysqli_query($connection,$querY_sh);


				//checking education isset title?

				for ($i=0; $i <count($education_title); $i++) { 
					
					if(!empty($education_title[$i])){

						$query_ed ="INSERT INTO education(user_id,edu_title,edu_year,edu_institute,edu_description) VALUES({$seeker_id},'".mysqli_real_escape_string($connection,$education_title["$i"])."','".mysqli_real_escape_string($connection,$education_year["$i"])."','".mysqli_real_escape_string($connection,$education_institute["$i"])."','".mysqli_real_escape_string($connection,$education_description["$i"])."')";
						$result_ed=mysqli_query($connection,$query_ed);
					}

				}

				//checking worrl isset title?

				for ($i=0; $i <count($work_title); $i++) { 
					
					if(!empty($work_title[$i])){

						$query_wk ="INSERT INTO work_experience(user_id,wk_title,wk_company,wk_years,wk_description) VALUES({$seeker_id},'".mysqli_real_escape_string($connection,$work_title["$i"])."','".mysqli_real_escape_string($connection,$work_name["$i"])."','".mysqli_real_escape_string($connection,$work_year["$i"])."','".mysqli_real_escape_string($connection,$description["$i"])."')";
						$result_wk=mysqli_query($connection,$query_wk);
					}
				}

				//checking pofessional Skills isset?
				if(!empty($professional_title1)){

					for ($i=0; $i <count($professional_title1) ; $i++) {

						if(!empty($professional_title1[$i])){
							$query_pt ="INSERT INTO professional_skills(user_id,title,percentage) VALUES({$seeker_id},'{$professional_title1["$i"]}','{$professional_precenage1["$i"]}')";
							$result_pt=mysqli_query($connection,$query_pt);
						}
						
					}
				}
				//checking worrl isset title?

				for ($i=0; $i <count($award_title) ; $i++) { 
					
					if (!empty($award_title[$i])) {
						$query_aw ="INSERT INTO awards(user_id,aw_title,aw_institute,aw_year,aw_description) VALUES({$seeker_id},'".mysqli_real_escape_string($connection,$award_title["$i"])."','".mysqli_real_escape_string($connection,$award_institute["$i"])."','".mysqli_real_escape_string($connection,$awards_year["$i"])."','".mysqli_real_escape_string($connection,$award_description["$i"])."')";
						$result_aw=mysqli_query($connection,$query_aw);
					}
				}

				//checking additional information heading title isset
				if(isset($additional_heading)){
					for($i=0;$i<count($additional_heading);$i++){

						if(!empty($additional_heading[$i])){
							if(!empty($additional_title[$i])){
								$query_addi = "INSERT INTO additional_cv(user_id,chs_headings,chs_title,chs_date,chs_company,chs_description) VALUES ({$seeker_id},'".mysqli_real_escape_string($connection,$additional_heading["$i"])."','".mysqli_real_escape_string($connection,$additional_title["$i"])."','".mysqli_real_escape_string($connection,$additional_date["$i"])."','".mysqli_real_escape_string($connection,$additional_associ["$i"])."','".mysqli_real_escape_string($connection,$additional_discription["$i"])."' )";
								$result_addi = mysqli_query($connection,$query_addi);
							}
						}

					}
				}
				
				header('Location:mainlogin.php');
				
			}
		}
		
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create CV</title>
	<link rel="shortcut icon" type="image/jpg" href="imj/icon/fav.png"/>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/cv.css">
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /><!--style sheet for scroll animation-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.css"><!--croper style-->
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>
	<script src="//cdn.ckeditor.com/4.14.0/basic/ckeditor.js"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/index-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/cv-media.css"><!--media query -->
</head>
<body>
	<?php require_once("inc/header.php") ?>

	<div class="model_page">
		<div class="crop_area">
			<div class="close">
				<button id="close"><i class='fas fa-times'></i></button>
			</div>
			<div class="cropper_image">
				<canvas id="canvas"></canvas>
			</div>
			<div class="cr_button">
				<button type="button" id="crop">Crop</button>
			</div>
		</div>
	</div><!-- model page for crop picture -->

	<div class="main">
		<div class="create">
			<h1>Create My CV</h1>
		</div>
		<form action="cv.php?seeker_id=<?php echo $seeker_id; ?>" method="post" enctype="multipart/form-data">
		<div class="cv">
			<div class="row1">
				<div class="column">
					<input type="hidden" name="seeker_id" value="<?php echo $seeker_id; ?>">
					<input type="text" name="firstname" placeholder="Eter First Name" value="<?php echo $first_name; ?>">
					<input type="text" name="lastname" placeholder="Eter Last Name" value="<?php echo $last_name; ?>">
					<p>
					<input type="text" name="title1" placeholder="Eter Title" value="<?php echo $title1; ?>">
					</p>
					<p>
						<textarea name="summery" placeholder="Enter Summery" cols="30" rows="10" maxlength="100"><?php echo $summery; ?></textarea>
					</p>
				</div>
				<div class="column">
					<div class="up_cv_pic">
						<div class="cv-pic">
							<?php 

								if ($is_image==0) {
									echo "<img src=\"imj/profile_pictures/default.jpg\">";
								}
								else{
									echo "<img src=\"imj/profile_pictures/seekers/" . $seeker_id . ".jpg\">";
								}

							 ?>

							 	<!-- use for load croped Image -->
								<div class="croped_pic">
									<input type="hidden" name="cv_pic_name" id="cv_pic_name">
									<input type="hidden" name="cv_pic_size" id="cv_pic_size">
									<input type="hidden" name="cv_pic" id="cv_pic">
								</div>

						 </div>
						 <div class="up-but">
								<input type="file" name="upload-pic" id="upload-pic">
								<label for="upload-pic"><i class="fas fa-pencil-alt"></i></label>
						</div>
					</div>
				</div>
				<div class="column">
					<p>
					<input type="email" name="email" placeholder="Enter Email" value="<?php echo $email ?>"><i class="fas fa-envelope"></i>
					</p>
					<p>
					<input type="text" name="phonenumber" placeholder="Enter Phone Number" value="<?php echo $phone_number ?>"><i class="fas fa-phone"></i>
					</p>
					<p>
					<input type="text" name="address" placeholder="Enter Address" value="<?php echo $address; ?>"><i class="fas fa-map-marker"></i>
					</p>
					<p>
					<input type="date" name="birtthday" placeholder="Enter Your Birth Day" value="<?php echo $birtthday ?>"><i class="far fa-calendar-alt"></i>
					</p>
					<p>
					<input type="text" name="LinkedIN" placeholder="LinkedIN" value="<?php echo $LinkedIN ?>"><i class="fab fa-linkedin"></i>
					</p>
					<p>
					<input type="text" name="Facebook" placeholder="Facebook " value="<?php echo $Facebook ?>"><i class="fab fa-facebook"></i>
					</p>
					<p>
					<input type="text" name="twitter" placeholder="Twitter" value="<?php echo $twitter ?>"><i class="fab fa-twitter"></i>
					</p>
					<p>
					<input type="text" name="git" placeholder="GitHub" value="<?php echo $git ?>"><i class="fab fa-github"></i>
					</p>
				</div>
			</div>
			
					<?php 
						if (!empty($errors)) {
							echo "<div class=\"errors\">";
							foreach ($errors as $value) {
							echo "<p>" . $value . "</p>";
							}
							echo "</div>";
						}
					 ?>
			<!-- additional section -->
			<div class="additional_sect">
				<div class="additional_row">
					<button type="button" id="addAdditional">Add Additional Information</button>
				</div>

				<div class="additional_form">
					<!-- dynamically loaded -->
				</div>

			</div>
			<div class="row2">
					<div class="row">
						<fieldset class="ed_fl">
							<legend><h1>Education</h1></legend>
							<div class="add_row">
								<button class="ad_sk ad_ed" type="button"><i class="fas fa-plus"></i></button>
							</div>
							<div class="ed_fl_row">
								<p>
									<label for="">Title</label>
									<input type="text" name="education_title[]" value="">
								</p>
								<p>
									<label for="">Year</label>
									<input type="month" name="education_year[]" value="">	
								</p>
								<p>
									<label for="">Institute</label>
									<input type="text" name="education_institute[]" value="">
								</p>
								<p>
									<label for="">Description</label>
									<textarea name="education_description[]" class="des" maxlength="500"></textarea>
								</p>	
							</div>

						</fieldset>
					</div>
					<div class="row">
						<fieldset class="we_fl">
							<legend><h1>Work & Experience</h1></legend>
							<div class="add_row">
								<button class="ad_sk ad_we" type="button"><i class="fas fa-plus"></i></button>
							</div>
							<div class="we_fl_row">
								<p>
									<label for="">Title</label>
									<input type="text" name="work_title[]" value="">
								</p>
								<p>
									<label for="">Company Name</label>
									<input type="text" name="work_name[]" value="">
								</p>
								<p>
									<label for="">Year</label>
									<input type="month" name="work_year[]" value="">	
								</p>
								
								<p>
									<label for="">Description</label>
									<textarea name="description[]" cols="30" rows="10" maxlength="500"></textarea>
								</p>
							</div>

						</fieldset>

					</div>
					<div class="row">
						<fieldset>
							<legend><h1>Professional Skill</h1></legend>
							<div class="add_row">
								<button class="ad_sk" id="ad_sk" type="button"><i class="fas fa-plus"></i></button>
							</div>

							<div class="skills">
								<div class="sk_row">
									<p>
										<label for="">Title</label>
										<input type="text" name="professional_title1[]">
									</p>
										<div class="prc">
											<div class="twopc">
												<label for="">Percentage</label>
												<input type="range" name="professional_precenage1[]" min="0" max="100" value="0" id="get1" oninput="scrol(event)">
											</div>
											<div class="twopcs">
												<input class="range_box" type="text" id="valu1" min="0" max="100" value="0" oninput="just1()">
												<span>%</span>
												<button type="button" class="butdl" onclick="dl_row(event)"><i class="fas fa-trash"></i></button>
											</div>
										</div>
								</div>
							</div>

						</fieldset>

					</div>
					<div class="row">
						<fieldset class="aw_fl">
							<legend><h1>Awards</h1></legend>
							<div class="add_row">
								<button class="ad_sk ad_aw" type="button"><i class="fas fa-plus"></i></button>
							</div>
							<div class="aw_fl_row">
								<p>
									<label for="">Title</label>
									<input type="text" name="award_title[]" value="">
								</p>
								<p>
									<label for="">Institute</label>
									<input type="text" name="award_institute[]" value="">	
								</p>
								<p>
									<label for="">Year</label>
									<input type="month" name="awards_year[]" value="">	
								</p>
								<p>
									<label for="">Description</label>
									<textarea name="award_description[]" cols="30" rows="10" maxlength="500"></textarea>
								</p>	
							</div>

						</fieldset>
					</div>
			</div>
			
			<div class="row3">
				<div class="cvbut">
					<input type="submit" name="submit" value="Submit CV">
				</div>
				<a href="mainlogin.php?ac=se" class="skip">Skip<i class="fas fa-arrow-right"></i></a>
			</div>
			

		</div>
		</form>
	</div>
	
<footer>
	<?php require_once("inc/footer.php"); ?>
</footer>

	<script src="js/srange.js"></script>
	
	<script src="https://unpkg.com/aos@next/dist/aos.js"></script><!--scroll animation-->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.js"></script>

	<script>
			//for scroll animation
	    AOS.init({
	    	offset:250,
	    	duration:700,
	    });
	</script>

	<script src="js/cv_pro_pic.js"></script><!-- cv Profile picture cropper-->
	<script src="js/generate_fields.js">//for generate fields</script>	

</body>
<?php mysqli_close($connection); ?>
</html>