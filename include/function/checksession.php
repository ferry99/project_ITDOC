<?php 
	session_start();
	if (!isset($_SESSION['username'])) {
	        header('Location: '.$config['urls']['baseUrl'].'/admin/login.php');
	}  
?>