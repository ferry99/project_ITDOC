<?php

	require_once (__DIR__ . '/../config.php');
	require_once (FUNC_PATH . '/connectdb.php');
	require_once __DIR__ . '/../libraries/sastrawi/vendor/autoload.php';
	
	function indexing($file_tmp , $file_name){
		ini_set('max_execution_time', 3000);
		$start = microtime(true);

		$pdf = '"'.$file_tmp.'"';
		$target_path = '"' .__DIR__ . "\..\data\\temp\\".$file_name.".txt". '"';
		$bin = LIBRARY_PATH . '\pdftotext.exe';

		$execute = $bin." ".$pdf." ".$target_path;
		exec($execute);
		usleep(50);

		$temp_file_txt = __DIR__ . "\..\data\\temp\\".$file_name.".txt";
		if (file_exists($temp_file_txt)){
			$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
			$stemmer  = $stemmerFactory->createStemmer();	

			//echo "parsing success";
			$file_stop_word= $temp_file_txt;
			$fopen_sw = fopen($file_stop_word, "r");

			if(filesize($file_stop_word) == 0){
				//echo filesize($file_stop_word);
				echo "BLANK 1";
				$index_status = false;
				return array('index_status' => $index_status);    	
			}else{
			    $fread_sw = fread($fopen_sw,filesize($file_stop_word));
			    $result =  $fread_sw; 
			    fclose($fopen_sw);

			    if (empty($result)) {
			    	echo "Empty";
					echo "BLANK 2";
			    	$index_status = false;
					return array('index_status' => $index_status);    	
			    }else{

			    	$abstract = getAbstrak(strtolower($result));
			    	$file_stop_word = LIBRARY_PATH .'/StopWordList/stopword_list_tala.txt';
					$fopen_sw = fopen($file_stop_word, "r");
				    $fread_sw = fread($fopen_sw,filesize($file_stop_word));
			      	$array_sw = explode("\n", $fread_sw); 
				    fclose($fopen_sw);


					$split = preg_split('/\s+/', $result);

					//2.remove another character
					foreach ($split as $key=>$value) {
						 if(!preg_match('/[A-Za-z]/',$value)){
						 	unset($split[$key]);
						 }else{
						 	$split[$key]= trim(preg_replace("/[^a-zA-Z ]/", " ", $value));
						 }
					}

					$split = array_map('strtolower', $split);
					$arr_text_filter=array_diff($split, $array_sw);

					$splited_words=implode(" ", $arr_text_filter);
					$stemmer_text  = $stemmer->stem($splited_words);

					$stemmer_array=explode(" ", $stemmer_text);

					foreach ($stemmer_array as $ksa => $vsa) {
						if(strlen($vsa) <=1 || strlen($vsa) >= 20){
						   unset($stemmer_array[$ksa]);
						}
				    }
					

					$group_kata_upload=array();
					foreach ($stemmer_array as $ksa => $vsa) {
					 	if (isset($group_kata_upload[$vsa]))
					    {
					        $group_kata_upload[$vsa]++;
					    } else {
					        $group_kata_upload[$vsa] = 1;
					    }						
					}

					//print_r($group_kata_upload);
					consolejs($group_kata_upload);
					$time = microtime(true) - $start;
					$index_status = true;
					return array('group_kata_upload' => $group_kata_upload , 'index_status' => $index_status , 'time' => $time , 'abstract' => $abstract);
				}	
			}
		}else{
			echo "error parsing";
			$index_status = false;
			return array('index_status' => $index_status);    	
		}

	}
   

	

	function getAbstrak($result){
	 	if (preg_match("~\babstrak\b~" , $result) == true) {
	    	//echo "have abstrak";
    	   	$arr = explode('abstrak', $result);
			$pos=strpos($arr[1], ' ', 250);
			$abstract = substr($arr[1] , 0 ,$pos) . '.....';
			return preg_replace('/[^ \'"A-Za-z0-9\-.()]/', '', $abstract); 
	    }elseif(preg_match("~\babstract\b~" , $result) == true){
	    	//echo "have abstract";
    		$arr = explode('abstract', $result);
			$pos=strpos($arr[1], ' ', 250);
			$abstract = substr($arr[1] , 0 ,$pos) . '.....';
			return preg_replace('/[^ \'"A-Za-z0-9\-.()]/', '', $abstract);
	    }elseif(preg_match("~\babstraksi\b~" , $result) == true){
	    	//echo "have abstract";
    		$arr = explode('abstraks', $result);
			$pos=strpos($arr[1], ' ', 250);
			$abstract = substr($arr[1] , 0 ,$pos) . '.....';
			return preg_replace('/[^ \'"A-Za-z0-9\-.()]/', '', $abstract); 

	    }else{
	    	//echo "dont have";
	    	return $abstract = "";
	    }
	}

    function consolejs($data){
        echo '
        <script type="text/javascript">
          var carnr;        
          data = '.json_encode($data).'
          console.log(data);
        </script>';
    }
?>