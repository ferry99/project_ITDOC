<?php
     if (isset($_POST['resetbtn'])){
        $sql = "ALTER TABLE ds_document AUTO_INCREMENT = 1";
        $result = mysql_query($sql);
        $sql = "ALTER TABLE ds_directory AUTO_INCREMENT = 1";
        $result = mysql_query($sql);
        $sql = "ALTER TABLE ds_index AUTO_INCREMENT = 1";
        $result = mysql_query($sql);
         $sql = "ALTER TABLE ds_term AUTO_INCREMENT = 1";
        $result = mysql_query($sql);
        echo "reset presssed";
     }
     else if(isset($_POST['changepwbtn'])){
        $userid = $_SESSION['userid'];
        $old_pw = $_POST['old_pw'];
        $new_pw = $_POST['new_pw'];


        $query = "SELECT * FROM ds_admin WHERE id_admin = '".$userid."' " ;
        $sql = mysql_query($query) or die(mysql_error());
        while ($rows = mysql_fetch_assoc($sql)) {
            $old_dbpw = $rows['password'];
        }

        if(md5($old_pw) == $old_dbpw){
            $query = "UPDATE ds_admin SET password = '".md5($new_pw)."' WHERE id_admin = '".$userid."' "; 
            $sql = mysql_query($query) or die(mysql_error()); 
            $notif = "<div class='alert alert-success alert-dismissable'>
                        <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                        Password has been changed
                        </div>";

        }else{
             $notif = "<div class='alert alert-danger alert-dismissable'>
                        <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                        Old password is wrong
                        </div>";
        }



     }



?>

<div class="container">

        <div class="manage row">

             <div class="col-lg-12">                    
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="index.php">Home</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-bar-edit-o"></i> Setting
                    </li>
                </ol>
            </div>                   
               
                
               

            <div class="col-md-9">

                <div class="row">
                        <div class="panel with-nav-tabs panel-info">
                            <div class="panel-heading">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab1default" data-toggle="tab">Change Password</a></li>
                                    <!-- <li><a href="#tab2default" data-toggle="tab">Database</a></li>
                                    <li><a href="#tab3default" data-toggle="tab">Default 3</a></li> -->
                                   <!--  <li class="dropdown">
                                        <a href="#" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#tab4default" data-toggle="tab">Default 4</a></li>
                                            <li><a href="#tab5default" data-toggle="tab">Default 5</a></li>
                                        </ul>
                                    </li> -->
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab1default">
                                        <?php 
                                        if (isset($notif)) {
                                            echo $notif;
                                        }
                                        ?>
                                        <div class="col-md-4">
                                            <form class="" id="changepwform" action="index.php?page=setting" method="POST">
                                                <div class="form-group">
                                                    <div class="input-group">Old password:
                                                        <input type="password" class="form-control" placeholder="" name="old_pw" >                                                    
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="input-group">New password
                                                        <input type="password" class="form-control" placeholder="" name="new_pw" >                                                    
                                                    </div>
                                                </div>  
                                                <div class="form-group">
                                                    <div class="input-group">Retype new password
                                                        <input type="password" class="form-control" placeholder="" name="new2_pw" >                                                    
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <button type ="submit" name="changepwbtn" id="changepwbtn" value = "upload" data-loading-text="<i class='fa fa-spinner fa-spin'></i>Loading..." class="btn btn-default">Change</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2default">
                                        <form class="" action="index.php?page=setting" method="post">
                                            <button class="btn btn-default" type="submit" name="resetbtn">Reset</button>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="tab3default">Default 3</div>
                                    <div class="tab-pane fade" id="tab4default">Default 4</div>
                                    <div class="tab-pane fade" id="tab5default">Default 5</div>
                                </div>
                            </div>
                        </div>
                </div>

            </div>
            <!-- /.col-md-9 -->
        </div>
        <!-- /.manage row -->
</div>
<!-- /.container -->


<script type="text/javascript">
    $('#changepwbtn').on('click', function() {
        var $this = $(this);
        $this.button('loading');       
    });



    $('#changepwform').formValidation({
    framework: 'bootstrap',
    fields: {
        new2_pw: {
            validators: {
                identical: {
                    field: 'new_pw',
                    message: 'The password and its confirm are not the same'
                }
            }
        }
    }
});
</script>
