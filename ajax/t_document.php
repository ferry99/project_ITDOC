    <link href ="../assets/css/bootstrap.css" rel="stylesheet">
    <link href ="../assets/css/mycss.css" rel="stylesheet">
    <link href ="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel ="stylesheet" href="../assets/css/formValidation.css"/>
    <link href ="../assets/css/bootstrap-table.css" rel="stylesheet">

    
    <script type="text/javascript" src="../assets/js/jquery.js"></script>
    <script type ="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/myjs.js"></script>
    <script language="JavaScript" src="../assets/js/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
    <script type="text/javascript" src="../assets/js/formValidation.js"></script>
    <script type="text/javascript" src="../assets/js/framework/bootstrap.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap-table.js"></script>    
    <script src="../assets/js/jquery.simplePagination.js"></script>
    
<?php
	include('../include/function/connectdb.php'); 
  	if (isset($_POST['id_dir'])) {
    	$firstOp = $_POST['id_dir'];

    }
 ?>                     
    <div class="col-md-9">


        <div class="panel panel-default filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Document</h3>                        
                <div class="pull-right">
                       <a href="index.php?page=temp_upload" id="upload" class="btn btn-xs btn-primary btn-create"><span class="btn-label"><i class="glyphicon glyphicon-upload"></i> </span>Upload</button></a>
                </div>
            </div>

           <div class="panel-body">
              <table class="table" data-toggle="table"  data-show-refresh="true" data-show-toggle="true"  data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="asc">
                  <thead>
                  <tr>
                      <th data-field="id" >ID</th>
                      <th data-field="name"  data-sortable="true">Name</th>
                      <th data-field="file" data-sortable="true">File name</th>
                      <th data-field="size" data-sortable="true">Size</th>
                      <th data-field="date" data-sortable="true">Date</th>
                      <th data-field="action" data-sortable="true"><em class="fa fa-cog"></em></th>
                  </tr>
                  </thead>                         
                  <tbody class="t_body">
                 
                      <?php
                            $query = "SELECT ds_document.* , ds_directory.name_directory
                            FROM ds_document , ds_directory
                            WHERE ds_directory.id_directory = ds_document.id_directory AND ds_directory.id_directory = '$firstOp' ";
                            $result = mysql_query($query) or die(mysql_error());
                            
                            if (mysql_num_rows($result) == 0) {
                                echo "<tr>";
                                    echo "<td text-align='center' colspan='6'>Empty Files</td>";
                                echo "</tr>";
                            }else{
                              $i = 1;
                                while($row=mysql_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>".$i++."</td>";
                                        echo "<td>".$row['name_document']."</td>";
                                        echo "<td>".$row['name_file']."</td>";
                                        echo "<td>".$row['size']."Kb</td>";
                                        echo "<td>".$row['date']."</td>";
                                        echo "<td align='center'>";
                                            echo "<a target='_blank' href= " .$row['path'].'/'.$row['name_directory'].'/'.rawurlencode($row['name_file']). " class='btn btn-default' ><em class='fa fa-eye'></em></a>";
                                            echo "<a class='btn btn-danger delete' id=".$row['id_document']." ><em class='fa fa-trash'></em></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                  </tbody>
              </table>
          </div>
        </div>

    </div>
       

    	    


