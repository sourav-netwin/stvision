<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo LTE; ?>bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo LTE; ?>dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo LTE; ?>plugins/iCheck/square/blue.css">
        <link rel="stylesheet" href="<?php echo LTE; ?>custom/custom.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <!-- Your logos -->
            <!--    <a href="<?php //echo base_url();            ?>index.php/students"><img src="<?php //echo base_url();            ?>img/logo-light.png" alt="plus-ed.com"></a>-->
                <a href="<?php echo base_url(); ?>index.php/vauth/<?php echo ($page_action == 'glpost' ? 'gl' : 'students'); ?>"><img style="margin-left: 68px" src="<?php echo base_url(); ?>img/logo-light.png" alt="plus-ed.com"></a>
            <!--    <a class="phone-title" href="login.html"><img src="<?php //echo base_url();            ?>img/logo-mobile.png" alt="plus-ed.com" height="22" width="70" /></a>-->
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Welcome back!</p>
                <div class="row">
                    <?php
                    $success_message = $this->session->flashdata('success_message');
                    $error_message = $this->session->flashdata('error_message');
                    if (!empty($success_message)) {
                        ?>
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissable text-center">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $success_message ?>
                            </div>
                        </div>
                        <?php
                    }
                    if (!empty($error_message)) {
                        ?>
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissable text-center">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $error_message ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <form id="frmLogin" action="<?php echo base_url(); ?>index.php/vauth/<?php echo $page_action; ?>" method="post" >
                    <div class="form-group has-feedback">
                        <input tabindex=1 type="text" class="required noerror form-control gl_param" placeholder="Name" name="login_name" id="login_name" />
                    </div>
                    <div class="form-group has-feedback">
                        <input tabindex=1 type="text" class="required noerror form-control gl_param" placeholder="Surname" name="login_surname" id="login_surname" />
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <strong><i class="fa fa-calendar margin-r-5"></i> Date of birth</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <select id="selDay" name="selDay" class="form-control gl_param" >
                                <option value="">Day</option>
                                <?php
                                for ($day = 1; $day < 32; $day++) {
                                    ?><option value="<?php echo $day; ?>" ><?php echo str_pad($day, 2, '0', STR_PAD_LEFT); ?></option><?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select id="selMonth" name="selMonth" class="form-control gl_param">
                                <option value="">Month</option>
                                <?php
                                for ($month = 1; $month < 13; $month++) {
                                    ?><option value="<?php echo $month; ?>" ><?php echo str_pad($month, 2, '0', STR_PAD_LEFT); ?></option><?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select id="selYear" name="selYear" class="form-control gl_param">
                                <option value="">Year</option>
                                <?php
                                for ($year = 2010; $year > 1944; $year--) {
                                    ?><option value="<?php echo $year; ?>" ><?php echo $year; ?></option><?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label for="selDay" style="display:none;" generated="true" class="error"></label>
                            <label for="selMonth" style="display:none;" generated="true" class="error"></label>
                            <label for="selYear" style="display:none;" generated="true" class="error"></label>
                        </div>
                    </div>
                    <?php if ($page_action == 'glpost') { ?>
                        <div class="form-group has-feedback">
                            <select class="form-control required" name="booking_id" id="booking_id">
                                <option value="">Select booking ID</option>
                            </select>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="booking_id" value="1" />
                    <?php } ?>
                    <div class="row">
                        <div class="col-xs-8">
                            <!--          <div class="checkbox icheck">
                                        <label>
                                          <input type="checkbox"> Remember Me
                                        </label>
                                      </div>-->
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!--    <a href="#">I forgot my password</a><br>
                    <a href="register.html" class="text-center">Register a new membership</a>-->

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.3 -->
        <script src="<?php echo LTE; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo LTE; ?>bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
        <script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
        <style>
            .login-box, .register-box {
                margin: 4% auto;
            }
        </style>
        <script>
            $(function () {
                $("#frmLogin").validate({
                    //errorElement:"div",
                    ignore: "",
                    rules: {
                        login_name: {
                            required: true
                        },
                        login_surname: {
                            required: true
                        },
                        selDay: {
                            required: true
                        },
                        selMonth: {
                            required: true
                        },
                        selYear: {
                            required: true
                        },
                        booking_id: {
                            required: true
                        }
                    },
                    messages: {
                        login_name: "Please enter your name",
                        login_surname: "Please enter your surname",
                        selDay: "Please select day of your date of birth",
                        selMonth: "Please select month of your date of birth",
                        selYear: "Please select year of your date of birth",
                        booking_id: "Please select booking id"
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
<?php if ($page_action == 'glpost') { ?>
                    $('.gl_param').on('change', function () {
                        getBookingId();
                    });
<?php } ?>
            });
            function getBookingId() {
                var name = $('#login_name').val();
                var surname = $('#login_surname').val();
                var day = $('#selDay').val();
                var month = $('#selMonth').val();
                var year = $('#selYear').val();
                if (name == '' || surname == '' || day == '' || month == '' || year == '') {
                    return;
                }
                $.ajax({
                    type: 'post',
                    url: '<?php echo base_url() . 'index.php/vauth/getBookingForGl' ?>',
                    dataType: 'json',
                    data: {
                        name: name,
                        surname: surname,
                        day: day,
                        month: month,
                        year: year
                    },
                    success: function (data) {
                        if (data.success) {
                            var html = '';
                            if (data.bookings.length != 1) {
                                html = '<option value="">Select booking ID</option>';
                            }
                            $.each(data.bookings, function (key, value) {
                                html += '<option value="' + value.id_book + '">' + value.booking_id + '</option>';
                            });
                            $('#booking_id').html(html);
                        }
                    }
                });
            }
        </script>
    </body>
</html>
