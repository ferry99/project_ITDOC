<?php
require_once (__DIR__ . '/../config.php');

function stemQuery($query){
	include(LIBRARY_PATH . '/pdf2text.php');
	require_once __DIR__ . '/../libraries/sastrawi/vendor/autoload.php';
	$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
						$stemmer  = $stemmerFactory->createStemmer();	           
					


	//	echo '<h2>Stop Word</h2>';
	$file_stop_word = LIBRARY_PATH . '/StopWordList/stopword_list_tala.txt';
	$fopen_sw = fopen($file_stop_word, "r");
    $fread_sw = fread($fopen_sw,filesize($file_stop_word));
      $array_sw = explode("\n", $fread_sw); 
    fclose($fopen_sw);


    // //1.split word into array
	$split = preg_split('/\s+/', $query);


		// //2.remove another character
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
	$stemmer_text = explode(" ", $stemmer_text);
	
	return $stemmer_text;
}

?>