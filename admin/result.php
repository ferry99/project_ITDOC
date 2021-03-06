
<?php
require_once ('../config.php');
?>


<body>

	<?php
		if(isset($_GET['q']) && $_GET['q'] != ""){
			$time_start = microtime(true);
			$q = $_GET['q'];			
			$filter = $_GET['search_param'];
		 	$stemmer_text = stemQuery($q);
		 	$arr_id_hasil = vsm_searching($stemmer_text , $filter);
		 	

		 	$limit = 3;  
			$total_records = 0;  
		 }
?>



<div class="result container adminrs">

        <div class="box row">
			<div class="col-lg-10">
				<form class="" action="index.php" method="get">
					<div class="input-group">
						<div class="input-group-btn search-panel">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                  <span id="search_concept"><?php echo get_name_byid($filter);?></a></span> <span class="caret"></span>
                                </button></a>
                                <ul class="dropdown-menu" role="menu">
                                  <?php 
			                       	getDir(); 			                         
			                       ?>
                                </ul>
                        </div>
                        <input type="hidden" name="page" value="result" >
						<input type="text" class="form-control" placeholder="" name="q" value="<?php echo $q; ?>">
                        <input type="hidden" name="search_param" value="<?php echo $filter; ?>" id="search_param">
						<div class="input-group-btn">
							<button class="btn btn-default" type="submit">Search</button>
						</div>
					</div>
				</form>			

			</div>


	    	 <div class="col-md-9">

	    	 	<div class="mb20">
					<h1>Search Results</h1>
					<h2 class="lead"><strong class="text-danger"><?php echo sizeof($arr_id_hasil) ?></strong> results were found for the search for <strong class="text-danger"><?php echo $q ?></strong></h2>								
				</div>				
				

				<div class = "target-content">
					<?php 
						if (empty($arr_id_hasil)) {
						 	echo "No Result Found";
						}else{ 
							 
						     if (isset($_GET["pagenum"])) { $pagenum  = $_GET["pagenum"]; } else { $pagenum=1; };  
						     $start_from = ($pagenum-1) * $limit;  

						    $rsList = implode(', ', $arr_id_hasil);
						    $_SESSION['temp_query'] = $rsList;	
						    $_SESSION['q'] = $q;	

							$query = "SELECT ds_document.* , ds_directory.name_directory 
										FROM ds_document ,ds_directory
											WHERE ds_document.id_document IN (".$rsList.")  AND ds_document.id_directory=ds_directory.id_directory ORDER BY FIELD(id_document, ".$rsList.") LIMIT $start_from, $limit  " ;
							$result = mysql_query($query) or die(mysql_error());

							if (mysql_num_rows($result) == 0) {
							 	echo "No Result Found";
								}else{ 
				                while ($row = mysql_fetch_assoc($result)) {
				                	$para_testing = "testing.php?id=" .$row['id_document']. "&q=" .$q ;
			                	?>  
								<div class="well">
									<div class="media">
										<a class="pull-left" href="#">
											<img class="media-object" src="../assets/img/pdf3.png" width="50" height="50">
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
													<?php echo "<a target='_blank' href=  ".'../' .$row['path'].'/'.rawurlencode($row['name_directory']).'/'.rawurlencode($row['name_file']). ">Download / View</a>" ?>
												</li>
												<li>|</li>
												
											</ul>
										</div>
									</div>
								</div>
						 <?php  
			                };  
		                ?>  
			            <!-- /.well -->
						</div>

						<!-- <div class="result pull-left"><strong>Showing 1 to 3 of <?php echo sizeof($arr_id_hasil) ?></strong></div> -->
						<?php  
						        $sql = "SELECT COUNT(id_document) FROM ds_document WHERE id_document IN (".$rsList.")";  
						        $rs_result = mysql_query($sql);  
						        $row = mysql_fetch_row($rs_result);  
						        $total_records = $row[0];  
						        $total_pages = ceil($total_records / $limit);  
						        $pagLink = "<ul class='pagination pull-right'>";  
						        for ($i=1; $i<=$total_pages; $i++) {  
						           $pagLink .= "<li><a href='../ajax/admin_pagination.php?pagenum=".$i."'>".$i."</a></li>";  
						       };  
						       echo $pagLink . "</ul>";  
				       ?>			
            </div>
            <!-- /.col-md-9 -->
            <?php }} ?>
        </div>
		<!-- /.box row -->

</body>




<?php 
    function getDir() {   
        $sql = "SELECT * FROM ds_directory";
        $result = mysql_query($sql);
        $first = true;
        if (mysql_num_rows($result) == 0) {
          echo "<li><a href='#empty'></a></li>";
        }else{
          while($row = mysql_fetch_array($result)) {  
            echo "<li><a href=".'#'.$row['id_directory'].">".$row['name_directory']."</a></li>";
          }
        }    
    }


     function get_name_byid($id) {   
        $sql = "SELECT name_directory FROM ds_directory WHERE id_directory = $id";
        $result = mysql_query($sql);
        if (mysql_num_rows($result) == 0) {
        }else{
          while($row = mysql_fetch_array($result)) {  
            $name = $row['name_directory'];
          }
          return $name;
        }    
    }


?>


<script type="text/javascript">
$(document).ready(function(){


    $('.search-panel .dropdown-menu').find('a').click(function(e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#","");
        var concept = $(this).text();
        $('.search-panel span#search_concept').text(concept);
        $('.input-group #search_param').val(param);
    });

    $('.pagination').pagination({
        items: <?php echo $total_records;?>,
        itemsOnPage: <?php echo $limit;?>,
        cssStyle: 'light-theme',
        currentPage : 1,
        onPageClick : function(pageNumber) {
            $('.target-content').html('loading...');
            $('.target-content').load("../ajax/admin_pagination.php?pagenum=" + pageNumber);
        }
    });
});
</script>