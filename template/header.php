<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $page_title; ?></title>

        <!-- some custom CSS -->
        <style>
            .left-margin{
                margin:0 .5em 0 0;
            }

            .right-button-margin{
                margin: 0 0 1em 0;
                overflow: hidden;
            }
        </style>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php FOLDER_CSS ?>/IMS/css/bootstrap.css">

        <!-- Custom styles for this template -->
        <link href="<?php FOLDER_CSS ?>/IMS/css/dashboard.css" rel="stylesheet">

        <!-- Css Icons -->
        <link href="<?php echo $global->wwwroot ?>css/simple-sidebar.css" rel="stylesheet">
        <link href="<?php FOLDER_CSS ?>/IMS/css/font-awesome.css" rel="stylesheet">

        <!-- Bootstrap core JavaScript
   ================================================== -->
        <script src="<?php FOLDER_JS ?>/IMS/js/ie-emulation-modes-warning.js"></script>
        <script src="<?php FOLDER_JS ?>/IMS/js/jquery.min.js"></script>
        <script src="<?php FOLDER_JS ?>/IMS/js/bootstrap.min.js"></script>
        <script src="<?php FOLDER_JS ?>/IMS/js/docs.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="<?php FOLDER_JS ?>/IMS/js/ie10-viewport-bug-workaround.js"></script>

        <!-- Calender JavaScript
        ================================================== -->
        <link rel="stylesheet" href="<?php FOLDER_CSS ?>/IMS/css/jquery-ui.css">
        <script src="<?php FOLDER_JS ?>/IMS/js/jquery-1.10.2.js"></script>
        <script src="<?php FOLDER_JS ?>/IMS/js/jquery-ui.js"></script>

        <!--================================================== -->
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand" style="font-size: 3em"><?php echo $companyName; ?></span>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>

                                    <?php
                                    if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                                        //echo 'Set and not empty, and no undefined index error!';
                                        
                                    }
                                    if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                                        $user = $users->userdata($_SESSION['id']);
                                        $username = $user['USERNAME'];
                                        $logAuth = $user['USER_LEVEL'];
                                        if($logAuth==1){
                                            echo "<a href='" . WWWROOT . "application/login/members.php'><i class='fa fa-user fa-fw'></i> User Profile</a>";
                                        }   
                                    } else {
                                        
                                    }
                                    ?>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <?php
                                    if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                                        echo "<a href='" . $global->wwwroot . "application/login/logout.php'><i class='fa fa-sign-out fa-fw'></i>Logout</a>";
                                    } else {
                                        if (empty($_SESSION['id'])) {
                                            echo "<a href='" . $global->wwwroot . "application/login/login.php'><i class='fa fa-sign-in fa-fw'></i>Login</a>";
                                            //header('Location:' . $global->wwwroot . 'application/login/login.php');
                                        }
                                    }
                                    ?>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <li>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <?php ?>
                <?php
                if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                    require_once(FOLDER_Template . 'slider.php');
                } else {
                    if (empty($_SESSION['id'])) {
                        
                    }
                }
                ?>


                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header"> <?php echo $page_title; ?> </h1> 
                    <div class="table-responsive">



