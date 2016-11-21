<?php 

    function uploadDoc($group_kata_upload , $doc_properties){
        ini_set('max_execution_time', 3000);
        $id_dir = $doc_properties['id_dir'];
        $name_doc  = $doc_properties['name_doc'];
        $file_name_new = $doc_properties['file_name_new'];
        $file_size = $doc_properties['file_size'];
        $abstract = $doc_properties['abstract'];

      
        $query = "INSERT INTO ds_document (id_directory , name_document , name_file , `path` , size , `desc` , `date`) VALUES ('".$id_dir."' , '" .mysql_escape_string($name_doc). "' ,  '" .$file_name_new. "' , 'data/pdf'  , '" .$file_size. "' , '" .mysql_escape_string($abstract). "' , NOW())";
        $sql = mysql_query($query) or die(mysql_error());

        $get_last_id =  mysql_query( "SELECT LAST_INSERT_ID()" ) ;
        $last_id = mysql_result($get_last_id ,0);



        foreach ($group_kata_upload as $key => $value) {
        //check ?? terms is exist
               $query = "SELECT * FROM ds_term WHERE term = '".$key."' " ;
               $sql = mysql_query($query) or die(mysql_error());

               if(mysql_num_rows($sql) == 0){
                   //if not exist insert
                    $query = "INSERT INTO ds_term ( `term` , `df` ) VALUES ( '" .$key. "' , 1 )";
                    $sql = mysql_query($query) or die(mysql_error());

               }else{
                   //if exist update idf
                    $query = "UPDATE ds_term SET df = df + 1 WHERE term = '".$key."'";
                    $sql = mysql_query($query) or die(mysql_error());
               }  

        }



        foreach ($group_kata_upload as $key => $value) {
            //insert all terms to ds_index
               //check id_terms on ds_terms(select id_term from terms where terms = "key")
               $query = "SELECT id_term FROM ds_term WHERE term = '".$key."' " ;
               $sql = mysql_query($query) or die(mysql_error());
               $row = mysql_result($sql , 0);

               //inserting id_terms and $value
                $query = "INSERT INTO ds_index( `id_document` , `id_term` , `tf` ) VALUES (  '$last_id' , '" .$row. "'  , '" .$value."'  )";
                $sql = mysql_query($query) or die(mysql_error());
        }

        $query = "UPDATE ds_directory SET size = size + '".$file_size."' WHERE id_directory = '".$id_dir."' "; 
        $sql = mysql_query($query) or die(mysql_error()); 

        }  


?>
