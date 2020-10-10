<?php require_once("inc/connection.php"); ?>

<?php  
	//geting ad details
	$job_query = "SELECT * FROM job_ad WHERE is_delete = 0 ORDER BY ad_no DESC LIMIT 0,5";

	$result_job = mysqli_query($connection,$job_query);


	//query for get total conut of jobs
	$count_query ="SELECT count(ad_no) as total FROM job_ad";

	$result_count = mysqli_query($connection,$count_query);

	$co = mysqli_fetch_assoc($result_count);

	$count = $co["total"];


	//function for get profile pictures of seekers	
	function get_provider_photo($crn,$con){

		$photo_query = "SELECT is_image FROM provider WHERE company_registration_number = '{$crn}' AND is_deleted = 0 LIMIT 1";

		$pic_result = mysqli_query($con,$photo_query);

		if ($pic_result) {
			
			$is = mysqli_fetch_assoc($pic_result);

			if ($is["is_image"]==1) {
				echo "<img src =\"imj/profile_pictures/providers/$crn.jpg\">";
			}
			else{
				echo "<img src ='imj/profile_pictures/default.jpg'>";
			}
		}
	}

	/*getting count of providers seekers ads for counter*/
	$providers_query= "SELECT count(company_registration_number) as company FROM provider WHERE is_deleted =0";
	$seeker_query ="SELECT count(seeker_id) as seekers FROM seeker WHERE is_deleted=0";

	$provider_result = mysqli_query($connection,$providers_query);
	$seeker_result = mysqli_query($connection,$seeker_query);

	$company_count = mysqli_fetch_assoc($provider_result);
	$seekers_count= mysqli_fetch_assoc($seeker_result);

	$company = $company_count["company"];
	$seekers = $seekers_count["seekers"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Jobber</title>
	<link rel="stylesheet" href="css/index.css">
	<!-- <link rel="stylesheet" href="css/media-queries/index-media.css">media query -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"><!--style sheet for testiminal jquery-->
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /><!--style sheet for scroll animation-->
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script><!--font Awsome Script-->

</head>
<body>

	<!-- loading Page -->
	<div class="loading_page">
		<div class="txt">
			<h1>JobberLK</h1>
		</div>
	</div>

	<div class="home">
		<header>

			<div class="logo"  data-aos="fade-down">
				<a href="index.php"><img src="imj/logo.svg" alt="LOGO"></a>
			</div>

			<div class="menu"  data-aos="fade-down">
				<ul>
					<li><a href="index.php" class="active">Home</a></li>
					<li><a href="aboutus.php">About Us</a></li>
					<li><a href="contactus.php">Contact</a></li>
				</ul>

				<!--<div class="mob-nav"><!-- this navigation mobile -->
					<!--<h3><i class="fas fa-bars"></i></h3>
					<ul>
						<li><a href="index.php" class="active">Home</a></li>
						<li><a href="aboutus.php">About Us</a></li>
						<li><a href="contactus.php">Contact</a></li>
					</ul>

				</div>--><!-- this navigation mobile -->

			</div>

			<div class="but"  data-aos="fade-down">
				<a href="userlogin.php"><button><i class="far fa-user"></i>Sign In</button></a>
				<a href="seekersignup.php"><button><i class="fas fa-user-plus"></i>Sign Up</button></a>

			</div>

		</header>

		<div class="slider">

				<div class="slide_show" >
					
							
							<!--<img class="img" src="imj/job2.jpg" alt="finr_job">
							<img class="img" src="imj/job8.jpg" alt="finr_job">-->
							<picture>
								<source media="(max-width:375px),(max-width:414px)" srcset="imj/mobile.jpg">
									<img class="img" src="imj/job12.jpg" alt="finr_job">
							</picture>

				</div>

				<div class="shape clearfix">

					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 250"><path fill="#ffff" fill-opacity="1" d="M0,160L120,144C240,128,480,96,720,90.7C960,85,1200,107,1320,117.3L1440,128L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path></svg>

				</div>


				<div class="pic_on_text">

						<h2><span>Upload</span> CV & Get Your <span>Job</span> </h2>

						<p>Find Jobs, Employment & Career Opportunities</p>
					
				</div>	<!--pic_on_text-->


		</div>	<!--slider-->
		
		<section>
		<div class="company_section clearfix">
			<div class="row1">
				<h1>Top Companies</h1>
			</div><!--row1-->
			<div class="row2">
				<div class="column">
					<img src="imj/bugerKing.png" alt="COMPANY">
					<h3>Burger KING</h3>
					<p><i class="fas fa-map-marker-alt"></i>1st Floor, 00300 Colombo, Sri Lanka</p>
				</div>
				<div class="column">
					<img src="imj/Dialog.jpg" alt="COMPANY">
					<h3>Dialog Axiata PLC</h3>
					<p><i class="fas fa-map-marker-alt"></i>475 Union Pl, Colombo 00200</p>
				</div>
				<div class="column">
					<img src="imj/dominos.jpg" alt="COMPANY">
					<h3>Domino's Pizza</h3>
					<p><i class="fas fa-map-marker-alt"></i>164 Galle Rd, Dehiwala-Mount Lavinia 10350</p>
				</div>
				<div class="column">
					<img src="imj/lolc.jpg" alt="COMPANY">
					<h3>LOLC Holdings PLC</h3>
					<p><i class="fas fa-map-marker-alt"></i>100/1 Sri Jayawardenepura Mawatha, Colombo 10290</p>
				</div>
			</div><!--row2-->


			
		</div><!--company_section-->
		</section>

		<div class="preview_some">
			<div class="content">
				<div class="main_column">
					<div class="heading">
						<h1>Browsing Listing</h1>
						<p>
							<label for="">Job Found</label>
							<input type="text" name="job_found" value="<?php echo $count; ?>"  disabled>
						</p>
					</div>
					<?php  

						if ($result_job) {
							while ($job = mysqli_fetch_assoc($result_job)) {

								echo "<div class=\"row\">";
								echo "<div class=\"column\">";
								echo "<div class=\"picture_bo\">";
								echo  "<div class=\"logo\">";
								echo  get_provider_photo($job["company_registration_number"],$connection);
								echo "</div>";
								echo "</div>";
								echo "</div>";
								echo "<div class=\"column\">";
								echo "<div class=\"job-row1\">";
								echo "<h1>" . $job["job_title"] . "</h1>";
								echo "</div>";
								echo "<div class=\"job-row2\">";
								echo "<h2><i class=\"fas fa-home\"></i>" . $job["company_name"] . "</h2>";
								echo "<h2><i class=\"fas fa-map-marker-alt\"></i>" . $job["location"] . "</h2>";
								echo "<h2><i class=\"far fa-building\"></i>" . $job["job_category"] . "</h2>";
								echo "<h2><i class=\"fas fa-coins\"></i>" . $job["monthly_salary"] . "</h2>";
								echo "</div>";
								echo "</div>";
								echo "<div class=\"column\">";
								echo "<div class=\"job-but\">";
								echo "<div class=\"job-row\">";
								echo "<a href =\"userlogin.php\"><button>Apply</button></a>";
								echo "</div>";
								echo "<div class=\"job-row2\">";
								echo "<h4><i class=\"fas fa-briefcase\"></i>" . $job["job_type"] . "</h4>";
								echo "<h4><i class=\"far fa-clock\"></i>Upload Time</h4>";
								echo "</div>";
								echo "</div>";
								echo "</div>";
								echo "</div>";

							}
						}


					?>
					<!--<div class="row">
						<div class="column">
							<div class="picture_bo">
								<div class="logo">
									<img src="imj/logo1.png" alt="">
									<h2>osada</h2>
								</div>
							</div>
						</div>
						<div class="column">
							<div class="job-row1">
								<h1>Job title</h1>
							</div>
							<div class="job-row2">
								<h2><i class="fas fa-home"></i>Company Name</h2>
								<h2><i class="fas fa-map-marker-alt"></i>location</h2>
								<h2>job catogery</h2>
								<h2><i class="fas fa-coins"></i>Salary</h2>
							</div>
						</div>
						<div class="column">
							<div class="job-but">
								<div class="job-row">
									<button>Apply</button>
								</div>
								<div class="job-row2">
									<h4><i class="fas fa-briefcase"></i>job type</h4>
									<h4><i class="far fa-clock"></i>Upload Time</h4>
								</div>
							</div>
						</div>
					</div>-->
				</div>
			</div>
		</div><!--prevview some jobs-->
		
		<div class="easy_way">

			<div class="row1" data-aos="fade-right">
				<h1>Easiest Way To Use</h1>
			</div><!--row1-->
			
			<div class="row2"  data-aos="fade-left">

					<div class="easy_content">
						<h5>01<span></span></h5>
						<img src="imj/jobsearch.jpg" alt="">
						<h5>Browser Job</h5>
						<p>Create an account and access your saved settings on any device.</p>
					</div><!--easy_content-->

					<div class="easy_content">
						<h5>02<span></span></h5>
						<img src="imj/findVacncie.jpg" alt="">
						<h5>Find Your Job</h5>
						<p>Don't just find. Be found. Put your CV in front of great employers.</p>
					</div><!--easy_content-->

					<div class="easy_content">
						<h5>03</h5>
						<img src="imj/sumitcv.jpg" alt="">
						<h5>Submit Your CV</h5>
						<p>Your next career move starts here. Choose Job from thousands of companies</p>
					</div><!--easy_content-->
										
			</div><!--row2-->
		
		</div><!--easy_way-->


		<div class="testiminal_section">
			<div class="testiminal ">
				<div class="row1">
					<h1>Client Say About Us</h1>
				</div>
				<div class="row2 owl-carousel"><!--owl-carousel-->
					<div class="column">
						<div class="row1">
							<p><span><i class="fas fa-quote-left"></i></span>Jobber is an excellent job portal. We value the CV received through this Site. And Posting Advertiwstments Is Easy In This Site. We are delighted with their service.</p>
						</div>
						<div class="row2">
							<img src="imj/people/01.jpg" alt="">
							<h4>John Smith</h4>	
							<h5>Project Maneger</h5>	
						</div>
					</div>
					<div class="column">
						<div class="row1">
							<p><span><i class="fas fa-quote-left"></i></span>This Site Is very user-friendly in terms of searching for Jobs. Also, they have an excellent database to search for Jobs. And Most Important Thing Is This Whole Web Site Is Very User Friendly. And There Are Thousand Jobs In this In various Categories. Even I Cant Select One Advertisement LOL!!.So I Apply For A Lot</p>
						</div>
						<div class="row2">
							<img src="imj/people/03.jpg" alt="">	
							<h4>Nimani</h4>	
							<h5>Seeker</h5>
						</div>
					</div>
					<div class="column">
						<div class="row1">
							<p><span><i class="fas fa-quote-left"></i></span>Now I Am A Successful Person It's Because I Found A job In the helping Of this Site. In Two Months Earlier I have Nothing And I Search Jobs Using News Papers And I Applied But Nothing Happen. And I Saw This Site And I Apply Job Using This Site. Now I Am A Successful Person. Thank You Jobber!!</p>
						</div>
						<div class="row2">
							<img src="imj/people/02.jpg" alt="">
							<h4>Ilmina Malshan</h4>	
							<h5>Web Developer</h5>
						</div>
					</div>
				</div>
			</div>

			
		</div><!--testiminal_secton-->


		<div class="pic_get_job" >
			<div class="pic">
				<picture>
					<source media="(max-width:375px),(max-width:414px)" srcset="imj/mobile_start.jpg">
					<img src="imj/start.jpg" alt="">
				</picture>
			</div>
			<div class="over-text">
				<h3  data-aos="fade-right">Post OR Get a job</h3>
				<h1  data-aos="fade-right">Looking for Post OR Get a job? We have end-to-end solutions that can keep up with your criteria.</h1>
				<p>
					<a href="providersignin.php"><button  data-aos="zoom-in">Post a Job</button></a>
					<a href="userlogin.php"><button  data-aos="zoom-in">Browse A job</button></a>
				</p>
			</div>
		</div><!--pic_get_job-->

		<div class="why_you_choose">
			<div class="main" >
				<div class="main_column">
					<div class="first_row">
						<h1>Why You Choose Job Among Other Site?</h1>
					</div>
						<div class="column">
							<div class="column-content">
								<i class="fas fa-users"></i>
								<h2>Best talented people</h2>
								<p>If success is a process with a number of defined steps.</p>
							</div>
						</div>
						<div class="column">
							<div class="column-content">
								<i class="far fa-comments"></i>
								<h2>Easy to communicate</h2>
								<p>Having clarity of purpose and a clear picture of what you desire.</p>
							</div>
						</div>
						<div class="column">
							<div class="column-content">
								<i class="fas fa-search"></i>
								<h2>Easy to find candidate</h2>
								<p>Introspection is the trick. Understand what you want.</p>
							</div>
						</div>
						<div class="column">
							<div class="column-content">
								<i class="fas fa-globe-americas"></i>
								<h2>Global recruitment option</h2>
								<p>There are basically six key areas to higher achievement.</p>
							</div>
						</div>	
				</div>
				<div class="main_column">
					<img src="imj/why.jpg" alt="">
				</div>
			</div>
		</div><!--why_you_choose-->
		<div class="counter">
			<div class="content">
				<div class="column">
					<img src="imj/icon/seeker.png" alt="">
					<div class="subcoun">
						<div class="numbers" data-target="<?php echo $seekers ?>">0 </div>
						<p>Seekers</p>
					</div>
				</div>
				<div class="column">
					<img src="imj/icon/ad.png" alt="">
					<div class="subcoun">
						<div class="numbers" data-target="<?php echo $count; ?>">0 </div>
						<p>Advertisement</p>
					</div>
				</div>
				<div class="column">
					<img src="imj/icon/work.png" alt="">
					<div class="subcoun">
						<div class="numbers" data-target="<?php echo $company ?>">0 </div>
						<p>Providers</p>
					</div>
				</div>
			</div>
		</div><!--counter-->
	</div><!--home-->

	<footer>
		<div class="simple_box">
				<div class="main_row">
					<div class="column">
						<div class="sub_column">
							<i class="fas fa-users"></i>
						</div>
						<div class="sub_column">
							<h4>Jobseeker</h4>
							<h1>Looking For Job?</h1>
							<a href="userlogin.php">Find A Job<i class="fas fa-arrow-right"></i></a>
						</div>
					</div>
					<div class="column">
						<div class="sub_column">
							<i class="fas fa-briefcase"></i>
						</div>
						<div class="sub_column">
							<h4>Recruiter</h4>
							<h1>Are You Recruiting?</h1>
							<a href="providersignin.php">Post A Job<i class="fas fa-arrow-right"></i></a>
						</div>
					</div>
				</div>
		</div>
		<div class="big_footer">
			<div class="footer_svg">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 250"><path fill="#fff" fill-opacity="1" d="M0,192L120,170.7C240,149,480,107,720,112C960,117,1200,171,1320,197.3L1440,224L1440,0L1320,0C1200,0,960,0,720,0C480,0,240,0,120,0L0,0Z"></path></svg>
			</div>
			
			<div class="footer-main">
				<div class="row">
					<div class="column">
						<h1>About Jobber</h1>
						<p>Post job free in JObber.Seekers Apply for a job and submit Your CV And connected With Great Companies.Search Jobs All over County Using This site And Apply Online Easily.</p>
					</div>
					<div class="column">
						<a href="#">
						
							<h1>Download App</h1>
							<h3>Download <span>Jobber</span> App Now</h3>
							<div class="store-row">
								<div class="store-icon">
									<i class="fab fa-google-play"></i>
								</div>
								<h3>Download On The</h3>
								<h3>Google Play</h3>
							</div>
						</a>		
						<a href="#">
							<div class="store-row">
								<div class="store-icon">
									<i class="fab fa-apple"></i>
								</div>
								<h3>Download On The</h3>
								<h3>App Store</h3>
							</div>	
						</a>
					</div>		
					<div class="column">
						<h1>Contact Us</h1>
						<h3>Jobber</h3>
						<h3>DeCom,Bandarawela Road,Hali-Ela,Badulla,Sri Lanka</h3>
						<h3>Osada:0768597090</h3>
						<h3>Malshan:076856032</h3>
						<h3>Supun:0768597090</h3>
						<h3>Tharindu:076855690</h3>
						<h3>Navod:071237650</h3>
						<h3>Praveen:0768789090</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="small_footer">
			<div class="column">
				<ul>
					<li><a href="aboutus.php">About US</a></li>
					<li><a href="userlogin.php">Seeker Sign In</a></li>
					<li><a href="providersignin.php">Post Job(Free)</a></li>
					<li><a href="contactus.php">Contact</a></li>
				</ul>
			</div>
			<div class="column">
				<h3>© Copyright 2020 <span>Team Repeaters</span> All Rights Reserved</h3>
			</div>
		</div>
	</footer>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script><!--jQuery CDN-->
	<script src="http://malsup.github.com/jquery.cycle2.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sticky/1.0.4/jquery.sticky.min.js"></script><!--sticky plug in-->
	<script src="https://unpkg.com/aos@next/dist/aos.js"></script><!--scroll animation-->

	<script>
		//testiminal
		$('.owl-carousel').owlCarousel({
    loop:true,
    autoplay:true,
    //autoplayTimeout:3000,
    smartSpeed: 3500,
    autoplayHoverPause:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
})
	</script>
	<script>
		//counter
		const counters =document.querySelectorAll(".numbers");
		const speed =200000;

		counters.forEach(numbers => {
			const updateCount = () =>{
				const target = +numbers.getAttribute('data-target');

				const count =+numbers.innerText;

				const inc = target/speed;

				if (count < target) {
					numbers.innerText = Math.ceil(count + inc);
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
		//slide show

		/*const slideshowImages =document.querySelectorAll(".slide_show img");

		const nextImageDelay =3000;
		let currentImageCounter =0;

		//slideshowImages[currentImageCounter].style.display ="block";
		slideshowImages[currentImageCounter].style.opacity = 1;

		setInterval(nextImage, nextImageDelay);


		function nextImage() {
			//slideshowImages[currentImageCounter].style.display ="none";
			slideshowImages[currentImageCounter].style.opacity =0;
			currentImageCounter =(currentImageCounter+1)%slideshowImages.length;
			//slideshowImages[currentImageCounter].style.display ="block";
			slideshowImages[currentImageCounter].style.opacity =1;
		}*/
	</script>
	<script>
		//sticky nav
		$(document).ready(function(){
			$("header").sticky({
				topSpacing:0,
				'zIndex':"100",
			});

			$(window).on("scroll",function(){
				if ($(window).scrollTop()) {
					$("header").css("overflow", "visible");
				}
				else{
					$("header").css("overflow", "auto");
				}

			});
		});
	</script>
	

	
  <script>
  	//for scroll animation
    AOS.init({
    	offset:25,
    	duration:700,
    });
  </script>

  <script>
  	//for mobile navigation
  	$(document).ready(function(){
  		$('.mob-nav h3').click(function(){
  			$('.mob-nav ul').toggle(400);
  		});

  	});
  </script>

	<script>
		//loader
		let text = document.querySelector('.txt h1').innerHTML;
		let textlength = text.length;
		let remindex = text.length;
		let index =0;
		
		(function type(){
			if(textlength == index){
				let remcontent = text.slice(0,--remindex);
				document.querySelector('.txt h1').textContent = remcontent;

				if(remindex == 1){
					console.log(remcontent);
					index =0;
				}
			}
			else{
				let newcontent = text.slice(0,++index);
				document.querySelector('.txt h1').textContent = newcontent;

				if(index == text.length){
					remindex = textlength;
				}
			}

				setTimeout(type,500);
		}());

		window.addEventListener('load',function(){
			document.getElementsByClassName('loading_page')[0].style.display = 'none';
		});

	</script>

</body>
<?php mysqli_close($connection); ?>
</html>