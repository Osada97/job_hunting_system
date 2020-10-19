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


	$query = "SELECT count(seeker_id) AS total_number_of_rows FROM seeker";

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
		$first ="<a href = 'admin-index-seeker.php?p=1'>First</a>";

		//link for last page
		$last_page = ceil($total_number_of_rows/$rows_per_page);
		$last ="<a href ='admin-index-seeker.php?p={$last_page}'>Last</a>";

		//link for next page
		if ($page_number>=$last_page) {
			$last="<a>Last</a>";
			$next="<a>Next</a>";
		}
		else{
			$next_page = $page_number+1;
			$next="<a href = 'admin-index-seeker.php?p={$next_page}'>Next</a>";
		}
		//link for previous
		if ($page_number==1) {
			$first="<a>First</a>";
			$previous="<a>Previous</a>";
		}
		else{
			$previous_page = $page_number-1;
			$previous="<a href = 'admin-index-seeker.php?p={$previous_page}'>Previous</a>";
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
	function ad_picture($sid,$con){

		$ad_pic_query = "SELECT is_image FROM seeker WHERE seeker_id = '{$sid}'";

		$result_ad_pic = mysqli_query($con,$ad_pic_query);

			if ($result_ad_pic) {

				$ad_pic = mysqli_fetch_assoc($result_ad_pic);

				if ($ad_pic["is_image"]==1) {
					
					return "<img src ='../imj/profile_pictures/seekers/{$sid}.jpg'>";
				}
				else{
					return "<img src ='../imj/profile_pictures/default.jpg'>";
				}
			}
			else{
				return "<img src ='../imj/profile_pictures/default.jpg'>";
			}
	}

?>

<?php  
	
	//function for show button
	function delete_button($sid,$page_no,$con){

		$delete_query = "SELECT is_deleted FROM seeker WHERE seeker_id='{$sid}' LIMIT 1";

		$delete_result = mysqli_query($con,$delete_query);

		if ($delete_query) {
			
			$delete_ad = mysqli_fetch_assoc($delete_result);

			echo "<form action =\"admin-index-seeker.php?p={$page_no}\" method=\"POST\" style='float:left;'>";
			echo "<input type=\"text\" name=\"seeker_id\" value=\"{$sid}\" hidden>";

				if ($delete_ad["is_deleted"]==1) {
					
					echo "<button class='restore' name='restore'><i class='fas fa-trash-restore'></i></button>";
					
				}
				else{
					echo "<a href=\"#\" onclick=\"return confirm('Are You Sure?');\"><button class='delete' name='delete'><i class='far fa-trash-alt'></i></button></a>";
				}
			echo "</form>";
		}

	}


	if (isset($_POST["restore"])) {
		
		$restore_query ="UPDATE seeker SET is_deleted = 0 WHERE seeker_id = '{$_POST['seeker_id']}' LIMIT 1";

		$result_restore = mysqli_query($connection,$restore_query);//restore provide

		if ($result_restore) {

			$delete_all_ad_query="UPDATE cv SET is_deleted=0 WHERE user_id='{$_POST['seeker_id']}'";
			$delete_all_ad_result=mysqli_query($connection,$delete_all_ad_query);//restore provide ads

				if ($delete_all_ad_result) {
					
				}
				else{
					print_r(mysqli_error($connection));
				}
		}
		else{
			print_r(mysqli_error($connection));
		}
	}

	if (isset($_POST["delete"])) {
		
		$delete_query ="UPDATE seeker SET is_deleted = 1 WHERE seeker_id = '{$_POST['seeker_id']}' LIMIT 1";

		$result_delete = mysqli_query($connection,$delete_query);//delete provider

		if ($result_delete) {
			$delete_all_ad_query="UPDATE cv SET is_deleted=1 WHERE user_id='{$_POST['seeker_id']}'";
			$delete_all_ad_result=mysqli_query($connection,$delete_all_ad_query);//delete provider ads

				if ($delete_all_ad_result) {
					
				}
				else{
					print_r(mysqli_error($connection));
				}
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

<style>

/*style for admin-index-orvider*/

.section-content .content table tr td:nth-child(2){
	width: 100px;
}
.section-content .content table tr td:nth-child(3) h2 i{
	margin-right: 5px;
	font-size: 15px;
}
.section-content .content table tr td:nth-child(4) button{
	margin-left: 32px;
}



</style>

<body>

	<header>
		<div class="main-row">
			<div class="logo">
				<img src="../imj/logo.svg" alt="logo">
			</div>
			<div class="nav">
				<ul>
					<li><a href="admin-index-ad.php">job Advertisement</a></li>
					<li class="active"><a href="admin-index-seeker.php">seekers</a></li>
					<li><a href="admin-index-provider.php">providers</a></li>
				</ul>
			</div>

				<div class="mob-nav">
					<h3 id="bars"><i class="fas fa-bars"></i></h3>
					<ul id="barul">
						<li><a href="admin-index-ad.php">job Advertisement</a></li>
						<li class="active"><a href="admin-index-seeker.php">seekers</a></li>
						<li><a href="admin-index-provider.php">providers</a></li>
					</ul>
				</div>

			<div class="welcome">
				<h3>welcome admin!!</h3>
			</div>
		</div>
	</header>

	<div class="big-row">
		<h1>Seekers</h1>
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

					$total_ad_query ="SELECT * FROM seeker ORDER BY seeker_id DESC  LIMIT {$start},{$rows_per_page} ";

					$ads_result = mysqli_query($connection,$total_ad_query);

						if (mysqli_num_rows($ads_result)!=0) {
							
							 echo "<table>";
							 echo "<tr><th>No</th><th>Seeker Profile Picture</th><th>Seeker Details</th><th>Status</th></tr>";

							 $x=($page_number-1)*$rows_per_page;
								 while ($adds = mysqli_fetch_assoc($ads_result)) {
								 	echo "<tr>";
								 	echo "<td>" . ++$x . "</td>";
								 	echo "<td><div class='table-pic'>" . ad_picture($adds["seeker_id"],$connection) . "</div></td>";
								 	echo "<td>";
								 	echo "<h2><i class='fas fa-home'></i>" . $adds["first_name"] . " " . $adds["last_name"] . "</h2>";
								 	echo "<h3><i class='fas fa-phone'></i>" . $adds["phone_number"] . "</h3><h3><i class='fas fa-envelope'></i>" . $adds["email"] . "</h3>";
								 	echo "</td>";
								 	echo "<td>";
								 		delete_button($adds["seeker_id"],$page_number,$connection);
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