<script type="text/javascript">   
    function get_str_id(){
        var param1var = getQueryVariable("str_id");
        $('#select_directory').val(param1var); 
    }

    function getQueryVariable(variable) {
      var query = window.location.search.substring(1);
      var vars = query.split("&");
      for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if (pair[0] == variable) {      
        //alert('Query Variable ' + pair[1] + 'found');
          return pair[1];
        }
      } 
      //alert('Query Variable ' + variable + ' not found');
    }
</script>


<?php   
require_once ('../config.php');
 

    if (isset($_POST['id'])) {
        require_once (FUNC_PATH . '/connectdb.php'); 
        require_once (VSM_PATH . '/vsm_delete_doc.php'); 
        echo $_POST['id']; 
        $id_doc = $_POST['id'];
        deleteDoc($id_doc);            
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
                        <i class="fa fa-bar-edit-o"></i> Manage Document
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
                        <a href="index.php?page=manage" class="list-group-item">Directory</a>
                        <a href="index.php?page=manage_doc" class="list-group-item active">Document</a>
                    </div>
                </div>
            </div>


                
                <h3>Directory :</h3>
                <div class="form-group col-md-6">
                    <select id="select_directory" class="form-control">
                       <?php 
                       getDir(); 
                          if (isset($_GET['str_id'])) {
                                $firstOp = $_GET['str_id'];
                                echo '<script type="text/javascript"> get_str_id(); </script>';
                            }
                       ?>
                    </select>
                </div>
                

            <div class="col-md-9">


                <div class="panel panel-default filterable">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-file"></span>
                          Document</h3>                        
                        <div class="pull-right">
                               <a href="index.php?page=temp_upload" id="upload" class="btn btn-xs btn-primary btn-create"><span class="btn-label"><i class="glyphicon glyphicon-upload"></i> </span>Upload</button></a>
                        </div>
                    </div>

                   <div class="panel-body">
                      <table class="table" data-toggle="table"  data-show-refresh="true"   data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" >
                          <thead>
                          <tr>
                              <th data-field="id" >ID</th>
                              <th data-field="name"  >Name</th>
                              <th data-field="file" >File name</th>
                              <th data-field="size" >Size</th>
                              <th data-field="date" >Date</th>
                              <th data-field="action" ><em class="fa fa-cog"></em></th>
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
                                                  echo "<a target='_blank' href= " .'../' .$row['path'].'/'.rawurlencode($row['name_directory']).'/'.rawurlencode($row['name_file']). " class='btn btn-default' ><em class='fa fa-eye'></em></a>";
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
            <!-- /.col-md-9 -->
        
        </div>
        <!-- /.manage row -->
</div>
<!-- /.container -->

<?php } ?>

<script type="text/javascript">

   
   $(document).ready(function(){
      $('#select_directory').change(function(){
	        //alert($("#select_directory").val());
	        $.ajax({
	            url: "../ajax/t_document.php",
	            data: { "id_dir": $(this).val() },
	            dataType:"html",
	            type: "post",
	            async: false,
	            success: function(data){
	               $('.col-md-9').replaceWith(data);
	               console.log(data);
	            }
	        });
    	});

       $('#upload').click(function(){
	        if(($("#select_directory").val())== 'NONE'){
		        alert('No directory created,Please create directory before upload');
           		event.preventDefault();
	        };	        
    	});

        $(document).on('click', '.delete', function() { 
        if (confirm("Are you sure you want to delete this document?"))
            {
                var id = $(this).attr('id');
                var data = 'id=' + id ;
                //alert(data);
                var parent = $(this).parent().parent();

                $.ajax(
                {
                       type: "POST",
                       url: "manage_doc.php",
                       data: data,
                       cache: false,
                       success: function(data)
                       {    
                            alert('file has been deleted');
                            console.log(data);
                            parent.fadeOut('slow', function() {$(this).remove();});
                       }
                 });                
            }
        });
    });

  $(function () {
        $('#hover, #striped, #condensed').click(function () {
            var classes = 'table';

            if ($('#hover').prop('checked')) {
                classes += ' table-hover';
            }
            if ($('#condensed').prop('checked')) {
                classes += ' table-condensed';
            }
            $('#table-style').bootstrapTable('destroy')
                .bootstrapTable({
                    classes: classes,
                    striped: $('#striped').prop('checked')
                });
        });
    });
            
    function rowStyle(row, index) {
        var classes = ['active', 'success', 'info', 'warning', 'danger'];

        if (index % 2 === 0 && index / 2 < classes.length) {
            return {
                classes: classes[index / 2]
            };
        }
        return {};
    }
</script>

<?php 
    function getDir() {   
        $sql = "SELECT * FROM ds_directory";
        $result = mysql_query($sql);
        $first = true;
        if (mysql_num_rows($result) == 0) {
          $GLOBALS['firstOp'] = "";
          echo "<option value='NONE'>None</option>";
        }else{
          while($row = mysql_fetch_array($result)) {
              if($first){
                  $GLOBALS['firstOp'] = $row['id_directory'];
                  $first = false;
              }
              echo "<option value='".$row['id_directory']."'>".$row['name_directory']."</option>";
          }
        }
    
    }

?>