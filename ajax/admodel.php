<?php

    require_once('../inc/connection.php');

    $ad_no=$_POST['ad_no'];
    $page_no =$_POST['pagenum'];

$query = "SELECT * FROM job_ad WHERE ad_no = {$ad_no} LIMIT 1";
$result = mysqli_query($connection,$query);

if($result){
    $comde = mysqli_fetch_assoc($result);

    echo '<div class="rows">';
        echo '<div class="provi_logo">';
            echo ad_picture($comde['company_registration_number'],$connection);
        echo '</div>';
    echo '</div>';
    echo '<div class="rows">';
        echo delete_button($ad_no,$page_no,$connection);
    echo '</div>';
    echo '<div class="rows">';
        echo '<div class="adtitle">';
            echo '<h2>'.$comde['job_title'].'</h2>';
        echo '</div>';
        echo '<div class="comtitle">';
            echo '<h3><i class="fas fa-home"></i>'.$comde['company_name'].'</h3>';
        echo '</div>';
        echo '<div class="comaddre">';
        echo '<h3><i class="fas fa-map-marker-alt"></i>'.$comde['location'].'</h3>';
        echo '</div>';
        echo '<div class="jocat">';
             echo '<h3><i class="far fa-building"></i>'.$comde['job_category'].'</h3>';
        echo '</div>';
        echo '<div class="jobsal">';
            echo '<h3><i class="fas fa-coins"></i>'.$comde['monthly_salary'].'</h3>';
        echo '</div>';
        echo '<div class="jobquali">';
            echo '<h3><i class="fas fa-graduation-cap"></i>'.$comde['qulification_level'].'</h3>';
         echo '</div>';
        echo '<div class="jobtyp">';
            echo '<h3><i class="fas fa-briefcase"></i>'.$comde['job_type'].'</h3>';
        echo '</div>';
        echo '<div class="jobage">';
            echo '<h3><i class="fas fa-male"></i>'.$comde['minimum_age'].' < '.$comde['maximum_age'].'</h3>';
        echo '</div>';
        echo '<div class="adgende">';
            echo '<h3><i class="fas fa-venus-mars"></i>'.$comde['gender'].'</h3>';
        echo '</div>';
        echo '<div class="time">';
            echo '<div class="uploadedtim">';
                echo '<h3><i class="far fa-clock"></i>'.time_ago($comde["ad_time"]).'</h3>';
            echo '</div>';
            echo '<div class="expiretime">';
                echo '<h3><i class="fas fa-history"></i>aMomkma dasd mad</h3>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
    echo '<div class="rows">';
        echo '<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quis possimus, quasi veritatis, error a natus recusandae excepturi ut explicabo aperiam a Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro libero quam similique at itaque, provident eum voluptatem excepturi deleniti! Facilis dolores ratione officiis maiores repudiandae impedit deleniti ab maxime reprehenderit.</p>';
    echo '</div>';
}

//function for get company Logo
function ad_picture($crn,$con){

    $ad_pic_query = "SELECT is_image FROM provider WHERE company_registration_number = '{$crn}'";

    $result_ad_pic = mysqli_query($con,$ad_pic_query);

        if ($result_ad_pic) {

            $ad_pic = mysqli_fetch_assoc($result_ad_pic);

            if ($ad_pic["is_image"]==1) {
                
                return "<img src ='../imj/profile_pictures/providers/{$crn}.jpg'>";
            }
            else{
                return "<img src ='../imj/profile_pictures/default.jpg'>";
            }
        }
        else{
            return "<img src ='../imj/profile_pictures/default.jpg'>";
        }
}
//function for show button
function delete_button($ad_no,$page_no,$con){

    $delete_query = "SELECT is_delete FROM job_ad WHERE ad_no={$ad_no} LIMIT 1";

    $delete_result = mysqli_query($con,$delete_query);

    if ($delete_query) {
        
        $delete_ad = mysqli_fetch_assoc($delete_result);

        if ($delete_ad["is_delete"]==1) {
            
            echo "<form action =\"index.php?p={$page_no}\" method=\"POST\"'>";
            echo "<input type=\"text\" name=\"ad_no\" value=\"{$ad_no}\" hidden>";
            echo "<button name='restore' style='color:green'><i class='fas fa-trash-restore'></i></button>";
            echo "</form>";
        }
        else{
            echo "<a href=\"delete-ad.php?ad_no={$ad_no}&p={$page_no}\" onclick=\"return confirm('Are You Sure?');\"><button class='delete' style='color:red'><i class='far fa-trash-alt'></i></button></a>";
        }
    }

}
//time ago function
date_default_timezone_set('Asia/colombo'); 
function time_ago($timestamp){  
$time_ago = strtotime($timestamp);
$current_time = time();  
$time_difference = $current_time - $time_ago;  
$seconds = $time_difference;  
$minutes      = round($seconds / 60 );           // value 60 is seconds  
$hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
$days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
$weeks          = round($seconds / 604800);          // 7*24*60*60;  
$months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
$years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
if($seconds <= 60)  
{  
return "Just Now";  
}  
else if($minutes <=60)  
{  
if($minutes==1)  
 {  
return "one minute ago";  
}  
else  
 {  
return "$minutes minutes ago";  
}  
}  
else if($hours <=24)  
{  
if($hours==1)  
 {  
return "an hour ago";  
}  
 else  
 {  
return "$hours hrs ago";  
}  
}  
else if($days <= 7)  
{  
if($days==1)  
 {  
return "yesterday";  
}  
 else  
 {  
return "$days days ago";  
}  
}  
else if($weeks <= 4.3) //4.3 == 52/12  
{  
if($weeks==1)  
 {  
return "a week ago";  
}  
 else  
 {  
return "$weeks weeks ago";  
}  
}  
else if($months <=12)  
{  
if($months==1)  
 {  
return "a month ago";  
}  
 else  
 {  
return "$months months ago";  
}  
}  
else  
{  
if($years==1)  
 {  
return "one year ago";  
}  
 else  
 {  
return "$years years ago";  
}  
}  
}
?>