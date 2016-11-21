<div class="container">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>indexing</th>
        <th>document</th>
        <th>writedb</th>
      </tr>
    </thead>
    <tbody>
     

 <?php




    require_once ('/../config.php');
    $dir = "../data/pdf/";
    ini_set('max_execution_time', 300);

    $folder = dirname(__FILE__)."\..\sample\*";
    $i=0;
    foreach(glob($folder) as $files){
       // echo $files;
        $start = microtime(true);
        $name_doc = strtolower(basename($files));
        $size = filesize($files);
     


        // $name_doc = $_POST['name_doc'];
         $id_dir = 1;
         $name_dir = 'journal';
        // $file = $_FILES['file'];


         //File properties
        $file_name = str_replace('"', '', basename($files));
        $file_name = preg_replace("/[^a-zA-Z0-9.]/", " ", basename($files));
        // $file_tmp = $file['tmp_name'];
        $file_size = substr($size, 0 , -3);

         //File extension

         $file_name_withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name_doc);
          //echo $files.'<br />';
        require_once (VSM_PATH . '/vsm_indexing2.php');
        $index = indexing($files , $file_name_withoutExt);
        


        $file_name_new = str_replace(".pdf", "_".date("ymdgis").".pdf", strtolower($file_name));
        $file_destination = $dir . $name_dir . '/' . $file_name_new; 
       // echo $file_destination.'<br />';
                   

            if($index['index_status'] == false ) {
                echo "EROR";
            }else{
                if (copy( $files,  $file_destination )) {
                    $continue = true;
                }else{
                echo "ERROR Upload";
                    $continue = false;
                }
                if ($continue) {
                    $group_kata_upload = $index['group_kata_upload'];

                    require_once (VSM_PATH . '/vsm_uploader.php');

                    $doc_properties = array(
                        "id_dir"         => $id_dir,  
                        "name_doc"      => $file_name_withoutExt,  
                        "file_name_new"      => $file_name_new,
                        "file_size"      => $file_size,
                        "abstract" => $index['abstract']
                    );

                    uploadDoc($group_kata_upload , $doc_properties); 
                    //sleep(5);
                        $time  = microtime(true) - $start;
                        echo "<tr>";
                            echo "<td>".$index['time']."</td>";
                            echo "<td>".$file_name_withoutExt." : success</td>";
                            echo "<td>".($time-$index['time'])."</td>";
                         echo "</tr>";
                    $i++;
                }                           

         }                       
     

    }
    echo $i;



?>

 
     
    </tbody>
  </table>
</div>