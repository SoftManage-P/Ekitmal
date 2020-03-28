
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Ektimal</title>
        <link rel="icon" href="{{ url('img/favicon.png')}}">

        <!-- <link rel="shortcut icon" href="assets/back/images/favicon.ico"> -->
        {{ Html::style('assets/back/plugins/datatables/dataTables.bootstrap4.min.css') }}
        {{ Html::style('assets/back/plugins/datatables/buttons.bootstrap4.min.css') }}
        <!-- Responsive datatable examples -->
        {{ Html::style('assets/back/plugins/datatables/responsive.bootstrap4.min.css') }}


        {{ Html::style('assets/back/plugins/morris/morris.css') }}
        {{ Html::style('assets/back/css/bootstrap.min.css') }}
        {{ Html::style('assets/back/css/metismenu.min.css') }}
        {{ Html::style('assets/back/css/icons.css') }}
        {{ Html::style('assets/back/css/style.css') }}
        <link href="{{ URL::asset('assets/back/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ URL::asset('assets/back/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('assets/back/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/back/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('assets/back/plugins/x-editable/css/bootstrap-editable.css')}}" rel="stylesheet">









        
        
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="{{url('home')}}" class="logo">
                        <span>
                            <img src="{{ url('img/logo.png')}}" alt="" height="50">
                        </span>
                        <i>
                            <img src="{{ url('img/logo.png')}}" alt="" height="22">
                        </i>
                    </a>
                </div>
      

                <nav class="navbar-custom">

                    <ul class="navbar-right d-flex list-inline float-right mb-0">
                       
                        <li class="dropdown notification-list">
                            <div class="dropdown notification-list nav-pro-img">
                                <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" style="margin:0px 15px;">
                                    <!-- <img src="{{url('uploads/images/user/img_avatar3.png')}}" alt="user" class="rounded-circle"> -->
                                    <span>{{Session::get('user')['user_name']}}</span> <b>
                                    @if(Session::get('user')['role'] == "superadmin") Super Admin @endif
                                    @if(Session::get('user')['role'] == "admin") Admin @endif
                                    @if(Session::get('user')['role'] == "manager") Manager @endif
                                    @if(Session::get('user')['role'] == "employee") Employee @endif</b>
                                    <i class="ion-ios7-arrow-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <!-- item-->
                                    @if(Session::get('user')['role'] == "superadmin") 
                                    <a class="dropdown-item" href="{{url('superadmin/myprofile')}}"><i class="mdi mdi-account-circle m-r-5"></i> Profile</a>
                                    @endif
                                    @if(Session::get('user')['role'] == "admin") 
                                    <a class="dropdown-item" href="{{url('admin/myprofile')}}"><i class="mdi mdi-account-circle m-r-5"></i> Profile</a>
                                    @endif
                                    <a class="dropdown-item text-danger" href="{{url('logout')}}"><i class="mdi mdi-power text-danger"></i> Logout</a>
                                </div>                                                                    
                            </div>
                        </li>

                    </ul>
                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left waves-effect">
                                <i class="mdi mdi-menu"></i>
                            </button>
                        </li>
                    </ul>

                   

                </nav>

            </div>
            <!-- Top Bar End -->

