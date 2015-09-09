<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
            <?php echo Configure::read('Theme.owner_name'); ?>&nbsp;:&nbsp;<?php echo $title_for_layout; ?>
        </title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <?php echo $this->Html->css('/bootstrap/css/bootstrap.min'); ?> 
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <?php echo $this->Html->css('AdminLTE.min'); ?> 
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <?php echo $this->Html->css('skins/_all-skins.min'); ?> 
        <?php echo $this->fetch('css'); ?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="layout-top-nav skin-purple">
        <div class="wrapper">

            <?php echo $this->element('main-header'); ?> 
            <?php //echo $this->element('main-sidebar'); ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 233px;">
                <div class="container">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <?php echo $this->fetch('content_header'); ?> 
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <?php echo $this->fetch('content'); ?>
                    </section><!-- /.content -->
                </div><!-- /.content-wrapper -->
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Project</b> condogest.com
                </div>
                <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="http://phalkaline.eu">pHAlkaline</a>.</strong> All rights reserved.
            </footer>

            <?php //echo $this->element('control-sidebar'); ?>
        </div><!-- ./wrapper -->

        <!-- jQuery 2.1.4 -->
        <?php echo $this->Html->script('/plugins/jQuery/jQuery-2.1.4.min'); ?>
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.5 -->
        <?php echo $this->Html->script('/bootstrap/js/bootstrap.min'); ?>
        <!-- AdminLTE App -->
        <?php echo $this->Html->script('app.min'); ?>
        <?php echo $this->fetch('script'); ?>


    </body>
</html>
