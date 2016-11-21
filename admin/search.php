<?php
	if(getCountDir() == 0){
		echo "<script>alert('Fail to Search..You dont have Document '); window.location = 'index.php'</script>";
	};

?>
  
<div class="container">

	 <div class="col-lg-12">
	    <h1 class="page-header">
	        Search
	    </h1>
	</div>

	<div class="row">
		<div class="col-lg-8">
	            <form id="mysearch" action="index.php?" role="search" method="GET">
	                <div class="input-group">
                        <input type="hidden" name="page" value="result">
	                    <input type="text" class="form-control" placeholder="Search Here" name="q" required data-fv-notempty-message="The field is required">
	                    <div class="input-group-btn">
	                        <button id="search" class="btn btn-default" type="submit">Search</button>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label>Directory</label>
	                    <select class="form-control" name="search_param">
	                        <?php getDir(); ?>
	                    </select>
	                </div>

	            </form>
		 </div>     
	</div>


</div>




<?php 

    function getDir() {   
        $sql = "SELECT * FROM ds_directory";
        $result = mysql_query($sql);
        // Lakukan perulangan pada data yang dikembalikan dan tampilkan
        while($row = mysql_fetch_array($result)) {
            echo "<option value='".$row['id_directory']."'>".$row['name_directory']."</option>";

       }
    
    }


     function getCountDir() {   
        $sql = "SELECT COUNT(*) FROM ds_directory";
        $result = mysql_query($sql);        
    	return mysql_result($result ,0);
    }

?>