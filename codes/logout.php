<?php
	//Logging out of system//
	include('connect.php');
	session_start();
	if ( isset( $_SESSION['user_id'] )){
		session_destroy();
	}
	header('location:../landing_page.php');
?>