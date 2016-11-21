<?php

require_once (__DIR__ .'/../config.php');
require_once (VSM_PATH . '/vsm_searching1.php');
require_once (VSM_PATH . '/stemmerQ.php');


function test($q , $id_document){

 	$stemmer_text = stemQuery($q);
	$GLOBALS['tf_kata'] = getTfquery($stemmer_text);	
	$tf_kata = $GLOBALS['tf_kata'];
	$query_arr = array_unique($stemmer_text);	

	$qvektor = getQvektor($tf_kata);
	$atas = getWij($query_arr , $id_document);	   				

	$query =" SELECT SUM(POWER((ds_index.tf * (LOG10((SELECT COUNT(id_document) FROM ds_document)/ds_term.df ))),2)) 
		FROM ds_term, ds_index
		WHERE ds_index.id_document = '".$id_document."'	AND ds_term.id_term = ds_index.id_term ";
	$result2 = mysql_query($query) or die(mysql_error());

	$Wdi = mysql_result($result2 ,0);
	$bawah = $qvektor * sqrt($Wdi);
	$cossim = $atas / $bawah;

	return(array('skalar' => $atas , 'vektorQ' => $qvektor , 'vektorDn' => sqrt($Wdi) , 'cossim' => $cossim));
}


function testW( $id_document){
   				

	$query =" SELECT ds_term.term ,ds_index.tf * (LOG10((SELECT COUNT(id_document) FROM ds_document)/ds_term.df )) as W
		FROM ds_term, ds_index
		WHERE ds_index.id_document = '".$id_document."'	AND ds_term.id_term = ds_index.id_term ";
	$result2 = mysql_query($query) or die(mysql_error());

	while ($row = mysql_fetch_assoc($result2)) {
		$bobot[$row['term']] = $row['W'];
	}
	return $bobot;
	
}
			   				
?>