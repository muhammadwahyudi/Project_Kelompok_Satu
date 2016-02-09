<?php
//include "auth.php";
$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
$control = filter_input(INPUT_SERVER, "BaseControl", FILTER_SANITIZE_URL);
$view = filter_input(INPUT_SERVER, "BaseView", FILTER_SANITIZE_URL);
require_once $root . 'model/database_model.php';
//include controler
include $control . 'admin.php';
//obj
$o_admin = new AdminControl();
if (isset($_POST['login'])) {
    $hasil = $o_admin->login_admin($_POST['username'], md5($_POST['password']));
}
session_start();
if (!empty($_SESSION['s_username'])&& $_SESSION['s_role']=="admin") {
    header('location:' . $view . 'index.php?home');
}elseif (!empty($_SESSION['s_username'])&& $_SESSION['s_role']=="super_admin") {
    header('location:' . $view . 'index_admin.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="images/lambang.png">

        <title><?php print $_SERVER['Title']; ?></title>

        <!-- Base Css Files -->
        <link href="css/bootstrap.min.css" rel="stylesheet" />

        <!-- Font Icons -->
        <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />
        <link href="css/material-design-iconic-font.min.css" rel="stylesheet">

        <!-- animate css -->
        <link href="css/animate.css" rel="stylesheet" />

        <!-- Waves-effect -->
        <link href="css/waves-effect.css" rel="stylesheet">

        <!-- Custom Files -->
        <link href="css/helper.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <!-- Plugins css -->
        <link href="assets/modal-effect/css/component.css" rel="stylesheet">
        <script src="js/modernizr.min.js"></script>

    </head>
    <body>


        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">
                <div class="panel-heading bg-img"> 
                    <div class=""></div>
                    <h3 class="text-center m-t-10 text-white"><img src="images/logo.png" style="height:40px"><strong>Login Sistem Pergudangan</strong> </h3>
                </div> 


                <div class="panel-body">
                    <?php
                    if (isset($_GET['error'])) {
                        ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Password </strong>dan <strong>Username </strong> anda salah atau status anda belum aktif, silahkan login kembali !
                        </div>
                    <?php } ?>
                    <?php
                    if (isset($_GET['succes'])) {
                        ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Password </strong>anda <strong>Sudah terkirim di email </strong>
                        </div>
                    <?php } ?>
                    <?php
                    if (isset($_GET['errorr'])) {
                        ?>
                        <div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Email </strong>anda <strong>Belum Terdaftar </strong>
                        </div>
                    <?php } ?>

                    <form class="form-horizontal m-t-20" id="loginForm" method="POST">

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input id="username" name="username" class="form-control input-lg " type="text" required="" placeholder="Username">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="password" name="password" class="form-control input-lg" type="password" required="" placeholder="Password">
                            </div>
                        </div>


                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-success btn-lg w-lg waves-effect waves-light" type="submit" name="login">Log In</button>
                            </div>
                        </div>

                        <div class="form-group m-t-30">
                             
                        </div>
                    </form> 
                </div>                                 

            </div>
        </div>


        <script>
                    var resizefunc = [];</script>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/waves.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="js/jquery.scrollTo.min.js"></script>
        <script src="assets/jquery-detectmobile/detect.js"></script>
        <script src="assets/fastclick/fastclick.js"></script>
        <script src="assets/jquery-slimscroll/jquery.slimscroll.js"></script>
        <script src="assets/jquery-blockui/jquery.blockUI.js"></script>

        <!-- Modal-Effect -->
        <script src="assets/modal-effect/js/classie.js"></script>
        <script src="assets/modal-effect/js/modalEffects.js"></script>
        <!-- CUSTOM JS -->
        <script src="js/jquery.app.js"></script>

        <!--form validation-->
        <script type="text/javascript" src="assets/jquery.validate/jquery.validate.min.js"></script>

        <!--form validation init-->
        <script src="assets/jquery.validate/form-validation-init.js"></script>
        <script type="text/javascript">
                    !function($) {
                    "use strict";
                            jQuery.validator.addMethod("noSpace", function(value, element) {
                            return value.indexOf(" ") < 0 && value != "";
                                    }, "Tidak Boleh Ada Spasi");
                            var FormValidator = function() {
                            this.$loginForm = $("#loginForm");
                            };
                            //init
                            FormValidator.prototype.init = function() {
                            //validator plugin
                            $.validator.setDefaults({
                            submitHandler: function() { window.location(""); }
                            });
                                    // validate signup form on keyup and submit
                                    this.$loginForm.validate({
                                    rules: {
                                    username: {
                                    required: true,
                                            minlength: 3,
                                            noSpace : true
                                    },
                                            password: {
                                            required: true,
                                                    minlength: 3
                                            }
                                    },
                                            messages: {
                                            username: "Isikan Username Anda",
                                                    password: "Isikan Password Anda",
                                                    username: {
                                                    required: "Isikan Username Anda",
                                                            minlength: "Username anda harus lebih dari 6"
                                                    },
                                                    password: {
                                                    required: "Isikan Password Anda",
                                                            minlength: "Password anda harus lebih dari 6"
                                                    }
                                            }
                                    });
                            },
                            //init
                            $.FormValidator = new FormValidator, $.FormValidator.Constructor = FormValidator
                    }(window.jQuery),
//initializing 
                    function($) {
                    "use strict";
                            $.FormValidator.init()
                    }(window.jQuery);
        </script>
    </body>
</html>