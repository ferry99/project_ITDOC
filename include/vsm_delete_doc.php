 <?php

function deleteDoc($id_doc)
{ 
        require_once (__DIR__ . '/../config.php');

        require_once(FUNC_PATH . '/connectdb.php');
        
        //GET ALL id_term FROM SELECTED DOCUMENT
        $sql = "SELECT id_term FROM ds_index WHERE id_document = '$id_doc'";
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)){
            $rows[] = $row['id_term'];
            echo '</br> id_term = '.$row['id_term'];
        }

        // //UPDATE df FROM ds_term 
        foreach ($rows as $key => $value) {
            $query = "UPDATE ds_term SET df = df - 1 WHERE id_term = '$value'";
            $sql = mysql_query($query) or die(mysql_error());   
         }
        
         //DELETE SELECTED DOCUMENT FROM ds_index
          $query = "DELETE from ds_index WHERE id_document = '$id_doc'";
          $sql = mysql_query($query) or die(mysql_error()); 

        //DELETE ds_term if df = 0
         $query = "DELETE from ds_term WHERE df = 0";
         $sql = mysql_query($query) or die(mysql_error());  

           //DELETE FILES PDF file name
          $file_path = __DIR__;
          $query = "SELECT ds_document.* , ds_directory.name_directory 
                        FROM ds_document ,ds_directory
                            WHERE ds_document.id_directory = ds_directory.id_directory AND ds_document.id_document = '$id_doc'" ;
          $result = mysql_query($query) or die(mysql_error());

            if (mysql_num_rows($result)==0) {
                echo "name file is empty";
            }else{
                while ($row = mysql_fetch_assoc($result)) { 
                   $path = $row['path'];
                   $id_dir = $row['id_directory'];
                   $name_dir = $row['name_directory'];
                   $name_file = $row['name_file'];
                   $file_size = $row['size'];
                }
                
                $query = "UPDATE ds_directory SET size = size - '".$file_size."' WHERE id_directory = '$id_dir' ";
                $sql = mysql_query($query) or die(mysql_error());  

                $f_path = '../'.$path.'/'.$name_dir.'/'.$name_file;
                echo $f_path;
                if(file_exists($f_path)){
                    unlink($f_path);
                    echo 'File Deleted';
                }else{
                    echo 'File is not exist';
                }
            }
        


        $query = "DELETE FROM ds_document WHERE id_document = '$id_doc' ";
        $result = mysql_query($query) or die(mysql_error()); 
        echo "Delete success";
}
?>