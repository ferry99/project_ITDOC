<?php
    if(isset($_GET['logout'])){
        session_destroy();
        header('Location: '.$config['urls']['baseUrl'].'/admin/login.php');
    }
?>


<header class="image-bg-fluid-height">
        <img class="img-responsive img-center" src="../assets/img/banner.jpg" width="1350px" height="200px" alt="">
</header>


<div class="container">
        <div class="row">
            <div class="col-lg-12">               
                    <h1 class="page-header">
                        Home <small>Overview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i>  <a href="index.html">Home</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-bar-chart-o"></i> Charts
                        </li>
                    </ol>
            </div>
        </div>


        <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-info-circle"></i>  <strong>Your Statistics</strong> 
                    </div>
                </div>
        </div>
        <!-- /.row -->

        <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <img src="../assets/img/folder2.png" width="50px" height="50px">
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php getCountDir(); ?></div>
                                    <div>Directory</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"></span>
                                <span class="pull-right"><i class="fa "></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <img src="../assets/img/pdf1.png" width="50px" height="50px">
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php getCountDoc(); ?></div>
                                    <div>Document</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <a href="index.php?page=manage_doc"><span class="pull-left">View Details</span></a>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
        </div>
        <!-- /.row -->



        <!-- Your Directory -->
        <div class="row">
            <div class="col-lg-12">
                <h2>Directory:</h2>
            </div>
            <div class="col-lg-6">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Folder Name</th>
                                <th>Document Files</th>
                                <th>Size</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                  $folder = getFolder();  
                                   while($row = mysql_fetch_array($folder)){                                                                                                         
                            ?>
                            <tr>
                                <td><img src="../assets/img/folder2.png" witdh="30px" height="40px"><?php echo $row['name_directory'] ?></td>
                                <td><?php echo $row['count'] ?></td>
                                <td><?php echo $row['size'].'kb' ?></td>
                                <td><a href= "index.php?page=manage"><button class="btn btn-xs btn-primary">View All</button></a></td>
                            </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
            </div>       
		</div>
</div>


<?php

     function getFolder()
     {
        $query = "SELECT ds_directory.*, COUNT(ds_document.id_document) as count
                    FROM ds_directory
                    LEFT JOIN ds_document
                    ON ds_directory.id_directory = ds_document.id_directory
                    GROUP BY ds_directory.id_directory";
        $result = mysql_query($query) or die(mysql_error());
        return $result;
     }


     function getCountDir(){
         $query = "SELECT COUNT(id_directory) FROM ds_directory";
         $result = mysql_query($query) or die(mysql_error());
         echo mysql_result($result, 0);
     }

     function getCountDoc(){
         $query = "SELECT COUNT(id_document) FROM ds_document";
         $result = mysql_query($query) or die(mysql_error());
         echo mysql_result($result, 0);
     }


    
?>