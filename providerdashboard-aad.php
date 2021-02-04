<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 

	date_default_timezone_set('Asia/colombo');
	
	$company_name = $_SESSION["company_name"];

	if (!isset($_SESSION["company_registration_number"])) {
		header("location:index.php");
	}

 ?>
 <?php 

 	$company_registration_number=$_SESSION["company_registration_number"];
 	$job_title="";
 	$email="";
 	$phone_number="";
 	$company_url="";
 	$location="";

 	$query = "SELECT * FROM provider WHERE company_registration_number='{$company_registration_number}' LIMIT 1";

 	$result = mysqli_query($connection,$query);

 	if (mysqli_num_rows($result)==1) {
 		
 		$details=mysqli_fetch_assoc($result);

 		$email = $details["company_email"];
 		$phone_number = $details["company_phone_number"];
 		$company_url =$details["company_website"];

 		if ($details["is_deleted"]==1) {
 			header("location:index.php");
 		}
 	}

 ?>

 <?php  

 	$error = array();

 			$job_category="Choose Category...";
 			$minimum_qualification="No Minimum Qualification";
 			$maximum_age="No Maximum Age";
 			$minimum_age="No Minimum Age";
 			$qulification_level = "no minimum qualification";
 			$gender="any";
 			$description="";

	if (isset($_POST["submit"])) {

			$job_title = $_POST["job_title"];
			$email = $_POST["email"];
			$phone_number = $_POST["phone_number"];
			$job_category = $_POST["job_category"];
			$maximum_age=$_POST["maximum_age"];
			$minimum_age=$_POST["minimum_age"];
			$minimum_qualification=$_POST["minimum_qualification"];
			$gender=$_POST["gender"];
			$qulification_level=$_POST["qulification"];
			$description=$_POST["description"];
			$expire_tiem =$_POST["datetime"];

	 		if (empty(trim($_POST["job_title"]))) {
	 			$error[] = "Please Enter Job Title";
	 		}
	 		if (empty(trim($_POST["email"]))) {
	 			$error[] = "Please Enter Company Email";
	 		}
	 		if (!isset($_POST["location"])) {
	 			$error[] = "Please Enter Location";
	 		}
	 		if (empty(trim($_POST["phone_number"]))) {
	 			$error[] = "Please Enter Company Phone Number";
	 		}
	 		if ($_POST["job_category"] == "Choose category…") {
	 			$error[] = "Please Enter Job Category";
			 }
			 if(empty($expire_tiem)){
			 	$nextmonth = strtotime('+1 Months');
				$expire_tiem = date('y-m-d- h:i:s',$nextmonth);
			 }


	 		$max_len_fields = array("job_title" =>200 ,"email" =>100 ,"phone_number" =>20);

	 		foreach ($max_len_fields as $fields => $value) {
	 			if (trim(strlen($_POST[$fields]))>$value) {
	 				$error[]= str_replace("_", " ", $fields) . " must be Less than " . $value . " charcters";
	 			}
	 		}


	 		if (empty($error)) {

	 			$job_title=mysqli_real_escape_string($connection,$_POST["job_title"]);
	 			$email=mysqli_real_escape_string($connection,$_POST["email"]);
	 			$company_url=mysqli_real_escape_string($connection,$_POST["company_url"]);

	 			$location =implode(",",$_POST["location"]);//convert array to String

	 			$job_type=mysqli_real_escape_string($connection,$_POST["job_type"]);
	 			$phone_number=mysqli_real_escape_string($connection,$_POST["phone_number"]);
	 			$monthly_salary=mysqli_real_escape_string($connection,$_POST["monthly_salary"]);
	 			$job_category=mysqli_real_escape_string($connection,$_POST["job_category"]);
	 			$gender=mysqli_real_escape_string($connection,$_POST["gender"]);
	 			$maximum_age=mysqli_real_escape_string($connection,$_POST["maximum_age"]);
	 			$minimum_age=mysqli_real_escape_string($connection,$_POST["minimum_age"]);
	 			$minimum_qualification=mysqli_real_escape_string($connection,$_POST["minimum_qualification"]);
	 			$qulification_level=mysqli_real_escape_string($connection,$_POST["qulification"]);
	 			$description=mysqli_real_escape_string($connection,$_POST["description"]);
	 			
	 			$query = "INSERT INTO job_ad (company_registration_number,company_name,job_title,email,company_url,location,job_type,phone_number,monthly_salary,job_category,gender,maximum_age,minimum_age,minimum_qualification,qulification_level,description,ad_time,expire_time,is_delete) VALUES ('{$company_registration_number}','{$company_name}','{$job_title}','{$email}','{$company_url}','{$location}','{$job_type}','{$phone_number}','{$monthly_salary}','{$job_category}','{$gender}','{$maximum_age}','{$minimum_age}','{$minimum_qualification}','{$qulification_level}','{$description}',NOW(),'{$expire_tiem}',0)";

	 			$result = mysqli_query($connection,$query);

	 			if ($result) {
	 				echo "<script> alert('Sucessfully Add Job Advertiestment'); </script>";
	 				header('Location:providerdashboard-ea.php');
	 			}
	 			else{
	 				$error[]="Query Error";
	 				echo mysqli_error($connection);
	 			}
	 		}

	 	} 	

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Company DashBoard</title>
	<link rel="shortcut icon" type="image/jpg" href="imj/icon/fav.png"/>
	<link rel="stylesheet" href="css/provider_dashboard.css">
	<link rel="stylesheet" href="css/provider_dashboard_aad.css">
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>
	<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

	<link rel="stylesheet" href="js/multi-chooser/chosen.min.css">

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/providerDashboard-header-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/providerDashboard-add-media.css"><!--media query-->
	
