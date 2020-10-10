<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 
	$p=$_GET["p"];

	//checking ad no is available
	$query_ad_av="SELECT * FROM job_ad WHERE ad_no = {$_GET['ad-no']} AND is_delete =1";
	$result_ad_av=mysqli_query($connection,$query_ad_av);

	if (mysqli_num_rows($result_ad_av)==1) {
		header('location:seekerdashboard.php?p=' . $p);
	}
	else{

		//checking seeker already applied for job
		$query_al = "SELECT * FROM job_apply WHERE ad_no = {$_GET['ad-no']} AND provider_id = '{$_GET['crn']}' AND seeker_id = {$_SESSION['seeker_id']} LIMIT 1";
		$result_al = mysqli_query($connection,$query_al);

		if(mysqli_num_rows($result_al)>0){
			header('location:seekerdashboard.php?p=' . $p . '&msg=alreay_applied');
		}

		$query = "SELECT * FROM cv WHERE user_id = '{$_SESSION["seeker_id"]}' AND is_deleted=0 LIMIT 1";
		$result=mysqli_query($connection, $query);
			if (mysqli_num_rows($result)==0) {
				 header('location:seekerdashboard-ecv.php?msg=create_cv_first');
			}
			else{
				//checking education,shmeadia,awards,works and experience and skills are empty
				$seeker_id = $_SESSION['seeker_id'];
				$hw_mn = 0;//for check how many of forms are filled

				$query_sh_media = "SELECT * FROM sh_media WHERE user_id={$seeker_id}";
				$result_sh_media = mysqli_query($connection,$query_sh_media);

				if(mysqli_num_rows($result_sh_media)==1){
					$hw_mn++;
				}

				//checking education form filled or not
				$query_education = "SELECT * FROM education WHERE user_id = {$seeker_id}";
				$result_education = mysqli_query($connection,$query_education);

				if(mysqli_num_rows($result_education)>0){
					$hw_mn++;
				}

				//checking work and experience form filled or not
				$query_experience = "SELECT * FROM  work_experience WHERE user_id = {$seeker_id}";
				$result_experience = mysqli_query($connection,$query_experience);

				if(mysqli_num_rows($result_experience)>0){
					$hw_mn++;
				}

				//checking skills form filled or not
				$query_skills = "SELECT * FROM  professional_skills WHERE user_id = {$seeker_id}";
				$result_skills = mysqli_query($connection,$query_skills);

				if(mysqli_num_rows($result_skills)>0){
					$hw_mn++;
				}

				//checking awards form filled or not
				$query_skills = "SELECT * FROM  awards WHERE user_id = {$seeker_id}";
				$result_skills = mysqli_query($connection,$query_skills);

				if(mysqli_num_rows($result_skills)>0){
					$hw_mn++;
				}

				//if one of extra forms are not empty
				if($hw_mn>0){
					//applying for jobs
					$provider_id = $_GET['crn'];
					$ad_no = $_GET['ad-no'];

					$ins_query = "INSERT INTO job_apply(seeker_id,provider_id,ad_no) VALUES({$seeker_id},'{$provider_id}',{$ad_no})";
					$result_ins = mysqli_query($connection,$ins_query);

					if($result_ins){
						header('location:seekerdashboard.php?p=' . $p);
					}
					else{
						print_r(mysqli_error($connection));
					}
				}
				else{
					header('location:seekerdashboard-ecv.php?msg=create_cv_first');
				}
			}
	}
?>