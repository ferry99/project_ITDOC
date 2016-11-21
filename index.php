
    <link href ="assets/css/bootstrap.css" rel="stylesheet">
    <link href ="assets/css/visitor/search.css" rel="stylesheet">
    <link href ="assets/css/simple-sidebar.css" rel="stylesheet">
    <link href ="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/css/formValidation.css"/>
    
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type ="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/myjs.js"></script>
    <script language="JavaScript" src="assets/js/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
    <script type="text/javascript" src="assets/js/formValidation.js"></script>
    <script type="text/javascript" src="assets/js/framework/bootstrap.js"></script>



<body id="indexbd">


<?php 
require_once ('config.php');
require_once (FUNC_PATH . '/connectdb.php');
require_once ( TEMPLATE_PATH . '/visitor/header.php');
?>


<div class="container">

 <!-- Header -->
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-heading">IT-Document</div>
                <div class="intro-lead-in">Kumpulan Dokumen *.pdf bertopik Teknologi Informasi</div>
                <i>Searching Based on Information Retrieval</i>
            </div>
        </div>
    </header>

    <div id="center">
        <div class="row">
            <form id="togglingForm" method="get" action="search1.php" class="form-horizontal">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-btn search-panel">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                  <span id="search_concept">Category</span> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                  <?php getDir(); ?>
                                </ul>
                            </div>
                            <input type="hidden" name="search_param" value="1" id="search_param">         
                            <input type="text" class="form-control" name="q" required data-fv-notempty-message="The field is required" />                                       
                        </div>
                        <!-- <small><i>Note : For more spesific result please insert spesific word instead of common word<br>For ex:"Forward chaining , fuzzy" instead of "metode foward chaining"</i></small> -->
                        <br />
                         <button class="btn btn-xl" type="submit" class="btn">search</i></button>
                    </div>
                </div>
            </form>

            </div>
        </div>
    </div>

<?php 
require_once ( TEMPLATE_PATH . '/visitor/footer.php');

    function getDir() {      
        $sql = "SELECT * FROM ds_directory";
        $result = mysql_query($sql);
        $first = true;
        if (mysql_num_rows($result) == 0) {
          echo "<li><a href='#empty'></a></li>";
        }else{
          while($row = mysql_fetch_array($result)) {  
            echo "<li><a href=".'#'.$row['id_directory'].">".$row['name_directory']."</a></li>";
          }
        }
    
    }

?>

<script>
    $(document).ready(function(e){
        $('.search-panel .dropdown-menu').find('a').click(function(e) {
            e.preventDefault();
            var param = $(this).attr("href").replace("#","");
            var concept = $(this).text();
            $('.search-panel span#search_concept').text(concept);
            $('.input-group #search_param').val(param);
        });
    });
</script>