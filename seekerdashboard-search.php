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

	
	}
	else{
		header("Location:seekerdashboard.php?search=faild");
	}






?>


<?php //for cancel button 

	

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
					<i class="fas fa-search"></i><input type="text" placeholder="What?" id='what' name="what-search">
				</p>
				<p>
					<i class="fas fa-search"></i><input type="text" placeholder="Where?" id='where' name="where-search">
				</p>
				<p>
					<i class="fas fa-search"></i><input type="text" placeholder="Company?" id='company' name="company-name">
				</p>
				<p><input type="submit" name="find" value="Find Job">
				</p>
			</form>
		</div>

	</div>

	<div class="add-list">
		<div class="all-ads">
						<!-- dynamically added -->
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

	<script>

		//search bar Ajax
		window.addEventListener('load',()=>{
			var what 	= <?php if(!empty($what)){echo "'".$what."'";}else{ echo "''";} ?>;
			var where	= <?php if(!empty($where)){echo "'".$where."'";}else{ echo "''";} ?>;
			var company	= <?php if(!empty($company_name)){echo "'".$company_name."'";}else{ echo "''";} ?>;
			var qualification = "<?php echo $seeker_qualification; ?>";

			$.post('ajax/searchJobs.php',{
				what: what,
				where : where,
				company : company,
				seeker_qualification:qualification
			},function(data){
				document.querySelector('.all-ads').innerHTML = data;
			});
		});

		//search bar ajax
		var what = document.querySelector('#what');
		var where = document.querySelector('#where');
		var company = document.querySelector('#company');
		var qualification = "<?php echo $seeker_qualification; ?>";
		what.addEventListener('keyup',getdata);
		where.addEventListener('keyup',getdata);
		company.addEventListener('keyup',getdata);

		function getdata(){
			whatval = what.value;
			whereval = where.value;
			companyval = company.value;

			$.post('ajax/searchJobs.php',{
				what: whatval,
				where : whereval,
				company : companyval,
				seeker_qualification:qualification
			},function(data){
				document.querySelector('.all-ads').innerHTML = data;
			});
		}
	</script>

<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>
</body>
<?php mysqli_close($connection); ?>
</html>