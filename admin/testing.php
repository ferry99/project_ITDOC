  <link href ="../assets/css/bootstrap.css" rel="stylesheet">
    <link href ="../assets/css/mycss.css" rel="stylesheet">
    <link href ="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../assets/css/formValidation.css"/>
    <link href="../assets/css/bootstrap-table.css" rel="stylesheet">

    
    <script type="text/javascript" src="../assets/js/jquery.js"></script>
    <script type ="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/myjs.js"></script>
    <script language="JavaScript" src="../assets/js/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
    <script type="text/javascript" src="../assets/js/formValidation.js"></script>
    <script type="text/javascript" src="../assets/js/framework/bootstrap.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap-table.js"></script>    
  
<?php
require_once ('../config.php');

require_once(FUNC_PATH . '/mainvals.php');
require_once(FUNC_PATH . '/connectdb.php');  
require_once(FUNC_PATH . '/readvals.php');  
require_once(FUNC_PATH . '/readcookie.php');
require_once(FUNC_PATH . '/checksession.php');                   

require_once (VSM_PATH . '/stemmerQ.php');
require_once (VSM_PATH . '/vsm_searching1.php');
require_once (VSM_PATH . '/vsm_test.php');


$q = $_GET['q'];
$id_document = $_GET['id'];
$i=1;

$hasil = test($q , $id_document);

?> 

<div class="container">
  <h4><i class="fa fa-angle-right"></i> Document: <?= $id_document ?> </h4>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Term</th>
        <th>TF</th>
        <th>DF</th>
        <th>iDF</th>
        <th>W</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT ds_term.term,ds_index.tf, ds_term.df, LOG10((SELECT COUNT(ds_document.id_document) FROM ds_document)/ds_term.df ) AS iidf         
                FROM ds_term, ds_index
                WHERE ds_index.id_document = '".$id_document."'
                AND ds_term.id_term = ds_index.id_term ";
        $result = mysql_query($query) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
            echo "No Result Found";
        }else{ 
            while ($row = mysql_fetch_assoc($result)) {?>
    <tr>
        <td><?= $i++ ?></td>
        <td><?= $row['term'] ?></td>
        <td><?= $row['tf'] ?></td>
        <td><?= $row['df'] ?></td>
        <td><?= round ($row['iidf'] , 4) ?></td>
        <td><?= round ($row['tf'] * $row['iidf'] , 4) ?></td>
    </tr>
    <?php } } ?>
    </tbody>
  </table>


<h3>Result</h3>
<table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Vektor Skalar</th>
        <th>Vektor Query</th>
        <th>Vektor Document</th>
        <th>Result</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?= $hasil['skalar']; ?></td>
        <td><?= $hasil['vektorQ']; ?></td>
        <td><?= $hasil['vektorDn']; ?></td>
        <td><?= $hasil['cossim']; ?></td>
      </tr>
    </tbody>
  </table>
</div>

<a href="testw.php?id=<?= $id_document; ?>">Weight Terms Graph</a>

<script type="text/javascript">
	
</script>
