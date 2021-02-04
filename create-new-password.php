<?php
    ob_start();
    require_once("inc/connection.php");

    if(!isset($_GET['selector'])){
        header('Location:index.php');
    }
    if(!isset($_GET['validator'])){
        header('Location:index.php');
    }
    if(!isset($_GET["actype"])){
        header("Location:index.php");
    }
    if(empty($_GET["actype"])){
        header("Location:resetpassword.php");
    }

    //checking user set button
    $actype = $_GET['actype'];
    $error = array();

    if(isset($_POST["newsubmit"])){

        $selector = $_POST["selector"];
        $validator = $_POST["validator"];

        $newPassword = $_POST["password"];
        $confirmPassword = $_POST["cpassword"];

        if(empty($newPassword) || empty($confirmPassword)){
            $error[] = "Please Enter Password";
        }

        if($newPassword != $confirmPassword){
            $error[] = "Confirm Password Invalid Please Enter Again";
        }

        
        $cuurentDate = date("U");

        $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector=? AND pwdResetExpire >= ?";
        $stmt = mysqli_stmt_init($connection);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            $error[] = "There Is An Error";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"ss",$selector,$cuurentDate);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if(!$row = mysqli_fetch_assoc($result)){
                $error[] = "You Need To Resubmit Your Password Reset Request";
                exit();
            }
            else{
                //convert our token to binary
                $tokenbinary = hex2bin($validator);
                $tokencheck = password_verify($tokenbinary,$row["pwdResetToken"]);

                if($tokencheck === false){
                    $error[] = "You Need To Resubmit Your Password Reset Request";
                    exit();
                }
                elseif($tokencheck === true){
                    
                    if(empty($error)){
                        //set password on user account
                        $tokenEmail = $row['pwdResetEmail'];
    
                        if($actype == "sk"){
                            
                            $sql = "SELECT * FROM seeker WHERE email='{$tokenEmail}'";
                            $result = mysqli_query($connection,$sql);
        
                            if($result){
                                if(mysqli_num_rows($result) == 1){
                                    //if there is one row in seeker account
                                    $shapassword = sha1($confirmPassword);
        
                                    $updateQuery = "UPDATE seeker SET password='{$shapassword}' WHERE email='{$tokenEmail}' LIMIT 1";
                                    $result = mysqli_query($connection,$updateQuery);
    
                                    if($result){
                                        header('Location:mainLogin.php?ac=se');
                                    }
                                }
                                else{
        
                                }
                            }
    
                        }
                        if($actype == "pr"){
                            
                            $sql = "SELECT * FROM provider WHERE company_email='{$tokenEmail}'";
                            $result = mysqli_query($connection,$sql);
        
                            if($result){
                                if(mysqli_num_rows($result) == 1){
                                    //if there is one row in seeker account
                                    $shapassword = sha1($confirmPassword);
        
                                    $updateQuery = "UPDATE provider SET password='{$shapassword}' WHERE company_email='{$tokenEmail}' LIMIT 1";
                                    $result = mysqli_query($connection,$updateQuery);
    
                                    if($result){
                                        header('Location:mainLogin.php?ac=pr');
                                    }
                                }
                                else{
        
                                }
                            }
    
                        }

                    }


                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/index.css">
    
	<link rel="stylesheet" href="css/media-queries/index-media.css"><!--media query-->
    <script src="https://kit.fontawesome.com/4f6c585cf2.js" crossorigin="anonymous"></script>
    <title>Document</title>
    <link rel="shortcut icon" type="image/jpg" href="imj/icon/fav.png"/>
</head>
<style>
@import url("https://fonts.googleapis.com/css2?family=Baloo+Tammudu+2&display=swap");
body{
    background-image:linear-gradient(to bottom,#f7f7f7cc,#fff);
}
.main_container{
    position:relative;
    width:100%;
    height:calc(100vh - 165px);
    margin:50px 0px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family: "IBM Plex Sans", sans-serif;
}
.main_container .bgtext_container{
    width:80%;
    text-align:center;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
}
.main_container .bgtext_container h1{
    font-size:200px;
    color:#1b1b1b14;
}
.main_container .form_container{
    width:600px;
    z-index:10;
}
.main_container .form_container h2{
    text-align:center;
    margin-bottom:45px;
    font-size:35px;
    color:#ff8a00;
}
.main_container .form_container label{
    margin-bottom:8px;
    font-size:16px;
    font-weight:600;
}
.main_container .form_container input{
    width:100%;
    padding:15px 5px;
    margin:10px 0;
    font-size:13px;
    border:1px solid #eee;
    background-color:#fff;
    outline-color:orange;
}
.main_container .form_container input[type="submit"]{
    margin-top:20px;
    background-color:#ff8a00;
    color:#fff;
    font-weight:600;
    width:200px;
    padding:10px;
    cursor:pointer;
}

@media screen and (max-width:1300px){
    .main_container .bgtext_container h1{
    font-size:150px;
}
}
@media screen and (max-width:1000px){
    .main_container .bgtext_container h1{
    font-size:150px;
}
}
@media screen and (max-width:959px){
    .main_container .bgtext_container h1{
    display:none;
}
}
@media screen and (max-width:620px){
    .main_container .form_container{
        width:95%;
    }
}
@media screen and (max-width:239px){
    .main_container .form_container input[type="submit"]{
        width:100%;
    }
}

</style>
<body>
    <header>
		<?php require_once("inc/header.php") ?>
	</header>

    <div class="main_container">
        <div class="bgtext_container">
            <h1>JOBBERLK</h1>
        </div>
        <div class="form_container">
            <?php
            
                $selector = $_GET['selector'];
                $validator = $_GET['validator'];

                if(empty($selector) || empty($validator)){
                    echo "Could Not Validate Your Request!!";
                }
                else{
                    if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !==false){
                        ?>
                        <?php if(!empty($error)){
                            ?>
                                <div class="error">
                                    <?php
                                        foreach($error as $err){
                                            echo"<p>". $err ."</p>";
                                        }
                                    ?>

                                </div>

                            <?php
                        }?>
                        <form action="create-new-password.php?selector=<?php echo $selector ?>&validator=<?php echo $validator ?>&actype=<?php echo $actype?>" method="POST">
                            <h2>Reset Password</h2>
                            <input type="hidden" name="selector" value="<?php echo $selector ?>">
                            <input type="hidden" name="validator" value="<?php echo $validator ?>">
                            <p>
                                <label for="">Enter Your Password</label>
                                <input type="password" name="password" placeholder="Enter New Password">
                            </p>
                            <p>
                            <label for="">Enter Confirm Password</label>
                                <input type="password" name="cpassword" placeholder="Repeat New Password">
                            </p>
                            <p>
                                <input type="submit" name="newsubmit" value="Reset Password">
                            </p>
                        </form>

                        <?php
                    }
                }

            ?>
        </div>
        
    </div>

    <footer>
	<?php require_once("inc/footer.php"); ?>
    </footer>
</body>
</html>