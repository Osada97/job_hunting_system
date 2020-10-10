<?php 

	session_start();

	$_SEESSION = array();

	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(),'',time()-86400, '/');
	}

	session_destroy();

	header("location:index.php");


?>