</head>
<body>
	
	<header>
		<div class="main">
			<div class="row">
				<div class="column">
					<div class="seeker-pic">
						<?php 

							if ($_SESSION["is_image_pro"]==1) {
								echo "<img src=\"imj/profile_pictures/providers/" . $company_registration_number . ".jpg\"> ";
							}
							else{
								echo "<img src=\"imj/profile_pictures/default.jpg\">";
							}

						 ?>
					</div>
					<div class="upload-pro-pic">
						<a href="providerdashboard-ema.php"><button><i class="fas fa-pencil-alt"></i></button></a>
					</div>
				</div>
				<div class="column">
					<div class="seeker-name">
						<h2><?php echo $company_name; ?></h2>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section>
		<div class="navi">
			<ul>
				<li><i class="fas fa-caret-down"></i><a href="providerdashboard-ea.php">My Advertisement</a></li>
				<li class="active"><i class="fas fa-caret-down"></i><a href="providerdashboard-aad.php">Add Advertisement</a></li>
				<li><i class="fas fa-caret-down"></i><a href="providerdashboard-vcvl.php">View CV list</a></li>
				<li class="drop-down"><i class="fas fa-caret-down"></i>Account Settings
						<div class="drop-down-content">
										<a href="providerdashboard-ema.php">Edit My Account</a>
										<a href="providerdashboard-cmp.php">Change Password</a>
										<a href="providerdashboard-dma.php">Delete My Account</a>
							</div>
				</li>			
				<li><i class="fas fa-power-off"></i><a href="logout.php">Log Out</a></li>
			</ul>
		</div>
	</section>

	<div class="section">
		<div class="add-content">
			<div class="row1">
				<div class="header">
					<h2>Post A New advertisement</h2>
				</div>
			</div>
			<div class="error">
				
				<?php 

					foreach ($error as  $value) {
						echo "<p>" . $value . "</p>";
					}

				 ?>

			</div>
			<form action="providerdashboard-aad.php" method="post">
				<div class="row2">
					<p>
						<label for="">Job Title</label>
						<input type="text" name="job_title" value="<?php echo $job_title; ?>">
					</p>
					<div class="sect">
						<p>
							<label for="">Email</label>
							<input type="email" name="email" value="<?php echo $email; ?>">
						</p>
						<p>
							<label for="">Company URL</label>
							<input type="text" name="company_url" value="<?php echo $company_url; ?>">
						</p>
					</div>
					<div class="sect">
					<p>
						<label for="">Job Category</label>
						<select name="job_category" id="">
							
							<option value="<?php echo $job_category; ?>" hidden><?php echo $job_category; ?></option>
				            <option value="Choose category…">Choose category…</option>
				            <option value="Accounting/Finance/Auditing">Accounting/Finance/Auditing</option>
				            <option value="Admin/Clerk/Office Assistant">Admin/Clerk/Office Assistant</option>
				            <option value="Agriculture/Dairy/Fisheries">Agriculture/Dairy/Fisheries</option>
				            <option value="Apparel/Garment/Clothing">Apparel/Garment/Clothing</option>
				            <option value="Architecture/Interior/Design">Architecture/Interior/Design</option>
				            <option value="Automotive/Aviation">Automotive/Aviation</option>
				            <option value="Banking/Finance">Banking/Finance</option>
				            <option value="BPO/KPO">BPO/KPO</option>
				            <option value="Business Development/Strategy/Corporate Planning">Business Development/Strategy/Corporate Planning</option>
				            <option value="Carpentry/Woodwork/Furniture">Carpentry/Woodwork/Furniture</option>
				           	<option value="Cashier">Cashier</option>
				           	<option value="Cleaning/Maintenance">Cleaning/Maintenance</option>
				           	<option value="Construction/Civil Engineering/QS">Construction/Civil Engineering/QS</option>
				            <option value="Consultancy/Coordination">Consultancy/Coordination</option>
				            <option value="Customer Relations/Public Relations">Customer Relations/Public Relations</option>
				            <option value="Customer Support/Call Centre">Customer Support/Call Centre</option>
				            <option value="Data Entry/Data Formatting/Type Setting">Data Entry/Data Formatting/Type Setting</option>
				            <option value="Data Entry/Payroll">Data Entry/Payroll</option>
				            <option value="Design/Art/Photography">Design/Art/Photography</option>
				            <option value="Driver/Chauffeur/Transport">Driver/Chauffeur/Transport</option>
				            <option value="Education/Teaching/Academic">Education/Teaching/Academic</option>
				            <option value="Electronics/Electrical">Electronics/Electrical</option>
				            <option value="Energy/Utilities">Energy/Utilities</option>
				            <option value="Engineering">Engineering</option>
				            <option value="Entertainment/Modeling/Acting">Entertainment/Modeling/Acting</option>
				           	<option value="Fashion/Design/Beauty">Fashion/Design/Beauty</option>
				            <option value="Food/Beverage/Catering">Food/Beverage/Catering</option>
				            <option value="General labor/Other">General labor/Other</option>
				            <option value="Government/Civil service">Government/Civil service</option>
				            <option value="Hospitality/Tourism">Hospitality/Tourism</option>
				            <option value="Hotels/Restaurants">Hotels/Restaurants</option>
				           	<option value="Housemaid/Caregiver">Housemaid/Caregiver</option>
				            <option value="HR/Recruitment/Training">HR/Recruitment/Training</option>
				           	<option value="Imports/Exports/Trading">Imports/Exports/Trading</option>
				            <option value="Insurance">Insurance</option>
				            <option value="International">International</option>
				            <option value="IT/Hardware/Network/System Admin">IT/Hardware/Network/System Admin</option>
				            <option value="IT/Programming">IT/Programming</option>
				            <option value="IT/Software/Web/Database/QA">IT/Software/Web/Database/QA</option>
				            <option value="Legal/Law/Risk/Compliance">Legal/Law/Risk/Compliance</option>
				            <option value="Leisure/Tourism/Travel">Leisure/Tourism/Travel</option>
				            <option value="Lifeguard/Safety/First Aid">Lifeguard/Safety/First Aid</option>
				            <option value="Logistics/Warehouse/Transport">Logistics/Warehouse/Transport</option>
				            <option value="Maintenance/Technical/Repair">Maintenance/Technical/Repair</option>
				            <option value="Management/Analysts">Management/Analysts</option>
				            <option value="Manufacturing/Industrial/Operations">Manufacturing/Industrial/Operations</option>
				            <option value="Mason/Plumber/Helper">Mason/Plumber/Helper</option>
				            <option value="Media/Advertising/PR/Communications">Media/Advertising/PR/Communications</option>
				            <option value="Medical/Health/Pharmaceutical">Medical/Health/Pharmaceutical</option>
				            <option value="Mobile Apps/Android/IOS/Windows">Mobile Apps/Android/IOS/Windows</option>
				            <option value="Motor Mechanics">Motor Mechanics</option>
				            <option value="Multimedia/Animations/Graphic Designing">Multimedia/Animations/Graphic Designing</option>
				            <option value="Music/Composing/Entertainment">Music/Composing/Entertainment</option>
				            <option value="NGO/Charity">NGO/Charity</option>
				            <option value="Office Admin/Secretarial/Receptionist">Office Admin/Secretarial/Receptionist</option>
				            <option value="Other">Other</option>
				            <option value="Procurement/Supply Chain">Procurement/Supply Chain</option>
				            <option value="Project Management">Project Management</option>
				            <option value="Property/Housing/Real Estate">Property/Housing/Real Estate</option>
				            <option value="Psychology/Counseling">Psychology/Counseling</option>
				            <option value="Quality Control & Assurance">Quality Control & Assurance</option>
				          	<option value="R & D/Science/Research">R & D/Science/Research</option>
				          	<option value="Retail/Trading/Services">Retail/Trading/Services</option>
				          	<option value="Sales/Marketing/Merchandising">Sales/Marketing/Merchandising</option>
				          	<option value="Seaman/Sailor/Marine">Seaman/Sailor/Marine</option>
				            <option value="Security">Security</option>
				          	<option value="Sound & Visual Engineering">Sound & Visual Engineering</option>
				          	<option value="Sports/Fitness/Recreational">Sports/Fitness/Recreational</option>
				          	<option value="Supervision/Quality Control">Supervision/Quality Control</option>
				          	<option value="Tailor/Clothing/Design">Tailor/Clothing/Design</option>
				          	<option value="Telecommunication/Network">Telecommunication/Network</option>
				          	<option value="Ticketing/Airline/Marine">Ticketing/Airline/Marine</option>
				          	<option value="Training/Development/Coaching">Training/Development/Coaching</option>
				          	<option value="Transport/Logistics">Transport/Logistics</option>
				          	<option value="Veterinary/Animal Care">Veterinary/Animal Care</option>
				            <option value="Welder/Painter/Helper">Welder/Painter/Helper</option>
						</select>
					</p>
					<p>
						<label for="">Job Type</label>
						<select name="job_type" id="">
							<option value="Full Time">Full Time</option>
							<option value="Part Time">Part Time</option>
							<option value="Government">Government</option>
							<option value="Contract">Contract</option>
							<option value="Internship">Internship</option>
							

						</select>
					</p>
				</div>
				<div class="sect">
					<p>
						<label for="">Phone Number</label>
						<input type="text" name="phone_number" value="<?php echo $phone_number ?>">
					</p>
					<p>
						<label for="">Monthly Salary(RS)</label>
						<select name="monthly_salary" id="">
							<option value="Not spacified">Not Spacified</option>
							<option value="Up to 25000">Up to 25000</option>
							<option value="25000 - 50000">25000 - 50000</option>
							<option value="50000 - 100000">50000 - 100000</option>
							<option value="100000 - 200000">100000 - 200000</option>
							<option value="200000 - 300000">200000 - 300000</option>
							<option value="300000 - 400000">300000 - 400000</option>
							<option value="400000 - 500000">400000 - 500000</option>
							<option value="Above 500000">Above 500000</option>
						</select>
					</p>
				</div>
				<div class="sect">
				<p>
						<label for="">Location</label>
						<select name="location[]" id="location"  value="<?php echo $location; ?>" multiple>
							<option value="Agunukolapelessa">Agunukolapelessa</option>
				            <option value="Ahangama">Ahangama</option>
				            <option value="Ahungalla">Ahungalla</option>
				            <option value="Akkaraipattu">Akkaraipattu</option>
				            <option value="Akurana">Akurana</option>
				            <option value="Akuressa">Akuressa</option>
				            <option value="Alawwa">Alawwa</option>
				            <option value="Aluthgama">Aluthgama</option>
				            <option value="Ambalangoda">Ambalangoda</option>
				            <option value="Ambalantota">Ambalantota</option>
				            <option value="Ambuldeniya">Ambuldeniya</option>
				            <option value="Ampara">Ampara</option>
				            <option value="Angoda">Angoda</option>
				            <option value="Anuradhapura">Anuradhapura</option>
				            <option value="Aralaganwila">Aralaganwila</option>
				            <option value="Arangala">Arangala</option>
				            <option value="Athurugiriya">Athurugiriya</option>
				            <option value="Attidiya">Attidiya</option>
				            <option value="Avissawella">Avissawella</option>
				            <option value="Baddegama">Baddegama</option>
				            <option value="Badulla">Badulla</option>
				            <option value="Balagolla">Balagolla</option>
				            <option value="Balangoda">Balangoda</option>
				            <option value="Balapitiya">Balapitiya</option>
				            <option value="Balummahara">Balummahara</option>
				            <option value="Bambalapitiya">Bambalapitiya</option>
				            <option value="Bandaragama">Bandaragama</option>
				            <option value="Bandarawela">Bandarawela</option>
				            <option value="Batapola">Batapola</option>
				            <option value="Battaramulla">Battaramulla</option>
				            <option value="Batticaloa">Batticaloa</option>
				            <option value="Beliatta">Beliatta</option>
				            <option value="Belihuloya">Belihuloya</option>
				            <option value="Belummahara">Belummahara</option>
				            <option value="Bemmulla">Bemmulla</option>
				            <option value="Bentota">Bentota</option>
				            <option value="Beruwala">Beruwala</option>
				            <option value="Bibile">Bibile</option>
				            <option value="Bingiriya">Bingiriya</option>
				            <option value="Biyagama">Biyagama</option>
				            <option value="Boralesgamuwa">Boralesgamuwa</option>
				            <option value="Borella">Borella</option>
				            <option value="Bothale Ihalagama">Bothale Ihalagama</option>
				            <option value="Bulathkohupitiya">Bulathkohupitiya</option>
				            <option value="Buthgamuwa">Buthgamuwa</option>
				            <option value="Buttala">Buttala</option>
				            <option value="Chavakacheri">Chavakacheri</option>
				            <option value="Chilaw">Chilaw</option>
				            <option value="Chunnakam">Chunnakam</option>
				            <option value="Coimbatore">Coimbatore</option>
				            <option value="Colombo 01">Colombo 01</option>
				            <option value="Colombo 02">Colombo 02</option>
				            <option value="Colombo 03">Colombo 03</option>
				            <option value="Colombo 04">Colombo 04</option>
				            <option value="Colombo 05">Colombo 05</option>
				            <option value="Colombo 06">Colombo 06</option>
				            <option value="Colombo 07">Colombo 07</option>
				            <option value="Colombo 08">Colombo 08</option>
				            <option value="Colombo 09">Colombo 09</option>
				            <option value="Colombo 10">Colombo 10</option>
				            <option value="Colombo 11">Colombo 11</option>
				            <option value="Colombo 12">Colombo 12</option>
				            <option value="Colombo 13">Colombo 13</option>
				            <option value="Colombo 14">Colombo 14</option>
				            <option value="Colombo 15">Colombo 15</option>
				            <option value="Colombo All">Colombo All</option>
				            <option value="Dalugama">Dalugama</option>
				            <option value="Dambulla">Dambulla</option>
				            <option value="Dankotuwa">Dankotuwa</option>
				            <option value="Dehiattakandiya">Dehiattakandiya</option>
				            <option value="Dehiowita">Dehiowita</option>
				            <option value="Dehiwala">Dehiwala</option>
				            <option value="Delgoda">Delgoda</option>
				            <option value="Delkanda">Delkanda</option>
				            <option value="Deniyaya">Deniyaya</option>
				            <option value="Depanama">Depanama</option>
				            <option value="Deraniyagala">Deraniyagala</option>
				            <option value="Digana">Digana</option>
				            <option value="Dikwella">Dikwella</option>
				            <option value="Divulapitiya">Divulapitiya</option>
				            <option value="Diyathalawa">Diyathalawa</option>
				            <option value="Dompe">Dompe</option>
				            <option value="Eheliyagoda">Eheliyagoda</option>
				            <option value="Ekala">Ekala</option>
				            <option value="Elakanda">Elakanda</option>
				            <option value="Ella">Ella</option>
				            <option value="Elpitiya">Elpitiya</option>
				            <option value="Embilipitiya">Embilipitiya</option>
				            <option value="Eppawala">Eppawala</option>
				            <option value="Eravur">Eravur</option>
				            <option value="Ethul Kotte">Ethul Kotte</option>
				            <option value="Ettampitiya">Ettampitiya</option>
				            <option value="Galagedara">Galagedara</option>
				            <option value="Galawewa">Galawewa</option>
				            <option value="Galawilawatta">Galawilawatta</option>
				            <option value="Galenbindunuwewa">Galenbindunuwewa</option>
				            <option value="Galewela">Galewela</option>
				            <option value="Galgamuwa">Galgamuwa</option>
				            <option value="Galigamuwa">Galigamuwa</option>
				            <option value="Galle">Galle</option>
				            <option value="Galnewa">Galnewa</option>
				            <option value="Gampaha">Gampaha</option>
				            <option value="Gampola">Gampola</option>
				            <option value="Ganemulla">Ganemulla</option>
				            <option value="Gangodawila">Gangodawila</option>
				            <option value="Gelioya">Gelioya</option>
				            <option value="Ginigathhena">Ginigathhena</option>
				            <option value="Giriulla">Giriulla</option>
				            <option value="Godagama">Godagama</option>
				            <option value="Gothatuwa">Gothatuwa</option>
				            <option value="Habarana">Habarana</option>
				            <option value="Hakmana">Hakmana</option>
				            <option value="Hali-ela">Hali-ela</option>
				            <option value="Hambantota">Hambantota</option>
				            <option value="Hanwella">Hanwella</option>
				            <option value="Haputale">Haputale</option>
				            <option value="Harispattuwa">Harispattuwa</option>
				            <option value="Hatton">Hatton</option>
				            <option value="Hettipola">Hettipola</option>
				            <option value="Hikkaduwa">Hikkaduwa</option>
				            <option value="Hingurakgoda">Hingurakgoda</option>
				            <option value="Hingurana">Hingurana</option>
				            <option value="Hingurangala">Hingurangala</option>
				            <option value="Hokandara">Hokandara</option>
				            <option value="Homagama">Homagama</option>
				            <option value="Horana">Horana</option>
				            <option value="Hungama">Hungama</option>
				            <option value="Ibbagamuwa">Ibbagamuwa</option>
				            <option value="Imaduwa">Imaduwa</option>
				            <option value="Ingiriya">Ingiriya</option>
				            <option value="Ja-Ela">Ja-Ela</option>
				            <option value="Jaffna">Jaffna</option>
				            <option value="Kadana">Kadana</option>
				            <option value="Kadawatha">Kadawatha</option>
				            <option value="Kadugannawa">Kadugannawa</option>
				            <option value="Kaduruwela">Kaduruwela</option>
				            <option value="Kaduwela">Kaduwela</option>
				            <option value="Kahatuduwa">Kahatuduwa</option>
				            <option value="Kahawatta">Kahawatta</option>
				            <option value="Kalagedihena">Kalagedihena</option>
				            <option value="Kalapaluwawa">Kalapaluwawa</option>
				            <option value="Kalawana">Kalawana</option>
				            <option value="Kaleliya">Kaleliya</option>
				            <option value="Kalmunai">Kalmunai</option>
				            <option value="Kalmunai">Kalmunai</option>
				            <option value="Kalpitiya">Kalpitiya</option>
				            <option value="Kaluaggala">Kaluaggala</option>
				            <option value="Kalubowila">Kalubowila</option>
				            <option value="Kaluthara">Kaluthara</option>
				            <option value="Kamburugamuwa">Kamburugamuwa</option>
				            <option value="Kamburupitiya">Kamburupitiya</option>
				            <option value="Kandana">Kandana</option>
				            <option value="Kandy">Kandy</option>
				            <option value="Karapitiya">Karapitiya</option>
				            <option value="Katana">Katana</option>
				            <option value="Kataragama">Kataragama</option>
				            <option value="Kattankudy">Kattankudy</option>
				            <option value="Katubedda">Katubedda</option>
				            <option value="Katugastota">Katugastota</option>
				            <option value="Katunayake">Katunayake</option>
				            <option value="Katuneriya">Katuneriya</option>
				            <option value="Katuwana">Katuwana</option>
				            <option value="Kebithigollewa">Kebithigollewa</option>
				            <option value="Kegalle">Kegalle</option>
				            <option value="Kekanadura">Kekanadura</option>
				            <option value="Kekirawa">Kekirawa</option>
				            <option value="Kelaniya">Kelaniya</option>
				            <option value="Kerawalapitiya">Kerawalapitiya</option>
				            <option value="Kesbewa">Kesbewa</option>
				            <option value="Kilinochchi">Kilinochchi</option>
				            <option value="Kimbulapitiya">Kimbulapitiya</option>
				            <option value="Kiribathgoda">Kiribathgoda</option>
				            <option value="Kirinda">Kirinda</option>
				            <option value="Kirulapone">Kirulapone</option>
				            <option value="Kitulgala">Kitulgala</option>
				            <option value="Kochchikade">Kochchikade</option>
				            <option value="Koggala">Koggala</option>
				            <option value="Kohuwala">Kohuwala</option>
				            <option value="Kollupitiya">Kollupitiya</option>
				            <option value="Kolonnawa">Kolonnawa</option>
				            <option value="Koralawella">Koralawella</option>
				            <option value="Korathota">Korathota</option>
				            <option value="Kosgama">Kosgama</option>
				            <option value="Kosgoda">Kosgoda</option>
				            <option value="Koswatta">Koswatta</option>
				            <option value="Kotadeniyawa">Kotadeniyawa</option>
				            <option value="Kotahena">Kotahena</option>
				            <option value="Kothalawala">Kothalawala</option>
				            <option value="Kotikawatta">Kotikawatta</option>
				            <option value="Kottawa">Kottawa</option>
				            <option value="Kotte">Kotte</option>
				            <option value="Kuliyapitiya">Kuliyapitiya</option>
				            <option value="Kundasale">Kundasale</option>
				            <option value="Kuruna">Kuruna</option>
				            <option value="Kurunegala">Kurunegala</option>
				            <option value="Kuruwita">Kuruwita</option>
				            <option value="Mabima">Mabima</option>
				            <option value="Mabola">Mabola</option>
				            <option value="Madampitiya">Madampitiya</option>
				            <option value="Madiwela">Madiwela</option>
				            <option value="Madola">Madola</option>
				            <option value="Magammana">Magammana</option>
				            <option value="Mahabage">Mahabage</option>
				            <option value="Mahara">Mahara</option>
				            <option value="Maharagama">Maharagama</option>
				            <option value="Mahiyanganaya">Mahiyanganaya</option>
				            <option value="Makola">Makola</option>
				            <option value="Makumbura">Makumbura</option>
				            <option value="Malabe">Malabe</option>
				            <option value="Malkaduwawa">Malkaduwawa</option>
				            <option value="Malwana">Malwana</option>
				            <option value="Mannar">Mannar</option>
				            <option value="Maradana">Maradana</option>
				            <option value="Marawila">Marawila</option>
				            <option value="Matale">Matale</option>
				            <option value="Matara">Matara</option>
				            <option value="Mathugama">Mathugama</option>
				            <option value="Mattakkuliya">Mattakkuliya</option>
				            <option value="Mattala">Mattala</option>
				            <option value="Matugama">Matugama</option>
				            <option value="Mawanella">Mawanella</option>
				            <option value="Mawathagama">Mawathagama</option>
				            <option value="Medawachchiya">Medawachchiya</option>
				            <option value="Medirigiriya">Medirigiriya</option>
				            <option value="Meegoda">Meegoda</option>
				            <option value="Meepe">Meepe</option>
				            <option value="Meethotamulla">Meethotamulla</option>
				            <option value="Menikhinna">Menikhinna</option>
				            <option value="Mihintale">Mihintale</option>
				            <option value="Minuwangoda">Minuwangoda</option>
				            <option value="Mirigama">Mirigama</option>
				            <option value="Mirissa">Mirissa</option>
				            <option value="Modara">Modara</option>
				            <option value="Monaragala">Monaragala</option>
				            <option value="Moratuwa">Moratuwa</option>
				            <option value="Morawaka">Morawaka</option>
				            <option value="Mount Lavinia">Mount Lavinia</option>
				            <option value="Mullaitivu">Mullaitivu</option>
				            <option value="Mulleriyawa North">Mulleriyawa North</option>
				            <option value="Mulleriyawa South">Mulleriyawa South</option>
				            <option value="Nainamadama">Nainamadama</option>
				            <option value="Narahenpita">Narahenpita</option>
				            <option value="Narammala">Narammala</option>
				            <option value="Nattandiya">Nattandiya</option>
				            <option value="Naula">Naula</option>
				            <option value="Navinna">Navinna</option>
				            <option value="Nawagamuwa">Nawagamuwa</option>
				            <option value="Nawala">Nawala</option>
				            <option value="Nawalapitiya">Nawalapitiya</option>
				            <option value="Negombo">Negombo</option>
				            <option value="Nelliady">Nelliady</option>
				            <option value="Nikaweratiya">Nikaweratiya</option>
				            <option value="Nilaveli">Nilaveli</option>
				            <option value="Nittambuwa">Nittambuwa</option>
				            <option value="Nivithigala">Nivithigala</option>
				            <option value="Nochchiyagama">Nochchiyagama</option>
				            <option value="Nugegoda">Nugegoda</option>
				            <option value="Nuwara Eliya">Nuwara Eliya</option>
				            <option value="Oddamavadi">Oddamavadi</option>
				            <option value="Okkampitiya">Okkampitiya</option>
				            <option value="Orugodawatta">Orugodawatta</option>
				            <option value="Oruwala">Oruwala</option>
				            <option value="Padiyatalawa">Padiyatalawa</option>
				            <option value="Padukka">Padukka</option>
				            <option value="Pahalawela">Pahalawela</option>
				            <option value="Palapathwela">Palapathwela</option>
				            <option value="Palau">Palau</option>
				            <option value="Palaviya">Palaviya</option>
				            <option value="Pallekele">Pallekele</option>
				            <option value="Pamankada">Pamankada</option>
				            <option value="Pamunuwa">Pamunuwa</option>
				            <option value="Panadura">Panadura</option>
				            <option value="Panchikawatta">Panchikawatta</option>
				            <option value="Pannala">Pannala</option>
				            <option value="Pannipitiya">Pannipitiya</option>
				            <option value="Pasikuda">Pasikuda</option>
				            <option value="Passara">Passara</option>
				            <option value="Pasyala">Pasyala</option>
				            <option value="Pelawatta">Pelawatta</option>
				            <option value="Peliyagoda">Peliyagoda</option>
				            <option value="Pelmadulla">Pelmadulla</option>
				            <option value="Pepiliyana">Pepiliyana</option>
				            <option value="Peradeniya">Peradeniya</option>
				            <option value="Pettah">Pettah</option>
				            <option value="Pilimathalawa">Pilimathalawa</option>
				            <option value="Piliyandala">Piliyandala</option>
				            <option value="Pita Kotte">Pita Kotte</option>
				            <option value="Pittugala">Pittugala</option>
				            <option value="Point Pedro">Point Pedro</option>
				            <option value="Polgahawela">Polgahawela</option>
				            <option value="Polgasowita">Polgasowita</option>
				            <option value="Polonnaruwa">Polonnaruwa</option>
				            <option value="Poojapitiya">Poojapitiya</option>
				            <option value="Pugoda">Pugoda</option>
				            <option value="Puttalam">Puttalam</option>
				            <option value="Radawana">Radawana</option>
				            <option value="Ragama">Ragama</option>
				            <option value="Rajagiriya">Rajagiriya</option>
				            <option value="Rambukkana">Rambukkana</option>
				            <option value="Ranala">Ranala</option>
				            <option value="Ranna">Ranna</option>
				            <option value="Rathmalana">Rathmalana</option>
				            <option value="Rathmale">Rathmale</option>
				            <option value="Ratnapura">Ratnapura</option>
				            <option value="Rattanapitiya">Rattanapitiya</option>
				            <option value="Ruhunupura">Ruhunupura</option>
				            <option value="Rukmalgama">Rukmalgama</option>
				            <option value="Ruwanwella">Ruwanwella</option>
				            <option value="Sampur">Sampur</option>
				            <option value="Sapugaskanda">Sapugaskanda</option>
				            <option value="Sedawatta">Sedawatta</option>
				            <option value="Seeduwa">Seeduwa</option>
				            <option value="Siddamulla">Siddamulla</option>
				            <option value="Sigiriya">Sigiriya</option>
				            <option value="Suriyakanda">Suriyakanda</option>
				            <option value="Talawa">Talawa</option>
				            <option value="Tangalle">Tangalle</option>
				            <option value="Thalahena">Thalahena</option>
				            <option value="Thalangama">Thalangama</option>
				            <option value="Thalathuoya">Thalathuoya</option>
				            <option value="Thalathuoya">Thalathuoya</option>
				            <option value="Thalawathugoda">Thalawathugoda</option>
				            <option value="Thambuttegama">Thambuttegama</option>
				            <option value="Thangalla">Thangalla</option>
				            <option value="Thimbirigasyaya">Thimbirigasyaya</option>
				            <option value="Thirunelvely">Thirunelvely</option>
				            <option value="Thotagoda">Thotagoda</option>
				            <option value="Thummulla">Thummulla</option>
				            <option value="Tissamaharama">Tissamaharama</option>
				            <option value="Town Hall">Town Hall</option>
				            <option value="Trincomalee">Trincomalee</option>
				            <option value="Udahamulla">Udahamulla</option>
				            <option value="Udappu">Udappu</option>
				            <option value="Udawalawa">Udawalawa</option>
				            <option value="Udugama">Udugama</option>
				            <option value="Udugampola">Udugampola</option>
				            <option value="Ukuwela">Ukuwela</option>
				            <option value="Unawatuna">Unawatuna</option>
				            <option value="Union Place">Union Place</option>
				            <option value="Valvettithurai">Valvettithurai</option>
				            <option value="Vauxhall Street">Vauxhall Street</option>
				            <option value="Vavuniya">Vavuniya</option>
				            <option value="Veyangoda">Veyangoda</option>
				            <option value="Wadduwa">Wadduwa</option>
				            <option value="Waikkal">Waikkal</option>
				            <option value="Warakapola">Warakapola</option>
				            <option value="Wariyapola">Wariyapola</option>
				            <option value="Waskaduwa">Waskaduwa</option>
				            <option value="Wathupitiwala">Wathupitiwala</option>
				            <option value="Wattala">Wattala</option>
				            <option value="Wattegama">Wattegama</option>
				            <option value="Welesara">Welesara</option>
				            <option value="Weligama">Weligama</option>
				            <option value="Welikanda">Welikanda</option>
				            <option value="Welimada">Welimada</option>
				            <option value="Welipenna">Welipenna</option>
				            <option value="Welisara">Welisara</option>
				            <option value="Welivita">Welivita</option>
				            <option value="Wellampitiya">Wellampitiya</option>
				            <option value="Wellawatte">Wellawatte</option>
				            <option value="Wellawaya">Wellawaya</option>
				            <option value="Wennappuwa">Wennappuwa</option>
				            <option value="Werahera">Werahera</option>
				            <option value="Weralugama">Weralugama</option>
				            <option value="Wijerama">Wijerama</option>
				            <option value="Yakkala">Yakkala</option>
				            <option value="Yala">Yala</option>
				            <option value="Yanthampalawa">Yanthampalawa</option>
				            <option value="Yatawatta">Yatawatta</option>
				            <option value="Yatiyanthota">Yatiyanthota</option>
						</select>
					</p>
			
				</div>
				<div class="sect">
					<div class="radiom">
						<p>
							<label for="">Sutible Candidate Details</label>
							
						</p>

						<div class="radio">
							<p>
								<label for="male" >Male</label>
								<input type="radio" name="gender" id="male"value="male" <?php if ($gender=="male") {echo "checked='checked'";} ?>>
							</p>
							<p>
								<label for="female" >Female</label>
								<input type="radio" name="gender" id="female"value="female" <?php if ($gender=="female") {echo "checked='checked'";} ?>>
							</p>
							<p>
								<label for="any" >Any</label>
								<input type="radio" name="gender" id="any" value="any"  <?php if ($gender=="any") {echo "checked='checked'";} ?>>
							</p>
						</div>
					</div>
						<p>
							<label for="">Minimum Years Of Qualification</label>
							<select name="minimum_qualification" id="">
								<option value="<?php echo $minimum_qualification; ?>" hidden><?php echo $minimum_qualification; ?></option>
								<option value="no">No Minimum Qualificatin Year</option>
								<option value="1 Year">1 Year</option>
								<option value="2 Years">2 Years</option>
								<option value="3 Years">3 Years</option>
								<option value="4 Years">4 Years</option>
								<option value="5 Years">5 Years</option>
								<option value="9 Years">9 Years</option>
								<option value="6 Years">6 Years</option>
								<option value="7 Years">7 Years</option>
								<option value="8 Years">8 Years</option>
								<option value="10 Years">10 Years</option>
	
							</select>
						</p>
						
					</div>
					<div class="sect">

						<p>
							<label for="">Minimum years Of Age</label>
							<select name="minimum_age" id="">
								<option value="<?php echo $minimum_age; ?>" hidden><?php echo $minimum_age; ?></option>
								<option value="No Minimum Age">No Minimum Age</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
								<option value="32">32</option>
								<option value="33">33</option>
								<option value="34">34</option>
								<option value="35">35</option>
								<option value="36">36</option>
								<option value="37">37</option>
								<option value="38">38</option>
								<option value="39">39</option>
								<option value="40">40</option>
								<option value="41">41</option>
								<option value="42">42</option>
								<option value="43">43</option>
								<option value="49">49</option>
								<option value="44">44</option>
								<option value="45">45</option>
								<option value="46">46</option>
								<option value="47">47</option>
								<option value="48">48</option>
								<option value="49">49</option>
								<option value="50">50</option>								
	
							</select>
						</p>
						<p>
							<label for="">Maximum Years Of Age</label>
							<select name="maximum_age" id="">
								<option value="<?php echo $maximum_age; ?>" hidden><?php echo $maximum_age; ?></option>
								<option value="No Maximum Age">No Maximum Age</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
								<option value="32">32</option>
								<option value="33">33</option>
								<option value="34">34</option>
								<option value="35">35</option>
								<option value="36">36</option>
								<option value="37">37</option>
								<option value="38">38</option>
								<option value="39">39</option>
								<option value="40">40</option>
								<option value="41">41</option>
								<option value="42">42</option>
								<option value="43">43</option>
								<option value="49">49</option>
								<option value="44">44</option>
								<option value="45">45</option>
								<option value="46">46</option>
								<option value="47">47</option>
								<option value="48">48</option>
								<option value="49">49</option>
								<option value="50">50</option>
	
							</select>
						</p>
					</div>
					<div class="sect">
						<div class="radiom">
							<p>
								<label for="">Minimum qualification Level</label>
							</p>
								<div class="radio">
									<p>
										<label for="O/L">O/L</label>
										<input type="radio" name="qulification" id="O/L" value="o/l" <?php if ($qulification_level=="o/l") {echo "checked='checked'";} ?>>
									</p>
									<p>
										<label for="A/l">A/L</label>
										<input type="radio" name="qulification" id="A/l" value="a/l" <?php if ($qulification_level=="a/l") {echo "checked='checked'";} ?>>
									</p>
									<p>
										<label for="degree">Degree</label>
										<input type="radio" name="qulification" id="degree" value="degree" <?php if ($qulification_level=="degree") {echo "checked='checked'";} ?>>
									</p>
									<p>
										<label for="no">No Minimum Qulification</label>
										<input type="radio" name="qulification" id="no" value="no minimum qualification" <?php if ($qulification_level=="no minimum qualification") {echo "checked='checked'";} ?>>
									</p>
								</div>
								
							</div>
									<p>
										<label for="datetime">Ad Expire Time</label>
										<input type="datetime-local" name="datetime" id="datetime" >
									</p>
					</div>
					<p>
						<label for="">Description</label>
						<textarea name="description" id="xx" cols="30" rows="10" ><?php echo $description; ?></textarea>
					</p>		
				</div>
				<div class="row3">
					<p>
						<input type="submit" name="submit" value="Post Advertisement">
					</p>
				</div>
			</form>
		</div>
	</div><!--section-->

<footer>
	<?php require_once("inc/dashboard-small-footer.php"); ?>
</footer>

	
				<script>
                        CKEDITOR.replace( 'description', );

                </script>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                <script src="js/multi-chooser/chosen.jquery.min.js"></script><!--multi chooser-->	

                <script>
                	$(document).ready(function(){

                		$('#location').chosen();

                	});
                </script>
</body>
<?php mysqli_close($connection); ?>
</html>