<?php
	include('../include/function/connectdb.php');  

	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$limit = 5;
	$start_from = ($page-1) * $limit;  
	  
	$query = "SELECT ds_document.* , ds_directory.name_directory 
					FROM ds_document ,ds_directory
						WHERE ds_document.id_directory=ds_directory.id_directory LIMIT $start_from, $limit  " ; 
	$result = mysql_query($query) or die(mysql_error());
	?>

	<?php  
	while ($row = mysql_fetch_assoc($result)) {
	?>  
         <div class="well">
						<div class="media">
							<a class="pull-left" href="#">
								<img class="media-object" src="assets/img/pdf3.png" width="50" height="50">
							</a>
							<div class="media-body">
								<a href="#"><h4 class="media-heading"><?php echo $row['name_document']; ?></h4></a>
								<!-- <p class="text-right">By Francisco</p> -->
								<p class="desc"><?php echo $row['desc']; ?></p>
								<ul class="list-inline list-unstyled">
									<li><span><i class="glyphicon glyphicon-calendar"></i><?php echo $row['date']; ?></span></li>
									<li>|</li>
									<span><i class="glyphicon glyphicon-file"></i><?php echo $row['name_directory']; ?></span>
									<li>|</li>
									<li>
											<?php echo "<a target='_blank' href= " .$row['path'].'/'.rawurlencode($row['name_directory']).'/'.rawurlencode($row['name_file']). ">Download / View</a>" ?>
									</li>
									<li>|</li>
									
								</ul>
							</div>
						</div>
					</div>



	<?php  
	};  
	?>
