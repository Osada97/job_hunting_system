<?php ob_start() ?>
<?php require_once("inc/connection.php"); ?>
<?php session_start(); ?>
<?php  

	$seeker_username = $_SESSION["username"];
	$seeker_id =$_SESSION["seeker_id"];

	if (!isset($seeker_id)) {
		header("location:index.php");
	}

?>

<?php  

	//display messages
	if(isset($_GET['msg'])){
		$message = $_GET['msg'];

		if($message == "cv_not_complete"){
			echo "<script>";
				echo "alert('Can Not Apply For Job, Please Fill CV')";
			echo "</script>";
		}
		else if($message == 'create_cv_first'){
			echo "<script>";
				echo "alert('Please Create CV Before Apply For Job')";
			echo "</script>";
		}
	}

?>

<?php 

	$ed_pr="";
	$we_pr="";
	$aw_pr="";
	$sk_pr="";
	$addi_pr="";

	$email="";
			$phonenumber="";
			$address="";
			$birthday="";
			$linkedIN="";
			$facebook="";
			$twitter="";
			$git="";

	$query="SELECT * FROM cv WHERE user_id='{$seeker_id}' LIMIT 1";
	$query_sh="SELECT * FROM sh_media WHERE user_id='{$seeker_id}' LIMIT 1";
	$query_aw = "SELECT * FROM awards WHERE user_id='{$seeker_id}'";
	$query_ed = "SELECT * FROM education WHERE user_id='{$seeker_id}'";
	$query_we = "SELECT * FROM work_experience WHERE user_id='{$seeker_id}'";
	$query_sk = "SELECT * FROM professional_skills WHERE user_id='{$seeker_id}'";
	$query_addi = "SELECT * FROM additional_cv WHERE user_id='{$seeker_id}'";

	$result_set = mysqli_query($connection,$query);
	$result_set_sh = mysqli_query($connection,$query_sh);
	$result_set_aw = mysqli_query($connection,$query_aw);
	$result_set_ed = mysqli_query($connection,$query_ed);
	$result_set_we = mysqli_query($connection,$query_we);
	$result_set_sk = mysqli_query($connection,$query_sk);
	$result_set_addicv = mysqli_query($connection,$query_addi);

	if (mysqli_num_rows($result_set)==1) {
		
		$result = mysqli_fetch_assoc($result_set);

		$is_deleted=$result["is_deleted"];

		if ($is_deleted==0) {
			
			$firstname=$result["first_name"];
			$lastname=$result["last_name"];
			$title=$result["title"];
			$description=$result["description"];

			$email=$result["email"];
			$phonenumber=$result["phone_number"];
			$address=$result["address"];
			$birthday=$result["birth_day"];

			if(mysqli_num_rows($result_set_sh)==1){

				$sh_result = mysqli_fetch_assoc($result_set_sh);

				$linkedIN=$sh_result["linked_in"];
				$facebook=$sh_result["facebook"];
				$twitter=$sh_result["twitter"];
				$git=$sh_result["git_hub"];
			}

			if(mysqli_num_rows($result_set_ed)>0){

				while ($aw_result = mysqli_fetch_assoc($result_set_ed)) {

					$education_title=$aw_result["edu_title"];
					$education_year=$aw_result["edu_year"];
					$education_institute=$aw_result["edu_institute"];
					$education_description=$aw_result["edu_description"];
					$no = $aw_result["no"];

					$ed_pr .= '<div class="ed_fl_row">';

					$ed_pr .= '<div class="buttoned">';
					$ed_pr .= '<button type="button" id="sh_ed" onclick="showform(event)"><i class="fas fa-pencil-alt"></i></button>';
					$ed_pr .= '<button type="button" id="dl_ed" onclick="dl_ed(event),deletefr('.$no.',\'ed\')"><i class="far fa-trash-alt"></i></button>';
					$ed_pr .= '</div>';

					$ed_pr .= '<div class="content">';
					$ed_pr .='<h5>'.$education_year.'</h5>';
					$ed_pr .= '<h2>'.$education_title.'</h2>';
					$ed_pr .= '<h3>'.$education_institute.'</h3>';
					$ed_pr .= '<h4>'.$education_description.'</h4>';
					$ed_pr .= '</div>';

					$ed_pr .= '<div class="ed_form e_form">';
					$ed_pr .= '<form action="seekerdashboard-ecv.php" method="POST">';
					$ed_pr .= '<p>';
					$ed_pr .= '<input type="hidden" name="no" value="'.$no.'"';
					$ed_pr .= '<label for="">Title</label>';
					$ed_pr .= '<input type="text" name="education_title" value="'.$education_title.'">';
					$ed_pr .= '</p>';
					$ed_pr .= '<p>';
					$ed_pr .= '<label for="">Year</label>';
					$ed_pr .= '<input type="month" name="education_year" value="'.$education_year.'">';
					$ed_pr .= '</p>';
					$ed_pr .= '<p>';
					$ed_pr .= '<label for="">Institute</label>';
					$ed_pr .= '<input type="text" name="education_institute" value="'.$education_institute.'">';
					$ed_pr .= '</p>';
					$ed_pr .= '<p>';
					$ed_pr .= '<label for="">Description</label>';
					$ed_pr .= '<textarea name="education_description" maxlength="500">'.$education_description.'</textarea>';
					$ed_pr .= '</p>';
					$ed_pr .= '<input type="submit" name="ed_su" value="Add">';
					$ed_pr .= '</form>';
					$ed_pr .= '</div>';
					$ed_pr .= '</div>';
				}

			}

			if(mysqli_num_rows($result_set_we)>0){

				while ($we_result = mysqli_fetch_assoc($result_set_we)) {
					
					$work_title=$we_result["wk_title"];
					$work_company=$we_result["wk_company"];
					$work_year=$we_result["wk_years"];
					$work_description=$we_result["wk_description"];
					$no = $we_result["no"];

					$we_pr .= '<div class="we_row">';

					$we_pr .= '<div class="buttoned">';
					$we_pr .= '<button type="button" id="sh_we" onclick="showform(event)"><i class="fas fa-pencil-alt"></i></button>';
					$we_pr .= '<button type="button" id="dl_we" onclick="dl_we(event),deletefr('.$no.',\'we\')"><i class="far fa-trash-alt"></i></button>';
					$we_pr .= '</div>';

					$we_pr .= '<div class="content">';
					$we_pr .='<h5>'.$work_year.'</h5>';
					$we_pr .= '<h2>'.$work_title.'</h2>';
					$we_pr .= '<h3>'.$work_company.'</h3>';
					$we_pr .= '<h4>'.$work_description.'</h4>';
					$we_pr .= '</div>';	

					$we_pr .= '<div class="we_form e_form">';
					$we_pr .= '<form action="seekerdashboard-ecv.php" method="POST">';
					$we_pr .= '<p>';
					$we_pr .= '<input type="hidden" name="wno" value="'.$no.'"';
					$we_pr .= '<label for="">Title</label>';
					$we_pr .= '<input type="text" name="work_title" value="'.$work_title.'">';
					$we_pr .= '</p>';
					$we_pr .= '<p>';
					$we_pr .= '<label for="">Institute</label>';
					$we_pr .= '<input type="text" name="work_company" value="'.$work_company.'">';
					$we_pr .= '</p>';
					$we_pr .= '<p>';
					$we_pr .= '<label for="">Year</label>';
					$we_pr .= '<input type="month" name="work_year" value="'.$work_year.'">';
					$we_pr .= '</p>';
					$we_pr .= '<p>';
					$we_pr .= '<label for="">Description</label>';
					$we_pr .= '<textarea name="work_description" maxlength="500">'.$work_description.'</textarea>';
					$we_pr .= '</p>';
					$we_pr .= '<input type="submit" name="we_su" value="Add">';
					$we_pr .= '</form>';
					$we_pr .= '</div>';
					$we_pr .= '</div>';
				}
			}

			if(mysqli_num_rows($result_set_sk)>0){

				while ($sk_result = mysqli_fetch_assoc($result_set_sk)) {

					$title1=$sk_result["title"];
					$percentage=$sk_result["percentage"];

					$sk_pr .= '<div class="sk_row">';
					$sk_pr .= '<p>';
					$sk_pr .= '<label for="">Title</label>';
					$sk_pr .= '<input type="text" name="professional_title1[]" value="'.$title1.'">';
					$sk_pr .= '<input type="hidden" name="skno[]" value="'.$sk_result['no'].'"';
					$sk_pr .= '</p>';
					$sk_pr .= '<div class="prc">';
					$sk_pr .= '<div class="twopc">';
					$sk_pr .= '<label for="">Percentage</label>';
					$sk_pr .= '<input type="range" name="professional_precenage1[]" min="0" max="100" class="range" id="get1" value="'.$percentage.'" oninput="scrol(event)">';
					$sk_pr .= '</div>';
					$sk_pr .= '<div class="twopcs">';
					$sk_pr .= '<input type="text" name="range_value_1" class="range_box" id="valu1" value="'.$percentage.'" oninput="just1()">';
					$sk_pr .= '<span>%</span>';
					$sk_pr .= '<button type="button" class="butdl" onclick="dl_row(event);deletesk('.$sk_result['no'].');"><i class="fas fa-trash"></i></button>';
					$sk_pr .= '</div>';
					$sk_pr .= '</div>';	
					$sk_pr .= '</div>';	
								
				}
			}


			if(mysqli_num_rows($result_set_aw)>0){

				while ($aw_result = mysqli_fetch_assoc($result_set_aw)) {

					$award_title=$aw_result["aw_title"];
					$award_institute=$aw_result["aw_institute"];
					$awards_year=$aw_result["aw_year"];
					$award_description=$aw_result["aw_description"];
					$no = $aw_result["no"];

					$aw_pr .= '<div class="aw_fl_row">';

					$aw_pr .= '<div class="buttoned">';
					$aw_pr .= '<button type="button" id="sh_ed" onclick="showform(event)"><i class="fas fa-pencil-alt"></i></button>';
					$aw_pr .= '<button type="button" id="dl_ed" onclick="dl_aw(event);deletefr('.$no.',\'aw\')"><i class="far fa-trash-alt"></i></button>';
					$aw_pr .= '</div>';

					$aw_pr .= '<div class="content">';
					$aw_pr .='<h5>'.$awards_year.'</h5>';
					$aw_pr .= '<h2>'.$award_title.'</h2>';
					$aw_pr .= '<h3>'.$award_institute.'</h3>';
					$aw_pr .= '<h4>'.$award_description.'</h4>';
					$aw_pr .= '</div>';

					$aw_pr .= '<div class="aw_form e_form">';
					$aw_pr .= '<form action="seekerdashboard-ecv.php" method="POST">';
					$aw_pr .= '<input type="hidden" name="awno" value="'.$no.'"';
					$aw_pr .= '<p>';
					$aw_pr .= '<label for="">Title</label>';
					$aw_pr .= '<input type="text" name="award_title" value="'.$award_title.'">';
					$aw_pr .= '</p>';
					$aw_pr .= '<p>';
					$aw_pr .= '<label for="">Institute</label>';
					$aw_pr .= '<input type="text" name="award_institute" value="'.$award_institute.'">';
					$aw_pr .= '</p>';
					$aw_pr .= '<p>';
					$aw_pr .= '<label for="">Year</label>';
					$aw_pr .= '<input type="month" name="awards_year" value="'.$awards_year.'">';
					$aw_pr .= '</p>';
					$aw_pr .= '<p>';
					$aw_pr .= '<label for="">Description</label>';
					$aw_pr .= '<textarea name="award_description" maxlength="500">'.$award_description.'</textarea>';
					$aw_pr .= '</p>';
					$aw_pr .= '<input type="submit" name="aw_su" value="Add">';
					$aw_pr .= '</form>';
					$aw_pr .= '</div>';
					$aw_pr .= '</div>';
				}
			}

			if(mysqli_num_rows($result_set_addicv)>0){

				while ($addi_result = mysqli_fetch_assoc($result_set_addicv)) {

					$chs_heading = $addi_result['chs_headings'];
					$chs_title=$addi_result["chs_title"];
					$chs_company=$addi_result["chs_company"];
					$chs_date=$addi_result["chs_date"];
					$chs_description=$addi_result["chs_description"];
					$no = $addi_result["no"];

					$addi_pr .= '<div class="addi_fl_row">';
					
					$addi_pr .= '<div class="buttoned">';
					$addi_pr .= '<button type="button" id="sh_sddi" onclick="showform(event)"><i class="fas fa-pencil-alt"></i></button>';
					$addi_pr .= '<button type="button" id="dl_addi" onclick="dl_addi(event);deletefr('.$no.',\'addi\')"><i class="far fa-trash-alt"></i></button>';
					$addi_pr .= '</div>';
					
					$addi_pr .= '<div class="content">';
					$addi_pr .= '<h1 id="addi_heading" style="margin-bottom:10px;font-size:22px">'.$chs_heading.'</h1>';
					$addi_pr .='<h5>'.$chs_date.'</h5>';
					$addi_pr .= '<h2>'.$chs_title.'</h2>';
					$addi_pr .= '<h3>'.$chs_company.'</h3>';
					$addi_pr .= '<h4>'.$chs_description.'</h4>';
					$addi_pr .= '</div>';

					$addi_pr .= '<div class="aw_form e_form">';
					$addi_pr .= '<form action="seekerdashboard-ecv.php" method="POST">';
					$addi_pr .= '<input type="hidden" name="addino" value="'.$no.'"';
					$addi_pr .= '<p>';
					$addi_pr .= '<label for="">Heading</label>';
					$addi_pr .= '<input type="text" name="chs_heading" value="'.$chs_heading.'">';
					$addi_pr .= '</p>';
					$addi_pr .= '<p>';
					$addi_pr .= '<label for="">Title</label>';
					$addi_pr .= '<input type="text" name="chs_title" value="'.$chs_title.'">';
					$addi_pr .= '</p>';
					$addi_pr .= '<p>';
					$addi_pr .= '<label for="">Institute</label>';
					$addi_pr .= '<input type="text" name="chs_company" value="'.$chs_company.'">';
					$addi_pr .= '</p>';
					$addi_pr .= '<p>';
					$addi_pr .= '<label for="">Year</label>';
					$addi_pr .= '<input type="month" name="chs_date" value="'.$chs_date.'">';
					$addi_pr .= '</p>';
					$addi_pr .= '<p>';
					$addi_pr .= '<label for="">Description</label>';
					$addi_pr .= '<textarea name="chs_description" maxlength="500">'.$chs_description.'</textarea>';
					$addi_pr .= '</p>';
					$addi_pr .= '<input type="submit" name="addi_su" value="Add">';
					$addi_pr .= '</form>';
					$addi_pr .= '</div>';
					$addi_pr .= '</div>';
				}
			}




		}else{
			$firstname="";
			$lastname="";
			$title="";
			$description="";

			$email="";
			$phonenumber="";
			$address="";
			$birthday="";
			$linkedIN="";
			$facebook="";
			$twitter="";
			$git="";

			$education_title="";
			$education_year="";
			$education_institute="";
			$education_description="";
			$work_title="";
			$work_name="";
			$work_year="";
			$work_description="";

			$award_title="";
			$award_institute="";
			$awards_year="";
			$award_description="";
		}
	}
	else{
		$query="SELECT * FROM seeker WHERE seeker_id = '{$seeker_id}'";

		$result_set =mysqli_query($connection,$query);

		if (mysqli_num_rows($result_set)==1) {
			$user= mysqli_fetch_assoc($result_set);

			$firstname=$user["first_name"];
			$lastname=$user["last_name"];
			$email=$user["email"];
			$phonenumber=$user["phone_number"];

			//cecking profile picture is updated

				if ($user["is_image"]==1) {
					$_SESSION["is_image"]=1;
				}
				else{
					$_SESSION["is_image"]=0;
				}
				//////////////////////////////////////

		}
			$title="";
			$description="";



			$address="";
			$birthday="";
			$linkedIN="";
			$facebook="";
			$twitter="";
			$git="";

			$education_title="";
			$education_year="";
			$education_institute="";
			$education_description="";
			$work_title="";
			$work_name="";
			$work_year="";
			$work_description="";

			$award_title="";
			$award_institute="";
			$awards_year="";
			$award_description="";

	}
	
