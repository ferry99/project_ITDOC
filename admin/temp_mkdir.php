<?php 
    require_once ('../config.php');
?>

<div class="container">
    <div class="manage row">

            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="index.php">Home</a>
                    </li>
                    <li>
                        <i class="fa fa-edit"></i>  <a href="index.php">Manage Directory</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-plus"></i> Create Directory
                    </li>
                </ol>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-th"></span>
                             Creating directory</h3>
                    </div>
                  
                    <div class="list-group">
                        <a href="index.php?page=manage" class="list-group-item "><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
                    </div>
                </div>
            </div>


            <div class="col-lg-9">
                <h2 class="page-header">Create Directory</h2>
                  <?php
				    if (isset($_POST['dirbtn'])){
					    	require_once (FUNC_PATH . '/mainvals.php');
				    		$dir_name = $_POST['dir_name'];

							if(!is_dir($dir. $dir_name)){
								mkdir( $dir. $dir_name);
								echo '<div class="alert alert-success alert-dismissable">';
						        echo "<button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>";
						        echo "Directory created";
						        echo "</div>";

								$query="INSERT INTO ds_directory (name_directory , path_directory , `date` , `size`) VALUES ('".$dir_name."' , '" .$dir. "' , now() , 0)";
						        $sql = mysql_query($query) or die(mysql_error());

							}else {
								echo '<div class="alert alert-danger alert-dismissable">';
						        echo "<button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>";
						        echo "Dir already exist";
						        echo "</div>";
								// $dh = opendir(__DIR__."/../data/pdf");
								//  while (($file_local = readdir($dh)) !== false) {				
								// 		echo $file_local.'</br>';								
								// }
							}
				       
				    }
					?>
                <form role="form" id="mkdirform" action="index.php?page=temp_mkdir" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Directory Name</label>
                        <input class="form-control" placeholder="Enter text" name="dir_name">
                    </div>
                    <button type ="submit" name="dirbtn"  class="btn btn-default">Create</button>
                </form>
            </div>    

    </div>
    <!-- /.row -->
</div>
    <!-- /.container -->


<script language="JavaScript" type="text/javascript"
    xml:space="preserve"> 
    $(document).ready(function() {
        $('#mkdirform').formValidation({
            icon: {
                valid: 'glyphicon',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                dir_name: {
                    validators: {
                        regexp: {
                            regexp: /^[a-z0-9\s]+$/i,
                            message: 'The directory name cannot contain any special character'
                        },
                        notEmpty: {
                            message: 'Directory name is required'
                        }
                    }
                }
            }
        });
});
//]]></script>