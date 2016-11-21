<?php

$config = array(    
	    "urls" => array(
	        "baseUrl" => "http://localhost/IT-Docs"
	    )   
);

defined("LIBRARY_PATH")
    or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/libraries'));
     
defined("FUNC_PATH")
    or define("FUNC_PATH", realpath(dirname(__FILE__) . '/include/function'));

defined("VSM_PATH")
    or define("VSM_PATH", realpath(dirname(__FILE__) . '/include'));

defined("TEMPLATE_PATH")
    or define("TEMPLATE_PATH", realpath(dirname(__FILE__) . '/include/template'));

defined("AJAX_RES_PATH")
    or define("AJAX_RES_PATH", realpath(dirname(__FILE__) . '/ajax'));

 defined("ASSETS_PATH")
    or define("ASSETS_PATH", realpath(dirname(__FILE__) . '/assets'));


?>