?>
<?php  
	
	$errors =array();

	clearstatcache();

	if (isset($_POST["save"])) {

		//to save when content has empyty set
		$firstname=$_POST["firstname"];
		$lastname=$_POST["lastname"];
		$title=$_POST["title1"];
		$address=$_POST["address"];
		$email=$_POST["email"];
		$phonenumber=$_POST["phonenumber"];

		if (empty(trim($_POST["firstname"]))) {
			$errors[]="Please Enter First Name";
		}
		if (empty(trim($_POST["lastname"]))) {
			$errors[]="Please Enter Last Name";
		}
		if (empty(trim($_POST["title1"]))) {
			$errors[]="Please Enter Professional Title";
		}
		if (empty(trim($_POST["address"]))) {
			$errors[]="Please Enter Your Address";
		}
		if (empty(trim($_POST["email"]))) {
			$errors[]="Please Enter Your Email";
		}
		if (empty(trim($_POST["phonenumber"]))) {
			$errors[]="Please Enter Your Phone number";
		}
		if (empty(trim($_POST["birthday"]))) {
			$errors[]="Please Enter Your Birth Day";
		}

		//to checking email address is already entered
		$email_query = "SELECT * FROM cv WHERE user_id != {$seeker_id} AND email = '{$email}' LIMIT 1";
		$result_email_set = mysqli_query($connection,$email_query);

		if(mysqli_num_rows($result_email_set)>0){
			$errors[] = "Email Is Already Entered";
			$email = "";
		}


		//validation for profile picture upload

		/*if ($_FILES["upload-pic"]["name"]) {
			
			if ($_FILES["upload-pic"]["error"]==0) {
				
				$file_name = $_FILES["upload-pic"]["name"];
				$file_type = $_FILES["upload-pic"]["type"];
				$file_size = $_FILES["upload-pic"]["size"];
				$temp_name = $_FILES["upload-pic"]["tmp_name"];

				$upload_to = "imj/profile_pictures/seekers/";

				//creating new file name
				$sp_old_name=explode(".",$file_name);

				$new_file_name = $seeker_id .  "." . end($sp_old_name);

				 if ($file_type != "image/jpeg") {
				 	$errors[]="Image Type Must Be jpg";
				 }

				 //checking file size
				if ($_FILES["upload-pro-pic"]["size"] > 1000000) {
					$errors[]="This Image Is Too Large";
				}


				if (empty($errors)) {
					
					move_uploaded_file($temp_name,$upload_to . $new_file_name);

					$query_to_is_image="UPDATE seeker SET is_image=1 WHERE seeker_id = {$seeker_id}";

					$result_is_image = mysqli_query($connection,$query_to_is_image);

					$_SESSION["is_image"]=1;
				}
			}
			else{
				$errors[]="Can Not Upload This Image";
			}
		}
*/

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

						$_SESSION["is_image"]=1;
					}
				}
				else{
					$errors[] = "Picture Is Too Large";
				}

			}

		}

		//0 erros then update data base
		if (empty($errors)) {
			
			$firstname = mysqli_real_escape_string($connection,$_POST['firstname']);
			$lastname = mysqli_real_escape_string($connection,$_POST['lastname']);
			$title = mysqli_real_escape_string($connection,$_POST['title1']);
			$summery = mysqli_real_escape_string($connection,$_POST['summery']);
			$email = mysqli_real_escape_string($connection,$_POST['email']);
			$phonenumber = mysqli_real_escape_string($connection,$_POST['phonenumber']);
			$address = mysqli_real_escape_string($connection,$_POST['address']);
			$birthday = mysqli_real_escape_string($connection,$_POST['birthday']);

			$linkedIN = mysqli_real_escape_string($connection,$_POST['linkedIN']);
			$facebook = mysqli_real_escape_string($connection,$_POST['facebook']);
			$twitter = mysqli_real_escape_string($connection,$_POST['twitter']);
			$git = mysqli_real_escape_string($connection,$_POST['git']);

			//inserting values to cv table
			$query_up_cv = "UPDATE cv SET first_name = '{$firstname}', last_name = '{$lastname}', title='{$title}',description='{$summery}', email='{$email}', phone_number='{$phonenumber}', address='{$address}', birth_day='{$birthday}' WHERE user_id = {$seeker_id} ";

			$query_up_sh = "UPDATE sh_media SET linked_in = '{$linkedIN}', facebook = '{$facebook}', twitter='{$twitter}',git_hub='{$git}' WHERE user_id = {$seeker_id} ";

			$result_set_cv = mysqli_query($connection,$query_up_cv);
			$result_set_sh = mysqli_query($connection,$query_up_sh);

			if($result_set_cv){
				header('Location:seekerdashboard-ecv.php');
			}
			if(!$result_set_sh){
				print_r(mysqli_error($connection));
			}
			
		}
	}

	//update Education
	if(isset($_POST['ed_su'])){

		//validation education
		$education_title = $_POST['education_title'];

		if(empty($education_title)){
			$errors[] = "Please Add Education Title";
		}

		if(empty($errors)){
			$eno = mysqli_real_escape_string($connection,$_POST['no']);
			$education_title = mysqli_real_escape_string($connection,$_POST['education_title']);
			$education_year = mysqli_real_escape_string($connection,$_POST['education_year']);
			$education_institute = mysqli_real_escape_string($connection,$_POST['education_institute']);
			$education_description = mysqli_real_escape_string($connection,$_POST['education_description']);

			//update education query
			$query_up_ed = "UPDATE education SET edu_title='{$education_title}',edu_year='{$education_year}',edu_institute='{$education_institute}',edu_description='{$education_description}' WHERE no={$eno} AND user_id={$seeker_id}";
			$result_up_ed = mysqli_query($connection,$query_up_ed);

			if($result_up_ed){
				header('Location:seekerdashboard-ecv.php');
			}
		}

	}

	//update work and Experience
	if(isset($_POST['we_su'])){
				echo "<pre>";
		print_r($_POST);
		echo "</pre>";

		//validation education
		$work_title = $_POST['work_title'];

		if(empty($work_title)){
			$errors[] = "Please Add Work And Experience Title";
		}

		if(empty($errors)){
			$wno = mysqli_real_escape_string($connection,$_POST['wno']);
			$work_title = mysqli_real_escape_string($connection,$_POST['work_title']);
			$work_year = mysqli_real_escape_string($connection,$_POST['work_year']);
			$work_company = mysqli_real_escape_string($connection,$_POST['work_company']);
			$work_description = mysqli_real_escape_string($connection,$_POST['work_description']);

			//update education query
			$query_up_we = "UPDATE work_experience SET wk_title='{$work_title}',wk_years='{$work_year}',wk_company='{$work_company}',wk_description='{$work_description}' WHERE no={$wno} AND user_id={$seeker_id}";
			$result_up_we = mysqli_query($connection,$query_up_we);

			if($result_up_we){
				header('Location:seekerdashboard-ecv.php');
			}
		}

	}

	//update awards
	if(isset($_POST['aw_su'])){

		//validation education
		$award_title = $_POST['award_title'];

		if(empty($award_title)){
			$errors[] = "Please Add Awards Title";
		}

		if(empty($errors)){
			$awno = mysqli_real_escape_string($connection,$_POST['awno']);
			$award_title = mysqli_real_escape_string($connection,$_POST['award_title']);
			$awards_year = mysqli_real_escape_string($connection,$_POST['awards_year']);
			$award_institute = mysqli_real_escape_string($connection,$_POST['award_institute']);
			$award_description = mysqli_real_escape_string($connection,$_POST['award_description']);

			//update education query
			$query_up_su = "UPDATE awards SET aw_title='{$award_title}',aw_year='{$awards_year}',aw_institute='{$award_institute}',aw_description='{$award_description}' WHERE no={$awno} AND user_id={$seeker_id}";
			$result_up_su = mysqli_query($connection,$query_up_su);

			if($result_up_su){
				header('Location:seekerdashboard-ecv.php');
			}
		}

	}

	//updating skills
	if(isset($_POST['skup'])){

		foreach ($_POST['professional_precenage1'] as $key => $value) {
			if($value>0){
				if(empty($_POST['professional_title1'][$key])){
					$errors[] = "Please Enter Skill Name " . ++$key;
				}
			}
		}

		if(empty($errors)){
			//checking values
			$professional_title1=$_POST['professional_title1'];
			$professional_precenage1=$_POST['professional_precenage1'];
			$skno = $_POST['skno'];

			for ($i=0; $i < count($professional_title1); $i++) { 
				
				if($professional_title1[$i]){

					//checking values are already entered or not
					$query = "SELECT * FROM professional_skills WHERE no='{$skno["$i"]}' AND user_id = '{$seeker_id}'";
					$result=mysqli_query($connection,$query);

					if(mysqli_num_rows($result)==1){
						//update skills
						$up_query = "UPDATE professional_skills SET title='{$professional_title1["$i"]}',percentage='{$professional_precenage1["$i"]}' WHERE user_id='{$seeker_id}' AND no='{$skno["$i"]}'";
						$result_up = mysqli_query($connection,$up_query);

						if($result_up){
							header("Location:seekerdashboard-ecv.php");
						}
					}
					else{
						//inserting skills
						$in_query = "INSERT INTO professional_skills (user_id,title,percentage) VALUES ('{$seeker_id}','{$professional_title1["$i"]}','{$professional_precenage1["$i"]}')";
						$result_in = mysqli_query($connection,$in_query);

						if(!$result_in){
							print_r(mysqli_error($connection));
						}
					}	
				}
			}
		}

		
	}
	//update additional cv information
	if(isset($_POST['addi_su'])){
		//validation additional Information
		$addi_heading = $_POST['chs_heading'];
		$addi_title = $_POST['chs_title'];
		
		if(empty($addi_heading)){
			$errors[] = "Please Add Additional Information Heading";
		}
		if(empty($addi_title)){
			$errors[] = "Please Add Awards Title";
		}
		
		if(empty($errors)){
			$addino = mysqli_real_escape_string($connection,$_POST['addino']);
			$addi_heading = mysqli_real_escape_string($connection,$_POST['chs_heading']);
			$addi_title = mysqli_real_escape_string($connection,$_POST['chs_title']);
			$addI_date = mysqli_real_escape_string($connection,$_POST['chs_date']);
			$addi_company = mysqli_real_escape_string($connection,$_POST['chs_company']);
			$addi_description = mysqli_real_escape_string($connection,$_POST['chs_description']);

			//update education query
			$query_up_addi = "UPDATE additional_cv SET chs_headings ='{$addi_heading}',chs_title='{$addi_title}',chs_date='{$addI_date}',chs_company='{$addi_company}',chs_description='{$addi_description}' WHERE no={$addino} AND user_id={$seeker_id}";
			$result_up_addi = mysqli_query($connection,$query_up_addi);

			if($result_up_addi){
				header('Location:seekerdashboard-ecv.php?true');
			}
		}

	}

	//add new education
	if(isset($_POST['submit_ed'])){

		$educ_title = $_POST['education_title'];
		$educ_year = $_POST['education_year'];
		$educ_institute = $_POST['education_institute'];
		$educ_description = $_POST['education_description'];

		for($i=0;$i<count($educ_title);$i++){
			if(empty($educ_title[$i])){
				$errors[] = "Please Enter Education Title";
			}
			else{
				$query_ad_educa = "INSERT INTO education(user_id,edu_title,edu_year,edu_institute,edu_description) VALUES({$seeker_id},'".mysqli_real_escape_string($connection,$educ_title["$i"])."','".mysqli_real_escape_string($connection,$educ_year["$i"])."','".
				mysqli_real_escape_string($connection,$educ_institute["$i"])."','".mysqli_real_escape_string($connection,$educ_description["$i"])."')";	

				$result_in_ed = mysqli_query($connection,$query_ad_educa);

				if($result_in_ed){
					header("Location:seekerdashboard-ecv.php");
				}
			}
		}
	}
	//add new work and experience
	if(isset($_POST['submit_we'])){

		$worke_title = $_POST['work_title'];
		$worke_year = $_POST['work_year'];
		$worke_name = $_POST['work_name'];
		$worke_description = $_POST['description'];

		for($i=0;$i<count($worke_title);$i++){
			if(empty($worke_title[$i])){
				$errors[] = "Please Enter Work And Experience Title";
			}
			else{
				$query_ad_expa = "INSERT INTO work_experience(user_id,wk_title,wk_years,wk_company,wk_description) VALUES({$seeker_id},'".mysqli_real_escape_string($connection,$worke_title["$i"])."','".mysqli_real_escape_string($connection,$worke_year["$i"])."','".
				mysqli_real_escape_string($connection,$worke_name["$i"])."','".mysqli_real_escape_string($connection,$worke_description["$i"])."')";	

				$result_in_we = mysqli_query($connection,$query_ad_expa);

				if($result_in_we){
					header("Location:seekerdashboard-ecv.php");
				}
			}
		}
	}
	//add new work and experience
	if(isset($_POST['submit_aw'])){

		$awar_title = $_POST['award_title'];
		$awar_year = $_POST['awards_year'];
		$awar_institute = $_POST['award_institute'];
		$awar_description = $_POST['award_description'];

		for($i=0;$i<count($awar_title);$i++){
			if(empty($awar_title[$i])){
				$errors[] = "Please Enter Awards Title";
			}
			else{
				$query_ad_awarda = "INSERT INTO awards(user_id,aw_title,aw_year,aw_institute,aw_description) VALUES({$seeker_id},'".mysqli_real_escape_string($connection,$awar_title["$i"])."','".mysqli_real_escape_string($connection,$awar_year["$i"])."','".
				mysqli_real_escape_string($connection,$awar_institute["$i"])."','".mysqli_real_escape_string($connection,$awar_description["$i"])."')";	

				$result_in_aw = mysqli_query($connection,$query_ad_awarda);

				if($result_in_aw){
					header("Location:seekerdashboard-ecv.php");
				}
			}
		}
	}

	//add new additional information
	if(isset($_POST['submit_addi'])){

		$chs_heading = $_POST['addI_heading'];
		$chs_title = $_POST['addi_title'];
		$chs_date = $_POST['addi_date'];
		$chs_company = $_POST['addi_asc'];
		$chas_description = $_POST['addi_description'];

		for($i=0;$i<count($chs_heading);$i++){
			if(empty($chs_heading[$i])){
				$errors[] = "Please Enter Additional Information Heading";
			}
			if(empty($chs_title[$i])){
				$errors[] = "Please Enter Additional Information Title";
			}
			else{
				$query_ad_additional = "INSERT INTO additional_cv(user_id,chs_headings,chs_title,chs_date,chs_company,chs_description) VALUES({$seeker_id},'".mysqli_real_escape_string($connection,$chs_heading["$i"])."','".mysqli_real_escape_string($connection,$chs_title["$i"])."','".mysqli_real_escape_string($connection,$chs_date["$i"])."','".
				mysqli_real_escape_string($connection,$chs_company["$i"])."','".mysqli_real_escape_string($connection,$chas_description["$i"])."')";	

				$result_in_additional = mysqli_query($connection,$query_ad_additional);

				if($result_in_additional){
					header("Location:seekerdashboard-ecv.php");
				}
				else{
					print_r(mysqli_error($connection));
				}
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
	<link rel="stylesheet" href="css/seekerdashboard-ecv.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.css"><!--croper style-->
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>
	<script src="//cdn.ckeditor.com/4.14.0/basic/ckeditor.js"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	
	<link rel="stylesheet" href="css/media-queries/seekerdashboardheader.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/seekerdashboard-ecv-media.css"><!--media query-->

</head>
<body>
	
	<!-- model page -->
	<div class="model_page">
		<div class="update_pic">
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
	</div><!-- model page -->



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

		<div class="ed-main">
			<div class="create">
				<h1>Edit My CV</h1>
			</div>

			<form action="seekerdashboard-ecv.php" method="post" enctype="multipart/form-data">
				<div class="cv">
					<div class="row1">
						<div class="column">
							<input type="hidden" name="seeker_id" value="<?php echo $seeker_id; ?>">
							<p>
								<input type="text" name="firstname" placeholder="Eter First Name" value="<?php echo $firstname ?>">

							</p>
							<p>
								<input type="text" name="lastname" placeholder="Eter Last Name" value="<?php echo $lastname ?>">
							</p>
							<p>
							<input type="text" name="title1" placeholder="Eter Title" value="<?php echo $title ?>">
							</p>
							<p>
								<textarea name="summery" placeholder="Enter Summery" cols="30" rows="10" ><?php echo $description ?></textarea>
							</p>
						</div>
						<div class="column">
							<div class="cv-pic">
								<div class="pic">
									<?php 

										if ($_SESSION["is_image"]==0) {
											echo "<img src=\"imj/profile_pictures/default.jpg\">";
										}
										else{
											echo "<img src=\"imj/profile_pictures/seekers/" . $_SESSION["seeker_id"] . ".jpg\">";
										}

									?>
								</div>

								<!-- use for load croped Image -->
								<div class="croped_pic">
									<input type="hidden" name="cv_pic_name" id="cv_pic_name">
									<input type="hidden" name="cv_pic_size" id="cv_pic_size">
									<input type="hidden" name="cv_pic" id="cv_pic">
								</div>
								
								<div class="up-but">
									<input type="file" name="upload-pic" id="upload-pic">
									<label for="upload-pic"><i class="fas fa-pencil-alt"></i></label>
								</div>
							</div>
						</div>
						<div class="column">
							<p>
							<input type="email" name="email" placeholder="Enter Email"  value="<?php echo $email; ?>"><i class="fas fa-envelope"></i>
							</p>
							<p>
							<input type="text" name="phonenumber" placeholder="Enter Phone Number"  value="<?php echo $phonenumber; ?>"><i class="fas fa-phone"></i>
							</p>
							<p>
							<input type="text" name="address" placeholder="Enter Address" value="<?php echo $address; ?>"><i class="fas fa-map-marker"></i>
							</p>
							<p>
							<input type="date" name="birthday" placeholder="Enter Your Birth Day" value="<?php echo $birthday; ?>"><i class="far fa-calendar-alt"></i>
							</p>
							<p>
							<input type="text" name="linkedIN" placeholder="LinkedIN" value="<?php echo $linkedIN; ?>"><i class="fab fa-linkedin"></i>
							</p>
							<p>
							<input type="text" name="facebook" placeholder="Facebook " value="<?php echo $facebook; ?>"><i class="fab fa-facebook"></i>
							</p>
							<p>
							<input type="text" name="twitter" placeholder="Twitter" value="<?php echo $twitter; ?>"><i class="fab fa-twitter"></i>
							</p>
							<p>
							<input type="text" name="git" placeholder="GitHub" value="<?php echo $git; ?>"><i class="fab fa-github"></i>
							</p>
						</div>
					</div>
					<div class="cvbut">
						<input type="submit" name="save" value="Update">
					</div>
				</div>
			</form>
					<div class="errors">
					<?php 

						foreach ($errors as $value) {
							echo "<p>" . $value . "</p>";
						}

					 ?>
					</div>
				<div class="row2">
						<div class="row">
							<div class="rowsec">
								<div class="add_row">
									<h1>Education</h1>
									<button type="button" id="addedu" onclick="checked();gened()">Add Education</button>
								</div>
								<form action="seekerdashboard-ecv.php" method="POST" class="edf">
									<div class="ed"><!-- for dynamically add form --></div>
								</form>
									<?php echo $ed_pr; ?>
							</div>		
						</div>
						<div class="row">
							<div class="rowsec">
								<div class="add_row">
									<h1>Work & Experience</h1>
									<button type="button" id="addexp" onclick="checkwe();genwe()">Add Experience</button>
								</div>
								<form action="seekerdashboard-ecv.php" method="POST" class="wef">
									<div class="we"><!-- for dynamically add form --></div>
								</form>
									<?php echo $we_pr; ?>
							</div>	
						</div>
						<div class="row">
							<div class="rowsec">
								<div class="add_row">
									<h1>Professional Skill</h1>
									<button type="button" id="adsk" onclick="skgen()">Add Skills</button>
								</div>
									<form action="seekerdashboard-ecv.php" method="POST">
										<div class="skills">
											<?php echo $sk_pr; ?>
										</div>
										<input type="submit" value="Save" name="skup">	
									</form>
							</div>
						</div>
						<div class="row">
							<div class="rowsec">
								<div class="add_row">
									<h1>Awards</h1>
									<button type="button" id="addaw" onclick="checkaw();genaw();">Add Awards</button>
								</div>
								<form action="seekerdashboard-ecv.php" method="POST" class="awf">
									<div class="aw"><!-- for dynamically add form --></div>
								</form>
									<?php  echo $aw_pr;?>	
							</div>
						</div>	
						<div class="row">
							<div class="rowsec">
								<div class="add_row">
									<h1>Additional Informaion</h1>
									<button style="width:220px" type="button" id="addaddi" onclick="checkaddi();genaddi();">Add Additional Information</button>
								</div>
								<form action="seekerdashboard-ecv.php" method="POST" class="addif">
									<div class="addi"><!-- for dynamically add form --></div>
								</form>	
									<?php  echo $addi_pr;?>	
							</div>	
						</div>	
				</div>
		</div>
	</div><!--section-->
	
<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.js"></script>

	<script src="js/cv_pro_pic.js"></script><!-- cv Profile picture cropper-->
	<script src="js/srange.js">//for generate fields</script>

	<script>
		/*for set submit button for add form*/
		const ed = document.querySelector('.ed');
		const forme = document.querySelector('.edf');
		const we = document.querySelector('.we');
		const formw = document.querySelector('.wef');
		const aw = document.querySelector('.aw');
		const form = document.querySelector('.awf');
		const addi = document.querySelector('.addi');
		const formaddi = document.querySelector('.addif');

		function checked(){
			const ed_fl_row = document.querySelectorAll('.ed_fl_row');
			if(ed.children.length==0 && ed_fl_row.length<3){
				let input = document.createElement('input');
				input.setAttribute('type','submit');
				input.setAttribute('name','submit_ed');
				input.setAttribute('value','Add');
				input.classList.add('forminput');

				forme.appendChild(input);
			}
		}
		function checkwe(){
			const we_fl_row = document.querySelectorAll('.we_fl_row');
			if(we.children.length==0 && we_fl_row.length<3){
				let input = document.createElement('input');
				input.setAttribute('type','submit');
				input.setAttribute('name','submit_we');
				input.setAttribute('value','Add');
				input.classList.add('forminput');

				formw.appendChild(input);
			}
		}
		function checkaw(){
			const aw_fl_row = document.querySelectorAll('.aw_fl_row');
			if(aw.children.length==0 && aw_fl_row.length<3 ){
				let input = document.createElement('input');
				input.setAttribute('type','submit');
				input.setAttribute('name','submit_aw');
				input.setAttribute('value','Add');
				input.classList.add('forminput');

				form.appendChild(input);
			}
		}
		function checkaddi(){	
			let addi_fl_row = document.querySelectorAll('.addi_fl_row');
			if(addi.children.length==0 && addi_fl_row.length<2 ){
				let input = document.createElement('input');
				input.setAttribute('type','submit');
				input.setAttribute('name','submit_addi');
				input.setAttribute('value','Add');
				input.classList.add('forminput');

				formaddi.appendChild(input);
			}
		}
	</script>

	<script>
			
			/*for show hide forms*/
			function showform(event){
				event.target.parentElement.parentElement.parentElement.children[2].style.display = 'block';

			}

	</script>

	<script>
		/*for remove skills row*/
		function dl_row(event){
			event.target.parentElement.parentElement.parentElement.parentElement.remove();
			countsk--;
		}
		/*For remove education row*/
		function dl_ed(event){
			event.target.parentElement.parentElement.parentElement.remove();
			countedforms--;
		}
		/*For remove work and experience row*/
		function dl_we(event){
			event.target.parentElement.parentElement.parentElement.remove();
			countweforms--;
		}
		/*For remove awards row*/
		function dl_aw(event){
			event.target.parentElement.parentElement.parentElement.remove();
			countforms--;
		}
		/*For remove additional cv row*/
		function dl_addi(event){
			event.target.parentElement.parentElement.parentElement.remove();
			contaddiform--;
		}

	</script>	

	<script>
		/*For remove new insert forms*/

		function dl_row_fr(event,fo){

			const ed = document.querySelector('.ed');
			const we = document.querySelector('.we');
			const aw = document.querySelector('.aw');
			const addi = document.querySelector('.addi');
			let input = event.target.parentElement.parentElement.parentElement.parentElement.parentElement.children[1];

			event.target.parentElement.parentElement.parentElement.remove();//remove form

			if(fo=='ed'){
				if(ed.children.length==0){
					input.remove();
				}
				countedforms--;
			}
			if(fo=='we'){
				if(we.children.length==0){
					input.remove();
				}
				countweforms--;
			}
			if(fo=='aw'){
				if(aw.children.length==0){
					input.remove();
				}
				countforms--;
			}
			if(fo=='addidl'){
				if(addi.children.length==0){
					input.remove();
				}
				contaddiform--;
			}
			


		}

	</script>

	<script>
		let countedforms = <?php echo mysqli_num_rows($result_set_ed); ?>;
		let countweforms = <?php echo mysqli_num_rows($result_set_we); ?>;
		let countsk = <?php echo mysqli_num_rows($result_set_sk); ?>;
		let countforms = <?php echo mysqli_num_rows($result_set_aw); ?>;
		let contaddiform = <?php echo mysqli_num_rows($result_set_addicv); ?>;


		//generate additional informauin form
		function genaddi(){
			const addi = document.querySelector('.addi');

			if(contaddiform<2){

				let addi_fl_row = document.createElement('div');
				addi_fl_row.classList.add('addi_fl_row');

				let dl_row_ed = document.createElement('div');
				dl_row_ed.classList.add('dl_row_ed');
				let dl_row_ed_but = document.createElement('button');
				dl_row_ed_but.setAttribute('type','button');
				dl_row_ed_but.classList.add('dl_row_ed_but');
				dl_row_ed_but.innerHTML='<i class="fas fa-trash"></i>';
				dl_row_ed_but.setAttribute('onclick','dl_row_fr(event,"addidl")');

				dl_row_ed.appendChild(dl_row_ed_but);
				addi_fl_row.appendChild(dl_row_ed);

				let p1 = document.createElement('p');

				let labelT0 = document.createElement('label');
				labelT0.innerText='Heading';
				let input0 = document.createElement('input');
				input0.setAttribute('type','text');
				input0.setAttribute('name','addI_heading[]');

				let labelTl = document.createElement('label');
				labelTl.innerText='Title';
				let input1 = document.createElement('input');
				input1.setAttribute('type','text');
				input1.setAttribute('name','addi_title[]');

				p1.appendChild(labelT0);
				p1.appendChild(input0);
				p1.appendChild(labelTl);
				p1.appendChild(input1);

				let p2 = document.createElement('p');

				let labelY2 = document.createElement('label');
				labelY2.innerText='Date';
				let input2 = document.createElement('input');
				input2.setAttribute('type','month');
				input2.setAttribute('name','addi_date[]');

				p2.appendChild(labelY2);
				p2.appendChild(input2);

				let p3 = document.createElement('p');

				let labelI3 = document.createElement('label');
				labelI3.innerText='Association';
				let input3 = document.createElement('input');
				input3.setAttribute('type','text');
				input3.setAttribute('name','addi_asc[]');

				p3.appendChild(labelI3);
				p3.appendChild(input3);

				let p4 = document.createElement('p');

				let description1 = document.createElement('label');
				description1.innerText='Description';
				let textarea1 = document.createElement('textarea');
				textarea1.setAttribute('name','addi_description[]');
				textarea1.setAttribute('maxlength','500');

				p4.appendChild(description1);
				p4.appendChild(textarea1);

				addi_fl_row.appendChild(p1);
				addi_fl_row.appendChild(p2);
				addi_fl_row.appendChild(p3);
				addi_fl_row.appendChild(p4);

				addi.appendChild(addi_fl_row);

				contaddiform++;
			}

		}
		
		//generate education fields
		function gened(){

			const ed_fl = document.querySelector('.ed');

			if(countedforms<3){

				let ed_fl_row = document.createElement('div');
				ed_fl_row.classList.add('ed_fl_row');

				let dl_row_ed = document.createElement('div');
				dl_row_ed.classList.add('dl_row_ed');
				let dl_row_ed_but = document.createElement('button');
				dl_row_ed_but.setAttribute('type','button');
				dl_row_ed_but.classList.add('dl_row_ed_but');
				dl_row_ed_but.innerHTML='<i class="fas fa-trash"></i>';
				dl_row_ed_but.setAttribute('onclick','dl_row_fr(event,"ed")');

				dl_row_ed.appendChild(dl_row_ed_but);
				ed_fl_row.appendChild(dl_row_ed);

				let p1 = document.createElement('p');

				let labelTl = document.createElement('label');
				labelTl.innerText='Title';
				let input1 = document.createElement('input');
				input1.setAttribute('type','text');
				input1.setAttribute('name','education_title[]');

				p1.appendChild(labelTl);
				p1.appendChild(input1);

				let p2 = document.createElement('p');

				let labelY2 = document.createElement('label');
				labelY2.innerText='Year';
				let input2 = document.createElement('input');
				input2.setAttribute('type','month');
				input2.setAttribute('name','education_year[]');

				p2.appendChild(labelY2);
				p2.appendChild(input2);

				let p3 = document.createElement('p');

				let labelI3 = document.createElement('label');
				labelI3.innerText='Institute';
				let input3 = document.createElement('input');
				input3.setAttribute('type','text');
				input3.setAttribute('name','education_institute[]');

				p3.appendChild(labelI3);
				p3.appendChild(input3);

				let p4 = document.createElement('p');

				let description1 = document.createElement('label');
				description1.innerText='Description';
				let textarea1 = document.createElement('textarea');
				textarea1.setAttribute('name','education_description[]');
				textarea1.setAttribute('maxlength','500');

				p4.appendChild(description1);
				p4.appendChild(textarea1);

				ed_fl_row.appendChild(p1);
				ed_fl_row.appendChild(p2);
				ed_fl_row.appendChild(p3);
				ed_fl_row.appendChild(p4);

				ed_fl.appendChild(ed_fl_row);

				countedforms++;
			}

		}

		function genwe(){

			const we_fl = document.querySelector('.we');

			if(countweforms<3){

				let we_fl_row = document.createElement('div');
				we_fl_row.classList.add('we_fl_row');

				let dl_row_ed = document.createElement('div');
				dl_row_ed.classList.add('dl_row_ed');
				let dl_row_ed_but = document.createElement('button');
				dl_row_ed_but.setAttribute('type','button');
				dl_row_ed_but.classList.add('dl_row_ed_but');
				dl_row_ed_but.innerHTML='<i class="fas fa-trash"></i>';
				dl_row_ed_but.setAttribute('onclick','dl_row_fr(event,"we")');

				dl_row_ed.appendChild(dl_row_ed_but);
				we_fl_row.appendChild(dl_row_ed);

				let p1 = document.createElement('p');

				let labelTl = document.createElement('label');
				labelTl.innerText='Title';
				let input1 = document.createElement('input');
				input1.setAttribute('type','text');
				input1.setAttribute('name','work_title[]');

				p1.appendChild(labelTl);
				p1.appendChild(input1);

				let p2 = document.createElement('p');

				let labelY2 = document.createElement('label');
				labelY2.innerText='Company Name';
				let input2 = document.createElement('input');
				input2.setAttribute('type','text');
				input2.setAttribute('name','work_name[]');

				p2.appendChild(labelY2);
				p2.appendChild(input2);

				let p3 = document.createElement('p');

				let labelI3 = document.createElement('label');
				labelI3.innerText='year';
				let input3 = document.createElement('input');
				input3.setAttribute('type','month');
				input3.setAttribute('name','work_year[]');

				p3.appendChild(labelI3);
				p3.appendChild(input3);

				let p4 = document.createElement('p');

				let description1 = document.createElement('label');
				description1.innerText='Description';
				let textarea1 = document.createElement('textarea');
				textarea1.setAttribute('name','description[]');
				textarea1.setAttribute('maxlength','500');

				p4.appendChild(description1);
				p4.appendChild(textarea1);

				we_fl_row.appendChild(p1);
				we_fl_row.appendChild(p2);
				we_fl_row.appendChild(p3);
				we_fl_row.appendChild(p4);

				we_fl.appendChild(we_fl_row);

				countweforms++;
			}

		}

		//generate awards fields
		function genaw(){

			const aw_fl = document.querySelector('.aw');


			if(countforms<3){

				let aw_fl_row = document.createElement('div');
				aw_fl_row.classList.add('aw_fl_row');

				let dl_row_ed = document.createElement('div');
				dl_row_ed.classList.add('dl_row_ed');
				let dl_row_ed_but = document.createElement('button');
				dl_row_ed_but.setAttribute('type','button');
				dl_row_ed_but.classList.add('dl_row_ed_but');
				dl_row_ed_but.innerHTML='<i class="fas fa-trash"></i>';
				dl_row_ed_but.setAttribute('onclick','dl_row_fr(event,"aw")');

				dl_row_ed.appendChild(dl_row_ed_but);
				aw_fl_row.appendChild(dl_row_ed);


				let p1 = document.createElement('p');

				let labelTl = document.createElement('label');
				labelTl.innerText='Title';
				let input1 = document.createElement('input');
				input1.setAttribute('type','text');
				input1.setAttribute('name','award_title[]');

				p1.appendChild(labelTl);
				p1.appendChild(input1);

				let p2 = document.createElement('p');

				let labelY2 = document.createElement('label');
				labelY2.innerText='Institute';
				let input2 = document.createElement('input');
				input2.setAttribute('type','text');
				input2.setAttribute('name','award_institute[]');

				p2.appendChild(labelY2);
				p2.appendChild(input2);

				let p3 = document.createElement('p');

				let labelI3 = document.createElement('label');
				labelI3.innerText='year';
				let input3 = document.createElement('input');
				input3.setAttribute('type','month');
				input3.setAttribute('name','awards_year[]');

				p3.appendChild(labelI3);
				p3.appendChild(input3);

				let p4 = document.createElement('p');

				let description1 = document.createElement('label');
				description1.innerText='Description';
				let textarea1 = document.createElement('textarea');
				textarea1.setAttribute('name','award_description[]');
				textarea1.setAttribute('maxlength','500');

				p4.appendChild(description1);
				p4.appendChild(textarea1);

				aw_fl_row.appendChild(p1);
				aw_fl_row.appendChild(p2);
				aw_fl_row.appendChild(p3);
				aw_fl_row.appendChild(p4);

				aw_fl.appendChild(aw_fl_row);

				countforms++;
			}
		}

			function skgen(){

				const skills = document.querySelector('.skills');

				if(countsk<5){

					let nde = document.createElement('div');
					nde.classList.add('sk_row');

					let skp = document.createElement('p');

					let sklb = document.createElement('label');
					sklb.innerText = 'Title';
					let skin = document.createElement('input');
					skin.setAttribute('type','text');
					skin.setAttribute('name','professional_title1[]');

					skp.appendChild(sklb);
					skp.appendChild(skin);

					let skp1 = document.createElement('div');
					skp1.classList.add('prc');

					let twopc = document.createElement('div');
					twopc.classList.add('twopc');

					let sklb1 = document.createElement('label');
					sklb1.innerText = 'Percentage';
					let skin1 = document.createElement('input');
					skin1.setAttribute('type','range');
					skin1.setAttribute('name','professional_precenage1[]');
					skin1.setAttribute('value','0');
					skin1.setAttribute('oninput','scrol(event)')
					let skin2 = document.createElement('input');
					skin2.classList.add('range_box');
					skin2.setAttribute('type','text');
					skin2.setAttribute('id','valu1');
					skin2.setAttribute('value','0');

					let twopcs = document.createElement('div');
					twopcs.classList.add('twopcs');

					twopc.appendChild(sklb1);
					twopc.appendChild(skin1);
					twopcs.appendChild(skin2);


					let span = document.createElement('span');
					span.innerText='%';
					twopcs.appendChild(span);

					let skdl = document.createElement('button');
					skdl.classList.add('butdl');
					skdl.innerHTML='<i class="fas fa-trash"></i>';
					skdl.setAttribute('type','button');
					skdl.setAttribute('onclick','dl_row(event)');
					twopcs.appendChild(skdl);
					
					let skRow =document.createElement('div');
					skRow.classList.add('sk_row');
					skp1.appendChild(twopc);
					skp1.appendChild(twopcs);
					skRow.appendChild(skp);
					skRow.appendChild(skp1);

					skills.appendChild(skRow);

					countsk++;
				}
			}

	</script>

	<script>
		//Ajax delete skills
		function deletesk(skill_number){
			var skill_number = skill_number;
			var user_id = <?php echo $seeker_id; ?>;

			$.post('ajax/delete_cv_forms.php',{
				sno:skill_number,
				user_id:user_id,
				form:'sk'
			});
		}

		function deletefr(form_number,form_name){
			var form_number = form_number;
			var form_name = form_name;
			var user_id = <?php echo $seeker_id; ?>;

			$.post('ajax/delete_cv_forms.php',{
				fno:form_number,
				user_id:user_id,
				form_name:form_name
			},function(data){

			});
		}

	</script>

</body>
<?php mysqli_close($connection); ?>
</html>