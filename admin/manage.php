<?php 
require_once ('../config.php');

    if (isset($_POST['id'])) {
        require_once (FUNC_PATH . '/connectdb.php'); 
        require_once (VSM_PATH . '/vsm_delete_doc.php'); 
        echo $_POST['id']; 
        $id = $_POST['id'];

        $query = "SELECT * FROM ds_document WHERE id_directory = '".$id."' ";
        $result = mysql_query($query) or die(mysql_error());

        if (mysql_num_rows($result) > 0) {
            while($row = mysql_fetch_array($result)){
                echo "Deleting".$row['name_document']."</br>";
                deleteDoc($row['id_document']);
            }
        }
        
        $query = "SELECT * FROM ds_directory WHERE id_directory = '".$id."' ";
        $result = mysql_query($query) or die(mysql_error()); 

        if (mysql_num_rows($result) > 0) {
            while($row = mysql_fetch_array($result)){
               $path = $row['path_directory'];
               $name_dir = $row['name_directory'];
            }
        }

        $query = "DELETE FROM ds_directory WHERE id_directory = '".$id."' ";
        $result = mysql_query($query) or die(mysql_error()); 
        echo "Delete Dir success";

        $f_path = $path.$name_dir;
        if(file_exists($f_path)){
            rmdir($f_path);
            echo 'Delete Folder success';
        }else{
            echo 'Folder is not exist';
        }

    }else{
?>

 <div class="container">

        <div class="manage row">
            
            <div class="col-lg-12">                    
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i>  <a href="index.php">Home</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-bar-edit-o"></i> Manage
                        </li>
                    </ol>
            </div>

            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-th"></span>
                             Manage</h3>
                    </div>
                    <div class="list-group">
                        <a href="index.php?page=manage" class="list-group-item active">Directory</a>
                        <a href="index.php?page=manage_doc" class="list-group-item">Document</a>
                    </div>
                </div>
            </div>


            <div class="col-md-9">                

                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                                <h3 class="panel-title"><span class="glyphicon glyphicon-folder-close">
                            </span> Directory</h3>
                            </div>
                            <div class="col col-xs-6 text-right">
                                <a href="index.php?page=temp_mkdir" class="btn btn-sm btn-primary btn-create" role="button">Create Dir</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">                        
                         <table class="table table-striped table-bordered table-list" data-toggle="table"  data-show-refresh="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true"  >
                            <thead>
                                <tr>
                                    <th class="action" data-field="action"><em class="fa fa-cog"></em></th>
                                    <th data-field="id"  class="hidden-xs">ID</th>
                                    <th data-field="name" >Name</th>
                                    <th data-field="date" >Date</th>
                                    <th data-field="size" >Size</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php

                            $query = "SELECT * FROM ds_directory";
                            $result = mysql_query($query) or die(mysql_error());
                            $i = 1;
                            while($row=mysql_fetch_array($result)){
                                echo "<tr>";
                                    echo "<td align='center'>";
                                        echo "<a href=?page=manage_doc&str_id=".$row['id_directory']." class='btn btn-default' ><em class='fa fa-eye'></em></a>";
                                        echo "<a class='btn btn-danger delete' id=".$row['id_directory']." ><em class='fa fa-trash'></em></a>";
                                    echo "</td>";
                                    echo "<td class='hidden-xs'>".$i++."</td>";
                                    echo "<td>".$row['name_directory']."</td>";
                                    echo "<td>".$row['date']."</td>";
                                    echo "<td>".$row['size']."Kb</td>";
                                echo "</tr>";
                            }
                            
                            ?>

                            </tbody>
                        </table>
                    </div>                    
                </div>

            </div>
            <!-- /.col-md-9 -->
        </div>
        <!-- /.manage row -->    

</div>
<!-- /.container -->


<script type="text/javascript">
    $(document).ready(function(){
        $(".delete").click(function(){
        if (confirm("Delete directory will delete all your documment!!!Are you sure you want to delete this row?"))
        {              
            var id = $(this).attr('id');
            var data = 'id=' + id ;
            //alert(data);
            var parent = $(this).parent().parent();

            $.ajax(
            {
                   type: "POST",
                   url: "manage.php",
                   data: data,
                   cache: false,
                   success: function(data)
                   {    
                        alert('directory has been deleted');
                        console.log(data);
                        parent.fadeOut('slow', function() {$(this).remove();});
                   }
             });
        }                
            
        });
    });
</script>

<?php } ?>