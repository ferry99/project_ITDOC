<?php
	session_start();
	require_once ('../config.php');
	include(FUNC_PATH . '/connectdb.php');  

	if (isset($_GET["pagenum"])) { $page = $_GET["pagenum"]; } 
		
	else { $page = 1; };  


	$limit = 3;
	$start_from = ($page-1) * $limit;  
	$rsList = $_SESSION['temp_query'];
	  
	$query = "SELECT ds_document.* , ds_directory.name_directory 
					FROM ds_document ,ds_directory
						WHERE ds_document.id_document IN (".$rsList.") AND ds_document.id_directory=ds_directory.id_directory ORDER BY FIELD(id_document, ".$rsList.") LIMIT $start_from, $limit  " ; 
	$result = mysql_query($query) or die(mysql_error());
	?>

	<?php  
	while ($row = mysql_fetch_assoc($result)) {
		$q = $_SESSION['q'];
    	$para_testing = "testing.php?id=" .$row['id_document']. "&q=" .$q ;
	?>  
         <div class="well">
						<div class="media">
							<a class="pull-left" href="#">
								<img class="media-object" src="/IT-Docs/assets/img/pdf3.png" width="50" height="50">
							</a>
							<div class="media-body">
								<a href="#"><h4 class="media-heading"><?php echo $row['name_document']; ?></h4></a>
								<a href="<?= $para_testing ?>"> <p class="text-right">Show Index</p></a>
								<p class="desc"><?php echo $row['desc']; ?></p>
								<ul class="list-inline list-unstyled">
									<li><span><i class="glyphicon glyphicon-calendar"></i><?php echo $row['date']; ?></span></li>
									<li>|</li>
									<span><i class="glyphicon glyphicon-file"></i><?php echo $row['name_directory']; ?></span>
									<li>|</li>
									<li>
											<?php echo "<a target='_blank' href= ".'/IT-Docs/' .$row['path'].'/'.rawurlencode($row['name_directory']).'/'.rawurlencode($row['name_file']). ">Download / View</a>" ?>
									</li>
									<li>|</li>
									
								</ul>
							</div>
						</div>
					</div>

	<?php  
	};  
	?>
