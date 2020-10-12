<?php ob_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 

	$errors =array();
	$Firstname="";
	$Lastname="";
	$Username="";
	$email_address="";
	$phone_number="";

	//checking is filds are set

	if (isset($_POST["submit"])) {

		//Save enter Filds

		$Firstname	=$_POST["Firstname"];
		$Lastname	=$_POST["Lastname"];
		$Username	=$_POST["Username"];
		$email_address	=$_POST["email_address"];
		$phone_number	=$_POST["phone_number"];
		////////////////////////////////////////////////
		
		if (empty(trim($_POST["Firstname"]))) {
			$errors[]="Please Enter First Name";
		}
		if (empty(trim($_POST["Lastname"]))) {
			$errors[]="Please Enter Last Name";
		}
		if (empty(trim($_POST["Username"]))) {
			$errors[]="Please Enter Username";
		}
		if (empty(trim($_POST["email_address"]))) {
			$errors[]="Please Enter Email Address";
		}
		if (empty(trim($_POST["phone_number"]))) {
			$errors[]="Please Enter Phone Number";
		}
		if (empty(trim($_POST["Password"]))) {
			$errors[]="Please Enter Password";
		}
		if (empty(trim($_POST["con_password"]))) {
			$errors[]="Please Reenter Password";
		}
		//checking max width

		$max_len_filds =array("Firstname" =>50,"Lastname" =>50,"Username" =>30,"email_address" =>100,"phone_number" =>20,"Password" =>100,"con_password" =>100);

		foreach ($max_len_filds as $filds => $value) {
		
			if (strlen(trim($_POST[$filds]))>$value) {
				$errors[] = $filds . " must be less than " . $value . "characters";
			}
		}

		//Checkin Password is correct

		if (! ($_POST["Password"] == $_POST["con_password"])) {
			$errors[]="Password Invalid";
		}

		//Checking if email address is alredy Exsits

		$email = mysqli_real_escape_string($connection, $_POST["email_address"]);
		$query ="SELECT * FROM seeker WHERE email='{$email}' LIMIT 1";
		
		$result_set = mysqli_query($connection, $query);
		
		if ($result_set) {
			if (mysqli_num_rows($result_set)==1) {
			$errors[]="Email address is alredy exists";
			}
		}

		//Add Data to forms
		if (empty($errors)) {
			
			$Firstname = mysqli_real_escape_string($connection, $_POST["Firstname"]);
			$Lastname = mysqli_real_escape_string($connection, $_POST["Lastname"]);
			$Username = mysqli_real_escape_string($connection, $_POST["Username"]);
			$email_address = mysqli_real_escape_string($connection, $_POST["email_address"]);
			$phone_number = mysqli_real_escape_string($connection, $_POST["phone_number"]);

			$hashed_pasword =sha1($_POST["con_password"]);

			$query = "INSERT INTO seeker (first_name, last_name, username, email, phone_number, password,is_image, is_deleted) VALUES ('{$Firstname}','{$Lastname}','{$Username}','{$email_address}','{$phone_number}','{$hashed_pasword}',0,0)";

			$result = mysqli_query($connection ,$query);

			if($result){
				//use thi query for get seeker_id
				$query="SELECT seeker_id FROM seeker WHERE email='{$email}' LIMIT 1";

				$result=mysqli_query($connection, $query);
				$seeker_id=mysqli_fetch_assoc($result);

				//Query is Sucessfull
				
					header("location:cv.php?seeker_id=" . $seeker_id["seeker_id"] . "&add_user=true");
				
			}
			else{
				$errors[]="Faild add record";
				//printf(mysqli_error($connection));
			}
		}

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sign Up</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/mainsignup.css">
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /><!--style sheet for scroll animation-->
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/index-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/mainlogin-media.css"><!--media query-->

	
</head>
<body>

	<header>
	<?php require_once("inc/header.php"); ?>
    </header>
    
    <section>
        <div class="main_row">
            <h1>Create Your Account</h1>
        </div>
        <div class="main_row">
            <div class="con_pannel">
                <fieldset>
                    <legend>Choose Your Account Type</legend>
                    <div class="ac_type">
                        <div class="type_column ac_active">
                            <div class="column">
                                <img src="imj/svg/groups.svg" alt="">
                            </div>
                            <div class="column">
                                <h3>Job Seeker</h3>
                                <p>Login as seeker</p>
                            </div>
                        </div>
                        <div class="type_column">
                            <div class="column">
                                <img src="imj/svg/company.svg" alt="">
                            </div>
                            <div class="column">
                                <h3>Job Provider</h3>
                                <p>Login as provider</p>
                            </div>
                        </div>        
                    </div>
                </fieldset>
            </div>
            <div class="con_form">
                <form action="mainsignup.php" method='POST'>
                        <div class="sec">
                            <p>
                                <label for="">First Name</label>
                                <input type="text" name="Firstname" id="" placeholder="Enter First Name" value="<?php echo $Firstname ?>" autofocus>
                            </p>
                            <p>
                                <label for="">Last Name</label>
                                <input type="text" name="Lastname" id="" placeholder="Enter Last Name" value="<?php echo $Lastname ?>">
                            </p>
						</div>
						<div class="sec">
                            <p>
                                <label for="">Username</label>
                                <input type="text" name="Username" id="" placeholder="Enter Username" value="<?php echo $Username ?>">
                            </p>
                            <p>
                                <label for="">Phone number</label>
                                <input type="text" name="phone_number" id="" placeholder="Enter Phone Number" value="<?php echo $phone_number ?>">
                            </p>
						</div>
						<div class="sec">
                            <p>
                                <label for="">Email Address</label>
                                <input type="Email" name="email_address" id="" placeholder="Enter Email address" value="<?php echo $email_address ?>">
                            </p>
                        </div>
                        <div class="sec">
                            <p>
                                <label for="">Qualification</label>
                                <div class="radio">
                                    <label for="ol">O/L</label>
                                    <input type="radio" name='qua' value="o/l" id="ol">
                                    <label for="al">A/L</label>
                                    <input type="radio" name='qua' value="a/l" id="al">
                                    <label for="degree">Degree</label>
                                    <input type="radio" name='qua' value="degree" id="degree">
                                    <label for="no">No Minimum Qualification</label>
                                    <input type="radio" name='qua' value="no" id="no" checked>
                                </div>
                            </p>   
						</div>
						
						<div class="sec">
                            <p>
                                <label for="">Password</label>
                                <input type="password" name="Password" id="" placeholder="Enter Password">
                            </p>
                            <p>
                                <label for="">Confirm Password</label>
                                <input type="password" name="con_password" id="" placeholder="Reenter Password">
                            </p>	
						</div>
                    <div class="subbut">
                        <div class="subcolumn">
                            <input type="submit" value="Login" name="ussubmit">
                        </div>
                        <div class="subcolumn">
                            <p>Already Have An Account? <a href="mainsignup.php">Sign Up Here</a></p>
                        </div>
                    </div>
                </form>
                <form action="mainsignup.php" method='POST' style="display:none">
                        <div class="sec">
                            <p>
                                <label for="">Company Name</label>
                                <input type="text" name="company_name">
                            </p>
                            <p>
                                <label for="">Company Registraion Number</label>
					            <input type="text" name="company_registration_number">
                            </p>
						</div>
						<div class="sec">
                            <p>
                                <label for="">Company Phone Number</label>
					            <input type="text" name="company_phone_number">
                            </p>
                            <p>
                                <label for="">Company Email</label>
					            <input type="Email" name="company_email">
                            </p>
						</div>
						<div class="sec">
                            <p  style="margin-right:25px;">
                                <label for="">Password</label>
					            <input type="password" name="password">
                            </p>
                            <p>
                                <label for="">Confirm Password</label>
					            <input type="password" name="c_passwrd">
                            </p>	
						</div>
                    <div class="subbut">
                        <div class="subcolumn">
                            <input type="submit" value="Login" name="cosubmit">
                        </div>
                        <div class="subcolumn">
                            <p>Already Have An Account? <a href="mainsignup.php">Sign Up Here</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

	<!-- <section>
		<div class="main">
			<div class="row1">
				<h2>Create Your Account</h2>
			</div>
			
			
			<?php 
				/**if (!empty($errors)) {
					echo "<div class='errmsg'>";
					foreach ($errors as $value) {
						echo "<p>" . $value . "</p>";
					}
					echo "</div>";
				}*/

			?>
			

			<div class="row2">
				<div class="signup_form">
					<form action="seekersignup.php" method="post">
						<p>
							<label for="">First Name</label>
							<input type="text" name="Firstname" id="" placeholder="Enter First Name" value="<?php echo $Firstname ?>">
						</p>
						<p>
							<label for="">Last Name</label>
							<input type="text" name="Lastname" id="" placeholder="Enter Last Name" value="<?php echo $Lastname ?>">
						</p>
						<p>
							<label for="">Username</label>
							<input type="text" name="Username" id="" placeholder="Enter Username" value="<?php echo $Username ?>">
						</p>
						<p>
							<label for="">Email Address</label>
							<input type="Email" name="email_address" id="" placeholder="Enter Email address" value="<?php echo $email_address ?>">
						</p>
						<p>
							<label for="">Phone number</label>
							<input type="text" name="phone_number" id="" placeholder="Enter Phone Number" value="<?php echo $phone_number ?>">
						</p>
						<p>
							<label for="">Password</label>
							<input type="password" name="Password" id="" placeholder="Enter Password">
						</p>
						<p>
							<label for="">Confirm Password</label>
							<input type="password" name="con_password" id="" placeholder="Reenter Password">
						</p>
						<p>
							<button type="submit" name="submit">Sign Up</button>
							<span>Already registered?<a href="userlogin.php">Log in Here</a></span>
						</p>
					</form>
				</div>
			</div>
		</div>
	</section> -->

	<footer>
		<?php require_once("inc/footer.php"); ?>
	</footer>


	<script src="https://unpkg.com/aos@next/dist/aos.js"></script><!--scroll animation-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script><!--jQuery CDN-->
    
    <script src="js/mobilenav.js">	//for mobile navigation</script>
    
    <script>
        const type_row1 = document.querySelectorAll('.type_column')[0];
        const type_row2 = document.querySelectorAll('.type_column')[1];
        const forms = document.querySelectorAll('.con_form form');

        type_row1.addEventListener('click',()=>{
            
                if(type_row1.className!='type_column ac_active'){
                    type_row1.classList.add('ac_active');
                    type_row2.classList.remove('ac_active');

                    forms[1].classList.add('form_hide');
                    forms[1].addEventListener('transitionend',(e)=>{
                        if(e.propertyName==="opacity"){
                            forms[0].style.display = "block";
                            forms[1].style.display = "none";
                            forms[0].classList.remove('form_hide');
                        }  
                        
                    });
                }
            
        });
        type_row2.addEventListener('click',()=>{
            
            if(type_row2.className!='type_column ac_active'){
                type_row2.classList.add('ac_active');
                type_row1.classList.remove('ac_active');

                forms[0].classList.add('form_hide');
                forms[0].addEventListener('transitionend',(e)=>{
                    if(e.propertyName==="opacity"){
                        forms[1].style.display = "block";
                        forms[0].style.display = "none";
                        forms[1].classList.remove('form_hide');
                    }
                    
                    
                    
                });
            }
        
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

<?php mysqli_close($connection); ?>
</html>