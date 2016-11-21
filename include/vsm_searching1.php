<?php

function vsm_searching($stemmer_text , $filter){

			$GLOBALS['tf_kata'] = getTfquery($stemmer_text);	
			$tf_kata = $GLOBALS['tf_kata'];
			$query_arr = array_unique($stemmer_text);			
			$sqlcon = getQcondition($query_arr);


			$query = "SELECT DISTINCT ds_document.id_document 
						FROM ds_index,ds_term,ds_document 
							WHERE ds_index.id_term=ds_term.id_term AND ds_document.id_document=ds_index.id_document AND ($sqlcon) AND ds_document.id_directory= $filter " ;
		   	$result = mysql_query($query) or die(mysql_error());

		   	if (mysql_num_rows($result) > 0) {
	   		 	$GLOBALS['total_doc'] = getTotalDoc();	 
	   		 	//print_r ($tf_kata);  		 	
		   		//echo "</br><h2>Dokumen yang mengandung query : </h2>";
		   		$qvektor = getQvektor($tf_kata);
		   		//echo "</br>Query Vektor : " . $qvektor;
		   			$i = 0;
				   	while ($rows = mysql_fetch_assoc($result)) {
		   				//echo '</br><h4>Document :'.$rows['id_document'].'</br></h4>';
		   				$atas = getWij($query_arr , $rows['id_document']);	   				

		   				//Wdi^2
		   				$query =" SELECT SUM(POWER((ds_index.tf * (LOG10((SELECT COUNT(id_document) FROM ds_document)/ds_term.df ))),2)) 
								FROM ds_term, ds_index
								WHERE ds_index.id_document = '".$rows['id_document']."'	AND ds_term.id_term = ds_index.id_term ";
						$result2 = mysql_query($query) or die(mysql_error());
						$Wdi = mysql_result($result2 ,0);
		   				//echo "</br>Wdi : " . sqrt($Wdi);

						$bawah = $qvektor * sqrt($Wdi);
						if ($bawah == 0 || $atas == 0) {
							$cossim = 0;
						}else{
							$cossim = $atas / $bawah;
							$hasil2[$i]['id_document'] = $rows['id_document'];
			   				$hasil2[$i]['cossim'] = $cossim;
			   				$i++;
						}
		   				//echo "</br>Panjang Vektor Bawah (Qvektor * Wdi) =" . $bawah;
		   				//echo "</br>COS SIM = " . $cossim;
		   				
		   			}

				   	//echo "</br><h1>Hasil Document = </h2>";
				   	if (isset($hasil2)) {

				   		$hasil2 = filterHasil($hasil2);
			   			$cossim = array();
					   	foreach ($hasil2 as $key => $row)
						{
						    $cossim[$key] = $row['cossim'];
						}
						array_multisort($cossim, SORT_DESC, $hasil2);

						foreach ($hasil2 as $key => $value) {
							$arr_id_hasil2[] =  $hasil2[$key]['id_document'];
							//echo "<br>". $hasil2[$key]['id_document'] . " = " .$hasil2[$key]['cossim'];
						}
						if (!empty($arr_id_hasil2)) {
							return $arr_id_hasil = $arr_id_hasil2;
						}else{
							return $arr_id_hasil = array();
						}
						
					}else{					
						return $arr_id_hasil = array();					
					}		   

		   	}else{
		   		return $arr_id_hasil = array();
		   	}

		}



		function getTfquery($stemmer_text){
			$tf_kata = array();	
			foreach ($stemmer_text as $ksa => $vsa) {
				 if (isset($tf_kata[$vsa]))
			    {
			        $tf_kata[$vsa]++;
			    } else {
			        $tf_kata[$vsa] = 1;
			    }			
			}
			return $tf_kata;
		}

		function getTotalDoc(){
			$query = "SELECT count( DISTINCT(id_document) ) FROM ds_index " ;
	   		$result = mysql_query($query) or die(mysql_error());
	   		$total = mysql_result($result, 0);
	   		return $total;
		}


		function getQcondition($query){
			$unique = $query; 
			$or = true;
			foreach ($unique as $key => $value) {
				if($or){
					$sqlcon = " ds_term.term = '$value' ";
					$or = false;
				}else{
					$sqlcon .= "OR ds_term.term = '$value' ";
				}
			}
			return $sqlcon;
		}

		function getQcondition2($query){
			$unique = $query; 
			$or = true;
			$qList = "'".implode("' , '", $unique)."'";
			$sqlcon2 = " ds_term.term IN ( $qList ) ";
			return $sqlcon2;
		}


		function getWij($keywords , $id_document ){
			global $tf_kata;
			$total_doc = getTotalDoc();
			$Wdqj = 0;
			$qvektor = 0;
			foreach ($keywords as $key => $value) {
				$query = "SELECT ds_index.tf,ds_term.df
							FROM ds_index,ds_term 
								WHERE ds_index.id_document='$id_document' AND ds_term.term='$value' AND ds_index.id_term=ds_term.id_term " ;
		   		$result = mysql_query($query) or die(mysql_error());
		   		if ($row = mysql_fetch_row($result)) {
		   			$Wqj = getWq($tf_kata , $value , $row[1]);
	   				//echo "<br>Bobot Query ".$value." = ".$Wqj."</br>";

	   				$idf = log10($total_doc/$row[1]);
	   				$Wdj = $row[0]*$idf;
	   				//echo "<br>Bobot kata ".$value." = ".$Wdj."</br>";
	   				
	   				$Wdqj += ($Wdj * $Wqj);
	   				//echo "<br>Atas = ".$Wdqj."</br>";
		   		}
			}
			return $Wdqj; 
		}


		function getWq($keywordArr , $keyword , $df){
			$total_doc = getTotalDoc();
			$Tf = $keywordArr[$keyword];
			$Wq = $Tf * (log10($total_doc/$df));
			return $Wq;
		}

		function getQvektor($keywordArr){
			$qvektor = 0;
			foreach ($keywordArr as $key => $value) {
				$query = "SELECT ds_term.df
								FROM ds_term 
									WHERE ds_term.term='$key' " ;
		   		$result = mysql_query($query) or die(mysql_error());
		   		if ($row = mysql_fetch_row($result)) {
		   			$Wqj = getWq($keywordArr , $key , $row[0]);
					//echo "<br>Bobot Query '".$key."' = ".$Wqj."^2</br>";
		   	   		$qvektor += ($Wqj*$Wqj);			
				}
			}

			return sqrt($qvektor);
		}

		function filterHasil($array){
			foreach($array as $subKey => $subArray){
		          if($subArray['cossim'] < 0.005){
		               unset($array[$subKey]);
		          }
		     }
			return $array;
		}
	     

?>