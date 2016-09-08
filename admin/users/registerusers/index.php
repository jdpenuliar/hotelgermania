<?php
session_start();
include("../../php/DBConfigs.php");
if(empty($_SESSION['userID'])){
    header("location: ../login");
}
if(($_SESSION['userLevel'] != 1)){
    header("location: ../../../404.html");
}
if(isset($_POST['btnSignOut'])){
    session_destroy();
    header("location: ../../login");
}//signout
if(isset($_POST['btnAddUserx'])){
    $userID = $_POST['userID'];//license number
    $userName = $_POST['userName'];
    $userPassword = $_POST['userPassword'];
    $userReTypePassword = $_POST['userReTypePassword'];
    $userFirstName = $_POST['userFirstName'];
    $userLastName = $_POST['userLastName'];
    $userLevel = $_POST['userLevel'];
    $userAccountStatus = $_POST['userAccountStatus'];
    $classDBRelatedFunctions->functionUserSignup($userID, $userName, $userPassword, $userReTypePassword, $userLevel, $userAccountStatus, $userFirstName,$userLastName);
    header("location: ../");
}
if(isset($_POST['btnCancelAddUserx'])){

    header("location: ../../");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hotel Germania</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../../css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="../../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../../css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="../../css/iCheck/minimal/blue.css" rel="stylesheet" type="text/css" />

    <link href="../../vitalets-bootstrap-datepicker-c7af15b/css/datepicker.css" rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/png" href="http://www.hotelgermaniaphilippines.com/img/logo.png">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="../../js/dataController.js"></script>
</head>
<body onLoad="process(0,0);" class="skin-blue">

<!-- header logo: style can be found in header.less -->
<header class="header">

    <a href="../../" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        Hotel Germania
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span id="userFirstLastName"><?php
                            session_start();
                            echo $_SESSION['userFirstName']. " " . $_SESSION['userLastName'];
                            ?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="../../img/avatar3.png" class="img-circle" alt="User Image" />
                            <p id="userFirstLastNameDropDown">
                                <?php
                                    session_start();
                                    echo $_SESSION['userFirstName']. " " . $_SESSION['userLastName'];
                                ?>
                            </p>
                            <small id="userLevelDropDown" >
                                <?php
                                    session_start();
                                    if($_SESSION['userLevel'] == 1){
                                        echo "admin";
                                    }
                                ?>
                            </small>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <!--<div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>-->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?php
                                echo '<form action="../../profile" method="post">
                                                <input type="submit" name="btnEditProfile" value="Profile" class="btn btn-default btn-flat">
                                            </form>';

                                //<a href="./login" class="btn btn-default btn-flat" onclick="process(0,"signOut")">Sign out</a>
                                ?>
                            </div>
                            <div class="pull-right">
                                <?php
                                echo '<form action="./" method="post">
                                                <input type="submit" name="btnSignOut" value="Sign out" class="btn btn-default btn-flat">
                                            </form>';

                                //<a href="./login" class="btn btn-default btn-flat" onclick="process(0,"signOut")">Sign out</a>
                                ?>

                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="../../img/avatar3.png" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p id="userFirstLastNameLeft">
                        <?php
                            session_start();
                            echo $_SESSION['userFirstName']. " " . $_SESSION['userLastName'];
                        ?>
                    </p>
                    <a href="#"><i  class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- search form
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search..."/>
                    <span class="input-group-btn">
                        <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>-->
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li id="dashboardTab" >
                    <a href="../../" onclick="process(0,'dashboard');">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li id="roomTransactionsTab" class="">
                    <a href="../../" onclick="process(0,'roomTransactions');">
                        <i class="fa fa-th"></i> <span>Room Transactions Paypal</span>
                    </a>
                </li>
                <li id="commentsTab" class="">
                    <a href="../../comments" onclick="process(0,'comments');">
                        <i class="fa fa-envelope"></i> <span>Comments</span>
                    </a>
                </li>
                <?php
                if($_SESSION['userLevel'] == 1){
                    echo '
                            <li id="usersTab" class="active">
                                <a href="../" onclick="process(0,\'users\');">
                                    <i class="fa fa-users"></i> <span>Users</span>
                                </a>
                            </li>
                        ';

                }
                ?>
                <!--<li class="treeview">
                    <a href="#">
                        <i class="fa fa-bar-chart-o"></i>
                        <span>Charts</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>
                        <li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-laptop"></i>
                        <span>UI Elements</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/UI/general.html"><i class="fa fa-angle-double-right"></i> General</a></li>
                        <li><a href="pages/UI/icons.html"><i class="fa fa-angle-double-right"></i> Icons</a></li>
                        <li><a href="pages/UI/buttons.html"><i class="fa fa-angle-double-right"></i> Buttons</a></li>
                        <li><a href="pages/UI/sliders.html"><i class="fa fa-angle-double-right"></i> Sliders</a></li>
                        <li><a href="pages/UI/timeline.html"><i class="fa fa-angle-double-right"></i> Timeline</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>Forms</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/forms/general.html"><i class="fa fa-angle-double-right"></i> General Elements</a></li>
                        <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-double-right"></i> Advanced Elements</a></li>
                        <li><a href="pages/forms/editors.html"><i class="fa fa-angle-double-right"></i> Editors</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Tables</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/tables/simple.html"><i class="fa fa-angle-double-right"></i> Simple tables</a></li>
                        <li><a href="pages/tables/data.html"><i class="fa fa-angle-double-right"></i> Data tables</a></li>
                    </ul>
                </li>
                <li>
                    <a href="pages/calendar.html">
                        <i class="fa fa-calendar"></i> <span>Calendar</span>
                        <small class="badge pull-right bg-red">3</small>
                    </a>
                </li>
                <li>
                    <a href="pages/mailbox.html">
                        <i class="fa fa-envelope"></i> <span>Mailbox</span>
                        <small class="badge pull-right bg-yellow">12</small>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>Examples</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/examples/invoice.html"><i class="fa fa-angle-double-right"></i> Invoice</a></li>
                        <li><a href="pages/examples/login.html"><i class="fa fa-angle-double-right"></i> Login</a></li>
                        <li><a href="pages/examples/register.html"><i class="fa fa-angle-double-right"></i> Register</a></li>
                        <li><a href="pages/examples/lockscreen.html"><i class="fa fa-angle-double-right"></i> Lockscreen</a></li>
                        <li><a href="pages/examples/404.html"><i class="fa fa-angle-double-right"></i> 404 Error</a></li>
                        <li><a href="pages/examples/500.html"><i class="fa fa-angle-double-right"></i> 500 Error</a></li>
                        <li><a href="pages/examples/blank.html"><i class="fa fa-angle-double-right"></i> Blank Page</a></li>
                    </ul>
                </li>-->
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Register User
            </h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Register User</h3>
                        </div><!-- /.box-header -->
                        <?php

                        echo "<div class=\"box-body\">";

                            echo "<form action=\"./\" method=\"post\" role=\"form\">";
                                //userID
                                echo "<label>User ID:</label>";
                                echo "<input type=\"text\" class=\"form-control\" placeholder=\"User ID\" name=\"userID\"/ required>";
                                //userName
                                echo "<label>User Name:</label>";
                                echo "<input type=\"text\" class=\"form-control\" placeholder=\"User Name\" name=\"userName\"/ required>";
                                //userPassword for salting
                                echo "<label>Password:</label>";
                                echo "<input type=\"password\" class=\"form-control\" placeholder=\"User Password\" name=\"userPassword\"/ required>";
                                echo "<label>Re-type Password:</label>";
                                echo "<input type=\"password\" class=\"form-control\" placeholder=\"User Retype Password\" name=\"userReTypePassword\"/ required>";
                                //userFirst Middle Last Name
                                echo "<label>First Name:</label>";
                                echo "<input type=\"text\" class=\"form-control\" placeholder=\"First name\" name=\"userFirstName\"/ required>";
                                echo "<label>Last Name:</label>";
                                echo "<input type=\"text\" class=\"form-control\" placeholder=\"User LastName\" name=\"userLastName\" required/>";
                                //userLevel
                                echo "<label>User Level:</label>";
                                echo "<select class=\"form-control\" name=\"userLevel\" required>";
                                echo "<option value=\"\">Please Select</option>";
                                echo "<option value=\"2\">User</option>";
                                echo "<option value=\"1\">Admin</option>";
                                echo "</select>";
                                //userAccouintStatus
                                echo "<label>User Account Status:</label>";
                                echo "<select class=\"form-control\" name=\"userAccountStatus\" required>";
                                echo "<option value=\"\">Please Select</option>";
                                echo "<option value=\"1\">Active</option>";
                                echo "<option value=\"0\">Inactive</option>";
                                echo "</select>";
                                echo '<div class="btn-group">';
                                    echo '<table class="table text-center">';
                                        echo '<tr>';
                                            echo '<td>';
                                                echo "<input type=\"submit\" name=\"btnAddUserx\" value=\"Register User\" class=\"btn btn-default btn-flat\">";
                                            echo '<td>';
                                            echo "<td>";
                                                echo "<input type=\"submit\" name=\"btnCancelAddUserx\" value=\"Cancel\" class=\"btn btn-default btn-flat\">";
                                            echo "</td>";
                                        echo "</tr>";
                                    echo "</table>";
                                echo "</div>";

                            echo "</form>";
                        echo "</div>";
                        ?>
                    </div><!-- /.box -->
                </div>
            </div>

        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->



<!-- jQuery 2.0.2 -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="../../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="../../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../../js/AdminLTE/app.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../js/AdminLTE/demo.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="../../js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script src="../../vitalets-bootstrap-datepicker-c7af15b/js/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- page script -->
<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
<!-- iCheck -->
<script src="../../js/plugins//iCheck/icheck.min.js" type="text/javascript"></script>
<!-- Page script -->
<script type="text/javascript">
    $(function() {

        "use strict";

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });

        //When unchecking the checkbox
        $("#check-all").on('ifUnchecked', function(event) {
            //Uncheck all checkboxes
            $("input[type='checkbox']", ".table-mailbox").iCheck("uncheck");
        });
        //When checking the checkbox
        $("#check-all").on('ifChecked', function(event) {
            //Check all checkboxes
            $("input[type='checkbox']", ".table-mailbox").iCheck("check");
        });
        //Handle starring for glyphicon and font awesome
        $(".fa-star, .fa-star-o, .glyphicon-star, .glyphicon-star-empty").click(function(e) {
            e.preventDefault();
            //detect type
            var glyph = $(this).hasClass("glyphicon");
            var fa = $(this).hasClass("fa");

            //Switch states
            if (glyph) {
                $(this).toggleClass("glyphicon-star");
                $(this).toggleClass("glyphicon-star-empty");
            }

            if (fa) {
                $(this).toggleClass("fa-star");
                $(this).toggleClass("fa-star-o");
            }
        });

        //Initialize WYSIHTML5 - text editor
        $("#email_message").wysihtml5();
    });
