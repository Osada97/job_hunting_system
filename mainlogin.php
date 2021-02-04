<?php ob_start(); ?>
<?php session_start(); ?>
<?php require_once("inc/connection.php"); ?>

<?php 

    $errors = array();
    $errors1 = array();

    if(isset($_POST["ussubmit"])){
        /*validation goes in here*/
        if (empty(trim($_POST["username_email"]))) {
			$errors[]="Enter User Name Or Email";
		}
		if (empty(trim($_POST["password"]))) {
			$errors[]="Enter Your Password";		
        }
        if (strlen((trim($_POST["username_email"]))) >100) {
			$errors[]="Username Field Must Be Less Than 100 Characters";		
        }
        if (strlen((trim($_POST["password"]))) >16) {
			$errors[]="Password Field Must Be Less Than 16 Characters";		
        }
        
        if (empty($errors)) {
			$username_email=mysqli_real_escape_string($connection,$_POST["username_email"]);
			$password=mysqli_real_escape_string($connection,$_POST["password"]);
			$hased_password=sha1($password);

			$query="SELECT * FROM seeker WHERE username='{$username_email}' OR email='{$username_email}' AND password='{$hased_password}' AND is_deleted=0 LIMIT 1";

			$result=mysqli_query($connection,$query);

			if ($result) {
				
				if (mysqli_num_rows($result) == 1) {

					$seeker=mysqli_fetch_assoc($result);
					$_SESSION["seeker_id"]=$seeker["seeker_id"];
					$_SESSION["username"]=$seeker["username"];
                    $_SESSION["is_image"]=$seeker["is_image"];
                    $_SESSION["qualifi"]=$seeker["qualification"];

					header("Location:seekerdashboard.php");
				}
				else{
					$errors[]="Invalid Username/Email Or Password Invalied";
				}
			}
		}
        
    }
    if (isset($_POST["prsubmit"])) {
		
		if (empty(trim($_POST["company_email"]))) {
			$errors1[]="Company Email Required";
		}
		if (empty(trim($_POST["password"]))) {
			$errors1[]="Password Required";
        }
        if (strlen((trim($_POST["company_email"]))) >300) {
			$errors1[]="Comapny Email Field Must Be Less Than 100 Characters";		
        }
        if (strlen((trim($_POST["password"]))) >16) {
			$errors1[]="Password Field Must Be Less Than 16 Characters";		
        }
		if (empty($errors1)) {
			
			$company_email=mysqli_real_escape_string($connection,$_POST["company_email"]);
			$password=mysqli_real_escape_string($connection,$_POST["password"]);

			$hashed_password = sha1($password);

			$query = "SELECT * FROM provider WHERE company_email = '{$company_email}' AND password='{$hashed_password}' AND is_deleted=0 LIMIT 1";

			$result = mysqli_query($connection , $query);

			if ($result) {
				if (mysqli_num_rows($result)==1) {

					$pro=mysqli_fetch_assoc($result);

					$_SESSION["company_registration_number"]=$pro["company_registration_number"];
					$_SESSION["company_name"]=$pro["company_name"];
					$_SESSION["is_image_pro"]=$pro["is_image"];

					header("location:providerdashboard-ea.php?crn=" . $pro["company_registration_number"]);
				}
				else{
					$errors1[]="Company Email Or Password Invalied";
				}
			}
			else{
				$errors1[]="query error";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Seeker LogIn</title>
    <link rel="shortcut icon" type="image/jpg" href="imj/icon/fav.png"/>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/mainlogin.css">
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /><!--style sheet for scroll animation-->
	<script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/media-queries/index-media.css"><!--media query-->
	<link rel="stylesheet" href="css/media-queries/mainlogin-media.css"><!--media query-->


</head>
<body>
	
	<header>
		<?php require_once("inc/header.php") ?>
	</header>
    
    <section>
        <div class="main_row">
            <h1>LogIn To Your Account</h1>
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
                <div class="errors">
                </div>
                <form action="mainlogin.php?ac=se" method='POST'>
                    <div class="errors">
                        <?php
                            if(!empty($errors)){
                                foreach($errors as $err){
                                    echo "<p>".$err."</p>";
                                }
                            }
                        ?>
                    </div>
                    <p>
						<label for="">Seeker Username</label>
						<input type="text" name="username_email" placeholder="Enter Email" autofocus>
					</p>
					<p>
						<label for="">Seeker Password</label>
                        <input type="password" name="password" placeholder="Enter Password" id="input">
                        <span id="showhide" title="Show Password"><i class="far fa-eye"></i></span>
                    </p>
                    <div class="subbut">
                        <div class="subcolumn">
                            <input type="submit" value="Login" name="ussubmit">
                        </div>
                        <div class="subcolumn">
                            <p><a href="resetpassword.php?actype=sk">Forget Your Password?</a></p>
                            <p>Don't You Have Account? <a href="mainsignup.php">Sign Up Here</a></p>
                        </div>
                    </div>
                </form>
                <form action="mainlogin.php?ac=pr" method='POST' style="display:none">
                    <div class="errors">
                        <?php
                            if(!empty($errors1)){
                                foreach($errors1 as $err){
                                    echo "<p>".$err."</p>";
                                }
                            }
                        ?>
                    </div>
                    <p>
						<label for="">Company Email</label>
						<input type="text" name="company_email" placeholder="Enter Email" autofocus>
					</p>
					<p>
						<label for="">Provider Password</label>
                        <input type="password" name="password" placeholder="Enter Password" id="input1">
                        <span id="showhide1" title="Show Password"><i class="far fa-eye"></i></span>
                    </p>
                    <div class="subbut">
                        <div class="subcolumn">
                            <input type="submit" value="Login" name="prsubmit">
                        </div>
                        <div class="subcolumn">
                            <p><a href="resetpassword.php?actype=pr">Forget Your Password?</a></p>
                            <p>Don't You Have Account? <a href="mainsignup.php">Sign Up Here</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

<footer>
	<?php require_once("inc/footer.php"); ?>
</footer>


	<script src="https://unpkg.com/aos@next/dist/aos.js"></script><!--scroll animation-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script><!--jQuery CDN-->
    
    <script src="js/mobilenav.js">	//for mobile navigation</script>
	<script>
			//for scroll animation
	    AOS.init({
	    	offset:250,
	    	duration:700,
	    });
    </script>
    
    <script>
        const type_row1 = document.querySelectorAll('.type_column')[0];
        const type_row2 = document.querySelectorAll('.type_column')[1];
        const forms = document.querySelectorAll('.con_form form');

        //getting url data
        const url = new URL(window.location.href);
        let acname = url.searchParams.get('ac');

        type_row1.addEventListener('click',()=>{
        
                if(type_row1.className!='type_column ac_active'){
                    type_row1.classList.add('ac_active');
                    type_row2.classList.remove('ac_active');

                    forms[1].classList.add('form_hide');
                    forms[1].addEventListener('transitionend',()=>{
                        forms[0].style.display = "block";
                        forms[1].style.display = "none";
                        forms[0].classList.remove('form_hide');
                    });
                }
            
        });

        if(acname == 'se'){
            type_row1.classList.add('ac_active');
            type_row2.classList.remove('ac_active');

            forms[1].classList.add('form_hide');
            forms[0].style.display = "block";
            forms[1].style.display = "none";
            forms[0].classList.remove('form_hide');
        }
        type_row2.addEventListener('click',()=>{
            
            if(type_row2.className!='type_column ac_active' || acname == 'pr'){
                type_row2.classList.add('ac_active');
                type_row1.classList.remove('ac_active');

                forms[0].classList.add('form_hide');
                forms[0].addEventListener('transitionend',()=>{
                    forms[1].style.display = "block";
                    forms[0].style.display = "none";
                    forms[1].classList.remove('form_hide');
                });
            }
        });
        if(acname == 'pr'){
            type_row2.classList.add('ac_active');
            type_row1.classList.remove('ac_active');

            forms[0].classList.add('form_hide');
            forms[1].style.display = "block";
            forms[0].style.display = "none";
            forms[1].classList.remove('form_hide');
        }
    </script>
    <script>
        const eye = document.querySelector('#showhide');
        let input = document.querySelector('#input');
        const eye1 = document.querySelector('#showhide1');
        let input1 = document.querySelector('#input1');

        eye.addEventListener('mousedown',()=>{
            input.setAttribute('type','text');
        });
        eye.addEventListener('mouseup',()=>{
            input.setAttribute('type','password');
        });
        eye1.addEventListener('mousedown',()=>{
            input1.setAttribute('type','text');
        });
        eye1.addEventListener('mouseup',()=>{
            input1.setAttribute('type','password');
        });
    </script>

</body>
<?php mysqli_close($connection) ?>
</html>