<?php 
    if (isset($_POST['uploadbtn'])){
        $name_doc = $_POST['name_doc'];
        $id_dir = $_POST['name_dir'];
        $name_dir = getNameDir($id_dir);
        $file = $_FILES['file'];


        //File properties
        $file_name = str_replace('"', '', $file['name']);
        $file_name = preg_replace("/[^a-zA-Z0-9.]/", " ", $file_name);
        $file_tmp = $file['tmp_name'];
        $file_size = substr($file['size'], 0 , -3);
        $file_error = $file['error'];

        //File extension
        $file_ext = explode('.' , $file_name) ;
        $file_ext = strtolower(end($file_ext));
        $allowed = array('pdf');

        $file_name_withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);

        require_once (VSM_PATH . '/vsm_indexing2.php');
        $index = indexing($file_tmp , $file_name_withoutExt);
        
        //$index = indexing($file_tmp , $id_dir);


        if (in_array($file_ext ,$allowed)) {
            if ($file_error === 0) {               
                if ($file_size <= 2097162) {
                    $file_name_new = str_replace(".pdf", "_".date("ymdgis").".pdf", strtolower($file_name));
                    $file_destination = $dir . $name_dir . '/' . $file_name_new;                    
                        
                        if($index['index_status'] == false ) {
                            $notif = "<div class='alert alert-danger alert-dismissable'>
                                    <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                                    <strong>Parsing Error</strong><br>
                                    Check your pdf compability
                                    </div>";
                        }else{
                            if (move_uploaded_file($file_tmp, $file_destination)) {
                              
                                $notif = "<div class='alert alert-success alert-dismissable'>
                                            <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                                            <strong>File Uploaded</strong><br>
                                            Indexing process time :<b>".$index['time']."secs</b> 
                                            </div>";
                                $continue = true;
                            }else{
                                 $notif = "<div class='alert alert-success alert-dismissable'>
                                        <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                                        <strong>Upload Error</strong>
                                        </div>";
                                $continue = false;

                            }

                            if ($continue) {

                                $group_kata_upload = $index['group_kata_upload'];

                                require_once (VSM_PATH . '/vsm_uploader.php');

                                $doc_properties = array(
                                    "id_dir"         => $id_dir,  
                                    "name_doc"      => $name_doc,  
                                    "file_name_new"      => $file_name_new,
                                    "file_size"      => $file_size,
                                    "abstract" => $index['abstract']
                                );

                                uploadDoc($group_kata_upload , $doc_properties);
                                

                            }                           

                        }                       
                   } 
                }
            }
        }
       

?>

<div class="container">
    <div class="manage row">

         <div class="col-lg-12">   

            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="index.php">Home</a>
                </li>
                <li>
                    <i class="fa fa-edit"></i>  <a href="index.php">Manage Document</a>
                </li>
                <li class="active">
                    <i class="fa fa-upload"></i> Upload Document
                </li>
            </ol>
        </div>

        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-th"></span>
                    Upload Document</h3>
                </div>
                <div class="list-group">
                    <a href="index.php?page=manage_doc" class="list-group-item "><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <h2 class="page-header">Upload Document</h2>
            <form role="form" id="upform" action="index.php?page=temp_upload" method="post" enctype="multipart/form-data">
                <?php if (isset($notif)) {
                    echo $notif;
                }
                ?>
                <div class="form-group">
                    <label>Document Name</label>
                    <input class="form-control" placeholder="Enter text" name="name_doc">
                </div>
                
                <div class="form-group">
                    <label>Directory</label>
                    <select class="form-control" name="name_dir">
                        <?php getDir(); ?>
                    </select>
                </div>
            
                
                 <div class="form-group">
                    <input type="file" name="file"/>
                </div>
       

                <button type ="submit" name="uploadbtn" id="uploadbtn" data-loading-text="<i class='fa fa-spinner fa-spin'></i>Loading..." value = "upload" class="btn btn-default">Upload</button>
            </form>
        </div>

        <div class="col-md-6">
            <h3 class="page-header">Recently Upload</h3>
                <table class="table table-striped">
                    <tbody>
                    <?php 
                         $query = "SELECT ds_document.* , ds_directory.name_directory 
                                        FROM ds_document ,ds_directory
                                            WHERE ds_document.id_directory = ds_directory.id_directory ORDER BY ds_document.date DESC LIMIT 3" ;
                        $result = mysql_query($query) or die(mysql_error());
                        while ($row = mysql_fetch_assoc($result)) { 
                    ?>
                    <tr class="success">
                        <td><?php echo $row['name_file'] ?></td>
                        <td><span class="glyphicon glyphicon-arrow-right"></td>
                        <td><?php echo $row['name_directory'] ?></td>
                        <td><?php echo $row['date'] ?></span>
                        </td>                                       
                    </tr> 
                    <?php } ?>              
                  </tbody>
                </table>        
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->



<?php 

    function getDir() {   
        $sql = "SELECT * FROM ds_directory";
        $result = mysql_query($sql);
        // Lakukan perulangan pada data yang dikembalikan dan tampilkan
        if (mysql_num_rows($result) == 0) {
            echo "<option value='NONE' >None</option>";
        }else{
            while($row = mysql_fetch_array($result)) {
                echo "<option value='".$row['id_directory']."' >".$row['name_directory']."</option>";
            }
        }
    
    }


    function getNameDir($para1){
        $id_dir = $para1;   
        $sql = "SELECT name_directory FROM ds_directory WHERE id_directory = '$id_dir'";
        $result = mysql_query($sql);
        $name = mysql_fetch_array($result);
        if($name != null){
            return $name_dir = $name[0];
        }else{
        
        }   
    }


?>



<script language="JavaScript" type="text/javascript"
    xml:space="preserve">
    
    $(document).ready(function() {


     $('#uploadbtn').on('click', function() {
        var $this = $(this);
      $this.button('loading');
    });


    $('#upform').formValidation({
        button: {
            disabled: 'disabled'
        },
       icon: {
                valid: 'glyphicon',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name_doc: {
                validators: {
                    notEmpty: {
                        message: 'Document name is required'
                    },                    
                }
            },
            file: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        message: 'Please choose a pdf file.'
                    },
                    notEmpty: {
                        message: 'Document file is required'
                    }
                }
            }
        }       

    })
     .on('err.form.fv', function(e) {
          $('#uploadbtn').button('reset');
        }); 
   
});
</script>
