<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php  
	
	$seeker_username=$_SESSION["username"];
	$seeker_qualification =$_SESSION["qualifi"];

	if (!isset($_SESSION["seeker_id"])) {
		header("Location:index.php");
	}

?>

<?php 
	
	$page_number=1;

	$where = "";
	$what ="";
	$company_name="";

	if (isset($_GET["what-search"]) ||isset($_GET["where-search"]) ||isset($_GET["company-name"])) {
		
			if (isset($_GET["what-search"])) {
				$what=mysqli_real_escape_string($connection,$_GET["what-search"]);
			}
			if (isset($_GET["where-search"])) {
				$where=mysqli_real_escape_string($connection,$_GET["where-search"]);
			}
			if (isset($_GET["company-name"])) {
				$company_name=mysqli_real_escape_string($connection,$_GET["company-name"]);
			}

		
		$query_search = "SELECT * FROM job_ad WHERE is_delete=0 AND active!=0 AND is_expire =0 AND qulification_level ='{$seeker_qualification}' AND location LIKE '%$where%' AND  job_title LIKE '%$what%' AND company_name LIKE '%$company_name%' ORDER BY ad_no DESC";


		$search_result = mysqli_query($connection,$query_search);

		/*if ($search_result) {
			if (mysqli_num_rows($search_result)>0) {
				while ($se=mysqli_fetch_assoc($search_result)) {
				echo $se["job_title"] ." ". $se["location"] . "<br>";
				}
			}
		}
		else{
			echo mysqli_error($connection);
			echo "Result Not Found";
		}*/
	}
	else{
		header("Location:seekerdashboard.php?search=faild");
	}

	//time ago function
	 	date_default_timezone_set('Asia/colombo'); 
	 	 function facebook_time_ago($timestamp){  
      $time_ago = strtotime($timestamp);
      $current_time = time();  
      $time_difference = $current_time - $time_ago;  
      $seconds = $time_difference;  
      $minutes      = round($seconds / 60 );           // value 60 is seconds  
      $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
      $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
      $weeks          = round($seconds / 604800);          // 7*24*60*60;  
      $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
      $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
      if($seconds <= 60)  
      {  
     return "Just Now";  
   }  
      else if($minutes <=60)  
      {  
     if($minutes==1)  
           {  
       return "one minute ago";  
     }  
     else  
           {  
       return "$minutes minutes ago";  
     }  
   }  
      else if($hours <=24)  
      {  
     if($hours==1)  
           {  
       return "an hour ago";  
     }  
           else  
           {  
       return "$hours hrs ago";  
     }  
   }  
      else if($days <= 7)  
      {  
     if($days==1)  
           {  
       return "yesterday";  
     }  
           else  
           {  
       return "$days days ago";  
     }  
   }  
      else if($weeks <= 4.3) //4.3 == 52/12  
      {  
     if($weeks==1)  
           {  
       return "a week ago";  
     }  
           else  
           {  
       return "$weeks weeks ago";  
     }  
   }  
       else if($months <=12)  
      {  
     if($months==1)  
           {  
       return "a month ago";  
     }  
           else  
           {  
       return "$months months ago";  
     }  
   }  
      else  
      {  
     if($years==1)  
           {  
       return "one year ago";  
     }  
           else  
           {  
       return "$years years ago";  
     }  
   }  
 }
 //function for get provider profile pic

 function provider_profile_picture($crm,$connection){

 	$company_registration_number=$crm;
 	$con=$connection;

 	$query_for_get_pp = "SELECT is_image FROM provider WHERE company_registration_number='{$company_registration_number}'";

 	$pp_result = mysqli_query($con,$query_for_get_pp);

 	if ($pp_result) {
 		
 		$is_image_pp=mysqli_fetch_assoc($pp_result);

 		if ($is_image_pp["is_image"]==1) {
 			return "<img src=\"imj/profile_pictures/providers/" . $company_registration_number . ".jpg\"> ";
 		}
 		else{
 			return "<img src=\"imj/profile_pictures/default.jpg\">";
 		}
 	}
 	else{
 		return "<img src=\"imj/profile_pictures/default.jpg\">";
 	}
 }


//function for appliy and cancel button

 	function apply_cancel_button($con,$seeker_id,$ad_no,$company_registration_number,$page_number){

		$connection = $con;

		$button_query = "SELECT * FROM job_apply WHERE seeker_id = '{$seeker_id}' AND ad_no='{$ad_no}' LIMIT 1";

		$button_result = mysqli_query($connection,$button_query);

		if ($button_result) {
			if (mysqli_num_rows($button_result)==1) {
				echo "<form action=\"seekerdashboard.php?p=$page_number\" method=\"POST\" >";
				echo "<input type=\"text\" name=\"ad_no\" value=\"{$ad_no}\" hidden>";
				echo  "<a><button id='button' class=\"cancel\" name=\"cancel\">Cancel</button></a>";
				echo "</form>";
			}
			else{

				echo  "<a href=\"seekerdashboard-apply-ad.php?ad-no={$ad_no}&crn={$company_registration_number}&p={$page_number}\" ><button id='button'>apply</button></a>";
			}
		}
		else{
			printf(mysqli_error($connection));
		}
 	}
