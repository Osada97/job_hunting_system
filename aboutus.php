<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ABOUT US</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/aboutus.css">
	<link rel="stylesheet" href="css/media-queries/index-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/aboutus-media.css"><!--aboutus media query-->
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /><!--style sheet for scroll animation-->
</head>
<body>
<header>

	<div class="logo"  data-aos="fade-down">
		<a href="index.php"><img src="imj/logo.svg" alt="LOGO"></a>
	</div>

	<div class="menu"  data-aos="fade-down">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="aboutus.php"  class="active">About Us</a></li>
			<li><a href="contactus.php">Contact</a></li>
		</ul>

		<div class="mob-nav"><!-- this navigation mobile -->
			<h3><i class="fas fa-bars"></i></h3>
			<ul>
				<li><a href="index.php">Home</a><i class="fas fa-chevron-down"></i></li>
				<li><a href="aboutus.php"  class="active">About Us</a><i class="fas fa-chevron-down"></i></li>
				<li><a href="contactus.php">Contact</a><i class="fas fa-chevron-down"></i></li>
			</ul>

		</div><!-- this navigation mobile -->
		<div class="mob-nav2"><!-- this navigation mobile -->
			<h3><i class="fas fa-bars"></i></h3>
			<ul>
				<li><a href="index.php">Home</a><i class="fas fa-chevron-down"></i></li>
				<li><a href="aboutus.php"  class="active">About Us</a><i class="fas fa-chevron-down"></i></li>
				<li><a href="contactus.php">Contact</a><i class="fas fa-chevron-down"></i></li>
				<li><a href="mainlogin.php"></i>Sign In</a><i class="far fa-user"></i></li>
				<li><a href="mainsignup.php">Sign Up</a><i class="fas fa-user-plus"></i></li>
			</ul>

		</div><!-- this navigation mobile -->

	</div>

	<div class="but"  data-aos="fade-down">
		<a href="mainlogin.php"><button><i class="far fa-user"></i>Sign In</button></a>
		<a href="mainsignup.php"><button><i class="fas fa-user-plus"></i>Sign Up</button></a>

	</div>

</header>


	<div class="main-row">
		<h1 data-aos="fade-up">About Us</h1>
	</div>
	<div class="about-content">
		<div class="content" data-aos="fade-right">
			<p><span>JOBBER </span>Is Place You can Find Your job OR You can Find your Candidate.<span>JOBBER </span>Is Very Simple And Very Efficient Site.IF You Are Job Seeker,Then You have  Simply Steps to Follow.First Of All You Have to Sign In to site.After Sign In to site You Can see various Jobs In Various category.So Pick One Your Choice And Apply It.IF you are a job provider,Then You Have To login first and Post Your advertisement In Our <span>JOBBER </span> Site.And Most Important Thing THis Service Is Free.</p><br>

			<p>Your Job vacancies will receive added exposure through <a href="www.facebook.com/jober"><span>JOBBER</span></a> Social media page.</p>

		</div>
	</div>
	<div class="main-pic">
		<img src="imj/aboutus.jpg" alt="">
	</div>
	<div class="tiels">
		<div class="row">
			<div class="column" data-aos="fade-down">
				<div class="icon">
					<i class="fas fa-ad"></i>
				</div>
				<div class="content">
					<h3>Advertise A Job</h3>
					<p>You can Easily Post Your Company Vacancies.</p>
				</div>
			</div>
			<div class="column" data-aos="fade-left">
				<div class="icon">
					<i class="fas fa-tools"></i>
				</div>
				<div class="content">
					<h3>Enjoy Free Service</h3>
					<p>To Apply And Post Advertisement Is Free!</p>
				</div>
			</div>
			<div class="column" data-aos="fade-down">
				<div class="icon">
					<i class="fas fa-search"></i>
				</div>
				<div class="content">
					<h3>Find Your Dream Job</h3>
					<p>Find Your Job Through Thousand of Jobs!!</p>
				</div>
			</div>
		</div>
	</div>

	<footer>
		<?php require_once("inc/footer.php"); ?>
	</footer>

	<script src="https://unpkg.com/aos@next/dist/aos.js"></script><!--scroll animation-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script><!--jQuery CDN-->
	
	<script src='js/mobilenav.js'>//for mobile navigation </script>

	<script>
		//for scroll animation
    AOS.init({
    	offset:200,
    	duration:700,
    });
	</script>
</body>
</html>