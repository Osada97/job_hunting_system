<?php 
	require_once('../inc/connection.php');

	$sno = $_POST['sno'];
	$form = $_POST['form'];
	$user_id = $_POST['user_id'];

	if($form==='sk'){
		$query_dl = "DELETE FROM professional_skills WHERE user_id = {$user_id} AND no={$sno} LIMIT 1";
		$result_dl = mysqli_query($connection,$query_dl);
	}

	//deleting other forms
	$fno  = $_POST['fno'];
	$form_name = $_POST['form_name'];
	$user_id = $_POST['user_id'];

	if($form_name==='ed'){
		$query_dl = "DELETE FROM education WHERE user_id = {$user_id} AND no={$fno} LIMIT 1";
		$result_dl = mysqli_query($connection,$query_dl);
	}
	if($form_name==='we'){
		$query_dl = "DELETE FROM work_experience WHERE user_id = {$user_id} AND no={$fno} LIMIT 1";
		$result_dl = mysqli_query($connection,$query_dl);
	}
	if($form_name==='aw'){
		$query_dl = "DELETE FROM awards WHERE user_id = {$user_id} AND no={$fno} LIMIT 1";
		$result_dl = mysqli_query($connection,$query_dl);
	}
	if($form_name==='addi'){
		$query_dl = "DELETE FROM additional_cv WHERE user_id = {$user_id} AND no={$fno} LIMIT 1";
		$result_dl = mysqli_query($connection,$query_dl);
	}

?>