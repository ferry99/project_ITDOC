<?php

    require_once ('/libraries/pdf2text.php');
	require_once ('/libraries/sastrawi/vendor/autoload.php');

	function preprocess($doc){

		
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();

		//Get Stopwords from .txt
		$file_stop_word = 'libraries/StopWordList/stopword_list_tala.txt';
		$fopen_sw = fopen($file_stop_word, "r");
		$fread_sw = fread($fopen_sw,filesize($file_stop_word));
		$array_sw = explode("\n", $fread_sw); 
		fclose($fopen_sw);


		$result = pdf2text($doc);

		//1.split word into array
		$split = preg_split('/\s+/', $result);

		//2.remove another character
		foreach ($split as $key => $value) {
			 if(!preg_match ('/[A-Za-z]/',$value)){
			 	unset($split[$key]);
			 }else{
			 	$split[$key] = trim(preg_replace("/[^a-zA-Z ]/", " ", $value));
			 }
		}

		//3.filter with stopwords
		$split = array_map('strtolower', $split);
		$filtered_terms = array_diff($split, $array_sw);


		 //4.stemming
		$splited_words=implode(" ", $filtered_terms);
		$stemmed_terms  = $stemmer->stem($splited_words);

		
		//5.get TF
		$stemmer_array=explode(" ", $stemmed_terms);
		$group_kata_upload=array();
		foreach ($stemmer_array as $ksa => $vsa) {
			 if (isset($group_kata_upload[$vsa]))
		    {
		        $group_kata_upload[$vsa]++;
		    } else {
		        $group_kata_upload[$vsa] = 1;
		    }
				
		}


		return $group_kata_upload;
					


	}

	



?>