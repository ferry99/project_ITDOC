<?php 


// create stemmer
// cukup dijalankan sekali saja, biasanya didaftarkan di service container
include("Stemmer/StemmerFactory.php");
$stemmerFactory = new StemmerFactory();
$stemmer  = $stemmerFactory->createStemmer();

// stem
$sentence = 'Perekonomian Indonesia sedang dalam pertumbuhan yang membanggakan';
$output   = $stemmer->stem($sentence);

echo $output . "\n";
// ekonomi indonesia sedang dalam tumbuh yang bangga

echo $stemmer->stem('Mereka meniru-nirukannya') . "\n"; ?>