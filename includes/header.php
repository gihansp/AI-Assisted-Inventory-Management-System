<?php require_once 'functions/session-check.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://bootswatch.com/3/yeti/bootstrap.css">
    <!-- Custom CSS -->
    <link href="sb-admin.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- File Input CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.2/css/fileinput.min.css">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    <!-- jQuery UI JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://bootswatch.com/3/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <!-- DataTables Buttons HTML5 Export JS -->
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
</head>

<body>


<div id="wrapper">

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">Phoenix Industries</a>
    </div>

    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li id="navDashboard"><a href="index.php"><i class="glyphicon glyphicon-dashboard"></i> Dashboard</a></li>
            <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                <li id="nav_cats"><a href="categories.php"><i class="glyphicon glyphicon-list-alt"></i> Categories</a></li>
            <?php } ?>
            <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                <li id="nav_prod"><a href="product.php"><i class="glyphicon glyphicon-shopping-cart"></i> Products</a></li>
            <?php } ?>
            <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                <li id="nav_prod"><a href="staff.php"><i class="glyphicon glyphicon-user"></i> Staff</a></li>
            <?php } ?>

            <li class="dropdown" id="nav_ord">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-shopping-cart"></i> Orders <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li id="top_nav_new_ord"><a href="orders.php?order=add"><i class="glyphicon glyphicon-plus"></i> Add Orders</a></li>
                    <li id="topNavManageOrder"><a href="orders.php?order=manage"><i class="glyphicon glyphicon-list"></i> Manage Orders</a></li>
                </ul>
            </li>

            <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                <li id="navReport"><a href="report.php"><i class="glyphicon glyphicon-stats"></i> Report</a></li>
            <?php } ?>
        </ul>

        <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown user-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> Admin <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                        <li><a href="setting.php"><i class="glyphicon glyphicon-cog"></i> Profile</a></li>
                    <?php } ?>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="glyphicon glyphicon-off"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>

</nav>


    <div class="container-fluid">

