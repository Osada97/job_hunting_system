<?php
    require_once('../inc/connection.php');

    $ad_no = $_POST['ad_no'];

    $query = "UPDATE job_ad SET active = 1 WHERE ad_no = {$ad_no} LIMIT 1";
    $result = mysqli_query($connection,$query);

    if(!$result){
        echo "false";
    }
    else{
        echo "true";
    }

?>