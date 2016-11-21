<?php
    // some values we read through get or post 
	$dir = "../data/pdf/";
	if (!empty($_GET['page'])) {
	    $page=$_GET['page'];
	}
	else { $page="home"; }

	if (!empty($_GET['action'])) {
	    $action=$_GET['action'];
	}else{
		$action="";
	}

	if (!empty($_GET['err'])) {
	    $err=$_GET['err'];
	}else{
		$err="";
	}

	if (!empty($_POST['action'])) {
	    $action=$_POST['action'];
	}

?>