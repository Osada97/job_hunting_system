<?php
    require_once('../inc/connection.php');

    	//time ago function
	 	date_default_timezone_set('Asia/colombo'); 
         function facebook_time_ago($timestamp){  
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

 //function for get provider profile pic

 function provider_profile_picture($crm,$connection){

    $company_registration_number=$crm;
    $con=$connection;

    $query_for_get_pp = "SELECT is_image FROM provider WHERE company_registration_number='{$company_registration_number}'";

    $pp_result = mysqli_query($con,$query_for_get_pp);

    if ($pp_result) {
        
        $is_image_pp=mysqli_fetch_assoc($pp_result);

        if ($is_image_pp["is_image"]==1) {
            return "<img src=\"imj/profile_pictures/providers/" . $company_registration_number . ".jpg\"> ";
        }
        else{
            return "<img src=\"imj/profile_pictures/default.jpg\">";
        }
    }
    else{
        return "<img src=\"imj/profile_pictures/default.jpg\">";
    }
}
function buttonColor($con,$seeker_id,$ad_no,$company_registration_number,$page_number){

    $connection = $con;

    $button_query = "SELECT * FROM job_apply WHERE seeker_id = '{$seeker_id}' AND ad_no='{$ad_no}' LIMIT 1";

    $button_result = mysqli_query($connection,$button_query);

    if ($button_result) {
        if (mysqli_num_rows($button_result)==1) {
            echo  "<a href=\"seekerdashboard-vjob.php?ad-no={$ad_no}&p={$page_number}\" ><button id='button' style='border-color:#15b715;color:#15b715' class='al' title='Applied Add'>View Ad</button></a>";
        }
        else{

            echo  "<a href=\"seekerdashboard-vjob.php?ad-no={$ad_no}&p={$page_number}\" ><button id='button' title='Not Applied Add'>View Ad</button></a>";
        }
    }
    else{
        printf(mysqli_error($connection));
    }
 }

    session_start();

    $what = $_POST['what'];
    $where = $_POST['where'];
    $company_name =$_POST['company'];
    $seeker_qualification = $_POST['seeker_qualification'];
    $page_number = 1;

    $query_search = "SELECT * FROM job_ad WHERE is_delete=0 AND active!=0 AND is_expire =0 AND qulification_level ='{$seeker_qualification}' AND location LIKE '%$where%' AND  job_title LIKE '%$what%' AND company_name LIKE '%$company_name%' ORDER BY ad_no DESC";

    $search_result = mysqli_query($connection,$query_search);

    if ($search_result) {
        if (mysqli_num_rows($search_result)>0) {
            echo "<div class = \"result\"><h2>Best Match</h2></div>";
            while ($se=mysqli_fetch_assoc($search_result)) {

                echo '<div class="row">';
                    echo "<a href=\"seekerdashboard-vjob.php?ad-no={$se["ad_no"]}&p={$page_number}\">";
                        echo '<div class="column1">';
                            echo '<div class="image">';
                                echo provider_profile_picture($se["company_registration_number"],$connection);
                            echo  '</div>';
                        echo '</div>';
                        echo '<div class="column2">';
                            echo '<div class="row1">';
                                echo '<h1>' . $se["job_title"] . '</h1>';
                            echo '</div>';
                            echo '<div class="row2">';
                                echo '<h2><i class="fas fa-home"></i>' . $se["company_name"]  . '</h2>';
                                echo '<h2><i class="fas fa-map-marker-alt"></i>' . $se["location"] . '</h2>';
                                echo '<h2>' . $se["job_category"] . '</h2>';
                                echo '<h2><i class="fas fa-coins"></i>RS:'. $se["monthly_salary"] . '</h2>';
                            echo  '</div>';
                        echo '</div>';
                        echo '<div class="column3">';
                            echo '<div class="row1">';
                               buttonColor($connection,$_SESSION["seeker_id"],$se["ad_no"],$se["company_registration_number"],$page_number);
                            echo '</div>';
                            echo '<div class="row2">';
                                echo '<h2><i class="fas fa-briefcase"></i>' . $se["job_type"] . '</h2>';
                                echo '<h2><i class="far fa-clock"></i>' . facebook_time_ago($se["ad_time"]) . '</h2>';
                            echo '</div>';
                        echo '</div>';
                    echo '</a>';		
            echo '</div>';

            }
        }
        else{
            echo "<div class ='empty'>";
			    echo "<h1>no any suitable ads for you</h1>";
					echo "<div class ='svg'>";
						require_once('../imj/svg/noads.svg');
					echo "</div>";
				echo "</div>";
            echo "</div>";
        }
    }

?>