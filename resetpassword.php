<?php
    ob_start();
    require_once("inc/connection.php");

    if(!isset($_GET['actype']) || empty($_GET['actype'])){
        header('Location:mainlogin.php');
    }
    else{
        $actype = $_GET['actype'];
    }
    
    if(isset($_POST['send_email'])){
       
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $cat_user="";
        $error = array();
 
        $expires = date("U") * 1800;
        
        $userEmail = $_POST["email"];
        
        //cheking account type 
        if($actype == "sk"){
            //checking email is belongs to seeker or provider
            $query_check = "SELECT * FROM seeker WHERE email = '{$userEmail}'";
            $result = mysqli_query($connection,$query_check);
            
            if($result){
                if(mysqli_num_rows($result)==1){
                    $cat_user = "sk";
                }
            }
        }

        if($actype == "pr"){
            //checking email is belongs to seeker or provider
            $query_check = "SELECT * FROM provider WHERE company_email = '{$userEmail}'";
            $result = mysqli_query($connection,$query_check);
            
            if($result){
                if(mysqli_num_rows($result)==1){
                    $cat_user = "pr";
                }
            }
        }
        
        $url = "/php/job_hunting_system/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token) . "&actype=" . $cat_user;
        
        //delete existing emails in token table in database
        $query_delete = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
        $stmt = mysqli_stmt_init($connection);

        if(!mysqli_stmt_prepare($stmt,$query_delete)){
            $error[] = "There Is An Error Please Try Again";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$userEmail);
            mysqli_stmt_execute($stmt);
        }

        //insert new value for token
        $query = "INSERT INTO pwdReset(pwdResetEmail,pwdResetSelector,pwdResetToken,pwdResetExpire) VALUES (?,?,?,?)";
        $stmt = mysqli_stmt_init($connection);

        if(!mysqli_stmt_prepare($stmt,$query)){
            $error[] = "There Is An Error Please Try Again";
            exit();
        }
        else{
            $hashedToken = password_hash($token,PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt,"ssss",$userEmail,$selector,$hashedToken,$expires);
            mysqli_stmt_execute($stmt);
        }

        mysqli_stmt_close($stmt);
        mysqli_close();
        
        $to = $userEmail;
        $subject = "Reset Your Password For Jobberlk";
        $message ="<p>We Recieved A Password Reset Request. The Link To Reset Password Is Bellow.If You Did Not Make This Request,You Can Ignore This Email.</p>";
        $message .= "<p>Here Is Your Password Reset Link:<br>";
        $message .= "<a href='".$url."'>".$url."</a></a>";

        $headers ="From: Jobberlk.com <jobberjobs@gail.com>\r\n";
        $headers .="Reply-To: Jobberlk.com <jobberjobs@gail.com>\r\n";
        $headers .="Content-type: text/html\r\n";

        if(mail($to,$subject,$message,$headers)){
            header('Location:resetpassword.php?reset=success&actype='.$actype);
        }
        else{
            header('Location:resetpassword.php?reset=unsuccess&actype='.$actype);
        }


        echo $message;
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
    <title>Reset Your Password</title>
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
.main_container .form_container p{
    margin-bottom:25px;
    font-size:14px;
}
.main_container .form_container p.cr{
    color:#a21cf5;
    font-size:16px;
    text-align:Center;
}
.main_container .form_container p.plz{
    color:red;
    font-size:16px;
    text-align:Center;
}
.main_container .form_container p.error{
    color:red;
    font-size:14px;
    margin-bottom:8px;
}
.main_container .form_container h2{
    text-align:center;
    margin-bottom:25px;
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
    margin:10px 0 0;
    font-size:13px;
    border:1px solid #eee;
    background-color:#fff;
    outline-color:orange;
}
.main_container .form_container input[type="submit"]{
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

        <?php if(!empty($error)){
           ?>
                <div class="error">
                 <?php
                    foreach($error as $err){
                      echo"<p class='error'>". $err ."</p>";
                   }
                ?>

            </div>

           <?php
         }?>
                        
         <form action="resetpassword.php?actype=<?php echo $actype?>" method="POST">
            <h2>Reset Password</h2>
            <p>An Email Will Be Send To You With Instructions On How To Reset Your Password.</p>
            <p>
                <label for="">Enter Your Email Address</label>
                <input type="text" name="email" placeholder="Enter Your Email Address...">
            </p>
            <p>
                <input type="submit" value="Send Email" name="send_email">
            </p>
        </form>
             <?php
                 if(isset($_GET['reset'])){
                    if($_GET['reset'] == 'success'){
                        echo "<p class='cr'>Check Your Email</p>";
                    }
                    else{
                        echo "<p class='plz'>Please Enter Correct Email<p>";
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