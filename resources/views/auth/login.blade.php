
<!DOCTYPE html>
<html lang="en">

    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>Ektimal</title>
        <meta name="description" content="Login page example">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--begin::Fonts -->
       <!--  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500"> -->

        <!--end::Fonts -->

        <!--begin::Page Custom Styles(used by this page) -->
        <link href="assets/css/pages/login/login-2.css" rel="stylesheet" type="text/css" />

        <!--end::Page Custom Styles -->

        <!--begin:: Vendor Plugins -->
        <link href="assets/plugins/general/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/tether/dist/css/tether.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/owl.carousel/dist/assets/owl.carousel.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/owl.carousel/dist/assets/owl.theme.default.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/animate.css/animate.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/toastr/build/toastr.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/dual-listbox/dist/dual-listbox.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/morris.js/morris.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/sweetalert2/dist/sweetalert2.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/socicon/css/socicon.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/plugins/line-awesome/css/line-awesome.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/plugins/flaticon/flaticon.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/plugins/flaticon2/flaticon.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/general/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />

        <!--end:: Vendor Plugins -->
        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />

       
        <link rel="shortcut icon" href="img/favicon.png" />
        <style>
            .kt-login.kt-login--v2 .kt-login__wrapper .kt-login__container .kt-login__account .kt-login__account-msg {
                color: #0f0e0f;
            }
            .kt-link.kt-link--light {
                color: #0b0b0b;
            }
            .kt-link.kt-link--light:hover {
                color: #125ea2;
            }

            .help-block {
                color: red;
            }
        </style>
    </head>

    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">

        <!-- begin:: Page -->
        <div class="kt-grid kt-grid--ver kt-grid--root kt-page">
            <div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(assets/media/bg/bg-1.jpg);">
                    <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                        <div class="kt-login__container">
                            <div class="kt-login__logo">
                                <a href="{{url('home')}}">
                                    <img src="assets/media/logo.png">
                                </a>
                            </div>
                            <div class="kt-login__signin">
                                <div class="kt-login__head">
                                    <h3 class="kt-login__title">Sign In To Admin</h3>
                                </div>
                                
                                <form class="kt-form" action="{{ url('signin') }}" autocomplete="on" method="post" role="form" id="login_form">
                                    @if ($msg = Session::get('msg'))
                                    <div class="alert alert-warning" role="alert" id="notific">
                                        <strong>Warning! &nbsp;&nbsp;  </strong>  {{ $msg }}
                                    </div>
                                    @endif
                                    <div class="input-group">
                                        <select class="form-control" name = "user_role">
                                            <?php foreach ($userRole as $val) {
                                              ?>
                                              <option value="<?php echo $val->user_role?>" ><?php echo $val->name?></option>
                                              <?php
                                            }?>
                                            <!-- <option value="Super Admin">Super Admin</option>
                                            <option value="Admin">Admin</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Employee" selected>Employee</option> -->
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <input class="form-control" type="text" placeholder="UserName" name="user_name" autocomplete="off">
                                    </div>
                                    <div class="input-group">
                                        <input class="form-control" type="password" placeholder="Password" name="password">
                                    </div>
                                    <div class="row kt-login__extra">
                                        <div class="col">
                                            <label class="kt-checkbox">
                                                <input type="checkbox" name="remember"> Remember me
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col kt-align-right">
                                            <a href="javascript:;" id="kt_login_forgot" class="kt-link kt-login__link">Forget Password ?</a>
                                        </div>
                                    </div>
                                    <div class="kt-login__actions">
                                        <button type="submit" id="" class="btn btn-pill kt-login__btn-primary"> Sign In</button> 
                                    </div>
                                </form>
                            </div>
                            <div class="kt-login__signup">
                                <div class="kt-login__head">
                                    <h3 class="kt-login__title">Sign Up</h3>
                                    <div class="kt-login__desc">Enter your details to create your account:</div>
                                </div>
                                <form class="kt-login__form kt-form" action="{{ url('signup') }}" autocomplete="on" method="post" role="form" id="signup_form">
                                    @if (Session::get('signup_msg'))
                                    <div class="alert alert-warning" role="alert" id="notific">
                                        <strong>Warning! &nbsp;&nbsp;  </strong>  {{ Session::get('signup_msg') }}
                                    </div>
                                    @endif
                                    @if (Session::get('signup_success_msg'))
                                    <div class="alert alert-success" role="alert" id="notific">
                                        <strong>Success! &nbsp;&nbsp;  </strong>  {{ Session::get('signup_success_msg') }}
                                    </div>
                                    @endif
                                    <div class="input-group">
                                        <input class="form-control" type="text" placeholder="UserId" name="username" value="{!! old('username') !!}">
                                    </div>
                                   {!! $errors->first('username', '<span class="help-block">:message</span>') !!}
                                    <div class="input-group">
                                        <input class="form-control" type="text" placeholder="Fullname" name="fullname" value="{!! old('fullname') !!}">
                                    </div>
                                    {!! $errors->first('fullname', '<span class="help-block">:message</span>') !!}
                                    <div class="input-group">
                                        <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off" value="{!! old('email') !!}">
                                    </div>
                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                    <div class="input-group">
                                        <input class="form-control" type="password" placeholder="Password" name="password" value="{!! old('password') !!}">
                                    </div>
                                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                    <div class="input-group">
                                        <input class="form-control" type="password" placeholder="Confirm Password" name="rpassword">
                                    </div>
                                    {!! $errors->first('rpassword', '<span class="help-block">:message</span>') !!}
                                    <div class="row kt-login__extra">
                                        <div class="col kt-align-left">
                                            <label class="kt-checkbox">
                                                <input type="checkbox" name="agree">I Agree the <a href="#" class="kt-link kt-login__link kt-font-bold">terms and conditions</a>.
                                                <span></span>
                                            </label>
                                            <span class="form-text text-muted"></span>
                                        </div>
                                    </div>
                                    <div class="kt-login__actions">
                                        <button type = "submit" id="kt_login_signup_submit" class="btn btn-pill kt-login__btn-primary">Sign Up</button>&nbsp;&nbsp;
                                        <button id="kt_login_signup_cancel" class="btn btn-pill kt-login__btn-secondary">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <div class="kt-login__forgot">
                                <div class="kt-login__head">
                                    <h3 class="kt-login__title">Forgotten Password ?</h3>
                                    <div class="kt-login__desc">Enter your email to reset your password:</div>
                                </div>
                                <form class="kt-form" action="">
                                    <div class="input-group">
                                        <input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
                                    </div>
                                    <div class="kt-login__actions">
                                        <button id="kt_login_forgot_submit" class="btn btn-pill kt-login__btn-primary">Request</button>&nbsp;&nbsp;
                                        <button id="kt_login_forgot_cancel" class="btn btn-pill kt-login__btn-secondary">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <div class="kt-login__account pb-5">
                                <span class="kt-login__account-msg">
                                    Don't have an account yet ?
                                </span>&nbsp;&nbsp;
                                <a href="javascript:;" id="kt_login_signup" class="kt-link kt-link--light kt-login__account-link">Sign Up</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end:: Page -->

        <!-- begin::Global Config(global config for global JS sciprts) -->
        <script>
            var KTAppOptions = {
                "colors": {
                    "state": {
                        "brand": "#5d78ff",
                        "light": "#ffffff",
                        "dark": "#282a3c",
                        "primary": "#5867dd",
                        "success": "#34bfa3",
                        "info": "#36a3f7",
                        "warning": "#ffb822",
                        "danger": "#fd3995"
                    },
                    "base": {
                        "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                        "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
                    }
                }
            };
        </script>

        <!-- end::Global Config -->

        <!--begin::Global Theme Bundle(used by all pages) -->

        <!--begin:: Vendor Plugins -->
        <script src="assets/plugins/general/jquery/dist/jquery.js" type="text/javascript"></script>
        <script src="assets/plugins/general/sticky-js/dist/sticky.min.js" type="text/javascript"></script>
        <script src="assets/plugins/general/jquery-form/dist/jquery.form.min.js" type="text/javascript"></script>
        <!--end:: Vendor Plugins -->
        <script src="assets/js/scripts.bundle.js" type="text/javascript"></script>

        <!--begin:: Vendor Plugins for custom pages -->
        <script src="assets/plugins/custom/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>        
        <script src="assets/plugins/general/jquery-validation/dist/jquery.validate.js" type="text/javascript"></script>  
        <!--end:: Vendor Plugins for custom pages -->

        <!--end::Global Theme Bundle -->

        <!--begin::Page Scripts(used by this page) -->
        <script src="assets/js/pages/custom/login/login-general.js" type="text/javascript"></script>
        <!--end::Page Scripts -->
        <script type="text/javascript">
         setTimeout(function() {
            $("#notific").remove();
        }, 5000);
        if ({{count($errors)}} > 0){
            var login = $('#kt_login');
                login.removeClass('kt-login--forgot');
                login.removeClass('kt-login--signin');

                login.addClass('kt-login--signup');
        }
        var s='{{Session::get('signup_msg')}}';
        if(s!='') {
            var login = $('#kt_login');
                login.removeClass('kt-login--forgot');
                login.removeClass('kt-login--signin');

                login.addClass('kt-login--signup');
        } 
        var ss='{{Session::get('signup_success_msg')}}';
        if(ss!='') {
            var login = $('#kt_login');
                login.removeClass('kt-login--forgot');
                login.removeClass('kt-login--signin');

                login.addClass('kt-login--signup');
        }
        var e='{{Session::get('error_msg')}}';
            if(e !=''){
            Swal.fire(e);
        }
         </script>
    </body>

    <!-- end::Body -->
</html>