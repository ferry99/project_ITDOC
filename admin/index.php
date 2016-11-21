<!DOCTYPE html> 

<?php
require_once ('../config.php');

require_once(FUNC_PATH . '/mainvals.php');
require_once(FUNC_PATH . '/connectdb.php');  
require_once(FUNC_PATH . '/readvals.php');  
require_once(FUNC_PATH . '/readcookie.php'); 

require_once(FUNC_PATH . '/checksession.php');                   

require_once (VSM_PATH . '/stemmerQ.php');
require_once (VSM_PATH . '/vsm_searching1.php');
?>

<head>


    <title>Doc Sekker</title>

    <link href ="../assets/css/bootstrap.css" rel="stylesheet">
    <link href ="../assets/css/mycss.css" rel="stylesheet">
    <link href ="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel ="stylesheet" href="../assets/css/formValidation.css"/>
    <link href ="../assets/css/bootstrap-table.css" rel="stylesheet">

    
    <script type="text/javascript" src="../assets/js/jquery.js"></script>
    <script type ="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/myjs.js"></script>
    <script language="JavaScript" src="../assets/js/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
    <script type="text/javascript" src="../assets/js/formValidation.js"></script>
    <script type="text/javascript" src="../assets/js/framework/bootstrap.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap-table.js"></script>    
    <script src="../assets/js/jquery.simplePagination.js"></script>


</head>


<body>    
    
    <?php 
    require_once ( TEMPLATE_PATH . '/navbar.php');     
     require_once ('loadmain.php');     
    // require_once ( TEMPLATE_PATH . '/footer.php');

      ?>
    

</body>

