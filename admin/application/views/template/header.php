<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="description" content="<?php echo $header['description'];?>">
  <meta name="keyword" content="<?php echo $header['keyword'];?>" />
  <meta name="author" content="<?php echo $header['author'];?>">
  <title>
    <?=$header['title'];?>
  </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url('theme');?>/datepicker/css/bootstrap-datepicker3.css">
  <link rel="stylesheet" href="<?php echo base_url('theme');?>/datepicker/css/bootstrap-timepicker.css">
  <link href="<?=base_url();?>css/fileinput.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/flat/blue.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/morris/morris.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dist/css/sweetalert2.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <style>
    .error {
      color: red;
      font-weight: normal;
    }
  </style>
  <!-- jQuery 2.1.4 -->
  <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
  <script type="text/javascript">
    var baseURL = "<?php echo base_url(); ?>";
  </script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition skin-blue sidebar-mini" ng-app="myApp" ng-controller="myCtrl">
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <a href="<?php echo base_url(); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>CB</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>xcitehitec</b></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo ucfirst($this->session->userdata('username')); ?></span>
                </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                  <p>
                    <?php echo ucfirst($this->session->userdata('username')); ?>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="text-center">
                    <a href="<?php echo base_url('signout');?>" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo ucfirst($this->session->userdata('username')); ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">MAIN NAVIGATION</li>
          <?php
            $parent_active = "0";
            foreach ($menus_list as $menu) {
              //find parentid
              if($menu['id'] == $menu_id){
                $parent_active = $menu['parent_id'];
              }
            }
          ?>
          <?php foreach ($menus_list as $menu): ?>
              <?php if ($menu['parent_id'] == "0"): ?>
                <li class="<?php if ($parent_active == $menu['id']){echo "active";} ?> treeview">
                  <a href="<?php echo base_url().$menu['link']; ?>">
                    <i class="<?php echo $menu['icon']; ?>"></i> <span><?php echo $menu['name']; ?></span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <?php foreach ($menus_list as $supmenu): ?>
                        <?php if ($supmenu['parent_id'] == $menu['id']): ?>
                          <li class="<?php if ($supmenu['id']== $menu_id) {echo "active";} ?>">
                            <a href="<?php echo base_url().$supmenu['link']; ?>">
                              <i class="<?php echo $supmenu['icon']; ?>"></i> <span><?php echo $supmenu['name']; ?></span>
                            </a>
                          </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                  </ul>
                </li>

              <?php endif; ?>
              <?php if ($menu['parent_id'] == "99"): ?>
                <li class="<?php if ($menu['id']== $menu_id) {echo "active";} ?>">
                  <a href="<?php echo base_url().$menu['link']; ?>">
                    <i class="<?php echo $menu['icon']; ?>"></i> <span><?php echo $menu['name']; ?></span>
                  </a>
                </li>
              <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
