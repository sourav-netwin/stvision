<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
        <title><?php echo $title; ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo LTE; ?>bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo LTE; ?>dist/css/AdminLTE.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition">
        <div class="login-box">
            <div class="login-logo">
                <img style="margin-left: 68px" src="<?php echo base_url(); ?>img/logo-light.png" alt="plus-ed.com">
            </div>
            <!-- /.login-logo -->
            <div class="row" style="padding-top: 13%;">
                <div class="col-sm-6">
                    <a href="<?php echo base_url() . 'index.php/vauth/students' ?>" class="btn btn-primary">Student Login</a>
                </div>
                <div class="col-sm-6 text-center">
                    <a href="<?php echo base_url() . 'index.php/vauth/gl' ?>" class="btn btn-primary">GL Login</a>
                </div>
            </div>
        </div>
        <script src="<?php echo LTE; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
        <style>
            .btn{
                padding: 10px 25px;
            }
            body{
                background-image: url('../../img/splash-img.jpg');
                background-repeat: no-repeat;
                background-size: cover;
            }
            .login-logo{
                padding-top: 28%;
            }
        </style>
    </body>
</html>