</script>
<script>
    $(function(){
        window.prettyPrint && prettyPrint();
        $('#dp1').datepicker({
            format: 'mm-dd-yyyy',
            todayBtn: 'linked'
        });

        $('#dp2').datepicker();
        $('#btn2').click(function(e){
            e.stopPropagation();
            $('#dp2').datepicker('update', '03/17/12');
        });

        $('#dp3').datepicker();


        var startDate = new Date(2012,1,20);
        var endDate = new Date(2012,1,25);
        $('#dp4').datepicker()
            .on('changeDate', function(ev){
                if (ev.date.valueOf() > endDate.valueOf()){
                    $('#alert').show().find('strong').text('The start date can not be greater then the end date');
                } else {
                    $('#alert').hide();
                    startDate = new Date(ev.date);
                    $('#startDate').text($('#dp4').data('date'));
                }
                $('#dp4').datepicker('hide');
            });
        $('#dp5').datepicker()
            .on('changeDate', function(ev){
                if (ev.date.valueOf() < startDate.valueOf()){
                    $('#alert').show().find('strong').text('The end date can not be less then the start date');
                } else {
                    $('#alert').hide();
                    endDate = new Date(ev.date);
                    $('#endDate').text($('#dp5').data('date'));
                }
                $('#dp5').datepicker('hide');
            });

        //inline
        $('#dp6').datepicker({
            todayBtn: 'linked'
        });

        $('#btn6').click(function(){
            $('#dp6').datepicker('update', '15-05-1984');
        });

        $('#btn7').click(function(){
            $('#dp6').data('datepicker').date = null;
            $('#dp6').find('.active').removeClass('active');
        });
    });
</script>
</body>
</html>