<?php


class vsm_searching {

	 public function search($stemmer_text){

			$tf_kata = $this->getTfquery($stemmer_text);	

			$query_arr = array_unique($stemmer_text);
			
			$sqlcon = $this->getQcondition($stemmer_text);
			$query = "SELECT DISTINCT ds_document.id_document 
						FROM ds_index,ds_term,ds_document 
							WHERE ds_index.id_term=ds_term.id_term AND ds_document.id_document=ds_index.id_document AND ($sqlcon) " ;
		   	$result = mysql_query($query) or die(mysql_error());

		   	if (mysql_num_rows($result) > 0) {
	   		 	$total_doc = $this->getTotalDoc();
	   		 	//echo $total_doc;
		   		//echo "</br><h2>Dokumen yang mengandung query : </h2>";
		   		$qvektor = $this->getQvektor($tf_kata);
		   		//echo "</br>Query Vektor : " . $qvektor;
		   			$i = 0;
				   	while ($rows = mysql_fetch_assoc($result)) {
		   				//echo '</br><h4>Document :'.$rows['id_document'].'</br></h4>';
		   				$atas = $this->getWij($query_arr , $rows['id_document']);	   				

		   				//Wdi^2
		   				$query =" SELECT SUM(POWER((ds_index.tf * (LOG10((SELECT COUNT(id_document) FROM ds_document)/ds_term.df ))),2)) 
								FROM ds_term, ds_index
								WHERE ds_index.id_document = '".$rows['id_document']."'	AND ds_term.id_term = ds_index.id_term ";
						$result2 = mysql_query($query) or die(mysql_error());
						$Wdi = mysql_result($result2 ,0);
		   				//echo "</br>Wdi : " . sqrt($Wdi);

						$bawah = $qvektor * sqrt($Wdi);
						$cossim = $atas / $bawah;
		   				//echo "</br>Panjang Vektor : " . $bawah;
		   				//echo "</br>COS SIM = " . $cossim;
		   				$hasil[$i]['id_document'] = $rows['id_document'];
		   				$hasil[$i]['cossim'] = $cossim;
		   				$i++;
		   			}

			   	//echo "</br><h1>Hasil Document = </h2>";
			   	$cossim = array();
			   	foreach ($hasil as $key => $row)
				{
				    $cossim[$key] = $row['cossim'];
				}
				array_multisort($cossim, SORT_DESC, $hasil);

				foreach ($hasil as $key => $value) {
					$arr_id_hasil[] =  $hasil[$key]['id_document'];
					//echo "<br>". $hasil[$key]['id_document'];
				}

				// $time_end = microtime(true);
				// $time = $time_end - $time_start;
				return $arr_id_hasil;
				//echo "</br>Get result in $time seconds\n";

		   	}else{
		   		//echo "Document not found";
		   		return $arr_id_hasil = 0;
		   	}
		}
	



		protected function getTfquery($stemmer_text){
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

		protected function getTotalDoc(){
			$query = "SELECT COUNT('id_document')
					FROM ds_document " ;
	   		$result = mysql_query($query) or die(mysql_error());
	   		$total = mysql_result($result, 0);
	   		return $total;
		}


		protected function getQcondition($query){
			$unique = array_unique($query); 
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


		protected function getWij($keywords , $id_document){
			global $tf_kata;
			global $total_doc;
			$Wdqj = 0;
			$qvektor = 0;
			foreach ($keywords as $key => $value) {
				$query = "SELECT ds_index.tf,ds_term.df
							FROM ds_index,ds_term 
								WHERE ds_index.id_document='$id_document' AND ds_term.term='$value' AND ds_index.id_term=ds_term.id_term " ;
		   		$result = mysql_query($query) or die(mysql_error());
		   		if ($row = mysql_fetch_row($result)) {
		   			$Wqj = $this->getWq($tf_kata , $value , $row[1]);
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


		protected function getWq($keywordArr , $keyword , $df){
			global $total_doc;
			$Tf = $keywordArr[$keyword];
			$Wq = $Tf * (log10($total_doc/$df));
			return $Wq;
		}

		protected function getQvektor($keywordArr){
			$qvektor = 0;
			foreach ($keywordArr as $key => $value) {
				$query = "SELECT ds_term.df
								FROM ds_term 
									WHERE ds_term.term='$key' " ;
		   		$result = mysql_query($query) or die(mysql_error());
		   		if ($row = mysql_fetch_row($result)) {
		   			$Wqj = $this->getWq($keywordArr , $key , $row[0]);
					//echo "<br>Bobot Query '".$key."' = ".$Wqj."^2</br>";
		   	   		$qvektor += ($Wqj*$Wqj);			
				}
			}

			return sqrt($qvektor);
		}

}


?>