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


	$query = "SELECT count(ad_no) AS total_number_of_rows FROM job_ad WHERE active !=0 ";

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
		$first ="<a href = 'index.php?p=1&m=ac'>First</a>";

		//link for last page
		$last_page = ceil($total_number_of_rows/$rows_per_page);
		$last ="<a href ='index.php?p={$last_page}&m=ac'>Last</a>";

		//link for next page
		if ($page_number>=$last_page) {
			$last="<a>Last</a>";
			$next="<a>Next</a>";
		}
		else{
			$next_page = $page_number+1;
			$next="<a href = 'index.php?p={$next_page}&m=ac'>Next</a>";
		}
		//link for previous
		if ($page_number==1) {
			$first="<a>First</a>";
			$previous="<a>Previous</a>";
		}
		else{
			$previous_page = $page_number-1;
			$previous="<a href = 'index.php?p={$previous_page}'>Previous</a>";
		}

	//asign page number to list

 		$page_nav = "<ul>";
	 	$page_nav .= "<li>" . $first . "</li>";
	 	$page_nav .= "<li>" . $previous . "</li>";
	 	$page_nav .="<li>" . $page_number . " Of " . $last_page . "</li>";
	 	$page_nav .= "<li>" . $next . "</li>";
	 	$page_nav .= "<li>" . $last . "</li>";
	 	$page_nav .= "</ul>";



	//pagination for inactive table
	$page_nav_inc;
		//pagination for not ac ads
		$query = "SELECT count(ad_no) AS total_number_of_rows FROM job_ad WHERE active=0";

		$result_Set = mysqli_query($connection,$query);

		$ares= mysqli_fetch_assoc($result_Set);

		$total_number_of_inc_rows = $ares["total_number_of_rows"];

		$rows_per_page_inc = 8;

			if (isset($_GET["pi"])) {
				$page_number_inc = $_GET["pi"];
			}
			else{
				$page_number_inc = 1;
			}

			$start_inc = ($page_number_inc-1)*$rows_per_page_inc;

		//link for first page
		$first_inc ="<a href = 'index.php?pi=1&m=inc'>First</a>";

			//link for last page
			$last_page_inc = ceil($total_number_of_inc_rows/$rows_per_page_inc);
			$last_inc ="<a href ='index.php?pi={$last_page_inc}&m=inc'>Last</a>";

			//link for next page
			if ($page_number_inc>=$last_page_inc) {
				$last_inc="<a>Last</a>";
				$next_inc="<a>Next</a>";
			}
			else{
				$next_page_inc = $page_number_inc+1;
				$next_inc="<a href = 'index.php?pi={$next_page_inc}&m=inc'>Next</a>";
			}
			//link for previous
			if ($page_number_inc==1) {
				$first_inc="<a>First</a>";
				$previous_inc="<a>Previous</a>";
			}
			else{
				$previous_page_inc = $page_number_inc-1;
				$previous_inc="<a href = 'index.php?pi={$previous_page_inc}&m=inc'>Previous</a>";
			}

			//asign page number to list
			$page_nav_inc = "<ul>";
			$page_nav_inc .= "<li>" . $first_inc . "</li>";
			$page_nav_inc .= "<li>" . $previous_inc . "</li>";
			$page_nav_inc .="<li>" . $page_number_inc . " Of " . $last_page_inc . "</li>";
			$page_nav_inc .= "<li>" . $next_inc . "</li>";
			$page_nav_inc .= "<li>" . $last_inc . "</li>";
			$page_nav_inc .= "</ul>";

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
				
				echo "<form action =\"index.php?p={$page_no}\" method=\"POST\"'>";
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

	<!-- modal page for show job details -->
	<div class="job_modal_page">
		<div class="job_modal">
			<!-- adding content dynamically -->
		</div>
	</div>
	
	<header>
		<div class="main-row">
			<div class="logo">
				<img src="../imj/logo.svg" alt="logo">
			</div>
			<div class="nav">
				<ul>
					<li class="active"><a href="index.php">job Advertisement</a></li>
					<li><a href="admin-index-seeker.php">seekers</a></li>
					<li><a href="admin-index-provider.php">providers</a></li>
				</ul>
			</div>

				<div class="mob-nav">
					<h3 id="bars"><i class="fas fa-bars"></i></h3>
					<ul id="barul">
						<li class="active"><a href="index.php">job Advertisement</a></li>
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

		<div class="coose_row">
			<ul>
				<li class='ac'>Active Advertisements</li>
				<li >Inactive Advertisements</li>
			</ul>
		</div>

		<div class="ad_section">
			<div class="content">
					<?php 

						$total_ad_query ="SELECT * FROM job_ad WHERE active != 0 ORDER BY ad_no DESC LIMIT {$start},{$rows_per_page} ";

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
										echo "<h2 class='comname' data-pr=".$adds["ad_no"].">" . $adds["job_title"] . "</h2>";
										echo "<h3><i class='fas fa-home'></i>" . $adds["company_name"] . "</h3><h3><i class='fas fa-map-marker-alt'></i>" . $adds["location"] . "</h3><h3><i class='far fa-building'></i>" . $adds["job_category"] . "</h3><h3><i class='fas fa-coins'></i>" . $adds["monthly_salary"] . "</h3><h3><i class='fas fa-briefcase'></i>" . $adds["job_type"] . "</h3>";
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
			<div class="row">
					<div class="next-link">
						<div class="next-content">
							<?php 
								if (mysqli_num_rows($result_Set)!=0 && $total_number_of_rows !=0 ) {
									echo $page_nav;
								}

							?>
						</div>
					</div>
			</div>
		</div>
		<div class="noac_ad" style='display:none'>
			<div class="content">
				<?php 

					$total_ad_query ="SELECT * FROM job_ad WHERE active = 0 ORDER BY ad_no DESC LIMIT {$start_inc},{$rows_per_page_inc} ";

						$ads_result = mysqli_query($connection,$total_ad_query);

							if (mysqli_num_rows($ads_result)!=0) {
									
								echo "<table>";
								echo "<tr><th>Company Logo</th><th>Ad Details</th><th>Upload Time</th><th>Active Ad</th><th>Delete Ad</th></tr>";

									while ($adds = mysqli_fetch_assoc($ads_result)) {
										echo "<tr>";
										echo "<td><div class='table-pic'>" . ad_picture($adds["company_registration_number"],$connection) . "</div></td>";
										echo "<td>";
										echo "<h2 class='comname' data-pr=".$adds["ad_no"].">" . $adds["job_title"] . "</h2>";
										echo "<h3><i class='fas fa-home'></i>" . $adds["company_name"] . "</h3><h3><i class='fas fa-map-marker-alt'></i>" . $adds["location"] . "</h3><h3><i class='far fa-building'></i>" . $adds["job_category"] . "</h3><h3><i class='fas fa-coins'></i>" . $adds["monthly_salary"] . "</h3><h3><i class='fas fa-briefcase'></i>" . $adds["job_type"] . "</h3>";
										echo "</td>";
										echo "<td><h3><i class='far fa-clock'></i>" . facebook_time_ago($adds["ad_time"]) . "</h3></td>";
										echo "<td>";
											echo "<input type='checkbox' name='active' onclick='add(".$adds['ad_no'] .",event)'>";
										echo "</td>";
										echo "<td>";
											delete_button($adds["ad_no"],$page_number,$connection);
										echo "</td>";
										echo "</tr>";
									}
									echo "</table>";
							}
							else{
								echo "<div class='no'> <h2>Don't Have Any Ads Yet..</h2> </div>";
							}
							
				?>
			</div>
			<div class="row">
				<div class="next-link">
					<div class="next-content">
						<?php 
							if (mysqli_num_rows($result_Set)!=0) {
								echo $page_nav_inc;
							}

						?>
					</div>
				</div>
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
			
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script><!--jquery-->

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
			}
			else{
				baul.style.display = "block";
			}

		});

		//for modal page
		const mainmodal = document.querySelector('.job_modal_page');
		const modal =document.querySelector('.job_modal_page .job_modal');
		const page_number = <?php echo $page_number ?>

		window.addEventListener('click',(e)=>{
			if(e.target.className=="comname"){
				let ad_no = e.target.getAttribute('data-pr');
				mainmodal.style.display = 'flex';
				modal.classList.remove("rem");
				modal.classList.add("ad");

				//jquery ajax
				$.post('../ajax/admodel.php',{
					ad_no:ad_no,
					pagenum:page_number
				},function(data){
					modal.innerHTML = data;
				});

			}
		});



		window.addEventListener('click',(e)=>{
			if(e.target.className == "job_modal_page"){
				modal.classList.remove('ad');
				modal.classList.add("rem");
				modal.addEventListener('transitionend',()=>{
					mainmodal.style.display = "none";
				});
			}
		});

		//for active abd inactive tables
		let ele = document.querySelectorAll('.coose_row ul li');

		//check url data
		let url = new URL(window.location.href);

		let tabelcat = url.searchParams.get('m')

		if(tabelcat=='ac'){
			if(ele[0].className != 'ac'){
				ele[1].classList.remove('ac');
				ele[0].classList.add('ac');

				document.querySelector('.noac_ad').style.display = "none";
				document.querySelector('.ad_section').style.display = "block";
			}
		}
		if(tabelcat=='inc'){
			if(ele[1].className != 'ac'){
				ele[0].classList.remove('ac');
				ele[1].classList.add('ac');

				document.querySelector('.noac_ad').style.display = "block";
				document.querySelector('.ad_section').style.display = "none";
			}
		}

		ele[0].addEventListener('click',()=>{
			if(ele[0].className != 'ac'){
				ele[1].classList.remove('ac');
				ele[0].classList.add('ac');

				document.querySelector('.noac_ad').style.display = "none";
				document.querySelector('.ad_section').style.display = "block";
			}
		});
		ele[1].addEventListener('click',()=>{
			if(ele[1].className != 'ac'){
				ele[0].classList.remove('ac');
				ele[1].classList.add('ac');

				document.querySelector('.noac_ad').style.display = "block";
				document.querySelector('.ad_section').style.display = "none";
			}
		});

	</script>

	<script>
		//using ajax add active status on ad
		function add(no,event){
			let companyNumber = no;

			if(event.target.checked){
				$.post('../ajax/admin-active-ad.php',{
					ad_no:companyNumber
				},function(data){
					console.log(data);
				});

				let row = event.target.parentElement.parentElement;

				row.classList.add("rohide");
				row.addEventListener('transitionend',()=>{
					row.style.display = "none";
				});

			}

		}


	</script>

</body>
<?php mysqli_close($connection); ?>
</html>