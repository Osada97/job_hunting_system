<?php ob_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 

	if (isset($_POST["send"])) {
		
		$name = mysqli_real_escape_string($connection,$_POST["name"]);
		$subject = mysqli_real_escape_string($connection,$_POST["subject"]);
		$email = mysqli_real_escape_string($connection,$_POST["email"]);
		$phone_number = mysqli_real_escape_string($connection,$_POST["phone_number"]);
		$msg = mysqli_real_escape_string($connection,$_POST["msg"]);

		$to = "jobbberjobs@gmail.com";
		$mail_subject = "Message From Jobberlk";
		$email_body = "Message From Contact Us Page Of Jobberlk.com <br>";
		$email_body .= "<b>From:</b> {$name} <br>";
		$email_body .= "<b>Subject:</b> {$subject} <br>";
		$email_body .= "<b>Phone Number:</b> {$phone_number}<br>";
		$email_body .= "<b>message:</b> <br>" . nl2br(strip_tags($msg));

		 //nl2br = using this tag for when user going new line and html line give br tags 
		//strip_tags == when user enter html code we can filter using this command;

		$header = "From {$email} \r\nContent-type : text/html;";

		//$mail_is = mail($to, $subject,$email_body,$header);

		if($mail_is == true){
			echo "<script>";
				echo "alert('Successfully  Send The Message ')";
			echo "</script>";
		}
		else{
			echo "<script>";
				echo "alert('Please Try Again')";
			echo "</script>";
		}

	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/contactus.css">
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /><!--style sheet for scroll animation-->

	<link rel="stylesheet" href="css/media-queries/index-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/contactus-media.css"><!--media query-->

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>CONTACT US</title>
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>


</head>
<body>
	<header class="clearfix">

		<div class="logo" data-aos="fade-down">
			<a href="index.php"><img src="imj/logo.svg" alt="LOGO"></a>
		</div>

		<div class="menu" data-aos="fade-down">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="aboutus.php">About Us</a></li>
				<li><a href="contactus.php" class="active">Contact</a></li>
			</ul>
			<div class="mob-nav"><!-- this navigation mobile -->
				<h3><i class="fas fa-bars"></i></h3>
				<ul>
					<li><a href="index.php" class="active">Home</a></li>
					<li><a href="aboutus.php">About Us</a></li>
					<li><a href="contactus.php">Contact</a></li>
				</ul>

			</div><!-- this navigation mobile -->
		</div>

		<div class="but" data-aos="fade-down">
			<button><a href="userlogin.php"><i class="fas fa-sign-in-alt"></i>LOG IN</a></button>
			<button><a href="seekersignup.php"><i class="fas fa-user-plus"></i>SIGN UP</a></button>

			<div class="drop">
				<button class="dropbtn"><a href="#"><i class="fas fa-building"></i>COMPANY</a></button>
					<div class="drop_down">
						<a href="providersignin.php"><i class="fas fa-sign-in-alt"></i>LOG IN</a>
						<a href="providersignup.php"><i class="fas fa-user-plus"></i>SIGN UP</a>
					</div>
			</div>

		</div>

	</header>

	<div class="main-row">
		<h1 data-aos="fade-up">Contact Us</h1>
	</div>

	<div class="contact-tiles">
		<div class="contact-row" data-aos="fade-right">
			<div class="column">
				<div class="icon">
					<i class="fas fa-map-marker-alt"></i>
				</div>
				<div class="content">
					<h2>Location</h2>
					<p>DeCom,Bandarawela Road,Hali-Ela,Badulla,Sri Lanka</p>
				</div>
			</div>
			<div class="column">
				<div class="icon">
					<i class="fas fa-phone"></i>
				</div>
				<div class="content">
					<h2>Phone Number</h2>
					<p>0768597090</p>
					<p>076856032</p>
					<p>0768597090</p>
				</div>
			</div>
			<div class="column">
				<div class="icon">
					<i class="fas fa-at"></i>
				</div>
				<div class="content">
					<h2>Email</h2>
					<p>jobbberjobs@gmail.com</p>
				</div>
			</div>
			<div class="column">
				<div class="icon">
					<i class="fas fa-fax"></i>
				</div>
				<div class="content">
					<h2>Fax</h2>
					<p>(+94)22-54657</p>
					<p>(+94)22-55578</p>
				</div>
			</div>
		</div>
	</div>

	<div class="contact-form">
		<form action="contactus.php" method="POST">
			<div class="contact-form-content">
				<div class="form-header">
					<h1>Lets Get In Touch</h1>
				</div>
				<div class="form-feild">
					<p>
						<input type="text" name="name" placeholder="Enter Your Name" required>
					</p>
					<p>
						<input type="text" name="subject" placeholder="Subject" required>
					</p>
					<p>
						<input type="email" name="email" placeholder="Enter Your Email" required>
					</p>
					<p>
						<input type="text" name="phone_number" placeholder="Enter Your Phone Number" required>
					</p>
					<textarea name="msg" id="" cols="30" rows="10" required></textarea>
				</div>
				<div class="contact-but">
					<button name="send">Send Your Message</button>
				</div>
			</div>
		</form>
	</div>
	
	<footer>
		<?php require_once("inc/footer.php"); ?>
	</footer>

	<script src="https://unpkg.com/aos@next/dist/aos.js"></script><!--scroll animation-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script><!--jQuery CDN-->
 <script>
  	//for mobile navigation
  	$(document).ready(function(){
  		$('.mob-nav h3').click(function(){
  			$('.mob-nav ul').toggle(400);
  		});

  	});
  </script>

	<script>
			//for scroll animation
	    AOS.init({
	    	offset:250,
	    	duration:700,
	    });
	</script>
</body>
</html>