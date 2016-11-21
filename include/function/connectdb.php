<?php
	$server ="localhost";
	$db_username = "root";
	$password = "";
	$database = "docsek04";
	$konek = mysql_connect($server,$db_username,$password) or die ("Gagal koneksi" .mysql_error());
	$bukadb = mysql_select_db($database) or die ("Gagal buka database".mysql_error());

?>