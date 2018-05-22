<!DOCTYPE html>
<!--
This is a application header page
it will load all required resources
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="google" content="notranslate" />
  <title>
      <?php
        if(isset($title)){
            echo (!empty($title) ? $title : "plus-ed.com");
        }
        else
            echo "plus-ed.com"
        ?>
  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="description" content="<?php
        if(isset($title)){
            echo (!empty($title) ? $title : "plus-ed.com");
        }
        else
            echo "plus-ed.com"
        ?>">
  <meta name="author" content="plus-ed.com">
  <!-- iPhone: Don't render numbers as call links -->
  <meta name="format-detection" content="telephone=no">

  <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo LTE;?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo LTE;?>plugins/jQueryUI/jquery.ui.css">
  <link rel="stylesheet" href="<?php echo LTE; ?>plugins/select2/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo LTE;?>dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.cleditor.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?php echo LTE;?>plugins/sweetalert/sweetalert.css">
  <link rel="stylesheet" href="<?php echo LTE;?>plugins/fileinput/fileinput.min.css">
  <link rel="stylesheet" href="<?php echo LTE;?>dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="<?php echo LTE;?>plugins/animation/font-awesome-animation.min.css">
  <link rel="stylesheet" href="<?php echo LTE;?>plugins/pace/pace.min.css">
  <link rel="stylesheet" href="<?php echo LTE;?>custom/custom.css?v=1">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo LTE;?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo LTE;?>plugins/jQueryUI/jquery-ui.min.js"></script><!-- 1.12.0 -->
<script src="<?php echo LTE;?>plugins/browser/jquery.browser.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="<?php echo LTE;?>bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo LTE;?>dist/js/app.min.js"></script>

<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.cleditor.js"></script>

<!-- Bootstrap Datetimepicker -->
<!--<script src="<?php //echo LTE; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<link href="<?php //echo LTE; ?>plugins/datepicker/datepicker3.css" rel="stylesheet">
<link href="<?php //echo LTE; ?>plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
<script src="<?php //echo LTE; ?>plugins/timepicker/bootstrap-timepicker.js"></script>-->
<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.ui.datetimepicker.js"></script>
<script src="<?php echo LTE; ?>plugins/fileinput/fileinput.min.js"></script>
<script src="<?php echo LTE; ?>plugins/pace/pace.min.js"></script>

<script type="text/javascript">
var siteUrl = "<?php echo site_url(); ?>/";
var baseUrl = "<?php echo base_url(); ?>";
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">