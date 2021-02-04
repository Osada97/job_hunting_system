<?php require_once("inc/connection.php"); ?>

<?php  
	
	if (!isset($_GET["sid"]) || $_GET["sid"]=="") {

		header("location:providersignin.php?err=please_log_in");
	}
	else{
		
		$seeker_id=$_GET["sid"];

		$query = "SELECT * FROM cv WHERE user_id = '{$seeker_id}' AND is_deleted=0 LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if(mysqli_num_rows($result_set)==1){ //check how many result query has? 

			$pcv=mysqli_fetch_assoc($result_set); //fetch the data

			$is_deleted=$pcv["is_deleted"];

			$first_name="";
			$last_name="";
			$title="";
			$des="";
			$email="";
			$phone="";
			$address="";
			$dob="";
			$in="";
			$fa="";
			$twitter="";
			$git="";
			$eyear="";
			$einstitute="";
			$etitle="";
			$edes="";
			$wyear="";
			$wtitle="";
			$winstitute="";
			$wdes="";
			$stitle="";
			$presentage="";
			$stitle2="";
			$presentage2="";
			$stitle3="";
			$presentage3="";
			$ayear="";
			$atitle="";
			$ainstitute="";
			$ades="";

			$print_ed = "";
			$print_we = "";
			$print_aw = "";
			$sk_prece = "";

			//check is cv is deleted?

			if ($is_deleted==0) {

			$first_name = $pcv["first_name"];
			$last_name = $pcv["last_name"];
			$title = $pcv["title"];
			$des=$pcv["description"];
			$email=$pcv["email"];
			$phone=$pcv["phone_number"];
			$address=$pcv["address"];
			$dob=$pcv["birth_day"];

			//retrieving cv social media details
			$query_sh = "SELECT * FROM sh_media WHERE user_id = {$seeker_id} LIMIT 1";
			$result_sh = mysqli_query($connection,$query_sh);

			$sh_pcv = mysqli_fetch_assoc($result_sh);

			$in=$sh_pcv["linked_in"];
			$fa=$sh_pcv["facebook"];
			$twitter=$sh_pcv["twitter"];
			$git=$sh_pcv["git_hub"];

			//retrieving cv education details
			$query_ed = "SELECT * FROM education WHERE user_id = {$seeker_id}";
			$result_ed = mysqli_query($connection,$query_ed);

			if(mysqli_num_rows($result_ed)>0){

				while($edpr = mysqli_fetch_assoc($result_ed)){

					$print_ed .= '<div class="content">';
					$print_ed .= '<h5>'.$edpr['edu_year']. '</h5>';
					$print_ed .= '<h2>'.$edpr['edu_institute']. '</h2>';
					$print_ed .= '<h3>'.$edpr['edu_title']. '</h3>';
					$print_ed .= '<h4>'.$edpr['edu_description']. '</h4>';
					$print_ed .= '</div>';				
							
				}
			}

			//retrieving cv work details
			$query_we = "SELECT * FROM work_experience WHERE user_id = {$seeker_id}";
			$result_we = mysqli_query($connection,$query_we);

			if(mysqli_num_rows($result_we)>0){

				while($wepr = mysqli_fetch_assoc($result_we)){

					$print_we .= '<div class="content">';
					$print_we .= '<h5>'.$wepr['wk_years']. '</h5>';
					$print_we .= '<h2>'.$wepr['wk_company']. '</h2>';
					$print_we .= '<h3>'.$wepr['wk_title']. '</h3>';
					$print_we .= '<h4>'.$wepr['wk_description']. '</h4>';
					$print_we .= '</div>';				
							
				}
			}

			//retrieving cv awards details
			$query_aw = "SELECT * FROM awards WHERE user_id = {$seeker_id}";
			$result_aw = mysqli_query($connection,$query_aw);

			if(mysqli_num_rows($result_aw)>0){

				while($awpr = mysqli_fetch_assoc($result_aw)){

					$print_aw .= '<div class="content">';
					$print_aw .= '<h5>'.$awpr['aw_year']. '</h5>';
					$print_aw .= '<h2>'.$awpr['aw_institute']. '</h2>';
					$print_aw .= '<h3>'.$awpr['aw_title']. '</h3>';
					$print_aw .= '<h4>'.$awpr['aw_description']. '</h4>';
					$print_aw .= '</div>';				
							
				}
			}

			//fetching data from professional skills
			$professional_query = "SELECT * FROM professional_skills WHERE user_id = {$seeker_id}";
			$professional_result = mysqli_query($connection,$professional_query);

			if(mysqli_num_rows($professional_result)>0){

				while($proRs=mysqli_fetch_assoc($professional_result)){

					$stitle=$proRs["title"];
					$presentage=$proRs["percentage"];

					$sk_prece .= '<div class="content">';
					$sk_prece .= '<h3>'.$stitle.'</h3>';
					$sk_prece .= '<h4><span>'.$presentage.'%</span></h4>';
					$sk_prece .='<div class="presentagebar">';
					$sk_prece .='<div class="bar" style="width:'.$presentage.'%">';
					$sk_prece .='</div>';
					$sk_prece .= '</div>';					
					$sk_prece .= '</div>';	

				}
			}
		}

		}
		else{
			header("location:providerdashboard-vcvl2.php?ad-no={$_GET["ad-no"]}");
		}
	}

	// Function for get profile Picture
 		function seeker_profile_picture($seeker_id,$connection){

 			$seeker_id = $seeker_id;
 			$con=$connection;
 			
 			$query_profile_pic = "SELECT is_image FROM seeker WHERE seeker_id={$seeker_id}";

 			$profile_pic = mysqli_query($con,$query_profile_pic);

 			if ($profile_pic) {
 				
 				$profile_result = mysqli_fetch_assoc($profile_pic);

 				if ($profile_result["is_image"]==1) {
 					return "<img src=\"imj/profile_pictures/seekers/" . $seeker_id . ".jpg\"  >";
 				}
 				else{
 					return "<img src='imj/profile_pictures/default.jpg'  >";
 				}

 			}
 		}
 		/////////////////////////////////////////////////////////
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>VIEW CV</title>
	<link rel="shortcut icon" type="image/jpg" href="imj/icon/fav.png"/>
	<link rel="stylesheet" href="css/previewcv.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/preview-cv-media.css"><!--media query-->