?>


<?php //for cancel button 

	if (isset($_POST["cancel"])) {
		
		$ad_no =$_POST["ad_no"];

		$cancel_query = "DELETE FROM job_apply WHERE seeker_id = '{$_SESSION["seeker_id"]}' AND ad_no = {$ad_no} ";

		$cancel_result =mysqli_query($connection,$cancel_query);


	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Seeker DashBoard</title>
	<link rel="stylesheet" href="css/seekerdashboard.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="css/seekerdashboard-main.css">

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/seekerdashboardheader.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/seeker-media.css"><!--media query-->
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

	<div class="search-bar">
		<div class="content-pic">

		</div>
		<div class="search-content">
			<form action="seekerdashboard-search.php" method="GET">
				<p>
					<i class="fas fa-search"></i><input type="text" placeholder="What?" name="what-search">
				</p>
				<p>
					<i class="fas fa-search"></i><input type="text" placeholder="Where?" name="where-search">
				</p>
				<p>
					<i class="fas fa-search"></i><input type="text" placeholder="Company?" name="company-name">
				</p>
				<p><input type="submit" name="find" value="Find Job">
				</p>
			</form>
		</div>

	</div>

	<div class="add-list">
		<div class="all-ads">

			<?php  

				if ($search_result) {
						if (mysqli_num_rows($search_result)>0) {
							echo "<div class = \"result\"><h2>Best Match</h2></div>";
							while ($se=mysqli_fetch_assoc($search_result)) {

								echo '<div class="row">';
									echo "<a href=\"seekerdashboard-vjob.php?ad-no={$se["ad_no"]}&p={$page_number}\">";
										echo '<div class="column1">';
											echo '<div class="image">';
												echo provider_profile_picture($se["company_registration_number"],$connection);
											echo  '</div>';
										echo '</div>';
										echo '<div class="column2">';
											echo '<div class="row1">';
												echo '<h1>' . $se["job_title"] . '</h1>';
											echo '</div>';
											echo '<div class="row2">';
												echo '<h2><i class="fas fa-home"></i>' . $se["company_name"]  . '</h2>';
												echo '<h2><i class="fas fa-map-marker-alt"></i>' . $se["location"] . '</h2>';
												echo '<h2>' . $se["job_category"] . '</h2>';
												echo '<h2><i class="fas fa-coins"></i>RS:'. $se["monthly_salary"] . '</h2>';
											echo  '</div>';
										echo '</div>';
										echo '<div class="column3">';
											echo '<div class="row1">';
												apply_cancel_button($connection,$_SESSION["seeker_id"],$se["ad_no"],$se["company_registration_number"],$page_number);
											echo '</div>';
											echo '<div class="row2">';
												echo '<h2><i class="fas fa-briefcase"></i>' . $se["job_type"] . '</h2>';
												echo '<h2><i class="far fa-clock"></i>' . facebook_time_ago($se["ad_time"]) . '</h2>';
											echo '</div>';
										echo '</div>';
									echo '</a>';		
							echo '</div>';

							}
						}
						else{
							echo "<div class=\"empty-msg\">";
							echo "<h1>No Suggestions Found</h1>";
							echo "</div>";
						}
					}
					else{
						//echo mysqli_error($connection);
						echo "<div class=\"empty-msg\">";
						echo "<h1>No Suggestions Found</h1>";
						echo "</div>";
					}

			?>
			

			<!--<div class="row">
				<a href="#">
					<div class="column1">
						<div class="image">
							<img src="imj/logo1.png" alt="">
						</div>
					</div>
					<div class="column2">
						<div class="row1">
							<h1>job title</h1>
						</div>
						<div class="row2">
							<h2><i class='fas fa-home'></i>company name</h2>
							<h2><i class='fas fa-map-marker-alt'></i>location</h2>
							<h2>category</h2>
							<h2><i class='fas fa-coins'></i>RS:salary</h2>
						</div>
					</div>
					<div class="column3">
						<div class="row1">
							<a href="sdfksdf" onclick="<?php //iscv($connection); ?>" ><button>apply</button></a>
						</div>
						<div class="row2">
							<h2><i class='fas fa-briefcase'></i>job type</h2>
							<h2><i class='far fa-clock'></i>time</h2>
						</div>
					</div>
				</a>
			</div>-->

		</div>
		<div class="row">
			<!--<div class="next-link">
				<div class="next-content">
					<?php 
						/*if (mysqli_num_rows($result_Set)!=0) {
							echo $page_nav;
						}
						else{
							echo "<div class ='empty'>";
							echo "You have not posted any ads yet";
							echo "</div>";
						} */
					?>
				</div>
			</div>-->
		</div>
	</div><!--add-list-->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script>
		//for chang apply button content
		$(function(){
			$('#button').click(function(){
				$('#button').html('applied');
			})
		});

	</script>
<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>
</body>
<?php mysqli_close($connection); ?>
</html>