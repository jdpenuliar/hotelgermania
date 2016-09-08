<?php
    session_start();
	require_once("../php/DBConfigs.php");
    if(isset($_SESSION['userID'])){
        header("location: ../");
    }//login button checcker
	if(isset($_POST['btnLogin'])){
		$xuname = $_POST['username'];
		$xpword = $_POST['password'];
		$classDBRelatedFunctions->functionUserAuthentication($xuname,$xpword);
        if(isset($_SESSION['userID'])){
            header("location: ../");
        }
	}//login button checcker
?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Hotel Germania</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
		<script type="text/javascript" src="../js/dataController.js"></script>
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Hotel Germania Admin</div>
            <form action="./" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="User ID" required/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required/>
                    </div>
                </div>
                <div class="footer">                                                               
                    <input type="submit" name="btnLogin" class="btn bg-olive btn-block" value="Sin in"/>
                </div>
            </form>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>