<?php  
      include 'action.php';
      if (!isset($_SESSION['IS_LOGIN'])) {
         header("location: ../index.php?error=Please login to access dashboard!");
       } ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>eLEARNING | Dashboard</title>
    <link rel="icon" href="../assets/images/logo.jpeg" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="http://ianlunn.github.io/Hover/css/hover.css">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../assets/plugins/datatables/dataTables.bootstrap.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">

    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
    <script src="../assets/library/loader.js"></script>
    <script src="../assets/dist/js/sweetalert.min.js"></script>

</head>

<body class="hold-transition skin-yellow sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>L</b>MS</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Admin Panel</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel" style="height: 40px;">
                    <p style="text-align: center; color: #fff">Admin
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </p>
                </div>

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>


                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i> <span>User Management</span> <i
                                class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="active">
                                <a href="index.php?page=manage_students">
                                    <i class="fa fa-user-plus"></i> <span>Manage Students</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=manage_teachers">
                                    <i class="fa fa-user"></i> <span>Manage Teachers</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="index.php?page=course_registrations">
                            <i class="fa fa-user"></i> <span>Courses Registrations</span>
                        </a>
                    </li>

                    <li>
                        <a href="index.php?page=manage_courses">
                            <i class="fa fa-list"></i> <span>Manage Courses</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=assignCourse">
                            <i class="fa fa-list"></i> <span>Assign Course</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=manage_batches">
                            <i class="fa fa-list"></i> <span>Manage Batches</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=manage_schedules">
                            <i class="fa fa-calendar"></i> <span>Manage Schedules</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=make_announcement">
                            <i class="fa fa-bullhorn"></i> <span>Make Announcement</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=change_password">
                            <i class="fa fa-lock"></i> <span>Change Password</span>
                        </a>
                    </li>


                    <li>
                        <a href="../includes/logout.php">
                            <i class="fa fa-sign-out "></i> <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Dashboard
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->


            <!-- Main content -->
            <section class="content">

                <?php
                if (isset($_GET['page'])) {
                  $page = $_GET['page'];
                } else {
                  $page = "default";
                }
                
                Load_Page($page);
            ?>

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2025 <a href="index.php">eLEARNING</a>.</strong> All rights reserved.
        </footer>


    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/app.min.js"></script>
    <!-- Custom Scripts -->
    <script src="../assets/dist/js/Custom_Scripts.js"></script>
</body>

</html>