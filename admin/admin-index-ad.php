<?php require_once("../inc/connection.php"); ?>

<?php  
 
 	//Foe Mini Box 
	$ad_query ="SELECT count(ad_no) as ad_count FROM job_ad WHERE is_delete=0";
	$provider_query ="SELECT count(company_registration_number) as company_count FROM provider WHERE is_deleted=0";
	$seeker_query ="SELECT count(seeker_id) as seeker_count FROM seeker WHERE is_deleted=0";

	$ad_result = mysqli_query($connection,$ad_query);
	$provider_result = mysqli_query($connection,$provider_query);
	$seeker_result = mysqli_query($connection,$seeker_query);

	$ad=mysqli_fetch_assoc($ad_result);
	$pro=mysqli_fetch_assoc($provider_result);
	$see=mysqli_fetch_assoc($seeker_result);

	$ad_count = $ad["ad_count"];
	$company_count = $pro["company_count"];
	$seeker_count = $see["seeker_count"];

?>

<?php 


	$query = "SELECT count(ad_no) AS total_number_of_rows FROM job_ad";

	$result_Set = mysqli_query($connection,$query);

	$res= mysqli_fetch_assoc($result_Set);

	$total_number_of_rows = $res["total_number_of_rows"];

	$rows_per_page = 8;

	if (isset($_GET["p"])) {
		$page_number = $_GET["p"];
	}
	else{
		$page_number = 1;
	}

	$start = ($page_number-1)*$rows_per_page;

		//link for first page
		$first ="<a href = 'admin-index-ad.php?p=1'>First</a>";

		//link for last page
		$last_page = ceil($total_number_of_rows/$rows_per_page);
		$last ="<a href ='admin-index-ad.php?p={$last_page}'>Last</a>";

		//link for next page
		if ($page_number>=$last_page) {
			$last="<a>Last</a>";
			$next="<a>Next</a>";
		}
		else{
			$next_page = $page_number+1;
			$next="<a href = 'admin-index-ad.php?p={$next_page}'>Next</a>";
		}
		//link for previous
		if ($page_number==1) {
			$first="<a>First</a>";
			$previous="<a>Previous</a>";
		}
		else{
			$previous_page = $page_number-1;
			$previous="<a href = 'admin-index-ad.php?p={$previous_page}'>Previous</a>";
		}

	//asign page number to list

 		$page_nav = "<ul>";
	 	$page_nav .= "<li>" . $first . "</li>";
	 	$page_nav .= "<li>" . $previous . "</li>";
	 	$page_nav .="<li>" . $page_number . " Of " . $last_page . "</li>";
	 	$page_nav .= "<li>" . $next . "</li>";
	 	$page_nav .= "<li>" . $last . "</li>";
	 	$page_nav .= "</ul>";



	//function for get company Logo
	function ad_picture($crn,$con){

		$ad_pic_query = "SELECT is_image FROM provider WHERE company_registration_number = '{$crn}'";

		$result_ad_pic = mysqli_query($con,$ad_pic_query);

			if ($result_ad_pic) {

				$ad_pic = mysqli_fetch_assoc($result_ad_pic);

				if ($ad_pic["is_image"]==1) {
					
					return "<img src ='../imj/profile_pictures/providers/{$crn}.jpg'>";
				}
				else{
					return "<img src ='../imj/profile_pictures/default.jpg'>";
				}
			}
			else{
				return "<img src ='../imj/profile_pictures/default.jpg'>";
			}
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

?>

<?php  
	
	//function for show button
	function delete_button($ad_no,$page_no,$con){

		$delete_query = "SELECT is_delete FROM job_ad WHERE ad_no={$ad_no} LIMIT 1";

		$delete_result = mysqli_query($con,$delete_query);

		if ($delete_query) {
			
			$delete_ad = mysqli_fetch_assoc($delete_result);

			if ($delete_ad["is_delete"]==1) {
				
				echo "<form action =\"admin-index-ad.php?p={$page_no}\" method=\"POST\"'>";
				echo "<input type=\"text\" name=\"ad_no\" value=\"{$ad_no}\" hidden>";
				echo "<button class='restore' name='restore'><i class='fas fa-trash-restore'></i></button>";
				echo "</form>";
			}
			else{
				echo "<a href=\"delete-ad.php?ad_no={$ad_no}&p={$page_no}\" onclick=\"return confirm('Are You Sure?');\"><button class='delete'><i class='far fa-trash-alt'></i></button></a>";
			}
		}

	}


	if (isset($_POST["restore"])) {
		
		$restore_query ="UPDATE job_ad SET is_delete = 0 WHERE ad_no = {$_POST['ad_no']} LIMIT 1";

		$result_restore = mysqli_query($connection,$restore_query);

		if ($result_restore) {
			# code...
		}
		else{
			print_r(mysqli_error($connection));
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ADMIN</title>
	<link rel="stylesheet" href="admin-index-ad.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="admin-index-ad-media.css"><!--media query-->
</head>
<body>

	<header>
		<div class="main-row">
			<div class="logo">
				<img src="../imj/logo.svg" alt="logo">
			</div>
			<div class="nav">
				<ul>
					<li class="active"><a href="admin-index-ad.php">job Advertisement</a></li>
					<li><a href="admin-index-seeker.php">seekers</a></li>
					<li><a href="admin-index-provider.php">providers</a></li>
				</ul>
			</div>

				<div class="mob-nav">
					<h3 id="bars"><i class="fas fa-bars"></i></h3>
					<ul id="barul">
						<li class="active"><a href="admin-index-ad.php">job Advertisement</a></li>
						<li><a href="admin-index-seeker.php">seekers</a></li>
						<li><a href="admin-index-provider.php">providers</a></li>
					</ul>
				</div>

			<div class="welcome">
				<h3>welcome admin!!</h3>
			</div>
		</div>
	</header>

	<div class="big-row">
		<h1>job Advertisement</h1>
	</div>

	<div class="mini-box-row">
		<div class="box-row">
			<div class="column">
				<div class="sub-column-icon">
					<i class="far fa-user"></i>
				</div>
				<div class="sub-column1">
					<h3>seekers</h3>
				</div>
				<div class="counter" data-target="<?php echo $seeker_count ?>">0</div>
			</div>
			<div class="column">
				<div class="sub-column-icon">
					<i class="fas fa-audio-description"></i>
				</div>
				<div class="sub-column1">
					<h3>job Advertisement</h3>
				</div>
				<div class="counter" data-target="<?php echo $ad_count ?>">0</div>
			</div>
			<div class="column">
				<div class="sub-column-icon">
					<i class="far fa-building"></i>
				</div>
				<div class="sub-column1">
					<h3>providers</h3>
				</div>
				<div class="counter" data-target="<?php echo $company_count ?>">0</div>
			</div>
		</div>
	</div>

	<div class="section-content">
		<div class="content">
				<?php 

					$total_ad_query ="SELECT * FROM job_ad ORDER BY ad_no DESC LIMIT {$start},{$rows_per_page} ";

					$ads_result = mysqli_query($connection,$total_ad_query);

						if (mysqli_num_rows($ads_result)!=0) {
							
							 echo "<table>";
							 echo "<tr><th>No</th><th>Company Logo</th><th>Ad Details</th><th>Upload Time</th><th>Status</th></tr>";

							 $x=($page_number-1)*8;
								 while ($adds = mysqli_fetch_assoc($ads_result)) {
								 	echo "<tr>";
								 	echo "<td>" . ++$x . "</td>";
								 	echo "<td><div class='table-pic'>" . ad_picture($adds["company_registration_number"],$connection) . "</div></td>";
								 	echo "<td>";
								 	echo "<h2>" . $adds["job_title"] . "</h2>";
								 	echo "<h3><i class='fas fa-home'></i>" . $adds["company_name"] . "</h3><h3><i class='fas fa-map-marker-alt'></i>" . $adds["location"] . "</h3><h3>" . $adds["job_category"] . "</h3><h3><i class='fas fa-coins'></i>" . $adds["monthly_salary"] . "</h3><h3><i class='fas fa-briefcase'></i>" . $adds["job_type"] . "</h3>";
								 	echo "</td>";
								 	echo "<td><h3><i class='far fa-clock'></i>" . facebook_time_ago($adds["ad_time"]) . "</h3></td>";
								 	echo "<td>";
								 		delete_button($adds["ad_no"],$page_number,$connection);
								 	//echo "<button><i class='far fa-eye'></i></button>";
								 	echo "</td>";
								 	echo "</tr>";
								 }
								 echo "</table>";;
						}
						else{
							echo "<div class='no'> <h2>Don't Have Any Ads Yet..</h2> </div>";
						}

				?>

				<!--<table>
					<tr><td>No</td><td>Company Logo</td><td>Company Details</td><td>Company Status</td></tr>
					<tr>
						<td>0</td>
						<td><img src="../imj/logo1.png"></td>
						<td>
							<h2>Ad title</h2>
							<h3>Company Name</h3>
							<h3>Location</h3>
							<h3>Category</h3>
							<h3>Salary</h3>
							<h3>job type</h3>
							<h3>upload Time</h3>
						</td>
						<td>
							<p>delete</p>
							<p>view</p>
						</td>
					</tr>
				</table>-->
		</div>
	</div>
	<div class="row">
			<div class="next-link">
				<div class="next-content">
					<?php 
						if (mysqli_num_rows($result_Set)!=0) {
							echo $page_nav;
						}

					?>
				</div>
			</div>
	</div>

<footer>
	<div class="small_footer">
	<div class="small_column">
		<ul>
			<li><a href="../aboutus.php">About US</a></li>
			<li><a href="../userlogin.php">Seeker Sign In</a></li>
			<li><a href="../providersignin.php">Post Job(Free)</a></li>
			<li><a href="../contactus.php">Contact</a></li>
		</ul>
	</div>
	<div class="small_column">
		<h3>© Copyright 2020 <span>Team Repeaters</span> All Rights Reserved</h3>
	</div>
</div>
</footer>

	<script>
		const counters =document.querySelectorAll(".counter");
		const speed =20000000000;

		counters.forEach(counter => {
			const updateCount = () =>{
				const target = +counter.getAttribute('data-target');

				const count =+counter.innerText;

				const inc = target/speed;

				if (count < target) {
					counter.innerText = Math.ceil(count + inc);
					setTimeout(updateCount, 1);
				}
				else{
					count.innerText = target;
				}

			}
			updateCount();
		});
	</script>

	<script>
		var ba = document.getElementById('bars');
		var baul=document.getElementById('barul');

		ba.addEventListener("click",function(){


			if (baul.style.display=="block") {
				baul.style.display="none";
				console.log("asda");
			}
			else{
				baul.style.display = "block";
			}

			
		});
	</script>
</body>
<?php mysqli_close($connection); ?>
</html>