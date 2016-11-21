
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
    <script src="assets/js/jquery.simplePagination.js"></script>


<?php 
    require_once ('config.php');
    require_once (TEMPLATE_PATH . '/visitor/header.php');
    require_once (FUNC_PATH . '/mainvals.php');
    require_once (FUNC_PATH . '/connectdb.php');  
    require_once (FUNC_PATH . '/readvals.php');  
    require_once (FUNC_PATH . '/readcookie.php');
    ?>


    <div class="result container">
        <h3 class="page-header">
            All <small>Document</small>
        </h3>

         <div class="box row">
                <div class="col-md-9">
                    <div class = "target-content">

                    <?php 
                        $limit = 5;
                        if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
                        $start_from = ($page-1) * $limit; 

                        $query = "SELECT ds_document.* , ds_directory.name_directory 
                                        FROM ds_document ,ds_directory
                                            WHERE ds_document.id_directory=ds_directory.id_directory LIMIT $start_from, $limit" ;
                        $result = mysql_query($query) or die(mysql_error());
                        while ($row = mysql_fetch_assoc($result)) {
                    ?>
                            <div class="well">
                                <div class="media">
                                    <a class="pull-left" href="#">
                                        <img class="media-object" src="assets/img/pdf3.png" width="50" height="50">
                                    </a>
                                    <div class="media-body">
                                        <a href="#"><h4 class="media-heading"><?php echo $row['name_document']; ?></h4></a>
                                        <!-- <p class="text-right">By Francisco</p> -->
                                        <p><?php echo $row['desc']; ?></p>
                                        <ul class="list-inline list-unstyled">
                                            <li><span><i class="glyphicon glyphicon-calendar"></i><?php echo $row['date']; ?></span></li>
                                            <li>|</li>
                                            <span><i class="glyphicon glyphicon-file"></i><?php echo $row['name_directory']; ?></span>
                                            <li>|</li>
                                            <li>
                                                <?php echo "<a target='_blank' href= " .$row['path'].'/'.rawurlencode($row['name_directory']).'/'.$row['name_file']. ">Download / View</a>" ?>
                                            </li>
                                            <li>|</li>
                                        
                                        </ul>
                                    </div>
                                </div>
                            </div> 
                            <!-- /.well -->                      
                             <?php  
                                };  
                            ?>  
                    </div>

                <?php  
                        $sql = "SELECT COUNT(id_document) FROM ds_document";  
                        $rs_result = mysql_query($sql);  
                        $row = mysql_fetch_row($rs_result);  
                        $total_records = $row[0];  
                        $total_pages = ceil($total_records / $limit);  
                        $pagLink = "<ul class='pagination pull-right'>";  
                        for ($i=1; $i<=$total_pages; $i++) {  
                           $pagLink .= "<li><a href='ajax/browse_pagination.php?page=".$i."'>".$i."</a></li>";  
                       };  
                       echo $pagLink . "</ul>";  
                   ?>   
                 </div>
                 <!-- /.col-md-9 -->
         </div>
            <!-- /.box row -->
    </div>
        <!-- /.container -->



<script type="text/javascript">
$(document).ready(function(){
    $('.pagination').pagination({
        items: <?php echo $total_records;?>,
        itemsOnPage: <?php echo $limit;?>,
        cssStyle: 'light-theme',
        currentPage : 1,
        onPageClick : function(pageNumber) {
            $('.target-content').html('loading...');
            $('.target-content').load("ajax/browse_pagination.php?page=" + pageNumber);
        }
    });
});
</script>