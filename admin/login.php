<?php 
	session_start();
	require_once ('../config.php');

	require_once (FUNC_PATH . '/mainvals.php');
	require_once (FUNC_PATH . '/connectdb.php');  
	require_once (FUNC_PATH . '/readvals.php');  
	require_once (FUNC_PATH . '/readcookie.php');  
	require_once (FUNC_PATH . '/subs.php'); 
	if(!isset($_SESSION['username'])){	
		echo $_SERVER['QUERY_STRING'];

?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Doc Sekker</title>

    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/mycss.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/formValidation.css"/>

	<script type="text/javascript" src="../assets/js/jquery.js"></script>
	<script type ="text/javascript" src="../assets/js/bootstrap.min.js"></script>
	<script type ="text/javascript" src="../assets/js/myjs.js"></script>
    <script type="text/javascript" src="../assets/js/formValidation.js"></script>
    <script type="text/javascript" src="../assets/js/framework/bootstrap.js"></script>		
    

</head>



<body class = "loginbd">
	<div class ="container">    
		
		<div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3"> 
			
			<div class ="row">                
				<div class ="iconmelon">
					<img src="../assets/img/logo2.png" width="130px" height="150px">
				</div>
			</div>
			
			<div class="panel panel-default" >
				<div class="panel-heading">
					<div class="panel-title text-center">Welcome Admin</div>
				</div>     

				<div class="panel-body" >

				<?php 
				if (isset($_POST['loginbtn'])) {
					$username = $_POST['username'];
					$password = $_POST['password'];
					$password = md5($password);

					if($username){
						if ($password) {
							$query = "SELECT * FROM ds_admin WHERE username = '$username'";
							$sql = mysql_query($query) or die(mysql_error());

							$numrows = mysql_num_rows($sql);
							if ($numrows == 1) {
								$row = mysql_fetch_assoc($sql);
								$dbusernme = $row['username'];
								$dbpass = $row['password'];
								if ($dbpass == $password) {
									$dbid = $row['id'];
									$_SESSION['userid'] = $dbid;
									$_SESSION['username'] = $dbusernme;
									header('Location: '.$config['urls']['baseUrl'].'/admin/index.php');
								}else{
									echo '<div class="alert alert-danger alert-dismissable">';
			                    	echo "<button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>";
			                    	echo "Wrong Password";
			                    	echo "</div>"; 
								}

							}else{
								echo '<div class="alert alert-danger alert-dismissable">';
		                    	echo "<button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>";
		                    	echo "Wrong Username";
		                    	echo "</div>"; 
							}


						}
					}else{
						echo '<div class="alert alert-danger alert-dismissable">';
                    	echo "<button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>";
                    	echo "NO USERNAME";
                    	echo "</div>";                    	
					}
				}
				?>
					<form name="form" action="./login.php" id="defaultForm" class="form-horizontal" enctype="multipart/form-data" method="POST">
						
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input id="user" type="text" class="form-control" name="username" value="" placeholder="Username">                                        
							</div>
						</div>
						
						<div class="form-group">
							<div class="input-group ">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input id="password" type="password" class="form-control" name="password" placeholder="Password">
							</div>    
						</div>                                                              

						<div class="form-group">
							<!-- Button -->
							<div class="col-sm-12 controls">
								<button type="submit" name="loginbtn" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-log-in"></i> Log in</button>                          
							</div>
						</div>

					</form>     

				</div>                     
			</div>  
		</div>
	</div>

<div id="particles"></div>

<?php }else header('Location: '.$config['urls']['baseUrl'].'/admin/index.php'); ?>


	<script type="text/javascript">
	$(document).ready(function() {
	    $('#defaultForm').formValidation({
        err: {
            container: 'tooltip'
        },
         row: {
        valid: ''
    	},
        icon: {
            valid: 'glyphicon',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'Username is required'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Password is required'
                    }                    
                }
            }
        }

	    });
	});
	</script>
</body>