</head>
<body>
	<section id="target">
		<div class="main">
			<div class="pcv">
				<div class="column">
					<div class="row">
						<div class="pic">
							<?php echo seeker_profile_picture($seeker_id,$connection); ?>
						</div>
					</div>
					<div class="row">
						<div class="content">
							<h3>Name:</h3>
							<h3><span><?php echo $first_name;echo " " . $last_name; ?></span></h3>
						</div>
						<div class="content">
							<h3>Title:</h3>
							<h3><span><?php echo $title; ?></span></h3>
						</div>
						<div class="content">
							<h3>Description:</h3>
							<h3><span><?php echo $des; ?></span></h3>
						</div>
					</div>
					<div class="row" id="row">
					
						<?php if(!empty($email)){
							echo '<h4><i class="fas fa-envelope"></i>'.$email.'</h4>';
						} ?>
						<?php if(!empty($phone)){
							echo '<h4><i class="fas fa-phone"></i>'.$phone.'</h4>';
						} ?>
						<?php if(!empty($address)){
							echo '<h4><i class="fas fa-map-marker"></i>'.$address.'</h4>';
						} ?>
						<?php if(!empty($dob)){
							echo '<h4><i class="far fa-calendar-alt"></i>'.$dob.'</h4>';
						} ?>
						<?php if(!empty($in)){
							echo '<h4><i class="fab fa-linkedin"></i>'.$in.'</h4>';
						} ?>
						<?php if(!empty($fa)){
							echo '<h4><i class="fab fa-facebook"></i>'.$fa.'</h4>';
						} ?>
						<?php if(!empty($twitter)){
							echo '<h4><i class="fab fa-twitter"></i>'.$twitter.'</h4>';
						} ?>
						<?php if(!empty($git)){
							echo '<h4><i class="fab fa-github"></i>'.$git.'</h4>';
						} ?>
					</div>
				</div>
				<div class="column">
					<div class="row">
					<h1>Education:</h1>
						<?php echo $print_ed; ?>
					</div>
					<div class="row">
					<h1>Work Experiencs:</h1>
						<?php if(!empty($print_we)){echo $print_we;} ?>
					</div>
					<div class="row">
						<h1>Skills:</h1>
						<?php if(!empty($sk_prece)){echo $sk_prece;} ?>
					</div>
					<div class="row">
						<h1>Award:</h1>
						<?php if(!empty($print_aw)){echo $print_aw;} ?>
					</div>
				</div>
			</div>
		</div>

		<div class="print-but">
			<button id="button"><i class="fas fa-print"></i>Print CV</button>
		</div>

	</section>



	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
	<script src="js/printThis.js"></script>

	<script>

		$(document).ready(function(){

			$('#button').click(function(){

				$("#target").printThis({
						    debug: false,               // show the iframe for debugging
						    importCSS: true,            // import parent page css
						    importStyle: false,         // import style tags
						    printContainer: true,       // print outer container/$.selector
						    loadCSS: "css/previewcv.css",                // path to additional css file - use an array [] for multiple
						    pageTitle: "",              // add title to print page
						    removeInline: false,        // remove inline styles from print elements
						    removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
						    printDelay: 333,            // variable print delay
						    header: null,               // prefix to html
						    footer: null,               // postfix to html
						    base: "http://localhost/php/job_hunting_system/cvpreview.php",                // preserve the BASE tag or accept a string for the URL
						    formValues: true,           // preserve input/form values
						    canvas: false,              // copy canvas content
						    doctypeString: '...',       // enter a different doctype for older markup
						    removeScripts: false,       // remove script tags from print content
						    copyTagClasses: false,      // copy classes from the html & body tag
						    beforePrintEvent: null,     // function for printEvent in iframe
						    beforePrint: null,          // function called before iframe is filled
						    afterPrint: null            // function called before iframe is removed
				});

			});

		});
	</script>


</body>
<?php mysqli_close($connection); ?>
</html>